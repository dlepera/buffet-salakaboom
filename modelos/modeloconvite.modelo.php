<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 09/12/2013
 */

namespace Modelo;
 
class ModeloConvite extends Principal{
	# Propriedades do modelo
	protected $modelo_convite_id, $modelo_convite_titulo, $modelo_convite_imagem, $modelo_convite_publicar = 1, $modelo_convite_delete = 0;
	
	public function __construct($id=0){
        parent::__construct('salakaboom_convites_modelos', 'modelo_convite_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
		
    /**
     * Obter ou editar o valor da propriedade $modelo_convite_titulo
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->modelo_convite_titulo
     * 
     * @return string - valor da propriedade $modelo_convite_titulo
     */
    public function _modelo_convite_titulo($valor=null){
        return is_null($valor) ?
            (string)$this->modelo_convite_titulo        
        : $this->modelo_convite_titulo = (string)$valor;
    } // Fim do método _modelo_convite_titulo
    
    /**
     * Obter ou editar o valor da propriedade $modelo_convite_imagem
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->modelo_convite_imagem
     * 
     * @return string - valor da propriedade $modelo_convite_imagem
     */
    public function _modelo_convite_imagem($valor=null){
        return is_null($valor) ?
            (string)$this->modelo_convite_imagem        
        : $this->modelo_convite_imagem = (string)$valor;
    } // Fim do método _modelo_convite_imagem
    
	/**
	 * Salvar o conteúdo do objeto no banco de dados
	 */
	public function _salvar($salvar=true){
		if( file_exists($_FILES['imagem']['tmp_name']) && $salvar ):
			$up = new \Upload('/aplicacao/uploads/convites/');
			
			if( $up->_salvar(strtolower(str_replace(' ', '-', \Funcoes::_removeracentuacao($this->modelo_convite_titulo))), true) )
				$this->modelo_convite_imagem = $up->arquivos_salvos[0];
		endif;
		
		if( !$this->modelo_convite_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " modelo_convite_titulo, modelo_convite_imagem, modelo_convite_publicar) VALUES ("
                    . " '{$this->modelo_convite_titulo}', '{$this->modelo_convite_imagem}', {$this->modelo_convite_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " modelo_convite_titulo = '{$this->modelo_convite_titulo}',"
                    . " modelo_convite_imagem = '{$this->modelo_convite_imagem}',"
                    . " modelo_convite_publicar = {$this->modelo_convite_publicar}"
                    . " WHERE modelo_convite_id = {$this->modelo_convite_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->modelo_convite_id = \DL::$bd_pdo->lastInsertID('modelo_convite_id');
        
        return $this->modelo_convite_id;
	} // Fim do médoto _salvar
	
	/**
	 * Remover o registro
	 */
	public function _remover(){
        $rem = \DL::$bd_pdo->exec("DELETE FROM {$this->bd_tabela} WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        if( $rem === false && property_exists($this, $this->modelo_delete) )
            $rem = \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET {$this->modelo_delete} = 1 WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
            
        # Remover os arquivos referentes a esse registro
        unlink($this->modelo_convite_imagem);
        
        return (int)$rem;
	} // Fim do método _remover
} // Fim da classe ModeloConvite
