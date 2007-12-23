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
define("_MI_SSHOP_CATEGORIES", "Categories");
define("_MI_SSHOP_ITEMS", "Items");
define("_MI_SSHOP_TRANSACTION", "Transactions");
define("_MI_SSHOP_CHECKOUT_CONFIG", "Check Out Page");

define("_MI_SSHOP_ITEMSPERPAGE", "Pages per category");
define("_MI_SSHOP_ITEMSPERPAGE_DSC", "Select the number of pages you would like to be displayed for each category.");

define("_MI_SSHOP_MODMETADESC", "Module meta-description");
define("_MI_SSHOP_MODMETADESC_DSC", "This will be used as a meta-description on the index page of the module.");
define("_MI_SSHOP_INVENTORY", "Inventory");
define("_MI_SSHOP_GLOBAL_CSTMFLDS", "Global custom fields");

define("_MI_SSHOP_SUBMIT_BY_CAT", "Submit an item");
define("_MI_SSHOP_WAIT_APPROVAL", "Submitted items");
define("_MI_SSHOP_CURR_USER_SUB", "Your submissions");
define("_MI_SSHOP_RENEW", "Renew expired");

define("_MI_SSHOP_NEW_SEARCH", "Search");
define("_MI_SSHOP_NEW_ADDS", "Recent items");
define("_MI_SSHOP_NEW_SELLERS", "New sellers");

define("_MI_SSHOP_GLOBAL_ITEM_NOTIFY", "Global");
define("_MI_SSHOP_GLOBAL_ITEM_NOTIFY_DSC", "");

define("_MI_SSHOP_ITEM_NOTIFY", "Item");
define("_MI_SSHOP_ITEM_NOTIFY_DSC", "");

define("_MI_SSHOP_ITEM_APPROVED_NOTIFY", "Approved item");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_CAP", "Notify me when this add will be approved");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_DSC", "");
define("_MI_SSHOP_ITEM_APPROVED_NOTIFY_SBJ", "Your add have been approved");

define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY", "Submitted item");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_CAP", "Notify me when a user submit a new add");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_DSC", "");
define("_MI_SSHOP_ITEM_SUBMITTED_NOTIFY_SBJ", "Add submitted");

define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY", "published item");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP", "Notify me when a new add is published");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC", "");
define("_MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ", "New add published");

