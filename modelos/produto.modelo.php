<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 09/12/2013
 */

namespace Modelo;
 
class Produto extends Principal{
	# Propriedades de assuntos de contatos do site
	protected $produto_id, $produto_tipo, $produto_nome, $produto_descr, $produto_valor, $produto_tipo_valor, $produto_dispon = array(),
        $produto_publicar = 1, $produto_delete = 0;
			
	public function __construct($id=0){
        parent::__construct('salakaboom_produtos', 'produto_');
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS P"
            . " INNER JOIN salakaboom_produtos_tipos AS TP ON( TP.tipo_produto_id = P.produto_tipo )"
            . " INNER JOIN salakaboom_produtos_tipos_valores AS TV ON( TV.tipo_valor_id = P.produto_tipo_valor )"
            . " WHERE %sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
	
    /**
     * Obter ou editar o valor da propriedade $produto_tipo
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->produto_tipo
     * 
     * @return int - valor da propriedade $produto_tipo
     */
    public function _produto_tipo($valor=null){
        return is_null($valor) ?
            (int)$this->produto_tipo        
        : $this->produto_tipo = (int)$valor;
    } // Fim do método _produto_tipo
    
    /**
     * Obter ou editar o valor da propriedade $produto_nome
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->produto_nome
     * 
     * @return string: valor da propriedade $produto_nome
     */
    public function _produto_nome($valor=null){
        return is_null($valor) ?
            (string)$this->produto_nome        
        : $this->produto_nome = (string)$valor;
    } // Fim do método _produto_nome
    
    /**
     * Obter ou editar o valor da propriedade $produto_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->produto_descr
     * 
     * @return string: valor da propriedade $produto_descr
     */
    public function _produto_descr($valor=null){
        return is_null($valor) ?
            (string)$this->produto_descr        
        : $this->produto_descr = (string)$valor;
    } // Fim do método _produto_descr
    
    /**
     * Obter ou editar o valor da propriedade $produto_valor
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->produto_valor
     * 
     * @return string: valor da propriedade $produto_valor
     */
    public function _produto_valor($valor=null){
        return is_null($valor) ?
            (string)str_replace('.', ',', $this->produto_valor)
        : $this->produto_valor = (string)str_replace(',', '.', $valor);
    } // Fim do método _produto_valor
    
    /**
     * Obter ou editar o valor da propriedade $produto_tipo_valor
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->produto_tipo_valor
     * 
     * @return int - valor da propriedade $produto_tipo_valor
     */
    public function _produto_tipo_valor($valor=null){
        return is_null($valor) ?
            (int)$this->produto_tipo_valor        
        : $this->produto_tipo_valor = (int)$valor;
    } // Fim do método _produto_tipo_valor
    
    /**
     * Obter ou editar o valor da propriedade $produto_dispon
     * 
     * @param array $valor - string contendo o valor a ser atribuído à $this->produto_dispon
     * 
     * @return array - valor da propriedade $produto_dispon
     */
    public function _produto_dispon($valor=null){
        return is_null($valor) ?
            (array)$this->produto_dispon        
        : $this->produto_dispon = (array)$valor;
    } // Fim do método _produto_dispon
    
	/*
	 * Selecionar pelo ID e publicar o resultado no objeto
	 * @param int $id: ID a ser buscado no banco de dados
	 * 
	 * @return void ou false
	 */
	public function _selecionarID($id){
		parent::_selecionarID($id);
        
        if( $this->produto_id > 0 ):
            # Selecionar os dias de disponibilidade
            $query = "SELECT"
                    ." dispon_dia_semana"
                    ." FROM {$this->bd_tabela}_dispon"
                    ." WHERE dispon_produto = {$this->produto_id}";
            $sql	= \DL::$bd_pdo->query($query);

            while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) )
                $this->produto_dispon[] = $rs['dispon_dia_semana'];
        endif;
	} // Fim do método _selecionarID
	
	/**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->produto_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " produto_tipo, produto_nome, produto_descr, produto_valor, produto_tipo_valor, produto_publicar) VALUES ("
                    . " {$this->produto_tipo}, '{$this->produto_nome}', '{$this->produto_descr}', '{$this->produto_valor}',"
                    . " {$this->produto_tipo_valor}, {$this->produto_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " produto_tipo = {$this->produto_tipo},"
                    . " produto_nome = '{$this->produto_nome}',"
                    . " produto_descr = '{$this->produto_descr}',"
                    . " produto_valor = '{$this->produto_valor}',"
                    . " produto_tipo_valor = {$this->produto_tipo_valor},"
                    . " produto_publicar = {$this->produto_publicar}"
                    . " WHERE produto_id = {$this->produto_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->produto_id = \DL::$bd_pdo->lastInsertID('produto_id');
        
        # Salvar os dias em que esse produto estará disponível
        foreach( $this->produto_dispon as $d )
            \DL::$bd_pdo->exec("INSERT INTO salakaboom_produtos_dispon VALUES ({$this->produto_id}, {$d})");
                
        return $this->produto_id;
    } // Fim do método _salvar
	
    /**
     * Filtrar pacotes de festa de acordo com a data informada
     * 
     * @param string $data - data a ser pesquisada
     * @return array - vetor contendo os resultados da consulta
     */
	public function _filtrarfesta($data){        
		if( !empty($data) && $data != '__/__/____'):
			# Identificar o dia da semana refrente à data passada
	        preg_match('#(\d{2})/(\d{2})/(\d{4})#', $data, $data);
	        $diasemana = date('w', mktime(0, 0, 0, $data[2], $data[1], $data[3]))+1;
			
			$query = "SELECT"
					. " P.produto_id, P.produto_nome"
					. " FROM {$this->bd_tabela} AS P"
					. " LEFT JOIN {$this->bd_tabela}_dispon AS D ON( D.dispon_produto = P.produto_id )"
					. " LEFT JOIN salakaboom_dias_semana AS DS ON( DS.dia_semana_id = D.dispon_dia_semana )"
					. " WHERE DS.dia_semana_id = {$diasemana}"
					. " AND P.produto_publicar = 1"
					. " AND P.produto_tipo = 1";
		else:
			$query = "SELECT"
					. " produto_id, produto_nome"
					. " FROM {$this->bd_tabela}"
                    . " WHERE produto_publicar = 1"
					. " AND produto_tipo = 1";
		endif;
		
		$sql = \DL::$bd_pdo->query($query);
		
		$r = array();
		
		while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) ):
			\Funcoes::_converterencode($rs, 'UTF-8', \DL::$ap_encoding);
			$r[] = $rs;
		endwhile;
			
		return $r;
	} // Fim do método _filtrarfesta 
    
    
    /**
     * Listar as informações dos produtos adicionados em um determinado orçamento
     * 
     * @param int $orcamento - ID do orçamento a ser selecionado
     * @param string $ordem - trecho a er incluído na query de consulta na cláusula WHERE
     * @param string $campos - trecho a er incluído na query de consulta na cláusula SELECT
     * @return array - vetor contendo os resultados da consulta
     */
    public function _listaropcionais($orcamento, $ordem = null, $campos = '*'){
        # Armazenar a query original para utilizá-la
        # após a seleção dos opcionais
        $query = $this->bd_select;
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS P"
            . " RIGHT JOIN salakaboom_orcamentos_opcionais AS O ON( O.opcional_orcamento_produto = P.produto_id )"
            . " WHERE P.%sdelete = 0";
        
        $r = $this->_listar("O.opcional_orcamento = {$orcamento}", $ordem, $campos);
        
        $this->bd_select = $query;
        
        return $r;
    } // Fim do método _listaropcionais
    
    public function _qtde_convidados($produto){
        $this->_selecionarID($produto);
        
        # Utilizar o modelo TipoValor
        $mod_tv = new \Modelo\TipoValor($this->produto_tipo_valor);
        
        return $mod_tv->tipo_valor_fator;
    } // Fim do método _qtde_convidados
} // Fim da classe Produto
