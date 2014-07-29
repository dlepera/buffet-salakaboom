<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 24, 2014 4:52:21 PM
 */

namespace Modelo;

class FotoAlbum extends Principal{
    protected $foto_album, $foto_album_id, $foto_album_titulo, $foto_album_descr, $foto_album_imagem, $foto_album_capa = 0, $foto_album_publicar = 1,
        $foto_album_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_site_albuns_fotos', 'foto_album_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $foto_album
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $this->foto_album
     * 
     * @return int: valor da propriedade $foto_album
     */
    public function _foto_album($valor=null){
        return is_null($valor) ?
            (int)$this->foto_album        
        : $this->foto_album = (int)$valor;
    } // Fim do método _foto_album
    
    /**
     * Obter ou editar o valor da propriedade $foto_album_titulo
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->foto_album_titulo
     * 
     * @return string: valor da propriedade $foto_album_titulo
     */
    public function _foto_album_titulo($valor=null){
        return is_null($valor) ?
            (string)$this->foto_album_titulo        
        : $this->foto_album_titulo = (string)$valor;
    } // Fim do método _foto_album_titulo
    
    /**
     * Obter ou editar o valor da propriedade $foto_album_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->foto_album_descr
     * 
     * @return string: valor da propriedade $foto_album_descr
     */
    public function _foto_album_descr($valor=null){
        return is_null($valor) ?
            (string)$this->foto_album_descr        
        : $this->foto_album_descr = (string)$valor;
    } // Fim do método _foto_album_descr
    
    /**
     * Obter ou editar o valor da propriedade $foto_album_imagem
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->foto_album_imagem
     * 
     * @return string: valor da propriedade $foto_album_imagem
     */
    public function _foto_album_imagem($valor=null){
        return is_null($valor) ?
            (string)$this->foto_album_imagem        
        : $this->foto_album_imagem = (string)$valor;
    } // Fim do método _foto_album_imagem
    
    /**
     * Obter ou editar o valor da propriedade $foto_album_capa
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $this->foto_album_capa
     * 
     * @return int: valor da propriedade $foto_album_capa
     */
    public function _foto_album_capa($valor=null){
        if( is_null($valor) )
            return (int)$this->foto_album_capa;
        
        if( !empty($valor) && ($valor < 0 || $valor > 1) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);

        return $this->foto_album_capa = (int)$valor;
    } // Fim do método _foto_album_capa
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        # Caso essa foto esteja sendo definida como capa,
        # remover a flag de qualquer outro registro desse
        # álbum
        if( $this->foto_album_capa === 1 )
            \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET foto_album_capa = 0 WHERE foto_album = {$this->foto_album}");
        
        if( !$this->foto_album_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " foto_album, foto_album_imagem, foto_album_capa, foto_album_publicar) VALUES ("
                    . " {$this->foto_album}, '{$this->foto_album_imagem}', {$this->foto_album_capa}, {$this->foto_album_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " foto_album = {$this->foto_album},"
                    . " foto_album_titulo = '{$this->foto_album_titulo}',"
                    . " foto_album_descr = '{$this->foto_album_descr}',"
                    . " foto_album_capa = {$this->foto_album_capa},"
                    . " foto_album_publicar = {$this->foto_album_publicar}"
                    . " WHERE foto_album_id = {$this->foto_album_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->foto_album_id = \DL::$bd_pdo->lastInsertID('foto_album_id');
                
        return $this->foto_album_id;
    } // Fim do método _salvar
    
    /**
     * Remover o registro
     */
    protected function _remover(){
        $rem = \DL::$bd_pdo->exec("DELETE FROM {$this->bd_tabela} WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        if( $rem === false && property_exists($this, $this->modelo_delete) )
            $rem = \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET {$this->modelo_delete} = 1 WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        # Remover essa foto do drive
        unlink($this->foto_album_imagem);
        
        return (int)$rem;
    } // Fim do método _remover
} // Fim do modelo FotoAlbum
