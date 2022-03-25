<?php

class Conta extends Controller
{
    public function index()
    {
        $this->view('conta/index');
    }

    public function entrar()
    {
        if($_POST){
            $dados = [
                'email' => $_POST['email'],
                'senha' => $_POST['senha']
            ];

            $user = new Usuario();
            $retorno = $user->entrar($dados);
            $this->view('conta/index', $retorno);
        }
        else{
            $this->view('conta/index');
        }

    }

    public function cadastre()
    {
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
        $this->view("conta/index", $retorno);
    }


}