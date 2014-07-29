<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/07/2014 16:37:50
 */

namespace Controle;

class Modulo extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Modulo();
        $this->str_m    = TXT_MODELO_MODULO;
        $this->perm_m   = 0;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'pai'       => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'nome'      => FILTER_SANITIZE_STRING,
                'descr'     => FILTER_SANITIZE_STRING,
                'link'      => FILTER_SANITIZE_STRING,
                'ordem'     => FILTER_SANITIZE_NUMBER_INT,
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->_bd_prefixo());
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
        $this->_escolhertpl('desenvolvedor/lista_modulos', array());
        $this->obj_v->_titulo(TXT_TITULO_MODULOS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'P.modulo_nome, M.modulo_nome', 
            "M.modulo_id, P.modulo_nome AS PAI, M.modulo_nome, M.modulo_link,"
            . " ( CASE M.modulo_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'M.modulo_nome', 'label' => TXT_LABEL_NOME),
            array('nome' => 'M.modulo_link', 'label' => TXT_LABEL_LINK)
        ));
    } // Fim do método _lista
    
    /**
     * Montar a lista explicativa do módulo caso o mesmo
     * esteja classificado como 'pai'
     * 
     * @param int $modulo: ID do módulo a ser listado e descrito
     */
    public function _descrever($modulo){
        # Selecionar o módulo
        $this->obj_m->_selecionarID((int)$modulo);
        
        # Preparar a visão
        $this->_escolhertpl('descr_modulo');
        $this->obj_v->_titulo($this->obj_m->modulo_nome);
        
        # Selecionar os sub-módulos desse módulo
        $lis_sm = $this->obj_m->_listar("M.modulo_pai = {$this->obj_m->modulo_id}", 'M.modulo_nome', 'M.modulo_nome, M.modulo_descr, M.modulo_link');
        
        # Incluir os parâmetros
        $this->obj_v->_incluirparams('modelo', $this->obj_m);
        $this->obj_v->_incluirparams('sub-modulos-2', $lis_sm);
    } // Fim do método _listahome
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id: ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('desenvolvedor/form_modulo', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_MODULOS);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
            
        if( !is_null($this->obj_m->modulo_id) && (int)$this->obj_m->modulo_pai !== 0 ):     
            # Obter a lista de grupos e permissões
            $mod_pg = new \Modelo\PermissoesGrupo();
            $lis_g  = $mod_pg->_listar(
                "P.permissao_modulo = {$this->obj_m->modulo_id}", 
                'G.grupo_usuario_descr', 
                'P.permissao_grupo, G.grupo_usuario_descr, P.permissao_ver, P.permissao_inserir, P.permissao_editar, P.permissao_remover, P.permissao_total'
            );
        else:
            # Obter a lista de grupos e permissões zeradas
            $mod_g = new \Modelo\GrupoUsuario();
            $lis_g = $mod_g->_listar("grupo_usuario_publicar = '1'", 'grupo_usuario_descr', 'grupo_usuario_id AS permissao_grupo, grupo_usuario_descr, 0 AS permissao_ver, 0 AS permissao_inserir, 0 AS permissao_editar, 0 AS permissao_remover, 0 AS permisao_total');
        endif;
        
        # Incluir parâmetros na visão
        $this->obj_v->_incluirparams('grupos', $lis_g);
            
        $this->_formpadrao();
    } // Fim do método _formulario
    
    /**
     * Salvar o registro
     */
    public function _salvar(){
        if( !$this->obj_ar->_verificarpermissao($this->perm_m, array('inserir', 'editar')) )
            throw new \Exception(ERRO_PADRAO_USUARIO_NAO_TEM_PERMISSAO, 1403);
        
        $this->obj_m->_salvar();
        
        if( (int)$this->obj_m->modulo_pai > 0 ):
            # Salvar os permissionamentos dos grupos
            $grupos = filter_input(INPUT_POST, 'grupos', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);

            $mod_pg = new \Modelo\PermissoesGrupo();

            foreach( $grupos as $gp ):
                $mod_pg->_selecionarID($gp, $this->obj_m->modulo_id);
                $mod_pg->permissao_ver      = (int)filter_input(INPUT_POST, "ver_{$gp}", FILTER_SANITIZE_NUMBER_INT);
                $mod_pg->permissao_inserir  = (int)filter_input(INPUT_POST, "inserir_{$gp}", FILTER_SANITIZE_NUMBER_INT);
                $mod_pg->permissao_editar   = (int)filter_input(INPUT_POST, "editar_{$gp}", FILTER_SANITIZE_NUMBER_INT);
                $mod_pg->permissao_remover  = (int)filter_input(INPUT_POST, "remover_{$gp}", FILTER_SANITIZE_NUMBER_INT);
                $mod_pg->permissao_total    = (int)filter_input(INPUT_POST, "total_{$gp}", FILTER_SANITIZE_NUMBER_INT);

                # Salvar o registro
                $mod_pg->_salvar();
            endforeach;
        endif;
        
        \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_SALVAR_REGISTRO, $this->str_m), 'sucesso');
    } // Fim do método _salvar
} // Fim do controle Modulo
