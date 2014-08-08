<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 4, 2014 1:00:56 PM
 */

namespace Controle;

class DepoimentoW extends Principal{
    public function __construct(){
        parent::__construct('site');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Depoimento();
        $this->str_m    = TXT_MODELO_DEPOIMENTO;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'nome'      => FILTER_SANITIZE_STRING,
                'texto'     => FILTER_SANITIZE_STRING
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
                    
            # Popular o modelo com as informa��es acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->bd_prefixo);
        endif;
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Lista de depoimentos
     */
    public function _lista(){
        # Preparar a vis�o
        $this->_escolhertpl('lista_depoimentos');
        $this->obj_v->_titulo(TXT_TITULO_DEPOIMENTOS);
                
        $this->_listapadrao(
            'log_registro_data_criacao DESC',
            'depoimento_nome, depoimento_texto, log_registro_data_criacao AS data'
        );
    } // Fim do m�todo _lista
    
    /**
     * Formul�rio para inclus�o 
     */
    public function _formulario(){
        $this->obj_v->_template('_form_depoimento');
    } // Fim do m�todo _formulario
    
    /**
     * Enviar o depoimento
     */
    public function _enviar(){
        $this->obj_m->_salvar();
        \Funcoes::_retornar(SUCESSO_DEPOIMENTO_ENVIAR, 'sucesso');
    } // Fim do m�todo _enviar
} // Fim do Controle DepoimentoW
