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
            
            # Popular o modelo com as informa��es acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->_bd_prefixo());
        endif;
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Carregar o formul�rio de contato do site
     */
    public function _formulario(){
        # Preparar a vis�o
        $this->_escolhertpl('contato');
        
        # Selecionar a lista de assuntos de e-mails
        $mod_ac = new \Modelo\AssuntoContato();
        $lis_ac = $mod_ac->_listar("assunto_contato_publicar = '1'", 'assunto_contato_descr');
        
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('assuntos', $lis_ac);
    } // Fim do m�todo _formul�rio
    
    /**
     * Salvar o registro do contato e envi�-lo para o e-mail
     * de acordo com o assunto escolhido
     */
    public function _enviar(){
        # Salvar o registro no banco de dados
        $this->obj_m->_salvar();
        
        # Identificar a �rea respos�vel a receber o e-mail
        $mod_ac = new \Modelo\AssuntoContato($this->obj_m->contato_site_assunto);
        
        # Enviar o e-mail
        $obj_e = new \Email();
        $obj_e->_enviar($mod_ac->assunto_contato_email, '['. \DL::$ap_nome .'] '. $mod_ac->assunto_contato_descr, $this->_emailhtml(\DL::$bd_pdo->lastInsertId()));
        $obj_e->_gravarlog(__CLASS__, $this->obj_m->bd_tabela, $this->obj_m->contato_site_id);
        
        return \Funcoes::_retornar(SUCESSO_CONTATOSITE_ENVIAR, 'sucesso');
    } // Fim do m�todo _enviar
    
    /**
     * Obter o HTML do corpo do e-mail
     * 
     * @param int $id - ID do contato enviado
     */
    public function _emailhtml($id){
        # Preparar a vis�o
        $obj_v = new \Visao('/emails/');
        $obj_v->_template('contato');
        
        # Carregar o modelo com as informa��es do contato
        $this->obj_m->_selecionarID((int)$id);
        
        # Selecionar o assunto
        $mod_ac = new \Modelo\AssuntoContato($this->obj_m->contato_site_assunto);
        
        # Incluir os par�metros no template
        $obj_v->_incluirparams('modelo', $this->obj_m);
        $obj_v->_incluirparams('assunto', $mod_ac);
        
        return $obj_v->_conteudo();
    } // Fim do m�todo _emailhtml
    
    /**
     * Mostrar o HTML obtido pelom�todo _emailhtml
     * 
     * @param int $id - ID do contato enviado
     */
    public function _mostrarhtml($id){
        echo $this->_emailhtml((int)$id);
    } // Fim do m�todo _mostrarhtml
} // Fim do Controle ContatoSite
