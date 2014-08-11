<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/05/2014 19:16:07
 */

namespace Controle;

class ConfigEmail extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\ConfigEmail();
        $this->str_m    = TXT_MODELO_CONFIGEMAIL;
        $this->perm_m   = 3;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'titulo'    => FILTER_SANITIZE_STRING, 
                'host'      => FILTER_SANITIZE_STRING,
                'porta'     => FILTER_SANITIZE_NUMBER_INT,
                'autent'    => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'cripto'    => FILTER_SANITIZE_STRING,
                'conta'     => FILTER_SANITIZE_STRING,
                'senha'     => FILTER_SANITIZE_STRING,
                'de_email'  => FILTER_SANITIZE_EMAIL,
                'de_nome'   => FILTER_SANITIZE_STRING,
                'responder_para'    => FILTER_SANITIZE_EMAIL,
                'html'      => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'principal' => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
        
            # Tratar as flags
            $post['autent']     = (int)$post['autent'];
            $post['html']       = (int)$post['html'];
            $post['principal']  = (int)$post['principal'];
        
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->_bd_prefixo());
        endif;
    } // Fim do método mégico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Exibir a lista de registros
     */
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('admin/lista_emails', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_CONFIGURACOES_DE_EMAILS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'config_email_titulo',
             "config_email_id, config_email_titulo, config_email_host, config_email_porta,"
            . " ( CASE config_email_principal"
            . " WHEN '0' THEN 'Não'"
            . " WHEN '1' THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PRINCIPAL",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
        
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'config_email_titulo', 'label' => TXT_LABEL_TITULO),
            array('nome' => 'config_email_host', 'label' => TXT_LABEL_HOST),
            array('nome' => 'config_email_porta', 'label' => TXT_LABEL_PORTA)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id - ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('admin/form_email', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_CONFIGURACOES_DE_EMAILS);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        $this->_formpadrao();
    } // Fim do método _formulario
    
    /**
     * Testar o envio de e-mails
     * 
     * @param int $id - ID da configuração de envio de e-mails a ser testada
     */
    public function _testar($id){
        # Iniciar instancia de e-mail
        $obj_e = new \Email();
        
        $obj_v = new \Visao('emails');
        $obj_v->_template('teste_config');
        $corpo = $obj_v->_conteudo();
        
        # Enviar o e-mail
        return !$obj_e->_enviar('teste@teste.com.br', TXT_EMAIL_ASSUNTO_TESTE, $corpo, $id) ?
            \Funcoes::_retornar(sprintf(ERRO_CONFIGEMAIL_TESTAR, $obj_e->_exibirlog()), 'erro')
        : \Funcoes::_retornar(SUCESSO_CONFIGEMAIL_TESTAR, 'sucesso');
    } // Fim do método testar
} // Fim do Controle ConfigEmail
