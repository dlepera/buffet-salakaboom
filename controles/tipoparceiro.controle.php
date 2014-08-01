<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 30, 2014 11:38:16 AM
 */

namespace Controle;

class TipoParceiro extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\TipoParceiro();
        $this->str_m    = TXT_MODELO_TIPOPARCEIRO;
        $this->perm_m   = 14;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'descr'     => FILTER_SANITIZE_STRING,
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informa��es atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informa��es acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->bd_prefixo);
        endif;
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Lista de registros
     */
    public function _lista(){
        # Preparar a vis�o
        $this->_escolhertpl('salakaboom/lista_tipos_parceiros', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_TIPOS_DE_PARCEIROS);
        
        # Configurar a lista padr�o
        $this->_listapadrao(
            'tipo_parceiro_descr', 
            "tipo_parceiro_id, tipo_parceiro_descr,"
            . " ( CASE tipo_parceiro_publicar"
            . " WHEN 0 THEN 'N�o'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'tipo_parceiro_descr', 'label' => TXT_LABEL_DESCRICAO)
        ));
    } // Fim do m�todo _lista
    
    /**
     * Carregar o formul�rio de edi��o do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a vis�o
        $this->_escolhertpl('salakaboom/form_tipo_parceiro', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_TIPOS_DE_PARCEIROS);
        
        # Selecionar as informa��es do modelo
        $this->obj_m->_selecionarID($id);
        
        $this->_formpadrao();
    } // Fim do m�todo _formulario
} // Fim do controle TipoParceiro
