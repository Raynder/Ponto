<?php

    class Controller {

        public function model($model) {
            require_once '../app/Models/' . $model . '.php';
            return new $model();
        }

        public function view($view, $dados = []) {
            $arquivo = '../app/Views/' . $view . '.php';
            if (file_exists($arquivo)) {
                require_once $arquivo;
            } else {
                die('View não encontrada');
            }
        }

        public function seLogin($view, $array = array()){
            if(isset($_SESSION['usuario']['id']) && !empty($_SESSION['usuario']['id'])){
                $this->view($view, $array);
                return true;
            }else{
                //redirecionar para pagina de login
                header('Location: '.URL.'sistema/index');
                // $this->view('conta/index');
                return false;
            }
        }
    }