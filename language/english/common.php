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
define("_CO_SOBJECT_SOLD", "Mark as sold");
define("_CO_SSHOP_STATUS_OFFLINE", "Offline");
define("_CO_SSHOP_STATUS_ONLINE", "Online");
define("_CO_SSHOP_STATUS_EXPIRED", "Expired");
define("_CO_SSHOP_STATUS_SUBMITTED", "Submitted");
define("_CO_SSHOP_STATUS_SOLD", "Sold");
define("_CO_SSHOP_ITEM_NAME", "Name");
define("_CO_SSHOP_ITEM_DATESUB", "Creation date");
define("_CO_SSHOP_ITEM_DATESUB_DSC", "Date of creation of this item.");
define("_CO_SSHOP_ITEM_DATE_EXP", "Expire date");
define("_CO_SSHOP_ITEM_DATE_EXP_DSC", "Expire date of this item.");
define("_CO_SSHOP_ITEM_STATUS", "Status");
define("_CO_SSHOP_ITEM_CATEGORY", "Category");
define("_CO_SSHOP_ITEM_ID", "Item #");
define("_CO_SSHOP_ITEM_CATEGORY_DSC", "Category to which belongs this item.");
define("_CO_SSHOP_ITEM_TITLE_DSC", "Title of this item");
define("_CO_SSHOP_ITEM_SUMMARY", "Summary");
define("_CO_SSHOP_ITEM_SUMMARY_DSC", "Summary of this item.");
define("_CO_SSHOP_ITEM", "Item");
define("_CO_SSHOP_ITEM_DESC", "Description");
define("_CO_SSHOP_ITEM_DESC_DSC", "Description of this particular item.<br/>The description must be at most 120 characters. Otherwise, extra text will be truncated.");

define("_CO_SSHOP_ITEM_PRICE", "Price");
define("_CO_SSHOP_ITEM_PRICE_DSC", "");

define("_CO_SSHOP_ITEM_CURRENCY", "Currency");
define("_CO_SSHOP_ITEM_CURRENCY_DSC", "");

define("_CO_SSHOP_ITEM_DATE", "Posted date");
define("_CO_SSHOP_ITEM_DATE_DSC", "");

define("_CO_SSHOP_CAT_HASITEM", "Can hold items");
define("_CO_SSHOP_CAT_HASITEM_DSC", "Select 'Yes', if items can be posted in this category. Select 'No' if this category is only a container for other categories.");

define("_CO_SSHOP_CAT_ISFORSALE", "Items within category are for sale");
define("_CO_SSHOP_CAT_ISFORSALE_DSC", "If you select 'Yes', information about price will be displayed.");

define("_CO_SSHOP_CURRENCY_CANDOL", "CDA");
define("_CO_SSHOP_CURRENCY_USDOL", "USD");
define("_CO_SSHOP_CURRENCY_EURO", "Euro");
define("_CO_SSHOP_CAT_OPTIONS", "Options");
define("_CO_SSHOP_CAT_OPTIONS_DSC", "If the type you selected needs options, here is where you would enter them, separated with a line break.<br/>To set a default value, prefix it with '***'. <br/>Ex: to set option 2 as default, enter:<br/>option1<br/>***option2<br/>option3<br/>");
define("_CO_SSHOP_CAT_OPTIONS_DEPENDCY_DSC", "Enter the options of this field and please select, for each options, to what optio of the dependency field they are linked.");

define("_CO_SSHOP_CAT_ATTRIBUT_CAT", "Category");
define("_CO_SSHOP_CAT_ATTRIBUT_CAT_DSC", "");

define("_CO_SSHOP_CAT_ATT_NAME", "Name");
define("_CO_SSHOP_CAT_ATT_NAME_DSC", "");

define("_CO_SSHOP_CAT_ATT_TYPE", "Type");
define("_CO_SSHOP_CAT_ATT_TYPE_DSC", "");

define("_CO_SSHOP_CAT_ATT_REQ", "Required ?");
define("_CO_SSHOP_CAT_ATT_REQ_DSC", "");
define("_CO_SSHOP_NO_USER", "Seller is no more a member of the communauty. Sorry for inconvenience");
define("_CO_SSHOP_CAT_ATT_DEFAULT", "Default");
define("_CO_SSHOP_CAT_ATT_DEFAULT_DSC", "");

