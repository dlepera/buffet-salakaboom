<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 20/01/2014
 */

namespace Modelo;
 
class LoginConvite extends Principal{
	# Propriedades de tipos de cardápios do site
	protected $login_convite_id, $login_convite_usuario, $login_convite_senha, $login_convite_email, $login_convite_delete = 0;
		
	public function __construct($id=0){
        parent::__construct('salakaboom_convites_logins', 'login_convite_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
	
    /**
     * Obter ou editar o valor da propriedade $login_convite_usuario
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->login_convite_usuario
     * 
     * @return string - valor da propriedade $login_convite_usuario
     */
    public function _login_convite_usuario($valor=null){
        return is_null($valor) ?
            (string)$this->login_convite_usuario        
        : $this->login_convite_usuario = (string)$valor;
    } // Fim do método _login_convite_usuario
    
    /**
     * Obter ou editar o valor da propriedade $login_convite_senha
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->login_convite_senha
     * 
     * @return string - valor da propriedade $login_convite_senha
     */
    public function _login_convite_senha($valor=null){
        return is_null($valor) ?
            (string)$this->login_convite_senha        
        : $this->login_convite_senha = (string)$valor;
    } // Fim do método _login_convite_senha
    
    /**
     * Obter ou editar o valor da propriedade $login_convite_email
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $login_convite_email
     * 
     * @return string: valor da propriedade $login_convite_nome
     */
    public function _login_convite_email($valor=null){
        if( is_null($valor) )
            return $this->login_convite_email;
        
        if( !empty($valor) && !$this->login_convite_email = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->login_convite_email = (string)$valor;
    } // Fim do método _login_convite_email
    
	/**
	 * Salvar o conteúdo do objeto no banco de dados
	 */
	public function _salvar($salvar = true){		
		if( !$this->login_convite_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " login_convite_usuario, login_convite_senha, login_convite_email) VALUES ("
                    . " '{$this->login_convite_usuario}', '{$this->login_convite_senha}', '{$this->login_convite_email}')";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " login_convite_usuario = '{$this->login_convite_usuario}',"
                    . " login_convite_senha = '{$this->login_convite_senha}',"
                    . " login_convite_email = '{$this->login_convite_email}'"
                    . " WHERE login_convite_id = {$this->login_convite_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->login_convite_id = \DL::$bd_pdo->lastInsertID('login_convite_id');
        
        return $this->login_convite_id;
	} // Fim do médoto _salvar
	
	public function _fazerlogin(){
        $lis_u = $this->_listar(
            "login_convite_usuario = '{$this->login_convite_usuario}' AND login_convite_senha = '{$this->login_convite_senha}'",
            null,
            "login_convite_id, login_convite_usuario, login_convite_email, 'site/' AS tema_diretorio"
        );
        
		if( count($lis_u) != 1 || !$lis_u )
			throw new \Exception(ERRO_LOGINCONVITE_FAZERLOGIN, 1500);
        
        return end($lis_u);
	} // Fim do método _fazerlogin
} // Fim do Modelo LoginConvite
