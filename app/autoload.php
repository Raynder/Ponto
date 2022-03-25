<?php
    
    spl_autoload_register(function ($class) {

        $dir = [
            'Controllers',
            'Models',
            'Helpers',
            'Libraries'
        ];

        foreach ($dir as $arq) {
            $arquivo = __DIR__ .DS.$arq.DS.$class.".php";
            if (file_exists($arquivo)) {
                require_once($arquivo);
            }
        }
        
    });