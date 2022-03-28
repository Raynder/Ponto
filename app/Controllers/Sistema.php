<?php

    class Sistema extends Controller {

        public function index() {
            $dados = array(
                'menus' => ['empregador', 'colaborador', 'registro'],
                'ativo' => 'registro',
                'funcao' => 'registrar'
            );

            $this->view('sistema/index', $dados);
        }

        public function registro() {
            $dados = array(
                'menus' => ['empregador', 'colaborador', 'registro'],
                'ativo' => 'registro',
                'funcao' => 'registrar'
            );

            $this->view('sistema/index', $dados);
        }

        public function colaborador() {
            $dados = array(
                'menus' => ['empregador', 'colaborador', 'registro'],
                'ativo' => 'colaborador',
                'funcao' => 'entrar'
            );

            $this->view('sistema/index', $dados);
        }

        public function empregador() {
            $dados = array(
                'menus' => ['empregador', 'colaborador', 'registro'],
                'ativo' => 'empregador',
                'funcao' => 'entrar'
            );

            $this->view('sistema/index', $dados);
        }

    }