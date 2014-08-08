<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 20/01/2014
 */

namespace Controle;

class LoginConvite extends PrincipalSistema{
	public function __construct(){
		parent::__construct('painel-dl');
        
        $this->obj_m    = new \Modelo\LoginConvite();
		$this->str_m    = TXT_MODELO_LOGINCONVITE;
        $this->perm_m   = 21;

		if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
			# Tratar os dados do $_POST
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'usuario'   => FILTER_SANITIZE_STRING,
                'senha'     => FILTER_SANITIZE_STRING,
                'email'     => FILTER_SANITIZE_EMAIL
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->bd_prefixo);
		endif;
	} // Fim do método de construção da classe
	
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
	/**
	 * Fazer o login no convite virtual
	 */
	public function _fazerlogin(){
		$this->obj_m->_fazerlogin();
		return \utilidade::_retornar(__CLASS__ .': linha '. __LINE__, true, SUCESSO_LOGINCONVITE_FAZERLOGIN);
	} // Fim do método _fazerlogin
    
    /*
	 * Exibir a lista de logins de convites virtuais
	 */
	public function _lista(){
        # Preparar a visão
		$this->_escolhertpl('convites/lista_logins', array('ver'));
		$this->obj_v->_titulo(TXT_TITULO_LOGINS_PARA_CONVITE_VIRTUAL);
		
        $this->_listapadrao(
            'login_convite_usuario',
            'login_convite_id, login_convite_usuario, login_convite_email',
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
	} // Fim do método _lista
	
	/*
	 * Formulário de criação e edição dos logins para a área
     * de convites virtuais
	 */
	public function _formulario($id=0){
		if( $id > 0 )
			$this->obj_m->_selecionarID((int)$id);
        
        # Preparar a visão
		$this->_escolhertpl('convites/form_login_convite', array('incluir', 'editar'));
		$this->obj_v->_titulo(TXT_TITULO_LOGINS_PARA_CONVITE_VIRTUAL);
        
        $this->_formpadrao();
	} // Fim do método _formulario
} // Fim da classe LoginConvite
