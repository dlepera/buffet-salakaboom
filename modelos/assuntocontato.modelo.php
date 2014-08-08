<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:52:19
 */

namespace Modelo;

class AssuntoContato extends Principal{
    # Propriedades do modelo
    protected $assunto_contato_id, $assunto_contato_descr, $assunto_contato_email, $assunto_contato_publicar = 1,
        $assunto_contato_delete = 0;
 
    public function __construct($id=0){
        parent::__construct('dl_site_assuntos_contato', 'assunto_contato_');
        
        if( !empty($id) )
            $this->_selecionarID ($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $assunto_contato_descr
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->assunto_contato_descr
     * 
     * @return string - valor da propriedade $assunto_contato_descr
     */
    public function _assunto_contato_descr($valor=null){
        return is_null($valor) ?
            (string)$this->assunto_contato_descr        
        : $this->assunto_contato_descr = (string)$valor;
    } // Fim do método _assunto_contato_descr
    
    /**
     * Obter ou editar o valor da propriedade $assunto_contato_email
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->assunto_contato_email
     * 
     * @return string: valor da propriedade $assunto_contato_email
     */
    public function _assunto_contato_email($valor=null){
        if( is_null($valor) )
            return $this->assunto_contato_email;
        
        if( !empty($valor) && !$this->assunto_contato_email = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->assunto_contato_email;
    } // Fim do método _assunto_contato_email
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->assunto_contato_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " assunto_contato_descr, assunto_contato_email, assunto_contato_publicar) VALUES ("
                    . " '{$this->assunto_contato_descr}', '{$this->assunto_contato_email}', {$this->assunto_contato_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " assunto_contato_descr = '{$this->assunto_contato_descr}',"
                    . " assunto_contato_email = '{$this->assunto_contato_email}',"
                    . " assunto_contato_publicar = {$this->assunto_contato_publicar}"
                    . " WHERE assunto_contato_id = {$this->assunto_contato_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->assunto_contato_id = \DL::$bd_pdo->lastInsertID('assunto_contato_id');
        
        return $this->assunto_contato_id;
    } // Fim do método _salvar
} // Fim do modelo AssuntoContato
