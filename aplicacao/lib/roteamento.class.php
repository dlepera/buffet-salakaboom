<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 19/09/2013
 */

class Roteamento{
	# Rotas
	private $rotas = array();
	private $rota;
	private $uri;
	
	# Configurações de açoes a serem executadas
	public $params;
	
	public function __construct(array $rotas = array()){
		// Adicionar as rotas
		if( count($rotas) > 0 )
			$this->rotas = $rotas;
		
		// Obter a URI atual
		$this->uri = str_replace('index.php', '', trim(filter_input(INPUT_GET, 'dl-uri'), '/'));
	} // Fim do método de construção da classe
	
	public function _obterrota(){
		if( !count($this->rotas) )
			throw new Exception('Nenhuma rota configurada!', false);
		
		# Vetor que receberá as configurações da rota
		$params = array();
        
		foreach( $this->rotas as $rota => $conf ):
			if( preg_match("#{$rota}#", $this->uri) ):
				if( is_string($conf) || isset($conf['params']) ): 
					$params_rota	= trim(is_string($conf) ? $conf : $conf['params'], '/');
					$url_explode 	= explode('/', $this->uri);
					$conf_explode 	= explode('/', $params_rota);
                    
					foreach($conf_explode as $k => $p):
						if( preg_match('~^:(?<nome>.*)$~', $p, $n) ):
							$params[$n['nome']] = $url_explode[$k];
						endif;
					endforeach;
                    
					# Remover os parâmetros do vetor para não duplicar
					# informações
					if( isset($conf['params']) && is_array($conf) ) unset($conf['params']);
				endif;
                
				 # Se a rota vem definida com um parâmetro como vetor
				 # o mesmo será unido ao vetor de parâmetros oficiais que serão
				 # passados ao controle
				if( is_array($conf) ):
					$params = array_merge($params, $conf);
				endif; // Fim elseif( is_array($conf) )
				break;
			endif;
		endforeach;
        
		$this->controle = ( !empty($params['controle']) )? $params['controle'] : 'Index'; 
			unset($params['controle']);
			
		$this->acao		= ( !empty($params['acao']) )? str_replace('-', '', strtolower($params['acao'])) : 'index';
			unset($params['acao']);
            
        return $this->params = $params;
	} // Fim do método _obterrota
} // Fim da classe Roteamento