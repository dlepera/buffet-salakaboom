<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 6, 2014 11:25:33 AM
 */

namespace Controle;

class EnvioConvite extends PrincipalSistema{
    public function __construct(){
		parent::__construct('painel-dl');
        
        $this->obj_m    = new \Modelo\EnvioConvite();
		$this->str_m    = TXT_MODELO_ENVIOCONVITE;
        $this->perm_m   = 22;
	} // Fim do método de construção da classe
	
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
        
    /*
	 * Exibir a lista de envios de convites virtuais
	 */
	public function _lista(){
        # Preparar a visão
		$this->_escolhertpl('convites/lista_envios', array('ver'));
		$this->obj_v->_titulo(TXT_TITULO_CONVITES_VIRTUAIS_ENVIADOS);
        
        $this->_listapadrao(
            'envio_convite_festa_aniversariante',
            'envio_convite_id, envio_convite_festa_aniversariante, envio_convite_festa_data, modelo_convite_titulo',
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
	} // Fim do método _lista
	
	/**
	 * Exibir detalhes do envio de convites virtuais
	 */
	public function _detalhes($id=0){
		if( $id > 0 )
			$this->obj_m->_selecionarID((int)$id);
        
        # Preparar a visão
		$this->_escolhertpl('convites/detalhes_envio', array('incluir', 'editar'));
		$this->obj_v->_titulo(TXT_TITULO_CONVITES_VIRTUAIS_ENVIADOS);
        
        $this->_formpadrao();
	} // Fim do método _detalhes
} // Fim do Controle EnvioConvite
