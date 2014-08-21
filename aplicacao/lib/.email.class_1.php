<?php

/*
 * DL-Sites @ 2013
 * Projeto	: Framework MVC
 * Programador e idealizador: Diego Lepera
 * Descri��o: Framework para facilitar o trabalho de criar sites e sistemas web
 * 				armazenando a��es comuns para todos os sites
 */

require_once 'phpmailer/class.phpmailer.php';
require_once 'phpmailer/class.smtp.php';
 
class Email{    
    # Dados do servidor
	public static $servidor_host;
	public static $servidor_smtp   = 1;         // Valores aceitos (0 e 1), para indicar se o servidor � SMTP ou n�o
	public static $servidor_porta  = 25;        // Definir a porta para envio do e-mail
	public static $servidor_autent = 1;         // Valores aceitos (0 e 1), para definir se o servidor requer autentica��o ou n�o
	public static $servidor_cripto = 'tls';     // Valores aceitos ('', 'tls', 'ssl'), para definir a forma de autentica��o do servidor 
	
	# Autentica��o
	# Nesse caso n�o haver� autentica��o, apenas o cabe�alho do e-mail
	# ter� essas informa��es, com exce��o da senha
	public static $conta_email;
	public static $conta_senha;
	
	# Corpo do e-mail
	public static $corpo_html;      // Valores (0 e 1) para definir se o corpo do e-mail ser� HTML ou texto puro
	public static $conteudo_html;   // Conte�do padr�o do corpo HTML
	
	
	# Cabe�alho do e-mail
	public static $cabecalho_from;
	public static $cabecalho_from_nome;
	public static $cabecalho_responder;
	
	# Armazenar a �ltima mensagem de erro do PHPMailer
	public static $phpmailer_erro; 
	
	# Configura��es
	public static $conf_debug = 0;
	
	/*
	 * Carregar a configura��o do e-mail atrav�s do banco de dados
	 */
	public static function _carregarconfig(){
		# Selecionar a configura��o no banco de dados
		$mod_ce = new \Modelo\ConfigEmail();
        $mod_ce->_selecionarprincipal();
		
		self::$servidor_host		= $mod_ce->config_email_host;
		self::$servidor_smtp   		= 1;
		self::$servidor_porta  		= $mod_ce->config_email_porta;
		self::$servidor_autent 		= (bool)$mod_ce->config_email_autent; 
		self::$servidor_cripto 		= $mod_ce->config_email_cripto;
		self::$conta_email 			= $mod_ce->config_email_conta;
		self::$conta_senha 			= $mod_ce->config_email_senha;
		self::$cabecalho_from 		= $mod_ce->config_email_de_email;
		self::$cabecalho_from_nome 	= $mod_ce->config_email_de_nome;
		self::$cabecalho_responder 	= $mod_ce->config_email_responder_para;
		self::$corpo_html			= (bool)$mod_ce->config_email_html;
		
        return true;
		// return utilidade::_retornar(true, SUCESSO_EMAIL_CONFIGURACOES_CARREGADAS);
	} // Fim do m�todo _carregarconfig
	        
	/* =====================================================================
	 *  REALIZAR O ENVIO DO E-MAIL
	 * ================================================================== */
	    public static function _enviar($para, $assunto, $corpo){
	    	# Verificar se j� existe alguma configura��o carregada para o
	    	# envio dos e-mails
	    	if( empty(self::$servidor_host) )
				if( !self::_carregarconfig() )
					return false;
				
	        if( DL::$ap_encoding != 'ISO-8859-1' && DL::$ap_encoding !== 'window-1252' ):
	            # Tratar as vari�veis passadas
	            // utilidade::_tratardados($assunto, 'ISO-8859-1');
	            // utilidade::_tratardados($corpo, 'ISO-8859-1');
	        endif;
	        
	        # Instanciar a classe PHPMailer
	        $email = new PHPMailer();
	        
	        # Dados do servidor
	        $email->Host = self::$servidor_host;
	        $email->Port = self::$servidor_porta;
	        
	        if( self::$servidor_smtp )
	            $email->IsSMTP();
	       
	        # Autentica��o do servidor
	        $email->SMTPAuth    = (bool)self::$servidor_autent;
	        $email->Username    = self::$conta_email;
	        $email->Password    = self::$conta_senha;
	        $email->SMTPSecure  = self::$servidor_cripto;
	        
	        # Cabe�alho do e-mail
	        $email->FromName = self::$cabecalho_from_nome;
	        $email->From     = self::$cabecalho_from;
	        $email->AddReplyTo(self::$cabecalho_responder);
	        
	        # Corpo do e-mail
	        $email->IsHTML((bool)self::$corpo_html);
	        $email->Subject = $assunto;
	        $email->Body    = $corpo;
	        
	        # Configura��es
	        if( self::$conf_debug > 0 )
	        	$email->SMTPDebug = self::$conf_debug;
	        
	        # Adicionar os remetentes da mensagem
	        if( strpos(', ', $para) !== false ):
	            $emails = explode(', ', $para);
	        
	            foreach( $emails as $remetente ):
	                $email->AddAddress($remetente);
	            endforeach;
	        else:
	           $email->AddAddress($para);
	        endif;
	        
	        if( !$email->Send() ){
	        	self::$phpmailer_erro = $email->ErrorInfo;					
	            return false;// utilidade::_retornar(false, sprintf(ERRO_EMAIL_ENVIAR_NAO_PODE_SER_ENVIADO, $email->ErrorInfo));
			} // Fim if( !$email->Send() )
			
	        return true; // utilidade::_retornar(true, SUCESSO_EMAIL_ENVIAR_ENVIADO);
	    } // Fim do m�doto _enviar
	} // Fim da classe Email