<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 1, 2014 11:24:03 AM
 */

namespace Controle;

class ProdutoW extends Principal{
    public function __construct(){
        parent::__construct('/site/');
        
        # Configurar esse Controle
        $this->obj_m = new \Modelo\Produto();
        $this->str_m = TXT_MODELO_PRODUTO;
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Filtrar os pacotes de festa de acordo com a data pretendida
     */
    public function _filtrardata(){
        $data = filter_input(INPUT_POST, 'data', FILTER_DEFAULT);
        //$this->obj_m->_filtrarfesta($data);
        echo json_encode($this->obj_m->_filtrarfesta($data));
    } // Fim do método _filtrardata
    
    /**
     * Obter a quantidade máxima de convidados para um determinado
     * pacotde de festa / produto
     */
    public function _obterqtdemax(){
        $produto = filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_NUMBER_INT);
        echo json_encode($this->obj_m->_qtde_convidados($produto));
    } // Fim do método _obterqtdemax
} // Fim do Controle ProdutoW
