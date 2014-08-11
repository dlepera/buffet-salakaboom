<?php

/**
 * @Autor	: Diego Lepera
 * @Projeto	: FrameworkDL
 * @Data	: 15/05/2014 15:41:26
 */

/* --------------------------------------------------------------------------------------------------------------------
 * Mensagens padrões
 * ----------------------------------------------------------------------------------------------------------------- */
define('MSG_PADRAO_POR_FAVOR_TENTE_NOVAMENTE_MAIS_TARDE', 'Please, try again later.');

/* --------------------------------------------------------------------------------------------------------------------
 * Erros personalizados
 * ----------------------------------------------------------------------------------------------------------------- */
# 403
define('TXT_TITULO_ERRO_403', 'Erroe 403: access denied');
define('MSG_ERRO_403', 'Sorry, you don\'t have permission to access this file or directory.');

# 404
define('TXT_TITULO_ERRO_404', 'Error 404: page not found');
define('MSG_ERRO_404', 'This page may have been removed or moved to another location.');

/* --------------------------------------------------------------------------------------------------------------------
 * Classes
 * ----------------------------------------------------------------------------------------------------------------- */
# Erros padrões
define('ERRO_PADRAO_PROPRIEDADE_NAO_EXISTE', 'Property <b>%s</b> not found!');
define('ERRO_PADRAO_METODO_NAO_EXISTE', 'Methosd %s not found!');
define('ERRO_PADRAO_FORMATO_NAO_CORRESPONDE', 'Invalid format to %s!');
define('ERRO_PADRAO_VALOR_INVALIDO', 'Invalid value to %s!');
define('ERRO_PADRAO_PROPRIEDADE_NAO_EXISTE_OU_NAO_PODE_SER_ACESSADA', '<span style="color: red;">This property not exists or cant be access!</span>');

/* --------------------------------------------------------------------------------------------------------------------
 * Registros
 * ----------------------------------------------------------------------------------------------------------------- */
# Mensagens
define('MSG_PADRAO_NENHUM_REGISTRO_ENCONTRADO', 'Record not found.');
define('MSG_PADRAO_DESEJA_REALMENTE_REMOVER_ESSE_REGISTRO', 'Do you really remove this record?');
define('MSG_PADRAO_DESEJA_REALMENTE_REMOVER_REGISTROS_SELECIONADOS', 'Do you really remove the selected records?');

# Mensagens de sucessos
define('SUCESSO_PADRAO_SALVAR_REGISTRO', 'The %s record saved successfully!');
define('SUCESSO_PADRAO_REMOVER_REGISTROS', 'Removed %d %s of %d selected!');

# Mensagens de erros
define('ERRO_PADRAO_SALVAR_REGISTRO', 'An error found on save record!<br />'. MSG_PADRAO_POR_FAVOR_TENTE_NOVAMENTE_MAIS_TARDE);
define('ERRO_PADRAO_REMOVER_REGISTROS', 'On error found on remove record!<br />'. MSG_PADRAO_POR_FAVOR_TENTE_NOVAMENTE_MAIS_TARDE);

/* --------------------------------------------------------------------------------------------------------------------
 * Opções
 * ----------------------------------------------------------------------------------------------------------------- */
define('TXT_OPCAO_SELECIONE_UMA_OPCAO', 'Select an option');

/* --------------------------------------------------------------------------------------------------------------------
 * Botões
 * ----------------------------------------------------------------------------------------------------------------- */
# Submits
define('TXT_BOTAO_SUBMIT_ENVIAR', 'Send');
define('TXT_BOTAO_SUBMIT_SALVAR', 'Save');
define('TXT_BOTAO_SUBMIT_FILTRAR', 'Search');
define('TXT_BOTAO_ENTRAR', 'Enter');

# Resets
define('TXT_BOTAO_RESET_CANCELAR', 'Cancel');


/* --------------------------------------------------------------------------------------------------------------------
 * Classe AcessoRestrito
 * ----------------------------------------------------------------------------------------------------------------- */
# Erro
define('ERRO_ACESSORESTRITO_USUARIO_SENHA_INVALIDOS', 'Invalid user and/or password!');
