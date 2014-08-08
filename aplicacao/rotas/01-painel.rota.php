<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 28/05/2014 10:17:21
 */

/* ----------------------------------------------------------------------------------------------------------------------
 * Módulos
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^painel-dl/(home|)$'] = array(
    'controle'  => 'PainelDL',
    'acao'      => 'home'
);

$rotas['^painel-dl/modulo/.+/\d+$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'descrever',
    'params'    =>  '/painel-dl/modulo/link-do-modulo/:modulo'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Módulo Web Site
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^painel-dl/web-site/contatos-recebidos/lista$'] = array(
    'controle'  =>  'ContatoSiteSis',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/web-site/detalhes-do-contato/\d+$'] = array(
    'controle'  =>  'ContatoSiteSis',
    'acao'      =>  'detalhes',
    'params'    =>  '/painel-dl/web-site/detalhes-do-contato/:id'
);

$rotas['^painel-dl/web-site/dados-para-contato/lista$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/web-site/dados-para-contato/novo$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/web-site/dados-para-contato/alterar/\d+$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/web-site/dados-para-contato/alterar/:id'
);

$rotas['^painel-dl/web-site/assuntos-de-contatos/lista$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/web-site/assuntos-de-contatos/novo$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/web-site/assuntos-de-contatos/alterar/\d+$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/web-site/assuntos-de-contatos/alterar/:id'
);

$rotas['^painel-dl/web-site/albuns-de-fotos/lista$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/web-site/albuns-de-fotos/novo$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/web-site/albuns-de-fotos/alterar/\d+$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/web-site/albuns-de-fotos/alterar/:id'
);

$rotas['^painel-dl/web-site/formas-de-contato/lista$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/web-site/formas-de-contato/novo$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/web-site/formas-de-contato/alterar/\d+$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/web-site/formas-de-contato/alterar/:id'
);

$rotas['^painel-dl/web-site/fotos/alterar/\d+$'] = array(
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/web-site/fotos/alterar/:id'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Módulo Admin
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^painel-dl/admin/emails/lista$'] = array(
    'controle'  => 'ConfigEmail',
    'acao'      => 'lista'
);

$rotas['^painel-dl/admin/emails/novo$'] = array(
    'controle'  => 'ConfigEmail',
    'acao'      => 'formulario'
);

$rotas['^painel-dl/admin/emails/alterar/\d+$'] = array(
    'controle'  => 'ConfigEmail',
    'acao'      => 'formulario',
    'params'    => '/painel-dl/admin/emails/alterar/:id'
);

$rotas['^painel-dl/admin/usuarios/lista'] = array(
    'controle'  => 'Usuario',
    'acao'      => 'lista'
);

$rotas['^painel-dl/admin/usuarios/novo$'] = array(
    'controle'  => 'Usuario',
    'acao'      => 'formulario'
);

$rotas['^painel-dl/admin/usuarios/alterar/\d+$'] = array(
    'controle'  => 'Usuario',
    'acao'      => 'formulario',
    'params'    => '/painel-dl/admin/usuarios/alterar/:id'
);

$rotas['^painel-dl/admin/grupos-de-usuarios/lista$'] = array(
    'controle'  => 'GrupoUsuario',
    'acao'      => 'lista'
);

$rotas['^painel-dl/admin/grupos-de-usuarios/novo$'] = array(
    'controle'  => 'GrupoUsuario',
    'acao'      => 'formulario'
);

$rotas['^painel-dl/admin/grupos-de-usuarios/alterar/\d+$'] = array(
    'controle'  => 'GrupoUsuario',
    'acao'      => 'formulario',
    'params'    => '/painel-dl/admin/grupos-de-usuarios/alterar/:id'
);

$rotas['^painel-dl/admin/grupos-de-usuarios/novo/str$'] = array(
    'controle'  => 'GrupoUsuario',
    'acao'      => 'formulario_str'
);

$rotas['^painel-dl/admin/usuarios/alterar-minha-senha$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'formalterarsenha'
);

$rotas['^painel-dl/admin/usuarios/esqueci-minha-senha$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'formesquecisenha'
);

$rotas['^painel-dl/admin/usuarios/recuperar-senha/(.*)$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'formresetsenha',
    'params'    =>  '/painel-dl/usuarios/recuperar-senha/:hash'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Módulo Desenvolvedor
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^painel-dl/desenvolvedor/modulos/lista'] = array(
    'controle'  => 'Modulo',
    'acao'      => 'lista'
);

$rotas['^painel-dl/desenvolvedor/modulos/novo$'] = array(
    'controle'  => 'Modulo',
    'acao'      => 'formulario'
);

$rotas['^painel-dl/desenvolvedor/modulos/alterar/\d+$'] = array(
    'controle'  => 'Modulo',
    'acao'      => 'formulario',
    'params'    => '/painel-dl/desenvolvedor/modulos/alterar/:id'
);

$rotas['^painel-dl/desenvolvedor/temas/lista'] = array(
    'controle'  => 'Tema',
    'acao'      => 'lista'
);

$rotas['^painel-dl/desenvolvedor/temas/novo$'] = array(
    'controle'  => 'Tema',
    'acao'      => 'formulario'
);

$rotas['^painel-dl/desenvolvedor/temas/alterar/\d+$'] = array(
    'controle'  => 'Tema',
    'acao'      => 'formulario',
    'params'    => '/painel-dl/desenvolvedor/temas/alterar/:id'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Ações
 * ------------------------------------------------------------------------------------------------------------------- */
# Consultar disponibilidade de login
$rotas['^painel-dl/admin/usuarios/verificarlogin/([a-z0-9]+)$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'verificarlogin',
    'params'    =>  'painel-dl/admin/usuarios/verificarlogin/:usr'
);

# Consultar disponibilidade do e-mail
$rotas['^painel-dl/admin/usuarios/verificaremail/(.+)$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'verificaremail',
    'params'    =>  'painel-dl/admin/usuarios/verificaremail/:email'
);

# Testar as configurações de envio de e-mail
$rotas['^painel-dl/admin/emails/testar/(\d+)$'] = array(
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'testar',
    'params'    =>  '/painel-dl/admin/emails/testar/:id'
);

# Fazer upload de imagens para um álbum
/* $rotas['^fotoalbum/upload/\d+$'] = array(
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'upload',
    'params'    =>  '/fotoalbum/upload/:album'
);    // '/:controle/:acao/:album'; */
$rotas['^fotoalbum/upload/\d+$'] = '/:controle/:acao/:album';
