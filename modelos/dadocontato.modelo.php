<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/06/2014 21:07:59
 */

namespace Modelo;

class DadoContato extends Principal{
    # Propriedades do modelo
    protected $dado_contato_id, $dado_contato_tipo, $dado_contato_descr, $dado_contato_publicar = 1, $dado_publicar_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_site_dados_contato', 'dado_contato_');
        
        # Query de seleção
        $this->bd_select = "SELECT"
            . " %s"
            . " FROM %s AS DC"
            . " INNER JOIN {$this->bd_tabela}_tipos AS TD ON( TD.tipo_dado_id = DC.dado_contato_tipo )"
            . " WHERE DC.%sdelete = 0";
            
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $dado_contato_tipo
     * 
     * @param int $valor: string contendo o valor a ser atribuído à $this->dado_contato_tipo
     * 
     * @return int: valor da propriedade $dado_contato_tipo
     */
    public function _dado_contato_tipo($valor=null){
        return is_null($valor) ?
            (int)$this->dado_contato_tipo
        : $this->dado_contato_tipo = (int)$valor;
    } // Fim do método _dado_contato_tipo
    
    /**
     * Obter ou editar o valor da propriedade $dado_contato_descr
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->dado_contato_descr
     * 
     * @return string: valor da propriedade $dado_contato_descr
     */
    public function _dado_contato_descr($valor=null){
        return is_null($valor) ?
            (string)$this->dado_contato_descr
        : $this->dado_contato_descr = (string)$valor;
    } // Fim do método _dado_contato_descr
        
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->dado_contato_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " dado_contato_tipo, dado_contato_descr, dado_contato_publicar) VALUES ("
                    . " '{$this->dado_contato_tipo}', '{$this->dado_contato_descr}', {$this->dado_contato_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " dado_contato_tipo = '{$this->dado_contato_tipo}',"
                    . " dado_contato_descr = '{$this->dado_contato_descr}',"
                    . " dado_contato_publicar = {$this->dado_contato_publicar}"
                    . " WHERE dado_contato_id = {$this->dado_contato_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->dado_contato_id = \DL::$bd_pdo->lastInsertID('dado_contato_id');
        
        return $this->dado_contato_id;
    } // Fim do método _salvar
} // Fim do método DadoContato
