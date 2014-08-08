/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 28, 2014 10:33:24 AM
 */

/* -----------------------------------------------------------------------------------------------------------------
 * Montar a estrutura da galeria
 * -------------------------------------------------------------------------------------------------------------- */
(function($){
    /**
     * Iniciar e configurar a galeria de fotos
     * 
     * @param {object} opcoes
     * @returns {object} instância jquery do objeto selecionado
     */
    $.fn._dlgaleria = function(opcoes){
        var $this = $(this);
        
        // Definir os valores padrão para as opções / configurações do plugin
        var padrao = {
            // Definir se haverão as miniaturas das fotos
            minis: false,
            
            // Definir se haverão botões para controlar a navegação
            naveg: false,
            
            // Definir se será exibido o indicador
            indicador: false,
            
            // Objeto que contenha as informações (json) das fotos
            // src (obrigatório): caminho para a fotos
            // titulo (opcional): título a ser exibido da foto
            // descr (opcional): descrição a ser exibida juntamente com a foto
            // ir (opcional): link para onde a imagem deve direcionar ao ser clicada
            // js (opcional): ação JS a ser executada (só funciona caso a opção 'ir' não
            //  tenha sido definida
            fotos: [],
            
            // Opcões da transição a ser utilizada
            // nome (obrigatório): nome da transição / efeito a ser utilizada
            // tempo (obrigatório): tempo de duração da transição
            transicao: { nome: "fade", tempo: "0.5s" },
            
            // Definir as informações de aparência do plugin
            // tema (obrigatório): nome do tema a ser utilizado
            // estilo (obrigatório): nome da folha de estilo que pertence ao
            // tema selecionado que deverá ser aplicada nessa galeria
            aparencia: { tema: "galeria-2", estilo: "galeria" },
            
            // Definir a auto troca de imagens, como numa apresentação de slides
            // ativar (obrigatório): ativar ou desativar a opção
            // tempo (obrigatório): tempo que a imagem será exibida antes de ser alterada
            // para a próxima
            autotroca: { ativar: false, tempo: 10000 }
        };
        
        // Unir os valores de configuração do usuário com os valores padrão
        opcoes = $.extend({}, padrao, opcoes);
        
        // Aplicar o tema do plugin
        if( typeof(CarregarCSS) === "function" ){
            CarregarCSS(dir_raiz +"/aplicacao/js/dl-galeria/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");
            CarregarCSS(dir_raiz +"/aplicacao/js/dl-galeria/css/"+ opcoes.aparencia.tema +"/animacoes.css");
        } // Fim if( typeof(CarregarCSS) === "function" )
        
        $this.addClass(opcoes.aparencia.tema);
        $this.addClass(opcoes.aparencia.estilo);
        
        // Incluir as fotos na galeria
        var qtde_f = opcoes.fotos.length;
        
        // Caso nenhuma foto tenha sido configurada, exibir uma mensagem informativa
        // e cancelar o restante da construção do plugin
        if( qtde_f < 1 ){
            $this.html('Nenhuma foto encontrada');            
            return $this;
        } // Fim if( qtde_f < 1 )
        
        for(var i = 0; i < qtde_f; i++){
            var foto    = opcoes.fotos[i];
            var $figure = $(document.createElement("figure")).attr({
                onclick: foto.ir !== undefined ? "window.location = '"+ foto.ir +"';" : foto.js !== undefined ? foto.js : ""
            }).appendTo($this);
            
            // Incluir a imagem
            $(document.createElement("img")).attr({
                src: foto.src
            }).appendTo($figure);
            
            // Criar o figcaption apenas se necessário
            if( (foto.titulo !== undefined && foto.titulo != "") ||
                (foto.descr !== undefined && foto.descr != "") ){
                var $figcaption = $(document.createElement("figcaption")).appendTo($figure);
                
                if( foto.titulo !== undefined && foto.titulo != "" )
                    $(document.createElement("h2")).html(foto.titulo).appendTo($figcaption);
                
                if( foto.descr !== undefined && foto.descr != "" )
                    $(document.createElement("p")).html(foto.descr).appendTo($figcaption);
            } // Fim if( (foto.titulo !== undefined && foto.titulo != "") ||...
        } // Fim for(i)
        
        /**
         * Configurar as miniaturas
         */
        if( opcoes.minis ){
            var $minis = $(document.createElement("div")).addClass('dl-galeria-minis').appendTo($this);
            
            for(var i = 0; i < qtde_f; i++){
                var foto    = opcoes.fotos[i];
                var $figure = $(document.createElement("figure")).on("click", function(){
                    $this.find("> figure")._dltrocaritem($(this).index(), opcoes.transicao);
                }).appendTo($minis);
                
                // Incluir a imagem
                $(document.createElement("img")).attr({
                    src: foto.src
                }).appendTo($figure);
            } // Fim for(i)
        } // Fim if( opcoes.minis )
        
        /**
         * Configurar os botões para navegação
         */
        if( opcoes.naveg ){
            var $naveg = $(document.createElement("nav")).addClass('dl-galeria-naveg').appendTo($this);
            
            // Botão: Primeira
            $(document.createElement("a")).attr({
                href: "javascript:;"
            }).html("|<").on("click", function(){
                $this.find("> figure")._dltrocaritem(0, opcoes.transicao);
            }).appendTo($naveg);
            
            // Botão: Anterior
            $(document.createElement("a")).attr({
                href: "javascript:;"
            }).on("click", function(){
                $this.find("> figure")._dltrocaritem($this.find("> figure:visible").index()-1, opcoes.transicao);
            }).html("<").appendTo($naveg);
            
            // Botão: Próxima
            $(document.createElement("a")).attr({
                href: "javascript:;"
            }).on("click", function(){
                $this.find("> figure")._dltrocaritem($this.find("> figure:visible").index()+1, opcoes.transicao);
            }).html(">").appendTo($naveg);
            
            // Botão: Última
            $(document.createElement("a")).attr({
                href: "javascript:;"
            }).on("click", function(){
                $this.find("> figure")._dltrocaritem(qtde_f, opcoes.transicao);
            }).html(">|").appendTo($naveg);
        } // Fim if( opcoes.naveg )
        
        /**
         * Configurar o indicador
         */
        if( opcoes.indicador ){
            var $indic = $(document.createElement("div")).addClass('dl-galeria-indicador').appendTo($this);
            
            for(var i = 0; i < qtde_f; i++){
                $(document.createElement("a")).text(i+1).attr({
                    href: "javascript:;"
                }).bind("click", function(){
                    var $_this = $(this);
                    
                    // Alterar o item a ser exibido
                    $this.find("> figure")._dltrocaritem($_this.index(), opcoes.transicao);
                }).appendTo($indic);
            } // Fim do for(i)
        } // Fim if( opcoes.minis )
            
        /**
         * Configurar a auto-troca das imagens
         */
        if( opcoes.autotroca.ativar ){
            window.setInterval(function(){ 
                $this.find("> figure")._dltrocaritem($this.find("> figure:visible").index()+1, opcoes.transicao, opcoes.loop);
            }, opcoes.autotroca.tempo);
        } // Fim if( opcoes.autotroca.ativar )
        
        return $this;
    };
    
    /**
     * Trocar o item que está sendo exibido
     * 
     * @param {int} item - index do item a ser exibido
     * @param {object} transicao
     *  nome: nome da transição a ser utilizada
     *  tempo: tempo (string) a durar a transição
     * @param {bool} loop - define de o efeito loop está ativado 
     * @returns {$}
     */
    $.fn._dltrocaritem = function(item, transicao, loop){
            var $this = $(this);
            
            // Tratar o parâmetro 'item'
            if( loop )
                item = item < 0 ? $this.length-1 : item > ($this.length-1) ? 0 : item;
            else
                item = item < 0 ? 0 : item > ($this.length-1) ? $this.length-1 : item;
            
            $this.filter(":visible").fadeOut("fast", function(){
                // Exibir o item
                $this.filter(":eq("+ item +")").css({ display: "block", animation: transicao.nome +" "+ transicao.tempo +" forwards" });
                
                // Marcar como atual
                $this.parents("div").find(".dl-galeria-indicador > a").removeClass("atual").filter(":eq("+ item +")").addClass("atual");
            });            
            
            return $this;
        }; // Fim function TrocaItem()
})(jQuery);
