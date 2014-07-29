	
/*
 * DL-Sites @ 2013
 * Projeto  : Framework MVC
 * Programador e idealizador: Diego Lepera
 * Descrição: Framework para facilitar o trabalho de criar sites e sistemas web
 *              armazenando ações comuns para todos os sites
 * Plugin   : Plugin para criar botões de navegação de paginação
 */

// Encontrar a página atual
function $_PAGINA(){
    // Obter a busca da URL atual
    var URL = window.location.search;
    
    // Expressão regular para identificar a página atual
    var expreg  = /(pg){1}\=([\d]*)*/i;
    var retorno = expreg.exec(URL);

    // Retornar o valor da variável
   	return retorno === null ? 1 : parseInt(retorno[retorno.length-1]);
} // Fim function $_PAGINA()

/*
 * Direcionar a uma página de resultados específica
 */
function $_IRPARA(pg){
    // Obter a hash e a busca da URL atual
    var URL 	= window.location.toString();
    var busca 	= window.location.search;

    // Verificar se dentro da busca atual já está sendo especificada
    // alguma página e em caso positivo remover
    if( URL.indexOf("pg=") > -1 )
        URL = URL.replace(/pg=\d+/, "pg="+ pg);
    else
        URL += busca == "" ? "?pg="+ pg : "&pg="+ pg;

	window.location = URL;
} // Fim function $_IRPARA(pg)

(function($){
    $.fn._dlpaginacao = function(opcoes){
        // Armazenar o objeto
        var $this = $(this);
        
        // Definir os padrões
        var padroes = {
            pgatual     : $_PAGINA(),
            pgtotal     : 10,
            exibir      : 5,
            loop	: true,
            mostrar	: 0, // 0 => mostrar todas as páginas
            btn_numeros	: true,
            btn_primeira: true,
            btn_ultima	: true,
            btn_proxima	: true,
            btn_anterior: true,
            aparencia	: { tema: "dl-paginacao-1.0", estilo: "dl-paginacao-1.0" }
        };

        // Sobrescrever
        var opcoes = $.extend({}, padroes, opcoes);
        
        // Carregar a aparência do plugin
        CarregarCSS(dir_raiz +"/aplicacao/js/dl-paginacao/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");
        
        if( opcoes.pgtotal <= 1 ) return false;

        // Configurar esse objeto
        $this.attr({ "id": "dl-paginacao" });

        /* =============================================================
         *  CRIAR E CONFIGURAR OS BOTÕES DE NAVEGAÇÃO
         * ========================================================== */
            // Ir para primeira página
            if( opcoes.btn_primeira ){
                // Criar o botão
                $(document.createElement("a")).text("|<<").attr({
                    href: "javascript:;",
                    id  : "dl-paginacao-btnprimeira"
                }).click(function(){ return $_IRPARA(1); }).appendTo($this);
            } // Fim if( opcoes.btn_primeira )

            // Ir para página anterior
            if( opcoes.btn_anterior ){
                // Criar o botão
                $(document.createElement("a")).text("<<").attr({
                    href: "javascript:;",
                    id  : "dl-paginacao-btnanterior"
                }).click(function(){ 
                    if( opcoes.pgatual == 1 ){
                        if( opcoes.loop )
                            return $_IRPARA(opcoes.pgtotal);
                        else
                            return false;
                    } else
                        return $_IRPARA(opcoes.pgatual-1);
                }).appendTo($this);
            } // Fim if( opcoes.btn_anterior )

        // Botões numéricos
        if( opcoes.btn_numeros ){
            // Definir quantos botões serão mostrados
            var mmetade = Math.floor(opcoes.mostrar/2);
            var minicio = opcoes.pgatual - mmetade;
                minicio = minicio < 1 ? 1 : minicio;
            var mfinal  = opcoes.pgatual + ((opcoes.mostrar-mmetade)-1);
                mfinal  = (mfinal-minicio) < opcoes.mostrar ? ((opcoes.mostrar-(mfinal-minicio)) + mfinal)-1 : pgfinal;
                mfinal  = mfinal > opcoes.pgtotal ? opcoes.pgtotal : mfinal;
                mfinal  = mfinal < minicio ? opcoes.pgtotal : mfinal;
                minicio = minicio == mfinal ? 1 : minicio;

            // Criar os botões
            for(i=minicio; i<=mfinal; i++){
                // Criar os botões
                $(document.createElement("a")).attr({
                    href	: "javascript:;",
                    "class"	: ( i == opcoes.pgatual )? "atual" : ""
                }).text(i).click(function(){
                    var ir = parseInt($(this).text());

                    if( opcoes.pgatual != ir )
                        return $_IRPARA(ir);
                    else
                        return false;
                }).appendTo($this);
            } // Fim for(i)s
        } // Fim if( opcoes.btn_numeros )

        // Ir para próxima página
        if( opcoes.btn_proxima ){
            // Criar o botão
            $(document.createElement("a")).text(">>").attr({
                href: "javascript:;",
                id  : "dl-paginacao-btnproxima"
            }).click(function(){
                if(  opcoes.pgatual == opcoes.pgtotal ){
                    if( opcoes.loop )
                        return $_IRPARA(1);
                    else
                        return false;
                } else
                    return $_IRPARA(opcoes.pgatual+1);
            }).appendTo($this);
        } // Fim if( opcoes.btn_primeira )

        // Ir para última página
        if( opcoes.btn_ultima ){
            // Criar o botão
            $(document.createElement("a")).text(">>|").attr({
                href: "javascript:;",
                id  : "dl-paginacao-btnultima"
            }).click(function(){
                return $_IRPARA(opcoes.pgtotal);
            }).appendTo($this);
        } // Fim if( opcoes.btn_ultima )		 		

        // Retornar o objeto
        return $this;
    };
})(jQuery);