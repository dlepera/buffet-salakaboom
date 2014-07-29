<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 23/06/2014 11:04:35
 */

namespace Controle;

class GrupoUsuario extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\GrupoUsuario();
        $this->str_m    = TXT_MODELO_GRUPO_USUARIO;
        $this->perm_m   = 4;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'descr'     => FILTER_SANITIZE_STRING,
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informa��es atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informa��es acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->_bd_prefixo());
        endif;
    } // Fim do m�todo m�gico de constru��o da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Salvar o registro
     */
    public function _salvar(){
        if( !$this->obj_ar->_verificarpermissao($this->perm_m, array('inserir', 'editar')) )
            throw new \Exception(ERRO_PADRAO_USUARIO_NAO_TEM_PERMISSAO, 1403);
        
        # Salvar o permissionamento
        $modulos = filter_input(INPUT_POST, 'modulo', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        
        # Salvar os dados do grupo de usu�rio
        $this->obj_m->_salvar();
            
        $mod_pg = new \Modelo\PermissoesGrupo();
        $mod_pg->permissao_grupo = $this->obj_m->grupo_usuario_id;
        
        foreach( $modulos as $m ):
            $mod_pg->permissao_modulo   = $m;
            $mod_pg->permissao_ver      = (int)filter_input(INPUT_POST, "ver_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pg->permissao_inserir  = (int)filter_input(INPUT_POST, "inserir_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pg->permissao_editar   = (int)filter_input(INPUT_POST, "editar_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pg->permissao_remover  = (int)filter_input(INPUT_POST, "remover_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pg->permissao_total    = (int)filter_input(INPUT_POST, "total_{$m}", FILTER_SANITIZE_NUMBER_INT);
            
            $mod_pg->_salvar();
        endforeach;
        
        return \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_SALVAR_REGISTRO, $this->str_m), 'sucesso');
    } // Fim do m�todo _salvar
    
    /**
     * Lista de registros
     */
    public function _lista(){
        # Preparar a vis�o
        $this->_escolhertpl('admin/lista_grupos', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_GRUPOS_DE_USUARIOS);
        
        # Configurar a lista padr�o
        $this->_listapadrao(
            'grupo_usuario_descr',
            "grupo_usuario_id, grupo_usuario_descr,"
            . " ( CASE grupo_usuario_publicar"
            . " WHEN 0 THEN 'N�o'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
                
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'grupo_usuario_descr', 'label' => TXT_LABEL_GRUPO)
        ));
    } // Fim do m�todo _lista
    
    /**
     * Carregar o formul�rio de edi��o do registro
     * 
     * @param int $id: ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a vis�o
        $this->_escolhertpl('admin/form_grupo', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_GRUPOS_DE_USUARIOS);
        
        # Selecionar as informa��es do modelo
        $this->obj_m->_selecionarID($id);
                
        if( !is_null($this->obj_m->grupo_usuario_id) ):
            $mod_pg = new \Modelo\PermissoesGrupo();
            $lis_pg = $mod_pg->_listar("P.permissao_grupo = {$this->obj_m->grupo_usuario_id}", null, 'P.permissao_modulo, P.permissao_ver, P.permissao_inserir, P.permissao_editar, P.permissao_remover, P.permissao_total');
            
            $this->obj_v->_incluirparams('lis_pg', $lis_pg);
        endif;
               
        $this->_formpadrao();
    } // Fim do m�todo _formulario
    
    /**
     * Exibir o formul�rio sem o topo e o rodap� padr�o
     */
    public function _formulario_str(){
        # Alterar o header da p�gina
        header('Content-type: text/html; charset=ISO-8859-1', true);
        
        # Preparar a vis�o
        $this->obj_v->_template('admin/form_grupo');
        
        # Selecionar a lista de m�dulos
        $mod_m  = new \Modelo\Modulo();
        $lis_m  = $mod_m->_listar("M.modulo_publicar = '1' AND M.modulo_pai IS NULL", 'M.modulo_nome', 'M.modulo_id, M.modulo_nome');
        $lis_sm = $mod_m->_listar("M.modulo_publicar = '1' AND M.modulo_pai IS NOT NULL", 'M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome');
        
        if( !is_null($this->obj_m->grupo_usuario_id) ):
            $mod_pg = new \Modelo\PermissoesGrupo();
            $lis_pg = $mod_pg->_listar("P.permissao_grupo = {$this->obj_m->usuario_id}", null, 'P.permissao_modulo, P.permissao_ver, P.permissao_inserir, P.permissao_editar, P.permissao_remover, P.permissao_total');
            
            $this->obj_v->_incluirparams('lis_pg', $lis_pg);
        endif;
        
        # Incluir os par�metros da p�gina
        $this->obj_v->_incluirparams('modulos', $lis_m);
        $this->obj_v->_incluirparams('sub-modulos', $lis_sm);
    } // Fim do m�todo _formulario_str
} // Fim do controle GrupoUsuario
