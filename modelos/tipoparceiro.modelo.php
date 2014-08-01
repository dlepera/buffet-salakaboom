<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 03/01/2014
 */
 
namespace Modelo;

class TipoParceiro extends Principal{
	# Propriedades do parceiro
	protected $tipo_parceiro_id, $tipo_parceiro_descr, $tipo_parceiro_publicar = 1, $tipo_parceiro_delete = 0;
		
	public function __construct($id=0){
        parent::__construct('salakaboom_parceiros_tipos', 'tipo_parceiro_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do mйtodo mбgico de construзгo da classe
	
    /**
     * Obter ou editar o valor da propriedade $tipo_parceiro_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuнdo а $this->tipo_parceiro_descr
     * 
     * @return string: valor da propriedade $tipo_parceiro_descr
     */
    public function _tipo_parceiro_descr($valor=null){
        return is_null($valor) ?
            (string)$this->tipo_parceiro_descr        
        : $this->tipo_parceiro_descr = (string)$valor;
    } // Fim do mйtodo _tipo_parceiro_descr
    
	/**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro serб salvo ou apenas
     * serб gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->tipo_parceiro_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " tipo_parceiro_descr, tipo_parceiro_publicar) VALUES ("
                    . " '{$this->tipo_parceiro_descr}', {$this->tipo_parceiro_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " tipo_parceiro_descr = '{$this->tipo_parceiro_descr}',"
                    . " tipo_parceiro_publicar = {$this->tipo_parceiro_publicar}"
                    . " WHERE tipo_parceiro_id = {$this->tipo_parceiro_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a aзгo executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->tipo_parceiro_id = \DL::$bd_pdo->lastInsertID('tipo_parceiro_id');
        
        return $this->tipo_parceiro_id;
    } // Fim do mйtodo _salvar
} // Fim da classe TipoParceiro
	
?>