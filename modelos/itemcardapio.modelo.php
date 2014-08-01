<?php

namespace Modelo;

class ItemCardapio extends Principal{
	# Propriedades da Itens de cardápio
	protected $item_cardapio, $item_cardapio_id, $item_cardapio_descr, $item_cardapio_publicar = 1, $item_cardapio_delete = 1;
    
	public function __construct($id=0){
        parent::__construct('salakaboom_cardapios_itens', 'item_cardapio_');
        
        if( !empty($id) )
            $this->_selecionarID ($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $item_cardapio
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $this->item_cardapio
     * 
     * @return int: valor da propriedade $item_cardapio
     */
    public function _item_cardapio($valor=null){
        return is_null($valor) ?
            (int)$this->item_cardapio        
        : $this->item_cardapio = (int)$valor;
    } // Fim do método _cardapio_descr
    
    /**
     * Obter ou editar o valor da propriedade $item_cardapio_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->item_cardapio_descr
     * 
     * @return string: valor da propriedade $item_cardapio_descr
     */
    public function _item_cardapio_descr($valor=null){
        return is_null($valor) ?
            (string)$this->item_cardapio_descr        
        : $this->item_cardapio_descr = (string)$valor;
    } // Fim do método _item_cardapio_descr
		
	/**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->item_cardapio_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " item_cardapio, item_cardapio_descr, item_cardapio_publicar) VALUES ("
                    . " {$this->item_cardapio}, '{$this->item_cardapio_descr}', {$this->item_cardapio_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " item_cardapio = {$this->item_cardapio},"
                    . " item_cardapio_descr = '{$this->item_cardapio_descr}',"
                    . " item_cardapio_publicar = {$this->item_cardapio_publicar}"
                    . " WHERE item_cardapio_id = {$this->item_cardapio_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->item_cardapio_id = \DL::$bd_pdo->lastInsertID('item_cardapio_id');
        
        return $this->item_cardapio_id;
    } // Fim do método _salvar
} // Fim da classe ItemCardapio
