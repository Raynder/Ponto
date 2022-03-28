<?php

class Conta extends Controller
{
    public function index()
    {
        $this->view('sistema/index');
    }

    public function entrar(){
        if($_POST){

            $user = new Usuario();
            $retorno = $user->entrar($_POST['dados'], $_POST['table']);
            $this->view('sistema/index', $retorno);
        }
        else{
            $this->view('sistema/index');
        }

    }

    public function cadastre(){
        if($_POST) {
            $dados = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha'],
                'confirmarSenha' => $_POST['confirmarSenha'],
                'cnpj' => $_POST['cnpj']
            ];

            $user = new Usuario();
            $retorno = $user->cadastrar($dados);
            $this->view('conta/cadastre', $retorno);
        }
        else{
            $this->view('conta/cadastre');
        }

    }

    public function sair(){
        $user = new Usuario();
        $retorno = $user->sair();

        $dados = array(
            'menus' => ['empregador', 'colaborador', 'registro'],
            'ativo' => 'registro',
            'funcao' => 'registrar'
        );
        $this->view("sistema/index", $dados);
    }


}