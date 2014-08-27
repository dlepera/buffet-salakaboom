/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 11:43:08
 */

var dir_raiz = "/buffet-salakaboom/";

function CarregarCSS(arquivo_css){
    // Tratar o nome do arquivo CSS
    arquivo_css = dir_raiz.replace(/\/$/, "") +"/"+ arquivo_css.replace(dir_raiz, "").replace(/^\//, "");
    
    $(document).ready(function(){
        // Verificar se o arquivo CSS já não foi carregado
        var $css_carregado = $("link[rel='stylesheet'][href='"+ arquivo_css +"']");

        if( $css_carregado.length > 0 )
            return true; // Arquivo já carregado

        // - Criar o novo link de ligação ao CSS
        // - Incluir a TAG na sessão HEAD da página
        // Obs.: Para manter organizado a folha de estilo será adicionada
        // em seguida à última
        $(document.createElement("link")).attr({
            rel     : 'stylesheet',
            type    : 'text/css',
            media   : 'all',
            href    : arquivo_css
        }).insertAfter("html head link:last-of-type");
    });

    return true;
} // Fim function CarregarCSS

/*
 * Remover um registro
 */
function RemoverRegistro(msg){
    if( !confirm(msg) )
        return false;

    $editar_lista.submit();
} // Fim function RemoverRegistro

/*
 * Alterar o controle de um formulário
 */
function AlterarControle(formulario, controlador, confirmacao){
    if( !confirm(confirmacao) )
        return false;

    $editar_lista = $(formulario)._dlformulario({
        controle: controlador,
        depois: function() {
            window.location.reload();
        }
    }).submit();
} // Fim function RemoverRegistro

function MoverCursor(objeto, posicao){
    return objeto.setSelectionRange(posicao, posicao);
} // Fim AlterarCursor(objeto, posicao)

/*
 * Selecionar uma linha em uma lista de resultados
 */
function SelecionarLinha(obj){
    var tag = obj.tagName;
    var $linha = tag === "TR" ? $(obj)
            : $(obj).parents("tr");

    // Alterar o estilo da linha
    $linha.addClass("selecionada");

    if( obj.type !== "checkbox" ){
        // Selecionar o checkbox dentro da linha
        $linha.find("td:first-child :checkbox").each(function() {
            this.checked = true;

            return true;
        });
    } // Fim if( obj.type != "checkbox" )

    return true;
} // Fim function SelecionaLinha(obj)

/**
 * Abrir formulário externo por cima do conteúdo atual
 * 
 * @param {string} form : Caminho que leva ao formulário a ser aberto
 */
function AbrirForm(form){
    $.ajax({
        url     : "/"+ form.replace(/^\//, ""),
        dataType: "html",
        success : function(html){
            var $form = $(document.createElement("div")).addClass("sobre-tela").html(html).appendTo($("body"));
            
            // Alterar algumas propriedades do formulário
            $form.find("[type='reset']").on("click", function(){
                $form.fadeOut("fast", function(){
                    $(this).remove();
                });
            });
        }
    });
} // Fim function AbrirForm(form)

// Adicionar o suporte ao trim
// Necessário para o IE (óbvio!!) 8 ou mais antigo
if( typeof String.prototype.trim !== "function" ){
  String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, ""); 
  };
}

/**
 * Configuração da execução do AJAX
 */
$.ajaxSetup({
    beforeSend  : function(){
        $(document.createElement("div")).attr("id", "carregando").addClass("sobre-tela").html(
            "<p class='carregando'>Processando, por favor aguarde...</p>"
        ).appendTo($("body")).fadeIn("fast");
    },
    
    complete    : function(){
        $("#carregando").fadeOut("fast", function(){
            $(this).remove();
        });
    }
});

$(document).ready(function(){
    $(":text[name='t']").bind("change", function(){
        var $this = $(this);
        
        if( $this.val() != "" )
            $this.css({ background: "#FFF" });
    }).filter(":not(:empty)").css({ background: "#FFF" });
});
