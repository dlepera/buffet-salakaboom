<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:52:19
 */

namespace Modelo;

class LogEmail extends Principal{
    # Propriedades do modelo
    protected $log_email_id, $log_email_data_criacao, $log_email_config, $log_email_ip, $log_email_classe,
        $log_email_tabela, $log_email_idreg, $log_email_mensagem, $log_email_status = 'S';
 
    public function __construct($tabela=null, $id=null){
        parent::__construct('dl_painel_email_logs', 'log_email_');
        
        $this->bd_select = "SELECT %s FROM %s";
        
        if( !is_null($tabela) && !is_null($id) )
            $this->_selecionarID((string)$tabela, (int)$id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $log_email_config
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_email_config
     * 
     * @return string: valor da propriedade $log_email_config
     */
    public function _log_email_config($valor=null){
        return is_null($valor) ?
            (int)$this->log_email_config
        : $this->log_email_config = (int)$valor;
    } // Fim do método _log_email_config
    
    /**
     * Obter ou editar o valor da propriedade $log_email_ip
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_email_ip
     * 
     * @return string: valor da propriedade $log_email_ip
     */
    public function _log_email_ip($valor=null){
        return is_null($valor) ?
            (string)$this->log_email_ip
        : $this->log_email_ip = (string)$valor;
    } // Fim do método _log_email_ip
    
    /**
     * Obter ou editar o valor da propriedade $log_email_classe
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_email_classe
     * 
     * @return string: valor da propriedade $log_email_classe
     */
    public function _log_email_classe($valor=null){
        return is_null($valor) ?
            (string)$this->log_email_classe
        : $this->log_email_classe = (string)$valor;
    } // Fim do método _log_email_classe
    
    /**
     * Obter ou editar o valor da propriedade $log_email_tabela
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_email_tabela
     * 
     * @return string: valor da propriedade $log_email_tabela
     */
    public function _log_email_tabela($valor=null){
        return is_null($valor) ?
            (string)$this->log_email_tabela
        : $this->log_email_tabela = (string)$valor;
    } // Fim do método _log_email_tabela
    
    /**
     * Obter ou editar o valor da propriedade $log_email_idreg
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_email_idreg
     * 
     * @return string: valor da propriedade $log_email_idreg
     */
    public function _log_email_idreg($valor=null){
        return is_null($valor) ?
            (string)$this->log_email_idreg
        : $this->log_email_idreg = (int)$valor;
    } // Fim do método _log_email_idreg
    
    /**
     * Obter ou editar o valor da propriedade $log_email_status
     * Os status aceitos são:
     * S: solicitado
     * E: enviado
     * F: falha
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_email_status
     * 
     * @return string: valor da propriedade $log_email_status
     */
    public function _log_email_status($valor=null){
        if( is_null($valor) )
            return $this->log_email_status;
        
        if( !in_array($valor, array('S', 'E', 'F')) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);

        return $this->log_email_status = (string)$valor;
    } // Fim do método _log_email_status    
    
    /**
     * Obter ou editar o valor da propriedade $log_email_mensagem
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_email_mensagem
     * 
     * @return string: valor da propriedade $log_email_mensagem
     */
    public function _log_email_mensagem($valor=null){
        return is_null($valor) ?
            (string)$this->log_email_mensagem
        : $this->log_email_mensagem = (string)$valor;
    } // Fim do método _log_email_status
    
    /**
     * Selecionar um registro desse modelo pelo ID
     * 
     * @param int $id : ID do registro a ser selecionado
     * 
     * @return void
     */
    protected function _selecionarID($tabela, $idreg){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);
        
        # Garantir que o ID seja um número inteiro
        $id = (int)$id;
        
        $lis_m = end($this->_listar("{$this->bd_prefixo}tabela = '{$tabela}' AND {$this->bd_prefixo}idreg = {$idreg}"));
        
        # Carregar os dados obtidos do banco de dados
        # nas propriedades da classe
        foreach( $lis_m as $c => $m ):
            if( property_exists($this, $c) )
               $this->{$c} = $m;
        endforeach;
    } // Fim do método _selecionarID
    
    /**
     * Salvar determinado registro
     * 
     * Obs.: Para esse modelo não é necessário alteração dos dados
     * 
     * @param boolean $salvar - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    public function _salvar($salvar=true){
        $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                . " log_email_config, log_email_ip, log_email_classe, log_email_tabela,"
                . " log_email_idreg, log_email_mensagem, log_email_status) VALUES ("
                . " {$this->log_email_config}, '{$this->log_email_ip}', '{$this->log_email_classe}',"
                . " '{$this->log_email_tabela}', {$this->log_email_idreg}, '{$this->log_email_mensagem}', '{$this->log_email_status}')";
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        return $exec;
    } // Fim do método _salvar
} // Fim do modelo LogEmail
