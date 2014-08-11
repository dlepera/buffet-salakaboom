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
    
    # Configura��es do Modelo
    protected $obj_m;
    protected $str_m;
    
    public function __construct($raiz){
        # Inicializar a classe Vis�o
        $this->obj_v = new \Visao($raiz);
    } // Fim do m�todo m�gico __construct
    
    public function __destruct(){
        $this->obj_v->_mostrar();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Escolher o tamplate e junt�-lo com os templates padr�o (_topo e _rodape)
     * 
     * @param string $tpl - nome do template a ser carregado
     */
    public function _escolhertpl($tpl){
        # Topo da p�gina
        $this->obj_v->_template('_topo');
        $this->obj_v->_template($tpl);
        $this->obj_v->_template('_rodape');
        
        # Selecionar os dados para contato
        $mod_dc = new \Modelo\DadoContato();
        $lis_dc = $mod_dc->_listar('dado_contato_publicar = 1', 'tipo_dado_descr, dado_contato_descr', 'tipo_dado_descr, dado_contato_descr');
        
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('contatos', $lis_dc);
    } // Fim do m�todo _escolhertpl
    
    /**
     * A��es padr�es para criar uma lista de registros
     * 
     * @param string $ordem - string que cont�m os campos a serem ordenados
     * @param string $campos - string que contenham os campos a serem selecionados
     * @param int $qtde - n�mero de registros a serem exibidos na pagina��o
     * @param string $metodo - nome do m�todo a ser executado para montar a lista 
     */
    public function _listapadrao($ordem = '', $campos = '*', $qtde = 0, $metodo = '_listar'){
        # Obter a busca realizada
        $_get_t = filter_input(INPUT_GET, 't', FILTER_DEFAULT);
        $_get_c = filter_input(INPUT_GET, 'c', FILTER_DEFAULT);
        $_get_p = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_NUMBER_INT);
        
        # Montar a string de filtro
        $filtro = !empty($_get_t) ? "{$_get_c} LIKE '{$_get_t}%'" : null;
        
        # Obter a quantidade de registros a serem exibidos
        $qtde = empty($qtde) ? $_SESSION['usuario_pref_num_registros'] : $qtde;
        
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('_get_c', $_get_c);
        $this->obj_v->_incluirparams('_get_t', $_get_t);
        $this->obj_v->_incluirparams('qtde_pg', ceil($this->obj_m->_qtde_registros($filtro)/$qtde));
        $this->obj_v->_incluirparams('lista', $this->obj_m->{$metodo}($filtro, $ordem, $campos, !$_get_p ? 1 : $_get_p, $qtde));
    } // Fim do m�toto _listapadrao 
    
    /**
     * Salvar o registro no banco de dados
     * 
     * @param boolean $salvar - define se o registro ser� salvo ou apenas retornar�
     * a string da query gerada
     * 
     * @return boolean se $salvar � definido como true ou string se $salvar � definido
     * como false
     */
    public function _salvar($salvar=true){
        $this->_salvar($salvar);
        \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_SALVAR_REGISTRO, $this->str_m), 'sucesso');
    } // Fim do m�todo _salvar
} // Fim da classe Principal