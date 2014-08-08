<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 5, 2014 3:58:03 PM
 */

namespace Controle;

class TipoDadoContato extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\TipoDadoContato();
        $this->str_m    = TXT_MODELO_TIPODADOCONTATO;
        $this->perm_m   = 11;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'            => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'descr'         => FILTER_SANITIZE_STRING,
                'rede_social'   => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'publicar'      => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
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
        $this->_escolhertpl('website/lista_tipos_dados', array());
        $this->obj_v->_titulo(TXT_TITULO_TIPOS_DE_DADOS_DE_CONTATO);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'tipo_dado_rede_social DESC, tipo_dado_descr', 
            "tipo_dado_id, tipo_dado_descr,"
            . " ( CASE tipo_dado_rede_social"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS REDE_SOCIAL,"
            . " ( CASE tipo_dado_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'tipo_dado_descr', 'label' => TXT_LABEL_DESCRICAO)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('website/form_tipo_dado', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_TIPOS_DE_DADOS_DE_CONTATO);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do Controle TipoDadoContato
