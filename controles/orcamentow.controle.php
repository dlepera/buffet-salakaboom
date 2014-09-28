<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 30, 2014 5:45:16 PM
 */

namespace Controle;

class OrcamentoW extends Principal{
    public function __construct(){
        parent::__construct('/site/');
        
        # Configurar esse Controle
        $this->obj_m = new \Modelo\Orcamento();
        $this->str_m = TXT_MODELO_ORCAMENTO;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'                => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'info_nome'         => FILTER_SANITIZE_STRING,
                'info_email'        => FILTER_SANITIZE_EMAIL,
                'info_telefone'     => FILTER_SANITIZE_STRING,
                'festa_data'        => FILTER_SANITIZE_STRING,
                'festa_pacote'      => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'festa_convidados'  => FILTER_SANITIZE_NUMBER_INT,
                'opcionais'         => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_REQUIRE_ARRAY)
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
    
    public function _formulario(){
        # Preparar a visão
        $this->_escolhertpl('orcamento');
        $this->obj_v->_titulo(TXT_TITULO_ORCAMENTO_ON_LINE);
        
        # Selecionar a lista de pacotes de festas
        $mod_p = new \Modelo\Produto();
        $lis_f = $mod_p->_listar('produto_publicar = 1 AND produto_tipo = 1', null, 'produto_id, produto_nome');
        $lis_o = $mod_p->_listar('produto_publicar = 1 AND produto_tipo = 2', null, 'produto_id, produto_nome, produto_descr');
        
        # Incluir os parâmetros
        $this->obj_v->_incluirparams('festas', $lis_f);
        $this->obj_v->_incluirparams('opcionais', $lis_o);
    } // Fim do metodo _formulario
    
    public function _enviar(){
        $id = $this->obj_m->_salvar();
        
        # Enviar o e-mail
        $obj_e = new \Email();
        $obj_e->_enviar("{$this->obj_m->orcamento_info_email};buffetsalakaboom@yahoo.com.br", '['. \DL::$ap_nome .'] Orcamento on-line', $this->_emailhtml($id));
        $obj_e->_gravarlog(__CLASS__, $this->obj_m->bd_tabela, $this->obj_m->orcamento_id);
        
        return \Funcoes::_retornar(SUCESSO_ORCAMENTO_ENVIAR, 'sucesso');
    } // Fim do método _enviar
    
    /**
     * Obter o HTML do corpo do e-mail
     * 
     * @param int $id - ID do contato enviado
     */
    public function _emailhtml($id){
        # Preparar a visão
        $obj_v = new \Visao('/emails/');
        $obj_v->_template('orcamento');
        
        # Carregar o modelo com as informações do contato
        $this->obj_m->_selecionarID((int)$id);
        
        $mod_p  = new \Modelo\Produto($this->obj_m->orcamento_festa_pacote);
        $lis_op = $mod_p->_listaropcionais(
            $this->obj_m->orcamento_id, 
            null, 
            "P.produto_nome, O.opcional_orcamento_qtde, REPLACE(O.opcional_orcamento_valor, '.', ',') AS opcional_orcamento_valor"
        );
        
        # Incluir os parâmetros no template
        $obj_v->_incluirparams('modelo', $this->obj_m);
        $obj_v->_incluirparams('produto', $mod_p);
        $obj_v->_incluirparams('opcionais', $lis_op);
        
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
} // Fim do Controle OrcamentoW
