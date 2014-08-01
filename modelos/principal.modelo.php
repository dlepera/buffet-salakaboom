<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:54:28
 */

namespace Modelo;

abstract class Principal{
    protected $bd_tabela;
    protected $bd_prefixo;
    protected $bd_select = 'SELECT %s FROM %s WHERE %sdelete = 0';
    
    # Gravar logs do registro
    private $mod_lr;
    
    # Campos padronizados
    protected $modelo_id, $modelo_publicar, $modelo_delete;
    
    public function __construct($tabela, $prefixo = ''){
        $this->_bd_tabela($tabela);
        $this->_bd_prefixo($prefixo);
        
        # Obter o nome dos campos padronizados
        $this->modelo_id        = "{$this->bd_prefixo}id";
        $this->modelo_publicar  = "{$this->bd_prefixo}publicar";
        $this->modelo_delete    = "{$this->bd_prefixo}delete";
        
        if( get_called_class() !== 'Modelo\LogRegistro' )
            $this->mod_lr = new \Modelo\LogRegistro();
    } // Fim do método mágico de construção
    
    /**
     * Obter o valor de uma propriedade, utilizando o método
     * de tratamento
     * 
     * @param string $nome : nome da propriedade a ser exibida
     * 
     * @return mixed: valor da propriedade ou mensagem de erro
     */
    public function __get($nome){
        # Essas propriedades podem apenas serem exibidas
        $apenas_exibir = array(
            $this->modelo_id,
            $this->modelo_publicar,
            $this->modelo_delete
        );
        
        if( in_array($nome, $apenas_exibir) )
            return $this->{$nome};
            
        $metodo = "_{$nome}";
        
        return method_exists($this, $metodo) ? 
            call_user_func_array(array($this, $metodo), array())
        : ERRO_PADRAO_PROPRIEDADE_NAO_EXISTE_OU_NAO_PODE_SER_ACESSADA;            
    } // Fim do método mágico __get
    
