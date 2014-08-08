<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 4, 2014 12:47:52 PM
 */

namespace Modelo;

class Depoimento extends Principal{
    protected $depoimento_id, $depoimento_nome, $depoimento_texto, $depoimento_publicar = 0, $depoimento_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('salakaboom_depoimentos', 'depoimento_');
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS D"
            . " INNER JOIN dl_painel_registros_logs AS LR ON( LR.log_registro_idreg = D.depoimento_id AND LR.log_registro_tabela = '{$this->bd_tabela}' )"
            . " WHERE %sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
	
    /**
     * Obter ou editar o valor da propriedade $depoimento_nome
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->depoimento_nome
     * 
     * @return string - valor da propriedade $depoimento_nome
     */
    public function _depoimento_nome($valor=null){
        return is_null($valor) ?
            (string)$this->depoimento_nome        
        : $this->depoimento_nome = (string)$valor;
    } // Fim do método _depoimento_nome
    
    /**
     * Obter ou editar o valor da propriedade $depoimento_texto
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->depoimento_texto
     * 
     * @return string - valor da propriedade $depoimento_texto
     */
    public function _depoimento_texto($valor=null){
        return is_null($valor) ?
            (string)$this->depoimento_texto        
        : $this->depoimento_texto = (string)$valor;
    } // Fim do método _depoimento_texto
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->depoimento_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " depoimento_nome, depoimento_texto) VALUES ("
                    . " '{$this->depoimento_nome}', '{$this->depoimento_texto}')";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    // . " depoimento_nome = '{$this->depoimento_nome}',"
                    // . " depoimento_texto = '{$this->depoimento_texto}',"
                    . " depoimento_publicar = {$this->depoimento_publicar}"
                    . " WHERE depoimento_id = {$this->depoimento_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->depoimento_id = \DL::$bd_pdo->lastInsertID('depoimento_id');
        
        return $this->depoimento_id;
    } // Fim do método _salvar
} // Fim do modelo Depoimento
