<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 31, 2014 11:15:52 AM
 */

namespace Modelo;

class Orcamento extends Principal{
    protected $orcamento_id, $orcamento_info_nome, $orcamento_info_email, $orcamento_info_telefone, $orcamento_festa_data,
        $orcamento_festa_pacote, $orcamento_festa_valor_pacote, $orcamento_festa_convidados = 50, $orcamento_delete = 1,
        $orcamento_opcionais = array();
    
    public function __construct($id=0){
        parent::__construct('salakaboom_orcamentos', 'orcamento_');
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS O"
            . " INNER JOIN salakaboom_produtos AS P ON( P.produto_id = O.orcamento_festa_pacote AND P.produto_tipo = 1 )"
            . " WHERE O.%sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID ($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_info_nome
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->orcamento_info_nome
     * 
     * @return string: valor da propriedade $orcamento_info_nome
     */
    public function _orcamento_info_nome($valor=null){
        return is_null($valor) ?
            (string)$this->orcamento_info_nome        
        : $this->orcamento_info_nome = (string)$valor;
    } // Fim do método _orcamento_info_nome
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_info_email
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->orcamento_info_email
     * 
     * @return string: valor da propriedade $orcamento_info_email
     */
    public function _orcamento_info_email($valor=null){
        if( is_null($valor) )
            return $this->orcamento_info_email;
        
        if( !empty($this->orcamento_info_email) && !$this->orcamento_info_email = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->orcamento_info_email = (string)$valor;
    } // Fim do método _orcamento_info_email
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_info_telefone
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->orcamento_info_telefone
     * 
     * @return string: valor da propriedade $orcamento_info_telefone
     */
    public function _orcamento_info_telefone($valor=null){
        return is_null($valor) ?
            (string)$this->orcamento_info_telefone        
        : $this->orcamento_info_telefone = (string)$valor;
    } // Fim do método _orcamento_info_telefone
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_festa_data
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->orcamento_festa_data
     * 
     * @return string: valor da propriedade $orcamento_festa_data
     */
    public function _orcamento_festa_data($valor=null){
        return is_null($valor) ?
            (string)\Funcoes::_formatardatahora($this->orcamento_festa_data, $_SESSION['data_hora_formato_data'])
        : $this->orcamento_festa_data = (string)\Funcoes::_formatardatahora($valor, \DL::$bd_dh_formato_data);
    } // Fim do método _orcamento_festa_data
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_festa_pacote
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->orcamento_festa_pacote
     * 
     * @return int - valor da propriedade $orcamento_festa_pacote
     */
    public function _orcamento_festa_pacote($valor=null){
        return is_null($valor) ?
            (int)$this->orcamento_festa_pacote        
        : $this->orcamento_festa_pacote = (int)$valor;
    } // Fim do método _orcamento_festa_pacote
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_festa_valor_pacote
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->orcamento_festa_valor_pacote
     * 
     * @return string - valor da propriedade $orcamento_festa_valor_pacote
     */
    public function _orcamento_festa_valor_pacote($valor=null){
        return is_null($valor) ?
            (string)str_replace('.', ',', $this->orcamento_festa_valor_pacote)
        : $this->orcamento_festa_valor_pacote = (string)str_replace(',', '.', $valor);
    } // Fim do método _orcamento_festa_valor_pacote
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_festa_convidados
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->orcamento_festa_convidados
     * 
     * @return int - valor da propriedade $orcamento_festa_convidados
     */
    public function _orcamento_festa_convidados($valor=null){
        return is_null($valor) ?
            (int)$this->orcamento_festa_convidados        
        : $this->orcamento_festa_convidados = (int)$valor;
    } // Fim do método _orcamento_festa_convidados
    
    /**
     * Obter ou editar o valor da propriedade $orcamento_opcionais
     * 
     * @param array $valor - string contendo o valor a ser atribuído à $this->orcamento_opcionais
     * 
     * @return array - valor da propriedade $orcamento_opcionais
     */
    public function _orcamento_opcionais($valor=null){
        return is_null($valor) ?
            (array)$this->orcamento_opcionais        
        : $this->orcamento_opcionais = (array)$valor;
    } // Fim do método _orcamento_festa_convidados
    
    /**
     * Selecionar um registro desse modelo pelo ID
     * 
     * @param int $id : ID do registro a ser selecionado
     * 
     * @return void
     */
    protected function _selecionarID($id){
        parent::_selecionarID($id);
        
        # Selecionar os opcionais desse orcamento
        if( $this->orcamento_id > 0 ):
            $sql = \DL::$bd_pdo->query(
                "SELECT"
                . " opcional_orcamento_produto"
                . " FROM {$this->bd_tabela}_opcionais"
                . " WHERE opcional_orcamento = {$this->orcamento_id}"
            );
                
            while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) )
                $this->orcamento_opcionais[] = $rs['opcional_orcamento_produto'];
        endif;
    } // Fim do método _selecionarID
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update  
     * 
     * Obs.: Essa opção tem apenas a função
     */
    protected function _salvar($salvar=true){
        # Obter o valor atual do produto
        $mod_p = new \Modelo\Produto($this->orcamento_festa_pacote);
        $this->_orcamento_festa_valor_pacote($mod_p->produto_valor);
        
        $query = "INSERT INTO {$this->bd_tabela} ("
                . " orcamento_info_nome, orcamento_info_email, orcamento_info_telefone, orcamento_festa_data, orcamento_festa_pacote,"
                . " orcamento_festa_valor_pacote, orcamento_festa_convidados) VALUES ("
                . " '{$this->orcamento_info_nome}', '{$this->orcamento_info_email}', '{$this->orcamento_info_telefone}',"
                . " '{$this->orcamento_festa_data}', {$this->orcamento_festa_pacote}, '{$this->orcamento_festa_valor_pacote}',"
                . " {$this->orcamento_festa_convidados})";
                
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->orcamento_id = \DL::$bd_pdo->lastInsertID('orcamento_id');
        
        # Incluir os opcionais
        # Caso a quantidade de pessoas tenha ultrapassado o pacote
        # da festa, adicionar o faltante como convidados adicionais
        $mod_tv = new \Modelo\TipoValor($mod_p->produto_tipo_valor);
        
        if( ($adc = $this->orcamento_festa_convidados - $mod_tv->tipo_valor_fator) > 0 ):
            $lis_ca = end($mod_p->_listar('produto_tipo = 4 AND produto_publicar = 1', null, 'produto_id, produto_valor'));
        
            \DL::$bd_pdo->exec(
                "INSERT INTO {$this->bd_tabela}_opcionais"
                . " (opcional_orcamento, opcional_orcamento_produto, opcional_orcamento_valor, opcional_orcamento_qtde) VALUES"
                . " ({$this->orcamento_id}, {$lis_ca['produto_id']}, '{$lis_ca['produto_valor']}', {$adc})"
            );
        endif;
        
        if( count($this->orcamento_opcionais) > 0 ):            
            foreach( $this->orcamento_opcionais as $o ):
                $mod_p->_selecionarID($o);
                \DL::$bd_pdo->exec(
                    "INSERT INTO {$this->bd_tabela}_opcionais"
                    . " (opcional_orcamento, opcional_orcamento_produto, opcional_orcamento_valor, opcional_orcamento_qtde) VALUES"
                    . " ({$this->orcamento_id}, {$mod_p->produto_id}, '{$mod_p->produto_valor}', 1)"
                );
            endforeach;
        endif;
        
        return $this->orcamento_id;
    } // Fim do método _salvar
} // Fim do Modeo Orcamento
