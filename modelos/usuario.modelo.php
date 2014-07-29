<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/05/2014 17:46:04
 */

namespace Modelo;

class Usuario extends Principal{
    protected $usuario_id, $usuario_info_grupo, $usuario_info_nome, $usuario_info_email, $usuario_info_telefone, $usuario_info_sexo,
        $usuario_info_login, $usuario_info_senha, $usuario_pref_idioma, $usuario_pref_tema, $usuario_pref_formato_data, $usuario_pref_num_registros,
        $usuario_conf_bloq = 0, $usuario_conf_reset = 1, $usuario_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('dl_painel_usuarios', 'usuario_');
        
        # Definir a query que fará a seleção dos resultados
        $this->bd_select = "SELECT"
            . " %s"
            . " FROM %s AS U"
            . " INNER JOIN dl_painel_grupos_usuarios AS G ON( G.grupo_usuario_id = U.usuario_info_grupo )"
            . " INNER JOIN dl_painel_idiomas AS I ON( I.idioma_id = U.usuario_pref_idioma )"
            . " INNER JOIN dl_painel_temas AS T ON( T.tema_id = U.usuario_pref_tema )"
            . " INNER JOIN dl_painel_formatos_data AS FD ON( FD.formato_data_id = U.usuario_pref_formato_data )"
            . " WHERE U.%sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
        
    /**
     * Obter ou editar o valor da propriedade $usuario_info_grupo
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $usuario_info_grupo
     * 
     * @return int: valor da propriedade $usuario_info_grupo
     */
    public function _usuario_info_grupo($valor=null){
        return is_null($valor) ?
            (int)$this->usuario_info_grupo
        : $this->usuario_info_grupo = (int)$valor;
    } // Fim do método _usuario_info_grupo
    
    /**
     * Obter ou editar o valor da propriedade $usuario_info_nome
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_info_nome
     * 
     * @return string: valor da propriedade $usuario_info_nome
     */
    public function _usuario_info_nome($valor=null){
        return is_null($valor) ?
            (string)$this->usuario_info_nome
        : $this->usuario_info_nome = (string)$valor;
    } // Fim do método _usuario_info_nome
    
