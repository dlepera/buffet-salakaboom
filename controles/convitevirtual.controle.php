<?php
 
/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC
 * @Data	: 14/09/2013
 */

namespace Controle;

class ConviteVirtual extends PrincipalSistema{
    public function __construct(){
        parent::__construct('site', 'cv');
    } // Fim do metodo magico de constru�ao da classe

    public function __destruct(){
        parent::__destruct();
    } // Fim do metodo magico de destrui�ao da classe

    /**
     * Escolher o template a ser utilizado
     * Caso o login n�o tenha sido realizado, for�ar o template
     * do formul�rio de login
     * 
     * @param {string} $tpl -  string com o caminho para o template
     * 
     */
    public function _escolhertpl($tpl){
        # Selecionar os dados para contato
        $mod_dc = new \Modelo\DadoContato();
        $lis_dc = $mod_dc->_listar(
            'dado_contato_publicar = 1 AND tipo_dado_rede_social = 0', 
            'tipo_dado_descr, dado_contato_descr', 
            'tipo_dado_descr, dado_contato_descr'
        );
        
        $lis_rs = $mod_dc->_listar(
            'dado_contato_publicar = 1 AND tipo_dado_rede_social = 1', 
            'tipo_dado_descr, dado_contato_descr', 
            'tipo_dado_descr, dado_contato_descr, tipo_dado_icone'
        );
        
        # Selecionar a lista de hor�rios de atendimento
        $mod_h  = new \Modelo\Horario();
        $lis_h = $mod_h->_listar(
            'H.horario_publicar = 1', 
            'H.horario_abertura, H.horario_fechamento, DS.dia_semana_id', 
            'DS.dia_semana_abrev, H.horario_abertura, H.horario_fechamento'
        );
        
        # Incluir os par�metros na vis�o
        $this->obj_v->_incluirparams('contatos', $lis_dc);
        $this->obj_v->_incluirparams('redes-sociais', $lis_rs);
        $this->obj_v->_incluirparams('horarios', $lis_h);
        
        # Topo da p�gina
        $this->obj_v->_template('_topo');
        $this->obj_v->_template($this->obj_ar->_verificarlogin(false) ? $tpl : 'convites/form_login');
        $this->obj_v->_template('_rodape');
	} // Fim do m�todo _escolhertpl
	
	/**
	 * P�gina inicial
	 */
	public function _formulario(){
        # Preparar a visao
        $this->_escolhertpl('convites/form_convite');
        $this->obj_v->_titulo(TXT_TITULO_CONVITES_VIRTUAIS);

        $mod_mc = new \Modelo\ModeloConvite();
        $lis_mc	= $mod_mc->_listar('modelo_convite_publicar = 1', null, 'modelo_convite_id, modelo_convite_titulo, modelo_convite_imagem');

        # Par�metros a serem passados para o template
        $this->obj_v->_incluirparams('modelos', $lis_mc);
    } // Fim do m�todo _formulario

    /*
     * Formul�rio de login
     */
    public function _formlogin(){
        // $this->obj_ar->_formlogin();
        $this->obj_v->_template('convites/form_login');
        $this->obj_v->_titulo(TXT_TITULO_CONVITES_VIRTUAIS);
    } // Fim do m�todo _formlogin
	
    /*
     * Executar a a��o de login
     */
    public function _fazerlogincv(){
        $mod_lc = new \Modelo\LoginConvite();
        $mod_lc->login_convite_usuario  = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
        $mod_lc->login_convite_senha    = filter_input(INPUT_POST, 'senha');
        $usr                            = $mod_lc->_fazerlogin();

        $this->obj_ar->_carregarsessao($usr, $this->obj_ar->_sessao('prefixo'));
		
        return \Funcoes::_retornar(SUCESSO_ACESSORESTRITO_LOGIN_REALIZADO, 'sucesso');
    } // Fim do m�todo _fazerlogin
	
    /*
     * Executar a a��o de logout
     */
    public function _fazerlogoutcv(){
        $l = $this->obj_ar->_fazerlogout();

        return ( !$l )?
            \Funcoes::_retornar(ERRO_ACESSORESTRITO_FAZERLOGOUT, 'erro')
        : \Funcoes::_retornar(SUCESSO_ACESSORESTRITO_FAZERLOGOUT, 'sucesso');
    } // Fim do m�todo _fazerlogin
	
    /*
     * Enviar os convites por e-mail :D
     */
    public function _enviar(){        
        # Salvar todas as informa��es no banco de dados
        $mod_ec = new \Modelo\EnvioConvite();
        $con_ec = new \Controle\EnvioConviteW();
        
        $mod_ec->_selecionarID($con_ec->_salvar());
		
        foreach( $mod_ec->envio_convite_convidados_emails as $c => $email ):
            # Corpo do e-mail
            $html = !isset($html)?
                $this->_emailhtml($mod_ec, $mod_ec->envio_convite_convidados_nomes[$c])
            : preg_replace('~(Ol�)\s(.+)\!~', "Ol� {$mod_ec->envio_convite_convidados_nomes[$c]}!", $html);
            
            $obj_e = new \Email();
            $envio = $obj_e->_enviar($email, '['. \DL::$ap_nome .'] '. sprintf(TXT_EMAIL_CONVITE_VIRTUAL, $mod_ec->envio_convite_convidados_nomes[$c], $mod_ec->envio_convite_festa_aniversariante), $html);
            $obj_e->_gravarlog(__CLASS__, $mod_ec->bd_tabela, $mod_ec->envio_convite_id);
        endforeach;
		
        return !$envio ?
            \Funcoes::_retornar($obj_e->_exibirlog(), 'erro')
        : \Funcoes::_retornar(SUCESSO_CONVITEVIRTUAL_ENVIAR, 'sucesso');
    } // Fim do m�todo _enviar
	
    public function _emailhtml(\Modelo\EnvioConvite $mod_ec, $nome){		
        # Modelo do convite a ser enviado
        $mod_mc = new \Modelo\ModeloConvite($mod_ec->envio_convite_modelo);

        # Utilizar outra inst�ncia da classe vis�o para n�o conflitar
        $obj_v = new \Visao('/emails/');
        $obj_v->_template('convite');

        # Par�metros a serem passados para o template
        $obj_v->_incluirparams('envio', $mod_ec);
        $obj_v->_incluirparams('modelo', $mod_mc);		
        $obj_v->_incluirparams('convidado', $nome);

        return $obj_v->_conteudo();
    } // Fim do m�todo _emailhtml
	
    public function _mostrarhtml($id, $email){
        $mod_ec = new \Modelo\EnvioConvite($id);

        echo $this->_emailhtml(
            $mod_ec,
            $mod_ec->envio_convite_convidados_nomes[array_search($email, $mod_ec->envio_convite_convidados_emails)]
        ); 
    } // Fim do m�todo _mostrarhtml
} // Fim da classe ConviteVirtual
