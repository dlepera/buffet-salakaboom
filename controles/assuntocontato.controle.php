<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/06/2014 15:51:22
 */

namespace Controle;

class AssuntoContato extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\AssuntoContato();
        $this->str_m    = TXT_MODELO_ASSUNTOCONTATO;
        $this->perm_m   = 8;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'descr'     => FILTER_SANITIZE_STRING,
                'email'     => array('filter', FILTER_SANITIZE_EMAIL, 'flags' => FILTER_NULL_ON_FAILURE),
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->_bd_prefixo());
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
        $this->_escolhertpl('website/lista_assuntos', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_ASSUNTOS_DE_CONTATOS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'assunto_contato_descr', 
            "assunto_contato_id, assunto_contato_descr, assunto_contato_email,"
            . " ( CASE assunto_contato_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'assunto_contato_descr', 'label' => TXT_LABEL_DESCRICAO),
            array('nome' => 'assunto_contato_email', 'label' => TXT_LABEL_EMAIL)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('website/form_assunto', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_ASSUNTOS_DE_CONTATOS);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
               
        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do controle AssuntoContato
