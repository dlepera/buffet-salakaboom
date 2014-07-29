<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 14/09/2013
 */

class Visao{
	private $dir_visoes = './visoes/';
    private $dir_erros  = './visoes/erros/';


    # Configura��es da vis�o
	private $template 	= array();
	private $conteudo;
	private $opcoes 	= array();
	private	$params		= array();
	
	# Propriedades da vis�o
	private $titulo = '';
	
	# Status da p�gina
	private $pagina_status = 200;
	
	public function __construct($raiz = '/'){
        $this->_dir_visoes($raiz);
	} // Fim do m�todo de constru��o da classe
	
    /**
     * Obter ou editar o valor da propriedade $dir_visoes
     * 
     * @param string $valor: valor a ser atribu�do � propriedade $dir_visoes
     * 
     * @return string: valor da propriedade $dir_visoes
     */
    public function _dir_visoes($valor=null){
        if( is_null($this->dir_visoes) )
            return $this->dir_visoes;
        
        return $this->dir_visoes = './visoes/'. trim($valor, '/') .'/';
    } // Fim do m�todo _dir_visoes

    /**
	 * Definir o template a ser usado nessa vis�o
	 * 
	 * @param string $template: Nome do arquivo .phtml a ser usado
	 * 		podendo conter tamb�m o subdiret�rio onde encontra-se o mesmos
	 * 
	 * @return void
	 */
	public function _template($template){
		# Caminho completo para chegar at� o template
		$c_completo = "{$this->dir_visoes}{$template}.phtml";

		# Vreificar se o template existe e, em caso negativo,
		# carregar o erro 404
		if( !file_exists($c_completo) ):
			# Alterar o c�digo de resposta do HTML para 404
			$this->_alterarstatus(404);
			$this->template[] = "{$this->dir_erros}404.phtml";
		else:		
			# Definir o novo template
			if( !in_array($c_completo, $this->template) )
				$this->template[] = $c_completo;
		endif;
	} // Fim do m�doto _definirtemplate
	
	/**
	 * Configurar/Alterar o t�tulo da p�gina
	 * 
	 * @param string $titulo: texto a ser exibido na TAG TITLE 
	 * @return string: valor da propriedade $titulo
	 */
	public function _titulo($titulo=null){
        if( is_null($titulo) )
            return $this->titulo;
        
		return $this->titulo = $titulo;
	} // Fim do m�todo _titulo	
	
	/**
	 * Carregar o conte�do do template
	 */
	public function _conteudo(){
		# Iniciar o buffer de sa�da, para evitar que a p�gina seja
		# exibida imediatamente
		ob_start();
		
		foreach( $this->template as $t ):
			if( !empty($t) )
				require_once $t;
			
			# Obter o conte�do do buffer e finalizar o buffer
			$this->conteudo = ob_get_contents();
		endforeach;
		
		if( !empty($this->opcoes) )
			$this->opcoes .= "\n". json_encode($this->opcoes);
		
		# Encerrar o buffer de sa�da para permitir que o template
		# seja exibido quando necess�rio
		ob_end_clean();
		
		return $this->conteudo;
	} // Fim do m�todo _conteudo
	
	/**
	 * Exibir o template na tela
     * 
	 * @param string $titulo: define o titulo da vis�o / p�gina, que
	 * 	ser� exibido atrav�s da TAG TITLE 
	 */
	public function _mostrar(){
		# Enviar o status da p�gina
		header(' ', true, $this->pagina_status);
		
		$conteudo = $this->_conteudo();
		
		# Configurar o t�tulo da p�gina 
		if( !empty($this->titulo) ):
			$expreg 	= '~\<title\>(.+)\<\/title\>~';
			$conteudo 	= preg_replace($expreg, "<title>{$this->titulo}". \DL::$conf_separador_titulo . \DL::$ap_nome ."</title>", $conteudo); 
		endif;
		
		echo $conteudo;
	} // Fim do m�todo _mostrar
	
	/**
	 * Incluir par�metros
	 */
	public function _incluirparams($c, $v){
		$this->params[$c] = $v;
	} // Fim do m�todo _incluirparams
	 
	/**
	 * Acessar os par�metros
	 */
	public function _obterparams(){
		return $this->params;
	} // Fim do m�todo _obterparams
	
	/**
	 * Alterar o status a ser enviado para o navegador
	 */
	public function _alterarstatus($s){
		$this->pagina_status = $s;
	} // Fim do m�todo _alterarstatus
} // Fim da classe Visao