<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/05/2014 15:39:13
 */

namespace Modelo;

class Tema extends Principal{
    # Propriedades desse modelo
    protected $tema_id, $tema_descr, $tema_diretorio, $tema_padrao = 0, $tema_publicar = 1, $tema_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_painel_temas', 'tema_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $tema_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $tema_descr
     * 
     * @return string: valor da propriedade $tema_descr
     */
    public function _tema_descr($valor=null){
        return is_null($valor) ?
            (string)$this->tema_descr
        : $this->tema_descr = (string)$valor;
    } // Fim do método _tema_descr
    
    /**
     * Obter ou editar o valor da propriedade $tema_diretorio
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $tema_diretorio
     * 
     * @return string: valor da propriedade $tema_diretorio
     */
    public function _tema_diretorio($valor=null){
        return is_null($valor) ?
            (string)$this->tema_diretorio
        : $this->tema_diretorio = (string)trim($valor, '/') .'/';
    } // Fim do método _tema_diretorio
    
    /**
     * Obter ou editar o valor da propriedade $tema_padrao
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $tema_padrao
     * 
     * @return int: valor da propriedade $tema_padrao
     */
    public function _tema_padrao($valor=null){
        if( is_null($valor) )
            return (int)$this->tema_padrao;
        
        if( !empty($valor) && ($valor < 0 || $valor > 1) )
            throw new Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->tema_padrao = (int)$valor;
    } // Fim do método _tema_diretorio
        
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        # Se o tema atual foi definido como padrão, qualquer outro
        # que seja defindo como padrão dever ser removida a flag
        \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET tema_padrao = 0");
        
        if( !$this->tema_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " tema_descr, tema_diretorio, tema_padrao, tema_publicar) VALUES ("
                    . " '{$this->tema_descr}', '{$this->tema_diretorio}', '{$this->tema_padrao}', {$this->tema_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " tema_descr = '{$this->tema_descr}',"
                    . " tema_diretorio = '{$this->tema_diretorio}',"
                    . " tema_padrao = {$this->tema_padrao},"
                    . " tema_publicar = {$this->tema_publicar}"
                    . " WHERE tema_id = {$this->tema_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->tema_id = \DL::$bd_pdo->lastInsertID('tema_id');
        
        return $this->tema_id;
    } // Fim do método _salvar
} // Fim do modelo Tema
