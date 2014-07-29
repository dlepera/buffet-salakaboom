
    /* ================================================================================ //
     * 	AUTOR       : Diego Lepera
     * 	DATA DE CRIAÇÃO: 19/04/2013
     * 	PROJETO     : DL-GALERIA
     * 	VERSÃO      : 1.1
     * 	DESCRIÇÃO   : Galeria de Imagens e Vídeos
     * ================================================================================ */
    
    /* ================================================================================ //
     * 	CHANGELOG
     * 	DATA        : 30/05/2013
     * 	DESCRIÇÃO   :
     *      1. Adicionada a opção "loop"
     * ================================================================================ */
    
    // Variável utilizada para o timeout da auto rotação
    var dl_interv;
    
    (function($){
        /* =====================================================================
         *  FUNÇÃO PARA ALTERAR O ITEM A SER EXIBIDO NA GALERIA
         * ================================================================== */
        $.fn._dltrocaitem = function(item, loop){
            var $this = $(this);
            
            // Tratar o parâmetro 'item'
            if( loop )
                item = ( item < 0 )? $this.length-1 : ( item > ($this.length-1) )? 0 : item;
            else
                item = ( item < 0 )? 0 : ( item > ($this.length-1) )? $this.length-1 : item;
            
            // Esconder o item que estiver visível
            $this.filter(":visible").fadeOut("fast", function(){            
                // Selecionar o novo item a ser exibido
                var $novo = $this.filter(":eq("+ item +")");

                // Alterar as informações do item exibido
                var title    = $novo.attr("title");
                var $galeria = $novo.parents(".dl-galeria-album");
                var $titulo  = $galeria.find(".dl-galeria-titulo");
                var $descr   = $galeria.find(".dl-galeria-descr");
                var $indic   = $galeria.find(".dl-galeria-indicador");

                // Título do item
                if( $titulo.length > 0 ){
                    // Identificar o título do item
                    var expreg = /^(Título:)\s+(.+)/i;
                    
                    if( expreg.test(title) ){
                        var titulo = expreg.exec(title);
                        $titulo.text(titulo[2]);
                    } // Fim if( expreg.test(title) )
                } // Fim if( $titulo.length > 0 )

                // Descrição do item
                if( $descr.length > 0 ){
                    // Identificar o título do item
                    var expreg = /(Descrição:)\s+(.+)/i;
                    
                    if( expreg.test(title) ){
                        var descr = expreg.exec(title);
                        $descr.text(descr[2]);
                    } // Fim if( expreg.test(title) )
                } // Fim if( $descr.length > 0 )                
				
                // Indicador do item
                if( $indic.length > 0 ){
                    var $a = $indic.find("a");
                            $a.removeClass("atual");

                    $a.filter(":eq("+ item +")").addClass("atual");
                } // Fim if( $indic.length > 0 )
				
                // Mostrar o item pedido
                $novo.fadeIn("fast");
            });
            
            return $this;
        }; // Fim function TrocaItem()
        
        $.fn._dlgaleria = function(opcoes){
            var $_this = $(this);
            
            // Definie valore padrão para as opções
            var padroes = {
                titulo  	: false,
                descr   	: false,
                minis   	: false,
                naveg   	: false,
                loop    	: false,
                rotacao 	: false,
                indicador	: false,
                teclaesc        : false,
                aparencia	: { tema: 'dl-galeria-1.0', estilo: 'dl-galeria-1.0' }
            };
            
            opcoes = $.extend({}, padroes, opcoes);
            
            // Carregar o tema para a galeria e seus elementos
            if( opcoes.aparencia !== null ){
                if( typeof(CarregarCSS) === "function" )
                    CarregarCSS(dir_raiz +"/aplicacao/js/dl-galeria/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");

                // Incluir a classe para o formulário
                $_this.addClass(opcoes.aparencia.tema);
            } // if( opcoes.aparencia !== null )
            
            // Aplicar em todas as ocorrências de $this
            $_this.each(function(){
                var $this = $(this);
                
                // Configurar a tecla ESC
                if( opcoes.teclaesc ){
                    $(window).bind("keyup", function(){
                        var kcode = event.keyCode;
                        
                        if( kcode == 27 /* ESC */ )
                            $this.fadeOut("fast", function(){ $(this).remove(); });
                    });
                } // Fim if( opcoes.teclaesc )
                
                // Ajustar o ID da galeria e o estilo
                $this.addClass("dl-galeria-album").addClass(opcoes.aparencia.estilo.replace('.', '_'));

                /* =============================================================
                 *  CASO NÃO TENHA SIDO ESPECIFICADO NO CSS A PROPRIEDADE
                 *  position, OU ELA FOR 'static', SETÁ-LA COMO 'relative'
                 *  PARA FACILITAR A ORGANIZAÇÃO DO LAYOUT DA GALERIA
                 * ========================================================== */
                    var position = $this.css("position");
                    if( position == "" || position == "static" || position == undefined )
                        $this.css({ position: "relative" });
                
                var $citens = $this.find(".dl-galeria-itens");
                
                // Encontrar todos os itens (fotos e vídeos) da galeria
                var $itens = $citens.find("> .dl-galeria-item");

                // Esconder todos os itens, MENOS o primeiro
                $itens.not(":first-child").css({ display: "none" });

                // Mostrar informações sobre o item
                if( opcoes.titulo || opcoes.descr ){ 
                    // Título do item
                    if( opcoes.titulo ){
                        // Criar a TAG que receberá o Título
                        $(document.createElement("div")).addClass("dl-galeria-titulo").insertBefore($citens);
                    } // Fim if( opcoes.titulo )

                    // Descrição do item
                    if( opcoes.descr ){
                        // Criar a TAG que receberá a Descrição
                        $(document.createElement("div")).addClass("dl-galeria-descr").insertBefore($citens);
                    } // Fim if( opcoes.descr )
                } // Fim if( opcoes.titulo || opcoes.descr )
                
                // Mostrar o primeiro item
                $itens._dltrocaitem(0, opcoes.loop);
                
                if( opcoes.naveg ){
                    // Criar a TAG que terá a barra de navegação
                    var $naveg = $(document.createElement("div")).addClass("dl-galeria-navegacao").insertBefore($citens);
                    
                    // Botão Primeiro
                    $(document.createElement("a")).text("|<").attr({ 
                        title   : "Primeiro",
                        href    : "javascript:;"
                    }).click(function(){
                        // Ir para o primeiro item
                        $itens._dltrocaitem(0, opcoes.loop);
                    }).appendTo($naveg);
                    
                    // Botão Anterior
                    $(document.createElement("a")).text("<").attr({ 
                        title   : "Anterior",
                        href    : "javascript:;"
                    }).click(function(){
                        // Verificar o item que está sendo exibido atualmente
                        var atual = $itens.filter(":visible").index();
                        
                        // Ir para o próximo item
                        return $itens._dltrocaitem(atual-1, opcoes.loop);
                    }).appendTo($naveg);
                    
                    // Botão Próximo
                    $(document.createElement("a")).text(">").attr({ 
                        title   : "Próximo",
                        href    : "javascript:;"
                    }).click(function(){
                        // Verificar o item que está sendo exibido atualmente
                        var atual = $itens.filter(":visible").index();
                        
                        // Ir para o próximo item
                        return $itens._dltrocaitem(atual+1, opcoes.loop);
                    }).appendTo($naveg);
                    
                    // Botão Último
                    $(document.createElement("a")).text(">|").attr({ 
                        title   : "Último",
                        href    : "javascript:;"
                    }).click(function(){
                        // Ir para o último item
                        return $itens._dltrocaitem($itens.length-1, opcoes.loop);
                    }).appendTo($naveg);
                } // Fim if( opcoes.naveg )
                
                // Exibir as miniaturas
                if( opcoes.minis ){
                    // Criar a TAG que terá as miniaturas
                    var $minis = $(document.createElement("div")).addClass("dl-galeria-minis").insertBefore($citens);
                    
                    // Copiar cada item e inserir em miniaturas
                    $itens.each(function(){
                        return $(this).clone().css({ display: "block" }).click(function(){
                            $itens._dltrocaitem($(this).index(), opcoes.loop);
                        }).appendTo($minis);
                    });
                } // Fim if( opcoes.minis )
                
                // Criar o indicador
                if( opcoes.indicador ){
                    // DIV do indicador
                    $indic 		= $(document.createElement("div")).addClass("dl-galeria-indicador").appendTo($this);

                    qtde_itens 	= $itens.length;

                    for(i=0; i<qtde_itens; i++){
                            $(document.createElement("a")).text(i+1).attr({
                                    href: "javascript:;"
                            }).bind("click", function(){
                                    // Obter a index desse link
                                    var index = $(this).index();

                                    // Alterar o item a ser exibido
                                    $itens._dltrocaitem(index, opcoes.loop);
                            }).appendTo($indic);
                    } // Fim do for(i)
                } // Fim if( opcoes.indicador )
            });
            
            // Habilitar a auto rotacao
            if( opcoes.rotacao )
                dl_interv = window.setInterval(function(){
                    var $itens = $(".dl-galeria-itens > .dl-galeria-item");
                    
                    // Verificar o item que está sendo exibido atualmente
                    var atual = $itens.filter(":visible").index();

                    // Ir para o próximo item
                    return $itens._dltrocaitem(atual+1, opcoes.loop);
                }, 7000);
            
            return $_this;
        };
    })(jQuery);


