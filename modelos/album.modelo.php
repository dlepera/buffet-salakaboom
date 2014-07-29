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
            . " LEFT JOIN dl_site_albuns_fotos AS F ON( F.foto_album = A.album_id AND F.foto_album_capa = 1 )";
        
        if( !empty($id) )
            $this->_selecionarID ($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $album_nome
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->album_nome
     * 
     * @return string: valor da propriedade $album_nome
     */
    public function _album_nome($valor=null){
        return is_null($valor) ?
            (string)$this->album_nome        
        : $this->album_nome = (string)$valor;
    } // Fim do método _album_nome
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
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
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->album_id = \DL::$bd_pdo->lastInsertID('album_id');
        
        # Criar o diretório que receberá as imagens desse álbum
        mkdir("./aplicacao/uploads/albuns/{$this->album_id}");
        
        return $this->album_id;
    } // Fim do método _salvar
} // Fim do modelo Album
