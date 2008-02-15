<?php

/**
* $Id: modinfo.php 807 2008-02-07 13:34:51Z fx2024 $
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path não definido");
}

// Module Info
// The name of this module

global $xoopsModule;
define("_MI_SSHOP_MD_NAME", "SmartShop");
define("_MI_SSHOP_MD_DESC", "Simples e flexivel módulo de conteúdos");

define("_MI_SSHOP_INDEX", "Index");
define("_MI_SSHOP_CATEGORIES", "Categorias");
define("_MI_SSHOP_ITEMS", "Items");
define("_MI_SSHOP_TRANSACTION", "Transações");
define("_MI_SSHOP_CHECKOUT_CONFIG", "Pagina de Checagem");

define("_MI_SSHOP_ITEMSPERPAGE", "Páginas por categoria");
define("_MI_SSHOP_ITEMSPERPAGE_DSC", "Selecione a quantidade de páginas que você gostaria que fossem exibidas em cada categoria");

define("_MI_SSHOP_MODMETADESC", "Meta-description do módulo");
define("_MI_SSHOP_MODMETADESC_DSC", "Isto será usado como meta-description na página principal do módulo");
define("_MI_SSHOP_INVENTORY", "Inventório");
define("_MI_SSHOP_GLOBAL_CSTMFLDS", "Campos globais personalizados");

define("_MI_SSHOP_SUBMIT_BY_CAT", "Envie um item");
define("_MI_SSHOP_WAIT_APPROVAL", "Items enviados");
define("_MI_SSHOP_CURR_USER_SUB", "Seus envios");
define("_MI_SSHOP_RENEW", "Renovar expirados");

define("_MI_SSHOP_NEW_SEARCH", "Pesquisa");
define("_MI_SSHOP_NEW_ADDS", "Itens recentes");
define("_MI_SSHOP_NEW_SELLERS", "Novos vendedores");

define("_MI_SSHOP_GLOBAL_ITEM_NOTIFY", "Global");
define("_MI_SSHOP_GLOBAL_ITEM_NOTIFY_DSC", "");

define("_MI_SSHOP_ITEM_NOTIFY", "Item");
define("_MI_SSHOP_ITEM_NOTIFY_DSC", "");

define("_MI_SSHOP_ITEM_APPROVED_NOTIFY", "item aprovado");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_CAP", "Notifique-me quando este item será aprovado");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_DSC", "");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_SBJ", "Seu item foi aprovado");

define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY", "Item enviado");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_CAP", "Notifique-me quando um usuário enviar um novo item");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_DSC", "");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_SBJ", "Item enviado");

define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY", "item publicado");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP", "Notifique quando um novo item for aprovado");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC", "");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ", "Novo item publicado");

define("_MI_SSHOP_CATEGORY_NAV", "Ativar navegação por categoria");
define("_MI_SSHOP_CATEGORY_NAV_DSC", "Se você selecionar 'Sim', uma lista de todas as categorias será exibida na página principal do módulo.'");
define("_MI_SSHOP_NAV_MODE", "Modo de navegação'");
define("_MI_SSHOP_NAV_MODE_DSC", "Se você selecionar 'Bread crumb', o caminho atual será exibido em cada página.<br/>O modo 'Voltar' exibirá um link 'voltar à página anterior' em cada página.");
define("_MI_SSHOP_NAV_MODE_BREAD", "Bread crumb");
define("_MI_SSHOP_NAV_MODE_BACK", "Voltar");
define("_MI_SSHOP_NAV_MODE_NONE", "Nenhum");
define("_MI_SSHOP_CURRENCIES", "Moedas");
define("_MI_SSHOP_CURRENCIES_DSC", "Moedas disponíveis para os itens.");
define("_MI_SSHOP_CURRENCY_CANDOL", "CDA");
define("_MI_SSHOP_CURRENCY_REAL", "Real");
define("_MI_SSHOP_CURRENCY_USDOL", "USD");
define("_MI_SSHOP_CURRENCY_EURO", "Euro");
define("_MI_SSHOP_DEFEDITOR", "Editor padrão");
define("_MI_SSHOP_DEFEDITOR_DSC", "");

define("_MI_SSHOP_MAX_SIZE", "Tamanho máximo da imagem do item permitida para upload");
define("_MI_SSHOP_MAX_SIZE_DSC", "");
define('_MI_SSHOP_IMG_MAX_WIDTH', "Largura máxima das imagens:");
define('_MI_SSHOP_IMG_MAX_WIDTH_DSC', "Esta será a largura máxima permitida para o upload de imagens.");
define("_MI_SSHOP_IMG_MAX_HEIGHT", "Altura máxima das imagens:");
define("_MI_SSHOP_IMG_MAX_HEIGHT_DSC", "Esta será a altura máxima permitida para o upload de imagens.");
define("_MI_SSHOP_DEF_DELAY_EXP", "Prazo padrão para expirar");
define("_MI_SSHOP_DEF_DELAY_EXP_DSC", "Número de dias entre a publicação e a expiração de um item. <b>Deve ser um número inteiro.</b> Use '0' para fazer itens que não expiram.");
define("_MI_SSHOP_DISPLAY_POSTER", "Exibir nome de quem enviou");
define("_MI_SSHOP_DISPLAY_POSTER_DSC", "");
define("_MI_SSHOP_DISPLAY_DATE_PUB", "Exibir data de publicação dos itens");
define("_MI_SSHOP_DISPLAY_DATE_PUB_DSC", "");
define("_MI_SSHOP_EXP_MANAGEBY_CRON", "Gerenciamento de expiração usa cron job?");
define("_MI_SSHOP_EXPMANAGEBYCRONDSC", "Recomendado. Você deve executar 'smartshop/_cron_expire.php' através de um cron job.<br>Caso contrário, a checagem de vencimento é feito sempre que um usuário entrar no site.");
define("_MI_SSHOP_DEF_AVATAR", "Imagem padrão dos usuários");
define("_MI_SSHOP_DEF_AVATAR_DSC", "Imagem que será mostrada em informações do usuário, no caso de ele não possuir um avatar. Deve ser na pasta smartshop/imagens. Deixe em branco para não mostrar imagens padrão.");
define("_MI_SSHOP_DEF_ITEM_PIC", "Imagem padrão dos itens");
define("_MI_SSHOP_DEF_ITEM_PIC_DSC", "Imagem que será mostrada nas informações dos itens no caso de não ter foto. Deve ser na pasta smartshop/imagens. Deixe em branco para não mostrar imagens padrão.");
define("_MI_SSHOPSUBMIT_INTRO", "Introdução da página de envio de itens");
define("_MI_SSHOP_SORT", "Ordenar itens por:");
define("_MI_SSHOP_CAT_SORT", "Ordenar categorias por:");
define("_MI_SSHOP_SORT_DSC", "");
define("_MI_SSHOP_SORT_WEIGHT", "Peso");
define("_MI_SSHOP_SORT_DATE", "Data");
define("_MI_SSHOP_SORT_ALPHA", "Alpha");
define("_MI_SSHOP_DISP_FIELDS", "Campos a exibir");
define("_MI_SSHOP_DISP_FIELDS_DSC", "Campos visíveis (não se aplica a campos personalizados)");
define("_MI_SSHOP_DISP_FIELDS_LINK", "Link Externo");
define("_MI_SSHOP_DISP_FIELDS_DESC", "Descrição");
define("_MI_SSHOP_DISP_FIELDS_IMG", "Imagem");
define("_MI_SSHOP_DISP_FIELDS_PRICE", "Preço");
define("_MI_SSHOP_DISP_FIELDS_COUNT", "Visualizações");
define("_MI_SSHOP_DISP_FIELDS_DATE", "Data");
define("_MI_SSHOP_NOTIF_EXP", "Notificação de Expiração");
define("_MI_SSHOP_NOTIF_EXP_DSC", "Selecione quantos dias antes da expiração você deseja notificar o autor");
define("_MI_SSHOP_AUTO_APP", "Itens enviados são sempre aprovados");
define("_MI_SSHOP_AUTO_APP_DSC", "Se você selecionar 'Não', um moderador deve aprovar itens enviados ou editados");
define("_MI_SSHOP_NONE", "Sem notificação");
define("_MI_SSHOP_ONLY_EXP", "Apenas ao expirar");
define("_MI_SSHOP_ALLWD_GRP", "Grupos que podem enviar");
define("_MI_SSHOP_ALLWD_GRP_DSC", "Selecione os grupos que podem enviar itens.");
define("_MI_SSHOP_INCLUDESEARCH", "Incluir pesquisa");
define("_MI_SSHOP_INCLUDESEARCHDSC", "Incluir pesquisa na parte inferior de todas as páginas no módulo");
define("_MI_SSHOP_DEFCATVIEWGR", "Permissões padrão para visualização da categoria");
define("_MI_SSHOP_DEFCATVIEWGRDSC", "Grupos que terão permissão de ver a categoria por padrão");
define("_MI_SSHOP_SUB_MENU", "Envie um item");
define("_MI_SSHOP_BCRUMB", "Exibir nome do módulo no bread crumb");
define("_MI_SSHOP_BCRUMBDSC", "");
define("_MI_SSHOP_INPUTTYPE_SEARCH", "Tipo de campo paras as categorias na busca");
define("_MI_SSHOP_INPUTTYPE_SEARCHDSC", "");
define("_MI_SSHOP_INPUTTYPE_RADIO", "Radio button");
define("_MI_SSHOP_INPUTTYPE_SELECT", "Select box");
define("_MI_SSHOP_CAT_TPL", "Tipo de visualização na página de categorias");
define("_MI_SSHOP_CAT_TPL_DSC", "");
define("_MI_SSHOP_TPL_LIST", "List view");
define("_MI_SSHOP_TPL_TABLE", "Table view");
define("_MI_SSHOP_BASKET", "Carrinho de Compras");
define("_MI_SSHOP_STANDARD", "Versão Padrão");
define("_MI_SSHOP_CUSTOM_VERSION" , "Versão do Módulo");
define("_MI_SSHOP_CUSTOM_VERSIONDSC", "Selecione o nome do seu site ou deixe em branco para 'Padrão'");

define("_MI_SSHOP_ORDER_MAIL", "Enviar e-mail para os grupos:");
define("_MI_SSHOP_ORDER_MAIL_DSC", "Selecione grupos que irão receber e-mails quando um usuário solicitar no site.");
define("_MI_SSHOP_EXTRA_EMAILS", "Envie e-mails de solicitações para o endereço");
define("_MI_SSHOP_EXTRA_EMAILS_DSC", " Entre com um novo endereço de e-mail separado por ';'");
define("MI_SSHOP_SIGNATURE", "Assinatura");
define("_MI_SSHOP_SIGNATURE_DSC", "Assinatura para e-mails de confirmação que serão enviados aos usuarios.");
define("_MI_SSHOP_HEADER_PRINT", "Cabeçalho para pagina de impressão");
define("_MI_SSHOP_HEADER_PRINT_DSC", "");
define("_MI_SSHOP_FOOTER_PRINT", "Rodapé para pagina de impressão");
define("_MI_SSHOP_FOOTER_PRINT_DSC", "");
define("_MI_SSHOP_MAX_QTY_BASKET", "Quantidade maxima a ser adicionada na cesta");
define("_MI_SSHOP_MAX_QTY_BASKET_DSC", "Digite '1' para mostrar quantidade. Digite '0' para desabilitar os botões 'Adicione ao carrinho'. Apenas valores numéricos.");
define("_MI_SSHOP_TAREA_WIDTH", "# colunas para as areas de texto");
define("_MI_SSHOP_TAREA_WIDTH_DSC", "");
define("_MI_SSHOP_TAREA_HEIGHT", "# linhas para as areas de texto");
define("_MI_SSHOP_TAREA_HEIGHT_DSC", "");
?>