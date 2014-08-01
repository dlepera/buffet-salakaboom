<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 29, 2014 5:39:00 PM
 */

namespace Controle;

class CardapioW extends Principal{
    public function __construct(){
        parent::__construct('/site/');
        
        # Configurar esse Controle
        $this->obj_m = new \Modelo\Cardapio();
        $this->str_m = TXT_MODELO_CARDAPIO;
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    public function _lista(){
        # Preparar a vis�o
        $this->_escolhertpl('cardapio');
        $this->obj_v->_titulo(TXT_TITULO_CARDAPIO);
        
        # Selecionar a lista de �lbuns
        $lis_c = $this->obj_m->_listar('cardapio_publicar = 1', 'cardapio_ordem, cardapio_titulo', 'cardapio_id, cardapio_titulo, cardapio_descr');
        
        # Incluir os par�metros
        $this->obj_v->_incluirparams('cardapios', $lis_c);
        $this->obj_v->_incluirparams('item', new \Modelo\ItemCardapio());
    } // Fim do m�todo _lista
} // Fim do Controle CardapioW
