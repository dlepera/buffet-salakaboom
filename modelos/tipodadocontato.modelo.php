<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/06/2014 21:14:57
 */

namespace Modelo;

class TipoDadoContato extends Principal{
    # Propriedades do modelo
    protected $tipo_dado_id, $tipo_dado_descr, $tipo_dado_icone, $tipo_dado_rede_social = 0, $tipo_dado_publicar = 1, $tipo_dado_delete = 0;
        
    public function __construct($id=0){
        parent::__construct('dl_site_dados_contato_tipos', 'tipo_dado_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $tipo_dado_descr
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->tipo_dado_descr
     * 
     * @return string: valor da propriedade $tipo_dado_descr
     */
    public function _tipo_dado_descr($valor=null){
        return is_null($valor) ?
            (string)$this->tipo_dado_descr
        : $this->tipo_dado_descr = (string)$valor;
    } // Fim do método _tipo_dado_descr
    
    /**
     * Obter ou editar o valor da propriedade $tipo_dado_icone
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->tipo_dado_icone
     * 
     * @return string: valor da propriedade $tipo_dado_icone
     */
    public function _tipo_dado_icone($valor=null){
        return is_null($valor) ?
            (string)$this->tipo_dado_icone
        : $this->tipo_dado_icone = (string)$valor;
    } // Fim do método _tipo_dado_icone
    
    /**
     * Obter ou editar o valor da propriedade $tipo_dado_rede_social
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->tipo_dado_rede_social
     * 
     * @return int: valor da propriedade $tipo_dado_rede_social
     */
    public function _tipo_dado_rede_social($valor=null){
        return is_null($valor) ?
            (int)$this->tipo_dado_rede_social
        : $this->tipo_dado_rede_social = (int)$valor;
    } // Fim do método _tipo_dado_icone
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){
        # Salvar o arquivo no diretório de uploads do site
        if( file_exists($_FILES['imagem']['tmp_name']) && $salvar ):
			$up = new \Upload('/aplicacao/uploads/contatos/');
			
			if( $up->_salvar(strtolower(str_replace(' ', '-', \Funcoes::_removeracentuacao($this->tipo_dado_descr))), true) )
				$this->tipo_dado_icone = $up->arquivos_salvos[0];
            
            # Redimensionar a imagem
            $obj_im = new \Imagem($this->tipo_dado_icone);
            $obj_im->_redimensionar(64);
            $obj_im->_salvar($this->tipo_dado_icone);
		endif;
        
        if( !$this->tipo_dado_id ):
            $query = "INSERT INTO ". $this->_bd_tabela() ." ("
                    . " tipo_dado_descr, tipo_dado_icone, tipo_dado_rede_social, tipo_dado_publicar) VALUES ("
                    . " '{$this->tipo_dado_descr}', '{$this->tipo_dado_icone}', {$this->tipo_dado_rede_social}, {$this->tipo_dado_publicar})";
        else:
            $query = "UPDATE ". $this->_bd_tabela() ." SET"
                    . " tipo_dado_descr = '{$this->tipo_dado_descr}',"
                    . " tipo_dado_icone = '{$this->tipo_dado_icone}',"
                    . " tipo_dado_rede_social = {$this->tipo_dado_rede_social},"
                    . " tipo_dado_publicar = {$this->tipo_dado_publicar}"
                    . " WHERE tipo_dado_id = {$this->tipo_dado_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->tipo_dado_id = \DL::$bd_pdo->lastInsertID('tipo_dado_id');
        
        return $this->tipo_dado_id;
    } // Fim do método _salvar
    
    /**
     * Remover o registro
     */
    protected function _remover(){
        $rem = \DL::$bd_pdo->exec("DELETE FROM {$this->bd_tabela} WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
        
        if( $rem === false && property_exists($this, $this->modelo_delete) )
            $rem = \DL::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET {$this->modelo_delete} = 1 WHERE {$this->modelo_id} = {$this->{$this->modelo_id}}");
            
        # Remover o icone desse registro
        unlink($this->tipo_dado_icone);
        
        return (int)$rem;
    } // Fim do método _remover
} // Fim do modelo TipoDadoContato
