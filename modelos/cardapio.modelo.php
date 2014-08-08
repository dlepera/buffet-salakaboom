<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 03/04/2014
 */

namespace Modelo;
 
class Cardapio extends Principal{
	# Propriedades de tipos de cardápios do site
	protected $cardapio_id, $cardapio_titulo, $cardapio_descr, $cardapio_ordem = 99, $cardapio_publicar = 1, $cardapio_delete = 0;
		
	public function __construct($id=0){
        parent::__construct('salakaboom_cardapios', 'cardapio_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
	
    /**
     * Obter ou editar o valor da propriedade $cardapio_titulo
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->cardapio_titulo
     * 
     * @return string: valor da propriedade $cardapio_titulo
     */
    public function _cardapio_titulo($valor=null){
        return is_null($valor) ?
            (string)$this->cardapio_titulo        
        : $this->cardapio_titulo = (string)$valor;
    } // Fim do método _cardapio_titulo
    
    /**
     * Obter ou editar o valor da propriedade $cardapio_descr
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->cardapio_descr
     * 
     * @return string: valor da propriedade $cardapio_descr
     */
    public function _cardapio_descr($valor=null){
        return is_null($valor) ?
            (string)$this->cardapio_descr        
        : $this->cardapio_descr = (string)$valor;
    } // Fim do método _cardapio_descr
    
    /**
     * Obter ou editar o valor da propriedade $cardapio
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $this->cardapio_ordem
     * 
     * @return int: valor da propriedade $cardapio_ordem
     */
    public function _cardapio_ordem($valor=null){
        return is_null($valor) ?
            (int)$this->cardapio_ordem        
        : $this->cardapio_ordem = (int)$valor;
    } // Fim do método _cardapio_ordem
    
	/**
     * Salvar determinado registro
     * 
     * @param boolean $salvar - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->cardapio_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " cardapio_titulo, cardapio_descr, cardapio_ordem, cardapio_publicar) VALUES ("
                    . " '{$this->cardapio_titulo}', '{$this->cardapio_descr}', {$this->cardapio_ordem}, {$this->cardapio_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " cardapio_titulo = '{$this->cardapio_titulo}',"
                    . " cardapio_descr = '{$this->cardapio_descr}',"
                    . " cardapio_ordem = {$this->cardapio_ordem},"
                    . " cardapio_publicar = {$this->cardapio_publicar}"
                    . " WHERE cardapio_id = {$this->cardapio_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->cardapio_id = \DL::$bd_pdo->lastInsertID('cardapio_id');
        
        return $this->cardapio_id;
    } // Fim do método _salvar
} // Fim da classe Cardapio
