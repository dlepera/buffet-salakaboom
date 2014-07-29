<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/07/2014 16:43:36
 */

try{
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=framework", 'root', '$d5Ro0t');
    
    # Executar o script de alteração dos nomes das tabelas
    $sql = $pdo->query("SHOW TABLES LIKE 'dl_gerenc_%'");
    
    while( $rs = $sql->fetch(PDO::FETCH_ASSOC) ):
        $tbl_antiga = $rs['Tables_in_framework (dl_gerenc_%)'];
        $tbl_nova   = str_replace('_gerenc_', '_painel_', $tbl_antiga);
        
        echo "RENAME TABLE {$tbl_antiga} TO {$tbl_nova};<br>";
    endwhile;
} catch(Exception $e){
    echo json_encode(
        array(
            'mensagem'  =>  utf8_encode($e->getMessage()),
            'tipo'      =>  'erro'
        )
    );
}