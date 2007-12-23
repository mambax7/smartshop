<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

// Module Info
// The name of this module

global $xoopsModule;
define("_MI_SSHOP_MD_NAME", "SmartShop");
define("_MI_SSHOP_MD_DESC", "Simple and flexible content module");

define("_MI_SSHOP_INDEX", "Index");
define("_MI_SSHOP_CATEGORIES", "Catégories");
define("_MI_SSHOP_ITEMS", "Items");
define("_MI_SSHOP_TRANSACTION", "Transactions");

define("_MI_SSHOP_ITEMSPERPAGE", "Items par catégorie");
define("_MI_SSHOP_ITEMSPERPAGE_DSC", "Nombre d'items par page");

define("_MI_SSHOP_MODMETADESC", "Meta-description du module");
define("_MI_SSHOP_MODMETADESC_DSC", "");
define("_MI_SSHOP_INVENTORY", "Inventaire");
define("_MI_SSHOP_SUBMIT_BY_CAT", "Soumettre un item");
define("_MI_SSHOP_WAIT_APPROVAL", "Items soumis");
define("_MI_SSHOP_CURR_USER_SUB", "Vos soumissions");
define("_MI_SSHOP_RENEW", "Renouveler expir&eacute;s");

define("_MI_SSHOP_NEW_SEARCH", "Recherche");
define("_MI_SSHOP_NEW_ADDS", "Items récents");
define("_MI_SSHOP_NEW_SELLERS", "Nouveaux vendeurs");



define("_MI_SSHOP_GLOBAL_ITEM_NOTIFY", "Global");
define("_MI_SSHOP_GLOBAL_ITEM_NOTIFY_DSC", "");

define("_MI_SSHOP_ITEM_NOTIFY", "Item");
define("_MI_SSHOP_ITEM_NOTIFY_DSC", "");

define("_MI_SSHOP_ITEM_APPROVED_NOTIFY", "Item approuvé");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_CAP", "Notifiez-moi quand cette annonce sera publiée");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_DSC", "");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_SBJ", "Votre annonce a été publiée");

define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY", "Item soumis");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_CAP", "Notifiez-moi quand un utilisateur soumet une annonce");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_DSC", "");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_SBJ", "Une annonce a été soumise");

define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY", "Item publié");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP", "Notifiez-moi à la publication d'une nouvelle annonce");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC", "");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ", "Nouvelle annonce publiée");

