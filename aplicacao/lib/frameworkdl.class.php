<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 15:08:43
 */

# Criar a fun��o __autoload para evitar que seja necess�rio
# incluir as classes manualmente
function __autoload($classe){
    preg_match_all('~([A-Za-z0-9]+)~', $classe, $classe);
    list($tipo, $nome) = array_map(
        create_function('$c', 'return strtolower($c);'),
        $classe[0]
    );
    
	switch($tipo):
        case 'iface':
			$diretorio  = __DIR__ .'/../lib/interfaces';
		break;
		
		case 'modelo':
			$diretorio = __DIR__ .'/../../modelos';
		break;
		
		case 'controle':
			$diretorio = __DIR__ .'/../../controles';
		break;
		
		case 'class':
		default:
			$diretorio = __DIR__;
		break;
	endswitch;
	
	$arquivo = $diretorio ."/{$nome}.{$tipo}.php";
    
	if( file_exists($arquivo) )
		require_once $arquivo;
	else return false;
} // Fim da fun��o __autoload

class FrameworkDL{
    # Configura��es do sistema
    private $sis_config, $sis_ambiente = 'dev';
    
    # Configura��es da aplica��o
    public static $ap_nome      = 'FrameworkDL';
    public static $ap_encoding  = 'windows-1252';
    public static $ap_slogan    = '';
        
    # Configura��es de diret�rio
    public static $dir_raiz         = '';
    private static $dir_config      = '/aplicacao/etc/';
    private static $dir_idiomas     = '/aplicacao/idiomas/';
    public static $dir_js           = '/aplicacao/js/';
    public static $dir_css          = '/aplicacao/css/';
    public static $dir_imgs         = '/aplicacao/imgs/';
    public static $dir_rotas        = '/aplicacao/rotas/';
    
    # Configura��es do framework
    private $conf_idioma                   = 'pt-BR';
    public static $conf_jquery_versao      = '2.1.1';
    public static $conf_versao             = '0.1';
    public static $conf_separador_titulo   = ' | ';
    
    # Configura��es de navegadores
    public static $browser_versao_ie = '10';
    
    # Configura��o dos plugins
    public static $plugin_formulario_tema   = "dl-formulario";
    public static $plugin_paginacao_tema    = "dl-paginacao-1.0";
    public static $plugin_galeria_tema      = "dl-galeria-1.0";
    
    # Configura��es de bancodedados
    public static $bd_pdo;
    private $bd_driver = 'mysql', $bd_host = 'localhost', $bd_porta = 3306, $bd_base, $bd_usuario = 'root', $bd_senha = '';
    public static $bd_dh_formato_completo = 'Y-m-d H:i:s', $bd_dh_formato_data = 'Y-m-d', $bd_dh_formato_hora = 'H:i:s',
        $bd_encoding = 'latin1';
   
    # Configura��es de exibi��o de datas
    public static $dh_formato_completo  = 'd/m/Y H:i';
    public static $dh_formato_data      = 'd/m/Y';
    public static $dh_formato_hora      = 'H:i';
    
    # Vari�vel que armazena respostas tempor�rias
    public static $tmp_buffer_resposta = array();
    
    /**
     * Obter o valor das propriedades da classe
     * 
     * @param string $nome : nome da propriedade a ser exibida
     * 
     * @return mixed: valor da propriedade $nome
     */
    public function __get($nome){
        if( property_exists($this, $nome) )
            return $this->{$nome};
    } // Fim do m�todo m�gico __get
    
    /**
     * Editar propriedades da classe
     * 
     * @param string $nome : nome da propriedade a ser editada
     * @param mixed $valor : valor a ser atribu�do � propriedade $nome
     * 
     * @return false
     */
    public function __set($nome, $valor){
        if( !property_exists($this, $nome) )
            throw new Exception(ERRO_PADRAO_PROPRIEDADE_NAO_EXISTE, 1403);
        
        # Diret�rios
        if( preg_match('~^(dir_)~', $nome) && $nome !== 'dir_raiz' )
            $this->{$nome} = '/'. trim($valor, '/') .'/';
                
        if( property_exists($this, "_{$nome}") ):
            call_user_func_array(array($this, "_{$nome}"), array('valor' => $valor));
        else:
            $this->{$nome} = $valor;
        endif;
    } // Fim do m�todo m�gico __set
    
    public function __construct($ambiente = 'dev', $config = 'website'){
        # Obter as informa��es din�micas
        $this->_sis_ambiente($ambiente);
        $this->_sis_config($config);
        
        # Aplicar arquivo de configura��o
        $config = '.'. self::$dir_config ."{$this->sis_ambiente}/{$this->sis_config}.conf.php";
        
        if( !file_exists($config) )
            throw new Exception("O arquivo de configura��o <em>{$config}</em> n�o foi encontrado!<br />The <em>{$config}</em> config file not found!", 1404);
        
        require_once $config;
        
        # Carregar as bibliotecas
        $this->_carregarlibs();
        
        # Conectar ao banco de dados
        $this->_conectarbd();
        
        # Carregar o conte�do da p�gina
        $this->_carregarconteudo();
    } // Fim do m�todo m�gico __construct
    
