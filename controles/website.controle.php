<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 19/05/2014 18:28:19
 */

namespace Controle;

class WebSite extends Principal{
    public function __construct($raiz='/site/'){
        parent::__construct($raiz);
    } // Fim do m�todo m�gico __conStruct
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do m�todo m�gico __destruct
    
    /**
     * Mostrar a p�gina inicial do site
     */
    public function _index(){
        # Preparar a vis�o
        $this->_escolhertpl('home');
        $this->obj_v->_titulo(TXT_TITULO_PAGINA_INICIAL);
        
        # Selecionar os banners a serem exibidos
        $diretorio  = './aplicacao/uploads/banners/';
        $banners    = array_map(
            create_function('$v', 'return "'. $diretorio .'{$v}";'),
            preg_grep('~\.(png|jpg|gif)$~', scandir($diretorio))
        );
        
        # Selecionar um depoimento para ser exibido de forma randomica
        $mod_d = new \Modelo\Depoimento();
        $lis_d = end($mod_d->_listar(
            'D.depoimento_publicar = 1', 
            'RAND()', 
            'D.depoimento_nome, D.depoimento_texto, LR.log_registro_data_criacao AS data', 1, 1
        ));
        
        # Incluir os par�metros da vis�o
        $this->obj_v->_incluirparams('banners', $banners);
        $this->obj_v->_incluirparams('depoimento', $lis_d);
    } // Fim do m�todo _index
    
    /**
     * Mostrar a p�gina institucional
     */
    public function _institucional(){
        # Preparar a vis�o
        $this->_escolhertpl('institucional');
        $this->obj_v->_titulo(TXT_TITULO_INSTITUCIONAL);
        
        # Selecionar as fotos para serem exibidas
        $mod_f = new \Modelo\FotoAlbum();
        $lis_f = $mod_f->_listar('foto_album_publicar', 'RAND()', 'foto_album_imagem', 1, 8);
        
        # Incluir par�metros na p�gina
        $this->obj_v->_incluirparams('fotos', $lis_f);
    } // Fim do m�todo _index
    
    /**
     * Mostrar a p�gina explicativa sobre o certificado de
     * excel�ncia no atendimento
     */
    public function _certificado(){
        # Preparar a vis�o
        $this->_escolhertpl('certificado');
        $this->obj_v->_titulo(TXT_TITULO_CERTIFICACAO_DE_EXCELENCIA_NO_ATENDIMENTO);
    } // Fim do m�todo _certificado
    
    /**
     * Mostrar a mapa da localiza�ao do buffet
     */
    public function _mapa(){
        # Preparar a vis�o
        $this->obj_v->_template('mapa');
        $this->obj_v->_titulo(TXT_TITULO_MAPA_DA_LOCALIZACAO);
    } // Fim do m�todo _certificado
} // Fim da classe WebSite
