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
     * @param array $vetor : vetor com os valore a serem inclu�dos em $obj.
     * As chaves devem conter os nomes das propriedades
     * @param object $obj : objeto j� instanciado que receber� os valores
     * do $vetor
     * @param string $prefixo : prefixo dos nomes de propriedades
     */
    public static function _vetor2objeto($vetor, &$obj, $prefixo = '') {
        foreach ($vetor as $p => $v):
            $p = "{$prefixo}{$p}";

            if (property_exists($obj, $p) && !is_null($v))
                $obj->{$p} = $v;
        endforeach;
    } // Fim do m�todo _post2objeto

    /**
     * Formatar data e hora
     * 
     * @param string $data_hora : string contendo uma representa��o de data ou
     * 	hora
     * @param string $formato : string contendo o formtado da data e/ou hora
     * 	desejado. O farmato deve ser aceito pela fun��o date();
     */
    public static function _formatardatahora($data_hora, $formato) {
        # Se $formato estiver em branco retornar a data sem nenhum altera��o
        if( empty($formato) )
            return $data_hora;

        # Essas strings n�o ser�o aceitas, por se tratarem de datas
        # e / ou horas inv�lidas
        $nao_aceito = array(
            '0000-00-00',
            '0000-00-00 00:00:00'
        );

        if( empty($data_hora) || in_array($data_hora, $nao_aceito) )
            return '';

        # A fun��o strtotime() n�o aceita a string da data no formato brasileiro
        # com a '/' barra separando dia, m�s e ano. Portanto, caso a data seja
        # informada dessa forma substituir a '/' barra pelo '-' hif�m
        if( strpos($data_hora, '/') > -1 )
            $data_hora = str_replace('/', '-', $data_hora);

        return date_format(date_create($data_hora), $formato);
    } // Fim do m�todo _formatardatahora

    /**
     * Exibir o conte�do em formato JSON para que o sistema possa exibi-lo
     * ao usu�rio
     * 
     * @param string $msg : mensagem a ser exibida na tela
     * @param string $tipo : define parte da apar�ncia da mensagens exibida
     */
    public static function _retornar($msg, $tipo) {
        \DL::$tmp_buffer_resposta[] = array(
            'mensagem'  => utf8_encode($msg),
            'tipo'      => $tipo
        );
    } // Fim do m�todo _retornar

    /**
     * Converter o encoding de uma vari�vel
     * 
     * @param string $var: vari�vel a ser convertida
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
    } // Fim do m�todo _converterencode

    /**
     * Remover acentua��o de uma string
     * 
     * @param string $string : string a ter a acentua��o removida
     * @returns string string com a acentua��o removida
     */
    public static function _removeracentuacao($string) {
        # Obter o encoding interno do submit do form
        preg_match("#^(.+);\s.+\=(.+)$#", filter_input(INPUT_SERVER, 'CONTENT_TYPE'), $content_type);
        list(, $content_type, $encode) = $content_type;

        # Caracteres que dever�o ser substitu�dos
        $acentuacao = array();

        # Acentua��o na letra 'a' min�scula
        $acentuacao['a'] = array('�', '�', '�', '�');

        # Acentua��o na letra 'e' min�scula
        $acentuacao['e'] = array('�', '�', '�');

        # Acentua��o na letra 'i' min�scula
        $acentuacao['i'] = array('�', '�', '�');

        # Acentua��o na letra 'o' min�scula
        $acentuacao['o'] = array('�', '�', '�', '�');

        # Acentua��o na letra 'u' min�scula
        $acentuacao['u'] = array('�', '�', '�');

        # Acentua��o na letra '�' min�scula
        $acentuacao['c'] = array('�');

        # Acentua��o na letra 'A' MAI�SCULA
        $acentuacao['A'] = array('�', '�', '�', '�');

        # Acentua��o na letra 'E' MAI�SCULA
        $acentuacao['E'] = array('�', '�', '�');

        # Acentua��o na letra 'I' MAI�SCULA
        $acentuacao['I'] = array('�', '�', '�');

        # Acentua��o na letra 'O' MAI�SCULA
        $acentuacao['O'] = array('�', '�', '�', '�');

        # Acentua��o na letra 'U' MAI�SCULA
        $acentuacao['U'] = array('�', '�', '�');

        # Acentua��o na letra '�' MAI�SCULA
        $acentuacao['C'] = array('�');

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
    } // Fim do m�doto _removeracentuacao
    
    /*
     * Obter o nome do dia da sema de uma determinada data
     * que deve ser passada no parametro data
     * @param $data: data para verificar o dia da semana
     */
    public static function _diadasemana($data){
    	# Separar a data em dia/m�s/ano utilizando uma express?o
    	# regular para facilitar
    	$expreg = '/(?<dia>[0-9]{2})[\-\/](?<mes>[0-9]{2})[\-\/](?<ano>[0-9]{4})/';
    	preg_match($expreg, $data, $data);
    	
    	# Obter a representa�?o num�rica do dia da semana
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
    } // Fim do m�todo _diadasemana
} // Fim da classe fun��es
