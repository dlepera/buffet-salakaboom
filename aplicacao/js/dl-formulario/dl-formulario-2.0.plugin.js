/* 
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 25/03/2014
 */

// Máscaras dos formatos mais comuns
// Telefones
var MASK_TELEFONE   = "(##) ####-####";
var MASK_CELULAR    = MASK_TELEFONE;
var MASK_CELULAR_9  = "(##) # ####-####";

// Documentos
var MASK_RG     = "##.###.###-#";
var MASK_CPF    = "###.###.###-##";
var MASK_CNPJ   = "##.###.###/####-##";

// Endereço
var MASK_CEP = "#####-###";

// Data e hora
var MASK_DATA = "##/##/####";
var MASK_HORA = "##:##";
var MASK_DATA_E_HORA = MASK_DATA + " " + MASK_HORA;

// Expressões regulares para validação
// Telefones e e-mail
var EXPR_TELEFONE   = /^\([0-9]{2}\)\s{1}[2-5]{1}[0-9]{3}\-{1}[0-9]{4}$/;
var EXPR_CELULAR    = /^\([0-9]{2}\)\s{1}[6-9]{1}[0-9]{3}\-{1}[0-9]{4}$/;
var EXPR_CELULAR_9  = /^\([0-9]{2}\)\s{1}9{1}\s{1}[0-9]{4}\-{1}[0-9]{4}$/;
var EXPR_EMAIL      = /^([a-zA-z\d\._-]*)\@([a-z\d\.-]*)\.([a-z]{2,3})/;

// Documentos
var EXPR_RG     = /^[0-9]{2}\.{1}[0-9]{3}\.{1}[0-9]{3}\-{1}[0-9Xx]{1}$/;
var EXPR_CPF    = /^[0-9]{3}\.{1}[0-9]{3}\.[0-9]{3}\-{1}[0-9]{2}$/;
var EXPR_CNPJ   = /^[0-9]{2}\.{1}[0-9]{3}\.[0-9]{3}\/{1}[0-9]{4}\-{1}[0-9]{2}$/;

// Endereço
var EXPR_CEP = /^[0-9]{5}\-{1}[0-9]{3}$/;

// Data e hora
var EXPR_DATA = /^[0-3]{1}[0-9]{1}\/{1}[0-1]{1}[0-9]{1}\/{1}[0-9]{4}$/;
var EXPR_HORA = /^[0-2]{1}[0-9]{1}\:{1}[0-5]{1}[0-9]{1}$/;
var EXPR_DATA_E_HORA = /^[0-3]{1}[0-9]{1}\/{1}[0-1]{1}[0-9]{1}\/{1}[0-9]{4}\S{1}[0-2]{1}[0-9]{1}\:{1}[0-5]{1}[0-9]{1}$/;

// Números e letras
var EXPR_APENAS_NUMEROS = /^\d*$/;
var EXPR_APENAS_LETRAS  = /^\w*$/;

// Moeda
var EXPR_MOEDA_BRL = /^[0-9]*,[0-9]{2}$/;

// Vetor que armazenará os timeouts das mensagens
var tempo_msg = new Object();

/**
 * Função que será utilizada para tratar a resposta
 * 
 * @param {string} r resposta do servidor após o envio da
 * requisição
 */
