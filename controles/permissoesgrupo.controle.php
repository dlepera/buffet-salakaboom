<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 25/06/2014 09:47:56
 */

namespace Controle;

class PermissoesGrupo extends PrincipalSistema{
    public function __construct(){
        parent::__construct('gerenc');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\PermissoesGrupo();
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Listar as permissões de acordo com o grupo de usuário
     */
    public function _filtrarporgrupo(){
        # Tratar a informação enviada pelo form
        $grupo = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_NUMBER_INT);
        
        echo json_encode($this->obj_m->_listar("P.permissao_grupo = {$grupo}"));
    } // Fim do método _filtrarporgrupo
} // Fim do controle PermissoesGrupo
