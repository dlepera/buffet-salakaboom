<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 29, 2014 5:41:17 PM
 */

/* ----------------------------------------------------------------------------------------------------------------------
 * Website buffetsalakaboom.com.br
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^nosso-cardapio$'] = array(
    'controle'  =>  'CardapioW',
    'acao'      =>  'lista'
);

$rotas['^nossos-parceiros$'] = array(
    'controle'  =>  'ParceiroW',
    'acao'      =>  'lista'
);

$rotas['^orcamento-on-line$'] = array(
    'controle'  =>  'OrcamentoW',
    'acao'      =>  'formulario'
);

$rotas['^depoimentos$'] = array(
    'controle'  =>  'DepoimentoW',
    'acao'      =>  'lista'
);

$rotas['^enviar-depoimento$'] = array(
    'controle'  =>  'DepoimentoW',
    'acao'      =>  'formulario'
);

$rotas['^certificado-de-excelencia$'] = array(
    'controle'  =>  'WebSite',
    'acao'      =>  'certificado'
);

$rotas['^mapa$'] = array(
    'controle'  =>  'WebSite',
    'acao'      =>  'mapa'
);

$rotas['^convites-virtuais$'] = array(
    'controle'  =>  'ConviteVirtual',
    'acao'      =>  'formulario'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Painel-DL <Módulo Salakaboom>
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^painel-dl/salakaboom/cardapios/lista$'] = array(
    'controle'  =>  'Cardapio',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/salakaboom/cardapios/novo$'] = array(
    'controle'  =>  'Cardapio',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/salakaboom/cardapios/alterar/\d+$'] = array(
    'controle'  =>  'Cardapio',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/salakaboom/cardapios/alterar/:id'
);

$rotas['^painel-dl/salakaboom/parceiros/lista$'] = array(
    'controle'  =>  'Parceiro',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/salakaboom/parceiros/novo$'] = array(
    'controle'  =>  'Parceiro',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/salakaboom/parceiros/alterar/\d+$'] = array(
    'controle'  =>  'Parceiro',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/salakaboom/parceiros/alterar/:id'
);

$rotas['^painel-dl/salakaboom/tipos-de-parceiros/lista$'] = array(
    'controle'  =>  'TipoParceiro',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/salakaboom/tipos-de-parceiros/novo$'] = array(
    'controle'  =>  'TipoParceiro',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/salakaboom/tipos-de-parceiros/alterar/\d+$'] = array(
    'controle'  =>  'TipoParceiro',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/salakaboom/tipos-de-parceiros/alterar/:id'
);

$rotas['^painel-dl/salakaboom/produtos/lista$'] = array(
    'controle'  =>  'Produto',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/salakaboom/produtos/novo$'] = array(
    'controle'  =>  'Produto',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/salakaboom/produtos/alterar/\d+$'] = array(
    'controle'  =>  'Produto',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/salakaboom/produtos/alterar/:id'
);

$rotas['^painel-dl/salakaboom/orcamentos-enviados/lista$'] = array(
    'controle'  =>  'Orcamento',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/salakaboom/orcamentos-recebidos/detalhes-do-orcamento/\d+$'] = array(
    'controle'  =>  'Orcamento',
    'acao'      =>  'detalhes',
    'params'    =>  '/painel-dl/salakaboom/orcamentos-recebidos/detalhes-do-orcamento/:id'
);

$rotas['^painel-dl/salakaboom/depoimentos/lista$'] = array(
    'controle'  =>  'Depoimento',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/salakaboom/horarios-de-atendimento/lista$'] = array(
    'controle'  =>  'Horario',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/salakaboom/horarios-de-atendimento/novo$'] = array(
    'controle'  =>  'Horario',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/salakaboom/horarios-de-atendimento/alterar/\d+$'] = array(
    'controle'  =>  'Horario',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/salakaboom/horarios-de-atendimento/alterar/:id'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Painel-DL <Módulo Convites Virtuais>
 * ------------------------------------------------------------------------------------------------------------------- */
$rotas['^painel-dl/convites-virtuais/modelos/lista$'] = array(
    'controle'  =>  'ModeloConvite',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/convites-virtuais/modelos/novo$'] = array(
    'controle'  =>  'ModeloConvite',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/convites-virtuais/modelos/alterar/\d+$'] = array(
    'controle'  =>  'ModeloConvite',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/convites-virtuais/modelos/alterar/:id'
);

$rotas['^painel-dl/convites-virtuais/logins/lista$'] = array(
    'controle'  =>  'LoginConvite',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/convites-virtuais/logins/novo$'] = array(
    'controle'  =>  'LoginConvite',
    'acao'      =>  'formulario'
);

$rotas['^painel-dl/convites-virtuais/logins/alterar/\d+$'] = array(
    'controle'  =>  'loginConvite',
    'acao'      =>  'formulario',
    'params'    =>  '/painel-dl/salakaboom/logins/alterar/:id'
);

$rotas['^painel-dl/convites-virtuais/envios/lista$'] = array(
    'controle'  =>  'EnvioConvite',
    'acao'      =>  'lista'
);

$rotas['^painel-dl/convites-virtuais/envios/detalhes-do-envio/\d+$'] = array(
    'controle'  =>  'EnvioConvite',
    'acao'      =>  'detalhes',
    'params'    =>  '/painel-dl/convites-virtuais/envios/detalhes-do-envio/:id'
);

/* ----------------------------------------------------------------------------------------------------------------------
 * Ações
 * ------------------------------------------------------------------------------------------------------------------- */
# Salvar um item de cardápio
$rotas['^itemcardapio/salvar/\d+$'] = '/:controle/:acao/:cardapio';

# Mostrar o e-mail HTML do orçamento
$rotas['^orcamento/mostrar-html/\d+'] = array(
    'controle'  =>  'OrcamentoW',
    'acao'      =>  'mostrarhtml',
    'params'    =>  '/orcamento/mostrar-html/:id'
);

# Mostrar o e-mail HTML do email convite virtual
$rotas['^convites-virtuais/mostrar-html/\d+/.+'] = array(
    'controle'  =>  'ConviteVirtual',
    'acao'      =>  'mostrarhtml',
    'params'    =>  '/convites-virtuais/mostrar-html/:id/:email'
);