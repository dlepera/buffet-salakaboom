<?php

/*
 * DL-Sites @ 2013
 * Projeto	: Framework MVC
 * Programador e idealizador: Diego Lepera
 * Descri��o: Framework para facilitar o trabalho de criar sites e sistemas web
 * 				armazenando a��es comuns para todos os sites
 */
 
class Arquivos{
	public static $extensoes = array(
        /* Arquivos de imagens */
        'image/png'=>'png', 'image/jpeg'=>'jpg', 'image/pjpeg'=>'jpg', 'image/gif'=>'gif', 'image/bmp'=>'bmp', 'image/x-windows-bmp'=>'bmp', 'image/fif'=>'fif',
        'image/florian'=>'flo', 'image/x-icon'=>'ico', 'image/x-jps'=>'jps',

        /* Arquivos de v�deo */
        'application/x-troff-msvideo'=>'avi', 'video/avi'=>'avi', 'video/msvideo'=>'avi', 'video/x-msvideo'=>'avi', 'video/avs-video'=>'avs',
        'video/fli'=>'fli', 'video/x-fli'=>'fli', 'video/x-motion-jpeg'=>'mpeg','video/quicktime'=>'mov', 'video/x-sgi-movie'=>'movie',

        /* Arquivos de �udio */
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

        /* Aplica��es */
        'application/x-navimap'=>'map',

        /* Web */
        'text/html'=>'html', 'text/asp'=>'asp', 'application/php'=>'php', 'application/x-javascript'=>'js', 'application/x-httpd-imap'=>'imap', 'message/rfc822'=>'mht'
    );
   	
	/*
	 * Criar um arquivo e inserir o conte�do
	 * 
	 * @param string $arquivo: diret�rio e nome onde o arquivo ser� salvo
	 * @param string $conteudo: conte�do a ser inserido no arquivo
	 */
	public static function _criartxt($arquivo, $conteudo){
		# Verificar se o diret�rio informado tem permiss�o para
		# escrita
		if( !utilidade::_permissao(dirname($arquivo)) )
			return true;
		
		# Criar e abrir o arquivo para escrita
		$a = fopen($arquivo, 'w+');
		
		# Escrever o conte�do no arquivo
		$e = fwrite($a, $conteudo);
		
		# Fechar o arquivo
		fclose($arquivo);
		
		return !$e ? false : true;
	} // Fim do m�todo _criartxt
	 
	/*
	 * Obter informa��es sobre um arquivo espec�fico
	 */
	public static function _obterinfos($caminho=''){
		# Obter nome
        $nome = explode('.', basename($caminho));
        $nome = $nome[count($nome)-1];

        # Obter o Mime-Type
        $mimetype = mime_content_type($caminho);

        # Obter o encode
        # ** Sem o finfo n�o foi poss�vel encontrar o ENCODE do arquivo
        $mimeencode = '';

        # Obter a extens�o
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
	} // Fim do m�todo _obterinfos
	
	/*
	 * Remover diret�rios, com a op��o de remover os arquivos dentro dos
	 * diret�rios de maneira recursiva. Semelhante ao rm -r do linux
	 */
	public static function _removerdir($diretorio, $remover_conteudo = false){
		# Ler os arquivos dentro do diret�rio
		$ls = scandir($diretorio);
		
		if( $ls > 0 && !$remover_conteudo )
			return false;
		
		if( $ls > 0 ):
			# Filtrar diret�rios ocultos
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
	} // Fim do m�todo _removerdir
} // Fim da classe Arquivos
