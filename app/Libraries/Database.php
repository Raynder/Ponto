<?php

    Class Database {

        private $conn;

        public function __construct(){
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $meses = ['janeiro', 'fevereiro','marco', 'abriu','maio', 'junho','julho', 'agosto','setembro', 'outubro','novembro', 'dezembro'];
            $mes = strftime('%m');
            $ano = strftime('%Y');

            $valor = $mes - 1;
             
            $db = 'ponto'; 
            $host = "localhost";
            $user = "root";
            $pass = "";

            $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        }

        public function insere($query, $array = array()){
            $sql = $this->conn->prepare($query);
            $this->setParams($array, $sql);
            if($sql->execute()){
                return true;
            }
        }

        public function select($query, $array = array()){
            $sql = $this->conn->prepare($query);
            $this->setParams($array, $sql);
            $sql->execute();
            $res = $sql->fetchALL(PDO::FETCH_ASSOC);
            return $res;
        }

        public function delete($query, $array = array()){
            $sql = $this->conn->prepare($query);
            $this->setParams($array, $sql);
            if($sql->execute()){
                return true;
            }
        }

        public function selectAnd($class, $array = array(), $infos =array()) {
            $cont = 0;
            $array2 = array();

            $query = "SELECT ";

            if(count($infos) > 1){
                for($i=0; $i < count($infos); $i++){
                    $query .= $infos[$i].",";
                }
                $query = substr($query, 0, -1);
            }
            else{
                $query .= "*";
            }

            $query .= " FROM $class ";
            $query .= count($array) > 0 ? "WHERE " : "";
            foreach($array as $key => $value){
                $query .= $key." = ".$this->lista[$cont]." AND ";
                $array2[$this->lista[$cont]] = $value;
                $cont++;
            }
            $query = $this->str_lreplace(" AND ", ";", $query);

            $dados = $this->query($query, $array2)->fetchAll(PDO::FETCH_ASSOC);
            if(count($dados) > 1){
                //Caso retorne mais de um objeto
                return $dados;
            }
            return $this->query($query, $array2)->fetch(PDO::FETCH_ASSOC);
        }

        public function update($query, $array = array()){
            $sql = $this->conn->prepare($query);
            $this->setParams($array, $sql);
            if($sql->execute()){
                return true;
            }
        }

        public function setParams($array = array(), $sql){

            foreach($array as $key => $value){
                $this->setParam($key, $value, $sql);
            }
        }

        public function setParam($key, $value, $sql){
            $sql->bindParam($key, $value);
        }

        public function multi_query($query){
            $sql = $this->conn->prepare($query);
            $sql->execute();
        }

        function str_lreplace($search, $replace, $subject)
        {
            $pos = strrpos($subject, $search);
        
            if($pos !== false)
            {
                $subject = substr_replace($subject, $replace, $pos, strlen($search));
            }
        
            return $subject;
        }

        function gerar_senha(){
            $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
            $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
            $nu = "0123456789"; // $nu contem os números
            $si = "!@#$%¨&*()_+="; // $si contem os símbolos
            $senha = '';
            
            $senha .= str_shuffle($ma);
            $senha .= str_shuffle($mi);
            $senha .= str_shuffle($nu);
            $senha .= str_shuffle($si);
            return substr(str_shuffle($senha),0,8);
        }
    }