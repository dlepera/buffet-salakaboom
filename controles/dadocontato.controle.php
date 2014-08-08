<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/06/2014 21:21:23
 */

namespace Controle;

class DadoContato extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\DadoContato();
        $this->str_m    = TXT_MODELO_DADOCONTATO;
        $this->perm_m   = 7;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'tipo'      => array('filter', FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'descr'     => FILTER_SANITIZE_STRING,
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
        $this->_escolhertpl('website/lista_dados', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_DADOS_PARA_CONTATO);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'TD.tipo_dado_descr', 
            "DC.dado_contato_id, DC.dado_contato_descr, TD.tipo_dado_descr,"
            . " ( CASE DC.dado_contato_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'DC.dado_contato_descr', 'label' => TXT_LABEL_DESCRICAO),
            array('nome' => 'TD.tipo_contato_descr', 'label' => TXT_LABEL_TIPO)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id - ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('website/form_dado', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_DADOS_PARA_CONTATO);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        # Selecionar a lista de tipos de dados para contato
        $mod_td = new \Modelo\TipoDadoContato();
        $lis_td = $mod_td->_listar('tipo_dado_publicar = 1', 'tipo_dado_descr', 'tipo_dado_id, tipo_dado_descr');
        
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('tipos', $lis_td);
        
        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do controle DadoContato
