	
/*
 * DL-Sites @ 2013
 * Projeto  : Framework MVC
 * Programador e idealizador: Diego Lepera
 * Descri��o: Framework para facilitar o trabalho de criar sites e sistemas web
 *              armazenando a��es comuns para todos os sites
 * Plugin   : Plugin para criar bot�es de navega��o de pagina��o
 */

// Encontrar a p�gina atual
function $_PAGINA(){
    // Obter a busca da URL atual
    var URL = window.location.search;
    
    // Express�o regular para identificar a p�gina atual
    var expreg  = /(pg){1}\=([\d]*)*/i;
    var retorno = expreg.exec(URL);

    // Retornar o valor da vari�vel
   	return retorno === null ? 1 : parseInt(retorno[retorno.length-1]);
} // Fim function $_PAGINA()

/*
 * Direcionar a uma p�gina de resultados espec�fica
 */
function $_IRPARA(pg){
    // Obter a hash e a busca da URL atual
    var URL 	= window.location.toString();
    var busca 	= window.location.search;

    // Verificar se dentro da busca atual j� est� sendo especificada
    // alguma p�gina e em caso positivo remover
    if( URL.indexOf("pg=") > -1 )
        URL = URL.replace(/pg=\d+/, "pg="+ pg);
    else
        URL += busca == "" ? "?pg="+ pg : "&pg="+ pg;

    window.location = URL;
} // Fim function $_IRPARA(pg)

(function($){
    /**
     * plugin jQuery para criar os bot�es de pagina��o de resultados
     * 
     * @param {Object} opcoes
     * @returns {Object|$}
     */
    $.fn._dlpaginacao = function(opcoes){
        // Armazenar o objeto
        var $this = $(this);
        
        // Definir os padr�es
        var padroes = {
            pgatual     : $_PAGINA(),
            pgtotal     : 10,
            exibir      : 5,
            loop	: true,
            mostrar	: 0, // 0 => mostrar todas as p�ginas
            btn_numeros	: true,
            btn_primeira: true,
            btn_ultima	: true,
            btn_proxima	: true,
            btn_anterior: true,
            aparencia	: { tema: "dl-paginacao-1.0", estilo: "dl-paginacao-1.0" }
        };

        // Sobrescrever
        opcoes = $.extend({}, padroes, opcoes);
        
        // Carregar o tema para o formul�rio e seus elementos
        if( opcoes.aparencia !== null ){
            if( typeof(CarregarCSS) === "function" )
                CarregarCSS(dir_raiz +"/aplicacao/js/dl-paginacao/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");

            // Incluir a classe para o formul�rio
            $this.addClass(opcoes.aparencia.tema +" "+ opcoes.aparencia.estilo);
        } // if( opcoes.aparencia !== null )		 		
        
        // N�o � necess�rio exibir pagina��o de a quantidade de p�ginas
        // � menor que 2
        if( opcoes.pgtotal < 2 ) return false;
        
        /* --------------------------------------------------------------------------------------------------------------------
         * Criar e configurar os bot�es de navega��o
         * 
         * Obs.: Os itens s�o inseridos na mesma ordem que devem aparecer por padr�o
         * ----------------------------------------------------------------------------------------------------------------- */
        if( opcoes.btn_primeira ){
            $(document.createElement("a")).attr("href", "javascript:;").addClass("btn-primeira").bind("click", function(){
                $_IRPARA(1);
            }).text("|<<").appendTo($this);
        } // Fim do m�todo opcoes.btn_primeira
        
        if( opcoes.btn_anterior ){
            $(document.createElement("a")).attr("href", "javascript:;").addClass("btn-anterior").bind("click", function(){
                if( opcoes.pgatual == 1 ){
                    if( opcoes.loop )
                        $_IRPARA(opcoes.pgtotal);
                    else
                        return false;
                } else $_IRPARA(opcoes.pgatual-1);
            }).text("<<").appendTo($this);
        } // Fim do m�todo opcoes.btn_anterior
        
        /* --------------------------------------------------------------------------------------------------------------------
         * Criar e configurar os bot�es num�ricos
         * ----------------------------------------------------------------------------------------------------------------- */
        if( opcoes.btn_numeros ){
            // Definir quantos bot�es num�ricos ser�o mostrados
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
        } // Fim do m�todo opcoes.btn_ultima
        
        if( opcoes.btn_ultima ){
            $(document.createElement("a")).attr("href", "javascript:;").addClass("btn-ultima").bind("click", function(){
                $_IRPARA(opcoes.pgtotal);
            }).text(">>|").appendTo($this);
        } // Fim do m�todo opcoes.btn_ultima
        
        // Retornar o objeto
        return $this;
    };
})(jQuery);