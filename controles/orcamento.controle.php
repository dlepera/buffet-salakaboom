<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 31, 2014 3:04:07 PM
 */

namespace Controle;

class Orcamento extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Orcamento();
        $this->str_m    = TXT_MODELO_ORCAMENTO;
        $this->perm_m   = 16;
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Lista de registros
     */
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('salakaboom/lista_orcamentos', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_ORCAMENTOS_ENVIADOS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'O.orcamento_info_nome', 
            "O.orcamento_id, O.orcamento_info_nome, O.orcamento_info_email, P.produto_nome",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'orcamento_info_nome', 'label' => TXT_LABEL_NOME),
            array('nome' => 'orcamento_info_email', 'label' => TXT_LABEL_EMAIL),
            array('nome' => 'produto_descr', 'label' => TXT_LABEL_PACOTE)
        ));
    } // Fim do método _lista
    
    /**
     * Exibir os detalhes de um determinado orçamento
     * 
     * @param int $id - ID do orçamento a ser exibido
     */
    public function _detalhes($id){
        # Selecionar as informações do orcamento
        $this->obj_m->_selecionarID($id);
        
        # Preparar a visão
        $this->_escolhertpl('salakaboom/detalhes_orcamento', array('ver'));
        
        $mod_p  = new \Modelo\Produto($this->obj_m->orcamento_festa_pacote);
        $lis_op = $mod_p->_listaropcionais($this->obj_m->orcamento_id, 'P.produto_nome', 'P.produto_nome, O.opcional_orcamento_qtde');
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('produto', $mod_p);
        $this->obj_v->_incluirparams('opcionais', $lis_op);
        $this->obj_v->_incluirparams('status', new \Modelo\LogEmail('salakaboom_orcamentos', $this->obj_m->orcamento_id));
        
        $this->_formpadrao();
    } // Fim do método _detalhes
} // Fim do Controle Orcamento
