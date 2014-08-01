<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 30, 2014 5:35:01 PM
 */

namespace Controle;

class ParceiroW extends Principal{
    public function __construct(){
        parent::__construct('/site/');
        
        # Configurar esse Controle
        $this->obj_m = new \Modelo\Parceiro();
        $this->str_m = TXT_MODELO_PARCEIRO;
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    public function _lista(){
        # Preparar a vis�o
        $this->_escolhertpl('parceiros');
        $this->obj_v->_titulo(TXT_TITULO_PARCEIROS);
        
        # Selecionar a lista de �lbuns
        $mod_tp = new \Modelo\TipoParceiro();
        $lis_tp = $mod_tp->_listar('tipo_parceiro_publicar = 1', 'tipo_parceiro_descr', 'tipo_parceiro_id, tipo_parceiro_descr');
        
        # Incluir os par�metros
        $this->obj_v->_incluirparams('tipos', $lis_tp);
        $this->obj_v->_incluirparams('modelo', $this->obj_m);
    } // Fim do m�todo _lista
} // Fim do Controle ParceiroW
