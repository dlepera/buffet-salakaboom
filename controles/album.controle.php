<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 24, 2014 5:19:35 PM
 */

namespace Controle;

class Album extends PrincipalSistema{
    public function __construct(){
        parent::__construct('painel-dl');
        
        # Configurar esse Controle
        $this->obj_m    = new \Modelo\Album();
        $this->str_m    = TXT_MODELO_ALBUM;
        $this->perm_m   = 9;
        
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'nome'      => FILTER_SANITIZE_STRING,
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));
            
            # Converter o encode
            \Funcoes::_converterencode($post, \DL::$ap_encoding);
            
            # Selecionar as informações atuais
            $this->obj_m->_selecionarID($post['id']);
        
            # Popular o modelo com as informações acima
            \Funcoes::_vetor2objeto($post, $this->obj_m, $this->obj_m->bd_prefixo);
        endif;
    } // Fim do método mágico de construção da classe
    
    public function __destruct(){
        parent::__destruct();
    } // Fim do método mágico __destruct
    
    /**
     * Lista de registros
     */
    public function _lista(){
        # Preparar a visão
        $this->_escolhertpl('website/lista_albuns', array('ver'));
        $this->obj_v->_titulo(TXT_TITULO_ALBUNS_DE_FOTOS);
        
        # Configurar a lista padrão
        $this->_listapadrao(
            'A.album_nome', 
            "A.album_id, A.album_nome, F.foto_album_imagem,"
            . " ( CASE A.album_publicar"
            . " WHEN 0 THEN 'Não'"
            . " WHEN 1 THEN 'Sim'"
            . " ELSE '??'"
            . " END ) AS PUBLICADO",
            var_export((int)$_SESSION['usuario_pref_num_registros'], true)
        );
        
        # Incluir os parâmetros na visão
        $this->obj_v->_incluirparams('campos', array(
            array('nome' => 'album_nome', 'label' => TXT_LABEL_NOME)
        ));
        $this->obj_v->_incluirparams('mod-fotoalbum', new \Modelo\FotoAlbum());
    } // Fim do método _lista
    
    /**
     * Carregar o formulário de edição do registro
     * 
     * @param int $id : ID do registro a ser selecionado
     */
    public function _formulario($id=null){
        # Preparar a visão
        $this->_escolhertpl('website/form_album', array('inserir', 'editar'));
        $this->obj_v->_titulo(TXT_TITULO_ALBUNS_DE_FOTOS);
        
        # Selecionar as informações do modelo
        $this->obj_m->_selecionarID($id);
        
        # Selecionar as fotos dese álbum
        $mod_f = new \Modelo\FotoAlbum();
        $lis_f = $mod_f->_listar("foto_album = {$this->obj_m->album_id}", null, 'foto_album_id, foto_album_titulo, foto_album_capa, foto_album_imagem');
        
        # Incluir esse parâmetro
        $this->obj_v->_incluirparams('fotos', $lis_f);
        
        $this->_formpadrao();
    } // Fim do método _formulario
    
    /**
     * Salvar o registro
     */
    public function _salvar(){
        if( !$this->obj_ar->_verificarpermissao($this->perm_m, array('inserir', 'editar')) )
            throw new \Exception(ERRO_PADRAO_USUARIO_NAO_TEM_PERMISSAO, 1403);
        
        $id = $this->obj_m->_salvar();
        
        if( !empty($_FILES['fotos']['tmp_name'][0]) ):
            # Salvar as fotos
            $con_f = new \Controle\FotoAlbum();
            $con_f->_upload($id);
        endif;
        
        \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_SALVAR_REGISTRO, $this->str_m), 'sucesso');
    } // Fim do método _salvar
} // Fim do controle Album
