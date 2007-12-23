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

define("_MD_SSHOP_PAGE_NOT_FOUND", "la page n'a pas été trouvée.");
define("_MD_SSHOP_SUBCATEGORIES", "Sous-catégories");

define("_MD_SSHOP_SUBMIT_CATEGORY_NOT_FOUND", "Les items doivent être créés &agrave; l'intérieur d'une catégorie. Choisissez une catégorie pour ensuite créer l'item.");


define("_AM_SSHOP_SOLD_CONFIRM", "Êtes vous sûr que vous voulez marquer cet item comme étant vendu?");
define("_AM_SSHOP_SOLD_SUCCESS", "l'item a été marqué comme vendu.");
define("_AM_SSHOP_SOLD_ERROR", "Une erreur est survenue au changement de statut.");
define("_AM_SSHOP_YES", "Oui");
define("_MD_SSHOP_YES", "Oui");
define("_MD_SSHOP_NO", "Non");
define("_MD_SSHOP_ANY", "Peu importe");
define("_MD_SSHOP_ITEM_SUBMIT", "Inscrire une annonce dans la cat&eacute;gorie %s");
define("_MD_SSHOP_ITEM_EDIT", "Modifier %s");

/**
* Hack by Félix(InBox Solutions) for movGames
* Limit of items per user
*/
define("_MD_SSHOP_SUBMIT_NO_CREDIT", "Vous devez acheter un forfait pour vendre sur ce site.");

/**
* End of Hack by Félix(InBox Solutions) for movGames
* Limit of items per user
*/
define("_MD_SSHOP_SEARCH", "Recherche");
define("_MD_SSHOP_SEARCH_INFO", "Remplissez correctement le formulaire afin de rechercher de rechercher un item particulier");
define("_MD_SSHOP_SEARCH_ALL", "Tous");
define("_MD_SSHOP_TITLE_SEARCH_DSC", "Mot(s) clé(s) à rechercher dans le titre de l'item");
define("_MD_SSHOP_CATEGORY", "Catégorie");
define("_MD_SSHOP_CATEGORY_DSC", "Catégorie &agrave; laquelle appartient l'item recherché");
define("_MD_SSHOP_TITLE", "Nom");
define("_MD_SSHOP_SEARCH_RESULTS_TITLE", "Résultats");
define("_MD_SSHOP_SEARCH_RESULTS_TEXT", "Voici les résultats de votre recherche:");
define("_MD_SSHOP_SEARCH_NORESULTS", "Aucun enregistrement ne correspond au critères de votre recherche.");

define("_MD_SSHOP_FIND_ITEM", "Rechercher un item spécifique:");
define("_MD_SSHOP_ADVANCED_SEARCH", "Recherche avancée");
define("_MD_SSHOP_DESCRIPTION", 'Description');
define("_MD_SSHOP_DESC_SEARCH_DSC", "Mot(s) clé(s) à rechercher dans la description de l'item");
define("_MD_SSHOP_SEARCH_ANDOR", 'Recherche restreinte');
define("_MD_SSHOP_SEARCH_ANDOR_DSC", 'Si vous choisissez "Oui", tous les critères mentionnés ci-haut devront être rencontrés');
define("_MD_SSHOP_WILL_BE_APPROVED", "L'item devra être approuvé par un administrateur avant d'être mis en ligne.");
define("_MD_SSHOP_CHOOSE_CAT","Chosissez une catégorie");
define("_MD_SSHOP_MUST_BE_REG","Vous devez être un membre inscrit du site pour annoncer.<br>Inscrivez-vous, ou connectez-vous si vous êtes déjà membre.");
define("_MD_SSHOP_NOT_ALLOWED2SUBMIT", "Vous n'avez pas la permission de proposer un item.");
define("_MD_SSHOP_BUY","Acheter cet item maintenant !");
define("_MD_SSHOP_PRICE","Prix");
define("_MD_SSHOP_DESIRED_QUANTITY","Veuillez entrer la quantité désirée et cliquez sur le bouton Soumettre.");

define("_MD_SSHOP_YOUR_REALLY_WANT_TO_BUY","Désirez vous vraiment acheter cet item?");
define("_MD_SSHOP_TRANSACTION_ERROR","Une erreur est survenue lors de l'enregistrement de cette transaction. Veuillez communiquer avec l'administrateur du site.");
define("_MD_SSHOP_TRANSACTION_SUCCESS","La transaction a été enregistré avec succès. Merci !");

define("_MD_SSHOP_AVAILABLE_CREDITS","Vos crédits disponibles");

define("_MD_SSHOP_NOT_ENOUGH_CREDIT","Désolé ! Vous n'avez malheureusement pas assez de crédits pour acheter cet article.");
define("_MD_SSHOP_NOT_ENOUGH_CREDIT_FOR_QUANTITY"," Vous n'avez malheureusement pas assez de crédits pour acheter cet quantité.");
?>