<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 5, 2014 11:56:18 AM
 */

namespace Controle;

class Horario extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Horario();
        $this->str_m    = TXT_MODELO_HORARIO;
        $this->perm_m   = 18;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'            => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'dia_semana'    => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'abertura'      => FILTER_SANITIZE_STRING,
                'fechamento'    => FILTER_SANITIZE_STRING,
                'consultar'     => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
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
        $this->_escolhertpl('salakaboom/lista_horarios', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_HORARIOS_DE_ATENDIMENTO);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'H.horario_abertura, H.horario_fechamento', 
            "DS.dia_semana_descr, H.horario_id, H.horario_abertura, H.horario_fechamento, H.horario_consultar,"
            . " ( CASE H.horario_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'dia_semana_descr', 'label' => TXT_LABEL_DIA_DE_SEMANA)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('salakaboom/form_horario', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_HORARIOS_DE_ATENDIMENTO);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        # Selecionar os dias da semana
        $mod_ds = new \Modelo\DiaSemana();
        $lis_ds = $mod_ds->_listar(null, null, 'dia_semana_id, dia_semana_descr');
        
        # Incluir esse parâmetro
        $this->obj_v->_incluirparams('dias', $lis_ds);
        
        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do Controle Horario
