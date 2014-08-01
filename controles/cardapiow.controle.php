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
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('cardapio');
        $this->obj_v->_titulo(TXT_TITULO_CARDAPIO);
        
        # Selecionar a lista de álbuns
        $lis_c = $this->obj_m->_listar('cardapio_publicar = 1', 'cardapio_ordem, cardapio_titulo', 'cardapio_id, cardapio_titulo, cardapio_descr');
        
        # Incluir os parâmetros
        $this->obj_v->_incluirparams('cardapios', $lis_c);
        $this->obj_v->_incluirparams('item', new \Modelo\ItemCardapio());
    } // Fim do método _lista
} // Fim do Controle CardapioW
