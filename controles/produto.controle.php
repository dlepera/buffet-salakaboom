<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 30, 2014 7:40:13 PM
 */

namespace Controle;

class Produto extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Produto();
        $this->str_m    = TXT_MODELO_PRODUTO;
        $this->perm_m   = 15;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'            => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'tipo'          => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'nome'          => FILTER_SANITIZE_STRING,
                'descr'         => FILTER_SANITIZE_STRING,                
                'valor'         => FILTER_SANITIZE_STRING,
                'tipo_valor'    => FILTER_SANITIZE_NUMBER_INT,
                'dispon'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_REQUIRE_ARRAY),
                'publicar'      => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
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
        $this->_escolhertpl('salakaboom/lista_produtos', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_PRODUTOS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'TP.tipo_produto_descr, P.produto_nome', 
            "P.produto_id, P.produto_nome, REPLACE(P.produto_valor, '.', ',') AS produto_valor, TP.tipo_produto_descr,"
            . " ( CASE P.produto_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'produto_nome', 'label' => TXT_LABEL_NOME),
            array('nome' => 'tipo_produto_descr', 'label' => TXT_LABEL_TIPO),
            array('nome' => 'produto_valor', 'label' => TXT_LABEL_VALOR)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('salakaboom/form_produto', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_PRODUTOS);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        # Selecionar a lista de tipos de produtos
        $mod_tp = new \Modelo\TipoProduto();
        $lis_tp = $mod_tp->_listar(null, 'tipo_produto_descr', 'tipo_produto_id, tipo_produto_descr');
        
        # Selecionar os tipos de valores
        $mod_tv = new \Modelo\TipoValor();
        $lis_tv = $mod_tv->_listar(null, 'tipo_valor_descr', 'tipo_valor_id, tipo_valor_descr');
        
        # Selecionar a lista de dias da semana
        $mod_ds = new \Modelo\DiaSemana();
        $lis_ds = $mod_ds->_listar(null, null, 'dia_semana_id, dia_semana_descr');
        
        # Incluir os parâmetros para a visão
        $this->obj_v->_incluirparams('tipos', $lis_tp);
        $this->obj_v->_incluirparams('tipos_valores', $lis_tv);
        $this->obj_v->_incluirparams('dias', $lis_ds);
        
        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do Controle Produto
