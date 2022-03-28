<?php

    class Usuario{

        private $sql;

        public function __construct(){ // 
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $this->sql = new Database();
        }

        public function entrar($dados, $table){
            switch($table){
                case 'colaborador':
                    $query = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha AND tipo = 1 or tipo = 3";
                    break;
                case 'empregador':
                    $query = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha AND tipo = 2 or tipo = 3";
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