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

    public function alterarHorarioColaborador($linhaAtual, $dataAtual, $valor, $idUser)
    {
        $query = "SELECT * FROM folha WHERE id_usuario = " . $idUser . " AND data = '" . $dataAtual . "'";

        if ($result = $this->sql->select($query)) {
            //Se todos os horarios estiverem batidos, calcula o total de horas trabalhadas e registrar no banco
            if ($result[0]['entrada1'] != '0000-00-00 00:00:00' && $result[0]['saida1'] != '0000-00-00 00:00:00' && $result[0]['entrada2'] != '0000-00-00 00:00:00' && $result[0]['saida2'] != '0000-00-00 00:00:00') {
                //Calcular horario trabalhado
                $entrada1 = new DateTime($result[0]['entrada1']);
                $saida1 = new DateTime($result[0]['saida1']);
                $entrada2 = new DateTime($result[0]['entrada2']);
                $saida2 = new DateTime($result[0]['saida2']);

                $tempo_trabalhado = $saida1->diff($entrada1);
                $tempo_trabalhado2 = $saida2->diff($entrada2);

                // somar as diferenças
                $tempo_trabalhado = $tempo_trabalhado->format('%H:%I:%S');
                $tempo_trabalhado2 = $tempo_trabalhado2->format('%H:%I:%S');
                $tempo_trabalhado = explode(':', $tempo_trabalhado);
                $tempo_trabalhado2 = explode(':', $tempo_trabalhado2);
                $tempo_trabalhado = $tempo_trabalhado[0] * 3600 + $tempo_trabalhado[1] * 60 + $tempo_trabalhado[2];

                $tempo_trabalhado2 = $tempo_trabalhado2[0] * 3600 + $tempo_trabalhado2[1] * 60 + $tempo_trabalhado2[2];

                $tempo_trabalhado = gmdate('H:i:s', $tempo_trabalhado + $tempo_trabalhado2);
                $query = "UPDATE folha SET " . $linhaAtual . " = '" . $dataAtual . $valor . "', horas_trabalhadas = '" . $tempo_trabalhado . "' WHERE id_usuario = " . $idUser . " AND data = '" . $dataAtual . "'";

                if ($this->sql->update($query)) {
                    exit("resultadoJson" . json_encode(['status' => 'success', 'mensagem' => 'Horário alterado com sucesso!']));
                } else {
                    exit("resultadoJson" . json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
                }
            }
            //Se não, somente registrar o horario
            else {
                $query = "UPDATE folha SET " . $linhaAtual . " = '" . $dataAtual . $valor . "' WHERE id_usuario = " . $idUser . " AND data = '" . $dataAtual . "'";

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
