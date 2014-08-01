<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 15:41:26
 */

/* --------------------------------------------------------------------------------------------------------------------
 * Dias da semana
 * ----------------------------------------------------------------------------------------------------------------- */
define('TXT_DIADASEMANA_DOMINGO', 'Domingo');
define('TXT_DIADASEMANA_SEGUNDA_FEIRA', 'Segunda-feira');
define('TXT_DIADASEMANA_TERCA_FEIRA', 'Ter�a-feira');
define('TXT_DIADASEMANA_QUARTA_FEIRA', 'Quarta-feira');
define('TXT_DIADASEMANA_QUINTA_FEIRA', 'Quinta-feira');
define('TXT_DIADASEMANA_SEXTA_FEIRA', 'Sexta-feira');
define('TXT_DIADASEMANA_SABADO', 'S�bado');

/* --------------------------------------------------------------------------------------------------------------------
 * Mensagens padr�es
 * ----------------------------------------------------------------------------------------------------------------- */
define('MSG_PADRAO_POR_FAVOR_TENTE_NOVAMENTE_MAIS_TARDE', 'Por favor, tente novamente mais tarde.');

/* --------------------------------------------------------------------------------------------------------------------
 * Erros personalizados
 * ----------------------------------------------------------------------------------------------------------------- */
# 403
define('TXT_TITULO_ERRO_403', 'Erro 403: acesso negado');
define('MSG_ERRO_403', 'Desculpe, voc� n�o tem acesso a esse arquivo, p�gina ou diret�rio.');

# 404
define('TXT_TITULO_ERRO_404', 'Erro 404: p�gina n�o encontrada');
define('MSG_ERRO_404', 'Essa p�gina pode ter sido removida ou movida para outro local.');

/* --------------------------------------------------------------------------------------------------------------------
 * Classes
 * ----------------------------------------------------------------------------------------------------------------- */
# Erros padr�es
define('ERRO_PADRAO_PROPRIEDADE_NAO_EXISTE', 'Propriedade <b>%s</b> n�o existe!');
define('ERRO_PADRAO_METODO_NAO_EXISTE', 'M�todo %s n�o existe!');
define('ERRO_PADRAO_FORMATO_NAO_CORRESPONDE', 'Formato inv�lido para %s!');
define('ERRO_PADRAO_VALOR_INVALIDO', 'Valor inv�lido para %s!');
define('ERRO_PADRAO_PROPRIEDADE_NAO_EXISTE_OU_NAO_PODE_SER_ACESSADA', '<span style="color: red;">Essa propriedade n�o existe ou n�o p�de ser acessada!</span>');

/* --------------------------------------------------------------------------------------------------------------------
 * Registros
 * ----------------------------------------------------------------------------------------------------------------- */
# Mensagens
define('MSG_PADRAO_NENHUM_REGISTRO_ENCONTRADO', 'Nenhum registro encontrado.');
define('MSG_PADRAO_DESEJA_REALMENTE_REMOVER_ESSE_REGISTRO', 'Deseja realmente remover esse registro?');
define('MSG_PADRAO_DESEJA_REALMENTE_REMOVER_REGISTROS_SELECIONADOS', 'Deseja remover os registros selecionados?');

# Mensagens de sucessos
define('SUCESSO_PADRAO_SALVAR_REGISTRO', 'O registro de %s foi salvo com sucesso!');
define('SUCESSO_PADRAO_REMOVER_REGISTROS', 'Foi removido %d %s de um total de %d selecionados!');

# Mensagens de erros
define('ERRO_PADRAO_SALVAR_REGISTRO', 'Ocorreu um erro ao salvar o registro!<br />'. MSG_PADRAO_POR_FAVOR_TENTE_NOVAMENTE_MAIS_TARDE);
define('ERRO_PADRAO_REMOVER_REGISTROS', 'Ocorreu um erro ao remover o resgistro!<br />'. MSG_PADRAO_POR_FAVOR_TENTE_NOVAMENTE_MAIS_TARDE);

/* --------------------------------------------------------------------------------------------------------------------
 * Op��es
 * ----------------------------------------------------------------------------------------------------------------- */
define('TXT_OPCAO_SELECIONE_UMA_OPCAO', 'Selecione uma das op��es');

/* --------------------------------------------------------------------------------------------------------------------
 * Bot�es
 * ----------------------------------------------------------------------------------------------------------------- */
# Submits
define('TXT_BOTAO_SUBMIT_ENVIAR', 'Enviar');
define('TXT_BOTAO_SUBMIT_SALVAR', 'Salvar');
define('TXT_BOTAO_SUBMIT_FILTRAR', 'Filtrar');
define('TXT_BOTAO_ENTRAR', 'Entrar');

# Resets
define('TXT_BOTAO_RESET_CANCELAR', 'Cancelar');

/* --------------------------------------------------------------------------------------------------------------------
 * Classe AcessoRestrito
 * ----------------------------------------------------------------------------------------------------------------- */
# Erro
define('ERRO_ACESSORESTRITO_USUARIO_SENHA_INVALIDOS', 'Usu�rio e/ou senha inv�lidos!');
define('ERRO_PADRAO_USUARIO_NAO_TEM_PERMISSAO', 'Erro! Voc� n�o tem permiss�o para executar essa a��o');
