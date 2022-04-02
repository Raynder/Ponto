<?php

class Folha
{

    private $sql;

    public function __construct()
    { // 
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $this->sql = new Database();
    }

    public function listarColaboradores()
    {
        $query = "SELECT * FROM usuarios WHERE tipo = 1";

        if ($resul = $this->sql->select($query)) {
            return $resul;
        } else {
            return false;
        }
    }

    public function listarRegistros($id)
    {
        $query = "SELECT * FROM folha WHERE id_usuario = :id_usuario";

        if ($result = $this->sql->select($query, array(':id_usuario' => $id))) {
            exit("resultadoJson" . json_encode($result));
        } else {
            exit("resultadoJson" . json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
        }
    }

    public function alterarHorarioColaborador($linhaAtual, $dataAtual, $valor, $idUser, $observacao)
    {
        $semana = array('domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado');

        $dia_semana = $semana[date('w')];

        $query = "SELECT folha.*, usuarios.id, escalas.".$dia_semana." as meta FROM usuarios INNER JOIN escalas ON usuarios.escala = escalas.id INNER JOIN folha ON folha.id_usuario = usuarios.id WHERE usuarios.id = :id_usuario AND folha.data = :data";
        $array = array(':id_usuario' => $idUser, ':data' => $dataAtual);

        if ($result = $this->sql->select($query, $array)) {
            //Se todos os horarios estiverem batidos, calcula o total de horas trabalhadas e registrar no banco
            if ($result[0]['entrada1'] != '0000-00-00 00:00:00' && $result[0]['saida1'] != '0000-00-00 00:00:00' && $result[0]['entrada2'] != '0000-00-00 00:00:00' && $result[0]['saida2'] != '0000-00-00 00:00:00') {
                //Transformar meta em tempo
                $meta = $result[0]['meta'];
                $meta = $meta * 60 * 60;
                //Calcular horario trabalhado

                $batidas = array(
                    'entrada1' => new DateTime($result[0]['entrada1']),
                    'saida1' => new DateTime($result[0]['saida1']),
                    'entrada2' => new DateTime($result[0]['entrada2']),
                    'saida2' => new DateTime($result[0]['saida2']),
                );

                $batidas[$linhaAtual] = new DateTime($dataAtual.$valor);
                
                $tempo_trabalhado = $batidas['saida1']->diff($batidas['entrada1']);
                $tempo_trabalhado2 = $batidas['saida2']->diff($batidas['entrada2']);

                // somar as diferenças
                $tempo_trabalhado = $tempo_trabalhado->format('%H:%I:%S');
                $tempo_trabalhado2 = $tempo_trabalhado2->format('%H:%I:%S');
                $tempo_trabalhado = explode(':', $tempo_trabalhado);
                $tempo_trabalhado2 = explode(':', $tempo_trabalhado2);
                $tempo_trabalhado = $tempo_trabalhado[0] * 3600 + $tempo_trabalhado[1] * 60 + $tempo_trabalhado[2];

                $tempo_trabalhado2 = $tempo_trabalhado2[0] * 3600 + $tempo_trabalhado2[1] * 60 + $tempo_trabalhado2[2];

                $tempo = $tempo_trabalhado + $tempo_trabalhado2;
                $tempo_trabalhado = gmdate('H:i:s', $tempo);
                
                if($meta > $tempo){
                    $saldo = $meta - $tempo;
                    $saldo = '-'.gmdate("H:i:s", $saldo);
                }
                else{
                    $saldo = $tempo - $meta;
                    $saldo = gmdate("H:i:s", $saldo);
                }
                // print_r($saldo);
                // exit(print_r($tempo_trabalhado));
                
                $query = "UPDATE folha SET " . $linhaAtual . " = '" . $dataAtual . $valor . "', tempo_trabalhado = '" . $tempo_trabalhado . "', saldo = '" . $saldo . "', observacao = '" . $observacao . "' WHERE id_usuario = " . $idUser . " AND data = '" . $dataAtual . "'";

                if ($this->sql->update($query)) {
                    exit("resultadoJson" . json_encode(['status' => 'success', 'mensagem' => 'Horário alterado com sucesso!']));
                } else {
                    exit("resultadoJson" . json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
                }
            }
            //Se não, somente registrar o horario
            else {
                $query = "UPDATE folha SET " . $linhaAtual . " = '" . $dataAtual . $valor . "', observacao = '" . $observacao . "' WHERE id_usuario = " . $idUser . " AND data = '" . $dataAtual . "'";

                if ($this->sql->update($query)) {
                    exit("resultadoJson" . json_encode(['status' => 'success', 'mensagem' => 'Horário alterado com sucesso!']));
                } else {
                    exit("resultadoJson" . json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
                }
            }
        } else {
            exit("resultadoJson" . json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
        }
    }
}
