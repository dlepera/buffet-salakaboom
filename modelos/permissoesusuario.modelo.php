<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 30/05/2014 21:40:50
 */

namespace Modelo;

class PermissoesUsuario extends Principal{
    # Propriedades desse modelo
    protected $permissao_usuario, $permissao_modulo, $permissao_ver = 0, $permissao_inserir = 0, $permissao_editar = 0,
        $permissao_remover = 0, $permissao_total = 0;
    
    public function __construct($u = null, $m = null){
        parent::__construct('dl_painel_usuarios_permissoes', 'permissao_');
       
        # Query de seleção
        $this->bd_select = 'SELECT %s FROM %s';
        
        if( !empty($u) && !empty($m) )
            $this->_selecionarID($u, $m);
    } // Fim do método mágico de construção da classe
        
    /**
     * Selecionar um registro desse modelo pelo ID
     * 
     * @param int $usuario: ID do usuário
     * @param int $modulo: ID do módulo
     * 
     * @return void
     */
    public function _selecionarID($usuario, $modulo){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);
        
        # Garantir que os IDs sejam números inteiros
        $usuario = (int)$usuario;
        $modulo  = (int)$modulo;
        
        $lis_m = end($this->_listar("{$this->bd_prefixo}usuario = {$usuario} AND {$this->bd_prefixo}modulo = {$modulo}"));
        
        # Carregar os dados obtidos do banco de dados
        # nas propriedades da classe
        foreach( $lis_m as $c => $m ):
            if( property_exists($this, $c) )
               $this->{$c} = $m;
        endforeach;
    } // Fim do método _selecionarID
    
    /**
     * Obter ou editar o valor da propriedade $permissao_usuario
     * 
     * @param int $valor: string contendo o valor a ser atribuído à $permissao_usuario
     * 
     * @return int: valor da propriedade $permissao_usuario
     */
    public function _permissao_usuario($valor=null){
        return is_null($valor) ?
            (int)$this->permissao_usuario
        : $this->permissao_usuario = (int)$valor;
    } // Fim do método _permissao_usuario
    
    /**
     * Obter ou editar o valor da propriedade $permissao_modulo
     * 
     * @param int $valor: string contendo o valor a ser atribuído à $permissao_modulo
     * 
     * @return int: valor da propriedade $permissao_modulo
     */
    public function _permissao_modulo($valor=null){
        return is_null($valor) ?
            (int)$this->permissao_modulo
        : $this->permissao_modulo = (int)$valor;
    } // Fim do método _permissao_modulo
    
    /**
     * Obter ou editar o valor da propriedade $permissao_ver
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $permissao_ver
     * 
     * @return string: valor da propriedade $permissao_ver
     */
    public function _permissao_ver($valor=null){
        if( is_null($valor) )
            return $this->permissao_ver;
        
        if( $valor < 0 || $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->permissao_ver = (int)$valor;
    } // Fim do método _permissao_ver
    
    /**
     * Obter ou editar o valor da propriedade $permissao_inserir
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $permissao_inserir
     * 
     * @return string: valor da propriedade $permissao_inserir
     */
    public function _permissao_inserir($valor=null){
        if( is_null($valor) )
            return $this->permissao_inserir;
        
        if( $valor < 0 || $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->permissao_inserir = (int)$valor;
    } // Fim do método _permissao_inserir
    
    /**
     * Obter ou editar o valor da propriedade $permissao_editar
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $permissao_editar
     * 
     * @return string: valor da propriedade $permissao_editar
     */
    public function _permissao_editar($valor=null){
        if( is_null($valor) )
            return $this->permissao_editar;
        
        if( $valor < 0 || $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->permissao_editar = (int)$valor;
    } // Fim do método _permissao_editar
    
    /**
     * Obter ou editar o valor da propriedade $permissao_remover
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $permissao_remover
     * 
     * @return string: valor da propriedade $permissao_remover
     */
    public function _permissao_remover($valor=null){
        if( is_null($valor) )
            return $this->permissao_remover;
        
        if( $valor < 0 || $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->permissao_remover = (int)$valor;
    } // Fim do método _permissao_remover
    
    /**
     * Obter ou editar o valor da propriedade $permissao_total
     * 
     * @param string $valor: string contendo o valor a ser atribuído à $permissao_total
     * 
     * @return string: valor da propriedade $permissao_total
     */
    public function _permissao_total($valor=null){
        if( is_null($valor) )
            return $this->permissao_total;
        
        if( $valor < 0 || $valor > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);
        
        return $this->permissao_total = (int)$valor;
    } // Fim do método _permissao_total
    
    /**
     * Salvar determinado registro
     * 
     * Obs.: Esse modelo não terá a opção de editar
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        if( !$this->_qtde_registros("permissao_usuario = {$this->permissao_usuario} AND permissao_modulo = {$this->permissao_modulo}") ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " permissao_usuario, permissao_modulo, permissao_ver, permissao_inserir, permissao_editar, permissao_remover, permissao_total) VALUES ("
                    . " {$this->permissao_usuario}, {$this->permissao_modulo}, '{$this->permissao_ver}', '{$this->permissao_inserir}', '{$this->permissao_editar}',"
                    . " '{$this->permissao_remover}', '{$this->permissao_total}')";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " permissao_ver = '{$this->permissao_ver}',"
                    . " permissao_inserir = '{$this->permissao_inserir}',"
                    . " permissao_editar = '{$this->permissao_editar}',"
                    . " permissao_remover = '{$this->permissao_remover}',"
                    . " permissao_total = '{$this->permissao_total}'"
                    . " WHERE permissao_usuario = {$this->permissao_usuario} AND permissao_modulo = {$this->permissao_modulo}";
        endif;
                
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        return $exec;
    } // Fim do método _salvar
} // Fim do modelo PermissoesUsuario
