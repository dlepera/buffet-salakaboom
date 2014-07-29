<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 25, 2014 9:47:54 AM
 */

namespace Controle;

class FotoAlbum extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\FotoAlbum();
        $this->str_m    = TXT_MODELO_FOTOALBUM;
        $this->perm_m   = 9;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'titulo'    => FILTER_SANITIZE_STRING,
                'descr'     => array('filter', FILTER_SANITIZE_EMAIL, 'flags' => FILTER_NULL_ON_FAILURE),
                'capa'      => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->_bd_prefixo());
        endif;
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Realizar o upload das fotos e salvar o registro no banco de dados
     * s
     * @param int $album
     * @returns void
     */
    public function _upload($album){
        # Selecionar as informações do álbum onde essas fotos serão salvas
        $mod_af = new \Modelo\Album($album);
        
        if( (int)$mod_af->album_id < 1 )
            throw new \Exception(ERRO_FOTOALBUM_UPLOAD_ALBUM_NAO_LOCALIZADO);
        
        $obj_up = new \Upload("/aplicacao/uploads/albuns/{$mod_af->album_id}/");
        $obj_up->_extensoes(array('jpg', 'jpeg', 'png'));
        
        if( !$obj_up->_salvar(\Funcoes::_removeracentuacao(strtolower($mod_af->album_nome))) )
            throw new \Exception(ERRO_FOTOALBUM_UPLOAD, 1500);
        
        foreach( $obj_up->arquivos_salvos as $f ):
            $mod_f = new \Modelo\FotoAlbum();
        
            $mod_f->foto_album        = $mod_af->album_id;
            $mod_f->foto_album_imagem = $f;
            $mod_f->_salvar();
            
            # Zerar as informações da foto
            unset($mod_f);
        endforeach;
        
        if( count($_FILES['fotos']) < count($obj_up->arquivos_salvos) )
            \Funcoes::_retornar(ERRO_FOTOALBUM_UPLOAD_NEM_TODAS_FORAM_SALVAS, 'atencao');
        else
            \Funcoes::_retornar(SUCESSO_FOTOALBUM_UPLOAD, 'sucesso');
    } // Fim do método _upload
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Alterar o content-type da página
        header('Content-type: text/html; charset='. \DL::$ap_encoding, true);
        
        # Preparar a visão
        $this->obj_v->_template('website/form_foto');
        $this->obj_v->_titulo(TXT_TITULO_INFORMACOES_DA_FOTO);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        $this->_formpadrao();
    } // Fim do método _formulario
} // Fim do controle FotoAlbum
