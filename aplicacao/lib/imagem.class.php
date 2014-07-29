<?php

/* 
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 14/04/2014
 */

class Imagem{
    # Propriedades dessa imagem
    private $arquivo, $imagem, $largura, $altura, $tipo;
        
    # Parâmetros de edição
    private $qlde_jpeg = 100, $qlde_png = 9;
    
    public function __construct($arquivo = null){
        $this->_arquivo($arquivo);        
    } // Fim do método mágico de construção da classe
    
    /**
     * Exibir o valor de determinada propriedade
     * 
     * @param string $nome: nome da propriedade a ser exibida
     * @return mixed valor da propriedade definida em $nom
     */
    public function __get($nome){
        return $this->$nome;
    } // Fim do método mágico __get
    
    /**
     * Editar as propriedades da classe
     * 
     * @param string $nome: nome da propriedade a ser editada
     * @param mixed $valor: valor a ser atribuído à propriedade
     * 
     * @return void
     */
    public function __set($nome, $valor){
        switch($nome):
            case 'arquivo':
                if( empty($valor) || !file_exists($valor) )
                    throw new Exception(ERRO_IMAGEM_NAO_ENCONTRADA, 1500);
                
                $this->arquivo = (string)$valor;
        
                # Obter as dimensões do arquivo original
                list($this->largura, $this->altura, $this->tipo,) = getimagesize($this->arquivo);
                break;
                
            case 'qldejpeg':
                if( $valor < 0 || $valor > 100 )
                    throw new Exception(ERRO_IMAGEM_VALOR_DE_QLDE_INVALIDO, 1500);
                
                $this->qlde_jpeg = (float)$valor;
                break;
                
            case 'qldepng':
                if( $valor < 0 || $valor > 9 )
                    throw new Exception(ERRO_IMAGEM_VALOR_DE_QLDE_INVALIDO, 1500);
                
                $this->qlde_png = (int)$valor;
                break;
        endswitch;        
    } // Fim do método mágico __set
    
    /**
     * Tranparência da imagem
     */
    public function _transparencia(){
        # Configurar transparência
        imagealphablending($this->imagem, false);
        imagesavealpha($this->imagem, true);
    } // Fim do método _transparencia
    
    /**
     * Preparar a imagem para ser exibida ou salva
     */
    public function _preparar(){
        # Recriar a imagem de acordo com o tipo
		switch($this->tipo):
            case 1: return imagecreatefromgif($this->arquivo);
            case 2: default: return imagecreatefromjpeg($this->arquivo);
            case 3: return imagecreatefrompng($this->arquivo);
            case 6: return imagecreatefrombmp($this->arquivo);
		endswitch;
    } // Fim do método _preparar
    
    /**
     * Redimensionar a imagem
     * 
     * @param {float} $largura: largura da imagem redimensionada (em píxels)
     * @param {float} $altura: altura da imagem redimensionada (em píxels)
     * 
     * PS.: Se um dos 2 parâmetros não forem informados a imagem usará
     * tamanho relativo
     */
    public function _redimensionar($largura = null, $altura = null){
        if( empty($largura) && empty($altura) )
            throw new Exception(ERRO_IMAGEM_REDIMENSIONAR_INFORME_ALTURA_X_LARGURA, 1500);
        
        # Definir os valores finais para largura e altura
        $largura = empty($largura) ? ($altura * $this->largura)/$this->altura : $largura;
        $altura  = empty($altura) ? ($this->altura * $largura)/$this->largura : $altura;
        
        # Criar a nova imagem com as dimensões finais
        $this->imagem = imagecreatetruecolor($largura, $altura);
        
        $this->_transparencia();
        
        # Caso a imagem seja GIF ou PNG prepara para utilizar
        # a transparência
        if( $this->tipo == 1 || $this->tipo == 3 )
            imagecolortransparent($this->imagem);
        
        # Copiar a imagem original e colocá-la
        # redimensionada em $imagem
        imagecopyresampled($this->imagem, $this->_preparar(), 0, 0, 0, 0, $largura, $altura, $this->largura, $this->altura);
        
        return $this->imagem;
    } // Fim do método _redimensionar
    
