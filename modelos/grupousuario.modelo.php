<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/05/2014 16:07:59
 */

namespace Modelo;

class GrupoUsuario extends Principal{
    protected $grupo_usuario_id, $grupo_usuario_descr, $grupo_usuario_publicar = 1, $grupo_usuario_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_painel_grupos_usuarios', 'grupo_usuario_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $grupo_usuario_descr
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $grupo_usuario_descr
     * 
     * @return string: valor da propriedade $grupo_usuario_descr
     */
    public function _grupo_usuario_descr($valor=null){
        return is_null($valor) ?
            (string)$this->grupo_usuario_descr
        : $this->grupo_usuario_descr = (string)$valor;
    } // Fim do método _grupo_usuario_descr
        
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        if( !$this->grupo_usuario_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " grupo_usuario_descr, grupo_usuario_publicar) VALUES ("
                    . " '{$this->grupo_usuario_descr}', {$this->grupo_usuario_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " grupo_usuario_descr = '{$this->grupo_usuario_descr}',"
                    . " grupo_usuario_publicar = {$this->grupo_usuario_publicar}"
                    . " WHERE grupo_usuario_id = {$this->grupo_usuario_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->grupo_usuario_id = \DL::$bd_pdo->lastInsertID('grupo_usuario_id');
        
        return $this->grupo_usuario_id;
    } // Fim do método _salvar
} // Fim do modelo GrupoUsuario
