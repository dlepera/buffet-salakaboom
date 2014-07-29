<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 16/05/2014 17:20:37
 */

namespace Controle;

abstract class Principal{
    protected $obj_v;
    
    # Configurações do Modelo
    protected $obj_m;
    protected $str_m;
    
    public function __construct($raiz){
        # Inicializar a classe Visão
        $this->obj_v = new \Visao($raiz);
    } // Fim do método mágico __construct
    
    public function __destruct(){
        $this->obj_v->_mostrar();
    } // Fim do método mágico __destruct
    
    /**
     * Escolher o tamplate e juntá-lo com os templates padrão (_topo e _rodape)
     * 
     * @param string $tpl: nome do template a ser carregado
     */
    public function _escolhertpl($tpl){
        # Topo da página
        $this->obj_v->_template('_topo');
        $this->obj_v->_template($tpl);
        $this->obj_v->_template('_rodape');
    } // Fim do método _escolhertpl
    
    /**
     * Salvar o registro no banco de dados
     * 
     * @param boolean $salvar: define se o registro será salvo ou apenas retornará
     * a string da query gerada
     * 
     * @return boolean se $salvar é definido como true ou string se $salvar é definido
     * como false
     */
    public function _salvar($salvar=true){
        $this->_salvar($salvar);
        \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_SALVAR_REGISTRO, $this->str_m), 'sucesso');
    } // Fim do método _salvar
} // Fim da classe Principal