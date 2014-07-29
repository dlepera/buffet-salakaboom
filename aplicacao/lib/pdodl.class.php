<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/07/2014 10:05:19
 */

class PDODL extends PDO{
    public function __construct($dsn, $username, $passwd, $options){
        parent::__construct($dsn, $username, $passwd, $options);
    } // Fim do m�todo m�gico __construct
    
    /**
     * Realizar a pagina��o de resultados
     * 
     * @param string $query: consulta a ser utilizada na pagina��o
     * @param int $pagina: n�mero da p�gina atual
     * @param int $qtde: quantidade de registros a ser exibida na pagina��o
     */
    public function _paginacao($query, $pagina = 1, $qtde = 20){        
        if( $qtde > 0 ):
            $bd = \DL::$bd_pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
            
            switch( $bd ):
                case 'mysql':
                    $inicio = $pagina == 1 ? 0 : ($pagina-1)*$qtde;

                    # Verificar se a query foi passada com o LIMIT
                    if( strpos("LIMIT", $query) > -1 )
                        $query = preg_replace('~LIMIT\s+[\d\w,]+~i', '', $query);

                    # Realizar a pagina��o dos resultados
                    $query .= " LIMIT {$inicio},{$qtde}";                        
                    break;
                    
                case 'mssql':
                    $inicio = $pagina == 1 ? 1 : (($pagina-1)*$qtde)+1;
                    $fim    = $inicio == 1 ? $qtde : $pagina*$qtde;

                    $expreg = '~^(SELECT){1}\s+(.+)\s+(FROM){1}\s+(.+)';
                        $expreg .= stripos($query, " WHERE ") === false ? '' : '\s+(WHERE){1}\s+(.+)';
                        $expreg .= stripos($query, " GROUP ") === false ? '' : '\s+(GROUP\s+BY){1}\s+(.+)';
                        $expreg .= stripos($query, " ORDER ") === false ? '' : '\s+(ORDER\s+BY){1}\s+(.+)';
                        $expreg .= '~i';
                    preg_match($expreg, $query, $string);

                    /* =========================================================
                     * 	SEPARAR A CL�USULA 'ORDER BY'
                     * ====================================================== */
                        $clausula   = array_search("ORDER BY", $string);
                        if( $clausula === false ) $order = $string[2];
                        else {
                            $order = $string[$clausula+1];

                            # Remover a cl�usula ORDER BY do vetor string
                            unset($string[$clausula], $string[$clausula+1]);
                        } // Fim if( $clausula === false ) 

                    $clausulas = implode(' ', array_slice($string, 2));

                    # Adicionar o n�mero da linha na query principal
                    
                    $query = "{$string[1]} ROW_NUMBER() OVER (ORDER BY ". trim($order) .") AS linha, {$clausulas}";

                    # Realizar a pagina��o dos resultados
                    $query = "WITH paginacao AS ({$query}) SELECT * FROM paginacao WHERE linha BETWEEN {$inicio} AND {$fim}";
                    break;
            endswitch;
        endif; // Fim if( $qtde > 0 )
        
        return $this->query($query);
    } // Fim do m�todo _paginacao
} // Fim da classe PDODL