define("_MI_SSHOP_CATEGORY_NAV", "Enable category navigation");
define("_MI_SSHOP_CATEGORY_NAV_DSC", "If you select 'Yes', the list of all categories will be displayed in index page of the module.'");
define("_MI_SSHOP_NAV_MODE", "Navigation mode'");
define("_MI_SSHOP_NAV_MODE_DSC", "If you select 'Bread crumb', the current path will be displayed on each page.<br/>
		The 'Back' mode will display a 'back to previous page' button on each page.");
define("_MI_SSHOP_NAV_MODE_BREAD", "Bread crumb");
define("_MI_SSHOP_NAV_MODE_BACK", "Back");
define("_MI_SSHOP_NAV_MODE_NONE", "None");
define("_MI_SSHOP_CURRENCIES", "currencies");
define("_MI_SSHOP_CURRENCIES_DSC", "Available currencies for items.");
define("_MI_SSHOP_CURRENCY_CANDOL", "CDA");
define("_MI_SSHOP_CURRENCY_USDOL", "USD");
define("_MI_SSHOP_CURRENCY_EURO", "Euro");
define("_MI_SSHOP_DEFEDITOR", "Default editor");
define("_MI_SSHOP_DEFEDITOR_DSC", "");

define("_MI_SSHOP_MAX_SIZE", "Maximum size for item images to upload");
define("_MI_SSHOP_MAX_SIZE_DSC", "");
define('_MI_SSHOP_IMG_MAX_WIDTH', "Maximum width of the images:");
define('_MI_SSHOP_IMG_MAX_WIDTH_DSC', "This will be the maximum width of an image that is uploaded to the module.");
define("_MI_SSHOP_IMG_MAX_HEIGHT", "Maximum height of the images:");
define("_MI_SSHOP_IMG_MAX_HEIGHT_DSC", "This will be the maximum height of an image that is uploaded to the module.");
define("_MI_SSHOP_DEF_DELAY_EXP", "Default expiration delay");
define("_MI_SSHOP_DEF_DELAY_EXP_DSC", "Number of days between publication and expiration of an item. <b>Must be an integer number.</b> Mark '0' to make items unexpirable.");
define("_MI_SSHOP_DISPLAY_POSTER", "Display Poster");
define("_MI_SSHOP_DISPLAY_POSTER_DSC", "");
define("_MI_SSHOP_DISPLAY_DATE_PUB", "Display items publication date");
define("_MI_SSHOP_DISPLAY_DATE_PUB_DSC", "");
define("_MI_SSHOP_EXP_MANAGEBY_CRON", "Expiration management using cron job?");
define("_MI_SSHOP_EXPMANAGEBYCRONDSC", "Recommanded. You must execute 'smartshop/_cron_expire.php' via a server cron job.<br> Otherwise, the check up for expiration is made every a user enter site.");
define("_MI_SSHOP_DEF_AVATAR", "Default user picture");
define("_MI_SSHOP_DEF_AVATAR_DSC", "Image that will be shown in user information, in the case that he has no d'avatar. Must be in folder smartshop/images. Leave blank to don't show default picture.");
define("_MI_SSHOP_DEF_ITEM_PIC", "Default item picture");
define("_MI_SSHOP_DEF_ITEM_PIC_DSC", "Image that will be shown in item information, in the case that it has no picture. Must be in folder smartshop/images. Leave blank to don't show default picture.");
define("_MI_SSHOPSUBMIT_INTRO", "Introduction of item sumission page");
define("_MI_SSHOP_SORT", "Sort items by:");
define("_MI_SSHOP_SORT_DSC", "");
define("_MI_SSHOP_SORT_WEIGHT", "Weight");
define("_MI_SSHOP_SORT_DATE", "Date");
define("_MI_SSHOP_DISP_FIELDS", "Fields to display");
define("_MI_SSHOP_DISP_FIELDS_DSC", "Visible fields (doesn't applies on custom fields)");
define("_MI_SSHOP_DISP_FIELDS_LINK", "External link");
define("_MI_SSHOP_DISP_FIELDS_DESC", "Description");
define("_MI_SSHOP_DISP_FIELDS_IMG", "Image");
define("_MI_SSHOP_DISP_FIELDS_PRICE", "Price");
define("_MI_SSHOP_DISP_FIELDS_COUNT", "Hits");
define("_MI_SSHOP_DISP_FIELDS_DATE", "Date");
define("_MI_SSHOP_NOTIF_EXP", "Expiration notification");
define("_MI_SSHOP_NOTIF_EXP_DSC", "Select how many days before expiration you wish to notify the author");
define("_MI_SSHOP_AUTO_APP", "Submitted items are always approved");
define("_MI_SSHOP_AUTO_APP_DSC", "If you select 'No', a moderator should approve submitted or modified items.");
define("_MI_SSHOP_NONE", "No notification");
define("_MI_SSHOP_ONLY_EXP", "Only at expiration");
define("_MI_SSHOP_ALLWD_GRP", "Groups that can submit");
define("_MI_SSHOP_ALLWD_GRP_DSC", "Choose witch groups may submit items.");
define("_MI_SSHOP_INCLUDESEARCH", "Include search");
define("_MI_SSHOP_INCLUDESEARCHDSC", "Include search at the bottom of all pages in the module");
define("_MI_SSHOP_DEFCATVIEWGR", "Category view default permissions");
define("_MI_SSHOP_DEFCATVIEWGRDSC", "Groups that will the category view permission by default");
define("_MI_SSHOP_SUB_MENU", "Submit an item");
define("_MI_SSHOP_BCRUMB", "Show module name in bread crumb");
define("_MI_SSHOP_BCRUMBDSC", "");
define("_MI_SSHOP_INPUTTYPE_SEARCH", "Input type of category in search form");
define("_MI_SSHOP_INPUTTYPE_SEARCHDSC", "");
define("_MI_SSHOP_INPUTTYPE_RADIO", "Radio button");
define("_MI_SSHOP_INPUTTYPE_SELECT", "Select box");
define("_MI_SSHOP_CAT_TPL", "View type in category page");
define("_MI_SSHOP_CAT_TPL_DSC", "");
define("_MI_SSHOP_TPL_LIST", "List view");
define("_MI_SSHOP_TPL_TABLE", "Table view");
define("_MI_SSHOP_BASKET", "Shopping cart");
define("_MI_SSHOP_STANDARD", "Standard Version");
define("_MI_SSHOP_CUSTOM_VERSION" , "Module version");
define("_MI_SSHOP_CUSTOM_VERSIONDSC", "Select your site name or leave it to 'standard'");

define("_MI_SSHOP_ORDER_MAIL", "Send order emails to groups:");
define("_MI_SSHOP_ORDER_MAIL_DSC", "Select groups that will receive emails when a user order on the site.");
define("_MI_SSHOP_EXTRA_EMAILS", "Send order emails to addresses");
define("_MI_SSHOP_EXTRA_EMAILS_DSC", "Enter email addresses separated by ';'");
define("MI_SSHOP_SIGNATURE", "Signature");
define("_MI_SSHOP_SIGNATURE_DSC", "Signatue for the order confirmation email that will receive users.");

?>