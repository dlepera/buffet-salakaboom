/* 
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 25/03/2014
 */

// M�scaras dos formatos mais comuns
// Telefones
var MASK_TELEFONE   = "(##) ####-####";
var MASK_CELULAR    = MASK_TELEFONE;
var MASK_CELULAR_9  = "(##) # ####-####";

// Documentos
var MASK_RG     = "##.###.###-#";
var MASK_CPF    = "###.###.###-##";
var MASK_CNPJ   = "##.###.###/####-##";

// Endere�o
var MASK_CEP = "#####-###";

// Data e hora
var MASK_DATA = "##/##/####";
var MASK_HORA = "##:##";
var MASK_DATA_E_HORA = MASK_DATA + " " + MASK_HORA;

// Express�es regulares para valida��o
// Telefones e e-mail
var EXPR_TELEFONE   = /^\([0-9]{2}\)\s{1}[2-5]{1}[0-9]{3}\-{1}[0-9]{4}$/;
var EXPR_CELULAR    = /^\([0-9]{2}\)\s{1}[6-9]{1}[0-9]{3}\-{1}[0-9]{4}$/;
var EXPR_CELULAR_9  = /^\([0-9]{2}\)\s{1}9{1}\s{1}[0-9]{4}\-{1}[0-9]{4}$/;
var EXPR_EMAIL      = /^([a-zA-z\d\._-]*)\@([a-z\d\.-]*)\.([a-z]{2,3})/;

// Documentos
var EXPR_RG     = /^[0-9]{2}\.{1}[0-9]{3}\.{1}[0-9]{3}\-{1}[0-9Xx]{1}$/;
var EXPR_CPF    = /^[0-9]{3}\.{1}[0-9]{3}\.[0-9]{3}\-{1}[0-9]{2}$/;
var EXPR_CNPJ   = /^[0-9]{2}\.{1}[0-9]{3}\.[0-9]{3}\/{1}[0-9]{4}\-{1}[0-9]{2}$/;

// Endere�o
var EXPR_CEP = /^[0-9]{5}\-{1}[0-9]{3}$/;

// Data e hora
var EXPR_DATA = /^[0-3]{1}[0-9]{1}\/{1}[0-1]{1}[0-9]{1}\/{1}[0-9]{4}$/;
var EXPR_HORA = /^[0-2]{1}[0-9]{1}\:{1}[0-5]{1}[0-9]{1}$/;
var EXPR_DATA_E_HORA = /^[0-3]{1}[0-9]{1}\/{1}[0-1]{1}[0-9]{1}\/{1}[0-9]{4}\S{1}[0-2]{1}[0-9]{1}\:{1}[0-5]{1}[0-9]{1}$/;

// N�meros e letras
var EXPR_APENAS_NUMEROS = /^\d*$/;
var EXPR_APENAS_LETRAS  = /^\w*$/;

// Moeda
var EXPR_MOEDA_BRL = /^[0-9]*,[0-9]{2}$/;

// Vetor que armazenar� os timeouts das mensagens
var tempo_msg = new Object();

/**
 * Fun��o que ser� utilizada para tratar a resposta
 * 
 * @param {string} r resposta do servidor ap�s o envio da
 * requisi��o
 */
