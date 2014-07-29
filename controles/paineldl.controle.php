<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 28/05/2014 10:11:39
 */

namespace Controle;

class PainelDL extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico de __destruicao
    
    public function _home(){
        # Preparar a visão
        $this->_escolhertpl('home', array());
        $this->obj_v->_titulo(\DL::$ap_nome);
    } // Fim do método _home
} // Fim do controle PainelDL
