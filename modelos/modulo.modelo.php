<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/05/2014 16:55:06
 */

namespace Modelo;

class Modulo extends Principal{
    protected $modulo_id, $modulo_pai = null, $modulo_nome, $modulo_descr, $modulo_link, $modulo_publicar = '1', $modulo_ordem = 0, $modulo_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_painel_modulos', 'modulo_');
        
        # Query de seleção
        $this->bd_select = "SELECT"
            . " %s"
            . " FROM %s AS M"
            . " LEFT JOIN {$this->bd_tabela} AS P ON( P.modulo_id = M.modulo_pai )"
            . " WHERE M.%sdelete = 0";

        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $modulo_pai
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $modulo_pai
     * 
     * @return string: valor da propriedade $modulo_pai
     */
    public function _modulo_pai($valor=null){
        return is_null($valor) ?
            (int)$this->modulo_pai
        : $this->modulo_pai = $valor > 0 ? (int)$valor : NULL;
    } // Fim do método _modulo_pai
    
    /**
     * Obter ou editar o valor da propriedade $modulo_nome
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $modulo_nome
     * 
     * @return string: valor da propriedade $modulo_nome
     */
    public function _modulo_nome($valor=null){
        return is_null($valor) ?
            (string)$this->modulo_nome
        : $this->modulo_nome = (string)$valor;
    } // Fim do método _modulo_nome
    
    /**
     * Obter ou editar o valor da propriedade $modulo_descr
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $modulo_descr
     * 
     * @return string: valor da propriedade $modulo_descr
     */
    public function _modulo_descr($valor=null){
        return is_null($valor) ?
            (string)$this->modulo_descr
        : $this->modulo_descr = (string)$valor;
    } // Fim do método _modulo_descr
    
    /**
     * Obter ou editar o valor da propriedade $modulo_link
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $modulo_descr
     * 
     * @return string: valor da propriedade $modulo_link
     */
    public function _modulo_link($valor=null){
        return is_null($valor) ?
            (string)$this->modulo_link
        : $this->modulo_link = (string)trim($valor, '/');
    } // Fim do método _modulo_link
    
    /**
     * Obter ou editar o valor da propriedade $modulo_ordem
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $modulo_ordem
     * 
     * @return string: valor da propriedade $modulo_ordem
     */
    public function _modulo_ordem($valor=null){
        return is_null($valor) ?
            (int)$this->modulo_ordem
        : $this->modulo_ordem = (int)$valor;
    } // Fim do método _modulo_descr
    
    protected function _selecionarID($id){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);
        
        # Garantir que o ID seja um número inteiro
        $id = (int)$id;
        
        $lis_m = end($this->_listar("M.{$this->modelo_id} = {$id}", null, 'M.*'));
        
        # Carregar os dados obtidos do banco de dados
        # nas propriedades da classe
        foreach( $lis_m as $c => $m ):
            if( property_exists($this, $c) )
               $this->{$c} = $m;
        endforeach;
    } // Fim do método _selecionarID
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        if( !$this->modulo_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " modulo_pai, modulo_nome, modulo_descr, modulo_link, modulo_ordem, modulo_publicar) VALUES ("
                    . " ". var_export($this->modulo_pai, true) .", '{$this->modulo_nome}', '{$this->modulo_descr}', '{$this->modulo_link}', {$this->modulo_ordem}, {$this->modulo_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " modulo_pai = ". var_export($this->modulo_pai, true) .","
                    . " modulo_nome = '{$this->modulo_nome}',"
                    . " modulo_descr = '{$this->modulo_descr}',"
                    . " modulo_link = '{$this->modulo_link}',"
                    . " modulo_ordem = {$this->modulo_ordem},"
                    . " modulo_publicar = {$this->modulo_publicar}"
                    . " WHERE modulo_id = {$this->modulo_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->modulo_id = \DL::$bd_pdo->lastInsertID('modulo_id');
        
        return $this->modulo_id;
    } // Fim do método _salvar
} // Fim do modelo Modulo
