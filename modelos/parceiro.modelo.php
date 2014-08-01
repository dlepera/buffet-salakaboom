<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 19/12/2013
 */
 
namespace Modelo;

class Parceiro extends Principal{
	# Propriedades do parceiro
	protected $parceiro_id, $parceiro_tipo, $parceiro_nome, $parceiro_descr, $parceiro_email, $parceiro_telefone, $parceiro_site, 
        $parceiro_imagem, $parceiro_publicar = 1, $parceiro_delete = 0;
			
	public function __construct($id=0){
        parent::__construct('salakaboom_parceiros', 'parceiro_');
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS P"
            . " INNER JOIN salakaboom_parceiros_tipos AS TP ON( TP.tipo_parceiro_id = P.parceiro_tipo )"
            . " WHERE P.{$this->bd_prefixo}delete = 0";
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
	
    /**
     * Obter ou editar o valor da propriedade $parceiro_tipo
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->parceiro_tipo
     * 
     * @return int - valor da propriedade $parceiro_tipo
     */
    public function _parceiro_tipo($valor=null){
        return is_null($valor) ?
            (int)$this->parceiro_tipo        
        : $this->parceiro_tipo = (int)$valor;
    } // Fim do método _parceiro_tipo
    
    /**
     * Obter ou editar o valor da propriedade $parceiro_nome
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->parceiro_nome
     * 
     * @return string: valor da propriedade $parceiro_nome
     */
    public function _parceiro_nome($valor=null){
        return is_null($valor) ?
            (string)$this->parceiro_nome        
        : $this->parceiro_nome = (string)$valor;
    } // Fim do método _parceiro_nome
    
    /**
     * Obter ou editar o valor da propriedade $parceiro_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->parceiro_descr
     * 
     * @return string: valor da propriedade $parceiro_descr
     */
    public function _parceiro_descr($valor=null){
        return is_null($valor) ?
            (string)$this->parceiro_descr        
        : $this->parceiro_descr = (string)$valor;
    } // Fim do método _parceiro_descr
    
    /**
     * Obter ou editar o valor da propriedade $parceiro_email
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->parceiro_email
     * 
     * @return string: valor da propriedade $parceiro_email
     */
    public function _parceiro_email($valor=null){
        if( is_null($valor) )
            return $this->parceiro_email;
        
        if( !empty($valor) && !$this->parceiro_email = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->parceiro_email;
    } // Fim do método _parceiro_email
    
    /**
     * Obter ou editar o valor da propriedade $parceiro_telefone
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->parceiro_telefone
     * 
     * @return string: valor da propriedade $parceiro_telefone
     */
    public function _parceiro_telefone($valor=null){
        return is_null($valor) ?
            (string)$this->parceiro_telefone        
        : $this->parceiro_telefone = (string)$valor;
    } // Fim do método _parceiro_telefone
    
    /**
     * Obter ou editar o valor da propriedade $parceiro_site
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->parceiro_site
     * 
     * @return string: valor da propriedade $parceiro_site
     */
    public function _parceiro_site($valor=null){
        return is_null($valor) ?
            (string)$this->parceiro_site        
        : $this->parceiro_site = (string)preg_replace('~(^http://|/$)~', '', $valor);
    } // Fim do método _parceiro_site
    
    /**
     * Obter ou editar o valor da propriedade $parceiro_imagem
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->parceiro_imagem
     * 
     * @return string: valor da propriedade $parceiro_imagem
     */
    public function _parceiro_imagem($valor=null){
        return is_null($valor) ?
            (string)$this->parceiro_imagem       
        : $this->parceiro_imagem = (string)$valor;
    } // Fim do método _parceiro_site
    
	/**
     * Salvar determinado registro
     * 
     * @param boolean $salvar - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        # Salvar o arquivo no diretório de uploads do site
        if( file_exists($_FILES['imagem']['tmp_name']) && $salvar ):
			$up = new \Upload('/aplicacao/uploads/parceiros/');
			
			if( $up->_salvar(strtolower(str_replace(' ', '-', \Funcoes::_removeracentuacao($this->parceiro_nome))), true) )
				$this->parceiro_imagem = $up->arquivos_salvos[0];
            
            # Redimensionar a imagem
            $obj_im = new \Imagem($this->parceiro_imagem);
            $obj_im->_redimensionar(200);
            $obj_im->_salvar($this->parceiro_imagem);
		endif;
        
        if( !$this->parceiro_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " parceiro_tipo, parceiro_nome, parceiro_descr, parceiro_email, parceiro_telefone, parceiro_site, parceiro_imagem,"
                    . " parceiro_publicar) VALUES ("
                    . " {$this->parceiro_tipo}, '{$this->parceiro_nome}', '{$this->parceiro_descr}', '{$this->parceiro_email}',"
                    . " '{$this->parceiro_telefone}', '{$this->parceiro_site}', '{$this->parceiro_imagem}', {$this->parceiro_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " parceiro_tipo = {$this->parceiro_tipo},"
                    . " parceiro_nome = '{$this->parceiro_nome}',"
                    . " parceiro_descr = '{$this->parceiro_descr}',"
                    . " parceiro_email = '{$this->parceiro_email}',"
                    . " parceiro_telefone = '{$this->parceiro_telefone}',"
                    . " parceiro_site = '{$this->parceiro_site}',"
                    . " parceiro_imagem = '{$this->parceiro_imagem}',"
                    . " parceiro_publicar = {$this->parceiro_publicar}"
                    . " WHERE parceiro_id = {$this->parceiro_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->parceiro_id = \DL::$bd_pdo->lastInsertID('parceiro_id');
        
        return $this->parceiro_id;
    } // Fim do método _salvar
	
	/**
     * Remover o registro
     */
    protected function _remover(){
        $rem = \DL::$bd_pdo->exec("DELETE FROM {$this->bd_tabela} WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        if( $rem === false && property_exists($this, $this->modelo_delete) )
            $rem = \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET {$this->modelo_delete} = 1 WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
            
        # Remover o logotipo desse parceiro
        unlink($this->parceiro_imagem);
            
        return (int)$rem;
    } // Fim do método _remover
} // Fim da classe Parceiro
