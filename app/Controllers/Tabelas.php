<?php

class Tabelas extends Controller
{
    public function index()
    {
        $this->seLogin('tabelas/visualizar');
    }

    private function listarColunas()
    {
        return ['registros', 'justificativas'];
    }

    public function registros()
    {
        $model = new Folha();

        $dados = array(
            'linhas' => $model->listarColaboradores(),
            'colunas' => [['nome', 0, 1], ['email', 0, 1], ['data', 0, 2], ['entrada1', 0, 2], ['saida1', 0, 2], ['entrada2', 0, 2], ['saida2', 0, 2]],
            'listas' => $this->listarColunas(),
            'lista' => 'registros'
        );

        $this->seLogin('tabelas/visualizar', $dados);
    }

    public function justificativas()
    {
        $model = new Usuario();

        #pegar nome concatenado com : e id de cada escala do banco
        $aux = $model->listar('escalas');
        $listaDeEscalas = [];

        foreach ($aux as $escala) {
            $listaDeEscalas = array_merge($listaDeEscalas,  [$escala['id'] . ':' . $escala['nome']]);
        }

        $dados = array(
            'linhas' => $model->listar('usuariosJoin'),
            'colunas' => [['nome', 0, 3], ['usuario', 0, 3], ['senha', 0, 2], ['email', 0, 3], ['escala', $listaDeEscalas, 3]],
            'listas' => $this->listarColunas(),
            'lista' => 'justificativas'
        );

        #sql que recebe todos os usuario junto com o nome da escala
        $sql = "SELECT usuarios.id, usuarios.nome, usuarios.usuario, usuarios.senha, usuarios.email, escalas.nome as escala FROM usuarios INNER JOIN escalas ON usuarios.escala = escalas.id";

        $this->seLogin('sistema/controle', $dados);
    }

    public function visualizar(){
        $model = new Folha();
        
        $model->listarRegistros($_POST['valor']);
    }
    public function editar()
    {
        $model = new Usuario();

        $dados = $model->editar($_POST['table'], $_POST['valor']);
    }
}
