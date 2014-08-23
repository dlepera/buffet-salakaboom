<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 19/05/2014 18:28:19
 */

namespace Controle;

class WebSite extends Principal{
    public function __construct($raiz='/site/'){
        parent::__construct($raiz);
    } // Fim do método mágico __conStruct
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Mostrar a página inicial do site
     */
    public function _index(){
        # Preparar a visão
        $this->_escolhertpl('home');
        $this->obj_v->_titulo(TXT_TITULO_PAGINA_INICIAL);
        
        # Selecionar os banners a serem exibidos na página inicial
        $dir_banners    = './aplicacao/uploads/banners/';
        $scan_banners   = array_map(
            create_function('&$v', 'return $v = "'. $dir_banners .'{$v}";'),
            preg_grep('~^[^\.]~', scandir($dir_banners))
        );
        
        # Selecionar um depoimento aleatório
        $mod_d = new \Modelo\Depoimento();
        $lis_d = end($mod_d->_listar('depoimento_publicar = 1', 'RAND()', 'depoimento_nome, depoimento_texto, log_registro_data_criacao AS data', 1, 1));
        
        # Incluir os parâmetros na página
        $this->obj_v->_incluirparams('depoimento', $lis_d);
        $this->obj_v->_incluirparams('banners', $scan_banners);
    } // Fim do método _index
    
    /**
     * Mostrar a página institucional
     */
    public function _institucional(){
        # Preparar a visão
        $this->_escolhertpl('institucional');
        $this->obj_v->_titulo(TXT_TITULO_INSTITUCIONAL);
        
        # Selecionar 4 fotos aleatórios para exibir na página
        $mod_f = new \Modelo\FotoAlbum();
        $lis_f = $mod_f->_listar('foto_album_publicar = 1', 'RAND()', 'foto_album_imagem', 1, 4);
        
        # Incluir parâmetros na visão
        $this->obj_v->_incluirparams('fotos', $lis_f);
    } // Fim do método _index
} // Fim da classe WebSite