define("_CO_SSHOP_CAT_ATT_SORTABLE", "Sortable ?");
define("_CO_SSHOP_CAT_ATT_SORTABLE_DSC", "");

define("_CO_SSHOP_CAT_ATT_SEARCHABLE", "Searchable ?");
define("_CO_SSHOP_CAT_ATT_SEARCHABLE_DSC", "");

define("_CO_SSHOP_CAT_ATT_DISPLAY", "Display on user side ?");
define("_CO_SSHOP_CAT_ATT_DISPLAY_DSC", "");

define("_CO_SSHOP_ITEM_UID", "Poster");
define("_CO_SSHOP_ITEM_UID_DSC", "Poster of this item.");
define("_CO_SSHOP_ITEM_STATUS_DSC", "Status of this item. Only the 'Online' items will be displayed on the user side.");

define("_CO_SSHOP_CAT_ATT_DESCRIPTION", "Description");
define("_CO_SSHOP_CAT_ATT_DESCRIPTION_DSC", "You can add a description to the field to give more information to user about the meaning of this field.");

define("_CO_SSHOP_TYPE_CHECK", "Checkbox");
define("_CO_SSHOP_TYPE_HTML", "HTML Area");
define("_CO_SSHOP_TYPE_RADIO", "Radio box");
define("_CO_SSHOP_TYPE_SELECT", "Select box");
define("_CO_SSHOP_TYPE_SELECT_MULTI", "Select list");
define("_CO_SSHOP_TYPE_TEXT", "Text box");
define("_CO_SSHOP_TYPE_UPLOAD", "File upload");
define("_CO_SSHOP_TYPE_URLLINK", "Link");
define("_CO_SSHOP_TYPE_UPLOADIMG", "Image upload");
define("_CO_SSHOP_TYPE_YN", "Yes / No");
define("_CO_SSHOP_TYPE_TAREA", "Text area");
define("_CO_SSHOP_FORM_SECTION", "Form section");

define("_CO_SSHOP_ITEM_NAME_DSC", "Name of this item");
define("_CO_SSHOP_POSTER", "Poster");

define("_CO_SSHOP_HITS", "Viewed");

define("_CO_SSHOP_ITEM_SUBMIT", "Submit an item");
define("_CO_SSHOP_PM", "Private message");
define("_CO_SSHOP_EMAIL", "Email");
define("_CO_SSHOP_ALL", "All");
define("_CO_SSHOP_ITEM_IMAGE", "Logo");
define("_CO_SSHOP_ITEM_IMAGE_DSC", "Images must be smaller than %s X %s <br>and smaller than %s bytes. Accepted files: GIF, JPG, PNG");
define("_CO_SSHOP_ITEM_LINK_NAME", "Name of the link");
define("_CO_SSHOP_ITEM_LINK_NAME_DSC", "Clickable text");
define("_CO_SSHOP_ITEM_LINK_URL", "Adress of the link");
define("_CO_SSHOP_ITEM_LINK_URL_DSC", "Targeted URL");
define("_CO_SSHOP_CAT_PUB", "Pub");
define("_CO_SSHOP_CAT_PUB_DSC", "");
define("_CO_SSHOP_ITEM_BILL_ADDR", "Biling address");
define("_CO_SSHOP_ITEM_BILL_ADDR_DSC", "");
define("_CO_SSHOP_ITEM_TEL", "Phone");
define("_CO_SSHOP_ITEM_TEL_DSC", "");
define("_CO_SSHOP_ITEM_NO_EXP", "No expiration");
define("_CO_SSHOP_ITEM_NO_EXP_DSC", "If you check 'Yes', expire date setted below will be ignore and item wont expire");

define("_CO_SSHOP_CAT_DEPENDENT_ATT_ID", "Dependent field");
define("_CO_SSHOP_CAT_DEPENDENT_ATT_ID_DSC", "If the options presented for this custom field are dependent of another existing custom field, please select this field here.");
define("_CO_SSHOP_NO_DEPENDENCY", "No dependency");

define("_CO_SSHOP_ADD", "Add ");
define("_CO_SSHOP_MORE_OPTIONS", " more options");

