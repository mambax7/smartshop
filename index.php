<?php
/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once('header.php');
include_once(XOOPS_ROOT_PATH . '/header.php');

$xoopsOption['template_main'] = 'smartshop_index.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

$xoopsTpl->assign('categories', $smartshop_category_handler->getAllCategoriesArray(0, 'category_view'));
$xoopsTpl->assign('module_home', smart_getModuleName(false, true));
$xoopsTpl->assign('index_item', true);
$xoopsTpl->assign('cat_nav', $xoopsModuleConfig['category_nav']);
$xoopsTpl->assign('index', true);
/**
 * Get all orphan items items
 */
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('parentid', 0));
$criteria->add(new Criteria('status', _SSHOP_STATUS_ONLINE));
$aItems = $smartshop_item_handler->getObjects($criteria, true, false);
$xoopsTpl->assign('items', $aItems);

/**
 * Generating meta information for this item
 */
$smartshop_metagen = new SmartMetagen($smartshop_moduleName);
$smartshop_metagen->createMetaTags();

if ($xoopsModuleConfig['include_search']) {
	include_once(SMARTSHOP_ROOT_PATH . "include/searchform.php");
}
include_once(XOOPS_ROOT_PATH . '/footer.php');
?>