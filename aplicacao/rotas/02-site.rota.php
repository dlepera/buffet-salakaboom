<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 12:04:01
 */

/* ----------------------------------------------------------------------------------------------------------------------
 * Website comum
 * ------------------------------------------------------------------------------------------------------------------- */
# Institucinal
$rotas['^institucional$'] = array(
    'controle'  =>  'WebSite',
    'acao'      =>  'institucional'
);

# Álbum de fotos
$rotas['^albuns-de-fotos$'] = array(
    'controle'  =>  'AlbumW',
    'acao'      =>  'lista'
);

$rotas['^album-de-fotos/.+/\d+$'] = array(
    'controle'  =>  'AlbumW',
    'acao'      =>  'detalhes',
    'params'    =>  '/album-de-fotos/.+/:id'
);

# Fale conosco
$rotas['^fale-conosco$'] = array(
    'controle'  =>  'ContatoSite',
    'acao'      =>  'formulario'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Exibição de e-mails
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^email/([a-z]+)/mostrarhtml/(\d+)$'] = '/email/:controle/:acao/:id';