<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Site buffetsalakaboom.com.br
 * @Data	: 09/01/2014
 */

namespace Controle;

class ModeloConvite extends PrincipalSistema{
	public function __construct(){
		parent::__construct('painel-dl');
        
        $this->obj_m    = new \Modelo\ModeloConvite();
		$this->str_m    = TXT_MODELO_MODELOCONVITE;
        $this->perm_m   = 20;

		if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
			# Tratar os dados do $_POST
            $post = filter_input_array(INPUT_POST, array(
                'id'     => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'titulo' => FILTER_SANITIZE_STRING
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->bd_prefixo);
		endif;
	} // Fim do método de construção da classe
    
    /*
	 * Exibir a lista de modelos de convites virtuais
	 */
	public function _lista(){
        # Preparar a visão
		$this->_escolhertpl('convites/lista_modelos', array('ver'));
		$this->obj_v->_titulo(TXT_TITULO_MODELOS_DE_CONVITES_VIRTUAIS);
        
        $this->_listapadrao(
            'modelo_convite_titulo',
            "modelo_convite_id, modelo_convite_titulo,"
            . " ( CASE modelo_convite_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
        
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'modelo_convite_titulo', 'label' => TXT_LABEL_TITULO)
        ));
	} // Fim do método _lista
    
    /*
	 * Formulário de criação e edição dos modelos para a área
     * de convites virtuais
	 */
	public function _formulario($id=0){
		if( $id > 0 )
			$this->obj_m->_selecionarID((int)$id);
		
        # Preparar a visão
		$this->_escolhertpl('convites/form_modelo', array('incluir', 'editar'));
		$this->obj_v->_titulo(TXT_TITULO_MODELOS_DE_CONVITES_VIRTUAIS);
        
        $this->_formpadrao();
	} // Fim do método _formulario
} // Fim do Controle ModeloConvite
