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
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico de __destruicao
    
    public function _home(){
        # Preparar a vis�o
        $this->_escolhertpl('home', array());
        $this->obj_v->_titulo(\DL::$ap_nome);
    } // Fim do m�todo _home
} // Fim do controle PainelDL
