<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 6, 2014 6:20:02 PM
 */

namespace Controle;

class EnvioConviteW extends Principal{
    public function __construct(){
        parent::__construct('site');
        
        $this->obj_m    = new \Modelo\EnvioConvite();
		$this->str_m    = TXT_MODELO_ENVIOCONVITE;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
			# Tratar os dados do $_POST
            $post = filter_input_array(INPUT_POST, array(
                'id'                    => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'modelo'                => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'festa_aniversariante'  => FILTER_SANITIZE_STRING,
                'festa_data'            => FILTER_SANITIZE_STRING,
                'festa_inicio'          => FILTER_SANITIZE_STRING,
                'festa_fim'             => FILTER_SANITIZE_STRING,
                'festa_idade'           => FILTER_SANITIZE_NUMBER_INT,
                'convidados_nomes'      => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_REQUIRE_ARRAY),
                'convidados_emails'     => array('filter' => FILTER_SANITIZE_EMAIL, 'flags' => FILTER_REQUIRE_ARRAY)
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->bd_prefixo);
		endif;
    } // Fim do método mágico de construção da classe
    
    /**
     * Salvar o registro
     * 
     * @param boolean $salvar - define se o registro será salvo apenas retornará a
     *  query criada
     * @return int - retorna o ID gerado pela inserção do registro
     */
    public function _salvar($salvar = true){
        return $this->obj_m->_salvar($salvar);
    } // Fim do método _salvar
} // Fim do Controle EnvioConviteW
