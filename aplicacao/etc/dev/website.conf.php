<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 16:35:23
 */

# Diret�rios
$this->_dir_raiz('/framework/');
self::$dir_css = '/aplicacao/css/site/';

# Configura��o do sistema
$this->_carregaridioma('pt-BR');

# Configura��es do banco de dados
$this->bd_usuario   = 'root';
$this->bd_senha     = '$d5Ro0t';
$this->bd_base      = 'framework';

# Configura��o dos plugins
self::$plugin_formulario_tema   = 'colorido';
self::$plugin_galeria_tema      = 'galeria-2';