<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 16:25:07
 */

namespace Modelo;

class ContatoSite extends Principal{
    # Propriedades do modelo
    protected $contato_site_id, $contato_site_nome, $contato_site_email, $contato_site_telefone,
        $contato_site_assunto, $contato_site_mensagem, $contato_site_delete = '0';
    
    public function __construct($id=0){
        parent::__construct('dl_site_contatos', 'contato_site_');
       
        # Query de seleção
        $this->bd_select = "SELECT"
            . " %s"
            . " FROM %s AS CS"
            . " INNER JOIN dl_site_assuntos_contato AS AC ON( AC.assunto_contato_id = CS.contato_site_assunto )"
            . " INNER JOIN dl_painel_email_logs AS LE ON( LE.log_email_tabela = 'dl_site_contatos' AND LE.log_email_idreg = CS.contato_site_id )"
            . " WHERE CS.%sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mégico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $contato_site_nome
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->contato_site_nome
     *  
     * @return string: valor da propriedade $contato_site_nome
     */
    public function _contato_site_nome($valor=null){
        return is_null($valor) ?
            (string)$this->$valor -contato_site_nome
        : $this->contato_site_nome = (string)$valor;
    } // Fim do método _contato_site_nome
    
    /**
     * Obter ou editar o valor da propriedade $contato_site_email
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->contato_site_email
     * 
     * @return string: valor da propriedade $contato_site_email
     */
    public function _contato_site_email($valor=null){
        if( is_null($valor) )
            return $this->contato_site_email;
        
        if( !$this->contato_site_email = filter_var($valor, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);
        
        return $this->contato_site_email;
    } // Fim do método _contato_site_email
    
    /**
     * Obter ou editar o valor da propriedade $contato_site_telefone
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->contato_site_telefone
     * 
     * @return string: valor da propriedade $contato_site_telefone
     */
    public function _contato_site_telefone($valor=null){
        return is_null($valor) ?
            (string)$this->contato_site_telefone
        : $this->contato_site_telefone = (string)$valor;
    } // Fim do método _contato_site_telefone
    
    /**
     * Obter ou editar o valor da propriedade $contato_site_assunto
     * 
     * @param int $valor - ID do assunto a ser vinculado com esse contato
     * 
     * @return int: valor da propriedade $contato_site_assunto
     */
    public function _contato_site_assunto($valor=null){
        return is_null($valor) ?
            (int)$this->contato_site_assunto
        : $this->contato_site_assunto = (int)$valor;
    } // Fim do método _contato_site_assunto
    
    /**
     * Obter ou editar o valor da propriedade $contato_site_mensagem
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->contato_site_mensagem
     * 
     * @return string: valor da propriedade $contato_site_mensagem
     */
    public function _contato_site_mensagem($valor=null){
        return is_null($valor) ?
            (string)$this->contato_site_mensagem
        : $this->contato_site_mensagem = (string)$valor;
    } // Fim do método _contato_site_mensagem
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     * 
     * Obs.: Esse modelo não tem a opção de alteração dos dados, apenas inserção
     */
    protected function _salvar($salvar=true){        
        $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                . " contato_site_nome, contato_site_email,"
                . " contato_site_telefone, contato_site_assunto, contato_site_mensagem) VALUES ("
                . " '{$this->contato_site_nome}', '{$this->contato_site_email}', '{$this->contato_site_telefone}',"
                . " {$this->contato_site_assunto}, '{$this->contato_site_mensagem}')";        
        
        if( !$salvar )
            return $query;
        
        if( \DL::$bd_pdo->exec($query) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        return $this->contato_site_id = \DL::$bd_pdo->lastInsertID('contato_site_id');
    } // Fim do método _salvar
} // Fim do Modelo ContatoSite
