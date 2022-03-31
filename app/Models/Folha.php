<?php

    class Folha{

        private $sql;

        public function __construct(){ // 
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $this->sql = new Database();
        }

        public function listarColaboradores(){
            $query = "SELECT * FROM usuarios WHERE tipo = 1";

            if($resul = $this->sql->select($query)){
                return $resul;
            }
            else{
                return false;
            }
        }

        public function listarRegistros($id){
            $query = "SELECT * FROM folha WHERE id_usuario = :id_usuario";

            if($result = $this->sql->select($query, array(':id_usuario' => $id))){
                exit("resultadoJson".json_encode($result));
            }
            else{
                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
            }
        }

        public function alterarHorarioColaborador($linhaAtual, $dataAtual, $valor, $idUser){
            $query = "SELECT saida2 FROM folha WHERE id_usuario = ".$idUser." AND data = '".$dataAtual."'";
            
            $query = "UPDATE folha SET ".$linhaAtual." = '".$dataAtual.$valor."' WHERE id_usuario = ".$idUser." AND data = '".$dataAtual."'";

            if($this->sql->update($query)){
                exit("resultadoJson".json_encode(['status' => 'success', 'mensagem' => 'Horário alterado com sucesso!']));
            }
            else{
                exit("resultadoJson".json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar editar campo!']));
            }
        }

    }