<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 15/12/2013
 */

class AcessoRestrito {
    # Templates

    private $tpl_formlogin;

    # Configuração de sessão
    private $sessao_prefixo;
    private $sessao_nome;

    # Configuração do acesso root
    private $root_usuario = 'root';
    private $root_senha = /* MD5 x 1 = '5b7278fa6678dfac1f64b7dcd780aa2d' */'64eedda5e60fdb52fc29aa903ce9002a';
    private $root_email = 'd_lepera@hotmail.com';

    public function __construct($tpl_formlogin, $sessao_prefixo = 'dl') {
        $this->tpl_formlogin = $tpl_formlogin;
        $this->sessao_prefixo = $sessao_prefixo;
        $this->sessao_nome = "{$this->sessao_prefixo}-sessao";
    } // Fim do método de construção da classe

    public function _sessao($param) {
        $param = "sessao_{$param}";

        return $this->{$param};
    } // Fim do método _sessao($param)

    public function _verificarlogin($redir = true) {
        // if( session_status() !== PHP_SESSION_ACTIVE ):
        if (!session_id()):
            $cookie = filter_input(INPUT_COOKIE, $this->sessao_nome);

            if (empty($cookie) && $redir):
                $this->_formlogin();
            elseif (preg_match("#^({$this->sessao_prefixo})#", $cookie)):
                if (!$this->_carregarsessao(array(), $cookie)):
                    $this->_fazerlogout();
                    return $redir ? $this->_formlogin() : false;
                else:
                    goto sessao_ok;
                endif;
            else:
                return false;
            endif;
        endif;

        sessao_ok:
        # Definir o tema a ser utilizado
        \DL::$dir_css = '/aplicacao/css/' . $_SESSION['tema_diretorio'];

        return true;
    } // Fim do método _verificarlogin

    public function _formlogin() {
        $v = new \Visao();
        $v->_template($this->tpl_formlogin);
        $v->_mostrar();
    } // Fim do método _formlogin

    public function _fazerlogin($usuario = '', $senha = '') {
        $usuario = empty($usuario) ? filter_input(INPUT_POST, 'info_login', FILTER_DEFAULT) : $usuario;
        $senha = empty($senha) ? md5(filter_input(INPUT_POST, 'info_senha', FILTER_DEFAULT)) : $senha;

        # Configurar acesso do usuário root
        if ($usuario == $this->root_usuario && $senha == $this->root_senha):
            $lis_u['usuario_id'] = 0;
            $lis_u['usuario_info_grupo'] = 1;
            $lis_u['grupo_usuario_descr'] = 'Admin';
            $lis_u['usuario_info_nome'] = 'Administrador';
            $lis_u['usuario_info_email'] = $this->root_email;
            $lis_u['usuario_conf_bloq'] = '0';
            $lis_u['usuario_conf_reset'] = '0';
            $lis_u['tema_diretorio'] = 'painel/';
            $lis_u['usuario_pref_idioma'] = 1;
            $lis_u['usuario_pref_num_registros'] = 20;
            $lis_u['formato_data_data'] = 'd/m/Y';
            $lis_u['formato_data_hora'] = 'H:i';
            $lis_u['formato_data_completo'] = 'd/m/Y H:i';

            # Selecionar os módulos ativos do sistema
            $query = "SELECT"
                    . " CONCAT('modulo_', modulo_id) AS modulo,"
                    . " 1 AS ver, 1 AS inserir, 1 AS editar, 1 AS remover, 1 AS total"
                    . " FROM dl_painel_modulos";
            $sql = \DL::$bd_pdo->query($query);

            # Configurar as permissões para o usuário root
            $lis_u['permissoes'] = array();

            while ($rs = $sql->fetch(\PDO::FETCH_ASSOC)):
                $lis_u['permissoes'][$rs['modulo']] = array(
                    'ver' => (bool) $rs['ver'],
                    'inserir' => (bool) $rs['inserir'],
                    'editar' => (bool) $rs['editar'],
                    'remover' => (bool) $rs['remover'],
                    'total' => (bool) $rs['total']
                );
            endwhile;
        else:
            # Iniciar a instância do usuário
            $mod_u = new \Modelo\Usuario();

            # Selecionar o usuário de acordo com o usuário e senha
            $lis_u = end($mod_u->_listar(
                            "U.usuario_info_login = '{$usuario}' AND U.usuario_info_senha = '{$senha}'", null, 'U.usuario_id, U.usuario_info_grupo, G.grupo_usuario_descr, U.usuario_info_nome, U.usuario_info_email, U.usuario_info_telefone,'
                            . ' U.usuario_info_sexo, U.usuario_pref_num_registros, U.usuario_conf_bloq, U.usuario_conf_reset, FD.formato_data_data, FD.formato_data_hora,'
                            . ' T.tema_diretorio, FD.formato_data_completo, I.idioma_sigla'
            ));

            if (!count($lis_u) || $lis_u === false)
                throw new Exception(ERRO_ACESSORESTRITO_USUARIO_SENHA_INVALIDOS, 1403);

            # Adicionar as permissões do usuário na sessão
            $mod_pu = new \Modelo\PermissoesUsuario();
            $lis_pu = $mod_pu->_listar(
                    "permissao_usuario = {$lis_u['usuario_id']}", null, "CONCAT('modulo_', permissao_modulo) AS modulo,"
                    . "permissao_ver AS ver, permissao_inserir AS inserir, permissao_editar AS editar,"
                    . "permissao_remover AS remover, permissao_total AS total"
            );

            foreach ($lis_pu as $pu):
                $lis_u['permissoes'][$pu['modulo']] = array(
                    'ver' => (bool) $pu['ver'],
                    'inserir' => (bool) $pu['inserir'],
                    'editar' => (bool) $pu['editar'],
                    'remover' => (bool) $pu['remover'],
                    'total' => (bool) $pu['total']
                );
            endforeach;
        endif;

        # Iniciar a sessão
        return $this->_carregarsessao($lis_u, "{$this->sessao_prefixo}{$lis_u['usuario_id']}");
    } // Fim do método _fazerlogin

    public function _carregarsessao(array $dados, $sessao_id) {
        # Definir o nome da sessão
        session_name($this->sessao_nome);

        # Definir o ID da sessão
        session_id($sessao_id);

        # Iniciar a sessão
        session_start();

        foreach ($dados as $c => $v):
            if (!preg_match('~(_senha)$~', $c))
                $_SESSION[$c] = $v;
        endforeach;

        return count($_SESSION) > 0 ? true : false;
    } // Fim do método _carregarsessao

    public function _fazerlogout() {
        if (!$this->_verificarlogin(false))
            return true;

        # Remover o cookie com o ID da sessão
        // $_COOKIE[$this->sessao_nome] = '';
        setcookie($this->sessao_nome, '', time() - 360, '/');

        # Destruir a sessão
        if (!session_destroy())
            return false;

        return true;
    } // Fim do método _fazerlogout

    public function _verificarpermissao($id_modulo, array $perms = array('ver')) {
        # Habilitar o acesso total ao usuário root, que é
        # caracterizado pelo ID (int)0
        if ($_SESSION['usuario_id'] === 0 || empty($perms))
            return true;

        if (!isset($_SESSION['permissoes']['modulo_' . $id_modulo]))
            return false;

        $perm = $_SESSION['permissoes']['modulo_' . $id_modulo];

        foreach ($perms as $p):
            if ($perm[$p] == '1')
                return true;
        endforeach;

        return false;
    } // Fim do método _verificarpermissao
} // Fim da classe AcessoRestrito
