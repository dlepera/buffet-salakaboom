<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 16:25:07
 */

namespace Controle;

class ContatoSiteSis extends PrincipalSistema{
    public function __construct(){
        parent::__construct('/painel-dl/');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\ContatoSite();
        $this->str_m    = TXT_MODELO_CONTATOSITE;
        $this->perm_m   = 6;
    } // Fim do método mégico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Exibir a lista de registros
     */
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('website/lista_contatos', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_CONTATOS_RECEBIDOS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'CS.contato_site_nome',
            'CS.contato_site_id, CS.contato_site_nome, CS.contato_site_email, AC.assunto_contato_descr, LE.log_email_status',
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
        
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'CS.contato_site_nome', 'label' => TXT_LABEL_NOME_COMPLETO),
            array('nome' => 'CS.contato_site_email', 'label' => TXT_LABEL_EMAIL),
            array('nome' => 'AC.assunto_contato_descr', 'label' => TXT_LABEL_ASSUNTO)
        ));
    } // Fim do método _lista
    
    /**
     * Exibir os detalhes do contato
     * 
     * @param int $id : ID do contato a ser exibido
     */
    public function _detalhes($id){
        # Preparar a visão
        $this->_escolhertpl('website/detalhes_contato', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_CONTATOS_RECEBIDOS);
        
        # Selecionar as informações desse contato
        $this->obj_m->_selecionarID($id);
        
        # Selecionar log de e-mail desse registro
        $mod_st = new \Modelo\LogEmail('dl_site_contatos', $id);
        
        # Incluir os parâmetros para essa visão
        $this->obj_v->_incluirparams('status', $mod_st);
        
        $this->_formpadrao();
    } // Fim do método _detalhes
} // Fim do Controle ContatoSiteSis
