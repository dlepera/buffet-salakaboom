<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 24, 2014 4:47:17 PM
 */

namespace Modelo;

class Album extends Principal{
    protected $album_id, $album_nome, $album_publicar = 1, $album_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_site_albuns', 'album_');
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS A"
            . " LEFT JOIN dl_site_albuns_fotos AS F ON( F.foto_album = A.album_id AND F.foto_album_capa = 1 )"
            . " WHERE A.%sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do m�todo m�gico de constru��o da classe
    
    /**
     * Obter ou editar o valor da propriedade $album_nome
     * 
     * @param string $valor : string contendo o valor a ser atribu�do � $this->album_nome
     * 
     * @return string: valor da propriedade $album_nome
     */
    public function _album_nome($valor=null){
        return is_null($valor) ?
            (string)$this->album_nome        
        : $this->album_nome = (string)$valor;
    } // Fim do m�todo _album_nome
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro ser� salvo ou apenas
     * ser� gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->album_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " album_nome, album_publicar) VALUES ("
                    . " '{$this->album_nome}', {$this->album_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " album_nome = '{$this->album_nome}',"
                    . " album_publicar = {$this->album_publicar}"
                    . " WHERE album_id = {$this->album_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a a��o executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->album_id = \DL::$bd_pdo->lastInsertID('album_id');
        
        # Criar o diret�rio que receber� as imagens desse �lbum
        mkdir("./aplicacao/uploads/albuns/{$this->album_id}");
        
        return $this->album_id;
    } // Fim do m�todo _salvar
    
    /**
     * Remover o registro
     */
    protected function _remover(){
        # Primeiramente � necess�rio remover as fotos desse �lbum
        $mod_f = new \Modelo\FotoAlbum();
        $lis_f = $mod_f->_listar("foto_album = {$this->album_id}", null, 'foto_album_id');
        
        foreach( $lis_f as $f ):
            $mod_f->_selecionarID($f['foto_album_id']);
            $mod_f->_remover();
        endforeach;
        
        $rem = \DL::$bd_pdo->exec("DELETE FROM {$this->bd_tabela} WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        if( $rem === false && property_exists($this, $this->modelo_delete) )
            $rem = \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET {$this->modelo_delete} = 1 WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        # Por fim, remover o diret�rio desse �lbum
        # PS.: S� funcionar� se todas as fotos tiverem sido removidas
        # corretamente
        rmdir("./aplicacao/uploads/albuns/{$this->album_id}");
        
        return (int)$rem;
    } // Fim do m�todo _remover
} // Fim do modelo Album
