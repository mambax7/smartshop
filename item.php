<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("header.php");

global $smartshop_category_handler, $smartshop_item_handler, $xoopsUser, $smart_previous_page;;

$itemid = isset($_REQUEST['itemid']) ? intval($_REQUEST['itemid']) : 0;

// Creating the item object for the selected itemid
$itemObj = $smartshop_item_handler->get($itemid);

if((isset($xoopsUser) && $xoopsUser != '') && $xoopsUser->getVar('uid') == $itemObj->getVar('uid', 'n')){
	$can_edit = 1;
}
// if the selected item is new, it means that this itemid was not found, OR if the item is not active, exit
if ($itemObj->isNew() || ($itemObj->getVar('status','n') != _SSHOP_STATUS_ONLINE && !$can_edit)) {
    redirect_header(SMARTSHOP_URL, 1, _MD_SSHOP_PAGE_NOT_FOUND);
    exit();
}
/**
 * get the item category
 */
$categoryid = $itemObj->getVar('parentid');
$categoryObj = $smartshop_category_handler->get($categoryid);

if (!$categoryObj->accessGranted('category_view')) {
    redirect_header(SMARTSHOP_URL, 1, _NOPERM);
    exit();
}
/*
 * basket feature
 */
 if($smartshop_module_use == 'boutique' && isset($_REQUEST['quantity'])){
	$basket = $smartshop_basket_handler->get();
	$basket->add($itemid, $_REQUEST['quantity']);
	if(isset($_REQUEST['back'])){
		redirect_header($smart_previous_page, 3, sprintf(_MD_SSHOP_ADDED_TO_BASKET,$_REQUEST['quantity'], $itemObj->getVar('name')));
	}else{
		redirect_header('category.php?categoryid='.$categoryid, 3, sprintf(_MD_SSHOP_ADDED_TO_BASKET,$_REQUEST['quantity'], $itemObj->getVar('name')));
	}
}

if(isset($_GET['print'])){
	require_once XOOPS_ROOT_PATH.'/class/template.php';
	$xoopsTpl = new XoopsTpl();
	$xoopsTpl->assign('footer_print', $xoopsModuleConfig['footer_print']);
	$xoopsTpl->assign('header_print', $xoopsModuleConfig['header_print']);

}else{
	$xoopsOption['template_main'] = 'smartshop_item.html';
	include_once(XOOPS_ROOT_PATH . "/header.php");
}

$xoopsTpl->assign('cat_nav', $xoopsModuleConfig['category_nav']);
$xoopsTpl->assign('nav_mode', $xoopsModuleConfig['nav_mode']);

include_once(SMARTSHOP_ROOT_PATH . "footer.php");

/**
 * Update item counter
 */
$smartshop_item_handler->updateCounter($itemObj);

$itemObj->initiateCustomFields();
$itemArray = $itemObj->toArray();

$customFieldsObj =& $itemObj->getCustomFields();
$aCustomFields = array();
foreach ($customFieldsObj as $customFieldObj) {
	if($customFieldObj->getVar('display')){
		$aCustomFields[] = $customFieldObj->toArray();
	}
}

$itemArray['customFields'] = $aCustomFields;

if($xoopsModuleConfig['display_poster']){
	$xoopsTpl->assign('display_poster', 1);
	$poster = array();
	$poster['uid'] = $itemObj->getVar('uid');
	$poster['userlink'] = smart_getLinkedUnameFromId($poster['uid']);
	$posterInfo = $itemObj->getPosterInfo();
	$poster['email'] = $posterInfo['email'];
	$poster['pmlink'] = str_replace("img src", "img  style=\"vertical-align: middle;\" src",$posterInfo['pmlink']);
	$poster['avatar'] = $posterInfo['avatar'];
	if(!$posterInfo['avatar']){
		$img = $xoopsModuleConfig['def_avatar'] == '' ? 'blank.png' : $xoopsModuleConfig['def_avatar'];
		$poster['avatar'] = XOOPS_URL."/modules/smartshop/images/".$img;
	}
	$itemArray['poster'] = $poster;
}
$xoopsTpl->assign('item', $itemArray);


if (!$categoryObj->isNew()) {
	$categoryPath = $categoryObj->getCategoryPath(true, false) . " > ";
} else {
	$categoryPath = '';
}



if($can_edit && ($smartshop_module_use == 'dynamic_directory' ||$smartshop_module_use == 'adds')){
	$xoopsTpl->assign('can_edit',$can_edit);
	$xoopsTpl->assign('autoEditLinks',$itemObj->getAutoEditLinks());
	$xoopsTpl->assign('status',$itemObj->getVar('status','s'));
}
if($xoopsModuleConfig['footer_display'] == 'item' || $xoopsModuleConfig['footer_display'] == 'both'){
	$xoopsTpl->assign('footer', $xoopsModuleConfig['footer'] );
}
$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
$xoopsTpl->assign('categoryPath', $categoryPath . $itemObj->getVar('name'));

/*
 * basket feature
 */

if($smartshop_module_use == 'boutique'){
	$basket = $smartshop_basket_handler->get();
	if(!$basket->isNew()){
		$basketItemArray =$basket->getItems(1);
	}
	$in_basket = (isset($basketItemArray[$itemid]) && intval($basketItemArray[$itemid]['quantity']) > 0);
	if($in_basket){
		if($xoopsModuleConfig['max_qty_basket'] > 1  && $xoopsModuleConfig['max_qty_basket']){
			$xoopsTpl->assign('message', sprintf(_MD_SSHOP_ALREADY_IN_BASKET, $basketItemArray[$itemid]['quantity']));
		}else{
			$xoopsTpl->assign('message', _MD_SSHOP_ALREADY_IN_BASKET1);
		}
	}else{
		if($xoopsModuleConfig['max_qty_basket'] > 1){
			for($i=1;$i<=intval($xoopsModuleConfig['max_qty_basket']);$i++){
				$qty_opt .= "<option value='".$i."'>".$i."</option>";
			}
			$xoopsTpl->assign('qty_opt', $qty_opt);
		}

	}

	$xoopsTpl->assign('in_basket', $in_basket);
	$xoopsTpl->assign('max_qty_basket', $xoopsModuleConfig['max_qty_basket']);
}

/**
 * Generating meta information for this item
 */
$smartshop_metagen = new SmartMetagen($itemObj->getVar('name'), $itemObj->getVar('meta_keywords'), $itemObj->getVar('meta_description'), $categoryPath);
$smartshop_metagen->createMetaTags();
if(isset($_GET['print'])){
	$xoopsTpl->display('db:smartshop_item_print.html');
}else{
	if (!isset($xoops_urls)) {
		include_once XOOPS_ROOT_PATH.'/modules/smartobject/include/functions.php';
		$xoops_urls = smart_getCurrentUrls();
	}
	$url = $xoops_urls['full'];
	$xoopsTpl->assign('print_link', "<a href='".$url."&print'><img src='".XOOPS_URL."/modules/smartobject/images/print.gif'></a>");

	if ($xoopsModuleConfig['include_search']) {
		include_once(SMARTSHOP_ROOT_PATH . "include/searchform.php");
	}
	include_once(XOOPS_ROOT_PATH . '/footer.php');
}


?>