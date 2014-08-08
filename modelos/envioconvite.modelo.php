<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 09/01/2014
 */

namespace Modelo;
 
class EnvioConvite extends Principal{
	# Propriedades do modelo
	protected $envio_convite_id, $envio_convite_festa_aniversariante, $envio_convite_festa_data, $envio_convite_festa_inicio,
        $envio_convite_festa_fim, $envio_convite_festa_idade, $envio_convite_modelo, $envio_convite_delete = 0,
        $envio_convite_convidados_nomes = array(), $envio_convite_convidados_emails = array();
	
	public function __construct($id=0){
        parent::__construct('salakaboom_convites_envios', 'envio_convite_');
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS E"
            . " INNER JOIN salakaboom_convites_modelos AS M ON( M.modelo_convite_id = E.envio_convite_modelo )"
            . " WHERE %sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $envio_convite_festa_aniversariante
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->envio_convite_festa_aniversariante
     * 
     * @return string - valor da propriedade $envio_convite_festa_aniversariante
     */
    public function _envio_convite_festa_aniversariante($valor=null){
        return is_null($valor) ?
            (string)$this->envio_convite_festa_aniversariante        
        : $this->envio_convite_festa_aniversariante = (string)$valor;
    } // Fim do método _envio_convite_festa_aniversariante
    
    /**
     * Obter ou editar o valor da propriedade $envio_convite_festa_data
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->envio_convite_festa_data
     * 
     * @return string - valor da propriedade $envio_convite_festa_data
     */
    public function _envio_convite_festa_data($valor=null){
        return is_null($valor) ?
            (string)\Funcoes::_formatardatahora($this->envio_convite_festa_data, $_SESSION['data_hora_formato_data'])
        : $this->envio_convite_festa_data = (string)\Funcoes::_formatardatahora($valor, \DL::$bd_dh_formato_data);
    } // Fim do método envio_convite_festa_data
    
    /**
     * Obter ou editar o valor da propriedade $envio_convite_inicio
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->envio_convite_inicio
     * 
     * @return string - valor da propriedade $envio_convite_inicio
     */
    public function _envio_convite_festa_inicio($valor=null){
        return is_null($valor) ?
            (string)\Funcoes::_formatardatahora($this->envio_convite_festa_inicio, $_SESSION['data_hora_formato_hora'])
        : $this->envio_convite_festa_inicio = (string)\Funcoes::_formatardatahora($valor, \DL::$bd_dh_formato_hora);
    } // Fim do método envio_convite_festa_inicio
    
    /**
     * Obter ou editar o valor da propriedade $envio_convite_festa_fim
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->envio_convite_festa_fim
     * 
     * @return string - valor da propriedade $envio_convite_festa_fim
     */
    public function _envio_convite_festa_fim($valor=null){
        return is_null($valor) ?
            (string)\Funcoes::_formatardatahora($this->envio_convite_festa_fim, $_SESSION['data_hora_formato_hora'])
        : $this->envio_convite_festa_fim = (string)\Funcoes::_formatardatahora($valor, \DL::$bd_dh_formato_hora);
    } // Fim do método _envio_convite_festa_fim
    
    /**
     * Obter ou editar o valor da propriedade $envio_convite_festa_idade
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->envio_convite_festa_idade
     * 
     * @return int - valor da propriedade $envio_convite_festa_idade
     */
    public function _envio_convite_festa_idade($valor=null){
        return is_null($valor) ?
            (int)$this->envio_convite_festa_idade        
        : $this->envio_convite_festa_idade = (int)$valor;
    } // Fim do método _envio_convite_festa_idade
    
    /**
     * Obter ou editar o valor da propriedade $envio_convite_modelo
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->envio_convite_modelo
     * 
     * @return int - valor da propriedade $envio_convite_modelo
     */
    public function _envio_convite_modelo($valor=null){
        return is_null($valor) ?
            (int)$this->envio_convite_modelo        
        : $this->envio_convite_modelo = (int)$valor;
    } // Fim do método _envio_convite_modelo
	
    /**
     * Obter ou editar o valor da propriedade $envio_convite_convidados_nomes
     * 
     * @param array $valor - string contendo o valor a ser atribuído à $this->envio_convite_convidados_nomes
     * 
     * @return array - valor da propriedade $envio_convite_convidados_nomes
     */
    public function _envio_convite_convidados_nomes($valor=null){
        return is_null($valor) ?
            (array)$this->envio_convite_convidados_nomes        
        : $this->envio_convite_convidados_nomes = (array)$valor;
    } // Fim do método _envio_convite_convidados_nomes
    
    /**
     * Obter ou editar o valor da propriedade $envio_convite_convidados_emails
     * 
     * @param array $valor - string contendo o valor a ser atribuído à $this->envio_convite_convidados_emails
     * 
     * @return array - valor da propriedade $envio_convite_convidados_emails
     */
    public function _envio_convite_convidados_emails($valor=null){
        return is_null($valor) ?
            (array)$this->envio_convite_convidados_emails        
        : $this->envio_convite_convidados_emails = (array)$valor;
    } // Fim do método _envio_convite_convidados_emails
    
	/**
	 * Salvar o conteúdo do objeto no banco de dados
	 */
	public function _salvar($salvar = true){		
        $query = "INSERT INTO {$this->bd_tabela} ("
            . " envio_convite_festa_aniversariante, envio_convite_festa_data, envio_convite_festa_inicio, envio_convite_festa_fim,"
            . " envio_convite_festa_idade, envio_convite_modelo) VALUES ("
            . " '{$this->envio_convite_festa_aniversariante}', '{$this->envio_convite_festa_data}', '{$this->envio_convite_festa_inicio}',"
            . " '{$this->envio_convite_festa_fim}', {$this->envio_convite_festa_idade}, {$this->envio_convite_modelo})";
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        $this->envio_convite_id = \DL::$bd_pdo->lastInsertID('envio_convite_id');
        
        # Incluir os convidados
        foreach( $this->envio_convite_convidados_emails as $k => $ce ):
            \DL::$bd_pdo->exec(
                "INSERT INTO {$this->bd_tabela}_convidados (convidado_envio, convidado_envio_nome, convidado_envio_email) VALUES"
                . " ({$this->envio_convite_id}, '{$this->envio_convite_convidados_nomes[$k]}', '{$ce}')"
            );
        endforeach;
        
        return $this->envio_convite_id;
	} // Fim do médoto _salvar
    
    public function _selecionarID($id){
        parent::_selecionarID($id);
        
        # Selecionar os convidados desse envio
        $sql = \DL::$bd_pdo->query("SELECT convidado_envio_nome, convidado_envio_email FROM {$this->bd_tabela}_convidados WHERE convidado_envio = {$this->envio_convite_id}");
        
        if( $sql !== false ):
            while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) ):
                $this->envio_convite_convidados_nomes[] = $rs['convidado_envio_nome'];
                $this->envio_convite_convidados_emails[] = $rs['convidado_envio_email'];
            endwhile;
        endif;
    } // Fim do método _selecionarID
} // Fim da classe EnvioConvite
