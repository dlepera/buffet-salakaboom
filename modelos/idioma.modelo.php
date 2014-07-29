<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/05/2014 16:41:20
 */

namespace Modelo;

class Idioma extends Principal{
    protected $idioma_id, $idioma_descr, $idioma_sigla, $idioma_publicar = 1, $idioma_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_painel_idiomas', 'idioma_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $idioma_descr
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $idioma_descr
     * 
     * @return string: valor da propriedade $idioma_descr
     */
    public function _idioma_descr($valor=null){
        return is_null($valor) ?
            (string)$this->idioma_descr
        : $this->idioma_descr = (string)$valor;
    } // Fim do método _idioma_descr
    
    /**
     * Obter ou editar o valor da propriedade $idioma_sigla
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $idioma_sigla
     * 
     * @return string: valor da propriedade $idioma_sigla
     */
    public function _idioma_sigla($valor=null){
        if( is_null($valor) )
            return $this->idioma_sigla;
        
        # Validar o formato da sigla do idioma
        if( !preg_match('~^[a-z]{2}\-[A-Z]{2}~', $valor) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->idioma_sigla = (string)$valor;
    } // Fim do método _idioma_descr
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        if( !$this->idioma_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " idioma_descr, idioma_sigla, idioma_publicar) VALUES ("
                    . " '{$this->idioma_descr}', '{$this->idioma_sigla}', {$this->idioma_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " idioma_descr = '{$this->idioma_descr}',"
                    . " idioma_sigla = '{$this->idioma_sigla}',"
                    . " idioma_publicar = {$this->idioma_publicar}"
                    . " WHERE idioma_id = {$this->idioma_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->idioma_id = \DL::$bd_pdo->lastInsertID('idioma_id');
        
        return $this->idioma_id;
    } // Fim do método _salvar
} // Fim do modelo Idioma