function TratarResposta(r){
    // Remover espa�os em branco
    var r = r.trim();
    
    // Verificar se a resposta � um conte�do JSON
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
     * Plugin que faz a valida��o do fomul�rio
     */
    $.fn._dlformulario = function(opcoes){
        // Esse plugin ser� utilizado apenas para formul�rios <form..>...</form>
        if( $(this)[0].tagName !== "FORM" ){
            alert("O plugin _dlfomulario s� pode ser utilizado em formul�rios.\nEx.: <form ...>...</form>");
            return false;
        } // Fim if( this.tagName !== "FORM" )
        
        var $this = $(this);
        
        // Op��es padr�o
        var padrao = {
            // Controle que executar� o formul�rio
            controle: null,
            
            // Apar�ncia do formul�rio e dos seus elementos,
            // que ser�o definidos por uma classe
            aparencia: { tema: "dl-formulario", estilo: "formulario" },
            
            // Fun��o a ser executada antes do submit do formul�rio
            antes: function(){ return true; },
            
            // Fun��o a ser executada ap�s a submiss�o do formul�rio
            depois: function(){ return true; },
            
            // Configura��o dos campos do formul�rio que precisam de valida��o
            // ou necessita aplicar algum m�scara
            campos: {  },
            
            // Definir se o formul�rio ser� resetado ap�s o submit
            reset: false,
            
            // Definir um checkbox para selecionar os demais
            cktodos: [false, ":checkbox:first", ":checkbox[name^='[]']"]
        };
        
        // Carregar as op��es e mescl�-las com as op��es padrao
        opcoes = $.extend({}, padrao, opcoes);
        
        // Carregar o tema para o formul�rio e seus elementos
        if( opcoes.aparencia !== null ){
            if( typeof(CarregarCSS) === "function" )
                CarregarCSS(dir_raiz +"/aplicacao/js/dl-formulario/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");

            // Incluir a classe para o formul�rio
            $this.addClass(opcoes.aparencia.tema);
        } // if( opcoes.aparencia !== null )
        
        /**
         * Complementar a fun��o 'depois'
         */
        fnc_depois = function(){
            if( opcoes.reset ) this.reset();
                // $this.each(function(){ this.reset(); });
            
            return opcoes.depois();
        };
        
        /**
         * Organizar a navega��o pelo TAB
         */
        $this.find("input:not(:hidden):not([readonly]), select, textarea").each(function(i){
            $(this).attr({
                tabindex: i+1
            });
        });
        
        /**
         * Configurar o comportamento 'reset' do formul�rio, para que retorne
         * � p�gina anterior
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
        
        // Aplicar a valida��o dos campos
        for( var a in opcoes.campos )
            $this.find("[name='"+ a +"']")._dlcampos(opcoes.campos[a]);
        
        /**
         * Alterar o submit do formul�rio para utilizar o
         * AJAX
         */
        $this.submit(function(){
            // Executar a fun��o 'opcoes.antes', simulando o evento 'onsubmit'
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
             * Verificar se esse formul�rio tem como objetivo realizar o
             * upload de arquivos 
             */
            if( $this.attr("enctype") === "multipart/form-data" && $this.find(":file").length > 0 ){
                /**
                 * Criar um iframe escondido para submeter o formul�rio
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
                
                // Alterar onde o formul�rio far� o submit
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
                                mensagem    : "Portugu�s: 404 - P�gina n�o encontrada!<br />English: 404 - Page not found!",
                                tipo        : ["erro", "alerta"],
                                aparencia   : { tema: opcoes.aparencia.tema, estilo: "mensagem" },
                                botao       : { texto: "x" }
                            });
                        },

                        500: function(){
                            $("body")._dlformulario({
                                mensagem    : "Portugu�s: 500 - Erro interno do servidor!<br />English: 500 - Internal Server Error!",
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
            
            // Retornar false para impedir o submit original do formul�rio
            return false;
        });
        
        return $this;
    }; // Fim $.fn._dlformulario
    
    $.fn._dlmostrarmsg = function(opcoes){
        var $this = $(this);
        
        // Op��es padr�o
        var padrao = {
            // Mensagem a ser mostrada
            mensagem: "Portugu�s: Mensagem padr�o!\nEnglish: Default menssage!",
            
            // Tipo de mensagem a ser mostrada
            // Obs: Tamb�m pode interferir na apar�ncia da mensagem
            tipo: ["alerta", "atencao"],
            
            // Tempo que a mensagem dever� ser exibida em ms
            tempo: 8000,
            
            // Texto a ser exibido no bot�o
            botao: { texto: "Ok", funcao: function(){ return true; } },
            
            // Apar�ncia
            aparencia: { tema: "dl-formulario", estilo: "mensagem" },
            
            // Anima��o que far� a mensagem aparecer
            animacao: { mostrar: "para-baixo", ocultar: "para-cima", tempo: "1s" }
        };
        
        // Carregar as op��es e mescl�-las com as op��es padrao
        opcoes = $.extend({}, padrao, opcoes);
        
        // Carregar o tema para o formul�rio e seus elementos
        if( typeof(CarregarCSS) === "function" ){
            CarregarCSS(dir_raiz +"aplicacao/js/dl-formulario/css/"+ opcoes.aparencia.tema +"/"+ opcoes.aparencia.estilo +".css");
            CarregarCSS(dir_raiz +"aplicacao/js/dl-formulario/css/"+ opcoes.aparencia.tema +"/animacoes.css");
        } // Fim if( typeof(CarregarCSS) === "function" )
        
        // Incluir a classe para o formul�rio
        $this.addClass(opcoes.aparencia.tema);
        
        /** 
         * N�o permitir v�rias mensagens para o mesmo campo
         */
        if( $.inArray("campo", opcoes.tipo) > -1 ){
            $("#msg-"+ $this.attr("name")).fadeOut("fast", function(){ $(this).remove(); });
        } // Fim if( $.inArray("campo", opcoes.tipo) > -1 )
        
        // ID �nico para controlar o timeout
        var id_unico = $("div.dl-formulario-mensagem").length;
        
        /**
         * Criar a DIV de exibi��o da mensagem
         */
        var $div = $(document.createElement("div")).addClass("dl-formulario-mensagem "+ opcoes.aparencia.tema +" "+ opcoes.tipo.join(" ")).css({
            "-webkit-animation-name": opcoes.animacao.mostrar,
            "-webkit-animation-duration":  opcoes.animacao.tempo,
            "-webkit-animation-fill-mode": "forwards"
        }).attr({
            id: $.inArray("campo", opcoes.tipo) > -1 ? "msg-"+ $this.attr("name") : id_unico
        });
        
        /**
         * Para campos, colocar a mensagem logo ap�s o elemento.
         * Para outros elementos, colocar a mensagem dentro do mesmo
         */
        var campos = ['INPUT', 'TEXTAREA', 'SELECT', 'BUTTON'];
        $.inArray(this[0].tagName, campos) > -1 ? $div.insertAfter($this) : $div.appendTo($this);
        
        /**
         * Criar um par�grafo (p) que ir� receber o texto e
         * coloc�-lo dentro da div
         */
        var $p = $(document.createElement("p")).html(opcoes.mensagem).appendTo($div);
        
        // Criar o bot�o de fechamento da mensagem
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
            
            // Reabilitar o bot�o submit
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
     * Valida��o e m�scara de campos
     */
    $.fn._dlcampos = function(opcoes){
        var $this = $(this);
        
        // Op��es padr�o
        var padrao = {
            // Apelido / nome do campo
            apelido: $this.attr("title"),
            
            // Define se esse campo � obrigat�rio
            obr: false,
            
            // Define se esse campos ser� marcado como obrigat�rio ou n�o
            // Obs: depende do par�metro 'obr'
            marcarobr: true,
            
            // M�scara a ser aplicada
            mascara: null,
            
            // Express�o regular respons�vel por validar esse campo
            validacao: null
        };
        
        // Carregar as op��es e mescl�-las com as op��es padrao
        opcoes = $.extend({}, padrao, opcoes);
        
         // Configura��es da m�scara
         if (opcoes.mascara !== null) {
            this.defaultValue = opcoes.mascara.replace(/#/g, "_");

            if ($this.attr("value") === "")
                $this.val(this.defaultValue);

            // Definir o tamanho m�ximo do campo para o tamanho
            // da m�scara
            $this.attr("maxlength", opcoes.mascara.length + 1);
        } // Fim if( opcoes.mascara != null )
        
        // Configura��es de campo obrigat�rio
        if (opcoes.obr && opcoes.marcarobr) {
            // Criar um SPAN e incluir um asterisco vermelho para indicar
            // obrigatoriedade de preenchimento
            $span = $(document.createElement("span")).css("color", "red").html("*");

            // Verificar se o campo est� dentro de uma label ou se h�
            // uma label espec�fica para esse campo
            $label = $this.parents("label").length > 0 ? $this.parents("label") : $("label[for='" + $this.attr("name") + "']");

            if ($label.length > 0)
                $span.appendTo($label);
            else
                $span.insertAfter($this);
        } // Fim if( opcoes.obr )
        
        // Configurar a m�scara (caso haja)
        $this.keyup(function(){
           if( opcoes.mascara !== null){
                var $_this = $(this);

                var valor_mascara_i = opcoes.mascara.replace(/#/g, "_");
                var valor_limpo     = $_this.val().replace(/[^A-Z^a-z^0-9]/g, "");
                var num             = valor_limpo.length;
                
                for(var i=0; i<num; i++)
                    valor_mascara_i = valor_mascara_i.replace("_", valor_limpo[i]);

                $_this.val(valor_mascara_i);
                
                // Alterar a posi��o do cursor
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
     * Valida��o de campos do formul�rio
     */
    $.fn._dlvalidacao = function(opcoes){
        var $this = $(this);
        
        // Op��es padr�o
        var padrao = {
            // Apelido / nome do campo
            apelido: $this.attr("title"),
            
            // Definir se esse campo tem preenchimento obrigat�rio
            obr: false, 
            
            // M�scara a ser aplicada
            mascara: null,
            
            // Express�o regular respons�vel pela valida��o do campo
            validacao: null
        };
        
        // Carregar as op��es e mescl�-las com as op��es padrao
        opcoes = $.extend({}, padrao, opcoes);

        var valor = $this.val(); if( opcoes.mascara !== null ) valor = valor.replace(opcoes.mascara.replace(/#/g, "_"), "");
        var coord = $this.position();
        
        if( opcoes.obr && valor === "" ){
            // Mover a janela at� o campo
            window.scrollTo(0, coord.top-100);
            
            $this._dlmostrarmsg({
                mensagem    : "O campo <b>"+ opcoes.apelido +"</b> � obrigat�rio!<br />Por favor preencha corretamente.",
                tipo        : ["campo", "erro"],
                botao       : { texto: "x" },
                animacao    : { mostrar: "fadein", ocultar: "fadeout", tempo: "1s" },
                aparencia   : { tema: "colorido", estilo: "mensagem" }
            });
            
            return false;
        } // Fim if( opcoes.obr && valor === "" )
        
        if( opcoes.validacao !== null ){
            if( valor != "" && !opcoes.validacao.test(valor) ){
                // Mover a janela at� o campo
                window.scrollTo(0, coord.top-100);

                $this._dlmostrarmsg({
                    mensagem    : "O campo <b>"+ opcoes.apelido +"</b> n�o obecece o formato necess�rio.<br />Por favor preencha corretamente.",
                    tipo        : ["campo", "erro"],
                    botao       : { texto: "x" },
                    animacao    : { mostrar: "fadein", ocultar: "fadeout", tempo: "1s" },
                    aparencia   : { tema: "colorido", estilo: "mensagem" }
                });

                return false;
            } // Fim if( opcoes.obr && valor === "" )
        } // Fim if( opcoes.validacao !== null )
        
        /**
         * Ao chegar at� esse ponto, significa que o campo foi validado
         * corretamente e qualquer mensagem exibida sobre ele podeser removida
         */
        $this.find("+.dl-formulario-mensagem").fadeOut("fast", function(){ $(this).remove(); });
        
        return $this;
    };
})(jQuery);
