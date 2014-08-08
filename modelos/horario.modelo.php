<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Aug 5, 2014 11:45:16 AM
 */

namespace Modelo;

class Horario extends Principal{
    protected $horario_id, $horario_dia_semana, $horario_abertura, $horario_fechamento, $horario_consultar = 0, $horario_publicar = 1,
        $horario_delete = 0;
    
    public function __construct($id=0){
        parent::__construct('salakaboom_horarios', 'horario_');
        
        $this->bd_select = "SELECT %s"
            . " FROM %s AS H"
            . " INNER JOIN salakaboom_dias_semana AS DS ON( DS.dia_semana_id = H.horario_dia_semana )"
            . " WHERE %sdelete = 0";
        
        if( !empty($id) )
            $this->_selecionarID ($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $horario_dia_semana
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->horario_dia_semana
     * 
     * @return int - valor da propriedade $horario_dia_semana
     */
    public function _horario_dia_semana($valor=null){
        return is_null($valor) ?
            (int)$this->horario_dia_semana        
        : $this->horario_dia_semana = (int)$valor;
    } // Fim do método _horario_dia_semana
    
    /**
     * Obter ou editar o valor da propriedade $horario_abertura
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->horario_abertura
     * 
     * @return string - valor da propriedade $horario_abertura
     */
    public function _horario_abertura($valor=null){
        return is_null($valor) ?
            (string)\Funcoes::_formatardatahora($this->horario_abertura, \DL::$dh_formato_hora)
        : $this->horario_abertura = (string)\Funcoes::_formatardatahora($valor, \DL::$bd_dh_formato_hora);
    } // Fim do método _horario_abertura
    
    /**
     * Obter ou editar o valor da propriedade $horario_fechamento
     * 
     * @param string $valor - string contendo o valor a ser atribuído à $this->horario_fechamento
     * 
     * @return string - valor da propriedade $horario_fechamento
     */
    public function _horario_fechamento($valor=null){
        return is_null($valor) ?
            (string)\Funcoes::_formatardatahora($this->horario_fechamento, \DL::$dh_formato_hora)
        : $this->horario_fechamento = (string)\Funcoes::_formatardatahora($valor, \DL::$bd_dh_formato_hora);
    } // Fim do método _horario_fechamento
    
    /**
     * Obter ou editar o valor da propriedade $horario_consultar
     * 
     * @param int $valor - string contendo o valor a ser atribuído à $this->horario_consultar
     * 
     * @return int - valor da propriedade $horario_consultar
     */
    public function _horario_consultar($valor=null){
        return is_null($valor) ?
            (int)$this->horario_consultar        
        : $this->horario_consultar = (int)$valor;
    } // Fim do método _horario_consultar
    
    /**
     * Salvar determinado registro
     * 
     * @param boolean $salvar : define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     */
    protected function _salvar($salvar=true){        
        if( !$this->horario_id ):
            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " horario_dia_semana, horario_abertura, horario_fechamento, horario_consultar, horario_publicar) VALUES ("
                    . " {$this->horario_dia_semana}, '{$this->horario_abertura}', '{$this->horario_fechamento}', {$this->horario_consultar},"
                    . " {$this->horario_publicar})";
        else:
            $query = "UPDATE {$this->bd_tabela} SET"
                    . " horario_dia_semana = {$this->horario_dia_semana},"
                    . " horario_abertura = '{$this->horario_abertura}',"
                    . " horario_fechamento = '{$this->horario_fechamento}',"
                    . " horario_consultar = {$this->horario_consultar},"
                    . " horario_publicar = {$this->horario_publicar}"
                    . " WHERE horario_id = {$this->horario_id}";
        endif;
        
        if( !$salvar )
            return $query;
        
        if( ($exec = \DL::$bd_pdo->exec($query)) === false )
            throw new \Exception(ERRO_PADRAO_SALVAR_REGISTRO, 1500);
        
        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) )
            $this->horario_id = \DL::$bd_pdo->lastInsertID('horario_id');
        
        return $this->horario_id;
    } // Fim do método _salvar
} // Fim do Modelo Horario
