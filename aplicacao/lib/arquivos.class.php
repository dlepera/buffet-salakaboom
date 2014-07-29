<?php

/*
 * DL-Sites @ 2013
 * Projeto	: Framework MVC
 * Programador e idealizador: Diego Lepera
 * Descrição: Framework para facilitar o trabalho de criar sites e sistemas web
 * 				armazenando ações comuns para todos os sites
 */
 
class Arquivos{
	public static $extensoes = array(
        /* Arquivos de imagens */
        'image/png'=>'png', 'image/jpeg'=>'jpg', 'image/pjpeg'=>'jpg', 'image/gif'=>'gif', 'image/bmp'=>'bmp', 'image/x-windows-bmp'=>'bmp', 'image/fif'=>'fif',
        'image/florian'=>'flo', 'image/x-icon'=>'ico', 'image/x-jps'=>'jps',

        /* Arquivos de vídeo */
        'application/x-troff-msvideo'=>'avi', 'video/avi'=>'avi', 'video/msvideo'=>'avi', 'video/x-msvideo'=>'avi', 'video/avs-video'=>'avs',
        'video/fli'=>'fli', 'video/x-fli'=>'fli', 'video/x-motion-jpeg'=>'mpeg','video/quicktime'=>'mov', 'video/x-sgi-movie'=>'movie',

        /* Arquivos de áudio */
        'application/x-midi'=>'mid', 'audio/midi'=>'mid', 'audio/x-mid'=>'mid', 'audio/x-midi'=>'mid', 'music/crescendo'=>'mid', 'x-music/x-midi'=>'midi',
        'audio/mod'=>'mod', 'audio/x-mod'=>'mod', 'audio/mpeg'=>'mp2', 'audio/x-mpeg'=>'mp2', 'video/mpeg'=>'mp3', 'video/x-mpeg'=>'mp3', 'video/x-mpeq2a'=>'mp2',
        'audio/mpeg3'=>'mp3', 'audio/x-mpeg-3'=>'mp3', 'audio/wav'=>'wav', 'audio/x-wav'=>'wav',

        /* Arquivos Compactados */
        'application/x-bzip2'=>'boz', 'application/x-bzip'=>'bz', 'application/x-bzip2'=>'bz2', 'application/x-compressed'=>'gz', 'application/x-gzip'=>'gzip',
        'multipart/x-gzip'=>'gzip', 'application/x-tar'=>'tar', 'application/gnutar'=>'tgz', 'application/x-compressed'=>'tgz', 'application/x-compressed'=>'tif',
        'image/x-tiff'=>'tif', 'application/x-zip-compressed'=>'zip', 'application/zip'=>'zip', 'multipart/x-zip'=>'zip',

        /* Pacote Office < 2007 */
        'application/msword'=>'doc',

        /* Desenvolvimento */
        'text/x-java-source'=>'java',

        /* Aplicações */
        'application/x-navimap'=>'map',

        /* Web */
        'text/html'=>'html', 'text/asp'=>'asp', 'application/php'=>'php', 'application/x-javascript'=>'js', 'application/x-httpd-imap'=>'imap', 'message/rfc822'=>'mht'
    );
   	
	/*
	 * Criar um arquivo e inserir o conteúdo
	 * 
	 * @param string $arquivo: diretório e nome onde o arquivo será salvo
	 * @param string $conteudo: conteúdo a ser inserido no arquivo
	 */
	public static function _criartxt($arquivo, $conteudo){
		# Verificar se o diretório informado tem permissão para
		# escrita
		if( !utilidade::_permissao(dirname($arquivo)) )
			return true;
		
		# Criar e abrir o arquivo para escrita
		$a = fopen($arquivo, 'w+');
		
		# Escrever o conteúdo no arquivo
		$e = fwrite($a, $conteudo);
		
		# Fechar o arquivo
		fclose($arquivo);
		
		return !$e ? false : true;
	} // Fim do método _criartxt
	 
	/*
	 * Obter informações sobre um arquivo específico
	 */
	public static function _obterinfos($caminho=''){
		# Obter nome
        $nome = explode('.', basename($caminho));
        $nome = $nome[count($nome)-1];

        # Obter o Mime-Type
        $mimetype = mime_content_type($caminho);

        # Obter o encode
        # ** Sem o finfo não foi possível encontrar o ENCODE do arquivo
        $mimeencode = '';

        # Obter a extensão
        $extensao = self::$extensoes[$mimetype];

        # Obter o tamanho do arquivo
        $tamanho = sprintf('%u', filesize($caminho)); // Previnindo para arquivos com tamanho maior que 2GB

        return array(
            'nome'		=> $nome,
            'mime-type'	=> $mimetype,
            'encoding'	=> $mimeencode,
            'extensao'	=> $extensao,
            'tamanho'	=> $tamanho
        );
	} // Fim do método _obterinfos
	
	/*
	 * Remover diretórios, com a opção de remover os arquivos dentro dos
	 * diretórios de maneira recursiva. Semelhante ao rm -r do linux
	 */
	public static function _removerdir($diretorio, $remover_conteudo = false){
		# Ler os arquivos dentro do diretório
		$ls = scandir($diretorio);
		
		if( $ls > 0 && !$remover_conteudo )
			return false;
		
		if( $ls > 0 ):
			# Filtrar diretórios ocultos
			$ls = preg_grep('#^[^\.]#', $ls);
			
			# Percorrer arquivo a arquivo para remover
			foreach( $ls as $linha ):
				$arquivo = "{$diretorio}/{$linha}";
				
				if( is_file($arquivo) )
					unlink($arquivo);
				elseif( is_dir($arquivo) )
					self::_removerdir($arquivo, true);
			endforeach;
		endif;

		$rmdir = rmdir($diretorio);

		return !$rmdir ? false : true;
	} // Fim do método _removerdir
} // Fim da classe Arquivos
