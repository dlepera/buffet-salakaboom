	
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
    /**
     * plugin jQuery para criar os botões de paginação de resultados
     * 
     * @param {Object} opcoes
     * @returns {Object|$}
     */
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
        opcoes = $.extend({}, padroes, opcoes);
        
        // Carregar o tema para o formulário e seus elementos
        if( opcoes.aparencia !== null ){
            if( typeof(CarregarCSS) === "function" )
                CarregarCSS(dir_raiz +"/aplicacao/js/dl-paginacao/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");

            // Incluir a classe para o formulário
            $this.addClass(opcoes.aparencia.tema +" "+ opcoes.aparencia.estilo);
        } // if( opcoes.aparencia !== null )		 		
        
        // Não é necessário exibir paginação de a quantidade de páginas
        // é menor que 2
        if( opcoes.pgtotal < 2 ) return false;
        
        /* --------------------------------------------------------------------------------------------------------------------
         * Criar e configurar os botões de navegação
         * 
         * Obs.: Os itens são inseridos na mesma ordem que devem aparecer por padrão
         * ----------------------------------------------------------------------------------------------------------------- */
        if( opcoes.btn_primeira ){
            $(document.createElement("a")).attr("href", "javascript:;").addClass("btn-primeira").bind("click", function(){
                $_IRPARA(1);
            }).text("|<<").appendTo($this);
        } // Fim do método opcoes.btn_primeira
        
        if( opcoes.btn_anterior ){
            $(document.createElement("a")).attr("href", "javascript:;").addClass("btn-anterior").bind("click", function(){
                if( opcoes.pgatual == 1 ){
                    if( opcoes.loop )
                        $_IRPARA(opcoes.pgtotal);
                    else
                        return false;
                } else $_IRPARA(opcoes.pgatual-1);
            }).text("<<").appendTo($this);
        } // Fim do método opcoes.btn_anterior
        
        /* --------------------------------------------------------------------------------------------------------------------
         * Criar e configurar os botões numéricos
         * ----------------------------------------------------------------------------------------------------------------- */
        if( opcoes.btn_numeros ){
            // Definir quantos botões numéricos serão mostrados
            var mmetade = Math.floor(opcoes.mostrar/2);
            var minicio = opcoes.pgatual - mmetade;
                minicio = minicio < 1 ? 1 : minicio;
            var mfinal  = opcoes.pgatual + ((opcoes.mostrar-mmetade)-1);
                mfinal  = (mfinal-minicio) < opcoes.mostrar ? ((opcoes.mostrar-(mfinal-minicio)) + mfinal)-1 : mfinal;
                mfinal  = mfinal > opcoes.pgtotal ? opcoes.pgtotal : mfinal;
                mfinal  = mfinal < minicio ? opcoes.pgtotal : mfinal;
                minicio = minicio == mfinal ? 1 : minicio;
                
            while( minicio <= mfinal ){
                $(document.createElement("a")).attr({
                    "href"  : "javascript:;",
                    "class" : minicio == opcoes.pgatual ? "pg-atual" : ""
                }).text(minicio++).bind("click", function(){
                    var ir = parseInt($(this).text());

                    if( opcoes.pgatual != ir )
                        return $_IRPARA(ir);
                    else
                        return false;
                }).appendTo($this);
            } // Fim while( minicio < mfinal )
        } // Fim if( opcoes.btn_numeros )
        
        if( opcoes.btn_proxima ){
            $(document.createElement("a")).attr("href", "javascript:;").addClass("btn-proxima").bind("click", function(){
                if( opcoes.pgatual == opcoes.pgtotal ){
                    if( opcoes.loop )
                        $_IRPARA(1);
                    else
                        return false;
                } else $_IRPARA(opcoes.pgatual+1);
            }).text(">>").appendTo($this);
        } // Fim do método opcoes.btn_ultima
        
        if( opcoes.btn_ultima ){
            $(document.createElement("a")).attr("href", "javascript:;").addClass("btn-ultima").bind("click", function(){
                $_IRPARA(opcoes.pgtotal);
            }).text(">>|").appendTo($this);
        } // Fim do método opcoes.btn_ultima
        
        // Retornar o objeto
        return $this;
    };
})(jQuery);