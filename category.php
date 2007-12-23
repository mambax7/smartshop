<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
ini_set('memory_limit','64M');
include_once('header.php');
include_once(XOOPS_ROOT_PATH . '/header.php');
$categoryid = isset($_GET['categoryid']) ? $_GET['categoryid'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Creating the category object for the selected categoryid
$categoryObj = $smartshop_category_handler->get($categoryid);
$tpl = $categoryObj->getVar('template') == 'default' ? $xoopsModuleConfig['category_tpl'] :$categoryObj->getVar('template');

if($tpl == 'list'){
	$xoopsOption['template_main'] = 'smartshop_category.html';
}else{
	$xoopsOption['template_main'] = 'smartshop_category_tableview.html';
}
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

$xoopsTpl->assign('cat_nav', $xoopsModuleConfig['category_nav']);
$xoopsTpl->assign('nav_mode', $xoopsModuleConfig['nav_mode']);


// if the selected item is new, it means that this itemid was not found, OR if the item is not active, exit
if ($categoryObj->isNew()) {
    redirect_header(SMARTSHOP_URL, 1, _CO_SOBJECT_NOT_SELECTED);
    exit();
}

if (!$categoryObj->accessGranted('category_view')) {
    redirect_header(SMARTSHOP_URL, 1, _NOPERM);
    exit();
}

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
/**
 * @todo TO be changed for a module preference
 */
$limit = $xoopsModuleConfig['items_per_page'] ;

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('parentid', $categoryid));
$criteria->add(new Criteria('status', _SSHOP_STATUS_ONLINE));
if($tpl == 'list'){
	$criteria->setSort($xoopsModuleConfig['sort'].', name');
	$criteria->setStart($start);
	$criteria->setLimit($limit);
}

$itemsObj =& $smartshop_item_handler->getObjects($criteria);
$itemsArray = array();
$i =0;
if($smartshop_module_use == 'boutique'){
	$basket = $smartshop_basket_handler->get();
	$basketItemArray =$basket->getItems(1);
}

foreach($itemsObj as $itemObj) {
	$itemObj->initiateCustomFields();
	$itemArray = $itemObj->toArray();
	$sortArray [$i] = $itemArray[$sort];
	if((isset($xoopsUser) && $xoopsUser != '') && $xoopsUser->getVar('uid') == $itemObj->getVar('uid', 'n')){
		$itemArray['can_edit'] = 1;
		$itemArray['auto_edit_links'] = $itemObj->getAutoEditLinks();
	}
	if($smartshop_module_use == 'boutique'){
	$itemArray['in_basket'] = (isset($basketItemArray[$itemObj->id()]) && intval($basketItemArray[$itemObj->id()]['quantity']) > 0);
	if($itemArray['in_basket']){
		$itemArray['message'] = sprintf(_MD_SSHOP_ALREADY_IN_BASKET, $basketItemArray[$itemObj->id()]['quantity']);
	}
}
	$itemsArray[$i] = $itemArray;
	$i++;
}
for($i=1;$i<51;$i++){
	$qty_opt .= "<option value='".$i."'>".$i."</option>";
}
$xoopsTpl->assign('qty_opt', $qty_opt);
$xoopsTpl->assign('items', $itemsArray);
$order == 'ASC' ? asort($sortArray) : arsort($sortArray) ;
$i =0;
foreach($sortArray as $index => $item){
	if($i >= $start && $i < ($start+$limit)){
		$sortArrayTrunc[$index] = $item;
	}
$i++;
}
$xoopsTpl->assign('sort_array', $sortArrayTrunc);
$xoopsTpl->assign('categoryid', $categoryid);
$xoopsTpl->assign('rev_order', $order == 'ASC' ? 'DESC' : 'ASC');
$order_icon = "<img src='".SMARTOBJECT_URL."images/actions/".($order == 'ASC' ? 'desc.png' : 'asc.png')."'/>";
$xoopsTpl->assign('order_icon', $order_icon);
$xoopsTpl->assign('current_sort', $sort);
$customFieldsObj =& $categoryObj->getCustomFields();
$aCustomFields = array();
foreach ($customFieldsObj as $customFieldObj) {
	$aCustomFields[] = $customFieldObj->toArray();
}
$xoopsTpl->assign('customFields', $aCustomFields);

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('parentid', $categoryid));
$criteria->add(new Criteria('status', _SSHOP_STATUS_ONLINE));
$totalItemsCount = $smartshop_item_handler->getCount($criteria);

include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

if($tpl == 'list'){
	$itemnav = new XoopsPageNav($totalItemsCount, $limit, $start, 'start', 'categoryid='.$categoryid);
}else{
	$itemnav = new XoopsPageNav($totalItemsCount, $limit, $start, 'start', 'categoryid='.$categoryid.'&sort='.$sort.'&order='.$order);
}
$xoopsTpl->assign('itemnav', $itemnav->renderNav());


$categories = array();
$categories[$categoryid]['self'] = $categoryObj->toArray();
$childCategories = $smartshop_category_handler->getAllCategoriesArray($categoryid);
if (count($childCategories)) {
	$categories[$categoryid]['sub'] = $childCategories;
	$categories[$categoryid]['subcatscount'] = count($childCategories);
} else {
	$categories[$categoryid]['subcatscount'] = 0;
}

$categoryPath = $categoryObj->getCategoryPath(true, true);
$xoopsTpl->assign('categoryPath', $categoryPath);
$xoopsTpl->assign('categories', $categories);
$xoopsTpl->assign('module_home', smart_getModuleName(true, true));

/**
 * Generating meta information for this item
 */
$smartshop_metagen = new SmartMetagen($categoryObj->getVar('name'), $categoryObj->getVar('meta_keywords'), $categoryObj->getVar('meta_description'));
$smartshop_metagen->createMetaTags();

if ($xoopsModuleConfig['include_search']) {
	include_once(SMARTSHOP_ROOT_PATH . "include/searchform.php");
};

include_once(XOOPS_ROOT_PATH . '/footer.php');

?>