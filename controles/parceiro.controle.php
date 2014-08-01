<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 30, 2014 2:55:25 PM
 */

namespace Controle;

class Parceiro extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Parceiro();
        $this->str_m    = TXT_MODELO_PARCEIRO;
        $this->perm_m   = 13;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'tipo'      => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'nome'      => FILTER_SANITIZE_STRING,
                'descr'     => FILTER_SANITIZE_STRING,
                'email'     => FILTER_SANITIZE_EMAIL,
                'telefone'  => FILTER_SANITIZE_STRING,
                'site'      => FILTER_SANITIZE_URL,
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
        $this->_escolhertpl('salakaboom/lista_parceiros', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_PARCEIROS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'TP.tipo_parceiro_descr, P.parceiro_nome', 
            "P.parceiro_id, P.parceiro_nome, P.parceiro_site, TP.tipo_parceiro_descr,"
            . " ( CASE P.parceiro_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'parceiro_nome', 'label' => TXT_LABEL_NOME),
            array('descr' => 'parceiro_site', 'label' => TXT_LABEL_SITE)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('salakaboom/form_parceiro', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_PARCEIROS);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        # Selecionar os tipos de parceiros
        $mod_tp = new \Modelo\TipoParceiro();
        $lis_tp = $mod_tp->_listar('tipo_parceiro_publicar = 1', 'tipo_parceiro_descr', 'tipo_parceiro_id, tipo_parceiro_descr');
        
        # Incluir esse parâmetro
        $this->obj_v->_incluirparams('tipos', $lis_tp);
        
        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do Controle PrincipalSistema
