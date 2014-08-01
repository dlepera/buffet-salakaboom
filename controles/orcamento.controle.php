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
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Lista de registros
     */
    public function _lista(){
        # Preparar a vis�o
        $this->_escolhertpl('salakaboom/lista_orcamentos', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_ORCAMENTOS_ENVIADOS);
        
        # Configurar a lista padr�o
        $this->_listapadrao(
            'O.orcamento_info_nome', 
            "O.orcamento_id, O.orcamento_info_nome, O.orcamento_info_email, P.produto_nome",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'orcamento_info_nome', 'label' => TXT_LABEL_NOME),
            array('nome' => 'orcamento_info_email', 'label' => TXT_LABEL_EMAIL),
            array('nome' => 'produto_descr', 'label' => TXT_LABEL_PACOTE)
        ));
    } // Fim do m�todo _lista
    
    /**
     * Exibir os detalhes de um determinado or�amento
     * 
     * @param int $id - ID do or�amento a ser exibido
     */
    public function _detalhes($id){
        # Selecionar as informa��es do orcamento
        $this->obj_m->_selecionarID($id);
        
        # Preparar a vis�o
        $this->_escolhertpl('salakaboom/detalhes_orcamento', array('ver'));
        
        $mod_p  = new \Modelo\Produto($this->obj_m->orcamento_festa_pacote);
        $lis_op = $mod_p->_listaropcionais($this->obj_m->orcamento_id, 'P.produto_nome', 'P.produto_nome, O.opcional_orcamento_qtde');
                
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('produto', $mod_p);
        $this->obj_v->_incluirparams('opcionais', $lis_op);
        $this->obj_v->_incluirparams('status', new \Modelo\LogEmail('salakaboom_orcamentos', $this->obj_m->orcamento_id));
        
        $this->_formpadrao();
    } // Fim do m�todo _detalhes
} // Fim do Controle Orcamento
