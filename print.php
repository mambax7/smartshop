<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once 'header.php';
require_once XOOPS_ROOT_PATH.'/class/template.php';

Global $smartshop_item_handler;

$itemid = isset($_GET['pageid']) ? intval($_GET['pageid']) : 0;

If ($itemid == 0) {
	redirect_header("javascript:history.go(-1)", 1, _MD_SSHOP_NOITEMSELECTED);
	exit();
}

// Creating the ITEM object for the selected ITEM
$itemObj = new SmartcontentItem($itemid);

// If the selected ITEM was not found, exit
If ($itemObj->notLoaded()) {
	redirect_header("javascript:history.go(-1)", 1, _MD_SSHOP_NOITEMSELECTED);
	exit();
}

// Creating the category object that holds the selected ITEM
$categoryObj =& $itemObj->category();

// Check user permissions to access that category of the selected ITEM
if (!(smartshop_itemAccessGranted($itemObj->getVar('itemid'), $itemObj->getVar('categoryid')))) {
	redirect_header("javascript:history.go(-1)", 1, _NOPERM);
	exit;
}
$xoopsTpl = new XoopsTpl();
global $xoopsConfig, $xoopsDB, $xoopsModule, $myts;

$item=  $itemObj->toArray(null, $categoryObj, false);
$printtitle = $xoopsConfig['sitename']." - ".smartshop_metagen_html2text($categoryObj->getCategoryPath())." > ".$myts->displayTarea($item['title']);
$printheader = $myts->displayTarea(smartshop_getConfig('headerprint'));
$who_where = sprintf(_MD_SSHOP_WHO_WHEN, $itemObj->posterName(), $itemObj->datesub());
$item['categoryname'] = $myts->displayTarea($categoryObj->name());

$xoopsTpl->assign('printtitle', $printtitle);
$xoopsTpl->assign('printlogourl', smartshop_getConfig('printlogourl'));
$xoopsTpl->assign('printheader', $printheader);
$xoopsTpl->assign('lang_category', _MD_SSHOP_CATEGORY);
$xoopsTpl->assign('lang_author_date', $who_where);
$xoopsTpl->assign('item', $item);
if(smartshop_getConfig('footerprint')== 'item footer' || smartshop_getConfig('footerprint')== 'both'){
	$xoopsTpl->assign('itemfooter', $myts->displayTarea( smartshop_getConfig('itemfooter')));
}
if(smartshop_getConfig('footerprint')== 'index footer' || smartshop_getConfig('footerprint')== 'both'){
	$xoopsTpl->assign('indexfooter', $myts->displayTarea( smartshop_getConfig('indexfooter')));
}

$xoopsTpl->assign('display_whowhen_link', $xoopsModuleConfig['display_whowhen_link']);

$xoopsTpl->display('db:smartshop_print.html');

?>