    /**
     * Editar o valor de uma propriedade, utilizando o método de
     * tratamento
     * 
     * @param string $nome: nome da propriedade a ser alterada
     */
    public function __set($nome, $valor){
        switch($nome):
            case $this->modelo_publicar:
                if( (int)$valor < 0 || (int)$valor > 1 )
                    throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, $this->modelo_publicar), 1500);
        
                return $this->{$this->modelo_publicar} = (int)$valor;
                
            case $this->modelo_delete:
                throw new \Exception(ERRO_PADRAO_PROPRIEDADE_APENAS_LEITURA, 1500);
        endswitch;
        
        $metodo = "_{$nome}";
        
        return method_exists($this, $metodo) ? 
            call_user_func_array(array($this, $metodo), array('valor' => $valor))
        : ERRO_PADRAO_PROPRIEDADE_NAO_EXISTE_OU_NAO_PODE_SER_ALTERADA;  
    } // Fim do método mágico __set
    
    /**
     * Ações padrões a serem executadas quando um determinado método é acionado
     * 
     * @param string $nome : Nome do método a ser executado
     * @param array $args : vetor contendo os argumentos a serem passados para o método
     */
    public function __call($nome, $args){
        $mod_registro = 'Modelo\LogRegistro';
        
        switch($nome):
            # Gravar log de inserção e alteração do registro
            case '_salvar':
                $id = $this->_salvar();
                
                if( class_exists('Modelo\LogRegistro') ):
                    $this->mod_lr->log_registro_tabela  = $this->bd_tabela;
                    $this->mod_lr->log_registro_idreg   = $id;
                    
                    $this->mod_lr->_salvar();
                endif;
                
                return $id;
                
            # Gravar log de remoção
            case '_remover':
                if( ($rem = $this->_remover()) !== false && class_exists($mod_registro) ):
                    $this->mod_lr->log_registro_tabela  = $this->bd_tabela;
                    $this->mod_lr->log_registro_idreg   = $this->{$this->modelo_id};
                    
                    $this->mod_lr->_salvar(true);
                endif;
                
                return $rem;
            
            # Selecionar as informações de inclusão e alteração do registro
            case '_selecionarID':
                $this->_selecionarID($args[0]);
                
                if( !is_null($this->{$this->modelo_id}) && get_called_class() != $mod_registro )
                    $this->mod_lr->_selecionarID($this->bd_tabela, $this->{$this->modelo_id});
                break;
        endswitch;
    } // Fim do método mágico __call

    /**
     * Obter ou editar o valor da propriedade $bd_tabela
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->bd_tabela
     * 
     * @return string: valor da propriedade $bd_tabela
     */
    public function _bd_tabela($valor=null){
        return is_null($valor) ?
            $this->bd_tabela
        : $this->bd_tabela = (string)$valor;
    } // Fim do método _bd_tabela
    
    /**
     * Obter ou editar o valor da propriedade $bd_prefixo
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->bd_prefixo
     * 
     * @return string: valor da propriedade $bd_prefixo
     */
    public function _bd_prefixo($valor=null){
        return is_null($valor) ?
            (string)$this->bd_prefixo
        : $this->bd_prefixo = (string)$valor;
    } // Fim do método _bd_tabela
    
    /**
     * Obter ou editar o valor da propriedade $bd_select
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->bd_select
     * 
     * @return string: valor da propriedade $bd_select
     */
    public function _bd_select($valor=null){
        return is_null($valor) ?
            (string)$this->bd_select
        : $this->bd_select = (string)$valor;
    } // Fim do método _bd_tabela
    
    /**
     * Obter a propriedade $mod_lr
     *  
     * @return string: valor da propriedade $bd_prefixo
     */
    public function _mod_lr(){
        return $this->mod_lr;
    } // Fim do método _bd_tabela
    
    /**
     * Listar registros desse modelos de acordo com o filtro e ordenação
     * 
     * @param string $filtro : parte da string referente à clausula WHERE da consulta SQL
     * @param string $ordem : parte da string referente à clausula ORDER BY da consulta SQL
     * @param string $campos : lista de campos a serem selecionados
     * @param int $pagina : página a ser considerada durante uma paginação de resultados.
     *  Se definida como 0 (zero) a paginação não é realizada
     * @param int $qtde : quantidade de registros a serem exibidos caso a paginação seja
     *  ativada
     * 
     * @return array: array associativo contendo o recordset da consulta
     */
    public function _listar($filtro=null, $ordem=null, $campos='*', $pagina=0, $qtde=20){
        $query = substr_count($this->bd_select, '%s') == 2 ? 
            sprintf($this->bd_select, $campos, $this->bd_tabela)
        : sprintf($this->bd_select, $campos, $this->bd_tabela, $this->bd_prefixo);
                
        if( !empty($filtro) )
            $query .= stripos($query, "WHERE") > -1 ? " AND {$filtro}" : " WHERE {$filtro}";
            
        if( !empty($ordem) )
            $query .= " ORDER BY {$ordem}";
            //echo $this->bd_select, ' <span style="color: red;">|< = >|</span> ', $query, '<br />--<br />';
        $sql = $pagina > 0 ?
            \DL::$bd_pdo->_paginacao($query, $pagina, $qtde) 
        : \DL::$bd_pdo->query($query);
        
        if( !$sql )
            return false;
        
        $r = array();
        
        while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) )
            $r[] = $rs;
        
        return $r;
    } // Fim do método _listar
    
    /**
     * Obter apenas a quantidade de registros
     * 
     * @param string $filtro : filtro a ser aplicado na consuta
     */
    public function _qtde_registros($filtro=''){
        $rs = end($this->_listar($filtro, null, 'COUNT(*) AS QTDE'));
        return $rs['QTDE'];
    } // Fim do método _qtde_registros
    
    /**
     * Selecionar um registro desse modelo pelo ID
     * 
     * @param int $id : ID do registro a ser selecionado
     * 
     * @return void
     */
    protected function _selecionarID($id){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);
        
        # Garantir que o ID seja um número inteiro
        $id = (int)$id;
        
        $lis_m = end($this->_listar("{$this->modelo_id} = {$id}"));
        
        # Carregar os dados obtidos do banco de dados
        # nas propriedades da classe
        foreach( $lis_m as $c => $m ):
            if( property_exists($this, $c) )
               $this->{$c} = $m;
        endforeach;
    } // Fim do método _selecionarID
    
    /**
     * Remover o registro
     */
    protected function _remover(){
        $rem = \DL::$bd_pdo->exec("DELETE FROM {$this->bd_tabela} WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        if( $rem === false && property_exists($this, $this->modelo_delete) )
            $rem = \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET {$this->modelo_delete} = 1 WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
            
        return (int)$rem;
    } // Fim do método _remover
} // Fim do modelo Principal
