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

if( !defined("SMARTSHOP_DIRNAME") ){
	define("SMARTSHOP_DIRNAME", 'smartshop');
}

if( !defined("SMARTSHOP_URL") ){
	define("SMARTSHOP_URL", XOOPS_URL.'/modules/'.SMARTSHOP_DIRNAME.'/');
}
if( !defined("SMARTSHOP_ROOT_PATH") ){
	define("SMARTSHOP_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTSHOP_DIRNAME.'/');
}

if( !defined("SMARTSHOP_IMAGES_URL") ){
	define("SMARTSHOP_IMAGES_URL", SMARTSHOP_URL.'/images/');
}

/** Include SmartObject framework **/
include_once XOOPS_ROOT_PATH.'/modules/smartobject/class/smartloader.php';
include_once(SMARTOBJECT_ROOT_PATH . "class/smartobjectcategory.php");

/**
 * Definition of the use of the module.
 * This will of course be put in a preference or in a wizard later...
 *
 * Possible values :
 * 	- adds
 *  - boutique
 *  - directory
 *  - dynamic_directory
 *  - movgames
 */
 include_once('functions.php');
$smartshop_module_use = smartshop_GetMeta('module_usage');

/*
 * Including the common language file of the module
 */
$fileName = SMARTSHOP_ROOT_PATH . 'language/' . $GLOBALS['xoopsConfig']['language'] . '/common.php';
if (!file_exists($fileName)) {
	$fileName = SMARTSHOP_ROOT_PATH . 'language/english/common.php';
}

include_once($fileName);

// Definition of some constants that should be put in module preferences when time permits
define('SMARTSHOP_UINTS_PER_PAGE_ADMIN', 10);

include_once(SMARTSHOP_ROOT_PATH . "include/functions.php");
include_once(SMARTSHOP_ROOT_PATH . "include/seo_functions.php");
include_once(SMARTSHOP_ROOT_PATH . "class/keyhighlighter.class.php");
/*
include_once(SMARTSHOP_ROOT_PATH . "class/smartobject.php");
*/

// Creating the SmartModule object
$smartShopModule =& smartshop_getModuleInfo();

// Find if the user is admin of the module
$smartshop_isAdmin = smartshop_userIsAdmin();

$myts = MyTextSanitizer::getInstance();
if(is_object($smartShopModule)){
	$smartshop_moduleName = $smartShopModule->getVar('name');
}

// Creating the SmartModule config Object
$smartShopConfig =& smartshop_getModuleConfig();


// Defining the different status of items
define('_SSHOP_STATUS_EXPIRED', 0);
define('_SSHOP_STATUS_OFFLINE', 1);
define('_SSHOP_STATUS_SUBMITTED', 2);
define('_SSHOP_STATUS_ONLINE', 3);
define('_SSHOP_STATUS_SOLD', 4);
define('_SSHOP_STATUS_MODIFIED', 5);
$statusArray = array(
	_SSHOP_STATUS_EXPIRED => _CO_SSHOP_STATUS_EXPIRED,
	_SSHOP_STATUS_OFFLINE => _CO_SSHOP_STATUS_OFFLINE,
	_SSHOP_STATUS_SUBMITTED =>_CO_SSHOP_STATUS_SUBMITTED,
	_SSHOP_STATUS_ONLINE => _CO_SSHOP_STATUS_ONLINE,
	_SSHOP_STATUS_SOLD => _CO_SSHOP_STATUS_SOLD,
	_SSHOP_STATUS_MODIFIED => _CO_SSHOP_STATUS_MODIFIED
	);


$typeArray = array(
	'check'  => _CO_SSHOP_TYPE_CHECK,
	'html' => _CO_SSHOP_TYPE_HTML,
	'radio' => _CO_SSHOP_TYPE_RADIO,
	'select' => _CO_SSHOP_TYPE_SELECT,
	'select_multi' => _CO_SSHOP_TYPE_SELECT_MULTI,
	'tarea' => _CO_SSHOP_TYPE_TAREA,
	'text' => _CO_SSHOP_TYPE_TEXT,
	'file' => _CO_SSHOP_TYPE_UPLOAD,
	'urllink' => _CO_SSHOP_TYPE_URLLINK,
	'image' => _CO_SSHOP_TYPE_UPLOADIMG,
	'yn' => _CO_SSHOP_TYPE_YN,
	'form_section' => _CO_SSHOP_FORM_SECTION
	);
/*
// Defining the different status of transaction
define('_SSHOP_TRAN_STATUS_EXPIRED', 0);
define('_SSHOP_STATUS_OFFLINE', 1);
define('_SSHOP_STATUS_SUBMITTED', 2);
define('_SSHOP_STATUS_ONLINE', 3);
define('_SSHOP_STATUS_SOLD', 4);
define('_SSHOP_STATUS_MODIFIED', 5);
$statusArray = array(
	_SSHOP_STATUS_EXPIRED => _CO_SSHOP_STATUS_EXPIRED,
	_SSHOP_STATUS_OFFLINE => _CO_SSHOP_STATUS_OFFLINE,
	_SSHOP_STATUS_SUBMITTED =>_CO_SSHOP_STATUS_SUBMITTED,
	_SSHOP_STATUS_ONLINE => _CO_SSHOP_STATUS_ONLINE,
	_SSHOP_STATUS_SOLD => _CO_SSHOP_STATUS_SOLD,
	_SSHOP_STATUS_MODIFIED => _CO_SSHOP_STATUS_MODIFIED
	);
*/
// include SmartObject Currency Management feature
include_once(SMARTOBJECT_ROOT_PATH . "include/currency.php");

include_once(SMARTSHOP_ROOT_PATH . "class/category.php");
include_once(SMARTSHOP_ROOT_PATH . "class/item.php");
include_once(SMARTSHOP_ROOT_PATH . "class/item_attribut.php");
include_once(SMARTSHOP_ROOT_PATH . "class/category_attribut.php");
include_once(SMARTSHOP_ROOT_PATH . "class/attribut_option.php");
include_once(SMARTSHOP_ROOT_PATH . "class/basket.php");
include_once(SMARTSHOP_ROOT_PATH . "class/basket_item.php");
include_once(SMARTSHOP_ROOT_PATH . "class/transaction.php");

// Creating the category handler object
$smartshop_category_handler =& xoops_getmodulehandler('category', SMARTSHOP_DIRNAME);

// Creating the item handler object
$smartshop_item_handler =& xoops_getmodulehandler('item', SMARTSHOP_DIRNAME);

// Creating the item_attribut handler object
$smartshop_item_attribut_handler =& xoops_getmodulehandler('item_attribut', SMARTSHOP_DIRNAME);

// Creating the category_attribut handler object
$smartshop_category_attribut_handler =& xoops_getmodulehandler('category_attribut', SMARTSHOP_DIRNAME);

// Creating the attribut_option handler object
$smartshop_attribut_option_handler =& xoops_getmodulehandler('attribut_option', SMARTSHOP_DIRNAME);

// Creating the basket handler object
$smartshop_basket_handler =& xoops_getmodulehandler('basket', SMARTSHOP_DIRNAME);

// Creating the basket_item handler object
$smartshop_basket_item_handler =& xoops_getmodulehandler('basket_item', SMARTSHOP_DIRNAME);

// Creating the transaction handler object
$smartshop_transaction_handler =& xoops_getmodulehandler('transaction', SMARTSHOP_DIRNAME);

// check of this is the first use of the module
if (is_object($xoopsModule) && $xoopsModule->dirname() == 'smartshop') {
	// We are in the module
	if (defined('XOOPS_CPFUNC_LOADED') && !defined('SMARTSHOP_FIRST_USE_PAGE')) {
		// We are in the admin side of the module
		if (!smart_getMeta('module_usage')) {
			redirect_header(SMARTSHOP_URL . 'admin/first_use.php', 4, _AM_SSHOP_MODULE_FIRST_USE);
			exit;
		}
	}
}
?>