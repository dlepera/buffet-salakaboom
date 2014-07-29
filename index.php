<?php

# Configurar a exibição de erros do PHP
error_reporting(E_ERROR);

require_once 'aplicacao/lib/frameworkdl.class.php';

# Declarar a constante especial __DIR__, caso a mesma não esteja definida
if( !defined('__DIR__') )
	define('__DIR__', dirname(__FILE__));

try{
    $__dl = new FrameworkDL(filter_input(INPUT_GET, 'dl-ambiente'), filter_input(INPUT_GET, 'dl-config'));
} catch(Exception $e){
    echo json_encode(
        array(
            'mensagem'  =>  utf8_encode($e->getMessage()),
            'tipo'      =>  'erro'
        )
    );
}