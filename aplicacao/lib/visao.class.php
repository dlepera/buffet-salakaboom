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


    # Configurações da visão
	private $template 	= array();
	private $conteudo;
	private $opcoes 	= array();
	private	$params		= array();
	
	# Propriedades da visão
	private $titulo = '';
	
	# Status da página
	private $pagina_status = 200;
	
	public function __construct($raiz = '/'){
        $this->_dir_visoes($raiz);
	} // Fim do método de construção da classe
	
    /**
     * Obter ou editar o valor da propriedade $dir_visoes
     * 
     * @param string $valor: valor a ser atribuído à propriedade $dir_visoes
     * 
     * @return string: valor da propriedade $dir_visoes
     */
    public function _dir_visoes($valor=null){
        if( is_null($this->dir_visoes) )
            return $this->dir_visoes;
        
        return $this->dir_visoes = './visoes/'. trim($valor, '/') .'/';
    } // Fim do método _dir_visoes

    /**
	 * Definir o template a ser usado nessa visão
	 * 
	 * @param string $template: Nome do arquivo .phtml a ser usado
	 * 		podendo conter também o subdiretório onde encontra-se o mesmos
	 * 
	 * @return void
	 */
	public function _template($template){
		# Caminho completo para chegar até o template
		$c_completo = "{$this->dir_visoes}{$template}.phtml";

		# Vreificar se o template existe e, em caso negativo,
		# carregar o erro 404
		if( !file_exists($c_completo) ):
			# Alterar o código de resposta do HTML para 404
			$this->_alterarstatus(404);
			$this->template[] = "{$this->dir_erros}404.phtml";
		else:		
			# Definir o novo template
			if( !in_array($c_completo, $this->template) )
				$this->template[] = $c_completo;
		endif;
	} // Fim do médoto _definirtemplate
	
	/**
	 * Configurar/Alterar o título da página
	 * 
	 * @param string $titulo: texto a ser exibido na TAG TITLE 
	 * @return string: valor da propriedade $titulo
	 */
	public function _titulo($titulo=null){
        if( is_null($titulo) )
            return $this->titulo;
        
		return $this->titulo = $titulo;
	} // Fim do método _titulo	
	
	/**
	 * Carregar o conteúdo do template
	 */
	public function _conteudo(){
		# Iniciar o buffer de saída, para evitar que a página seja
		# exibida imediatamente
		ob_start();
		
		foreach( $this->template as $t ):
			if( !empty($t) )
				require_once $t;
			
			# Obter o conteúdo do buffer e finalizar o buffer
			$this->conteudo = ob_get_contents();
		endforeach;
		
		if( !empty($this->opcoes) )
			$this->opcoes .= "\n". json_encode($this->opcoes);
		
		# Encerrar o buffer de saída para permitir que o template
		# seja exibido quando necessário
		ob_end_clean();
		
		return $this->conteudo;
	} // Fim do método _conteudo
	
	/**
	 * Exibir o template na tela
     * 
	 * @param string $titulo: define o titulo da visão / página, que
	 * 	será exibido através da TAG TITLE 
	 */
	public function _mostrar(){
		# Enviar o status da página
		header(' ', true, $this->pagina_status);
		
		$conteudo = $this->_conteudo();
		
		# Configurar o título da página 
		if( !empty($this->titulo) ):
			$expreg 	= '~\<title\>(.+)\<\/title\>~';
			$conteudo 	= preg_replace($expreg, "<title>{$this->titulo}". \DL::$conf_separador_titulo . \DL::$ap_nome ."</title>", $conteudo); 
		endif;
		
		echo $conteudo;
	} // Fim do método _mostrar
	
	/**
	 * Incluir parâmetros
	 */
	public function _incluirparams($c, $v){
		$this->params[$c] = $v;
	} // Fim do método _incluirparams
	 
	/**
	 * Acessar os parâmetros
	 */
	public function _obterparams(){
		return $this->params;
	} // Fim do método _obterparams
	
	/**
	 * Alterar o status a ser enviado para o navegador
	 */
	public function _alterarstatus($s){
		$this->pagina_status = $s;
	} // Fim do método _alterarstatus
} // Fim da classe Visao