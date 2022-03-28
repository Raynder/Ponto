<?php

class Controle extends Controller
{

    public function index()
    {

        $this->seLogin('sistema/controle');
    }

    public function colaborador()
    {
        if ($_SESSION['usuario']['tipo'] == 1 || $_SESSION['usuario']['tipo'] == 3) {
            $model = new Usuario();



            $dados = array(
                'linhas' => $model->listar('usuariosJoin'),
                'colunas' => [['nome', 0, 3], ['usuario', 0, 3], ['senha', 0, 2], ['email', 0, 3], ['escala', $listaDeEscalas, 3]],
                'listas' => $this->listarColunas(),
                'lista' => 'usuarios'
            );

            #sql que recebe todos os usuario junto com o nome da escala
            $sql = "SELECT usuarios.id, usuarios.nome, usuarios.usuario, usuarios.senha, usuarios.email, escalas.nome as escala FROM usuarios INNER JOIN escalas ON usuarios.escala = escalas.id";

            // $this->seLogin('sistema/controle', $dados);
        } else {
            $this->view('sistema/erro');
        }
    }

    public function empregador()
    {
        if ($_SESSION['usuario']['tipo'] == 2 || $_SESSION['usuario']['tipo'] == 3) {

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
                'lista' => 'usuarios'
            );

            #sql que recebe todos os usuario junto com o nome da escala
            $sql = "SELECT usuarios.id, usuarios.nome, usuarios.usuario, usuarios.senha, usuarios.email, escalas.nome as escala FROM usuarios INNER JOIN escalas ON usuarios.escala = escalas.id";
            $this->seLogin('sistema/controle', $dados);
        } else {
            $this->view('sistema/erro');
        }
    }

    private function listarColunas()
    {
        return ['usuarios', 'escalas'];
    }

    public function usuarios()
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
            'lista' => 'usuarios'
        );

        #sql que recebe todos os usuario junto com o nome da escala
        $sql = "SELECT usuarios.id, usuarios.nome, usuarios.usuario, usuarios.senha, usuarios.email, escalas.nome as escala FROM usuarios INNER JOIN escalas ON usuarios.escala = escalas.id";

        $this->seLogin('sistema/controle', $dados);
    }

    public function escalas()
    {
        $model = new Usuario();
        $dados = array(
            'linhas' => $model->listar('escalas'),
            'colunas' => [['nome', 0, 3], ['jornada', 0, 2], ['domingo', 1, 2], ['segunda', 1, 2], ['terca', 1, 2], ['quarta', 1, 2], ['quinta', 1, 2], ['sexta', 1, 2], ['sabado', 1, 2]],
            'listas' => $this->listarColunas(),
            'lista' => 'escalas'
        );
        $this->seLogin('sistema/controle', $dados);
    }

    public function cadastrar()
    {
        $model = new Usuario();

        if (isset($_POST['dados']['id']) && !empty($_POST['dados']['id'])) {
            if ($model->atualizar($_POST['table'], $_POST['dados'])) {
                return true;
            }
            return false;
        } else {
            if ($model->cadastrar($_POST['table'], $_POST['dados'])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deletar()
    {
        $model = new Usuario();
        if ($model->deletar($_POST['table'], $_POST['valor'])) {
            return true;
        } else {
            return false;
        }
    }

    public function editar()
    {
        $model = new Usuario();

        $dados = $model->editar($_POST['table'], $_POST['valor']);
    }
}
