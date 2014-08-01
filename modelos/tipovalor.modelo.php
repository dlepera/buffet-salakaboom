<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 08/01/2014
 */
 
namespace Modelo;

class TipoValor extends Principal{
	# Propriedades do modelo
	protected $tipo_valor_id, $tipo_valor_descr, $tipo_valor_fator, $tipo_valor_delete = 0;
	
	public function __construct($id=0){
        parent::__construct('salakaboom_produtos_tipos_valores', 'tipo_valor_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
	
    /**
     * Obter ou editar o valor da propriedade $tipo_valor_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->tipo_valor_descr
     * 
     * @return string: valor da propriedade $tipo_valor_descr
     */
    public function _tipo_valor_descr($valor=null){
        return is_null($valor) ?
            (string)$this->tipo_valor_descr        
        : $this->tipo_valor_descr = (string)$valor;
    } // Fim do método _tipo_valor_descr
    
    /**
     * Obter ou editar o valor da propriedade $tipo_valor_fator
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->tipo_valor_fator
     * 
     * @return int - valor da propriedade $tipo_valor_fator
     */
    public function _tipo_valor_fator($valor=null){
        return is_null($valor) ?
            (int)$this->tipo_valor_fator        
        : $this->tipo_valor_fator = (int)$valor;
    } // Fim do método _tipo_valor_fator
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->tipo_valor_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " tipo_valor_descr, tipo_valor_fator) VALUES ("
                    . " '{$this->tipo_valor_descr}', {$this->tipo_valor_fator})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " tipo_valor_descr = '{$this->tipo_valor_descr}',"
                    . " tipo_valor_fator = {$this->tipo_valor_fator},"
                    . " WHERE tipo_valor_id = {$this->tipo_valor_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->tipo_valor_id = \DL::$bd_pdo->lastInsertID('tipo_valor_id');
        
        return $this->tipo_valor_id;
    } // Fim do método _salvar
} // Fim da classe TipoValor
