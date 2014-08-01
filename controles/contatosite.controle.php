<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 16:25:07
 */

namespace Controle;

class ContatoSite extends Principal{
    public function __construct(){
        parent::__construct('/site/');
        
        # Configurar esse Controle
        $this->obj_m = new \Modelo\ContatoSite();
        $this->str_m = TXT_MODELO_CONTATOSITE;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'nome'      => FILTER_SANITIZE_STRING, 
                'email'     => FILTER_SANITIZE_EMAIL,
                'telefone'  => FILTER_SANITIZE_STRING,
                'assunto'   => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'mensagem'  => FILTER_SANITIZE_STRING
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->_bd_prefixo());
        endif;
    } // Fim do método mégico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Carregar o formulário de contato do site
     */
    public function _formulario(){
        # Preparar a visão
        $this->_escolhertpl('contato');
        
        # Selecionar a lista de assuntos de e-mails
        $mod_ac = new \Modelo\AssuntoContato();
        $lis_ac = $mod_ac->_listar("assunto_contato_publicar = '1'", 'assunto_contato_descr');
        
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('assuntos', $lis_ac);
    } // Fim do método _formulário
    
    /**
     * Salvar o registro do contato e enviá-lo para o e-mail
     * de acordo com o assunto escolhido
     */
    public function _enviar(){
        # Salvar o registro no banco de dados
        $this->obj_m->_salvar();
        
        # Identificar a área resposável a receber o e-mail
        $mod_ac = new \Modelo\AssuntoContato($this->obj_m->contato_site_assunto);
        
        # Enviar o e-mail
        $obj_e = new \Email();
        $obj_e->_enviar($mod_ac->assunto_contato_email, '['. \DL::$ap_nome .'] '. $mod_ac->assunto_contato_descr, $this->_emailhtml(\DL::$bd_pdo->lastInsertId()));
        $obj_e->_gravarlog(__CLASS__, $this->obj_m->bd_tabela, $this->obj_m->contato_site_id);
        
        return \Funcoes::_retornar(SUCESSO_CONTATOSITE_ENVIAR, 'sucesso');
    } // Fim do método _enviar
    
    /**
     * Obter o HTML do corpo do e-mail
     * 
     * @param int $id - ID do contato enviado
     */
    public function _emailhtml($id){
        # Preparar a visão
        $obj_v = new \Visao('/emails/');
        $obj_v->_template('contato');
        
        # Carregar o modelo com as informações do contato
        $this->obj_m->_selecionarID((int)$id);
        
        # Selecionar o assunto
        $mod_ac = new \Modelo\AssuntoContato($this->obj_m->contato_site_assunto);
        
        # Incluir os parâmetros no template
        $obj_v->_incluirparams('modelo', $this->obj_m);
        $obj_v->_incluirparams('assunto', $mod_ac);
        
        return $obj_v->_conteudo();
    } // Fim do método _emailhtml
    
    /**
     * Mostrar o HTML obtido pelométodo _emailhtml
     * 
     * @param int $id - ID do contato enviado
     */
    public function _mostrarhtml($id){
        echo $this->_emailhtml((int)$id);
    } // Fim do método _mostrarhtml
} // Fim do Controle ContatoSite
