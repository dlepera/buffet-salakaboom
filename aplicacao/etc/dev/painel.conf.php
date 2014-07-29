<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 16:35:23
 */

# Diretórios
$this->_dir_raiz('/framework/');
self::$dir_css = '/aplicacao/css/painel/';

# Configuração do sistema
$this->_carregaridioma('pt-BR');
self::$ap_nome      = 'Painel-DL';
self::$ap_slogan    = 'Gerenciador de conteúdo';
self::$conf_versao  = '<span class="dl-versao">1.1 BETA</span>';

# Configurações do banco de dados
$this->bd_usuario   = 'root';
$this->bd_senha     = '$d5Ro0t';
$this->bd_base      = 'framework';

# Configuração dos plugins
self::$plugin_formulario_tema   = 'colorido';
self::$plugin_paginacao_tema    = 'painel-dl';