function TratarResposta(r){
    // Remover espaços em branco
    var r = r.trim();
    
    // Verificar se a resposta é um conteúdo JSON
    if( /^[?\[{]{1,}(.+)[}\]{1,}]?$/.test(r) ){
        var json = $.parseJSON(r);
            json = /^\[/.test(r) ? json[json.length-1] : json;
            
        var mensagem = json.mensagem;
        var retorno  = json.tipo;
    } else {
        var mensagem = r;
        var retorno  = "atencao";
    } // Fim if( expreg.test(r) )
    
    return { msg: mensagem, ret: retorno };
} // Fim function TratarResposta(r)

(function($){
    /**
     * Plugin que faz a validação do fomulário
     */
    $.fn._dlformulario = function(opcoes){
        // Esse plugin será utilizado apenas para formulários <form..>...</form>
        if( $(this)[0].tagName !== "FORM" ){
            alert("O plugin _dlfomulario só pode ser utilizado em formulários.\nEx.: <form ...>...</form>");
            return false;
        } // Fim if( this.tagName !== "FORM" )
        
        var $this = $(this);
        
        // Opções padrão
        var padrao = {
            // Controle que executará o formulário
            controle: null,
            
            // Aparência do formulário e dos seus elementos,
            // que serão definidos por uma classe
            aparencia: { tema: "dl-formulario", estilo: "formulario" },
            
            // Função a ser executada antes do submit do formulário
            antes: function(){ return true; },
            
            // Função a ser executada após a submissão do formulário
            depois: function(){ return true; },
            
            // Configuração dos campos do formulário que precisam de validação
            // ou necessita aplicar algum máscara
            campos: {  },
            
            // Definir se o formulário será resetado após o submit
            reset: false,
            
            // Definir um checkbox para selecionar os demais
            cktodos: [false, ":checkbox:first", ":checkbox[name^='[]']"]
        };
        
        // Carregar as opções e mesclá-las com as opções padrao
        opcoes = $.extend({}, padrao, opcoes);
        
        // Carregar o tema para o formulário e seus elementos
        if( opcoes.aparencia !== null ){
            if( typeof(CarregarCSS) === "function" )
                CarregarCSS(dir_raiz +"/aplicacao/js/dl-formulario/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");

            // Incluir a classe para o formulário
            $this.addClass(opcoes.aparencia.tema);
        } // if( opcoes.aparencia !== null )
        
        /**
         * Complementar a função 'depois'
         */
        fnc_depois = function(){
            if( opcoes.reset ) this.reset();
                // $this.each(function(){ this.reset(); });
            
            return opcoes.depois();
        };
        
        /**
         * Organizar a navegação pelo TAB
         */
        $this.find("input:not(:hidden):not([readonly]), select, textarea").each(function(i){
            $(this).attr({
                tabindex: i+1
            });
        });
        
        /**
         * Configurar o comportamento 'reset' do formulário, para que retorne
         * à página anterior
         */
        $this.bind("reset", function(){
            history.back();
        });
        
        /**
         * Configurar o checkbox de selecionar os registros
         */
        if( opcoes.cktodos[0] ){
            $selecionador   = $(opcoes.cktodos[1]);
            $selecionaveis  = $(opcoes.cktodos[2]);
            
            $selecionador.click(function(){
                $selecionaveis.each(function(){
                    this.checked = $selecionador[0].checked;
                });
            });
        } // Fim if( cktodos[0] )
        
        // Aplicar a validação dos campos
        for( var a in opcoes.campos )
            $this.find("[name='"+ a +"']")._dlcampos(opcoes.campos[a]);
        
        /**
         * Alterar o submit do formulário para utilizar o
         * AJAX
         */
        $this.submit(function(){
            // Executar a função 'opcoes.antes', simulando o evento 'onsubmit'
            if( !opcoes.antes() )
                return false;
            
            /**
             * Passar campo a campo para validar
             */
            for( var a in opcoes.campos )
                if( !$this.find("[name='"+ a +"']")._dlvalidacao(opcoes.campos[a]) ) return false;
            
            var form_acao = $this.attr("action").indexOf("php/") < 0 ?
                $this.attr("action") +"/"+ opcoes.controle 
            : $this.attr("action");
            
            /**
             * Verificar se esse formulário tem como objetivo realizar o
             * upload de arquivos 
             */
            if( $this.attr("enctype") === "multipart/form-data" && $this.find(":file").length > 0 ){
                /**
                 * Criar um iframe escondido para submeter o formulário
                 * e alterar a action do form
                 */
                var form_nome = "form_upload_"+ $this.attr("name");
                $this.attr({ "action": form_acao });
                
                if( $("iframe[name='"+ form_nome +"']").length < 1 ){
                    $(document.createElement("iframe")).attr({ name: form_nome }).css({
                        width       : 0,
                        height      : 0,
                        visibility  : "hidden"
                    }).bind("load", function(){
                        var r = eval("$(window."+ form_nome +".document).text();");

                        if( r !== "" ){
                            var resp = TratarResposta(r);

                            $("body")._dlmostrarmsg({
                                mensagem    : resp.msg,
                                tipo        : ["alerta", resp.ret],
                                aparencia   : { tema: opcoes.aparencia.tema, estilo: "mensagem" },
                                botao       : { texto: "x", funcao: resp.ret === "sucesso" ? fnc_depois : function(){ return false; } }
                            });
                        } // Fim if( r !== "" )
                    }).appendTo($this);
                } // Fim if( $("iframe[name='"+ form_nome +"']").length < 1 )
                
                // Alterar onde o formulário fará o submit
                $this.attr({ target: form_nome });
                    
                // Submeter o form via JS
                eval("document."+ $this.attr("name") +".submit();");
            } else {
                $.ajax({
                    url : form_acao,
                    type: $this.attr("method"),
                    data: $this.serialize(),
                    statusCode: {
                        404: function(){
                            $("body")._dlformulario({
                                mensagem    : "Português: 404 - Página não encontrada!<br />English: 404 - Page not found!",
                                tipo        : ["erro", "alerta"],
                                aparencia   : { tema: opcoes.aparencia.tema, estilo: "mensagem" },
                                botao       : { texto: "x" }
                            });
                        },

                        500: function(){
                            $("body")._dlformulario({
                                mensagem    : "Português: 500 - Erro interno do servidor!<br />English: 500 - Internal Server Error!",
                                tipo        : ["erro", "alerta"],
                                aparencia   : { tema: opcoes.aparencia.tema, estilo: "mensagem" },
                                botao       : { texto: "x" }
                            });
                        }
                    },
                    success: function(r){
                        var resp = TratarResposta(r);
                        
                        $("body")._dlmostrarmsg({
                            mensagem    : resp.msg,
                            tipo        : ["alerta", resp.ret],
                            aparencia   : { tema: opcoes.aparencia.tema, estilo: "mensagem" },
                            botao       : { texto: "x", funcao: resp.ret === "sucesso" ? fnc_depois : function(){ return false; } }
                        });
                    }
                });
            } // Fim if( $this.attr("enctype") === "multipart/form-data" && $this.find(":file").length > 0 )
            
            // Retornar false para impedir o submit original do formulário
            return false;
        });
        
        return $this;
    }; // Fim $.fn._dlformulario
    
    $.fn._dlmostrarmsg = function(opcoes){
        var $this = $(this);
        
        // Opções padrão
        var padrao = {
            // Mensagem a ser mostrada
            mensagem: "Português: Mensagem padrão!\nEnglish: Default menssage!",
            
            // Tipo de mensagem a ser mostrada
            // Obs: Também pode interferir na aparência da mensagem
            tipo: ["alerta", "atencao"],
            
            // Tempo que a mensagem deverá ser exibida em ms
            tempo: 8000,
            
            // Texto a ser exibido no botão
            botao: { texto: "Ok", funcao: function(){ return true; } },
            
            // Aparência
            aparencia: { tema: "dl-formulario", estilo: "mensagem" },
            
            // Animação que fará a mensagem aparecer
            animacao: { mostrar: "para-baixo", ocultar: "para-cima", tempo: "1s" }
        };
        
        // Carregar as opções e mesclá-las com as opções padrao
        opcoes = $.extend({}, padrao, opcoes);
        
        // Carregar o tema para o formulário e seus elementos
        if( typeof(CarregarCSS) === "function" ){
            CarregarCSS(dir_raiz +"aplicacao/js/dl-formulario/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");
            CarregarCSS(dir_raiz +"aplicacao/js/dl-formulario/css/"+ opcoes.aparencia.tema +"/animacoes.css");
        } // Fim if( typeof(CarregarCSS) === "function" )
        
        // Incluir a classe para o formulário
        $this.addClass(opcoes.aparencia.tema);
        
        /** 
         * Não permitir várias mensagens para o mesmo campo
         */
        if( $.inArray("campo", opcoes.tipo) > -1 ){
            $("#msg-"+ $this.attr("name")).fadeOut("fast", function(){ $(this).remove(); });
        } // Fim if( $.inArray("campo", opcoes.tipo) > -1 )
        
        // ID único para controlar o timeout
        var id_unico = $("div.dl-formulario-mensagem").length;
        
        /**
         * Criar a DIV de exibição da mensagem
         */
        var $div = $(document.createElement("div")).addClass("dl-formulario-mensagem "+ opcoes.aparencia.tema +" "+ opcoes.tipo.join(" ")).css({
            "-webkit-animation-name": opcoes.animacao.mostrar,
            "-webkit-animation-duration":  opcoes.animacao.tempo,
            "-webkit-animation-fill-mode": "forwards"
        }).attr({
            id: $.inArray("campo", opcoes.tipo) > -1 ? "msg-"+ $this.attr("name") : id_unico
        });
        
        /**
         * Para campos, colocar a mensagem logo após o elemento.
         * Para outros elementos, colocar a mensagem dentro do mesmo
         */
        var campos = ['INPUT', 'TEXTAREA', 'SELECT', 'BUTTON'];
        $.inArray(this[0].tagName, campos) > -1 ? $div.insertAfter($this) : $div.appendTo($this);
        
        /**
         * Criar um parágrafo (p) que irá receber o texto e
         * colocá-lo dentro da div
         */
        var $p = $(document.createElement("p")).html(opcoes.mensagem).appendTo($div);
        
        // Criar o botão de fechamento da mensagem
        var $botao = $(document.createElement("button")).attr({
            type: "button"
        }).click(function() {
            // Remover o 'timeout' dessa mensagem
            clearTimeout(tempo_msg[id_unico]);

            // Remover essa mensagem
            $div.css({
                "-webkit-animation-name": opcoes.animacao.ocultar,
                "-webkit-animation-duration": opcoes.animacao.tempo,
                "-webkit-animation-fill-mode": "forwards"
            });
            
            // Remover a mensagem
            setTimeout(
                function(){ return $div.remove(); },
                
                // Converter os segundos em milesegundos
                opcoes.animacao.tempo.replace(/[^0-9]/g, "")*1000
            );
            
            // Reabilitar o botão submit
            $("button[type='submit']:disabled").removeAttr("disabled");
            
            return opcoes.botao.funcao !== undefined ?
                opcoes.botao.funcao()
            : true;
        }).text(opcoes.botao.texto).appendTo($p);
        
        // Configurar o tempo para que a mensagem suma
        tempo_msg[id_unico] = window.setTimeout(function(){
            return $botao.trigger("click");
        }, opcoes.tempo);
        
        return $this;
    }; // Fim $.fn._dlmostrarmsg
    
    /**
     * Validação e máscara de campos
     */
    $.fn._dlcampos = function(opcoes){
        var $this = $(this);
        
        // Opções padrão
        var padrao = {
            // Apelido / nome do campo
            apelido: $this.attr("title"),
            
            // Define se esse campo é obrigatório
            obr: false,
            
            // Define se esse campos será marcado como obrigatório ou não
            // Obs: depende do parâmetro 'obr'
            marcarobr: true,
            
            // Máscara a ser aplicada
            mascara: null,
            
            // Expressão regular responsável por validar esse campo
            validacao: null
        };
        
        // Carregar as opções e mesclá-las com as opções padrao
        opcoes = $.extend({}, padrao, opcoes);
        
         // Configurações da máscara
         if (opcoes.mascara !== null) {
            this.defaultValue = opcoes.mascara.replace(/#/g, "_");

            if ($this.attr("value") === "")
                $this.val(this.defaultValue);

            // Definir o tamanho máximo do campo para o tamanho
            // da máscara
            $this.attr("maxlength", opcoes.mascara.length + 1);
        } // Fim if( opcoes.mascara != null )
        
        // Configurações de campo obrigatório
        if (opcoes.obr && opcoes.marcarobr) {
            // Criar um SPAN e incluir um asterisco vermelho para indicar
            // obrigatoriedade de preenchimento
            $span = $(document.createElement("span")).css("color", "red").html("*");

            // Verificar se o campo está dentro de uma label ou se há
            // uma label específica para esse campo
            $label = $this.parents("label").length > 0 ? $this.parents("label") : $("label[for='" + $this.attr("name") + "']");

            if ($label.length > 0)
                $span.appendTo($label);
            else
                $span.insertAfter($this);
        } // Fim if( opcoes.obr )
        
        // Configurar a máscara (caso haja)
        $this.keyup(function(){
           if( opcoes.mascara !== null){
                var $_this = $(this);

                var valor_mascara_i = opcoes.mascara.replace(/#/g, "_");
                var valor_limpo     = $_this.val().replace(/[^A-Z^a-z^0-9]/g, "");
                var num             = valor_limpo.length;
                
                for(var i=0; i<num; i++)
                    valor_mascara_i = valor_mascara_i.replace("_", valor_limpo[i]);

                $_this.val(valor_mascara_i);
                
                // Alterar a posição do cursor
                var cursor = $_this.val().indexOf("_");
                
                if( cursor > -1 )
                    MoverCursor(this, cursor);
            } // Fim if( opcoes.mascara != null ) 
        }).blur(function(){
            // Validar o campo
            return $(this)._dlvalidacao({
                apelido  : opcoes.apelido,
                obr      : opcoes.obr,
                validacao: opcoes.validacao,
                mascara  : opcoes.mascara
            });
        });
        
        return $this;
    };
    
    /**
     * Validação de campos do formulário
     */
    $.fn._dlvalidacao = function(opcoes){
        var $this = $(this);
        
        // Opções padrão
        var padrao = {
            // Apelido / nome do campo
            apelido: $this.attr("title"),
            
            // Definir se esse campo tem preenchimento obrigatório
            obr: false, 
            
            // Máscara a ser aplicada
            mascara: null,
            
            // Expressão regular responsável pela validação do campo
            validacao: null
        };
        
        // Carregar as opções e mesclá-las com as opções padrao
        opcoes = $.extend({}, padrao, opcoes);

        var valor = $this.val(); if( opcoes.mascara !== null ) valor = valor.replace(opcoes.mascara.replace(/#/g, "_"), "");
        var coord = $this.position();
        
        if( opcoes.obr && valor === "" ){
            // Mover a janela até o campo
            window.scrollTo(0, coord.top-100);
            
            $this._dlmostrarmsg({
                mensagem    : "O campo <b>"+ opcoes.apelido +"</b> é obrigatório!<br />Por favor preencha corretamente.",
                tipo        : ["campo", "erro"],
                botao       : { texto: "x" },
                animacao    : { mostrar: "fadein", ocultar: "fadeout", tempo: "1s" },
                aparencia   : { tema: "colorido", estilo: "mensagem" }
            });
            
            return false;
        } // Fim if( opcoes.obr && valor === "" )
        
        if( opcoes.validacao !== null ){
            if( valor != "" && !opcoes.validacao.test(valor) ){
                // Mover a janela até o campo
                window.scrollTo(0, coord.top-100);

                $this._dlmostrarmsg({
                    mensagem    : "O campo <b>"+ opcoes.apelido +"</b> não obecece o formato necessário.<br />Por favor preencha corretamente.",
                    tipo        : ["campo", "erro"],
                    botao       : { texto: "x" },
                    animacao    : { mostrar: "fadein", ocultar: "fadeout", tempo: "1s" },
                    aparencia   : { tema: "colorido", estilo: "mensagem" }
                });

                return false;
            } // Fim if( opcoes.obr && valor === "" )
        } // Fim if( opcoes.validacao !== null )
        
        /**
         * Ao chegar até esse ponto, significa que o campo foi validado
         * corretamente e qualquer mensagem exibida sobre ele podeser removida
         */
        $this.find("+.dl-formulario-mensagem").fadeOut("fast", function(){ $(this).remove(); });
        
        return $this;
    };
})(jQuery);
