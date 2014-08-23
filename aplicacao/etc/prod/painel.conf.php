<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 16:35:23
 */

# Diret�rios
$this->_dir_raiz('/');
self::$dir_css = '/aplicacao/css/painel/';

# Configura��o do sistema
$this->_carregaridioma('pt-BR');
self::$ap_nome      = 'Painel-DL';
self::$ap_slogan    = 'Gerenciador de conte�do';
self::$conf_versao  = '<span class="dl-versao">1.1 BETA</span>';

# Configura��es do banco de dados
$this->bd_host      = 'mysql.hostinger.com.br';
$this->bd_usuario   = 'u942579634_s2014';
$this->bd_senha     = '$@l4K@';
$this->bd_base      = 'u942579634_b2014';

# Configura��o dos plugins
self::$plugin_formulario_tema   = 'colorido';
self::$plugin_paginacao_tema    = 'painel-dl';