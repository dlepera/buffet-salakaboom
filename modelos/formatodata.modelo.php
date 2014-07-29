<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/05/2014 13:55:52
 */

namespace Modelo;

class FormatoData extends Principal{
    protected $formato_data_id, $formato_data_descr, $formato_data_completo, $formato_data_data, $formato_data_hora,
        $formato_data_publicar = 1, $formato_data_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_painel_formatos_data', 'formato_data_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $formato_data_descr
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $formato_data_descr
     * 
     * @return string: valor da propriedade $formato_data_descr
     */
    public function _formato_data_descr($valor=null){
        return is_null($valor) ?
            (string)$this->formato_data_descr
        : $this->formato_data_descr = (string)$valor;
    } // Fim do método _formato_data_descr
    
    /**
     * Obter ou editar o valor da propriedade $formato_data_completo
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $formato_data_completo
     * 
     * @return string: valor da propriedade $formato_data_completo
     */
    public function _formato_data_completo($valor=null){
        return is_null($valor) ?
            (string)$this->formato_data_completo
        : $this->formato_data_completo = (string)$valor;
    } // Fim do método _formato_data_completo
    
    /**
     * Obter ou editar o valor da propriedade $formato_data_data
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->formato_data_data
     * 
     * @return string: valor da propriedade $formato_data_data
     */
    public function _formato_data_data($valor=null){
        return is_null($valor) ?
            (string)$this->formato_data_data
        : $this->formato_data_data = (string)$valor;
    } // Fim do método _formato_data_data
    
    /**
     * Obter ou editar o valor da propriedade $formato_data_hora
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->formato_data_hora
     * 
     * @return string: valor da propriedade $formato_data_hora
     */
    public function _formato_data_hora($valor=null){
        return is_null($valor) ?
            (string)$this->formato_data_hora
        : $this->formato_data_hora = (string)$valor;
    } // Fim do método _formato_data_hora
        
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        if( !$this->formato_data_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " formato_data_descr, formato_data_completo, formato_data_data, formato_data_hora, formato_data_publicar) VALUES ("
                    . " '{$this->formato_data_descr}', '{$this->formato_data_completo}', '{$this->formato_data_data}',"
                    . " '{$this->formato_data_hora}', {$this->formato_data_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " formato_data_descr = '{$this->formato_data_descr}',"
                    . " formato_data_completo = '{$this->formato_data_completo}',"
                    . " formato_data_data = '{$this->formato_data_data}',"
                    . " formato_data_hora = '{$this->formato_data_hora}',"
                    . " formato_data_publicar = {$this->formato_data_publicar}"
                    . " WHERE formato_data_id = {$this->formato_data_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->formato_data_id = \DL::$bd_pdo->lastInsertID('formato_data_id');
        
        return $this->formato_data_id;
    } // Fim do método _salvar
} // Fim do modelo FormatoData
