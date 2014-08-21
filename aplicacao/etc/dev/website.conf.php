<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 16:35:23
 */

# Diretórios
$this->_dir_raiz('/buffet-salakaboom/');
self::$dir_css = '/aplicacao/css/site/';

# Configuração do sistema
$this->_carregaridioma('pt-BR');
self::$ap_nome      = 'Buffet Salakaboom';
self::$ap_slogan    = 'Oi! Meu nome é Salakaboom. Seja bem-vindo a um mundo de magia e diversão!';
self::$conf_separador_titulo = ' :|: ';

# Configurações do banco de dados
$this->bd_host      = '127.0.0.1';
$this->bd_usuario   = 'salakaboom';
$this->bd_senha     = '$@l4K';
$this->bd_base      = 'salakaboom';

# Configurações de data
self::$dh_formato_hora = 'H:i';

# Configuração dos plugins
self::$plugin_formulario_tema   = 'salakaboom';
self::$plugin_galeria_tema      = 'salakaboom';
