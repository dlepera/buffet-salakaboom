<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 16/05/2014 17:26:50
 */

namespace Controle;

abstract class PrincipalSistema extends Principal{
    protected $obj_ar;
    
    # Configurações do Modelo
    protected $perm_m;
    
    # Status da sessão
    protected $sessao_status;
    
    public function __construct($raiz){
        parent::__construct($raiz);
        
        # Iniciar classe de acesso restrito
        $this->obj_ar        = new \AcessoRestrito('painel-dl/login/form_login');
        $this->sessao_status = $this->obj_ar->_verificarlogin(false);
    } // Fim do método mágico __construct
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Escolher o tamplate e juntá-lo com os templates padrão (_topo e _rodape)
     * 
     * @param string $tpl: nome do template a ser carregado
     * @param string $perm: vetor contendo as permissões que são necessárias
     * realizar a verificação
     */
    public function _escolhertpl($tpl, array $perm = array()){
        # Verificar se o usuário fez o login
        if( !$this->sessao_status ):
            $this->obj_ar->_formlogin();
            return false;
        endif;
        
        # Verificar se será necessário alterar a senha nesse login
        if( $_SESSION['usuario_conf_reset'] == 1 ):
            $this->obj_v->_template('login/form_alterar_senha');
            return false;
        endif;
        
        # Preparar as visões
        $this->obj_v->_template('_topo');
        $this->obj_v->_template($this->obj_ar->_verificarpermissao((int)$this->perm_m, $perm) ? $tpl : '../erros/403');
        $this->obj_v->_template('_rodape');
        
        # Selecionar os módulos do sistema
        $mod_m  = new \Modelo\Modulo();
        $lis_m  = $mod_m->_listar("M.modulo_publicar = '1' AND M.modulo_pai IS NULL", 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_nome, M.modulo_link');
        $lis_sm = $mod_m->_listar("M.modulo_publicar = '1' AND M.modulo_pai IS NOT NULL", 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_link');
        
        # Incluuir os parâmetros na página
        $this->obj_v->_incluirparams('modulos', $lis_m);
        $this->obj_v->_incluirparams('sub-modulos', $lis_sm);
        $this->obj_v->_incluirparams('perm', $_SESSION['permissoes']['modulo_'. $this->perm_m]);
    } // Fim do método _escolhertpl
    
    /**
     * Ações padrões para criar uma lista de registros
     * 
     * @param string $ordem: string que contém os campos a serem ordenados
     * @param string $campos: string que contenham os campos a serem selecionados
     * @param int $qtde: número de registros a serem exibidos na paginação
     */
    public function _listapadrao($ordem = '', $campos = '*', $qtde = 0){
        # Obter a busca realizada
        $_get_t = filter_input(INPUT_GET, 't', FILTER_DEFAULT);
        $_get_c = filter_input(INPUT_GET, 'c', FILTER_DEFAULT);
        $_get_p = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_NUMBER_INT);
        
        # Montar a string de filtro
        $filtro = !empty($_get_t) ? "{$_get_c} LIKE '{$_get_t}%'" : null;
                            
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('_get_c', $_get_c);
        $this->obj_v->_incluirparams('_get_t', $_get_t);
        $this->obj_v->_incluirparams('qtde_pg', ceil($this->obj_m->_qtde_registros($filtro)/$_SESSION['usuario_pref_num_registros']));
        $this->obj_v->_incluirparams('lista', $this->obj_m->_listar($filtro, $ordem, $campos, !$_get_p ? 1 : $_get_p, $qtde));
    } // Fim do métoto _listapadrao 
    
    /**
     * Ações padrões para criar um formulário
     */
    public function _formpadrao(){
        $modelo_id = "{$this->obj_m->bd_prefixo}id";
        
        if( !is_null($this->obj_m->{$modelo_id}) ):
            # Obter as informações de usuário
            $mod_u = new \Modelo\Usuario((int)$this->obj_m->mod_lr->log_registro_usuario_criacao);
            $this->obj_v->_incluirparams('usr_criacao', $mod_u->usuario_info_nome);
            $this->obj_v->_incluirparams('dt_criacao', $this->obj_m->mod_lr->log_registro_data_criacao);

            $mod_u->_selecionarID((int)$this->obj_m->mod_lr->log_registro_usuario_alteracao);
            $this->obj_v->_incluirparams('usr_alteracao', $mod_u->usuario_info_nome);
            $this->obj_v->_incluirparams('dt_alteracao', $this->obj_m->mod_lr->log_registro_data_alteracao);
        endif;
        
        # Inserir os parâmetros na visão
        $this->obj_v->_incluirparams('modelo', $this->obj_m);
    } // Fim do métood _formpadrao
    
    /**
     * Salvar o registro
     */
    public function _salvar(){
        if( !$this->obj_ar->_verificarpermissao($this->perm_m, array('inserir', 'editar')) )
            throw new \Exception(ERRO_PADRAO_USUARIO_NAO_TEM_PERMISSAO, 1403);
        
        $this->obj_m->_salvar();
        
        \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_SALVAR_REGISTRO, $this->str_m), 'sucesso');
    } // Fim do método _salvar


    /**
     * Remover os registros marcados do banco de dados
     */
    public function _remover(){
       if( !$this->obj_ar->_verificarpermissao($this->perm_m, array('remover')) )
           throw new \Exception(ERRO_PADRAO_USUARIO_NAO_TEM_PERMISSAO, 1403);
        
        # Obter os ID's dos registros a serem removidos
        $post_id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        
        # Qtde de registros e quantidade de registros removidos
        $num_reg = count($post_id);
        $num_rem = 0;
        
        foreach( $post_id as $id ):
            $this->obj_m->_selecionarID((int)$id);
        
            if( $this->obj_m->_remover() > 0 )
                $num_rem++;
        endforeach;
        
        \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_REMOVER_REGISTROS, $num_rem, $this->str_m, $num_reg), 'sucesso');
    } // Fim do método _remover
} // Fim da classe PrincipalSistema