    /**
     * Obter ou editar o valor da propriedade $usuario_info_email
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_info_email
     * 
     * @return string: valor da propriedade $usuario_info_nome
     */
    public function _usuario_info_email($valor=null){
        if( is_null($valor) )
            return $this->usuario_info_email;
        
        if( !empty($valor) && !$this->usuario_info_email = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->usuario_info_email = (string)$valor;
    } // Fim do método _usuario_info_email
    
    /**
     * Obter ou editar o valor da propriedade $usuario_info_telefone
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_info_telefone
     * 
     * @return string: valor da propriedade $usuario_info_telefone
     */
    public function _usuario_info_telefone($valor=null){
        return is_null($valor) ?
            (string)$this->usuario_info_telefone
        : $this->usuario_info_telefone = (string)$valor;
    } // Fim do método _usuario_info_telefone
    
    /**
     * Obter ou editar o valor da propriedade $usuario_info_sexo
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_info_sexo
     * 
     * @return string: valor da propriedade $usuario_info_sexo
     */
    public function _usuario_info_sexo($valor=null){
        if( is_null($valor) )
            return $this->usuario_info_sexo;
        
        if( !empty($valor) && !in_array($valor, array('M', 'F')) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->usuario_info_sexo = (string)$valor;
    } // Fim do método _usuario_info_sexo
    
    /**
     * Obter ou editar o valor da propriedade $usuario_info_login
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_info_login
     * 
     * @return string: valor da propriedade $usuario_info_login
     */
    public function _usuario_info_login($valor=null){
        return is_null($valor) ?
            (string)$this->usuario_info_login
        : $this->usuario_info_login = (string)$valor;
    } // Fim do método _usuario_info_login
    
    /**
     * Obter ou editar o valor da propriedade $usuario_info_senha
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_info_senha
     * 
     * @return string: valor da propriedade $usuario_info_senha
     */
    public function _usuario_info_senha($valor=null){
        return is_null($valor) ?
            (string)$this->usuario_info_senha
        : $this->usuario_info_senha = md5(md5((string)$valor));
    } // Fim do método _usuario_info_senha
    
    /**
     * Obter ou editar o valor da propriedade $usuario_pref_idioma
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $usuario_pref_idioma
     * 
     * @return int: valor da propriedade $usuario_pref_idioma
     */
    public function _usuario_pref_idioma($valor=null){
        return is_null($valor) ?
            (int)$this->usuario_pref_idioma
        : $this->usuario_pref_idioma = (int)$valor;
    } // Fim do método _usuario_pref_idioma
    
    /**
     * Obter ou editar o valor da propriedade $usuario_pref_tema
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $usuario_pref_tema
     * 
     * @return int: valor da propriedade $usuario_pref_tema
     */
    public function _usuario_pref_tema($valor=null){
        return is_null($valor) ?
            (int)$this->usuario_pref_tema
        : $this->usuario_pref_tema = (int)$valor;
    } // Fim do método _usuario_pref_tema
    
    /**
     * Obter ou editar o valor da propriedade $usuario_pref_formato_data
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $usuario_pref_formato_data
     * 
     * @return int: valor da propriedade $usuario_pref_formato_data
     */
    public function _usuario_pref_formato_data($valor=null){
        return is_null($valor) ?
            (int)$this->usuario_pref_formato_data
        : $this->usuario_pref_formato_data = (int)$valor;
    } // Fim do método _usuario_pref_formato_data
    
    /**
     * Obter ou editar o valor da propriedade $usuario_pref_num_registros
     * 
     * @param int $valor : string contendo o valor a ser atribuído à $usuario_pref_num_registros
     * 
     * @return int: valor da propriedade $usuario_pref_num_registros
     */
    public function _usuario_pref_num_registros($valor=null){
        return is_null($valor) ?
            (int)$this->usuario_pref_num_registros
        : $this->usuario_pref_num_registros = (int)$valor;
    } // Fim do método _usuario_pref_idioma
    
    /**
     * Obter ou editar o valor da propriedade $usuario_conf_bloq
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_conf_bloq
     * 
     * @return string: valor da propriedade $usuario_conf_bloq
     */
    public function _usuario_conf_bloq($valor=null){
        if( is_null($valor) )
            return $this->usuario_conf_bloq;
        
        if( $valor < 0 || $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->usuario_conf_bloq = (int)$valor;
    } // Fim do método _usuario_conf_bloq
    
    /**
     * Obter ou editar o valor da propriedade $usuario_conf_reset
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $usuario_conf_reset
     * 
     * @return string: valor da propriedade $usuario_conf_reset
     */
    public function _usuario_conf_reset($valor=null){
        if( is_null($valor) )
            return (int)$this->usuario_conf_reset;
        
        if( !empty($valor) && ($valor < 0 || $valor > 1) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->usuario_conf_reset = (int)$valor;
    } // Fim do método _usuario_conf_reset
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        if( !$this->usuario_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " usuario_info_grupo, usuario_info_nome, usuario_info_email, usuario_info_telefone, usuario_info_sexo, usuario_info_login, usuario_info_senha,"
                    . " usuario_pref_idioma, usuario_pref_tema, usuario_pref_formato_data, usuario_pref_num_registros, usuario_conf_bloq) VALUES ("
                    . " {$this->usuario_info_grupo}, '{$this->usuario_info_nome}', '{$this->usuario_info_email}', '{$this->usuario_info_telefone}', '{$this->usuario_info_sexo}', '{$this->usuario_info_login}', '{$this->usuario_info_senha}',"
                    . " {$this->usuario_pref_idioma}, {$this->usuario_pref_tema}, {$this->usuario_pref_formato_data}, {$this->usuario_pref_num_registros}, {$this->usuario_conf_bloq})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " usuario_info_grupo = {$this->usuario_info_grupo},"
                    . " usuario_info_nome = '{$this->usuario_info_nome}',"
                    . " usuario_info_email = '{$this->usuario_info_email}',"
                    . " usuario_info_telefone = '{$this->usuario_info_telefone}',"
                    . " usuario_info_sexo = '{$this->usuario_info_sexo}',"
                    . " usuario_info_login = '{$this->usuario_info_login}',"
                    . " usuario_pref_idioma = {$this->usuario_pref_idioma},"
                    . " usuario_pref_tema = {$this->usuario_pref_tema},"
                    . " usuario_pref_formato_data = {$this->usuario_pref_formato_data},"
                    . " usuario_pref_num_registros = {$this->usuario_pref_num_registros},"
                    . " usuario_conf_bloq = {$this->usuario_conf_bloq}"
                    . " WHERE usuario_id = {$this->usuario_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->usuario_id = \DL::$bd_pdo->lastInsertID('usuario_id');
                
        return (int)$this->usuario_id;
    } // Fim do método _salvar
    
    /**
     * Alterar senha do usuário logado
     * 
     * @param string $senha_a: senha atual
     * @param string $senha_n: nova senha a ser utilizada
     * @param string $confirm: confirmação da senha digitada
     */
    public function _alterarsenha($senha_a, $senha_n, $confirm){
        if( $senha_a !== $this->usuario_info_senha )
            throw new \Exception(ERRO_USUARIO_ALTERARSENHA_ATUAL_NAO_CONFERE, 1500);
        
        if( $senha_n !== $confirm )
            throw new \Exception(ERRO_USUARIO_ALTERARSENHA_SENHAS_NAO_CONFEREM, 1500);
        
        $this->_usuario_info_senha($senha_n);
        
        $query = "UPDATE ". $this->_bd_tabela()
                . " SET usuario_info_senha = '{$senha_n}',"
                . " usuario_conf_reset = 0"
                . " WHERE usuario_id = {$this->usuario_id}";
                
        if( \DL::$bd_pdo->exec($query) ):
            $_SESSION['usuario_conf_reset'] = 0;
            return true;
        else:
            return false;
        endif;
    } // Fim do método _alterarsenha
    
    /**
     * Resetar senha do usuário logado
     *
     * @param string $hash: Hash identificadora
     * @param string $senha_n: nova senha a ser utilizada
     * @param string $confirm: confirmação da senha digitada
     */
    public function _resetarsenha($hash, $senha_n, $confirm){
        if( $senha_n !== $confirm )
            throw new \Exception(ERRO_USUARIO_ALTERARSENHA_SENHAS_NAO_CONFEREM, 1500);
        
        $this->_usuario_info_senha($senha_n);
        
        $query = "UPDATE ". $this->_bd_tabela()
                . " SET usuario_info_senha = '{$senha_n}'"
                . " WHERE usuario_id = {$this->usuario_id}";
                
        if( \DL::$bd_pdo->exec($query) ):
            $query = "UPDATE ". $this->_bd_tabela() ."_recuperacoes"
                . " SET recuperacao_status = 'R'"
                . " WHERE recuperacao_hash = '{$hash}' AND recuperacao_usuario = {$this->usuario_id}";
            return \DL::$bd_pdo->exec($query);
        else:
            return false;
        endif;
    } // Fim do método _resetarsenha
} // Fim do modelo Usuario
