<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 29/05/2014 14:23:12
 */

namespace Controle;

class Usuario extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Usuario();
        $this->str_m    = TXT_MODELO_USUARIO;
        $this->perm_m   = 2;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'                => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'info_grupo'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'info_nome'         => FILTER_SANITIZE_STRING, 
                'info_email'        => array('filter' => FILTER_SANITIZE_EMAIL, 'flags' => FILTER_NULL_ON_FAILURE),
                'info_telefone'     => FILTER_SANITIZE_STRING,
                'info_sexo'         => FILTER_SANITIZE_STRING,
                'info_login'        => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_NULL_ON_FAILURE),
                'info_senha'        => FILTER_SANITIZE_STRING,
                'pref_idioma'       => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'pref_tema'         => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'pref_formato_data' => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'pref_num_registros'=> FILTER_SANITIZE_NUMBER_INT,
                'conf_bloq'         => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'conf_reset'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
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
     * Salvar o registro
     */
    public function _salvar(){
        if( !$this->obj_ar->_verificarpermissao($this->perm_m, array('inserir', 'editar')) && $this->obj_m->usuario_id != $_SESSION['usuario_id'] )
            throw new \Exception(ERRO_PADRAO_USUARIO_NAO_TEM_PERMISSAO, 1403);
        
        # Salvar o permissionamento
        $modulos = filter_input(INPUT_POST, 'modulo', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        
        # Salvar as informações do usuário
        $this->obj_m->_salvar();
        
        $mod_pu = new \Modelo\PermissoesUsuario();
        $mod_pu->permissao_usuario = $this->obj_m->usuario_id;
        
        foreach( $modulos as $m ):
            $mod_pu->permissao_modulo   = $m;
            $mod_pu->permissao_ver      = (int)filter_input(INPUT_POST, "ver_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pu->permissao_inserir  = (int)filter_input(INPUT_POST, "inserir_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pu->permissao_editar   = (int)filter_input(INPUT_POST, "editar_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pu->permissao_remover  = (int)filter_input(INPUT_POST, "remover_{$m}", FILTER_SANITIZE_NUMBER_INT);
            $mod_pu->permissao_total    = (int)filter_input(INPUT_POST, "total_{$m}", FILTER_SANITIZE_NUMBER_INT);
            
            $mod_pu->_salvar();
        endforeach;
        
        return \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_SALVAR_REGISTRO, $this->str_m), 'sucesso');
    } // Fim do método _salvar
    
    /**
     * Lista de registros
     */
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('admin/lista_usuarios', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_USUARIOS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'G.grupo_usuario_descr, U.usuario_info_nome',
            'U.usuario_id, G.grupo_usuario_descr, U.usuario_info_nome, U.usuario_info_email, U.usuario_info_login',
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
        
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'U.usuario_info_nome', 'label' => TXT_LABEL_NOME_COMPLETO),
            array('nome' => 'G.grupo_usuario_descr', 'label' => TXT_LABEL_GRUPO),
            array('nome' => 'U.usuario_info_email', 'label' => TXT_LABEL_EMAIL),
            array('nome' => 'U.usuario_info_login', 'label' => TXT_LABEL_LOGIN)
        ));
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id: ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Para possibilitar aos usuários comuns a alterarem seus dados 
        # devo fazer toda a verificação separadamente
        if( !$this->obj_ar->_verificarpermissao($this->perm_m, array('inserir', 'editar')) && $id != $_SESSION['usuario_id'] ):
            # Alterar o código de retorno da página
            $this->obj_v->_alterarstatus(403);
        
            # Selecionar o template de erro
            $this->_escolhertpl('../erros/403');
            return false;
        endif;
        
        # Preparar a visão
        $this->_escolhertpl('admin/form_usuario');
        $this->obj_v->_titulo(TXT_TITULO_USUARIOS);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        # Selecionar a lista de grupos de usuário
        $mod_gu = new \Modelo\GrupoUsuario();
        $lis_gu = $mod_gu->_listar('grupo_usuario_publicar = 1', 'grupo_usuario_descr', 'grupo_usuario_id, grupo_usuario_descr');
        
        # Selecionar a lista de idiomas do sistema
        $mod_i  = new \Modelo\Idioma();
        $lis_i  = $mod_i->_listar('idioma_publicar = 1', 'idioma_descr', 'idioma_id, idioma_descr');
        
        # Selecionar a lista de temas do sistema
        $mod_t  = new \Modelo\Tema();
        $lis_t  = $mod_t->_listar('tema_publicar = 1', 'tema_descr', 'tema_id, tema_descr');
        
        # Selecionar a lista de formatos de data
        $mod_fd = new \Modelo\FormatoData();
        $lis_fd = $mod_fd->_listar('formato_data_publicar = 1', 'formato_data_descr', 'formato_data_id, formato_data_descr');
        
        if( !is_null($this->obj_m->usuario_id) ):
            $mod_pu = new \Modelo\PermissoesUsuario();
            $lis_pu = $mod_pu->_listar("permissao_usuario = {$this->obj_m->usuario_id}", null, 'permissao_modulo, permissao_ver, permissao_inserir, permissao_editar, permissao_remover, permissao_total');
            
            $this->obj_v->_incluirparams('lis_pu', $lis_pu);
        endif;
        
        # Incluir os parâmetros da visão
        $this->obj_v->_incluirparams('grupos', $lis_gu);
        $this->obj_v->_incluirparams('idiomas', $lis_i);
        $this->obj_v->_incluirparams('temas', $lis_t);
        $this->obj_v->_incluirparams('formatos_data', $lis_fd);
        
        $this->_formpadrao();
    } // Fim do método _formulario
    
    /**
     * Verificar se o usuário já está cadastrado no sistema
     * 
     * @param string $usr: nome de usuário a ser pesquisado
     */
    public function _verificarlogin($usr){
        $usr = filter_var($usr, FILTER_DEFAULT);
        
        if( $this->obj_m->_qtde_registros("U.usuario_info_login = '{$usr}'") > 0 ):
            \Funcoes::_retornar(ERRO_USUARIO_VERIFICARLOGIN, 'erro');
        
            return false;
        else:
            \Funcoes::_retornar(SUCESSO_USUARIO_VERIFICARLOGIN, 'sucesso');
        
            return true;
        endif;
    } // Fim do método _verificarlogin
    
    /**
     * Verificar se o usuário já está cadastrado no sistema
     * 
     * @param string $usr: nome de usuário a ser pesquisado
     */
    public function _verificaremail($email){
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if( $this->obj_m->_qtde_registros("U.usuario_info_email = '{$email}'") > 0 ):
            \Funcoes::_retornar(ERRO_USUARIO_VERIFICAREMAIL, 'erro');
        
            return false;
        else:
            \Funcoes::_retornar(SUCESSO_USUARIO_VERIFICAREMAIL, 'sucesso');
            
            return true;
        endif;
    } // Fim do método _verificaremail
    
    /**
     * Fazer o login do usuário
     */
    public function _fazerlogin(){
        $this->obj_ar->_fazerlogin($this->obj_m->usuario_info_login, $this->obj_m->usuario_info_senha);
        return \Funcoes::_retornar(SUCESSO_USUARIO_FAZERLOGIN, 'sucesso');
    } // Fim do método _fazerlogin
    
    /**
     * Encerrar a sessão do usuário
     */
    public function _fazerlogout(){
        $this->obj_ar->_fazerlogout();
        return \Funcoes::_retornar(SUCESSO_USUARIO_FAZERLOGOUT, 'sucesso');
    } // Fim do método _fazerlogin
    
    /**
     * Formulário para alterar a  senha do usuário logado
     */
    public function _formalterarsenha(){
        # Preparar a visão
        $this->obj_v->_template('login/form_alterar_senha');
        $this->obj_v->_titulo(TXT_TITULO_ALTERAR_MINHA_SENHA);
    } // Fim do método _formalterarsenha
    
    /**
     * Alterar a senha do usuário logado
     */
    public function _alterarsenha(){
        # Selecionar dados do usuário logado
        $this->obj_m->_selecionarID($_SESSION['usuario_id']);
        
        $senha_atual        = md5(md5(filter_input(INPUT_POST, 'senha_atual', FILTER_DEFAULT)));
        $senha_nova         = md5(md5(filter_input(INPUT_POST, 'senha_nova', FILTER_DEFAULT)));
        $senha_nova_conf    = md5(md5(filter_input(INPUT_POST, 'senha_nova_conf', FILTER_DEFAULT)));
        
        # Verificar se as senhas novas são iguais
        $this->obj_m->_alterarsenha($senha_atual, $senha_nova, $senha_nova_conf);
        
        return \Funcoes::_retornar(SUCESSO_USUARIO_ALTERARSENHA, 'sucesso');
    } // Fim do método _alterarsenha
    
    /**
     * Alterar a senha do usuário logado
     */
    public function _formesquecisenha(){
        # Preparar a visão
        $this->obj_v->_template('login/form_esqueci_senha');
        $this->obj_v->_titulo(TXT_TITULO_ESQUECI_MINHA_SENHA);
    } // Fim do método _formalterarsenha
    
    /**
     * Executar as ações de recuperação de senha
     */
    public function _esquecisenha(){
        # Tratar informação vinda do formulário
        $login = filter_input(INPUT_POST, 'login', FILTER_DEFAULT);
        
        # Selecionar os dados do usuário
        $lis_u = end($this->obj_m->_listar("U.usuario_info_login = '{$login}' OR U.usuario_info_email = '{$login}'", null, 'U.usuario_id'));
        
        if( $lis_u === false )
            throw new \Exception(ERRO_USUARIO_ESQUECISENHA_USUARIO_NAO_LOCALIZADO, 1404);
        
        $this->obj_m->_selecionarID($lis_u['usuario_id']);
        
        # Criar o registro de recuperação
        $mod_r = new \Modelo\Recuperacao();
        
        # Verificar se o usuário solicitou recentemente a alteração da senha,
        # pois em caso positivo será usada a mesma hash
        $lis_r = end($mod_r->_listar("recuperacao_usuario = {$this->obj_m->usuario_id} AND recuperacao_status = 'E'", null, 'recuperacao_id'));
        
        if( $lis_r === false ):
            $mod_r->recuperacao_usuario = $this->obj_m->usuario_id;
            $mod_r->recuperacao_hash    = date(\DL::$bd_dh_formato_completo);
            $mod_r->_salvar();
        else:
            $mod_r->_selecionarID($lis_r['recuperacao_id']);
        endif;
        
        # Enviar o e-mail ao usuário
        
        # Selecionar o conteúdo do e-mail
        $this->obj_v->_template('../emails/recuperacao_senha');
        $this->obj_v->_incluirparams('modelo', $this->obj_m);
        $this->obj_v->_incluirparams('recuperacao', $mod_r);
        
        $obj_e = new \Email();
        $obj_e->_enviar($this->obj_m->usuario_info_email, TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA, $this->obj_v->_conteudo());
        $obj_e->_gravarlog(__CLASS__, $this->obj_m->bd_tabela, $this->obj_m->recuperacao_id);
        
        return \Funcoes::_retornar(SUCESSO_USUARIO_ESQUECISENHA, 'sucesso');
    } // Fim do método _esquecisenha
    
    /**
     * Formulário para alterar a  senha do usuário logado
     * 
     * @param string $hash: Hash identificadora do usuário
     */
    public function _formresetsenha($hash=''){
        # Tratar a Hash
        $hash = filter_var($hash, FILTER_DEFAULT);
        
        # Preparar a visão
        $this->obj_v->_template(!empty($hash) ? 'login/form_reset_senha' : '../erros/404');
        $this->obj_v->_titulo(TXT_TITULO_RESETAR_MINHA_SENHA);
        
        # Selecionar o ID do usuário de acordo com a HASH
        $mod_r = new \Modelo\Recuperacao();
        $lis_r = end($mod_r->_listar("recuperacao_hash = '{$hash}' AND recuperacao_status = 'E'", null, 'recuperacao_usuario'));
        
        # Selecionar as informações do usuário
        $this->obj_m->_selecionarID($lis_r['recuperacao_usuario']);
        
        # Incluir os parâmetros da visão
        $this->obj_v->_incluirparams('hash', $hash);
        $this->obj_v->_incluirparams('usr_nome', $this->obj_m->usuario_info_nome);
    } // Fim do método _formresetsenha
    
    /**
     * Resetar a senha do usuário logado
     */
    public function _resetarsenha(){
        $hash               = filter_input(INPUT_POST, 'hash', FILTER_DEFAULT);
        $senha_nova         = md5(md5(filter_input(INPUT_POST, 'senha_nova', FILTER_DEFAULT)));
        $senha_nova_conf    = md5(md5(filter_input(INPUT_POST, 'senha_nova_conf', FILTER_DEFAULT)));
        
        # Selecionar o ID do usuário de acordo com a HASH
        $mod_r = new \Modelo\Recuperacao();
        $lis_r = end($mod_r->_listar("recuperacao_hash = '{$hash}' AND recuperacao_status = 'E'", null, 'recuperacao_usuario'));
        
        if( $lis_r === false )
            throw new \Exception(ERRO_USUARIO_ESQUECISENHA_USUARIO_NAO_LOCALIZADO, 1404);
        
        $this->obj_m->_selecionarID($lis_r['recuperacao_usuario']);
        
        # Verificar se as senhas novas são iguais
        $this->obj_m->_resetarsenha($hash, $senha_nova, $senha_nova_conf);
        
        return \Funcoes::_retornar(SUCESSO_USUARIO_RESETARSENHA, 'sucesso');
    } // Fim do método _alterarsenha
} // Fim do controle Usuario
