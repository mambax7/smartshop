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

global $xoopsModule, $xoopsModuleConfig;

include_once XOOPS_ROOT_PATH . "/modules/smartshop/include/functions.php";

$uid = ($xoopsUser) ? ($xoopsUser->getVar("uid")) : 0;

$xoopsTpl->assign("smartshop_adminpage", "<a href='" . XOOPS_URL . "/modules/smartshop/admin/index.php'>" ._CO_SOBJECT_ADMIN_PAGE . "</a>");
$xoopsTpl->assign("isAdmin", $smartshop_isAdmin);
$xoopsTpl->assign('smartshop_url', SMARTSHOP_URL);
$xoopsTpl->assign('smartshop_images_url', SMARTSHOP_IMAGES_URL);

$xoopsTpl->assign("xoops_module_header", smart_get_css_link(SMARTSHOP_URL . 'module.css') . ' ' . smart_get_css_link(SMARTOBJECT_URL . 'module.css'));

$xoopsTpl->assign("ref_smartfactory", "SmartShop is developed by The SmartFactory (http://smartfactory.ca), a division of InBox Solutions (http://inboxsolutions.net)");
$xoopsTpl->assign("lang_search", _MD_SSHOP_SEARCH);
$xoopsTpl->assign("lang_finditem", _MD_SSHOP_FIND_ITEM);
$xoopsTpl->assign("lang_advanced_search", _MD_SSHOP_ADVANCED_SEARCH);
$xoopsTpl->assign("smartshop_module_use", $smartshop_module_use);
$xoopsTpl->assign("include_search", $xoopsModuleConfig['include_search']);
$xoopsTpl->assign('nav_mode', $xoopsModuleConfig['nav_mode']);
$xoopsTpl->assign('img_max_width', $xoopsModuleConfig['img_max_width']);
$xoopsTpl->assign('credits_balance', $credits_balance);
$display_array = array();
foreach($xoopsModuleConfig['display_fields'] as $field){
	$display_array[$field] = 1;
}
$xoopsTpl->assign('display', $display_array);
if($smartshop_module_use == 'boutique' || $smartshop_module_use == 'adds'){
	$xoopsTpl->assign('for_sale', true);
}

?>