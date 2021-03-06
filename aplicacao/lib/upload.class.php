<?php

/* 
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 15/04/2014
 */

class Upload{
    # Propriedades do upload
    private $diretorio, $extensoes = array();
    
    # Registro dos arquivos que foram salvos
    public $arquivos_salvos = array();
    
    public function __construct($dir = ''){
        if( !isset($_FILES) || !count($_FILES) )
            throw new Exception(ERRO_UPLOAD_NENHUM_ARQUIVO_ENVIADO, 1500);
        
        $this->_diretorio($dir);
    } // Fim do m�todo de constru��o da classe
    
    /**
     * Exibir ou editar a propriedade $diretorio
     * 
     * @param {string} $dir : caminho onde os arquivos do upload
     * ser�o salvos
     */
    public function _diretorio($dir = null){
        if( is_null($dir) )
            return $this->diretorio;
        
        if( empty($dir) )
            throw new Exception(ERRO_UPLOAD_DIRETORIO_NAO_INFORMADO, 1500);
        
        return $this->diretorio = preg_replace('~/$~', '', $dir);
    } // Fim do m�todo _diretorio
    
    /**
     * Exibir ou editar a propriedade extens�es
     * 
     * @param {mixed} $ext : extens�o a ser permitida ou um vetor de
     * strings a serem permitidos
     */
    public function _extensoes($ext = null){
        if( is_null($ext) )
            return $this->extensoes;
        
        if( is_array($ext) ):
            foreach( $ext as $e )
                $this->extensoes[] = $e;
        
            return $this->extensoes;
        else:
            return $this->extensoes[] = $ext;
        endif;
    } // Fim do m�todo _extensoes
    
    /**
     * Salvar todos os arquivos
     * 
     * @param {string} $nome : nome padr�o para salvar os arquivos. Caso fique em branco
     * ser� usado o nome original da imagem
     * @param {bool} $sobrescrever : define o comportamento da classe caso o arquivo a ser
     * salvo j� exista no diret�rio
     */
    public function _salvar($nome = '', $sobrescrever = false){
        foreach( $_FILES as $upload ):
            $_name      = !is_array($upload['name']) ? array($upload['name']) : $upload['name'];
            $_tmp_name  = !is_array($upload['tmp_name']) ? array($upload['tmp_name']) : $upload['tmp_name'];
            $_error     = !is_array($upload['error']) ? array($upload['error']) : $upload['error'];

            # Quantidade de arquivos
            $qtde = count($_tmp_name);

            # Caminho onde os arquivos ser�o salvos
            $caminho = ".{$this->diretorio}";

            for($i=0; $i<$qtde; $i++):
                if( $_error[$i] != '0' || !file_exists($_tmp_name[$i]) )
                    $i++;
                
                # Obter as informa��es desse arquivo
                $infos = arquivos::_obterinfos($_tmp_name[$i]);
                
                # Verificar se a extens�o do arquivo deve ser aceita ou se n�o h�
                # limita��o das extens�es
                if( count($this->extensoes) > 0 && !in_array($infos['extensao'], $this->extensoes) ):
                    # Remover o arquivo tempor�rio para n�o ter o risco
                    # de sobrecarregar o servidor
                    unlink($_tmp_name[$i]);
                    
                    # Passar para o pr�ximo passo do la�o
                    continue;
                endif;
                
                # Definir o nome desse arquivo
                $nome = empty($nome) ? preg_replace('~[\s_]+~', '-', strtolower($_name[$i])) : $nome;

                # Caminho e nome do arquivo
                $completo = "{$caminho}/{$nome}.{$infos['extensao']}";

                # Definir n�mero para renomear o arquivo
                $c = 0;

                # Verificar se o nome j� existe e em caso positivo
                # renomear ou sobrescrever
                while( !$sobrescrever && file_exists($completo) )
                    $completo = "{$caminho}/{$nome}-". $c++ .".{$infos['extensao']}";
                
                if( move_uploaded_file($_tmp_name[$i], $completo) )
                    $this->arquivos_salvos[] = $completo;
            endfor;
        endforeach;
        
        return !count($this->arquivos_salvos) ? false : true;
    } // Fim do m�todo _salvar
} // Fim da classe Upload