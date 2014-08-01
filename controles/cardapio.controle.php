<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 29, 2014 5:55:33 PM
 */

namespace Controle;

class Cardapio extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Cardapio();
        $this->str_m    = TXT_MODELO_CARDAPIO;
        $this->perm_m   = 12;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'titulo'    => FILTER_SANITIZE_STRING,
                'descr'     => FILTER_SANITIZE_STRING,
                'ordem'     => FILTER_SANITIZE_NUMBER_INT,
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->bd_prefixo);
        endif;
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Lista de registros
     */
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('salakaboom/lista_cardapios', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_CARDAPIO);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'cardapio_ordem, cardapio_titulo', 
            "cardapio_id, cardapio_titulo,"
            . " ( CASE cardapio_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'cardapio_titulo', 'label' => TXT_LABEL_TITULO)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('salakaboom/form_cardapio', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_CARDAPIO);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        if( (int)$this->obj_m->cardapio_id > 0 ):
            # Selecionar a lista de itens de cardápio
            $mod_ic = new \Modelo\ItemCardapio();
            $lis_ic = $mod_ic->_listar("item_cardapio = {$this->obj_m->cardapio_id}", 'item_cardapio_descr', 'item_cardapio_id, item_cardapio_descr');

            # Incluir os parâmetros na visão
            $this->obj_v->_incluirparams('itens', $lis_ic);
        endif;

        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do controle Cardapio
