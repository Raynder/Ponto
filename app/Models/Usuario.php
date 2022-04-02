<?php

    class Usuario{

        private $sql;

        public function __construct(){ // 
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $this->sql = new Database();
        }

        public function entrar($dados, $table){
            // exit(print_r($dados));
            switch($table){
                case 'colaborador':
                    $query = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha AND tipo = 1";
                    break;
                case 'empregador':
                    $query = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha AND tipo = 2";
                    break;
            }

            $array = array(
                ':usuario' => $dados['usuario'],
                ':senha' => $dados['senha']
            );
            $resul = $this->sql->select($query, $array);
            if(count($resul) > 0){
                $_SESSION['usuario']['id'] = $resul[0]['id'];
                $_SESSION['usuario']['nome'] = $resul[0]['nome'];
                $_SESSION['usuario']['usuario'] = $resul[0]['usuario'];
                $_SESSION['usuario']['tipo'] = $resul[0]['tipo'];
                $_SESSION['usuario']['home'] = $table;
                
                exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Usuário logado com sucesso!', 'redirecionar' => 'controle/'.$table]));
            }
            else{
                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Usuário ou senha incorretos!', 'redirecionar' => 'sistema/entrar']));
            }
        }

        public function sair(){
            session_destroy();
            return ['status' => 'info', 'msg' => 'Usuário deslogado com sucesso!'];
        }

        public function listar($tabela){
            if($tabela == 'usuariosJoin'){
                $query = "SELECT usuarios.id, usuarios.nome, usuarios.usuario, usuarios.senha, usuarios.email, escalas.nome as escala FROM usuarios INNER JOIN escalas ON usuarios.escala = escalas.id";
            }
            else{
                $query = "SELECT * FROM $tabela";
            }
            $resul = $this->sql->select($query);
            return $resul;
        }

        public function registrar($usuario, $senha){
            $semana = array('domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado');
            
            $dia_semana = $semana[date('w')];
            // Buscar id do usuário
            $query = "SELECT usuarios.id, escalas.$dia_semana as meta FROM usuarios INNER JOIN escalas ON usuarios.escala = escalas.id WHERE usuario = :usuario AND senha = :senha";
            $array = array(
                ':usuario' => $usuario,
                ':senha' => $senha
            );
            $resul = $this->sql->select($query, $array);
            if(count($resul) > 0){
                $meta = $resul[0]['meta'];
                $id_usuario = $resul[0]['id'];
                $agora = date('Y-m-d H:i:s');
                $hoje = date('Y-m-d');
                $query = "SELECT * FROM folha WHERE id_usuario = :id_usuario AND data = :data";
                $array = array(
                    ':id_usuario' => $id_usuario,
                    ':data' => $hoje
                );
                $resul = $this->sql->select($query, $array);
                if(count($resul) > 0){
                    //transformar meta em horas
                    $meta = $meta * 60 * 60;
                    // verificar se entrada1, saida1, entrada2, saida2 foram preenchidos

                    $batidas = array(
                        'entrada1' => $resul[0]['entrada1'],
                        'saida1' => $resul[0]['saida1'],
                        'entrada2' => $resul[0]['entrada2'],
                        'saida2' => $resul[0]['saida2']
                    );

                    //encontrar primeira batida vazia e salvar o horario de agora
                    foreach($batidas as $key => $value){
                        if(($key == 'saida1' || $key == 'saida2') && $value == '0000-00-00 00:00:00'){
                            //calcular tempo trabalhado
                            //converter valores em datatime
                            $entrada1 = new DateTime($batidas['entrada1']);
                            $saida1 = new DateTime($batidas['saida1']);
                            $entrada2 = new DateTime($batidas['entrada2']);
                            $saida2 = new DateTime($batidas['saida2']);

                            if($key == 'saida1'){
                                $saida1 = new DateTime($agora);
                            }
                            else{
                                $saida2 = new DateTime($agora);
                            }
                            //calcular diferença de de turnos
                            $tempo_trabalhado = $saida1->diff($entrada1);
                            $tempo_trabalhado2 = $saida2->diff($entrada2);

                            // somar as diferenças
                            $tempo_trabalhado = $tempo_trabalhado->format('%H:%I:%S');
                            $tempo_trabalhado2 = $tempo_trabalhado2->format('%H:%I:%S');
                            $tempo_trabalhado = explode(':', $tempo_trabalhado);
                            $tempo_trabalhado2 = explode(':', $tempo_trabalhado2);
                            $tempo_trabalhado = $tempo_trabalhado[0] * 3600 + $tempo_trabalhado[1] * 60 + $tempo_trabalhado[2];

                            $tempo_trabalhado2 = $tempo_trabalhado2[0] * 3600 + $tempo_trabalhado2[1] * 60 + $tempo_trabalhado2[2];
                            if($key == 'saida2'){
                                $tempo_trabalhado = $tempo_trabalhado + $tempo_trabalhado2;
                            }
                            $tempo = $tempo_trabalhado;

                            
                            //transformar tempo_trabalhado em horas e minutos
                            $tempo_trabalhado = gmdate("H:i:s", $tempo_trabalhado);
                            if($meta > $tempo){
                                $saldo = $meta - $tempo;
                                $saldo = '-'.gmdate("H:i:s", $saldo);
                            }
                            else{
                                $saldo = $tempo - $meta;
                                $saldo = gmdate("H:i:s", $saldo);
                            }
                            echo($saldo);
                            

                            $query = "UPDATE folha SET $key = :$key, tempo_trabalhado = :tempo_trabalhado, saldo = :saldo WHERE id_usuario = :id_usuario AND data = :data";
                            $array = array(
                                ':'.$key => $agora,
                                ':tempo_trabalhado' => $tempo_trabalhado,
                                ':id_usuario' => $id_usuario,
                                ':data' => $hoje,
                                ':saldo' => $saldo
                            );

                            $resul = $this->sql->update($query, $array);
                            if($resul){
                                exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Ponto registrada com sucesso!', 'redirecionar' => 'sistema/home']));
                            }
                            else{
                                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao registrar ponto!', 'redirecionar' => 'sistema/home']));
                            }
                        }
                        else{
                            //pegar o dia da semana
                            if($key == 'saida2'){
                                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Você ja registrou todos os horarios de hoje!', 'redirecionar' => 'sistema/home']));
                            }
                            if($value == '0000-00-00 00:00:00'){
                                $query = "UPDATE folha SET $key = :agora WHERE id_usuario = :id_usuario AND data = :data";
                                $array = array(
                                    ':agora' => $agora,
                                    ':id_usuario' => $id_usuario,
                                    ':data' => $hoje
                                );
                                if($this->sql->update($query, $array)){
                                    exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Ponto registradado com sucesso!', 'redirecionar' => 'sistema/registrar']));
                                }
                                else{
                                    exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao registrar ponto!', 'redirecionar' => 'sistema/registrar']));
                                }
                            }
                        }
                    }

                }
                else{
                    $query = "INSERT INTO folha (id_usuario, entrada1, data) VALUES (:id_usuario, :agora, :data)";
                    $array = array(
                        ':id_usuario' => $id_usuario,
                        ':agora' => $agora,
                        ':data' => $hoje
                    );
                    if($this->sql->insere($query, $array)){
                        exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Ponto registradado com sucesso!', 'redirecionar' => 'sistema/registrar']));
                    }
                    else{
                        exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao registrar ponto!', 'redirecionar' => 'sistema/registrar']));
                    }
                }
            }

        }

        public function cadastrar($table, $dados){
            $query = "INSERT INTO $table (";
            $campos = "";
            $valores = "";

            foreach($dados as $key => $value){
                $campos .= $key.", ";
                $valores .= ":".$key.", ";
            }

            $campos = substr($campos, 0, -2);
            $valores = substr($valores, 0, -2);
            
            $query .= $campos.") VALUES (".$valores.")";

            if($this->sql->insere($query, $dados)){
                exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Registro salvo com sucesso!']));
            }
            else{
                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao salvar registro!']));
            }
        }

        public function deletar($table, $id){
            $sql = new Database();
            $query = "DELETE FROM $table WHERE id = :id";
            $array = array(
                ':id' => $id
            );

            if($sql->delete($query, $array)){
                exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Campo excluído com sucesso!']));
            }
            else{
                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao excluir campo!']));
            }
        }

        public function editar($table, $id){
            $sql = new Database();
            $query = "SELECT * FROM $table WHERE id = :id";

            $array = array(
                ':id' => $id
            );

            if($result = $sql->select($query, $array)){
                exit("resultadoJson".json_encode($result));
            }
            else{
                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
            }

        }

        public function atualizar($table, $dados){
            $sql = new Database();
            $query = "UPDATE $table SET ";
            $campos = "";
            $valores = "";
            $array = array();

            foreach($dados as $key => $value){
                $query .= $key." = :".$key.", ";
                $array[":".$key] = $value;
            }

            $query = substr($query, 0, -2);
            $query .= " WHERE id = :id";

            if($sql->update($query, $array)){
                exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Registro atualizado com sucesso!']));
            }
            else{
                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao atualizar registro!']));
            }
            
        }
    }