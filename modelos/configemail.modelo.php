<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:52:19
 */

namespace Modelo;

class ConfigEmail extends Principal{
    # Propriedades do modelo
    protected $config_email_id, $config_email_titulo, $config_email_host, $config_email_porta,
        $config_email_autent, $config_email_cripto, $config_email_conta, $config_email_senha, 
        $config_email_de_email, $config_email_de_nome, $config_email_responder_para,
        $config_email_html = 1, $config_email_principal = 1, $config_email_delete = 0;
 
    public function __construct($id=0){
        parent::__construct('dl_painel_email_config', 'config_email_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $config_email_titulo
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_titulo
     * 
     * @return string: valor da propriedade $config_email_titulo
     */
    public function _config_email_titulo($valor=null){
        if( is_null($valor) )
            return $this->config_email_titulo;
        
        return $this->config_email_titulo = (string)$valor;
    } // Fim do método _config_email_titulo
    
    /**
     * Obter ou editar o valor da propriedade $config_email_host
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_host
     * 
     * @return string: valor da propriedade $config_email_host
     */
    public function _config_email_host($valor=null){
        if( is_null($valor) )
            return $this->config_email_host;
        
        return $this->config_email_host = (string)$valor;
    } // Fim do método _config_email_host
    
    /**
     * Obter ou editar o valor da propriedade $config_email_porta
     * 
     * @param int $valor: string contendo o valor a ser atribuído à $this->config_email_porta
     * 
     * @return int: valor da propriedade $config_email_porta
     */
    public function _config_email_porta($valor=null){
        if( is_null($valor) )
            return $this->config_email_porta;
        
        return $this->config_email_porta = (int)$valor;
    } // Fim do método _config_email_porta
    
    /**
     * Obter ou editar o valor da propriedade $config_email_autent
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_autent
     * 
     * @return int: valor da propriedade $config_email_autent
     */
    public function _config_email_autent($valor=null){
        if( is_null($valor) )
            return $this->config_email_autent;
        
        if( $valor < 0 && $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->config_email_autent = (int)$valor;
    } // Fim do método _config_email_autent
    
    /**
     * Obter ou editar o valor da propriedade $config_email_cripto
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_cripto
     * 
     * @return string: valor da propriedade $config_email_cripto
     */
    public function _config_email_cripto($valor=null){
        if( is_null($valor) )
            return $this->config_email_cripto;
        
        return $this->config_email_cripto = (string)$valor;
    } // Fim do método _config_email_cripto
    
    /**
     * Obter ou editar o valor da propriedade $config_email_conta
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_conta
     * 
     * @return string: valor da propriedade $config_email_conta
     */
    public function _config_email_conta($valor=null){
        if( is_null($valor) )
            return $this->config_email_conta;
        
        return $this->config_email_conta = (string)$valor;
    } // Fim do método _config_email_conta
    
    /**
     * Obter ou editar o valor da propriedade $config_email_senha
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_senha
     * 
     * @return string: valor da propriedade $config_email_senha
     */
    public function _config_email_senha($valor=null){
        if( is_null($valor) )
            return $this->config_email_senha;
        
        return $this->config_email_senha = (string)$valor;
    } // Fim do método _config_email_senha
    
    /**
     * Obter ou editar o valor da propriedade $config_email_de_email
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_de_email
     * 
     * @return string: valor da propriedade $config_email_de_email
     */
    public function _config_email_de_email($valor=null){
        if( is_null($valor) )
            return $this->config_email_de_email;
        
        if( !$this->config_email_de_email = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->config_email_de_email;
    } // Fim do método _config_email_de_email
    
    /**
     * Obter ou editar o valor da propriedade $config_email_de_nome
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_de_nome
     * 
     * @return string: valor da propriedade $config_email_de_nome
     */
    public function _config_email_de_nome($valor=null){
        if( is_null($valor) )
            return $this->config_email_de_nome;
        
        return $this->config_email_de_nome = (string)$valor;
    } // Fim do método _config_email_de_nome
    
    /**
     * Obter ou editar o valor da propriedade $config_email_responder_para
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_responder_para
     * 
     * @return string: valor da propriedade $config_email_responder_para
     */
    public function _config_email_responder_para($valor=null){
        if( is_null($valor) )
            return $this->config_email_responder_para;
        
        if( !$this->config_email_responder_para = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->config_email_responder_para;
    } // Fim do método _config_email_responder_para
    
    /**
     * Obter ou editar o valor da propriedade $config_email_html
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_html
     * 
     * @return int: valor da propriedade $config_email_html
     */
    public function _config_email_html($valor=null){
        if( is_null($valor) )
            return $this->config_email_html;
        
        if( $valor < 0 && $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->config_email_html = (int)$valor;
    } // Fim do método _config_email_html
    
    /**
     * Obter ou editar o valor da propriedade $config_email_principal
     * @param string $valor: string contendo o valor a ser atribuído à $this->config_email_principal
     * 
     * @return int: valor da propriedade $config_email_principal
     */
    public function _config_email_principal($valor=null){
        if( is_null($valor) )
            return $this->config_email_principal;
        
        if( $valor < 0 && $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->config_email_principal = (int)$valor;
    } // Fim do método _config_email_principal
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        if( !$this->config_email_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " config_email_titulo, config_email_host, config_email_porta, config_email_autent, config_email_cripto,"
                    . " config_email_conta, config_email_senha, config_email_de_email, config_email_de_nome,"
                    . " config_email_responder_para, config_email_html, config_email_principal) VALUES ("
                    . " '{$this->config_email_titulo}', '{$this->config_email_host}', {$this->config_email_porta},"
                    . " {$this->config_email_autent}, '{$this->config_email_cripto}', '{$this->config_email_conta}',"
                    . " '{$this->config_email_senha}', '{$this->config_email_de_email}', '{$this->config_email_de_nome}',"
                    . " '{$this->config_email_responder_para}', {$this->config_email_html}, {$this->config_email_principal})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " config_email_titulo = '{$this->config_email_titulo}',"
                    . " config_email_host = '{$this->config_email_host}',"
                    . " config_email_porta = {$this->config_email_porta},"
                    . " config_email_autent = {$this->config_email_autent},"
                    . " config_email_cripto = '{$this->config_email_cripto}',"
                    . " config_email_conta = '{$this->config_email_conta}',"
                    . " config_email_senha = '{$this->config_email_senha}',"
                    . " config_email_de_email = '{$this->config_email_de_email}',"
                    . " config_email_de_nome = '{$this->config_email_de_nome}',"
                    . " config_email_responder_para = '{$this->config_email_responder_para}',"
                    . " config_email_html = {$this->config_email_html},"
                    . " config_email_principal = {$this->config_email_principal}"
                    . " WHERE config_email_id = {$this->config_email_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        # Apenas 1 configuração pode ser definida como principal.
        # Portanto caso a configuração atual esteja sendo configurada
        # como principal, deve-se remover a flag de qualquer outro registro
        if( $this->config_email_principal === 1 )
            \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET config_email_principal = 0 WHERE config_email_principal = 1");
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->config_email_id = \DL::$bd_pdo->lastInsertID('config_email_id');
        
        return $this->config_email_id;
    } // Fim do método _salvar
    
    /**
     * Selecionar apenas a configuração principal
     */
    public function _selecionarprincipal(){
        $lis_m = end($this->_listar("config_email_principal = 1", null, 'config_email_id'));
        
        if( $lis_m === false )
            throw new \Exception(ERRO_CONFIGEMAIL_SELECIONARPRINCIPAL, 1404);
        
        $this->_selecionarID($lis_m['config_email_id']);
    } // Fim do método _selecionarprincipal
} // Fim do modelo ConfigModelo