define("_MI_SSHOP_CATEGORY_NAV", "Activer la navigation par catégories");
define("_MI_SSHOP_CATEGORY_NAV_DSC", "Si vous choisissez 'Oui', la liste des catégories s'affichera dans la page index du module.'");
define("_MI_SSHOP_NAV_MODE", "Mode d'aide à la navigation'");
define("_MI_SSHOP_NAV_MODE_DSC", "Si vous choisissez 'Miettes de pain', le chemin sera affiché en haut de chaque page pour situer l'utilisateur.<br/>
		Le Mode 'Retour' fait afficher un bouton de retour à la page précédente sur chaque page.");
define("_MI_SSHOP_NAV_MODE_BREAD", "Miettes de pain");
define("_MI_SSHOP_NAV_MODE_BACK", "Retour");
define("_MI_SSHOP_NAV_MODE_NONE", "Aucun");
define("_MI_SSHOP_CURRENCIES", "Devises");
define("_MI_SSHOP_CURRENCIES_DSC", "Devises qui seront disponibles pour afficher les items.");
define("_MI_SSHOP_CURRENCY_CANDOL", "CDA");
define("_MI_SSHOP_CURRENCY_USDOL", "USD");
define("_MI_SSHOP_CURRENCY_EURO", "Euro");
define("_MI_SSHOP_DEFEDITOR", "Éditeur par défaut");
define("_MI_SSHOP_DEFEDITOR_DSC", "");

define("_MI_SSHOP_MAX_SIZE", "Grosseur maximale des images d'items à charger");
define("_MI_SSHOP_MAX_SIZE_DSC", "");
define('_MI_SSHOP_IMG_MAX_WIDTH', "Largeur maximale des images:");
define('_MI_SSHOP_IMG_MAX_WIDTH_DSC', "Ceci d&eacute;finira la largeur maximale des images pouvant &ecirc;tre charg&eacute;s dans le module.");
define('_MI_SSHOP_IMG_MAX_HEIGHT', "Hauter maximale des images:");
define('_MI_SSHOP_IMG_MAX_HEIGHT_DSC', "Ceci d&eacute;finira la hauteur maximale des images pouvant &ecirc;tre charg&eacute;s dans le module.");
define("_MI_SSHOP_DEF_DELAY_EXP", "Délai par défaut avant expiration");
define("_MI_SSHOP_DEF_DELAY_EXP_DSC", "Nombre de jours entre la publication d'un item et son expiration. <b>Doit être un nombre entier.</b>'. Inscrivez '0' pour que les items n'expirent pas");
define("_MI_SSHOP_DISPLAY_POSTER", "Afficher l'auteur");
define("_MI_SSHOP_DISPLAY_POSTER_DSC", "");
define("_MI_SSHOP_DISPLAY_DATE_PUB", "Afficher la date de publication des items");
define("_MI_SSHOP_DISPLAY_DATE_PUB_DSC", "");
define("_MI_SSHOP_EXP_MANAGEBY_CRON", "Gestion des expirations via un 'cron job'?");
define("_MI_SSHOP_EXPMANAGEBYCRONDSC", "Recommandé. Il faut alors faire éxécuter le script 'smartshop/cron_expire.php' via votre seveur.<br> Si vous cochez 'non', la vérification des expirations se fait à chaque visite d'un utilisateur.");
define("_MI_SSHOP_DEF_AVATAR", "Photo d'utilisateur par défaut");
define("_MI_SSHOP_DEF_AVATAR_DSC", "Image qui sera montrée dans les informations sur l'utilisateur dans le cas où celui-ci n'a pas d'avatar. Doit être placée dans le répertoire smartshop/images. Laisser blanc pour ne pas en mettre.");
define("_MI_SSHOP_DEF_ITEM_PIC", "Image d'item par défaut");
define("_MI_SSHOP_DEF_ITEM_PIC_DSC", "Image qui sera montrée dans les informations sur l'item dans le cas où celui-ci n'a pas d'image. Doit être placée dans le répertoire smartshop/images.  Laisser blanc pour ne pas en mettre.");
define("_MI_SSHOPSUBMIT_INTRO", "Introduction de la page de soumission d'item");
define("_MI_SSHOP_SORT", "Trier les liens par:");
define("_MI_SSHOP_SORT_DSC", "");
define("_MI_SSHOP_SORT_WEIGHT", "Poids");
define("_MI_SSHOP_SORT_DATE", "Date");
define("_MI_SSHOP_DISP_FIELDS", "Champs à afficher");
define("_MI_SSHOP_DISP_FIELDS_DSC", "Champs qui seront visible (ne concerne pas les champs particulliers)");
define("_MI_SSHOP_DISP_FIELDS_LINK", "Lien externe");
define("_MI_SSHOP_DISP_FIELDS_DESC", "Description");
define("_MI_SSHOP_DISP_FIELDS_IMG", "Image");
define("_MI_SSHOP_DISP_FIELDS_PRICE", "Prix");
define("_MI_SSHOP_DISP_FIELDS_COUNT", "Nombre de clics");
define("_MI_SSHOP_DISP_FIELDS_DATE", "Date d`affichage");
define("_MI_SSHOP_NOTIF_EXP", "Notifications d'expiration");
define("_MI_SSHOP_NOTIF_EXP_DSC", "Sélectionnez à combien de jours avant l'expiration vous souhaitez aviser l'auteur");
define("_MI_SSHOP_AUTO_APP", "Les items soumis sont toujours approuvés");
define("_MI_SSHOP_AUTO_APP_DSC", "Si vous cochez 'Non', un modérateur devra approuver les items soumis ou modifiés.");
define("_MI_SSHOP_NONE", "Aucune notification");
define("_MI_SSHOP_ONLY_EXP", "Seulement expiration");
define("_MI_SSHOP_ALLWD_GRP", "Groupes pouvant soumettre");
define("_MI_SSHOP_ALLWD_GRP_DSC", "Choisissez les groupes d'utilisateurs qui pourront proposer des items.");
define("_MI_SSHOP_INCLUDESEARCH", "Inclure recherche");
define("_MI_SSHOP_INCLUDESEARCHDSC", "Inclure le formulaire de recherche au bas de chaque page du module");
define("_MI_SSHOP_DEFCATVIEWGR", "Permissions de visualisation des catégories par défaut");
define("_MI_SSHOP_DEFCATVIEWGRDSC", "");
define("_MI_SSHOP_SUB_MENU", "Soumettre un item");
define("_MI_SSHOP_STANDARD", "Version standard");
define("_MD_SSHOP_AVAILABLE_CREDITS","Vos crédits disponibles");
?>