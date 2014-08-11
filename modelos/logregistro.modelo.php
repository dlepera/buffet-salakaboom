<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 22/05/2014 16:52:19
 */

namespace Modelo;

class LogRegistro extends Principal{
    # Propriedades do modelo
    protected $log_registro_tabela, $log_registro_idreg, $log_registro_data_criacao,
        $log_registro_data_alteracao, $log_registro_data_exclusao, $log_registro_usuario_criacao,
        $log_registro_usuario_alteracao, $log_registro_usuario_exclusao, $log_registro_ip_criacao,
        $log_registro_ip_alteracao, $log_registro_ip_exclusao;
 
    public function __construct($tabela=null, $idreg=null){
        parent::__construct('dl_painel_registros_logs', 'log_registro_');
        
        # Query de seleção
        $this->bd_select = 'SELECT %s FROM %s';
                
        if( !is_null($tabela) && !is_null($idreg) )
            $this->_selecionarID($tabela, $idreg);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter o valor das propriedades
     * 
     * @param string $nome: nome da propriedade a ser obtida
     */
    public function __get($nome){
        if( property_exists($this, $nome) )          
            return $this->{$nome};
    } // Fim do método mágico __get
    
    /**
     * Obter ou editar o valor da propriedade $log_registro_tabela
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_registro_tabela
     * 
     * @return string: valor da propriedade $log_registro_tabela
     */
    public function _log_registro_tabela($valor=null){
        return is_null($valor) ?
            (string)$this->log_registro_tabela
        : $this->log_registro_tabela = (int)$valor;
    } // Fim do método _log_registro_tabela
    
    /**
     * Obter ou editar o valor da propriedade $log_registro_idreg
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->log_registro_idreg
     * 
     * @return string: valor da propriedade $log_registro_idreg
     */
    public function _log_registro_idreg($valor=null){
        return is_null($valor) ?
            (string)$this->log_registro_idreg
        : $this->log_registro_idreg = (int)$valor;
    } // Fim do método _log_registro_idreg
    
    /**
     * Selecionar um registro desse modelo pelo ID
     * 
     * Obs.: No caso desse modelo a chave é composta: tabela e id do registro
     * 
     * @param string $tabela
     * @param int $idreg - ID do registro a ser selecionado
     * 
     * @return void
     */
    public function _selecionarID($tabela, $idreg){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);
        
        # Garantir que o ID seja um número inteiro
        # e a tabela uma string
        $idreg  = (int)$idreg;
        $tabela = (string)$tabela;
        
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
     * @param bool $salvar - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    public function _salvar($remover = false, $salvar=true){
        $this->_selecionarID($this->log_registro_tabela, $this->log_registro_idreg);
        
        if( is_null($this->log_registro_data_criacao) || $this->log_registro_data_criacao == '0000-00-00 00:00:00' ):
            # Complementar informações de inserção
            $this->log_registro_usuario_criacao     = (int)$_SESSION['usuario_id'];
            $this->log_registro_data_criacao        = date(\DL::$bd_dh_formato_completo);
            $this->log_registro_ip_criacao          = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
            
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " log_registro_usuario_criacao, log_registro_data_criacao, log_registro_ip_criacao, log_registro_idreg, log_registro_tabela) VALUES ("
                    . " {$this->log_registro_usuario_criacao}, '{$this->log_registro_data_criacao}', '{$this->log_registro_ip_criacao}', {$this->log_registro_idreg}, '{$this->log_registro_tabela}')";
        else:
            if( !$remover ):
                # Complementar os dados de atualização
                $this->log_registro_usuario_alteracao   = (int)$_SESSION['usuario_id'];
                $this->log_registro_data_alteracao      = date(\DL::$bd_dh_formato_completo);
                $this->log_registro_ip_alteracao        = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

                $query = "UPDATE ". $this->_bd_tabela() ." SET"
                        . " log_registro_usuario_alteracao = {$this->log_registro_usuario_alteracao},"
                        . " log_registro_data_alteracao = '{$this->log_registro_data_alteracao}',"
                        . " log_registro_ip_alteracao = '{$this->log_registro_ip_alteracao}'"
                        . " WHERE log_registro_idreg = {$this->log_registro_idreg} AND log_registro_tabela = '{$this->log_registro_tabela}'";
            else:
                # Complementar os dados de remoção
                $this->log_registro_usuario_exclusao    = (int)$_SESSION['usuario_id'];
                $this->log_registro_data_exclusao       = date(\DL::$bd_dh_formato_completo);
                $this->log_registro_ip_exclusao         = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

                $query = "UPDATE ". $this->_bd_tabela() ." SET"
                        . " log_registro_usuario_exclusao = {$this->log_registro_usuario_exclusao},"
                        . " log_registro_data_exclusao = '{$this->log_registro_data_exclusao}',"
                        . " log_registro_ip_exclusao = '{$this->log_registro_ip_exclusao}'"
                        . " WHERE log_registro_idreg = {$this->log_registro_idreg} AND log_registro_tabela = '{$this->log_registro_tabela}'";
            endif;
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        return $exec;
    } // Fim do método _salvar
} // Fim do modelo LogRegistro
