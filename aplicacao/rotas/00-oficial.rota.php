<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 16/05/2014 14:25:10
 */

$rotas = array();

/* ----------------------------------------------------------------------------------------------------------------------
 * Website comum
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^(home|)$'] = array(
    'controle'  => 'WebSite',
    'acao'      => 'index'
);