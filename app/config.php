<?php

    define('APP', dirname(__FILE__));
    define('DS', DIRECTORY_SEPARATOR);
    define('URL', 'http://192.168.1.37/ponto/');
    define('DIST', 'http://192.168.1.37/ponto/public/dist/');
    define('APP_NOME', 'LOBE');
    global $cabecalho;

// SELECT folha.saldo, usuarios.id, escalas.terca as meta 
// FROM usuarios 
// INNER JOIN escalas ON usuarios.escala = escalas.id 
// INNER JOIN folha ON folha.id_usuario = usuarios.id 
// WHERE usuario = 'kauanny' AND senha = '321';