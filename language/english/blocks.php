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
//if there is a custom language file, load it, otherwise use this file
$fileName = SMARTSHOP_ROOT_PATH . 'language/custom/english/blocks.php';
if (file_exists($fileName)) {
	include_once($fileName);
}else{
	define("_MB_SSHOP_ALLCAT", "All categories");
	define("_MB_SSHOP_AUTO_LAST_ITEMS", "Automatically display last item(s)?");
	define("_MB_SSHOP_CATEGORY", "Category");
	define("_MB_SSHOP_CHARS", "Length of the title");
	define("_MB_SSHOP_COMMENTS", "Comment(s)");
	define("_MB_SSHOP_DATE", "Published date");
	define("_MB_SSHOP_DISP", "Display");
	define("_MB_SSHOP_DISPLAY_CATEGORY", "Display the category name?");
	define("_MB_SSHOP_DISPLAY_COMMENTS", "Display comment count?");
	define("_MB_SSHOP_DISPLAY_TYPE", "Display type :");
	define("_MB_SSHOP_DISPLAY_TYPE_BLOCK", "Each item is a block");
	define("_MB_SSHOP_DISPLAY_TYPE_BULLET", "Each item is a bullet");
	define("_MB_SSHOP_DISPLAY_WHO_AND_WHEN", "Display the poster and date?");
	define("_MB_SSHOP_FULLITEM", "Read the complete article");
	define("_MB_SSHOP_HITS", "Number of hits");
	define("_MB_SSHOP_ITEMS", "Articles");
	define("_MB_SSHOP_LAST_ITEMS_COUNT", "If yes, how many items to display?");
	define("_MB_SSHOP_LENGTH", " characters");
	define("_MB_SSHOP_ORDER", "Display order");
	define("_MB_SSHOP_POSTEDBY", "Published by");
	define("_MB_SSHOP_READMORE", "Read more...");
	define("_MB_SSHOP_READS", "reads");
	define("_MB_SSHOP_SELECT_ITEMS", "If no, select the articles to be displayed :");
	define("_MB_SSHOP_SELECTCAT", "Display the articles of :");
	define("_MB_SSHOP_VISITITEM", "Visit the");
	define("_MB_SSHOP_WEIGHT", "List by weight");
	define("_MB_SSHOP_WHO_WHEN", "Published by %s on %s");
	//bd tree block hack
	define("_MB_SSHOP_LEVELS", "levels");
	define("_MB_SSHOP_CURRENTCATEGORY", "Current Category");
	define("_MB_SSHOP_ASC", "ASC");
	define("_MB_SSHOP_DESC", "DESC");
	define("_MB_SSHOP_SHOWITEMS", "Show Items");
	//--/bd
	define("_MB_SSHOP_STATUS_1", "Offline");
	define("_MB_SSHOP_STATUS_3", "Online");
	define("_MB_SSHOP_STATUS_0", "Expired");
	define("_MB_SSHOP_STATUS_2", "Submitted");
	define("_MB_SSHOP_STATUS_4", "Sold");
	define("_MB_SSHOP_SEARCH","Search");
	define("_MB_SSHOP_ADVS","Advanced Search");
	define("_MB_SSHOP_CHOOSE","Choose your category");
	define("_MB_SSHOP_SUBMIT_BL_FORMAT","Display mode");
	define("_MB_SSHOP_LIST","List");
	define("_MB_SSHOP_SELECT","Select");
	define("_MB_SSHOP_BASKET_DETAILS","Modify/Order");
	define("_MB_SSHOP_BASKET_EMPTY","Your Cart is Empty");
}
?>