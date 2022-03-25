<?php

class Rota {
    
    private $controlador = 'Sistema'; // Controlador padrão
    private $metodo = 'index'; // Método padrão
    private $parametros = array(); // Parâmetros padrão


    public function __construct(){ // Método construtor que faz o require dos controllers e metodos
        $url = $this->url() ? $this->url() : [0];
        $cabecalho = '';

        if(file_exists('../app/Controllers/' . ucwords($url[0]) . '.php')){ // Verifica se o controlador existe
            $this->controlador = ucwords($url[0]);
            $cabecalho = $url[0];
            unset($url[0]);
        }

        require_once '../app/Controllers/' . $this->controlador . '.php'; // Requerer o controlador
        $this->controlador = new $this->controlador;

        if(isset($url[1])){ // Verifica se o método existe
            if(method_exists($this->controlador, $url[1])){
                $this->metodo = $url[1]; // Se existir, atribui o método
                unset($url[1]);
            }
        }
        // exit(APP.'/Views/cabecalhos/'.$cabecalho.'.php');
        $this->parametros = $url ? array_values($url) : []; // Se existir, atribui os parâmetros
        if(file_exists(APP.'/Views/cabecalhos/sistema.php') && $this->metodo != 'index'){
            include APP.'/Views/cabecalhos/sistema.php';
        }
        call_user_func_array([$this->controlador, $this->metodo], $this->parametros); // Chama o método e passa os parâmetros

    }

    public function url(){ // Método que retorna a url
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        if(isset($url)){
            $url = trim(rtrim($url, '/'));
            $url = explode('/', $url);
            return ($url);
        }
    }
}