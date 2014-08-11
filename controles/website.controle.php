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
    } // Fim do método _index
    
    /**
     * Mostrar a página institucional
     */
    public function _institucional(){
        # Preparar a visão
        $this->_escolhertpl('institucional');
        $this->obj_v->_titulo(TXT_TITULO_INSTITUCIONAL);
    } // Fim do método _index
} // Fim da classe WebSite
