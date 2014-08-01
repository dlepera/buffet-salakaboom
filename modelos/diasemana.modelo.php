<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 09/12/2013
 */

namespace Modelo;
 
class DiaSemana extends Principal{
	# Propriedades de assuntos de contatos do site
	protected $dia_semana_id, $dia_semana_descr, $dia_semana_abrev, $dia_semana_delete = 0;
	
    public function __construct($id=0){
        parent::__construct('salakaboom_dias_semana', 'dia_semana_');
        
        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico de construção da classe
    
    /**
     * Obter ou editar o valor da propriedade $dia_semana_descr
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->dia_semana_descr
     * 
     * @return string: valor da propriedade $dia_semana_descr
     */
    public function _dia_semana_descr($valor=null){
        return is_null($valor) ?
            (string)$this->dia_semana_descr        
        : $this->dia_semana_descr = (string)$valor;
    } // Fim do método _dia_semana_descr
	
    /**
     * Obter ou editar o valor da propriedade $dia_semana_abrev
     * 
     * @param string $valor : string contendo o valor a ser atribuído à $this->dia_semana_abrev
     * 
     * @return string: valor da propriedade $dia_semana_abrev
     */
    public function _dia_semana_abrev($valor=null){
        return is_null($valor) ?
            (string)$this->dia_semana_abrev        
        : $this->dia_semana_abrev = (string)$valor;
    } // Fim do método _dia_semana_abrev
} // Fim da classe DiaSemana
