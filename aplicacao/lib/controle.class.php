<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 07/12/2013
 */
 
class Controle{
	private $controle;
	private $acao;
	private $params;
	
	public function __construct($controle, $acao, $params = ''){
		$this->controle = $this->_controle($controle);
		$this->acao		= $this->_acao($acao);
		
		if( !empty($params) )
			$this->params = $params;
	} // Fim do mйtodo mбgico de construзгo da classe
	
    /**
     * Obter ou editar a propriedade $controle
     * 
     * @param string $valor: valor a ser atribъido а propriedade
     * 
     * @return string: valor da propriedade $controle
     */
    public function _controle($valor=null){
        if( is_null($valor) )
            return $this->controle;
        
        return $this->controle = '\Controle\\'. ucfirst($valor);
    } // Fim do mйtodo _controle
    
    /**
     * Obter ou editar a propriedade $controle
     * 
     * @param string $valor: valor a ser atribъido а propriedade
     * 
     * @return string: valor da propriedade $controle
     */
    public function _acao($valor=null){
        if( is_null($valor) )
            return $this->valor;
        
        return $this->valor = "_{$valor}";
    } // Fim do mйtodo _controle
    
	public function _validar(){
		# Verificar se o controle existe
		// if( !class_exists($this->controle) )
            # Gravar mensagem no log
            // throw new Exception("O controle {$this->controle} nгo existe!", 1500);
		    
		# Verificar se a aзгo existe dentro da classe
		// if( !method_exists($this->controle, $this->acao) )
            # Gravar mensagem no log
            // throw new Exception("O mйtodo {$this->acao} nгo foi encontrado na classe {$this->controle}.", 1500);            
            
        return !class_exists($this->controle) || !method_exists($this->controle, $this->acao) ? false : true;
	} // Fim do mйtodo _validar
	
	public function _executar(){
		if( !$this->_validar() ):
            # Alterar o cуdigo de retorno da pбgina
            header('', true, 404);
            
            # Exibir mensagem de pбgina nгo encontrada
            $obj_v = new Visao('/erros/');
            $obj_v->_template('404');
            $obj_v->_mostrar();
        endif;
			
		$c = new $this->controle();
		
		return call_user_func_array(
			array($c, $this->acao),
			!empty($this->params) ? $this->params : array()
		);
	} // Fim do mйtodo _executar
} // Fim da classe Controle

?>