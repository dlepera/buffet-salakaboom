<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/05/2014 11:38:28
 */

class Funcoes {

    /**
     * Converter vetor para as propriedades de um objeto
     * 
     * @param array $vetor : vetor com os valore a serem incluídos em $obj.
     * As chaves devem conter os nomes das propriedades
     * @param object $obj : objeto já instanciado que receberá os valores
     * do $vetor
     * @param string $prefixo : prefixo dos nomes de propriedades
     */
    public static function _vetor2objeto($vetor, &$obj, $prefixo = '') {
        foreach ($vetor as $p => $v):
            $p = "{$prefixo}{$p}";

            if (property_exists($obj, $p) && !is_null($v))
                $obj->{$p} = $v;
        endforeach;
    } // Fim do método _post2objeto

    /**
     * Formatar data e hora
     * 
     * @param string $data_hora : string contendo uma representação de data ou
     * 	hora
     * @param string $formato : string contendo o formtado da data e/ou hora
     * 	desejado. O farmato deve ser aceito pela função date();
     */
    public static function _formatardatahora($data_hora, $formato) {
        # Se $formato estiver em branco retornar a data sem nenhum alteração
        if( empty($formato) )
            return $data_hora;

        # Essas strings não serão aceitas, por se tratarem de datas
        # e / ou horas inválidas
        $nao_aceito = array(
            '0000-00-00',
            '0000-00-00 00:00:00'
        );

        if( empty($data_hora) || in_array($data_hora, $nao_aceito) )
            return '';

        # A função strtotime() não aceita a string da data no formato brasileiro
        # com a '/' barra separando dia, mês e ano. Portanto, caso a data seja
        # informada dessa forma substituir a '/' barra pelo '-' hifém
        if( strpos($data_hora, '/') > -1 )
            $data_hora = str_replace('/', '-', $data_hora);

        return date_format(date_create($data_hora), $formato);
    } // Fim do método _formatardatahora

    /**
     * Exibir o conteúdo em formato JSON para que o sistema possa exibi-lo
     * ao usuário
     * 
     * @param string $msg : mensagem a ser exibida na tela
     * @param string $tipo : define parte da aparência da mensagens exibida
     */
    public static function _retornar($msg, $tipo) {
        \DL::$tmp_buffer_resposta[] = array(
            'mensagem'  => utf8_encode($msg),
            'tipo'      => $tipo
        );
    } // Fim do método _retornar

    /**
     * Converter o encoding de uma variável
     * 
     * @param string $var: variável a ser convertida
     */
    public static function _converterencode(&$var, $para_encode, $de_encode = 'UTF-8') {
        if (!is_array($var)):
            if (mb_check_encoding($var, $de_encode)):
                $var = mb_convert_encoding($var, $para_encode, $de_encode);
            endif;
        else:
            foreach ($var as &$v)
                self::_converterencode($v, $para_encode, $de_encode);
        endif;
    } // Fim do método _converterencode

    /**
     * Remover acentuação de uma string
     * 
     * @param string $string : string a ter a acentuação removida
     * @returns string string com a acentuação removida
     */
    public static function _removeracentuacao($string) {
        # Obter o encoding interno do submit do form
        preg_match("#^(.+);\s.+\=(.+)$#", filter_input(INPUT_SERVER, 'CONTENT_TYPE'), $content_type);
        list(, $content_type, $encode) = $content_type;

        # Caracteres que deverão ser substituídos
        $acentuacao = array();

        # Acentuação na letra 'a' minúscula
        $acentuacao['a'] = array('á', 'à', 'â', 'ã');

        # Acentuação na letra 'e' minúscula
        $acentuacao['e'] = array('é', 'è', 'ê');

        # Acentuação na letra 'i' minúscula
        $acentuacao['i'] = array('í', 'ì', 'î');

        # Acentuação na letra 'o' minúscula
        $acentuacao['o'] = array('ó', 'ò', 'ô', 'õ');

        # Acentuação na letra 'u' minúscula
        $acentuacao['u'] = array('ú', 'ù', 'û');

        # Acentuação na letra 'ç' minúscula
        $acentuacao['c'] = array('ç');

        # Acentuação na letra 'A' MAIÚSCULA
        $acentuacao['A'] = array('Á', 'À', 'Â', 'Ã');

        # Acentuação na letra 'E' MAIÚSCULA
        $acentuacao['E'] = array('É', 'È', 'Ê');

        # Acentuação na letra 'I' MAIÚSCULA
        $acentuacao['I'] = array('Í', 'Ì', 'Î');

        # Acentuação na letra 'O' MAIÚSCULA
        $acentuacao['O'] = array('Ó', 'Ò', 'Ô', 'Õ');

        # Acentuação na letra 'U' MAIÚSCULA
        $acentuacao['U'] = array('Ú', 'Ù', 'Û');

        # Acentuação na letra 'Ç' MAIÚSCULA
        $acentuacao['C'] = array('Ç');

        # Verificar se o encoding precisa ser ajustado
        if ($content_type != 'multipart/form-data' && !empty($encode))
            $ajustar_encode = true;

        $string = ( $ajustar_encode && mb_detect_encoding($string) != $encode ) ?
                mb_convert_encoding($string, $encode) : $string;

        foreach ($acentuacao as $chave => $acento):
            foreach ($acento as $letra):
                $letra = ( $ajustar_encode ) ?
                        mb_convert_encoding($letra, $encode) : $letra;

                if (strpos($string, $letra) !== false)
                    $string = str_replace($letra, $chave, $string);
            endforeach;
        endforeach;

        return $string;
    } // Fim do médoto _removeracentuacao
    
    /*
     * Obter o nome do dia da sema de uma determinada data
     * que deve ser passada no parametro data
     * @param $data: data para verificar o dia da semana
     */
    public static function _diadasemana($data){
    	# Separar a data em dia/mÍs/ano utilizando uma express?o
    	# regular para facilitar
    	$expreg = '/(?<dia>[0-9]{2})[\-\/](?<mes>[0-9]{2})[\-\/](?<ano>[0-9]{4})/';
    	preg_match($expreg, $data, $data);
    	
    	# Obter a representaÁ?o numÈrica do dia da semana
    	# correspondente a data informada
    	$diasemana = date('w', mktime(0, 0, 0, $data['mes'], $data['dia'], $data['ano']));
		
        switch( $diasemana ):
            case 0:  return TXT_DIADASEMANA_DOMINGO;
            case 1:  return TXT_DIADASEMANA_SEGUNDA_FEIRA;
            case 2:  return TXT_DIADASEMANA_TERCA_FEIRA;
            case 3:  return TXT_DIADASEMANA_QUARTA_FEIRA;
            case 4:  return TXT_DIADASEMANA_QUINTA_FEIRA;
            case 5:  return TXT_DIADASEMANA_SEXTA_FEIRA;
            case 6:  return TXT_DIADASEMANA_SABADO;
            default: return false;
        endswitch;
    } // Fim do mÈtodo _diadasemana
} // Fim da classe funções
