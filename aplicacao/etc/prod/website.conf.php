<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 16:35:23
 */

# Diret�rios
$this->_dir_raiz('/');
self::$dir_css = '/aplicacao/css/site/';

# Configura��o do sistema
$this->_carregaridioma('pt-BR');
self::$ap_nome      = 'Buffet Salakaboom';
self::$ap_slogan    = 'Oi! Meu nome � Salakaboom. Seja bem-vindo a um mundo de magia e divers�o!';
self::$conf_separador_titulo = ' :|: ';

# Configura��es do banco de dados
$this->bd_host      = 'mysql.hostinger.com.br';
$this->bd_usuario   = 'u942579634_s2014';
$this->bd_senha     = '$@l4K@';
$this->bd_base      = 'u942579634_b2014';

# Configura��es de data
self::$dh_formato_hora = 'H:i';

# Configura��o dos plugins
self::$plugin_formulario_tema   = 'salakaboom';
self::$plugin_galeria_tema      = 'salakaboom';
