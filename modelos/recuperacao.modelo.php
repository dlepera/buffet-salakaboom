<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 01/07/2014 13:38:07
 */

namespace Modelo;

class Recuperacao extends Principal{
    # Propriedades desse modelo
    protected $recuperacao_id, $recuperacao_usuario, $recuperacao_hash, $recuperacao_status = 'E';
        
    public function __construct($id=0){
        parent::__construct('dl_painel_usuarios_recuperacoes', 'recuperacao_');
        
        # Query de seleção
        $this->bd_select = 'SELECT %s FROM %s';
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico __construct
    
    /**
     * Obter ou editar o valor da propriedade $recuperacao_usuario
     * 
     * @param int $valor: string contendo o valor a ser atribuído à $this->recuperacao_usuario
     * 
     * @return int: valor da propriedade $recuperacao_usuario
     */
    public function _recuperacao_usuario($valor=null){
        return is_null($valor) ?
            (int)$this->recuperacao_usuario
        : $this->recuperacao_usuario = (int)$valor;
    } // Fim do método _recuperacao_usuario
    
    /**
     * Obter ou editar o valor da propriedade $recuperacao_hash
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->recuperacao_hash
     * 
     * @return string: valor da propriedade $recuperacao_hash
     */
    public function _recuperacao_hash($valor=null){
        return is_null($valor) ?
            (string)$this->recuperacao_hash
        : $this->recuperacao_hash = (string)md5(crypt($valor));
    } // Fim do método _recuperacao_hash
    
    /**
     * Obter ou editar o valor da propriedade $recuperacao_status
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->recuperacao_status
     * 
     * @return string: valor da propriedade $recuperacao_status
     */
    public function _recuperacao_status($valor=null){
        if( is_null($valor) )
            return $this->recuperacao_status;
        
        if( !empty($valor) && !in_array($valor, array('E', 'C', 'R', 'X')) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1404);
        
        return $this->recuperacao_status = (string)$valor;
    } // Fim do método _recuperacao_status
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->recuperacao_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " recuperacao_usuario, recuperacao_hash) VALUES ("
                    . " {$this->recuperacao_usuario}, '{$this->recuperacao_hash}')";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " recuperacao_status = '{$this->recuperacao_status}'"
                    . " WHERE recuperacao_id = {$this->recuperacao_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->recuperacao_id = \DL::$bd_pdo->lastInsertID('recuperacao_id');
        
        return $this->recuperacao_id;
    } // Fim do método _salvar
} // Fim do modelo Recuperacao
