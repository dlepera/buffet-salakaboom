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
    } // Fim do m�todo m�gico __conStruct
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Mostrar a p�gina inicial do site
     */
    public function _index(){
        # Preparar a vis�o
        $this->_escolhertpl('home');
        $this->obj_v->_titulo(TXT_TITULO_PAGINA_INICIAL);
    } // Fim do m�todo _index
    
    /**
     * Mostrar a p�gina institucional
     */
    public function _institucional(){
        # Preparar a vis�o
        $this->_escolhertpl('institucional');
        $this->obj_v->_titulo(TXT_TITULO_INSTITUCIONAL);
    } // Fim do m�todo _index
} // Fim da classe WebSite