    public function __destruct(){
        # Enviar as respostas ao usu�rio
        if( count(self::$tmp_buffer_resposta) > 0 )
            echo json_encode(self::$tmp_buffer_resposta);
    } // Fim do m�todo m�gico de destrui��o da classe
    
    /**
     * Obter ou editar o valor da propriedade $sis_config
     * 
     * @param string $valor : sigla do pacote de idiomas a ser utilizado
     * 
     * @return string: valor da propriedade $sis_config
     */
    public function _sis_config($valor = null){
        if( is_null($valor) )
            return $this->sis_config;
        
        return $this->sis_config = (string)$valor;
    } // Fim do m�todo _sis_config
    
    /**
     * Obter ou editar o valor da propriedade $sis_ambiente
     * 
     * @param string $valor : sigla do pacote de idiomas a ser utilizado
     * 
     * @return string: valor da propriedade $sis_ambiente
     */
    public function _sis_ambiente($valor = null){
        if( is_null($valor) )
            return $this->sis_ambiente;
        
        return $this->sis_ambiente = (string)$valor;
    } // Fim do m�todo _sis_config
    
    /**
     * Obter ou editar o valor da propriedade $conf_idioma
     * 
     * @param string $valor : sigla do pacote de idiomas a ser utilizado
     * 
     * @return string: valor da propriedade $conf_idioma
     */
    public function _conf_idioma($valor = null){
        if( is_null($valor) )
            return $this->conf_idioma;
        
        return $this->conf_idioma = (string)$valor;
    } // Fim do m�todo _conf_idioma
    
    /**
     * Obter ou editar o valor da propriedade $dir_raiz
     * 
     * @param string $valor : diret�rio que deve ser definido como a ra�z do sistema,
     * independente da ra�z do site definido pelo apache
     * 
     * @return string: valor da propriedade $dir_raiz
     */
    public function _dir_raiz($valor = null){
        if( is_null($valor) )
            return self::$dir_raiz;
            
        # Remover o / ao final da string
        self::$dir_raiz = preg_replace('~/$~', '', $valor);

        # Alterar o diret�rio
        chdir(
            '/'. trim(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT'), '/')
            .'/'. self::$dir_raiz
        );
            
        return self::$dir_raiz;
    } // Fim do m�todo _dir_raiz

    /**
     * Conectar ao banco de dados
     * 
     * @return boolean true em caso de sucesso ou false em caso de falha
     */
    public function _conectarbd(){
        try{
            self::$bd_pdo = new PDODL(
                "{$this->bd_driver}:host={$this->bd_host};port={$this->bd_porta};dbname={$this->bd_base}",
                $this->bd_usuario, $this->bd_senha
            );
        } catch(PDOException $e){
            var_dump($e);
        }
        
        if( $this->bd_driver == 'mysql' )
            self::$bd_pdo->exec('SET NAMES '. self::$bd_encoding);
    } // Fim do m�todo de conex�o ao banco de dados
    
    /**
     * Carregar o pacote de idiomas
     */
    public function _carregaridioma($idioma){
        $this->_conf_idioma($idioma);
        
        $idioma = '.'. self::$dir_idiomas . $this->conf_idioma;
                
        # Verificar se o pacote de idiomas est� instalado
        if( !file_exists($idioma) )
            throw new Exception("Pacote de idiomas <em>{$this->conf_idioma}</em> n�o encontrado!<br />The <em>{$this->conf_idioma}</em> language package not found!", 1404);
            
        # Ler apenas arquivo que n�o estejam ocultos
        $arquivos = preg_grep('~^[^\.]~', scandir($idioma));
        
        foreach( $arquivos as $a )
            include_once "{$idioma}/{$a}";
        
        return true;
    } // Fim do m�todo _carregaridioma
    
    /**
     * Carregar as bibliotecas
     */
    public function _carregarlibs(){
        # Scanear o diret�rio de bibliotecas
        $arquivos = preg_grep('~^[^\.]~', scandir(__DIR__));
        
        foreach( $arquivos as $a ):
            $a = __DIR__ ."/{$a}";
            
            if( is_file($a) )
                include_once $a;
        endforeach;
        
        return true;
    } // Fim do m�todo _carregarlibs
    
    /**
     * Carregar conte�do
     */
    public function _carregarconteudo(){
        # Scanear o diret�rio de rotas
        $dir_rotas = '.'. self::$dir_rotas;
        
        $arquivos = preg_grep('~^[^\.]~', scandir($dir_rotas));
        
        foreach( $arquivos as $a ):
            $a = "{$dir_rotas}{$a}";
            
            if( is_file($a) )
                include_once $a;
        endforeach;
        
        # Utilizar a classe de Roteamento, para identificar
        # os par�metros da rota
        $obj_r = new Roteamento($rotas);
        $obj_r->_obterrota();
        
        # Utilizar a classe Controle para executar o controle
        # de acordo com a classe roteamento
        $obj_c = new Controle($obj_r->controle, $obj_r->acao, $obj_r->params);
        $obj_c->_executar();
    } // Fim do m�todo _carregarconteudo
} // Fim da classe FrameworkDL

# Criar um alias para essa classe, para facilitar
# o acesso �s configura��es
class_alias('FrameworkDL', 'DL');