define("_CO_SSHOP_TRANS_TRANSACTIONID", "Transaction ID");
define("_CO_SSHOP_TRANS_DATE", "Date");
define("_CO_SSHOP_TRANS_DATE_DSC", "");
define("_CO_SSHOP_TRANS_STATUS", "Status");
define("_CO_SSHOP_TRANS_STATUS_DSC", "");
define("_CO_SSHOP_TRANS_ITEMID", "Item");
define("_CO_SSHOP_TRANS_ITEMID_DSC", "");
define("_CO_SSHOP_TRANS_UID", "User");
define("_CO_SSHOP_TRANS_UID_DSC", "");
define("_CO_SSHOP_TRANS_PRICE", "Price");
define("_CO_SSHOP_TRANS_PRICE_DSC", "");
define("_CO_SSHOP_TRANS_CURRENCY", "Currency");
define("_CO_SSHOP_TRANS_CURRENCY_DSC", "");
define("_CO_SSHOP_TRANS_QUANTITY", "Quantity");
define("_CO_SSHOP_TRANS_QUANTITY_DSC", "");
define("_CO_SSHOP_CAT_ATT_CAPTION", "Caption");
define("_CO_SSHOP_CAT_ATT_CAPTION_DSC", "Caption of this field in the item form.");

define("_CO_SSHOP_CAT_ATTRIBUT_EDIT", "Custom field information");
define("_CO_SSHOP_CAT_ATTRIBUT_EDIT_INFO", "Fill out this form in order to edit this custom field information.");

define("_CO_SSHOP_TRANS_UNAME", "Username");
define("_CO_SSHOP_TRANS_VENDOR_ADP", "Vendor ADP");
define("_CO_SSHOP_CAT_ATT_SUMMARYDISPLAY", "Display on category summary");
define("_CO_SSHOP_CAT_ATT_SUMMARYDISPLAY_DSC", "If you click 'Yes', this attribute will be visible in the item listing of the category. 'Display in user side' must be set to 'Yes' as well to work.");
define("_CO_SSHOP_CAT_ATT_SEARCHDISPLAY", "Display on search results page");
define("_CO_SSHOP_CAT_ATT_SEARCHDISPLAY_DSC", "If you click 'Yes', this attribute will be visible in the item search results page. 'Display in user side' must be set to 'Yes' as well to work.");
define("_CO_SSHOP_CAT_ATT_CHECKOUTDISPLAY", "Display on checkout page");
define("_CO_SSHOP_CAT_ATT_CHECKOUTDISPLAY_DSC", "If you click 'Yes', this attribute will be visible in the checkout page. 'Display in user side' must be set to 'Yes' as well to work.");

define("_CO_SSHOP_CUSTOM_RENDERING", "Custom Rendering");
define("_CO_SSHOP_CUSTOM_RENDERING_DSC", "Not implemented on option fields.<br/>" .
		"Use {URL}, {CAPTION} and {DESCRIPTION} for files and links.<br/>Also, use {TARGET} for links. <br/>For other field types use {VALUE}<br/>Those tags will be replaced by the actual values of the fields.");
define("_CO_SSHOP_CAT_SEARCHABLE", "Display on search form");
define("_CO_SSHOP_CAT_SEARCHABLE_DSC", "If you select 'Yes', users can select this category in the search form. Otherwise, items will be searchable by selecting a parent category in the searchform");
define("_CO_SSHOP_RESET_VALUES", "You are about to change the type of the custom field wich is incompatible with the previous one. All values of this field will be reset for the existing items. Continue?");
define("_CO_SSHOP_SET_DEFAULT", "You are about to change the type of the custom field wich is incompatible with the previous one. All values of this field will be set to default for the existing items. Continue?");
define("_CO_SSHOP_DEFAULT_ERROR", "You must set a default value to a required field.");
define("_CO_SSHOP_CAT_ATT_SIZE", "Size");
define("_CO_SSHOP_CAT_ATT_SIZE_DSC", "");
define("_CO_SSHOP_CAT_TPL_DEF", "Default");
define("_CO_SSHOP_CAT_TPL_LIST", "List view");
define("_CO_SSHOP_CAT_TPL_TABLE", "Table view");
define("_CO_SSHOP_CAT_TEMPLATE", "Template");
define("_CO_SSHOP_CAT_TEMPLATE_DSC", "This allows you to display this particular category differntly than global setting from module preferences");
define("_CO_SSHOP_CAT_ATT_UNIQUE", "Unique");
define("_CO_SSHOP_CAT_ATT_UNIQUE_DSC", "");
define("_CO_SSHOP_ERROR_UNIQUE_MSG", " value already used. Must be unique.");
?>