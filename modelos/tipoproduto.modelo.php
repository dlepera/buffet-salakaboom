<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 08/01/2014
 */
 
namespace Modelo;

class TipoProduto extends Principal{
	# Propriedades do parceiro
	protected $tipo_produto_id, $tipo_produto_descr, $tipo_produto_delete = 0;
    
	public function __construct($id=0){
        parent::__construct('salakaboom_produtos_tipos', 'tipo_produto_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
		
	/**
     * Obter ou editar o valor da propriedade $tipo_produto_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->tipo_produto_descr
     * 
     * @return string: valor da propriedade $tipo_produto_descr
     */
    public function _tipo_produto_descr($valor=null){
        return is_null($valor) ?
            (string)$this->tipo_produto_descr        
        : $this->tipo_produto_descr = (string)$valor;
    } // Fim do método _tipo_produto_descr
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->tipo_produto_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " tipo_produto_descr) VALUES ("
                    . " '{$this->tipo_produto_descr}')";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " tipo_produto_descr = '{$this->tipo_produto_descr}',"
                    . " WHERE tipo_produto_id = {$this->tipo_produto_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->tipo_produto_id = \DL::$bd_pdo->lastInsertID('tipo_produto_id');
        
        return $this->tipo_produto_id;
    } // Fim do método _salvar
} // Fim da classe TipoProduto
