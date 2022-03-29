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

    }