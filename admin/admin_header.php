<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("SMARTSHOP_NOCPFUNC")) {
	include_once '../../../include/cp_header.php';
}

require_once XOOPS_ROOT_PATH.'/kernel/module.php';
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . '/class/template.php';

include_once XOOPS_ROOT_PATH.'/modules/smartshop/include/common.php';

if( !defined("SMARTSHOP_ADMIN_URL") ){
	define('SMARTSHOP_ADMIN_URL', SMARTSHOP_URL . "admin/");
}

$imagearray = array(
	'editimg' => "<img src='". SMARTSHOP_IMAGES_URL ."/button_edit.png' alt='" . _AM_SSHOP_ICO_EDIT . "' align='middle' />",
    'deleteimg' => "<img src='". SMARTSHOP_IMAGES_URL ."/button_delete.png' alt='" . _AM_SSHOP_ICO_DELETE . "' align='middle' />",
	);
smart_loadCommonLanguageFile();
?>