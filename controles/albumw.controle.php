<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 28, 2014 12:33:07 PM
 */

namespace Controle;

class AlbumW extends Principal{
    public function __construct(){
        parent::__construct('/site/');
        
        # Configurar esse Controle
        $this->obj_m = new \Modelo\Album();
        $this->str_m = TXT_MODELO_ALBUM;
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('albuns_fotos');
        $this->obj_v->_titulo(TXT_TITULO_ALBUNS_DE_FOTOS);
        
        # Tratar o número da página
        $_get_pg = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_NUMBER_INT);
        
        # Selecionar a lista de álbuns
        $lis_a = $this->obj_m->_listar('A.album_publicar = 1', 'A.album_nome', 'A.album_id, A.album_nome, F.foto_album_imagem', $_get_pg, 12);
        
        # Incluir os parâmetros
        $this->obj_v->_incluirparams('albuns', $lis_a);
    } // Fim do método _lista
    
    public function _detalhes($id){
        # Selecionar o álbum solicitado
        $this->obj_m->_selecionarID($id);
        
        # Preparar a visão
        $this->_escolhertpl('fotos');
        $this->obj_v->_titulo(TXT_TITULO_ALBUNS_DE_FOTOS);
        
        # Selecionar as fotos do álbum selecionado
        $mod_f = new \Modelo\FotoAlbum();
        $lis_f = $mod_f->_listar("foto_album = {$this->obj_m->album_id}", 'foto_album_capa DESC, foto_album_id DESC', 'foto_album_titulo, foto_album_descr, foto_album_imagem');
        
        # Incluir os parâmetros
        $this->obj_v->_incluirparams('album', $this->obj_m);
        $this->obj_v->_incluirparams('fotos', $lis_f);
    } // Fim do método _detalhes
} // Fim do Controle AlbumW