    /**
     * Recortar a imagem
     * 
     * @param float $largura: nova largura da imagem
     * @param float $altura: nova altura da imagem
     * @param int $coord_x: coordenada do eixo X onde será o ínicio da imagem
     * @param int $coord_y: coordenada do eixo Y onde será o início da imagem
     */
    public function _recortar($largura = null, $altura = null, $coord_x=0, $coord_y=0){
        if( empty($largura) && empty($altura) )
            throw new Exception(ERRO_IMAGEM_REDIMENSIONAR_INFORME_ALTURA_X_LARGURA, 1500);
        
        # Definir os valores finais para largura e altura
        $largura = empty($largura) ? ($altura * $this->largura)/$this->altura : $largura;
        $altura  = empty($altura) ? ($this->altura * $largura)/$this->largura : $altura;
        
        # Criar uma imagem em branco que servirá
        # como base para a nova imagem redimensionada
        $this->imagem = imagecreatetruecolor($largura, $altura);
        
        $this->_transparencia();
        
        # Copiar a imagem original e colocá-la
        # redimensionada na $nova_imagem
        imagecopy($this->imagem, $this->_preparar(), 0, 0, $coord_x, $coord_y, $largura, $altura);
        
        return $this->imagem;
    } // Fim do método _recortar
    
    /**
     * Rotacionar a imagem
     * 
     * @param {float} $graus: 
     */
    public function _rotacionar($graus){
        if( empty($graus) || !is_numeric($graus) )
            throw new Exception(ERRO_IMAGEM_ROTACIONAR_GRAUS_INVALIDOS, 1500);
        
        # Rotacionar a nova imagem com transparência
        $this->imagem = imagerotate(
            $this->_preparar(), 
            $graus, 
            imagecolorallocatealpha($this->_preparar(), 0, 0, 0, 127)
        );
        
        $this->_transparencia();
        
        return $this->imagem;
    } // Fim do método _rotacionar
    
    /**
     * Salvar a imagem em um arquivo
     * 
     * @param {string} $arquivo: nome do arquivo a ser salvo
     */
    public function _salvar($arquivo){
        if( empty($arquivo) )
            throw new Exception(ERRO_IMAGEM_SALVAR_POR_FAVOR_INFORME_NOME_ARQUIVO, 1500);
       
        switch($this->tipo):
            /* IMAGEM GIF */
            case 1: imagegif($this->imagem, $arquivo); break;
            
            /* IMAGEM JPG */
            case 2: imagejpeg($this->imagem, $arquivo, $this->qlde_jpeg); break;
            
            /* IMAGEM PNG */
            case 3: imagepng($this->imagem, $arquivo, $this->qlde_png); break;
				
            /* IMAGEM BMP */
            case 6: imagewbmp($this->imagem, $arquivo); break;
				
            default: echo 'Tipo de imagem não suportado pelo sistema!'; break;
        endswitch;
        
        # Destruir essa imagem e liberar o espaço em memória
        return imagedestroy($this->imagem);
    } // Fim do método _salvar
    
    /**
     * Salvar a imagem em um arquivo
     */
    public function _mostrar(){
        switch($this->tipo):
            /* IMAGEM GIF */
            case 1:
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/gif');
                
                imagegif($this->imagem);
                break;
            
            /* IMAGEM JPG */
            case 2:                
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/jpeg');
                
                imagejpeg($this->imagem, null, $this->qlde_jpeg);
                break;
            
            /* IMAGEM PNG */
            case 3:
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/png');
				
                imagepng($this->imagem, null, $this->qlde_png);
                break;
				
            /* IMAGEM BMP */
            case 6:
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/bmp');
                
                imagewbmp($this->imagem);
                break;
				
            default: echo 'Tipo de imagem não suportado pelo sistema!'; break;
        endswitch;
        
        # Destruir essa imagem e liberar o espaço em memória
        return imagedestroy($this->imagem);
    } // Fim do método _mostrar
} // Fim da classe Imagem