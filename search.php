<?php

global $smartshop_category_handler, $smartshop_category_attribut_handler,$smartshop_item_handler, $xoopsUser, $xoopsModuleConfig;
include_once("header.php");

$xoopsOption['template_main'] = 'smartshop_searchresults.html';
include_once(XOOPS_ROOT_PATH . "/header.php");


$xoopsTpl->assign('cat_nav', $xoopsModuleConfig['category_nav']);
$xoopsTpl->assign('nav_mode', $xoopsModuleConfig['nav_mode']);
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'form';
//$categoryid = (isset($categoryid)) ? $categoryid : ;
$categoryid = (isset($_REQUEST['categoryid'])) ? $_REQUEST['categoryid'] : 0;
$title = (isset($_REQUEST['title'])) ? $_REQUEST['title'] : '';
$name_desc = (isset($_REQUEST['name_desc'])) ? $_REQUEST['name_desc'] : '';
$desc = (isset($_REQUEST['desc'])) ? $_REQUEST['desc'] : '';
$andOr = intval($_REQUEST['andor']) == 1 ? 'AND' : 'OR';

$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
$order = isset($_REQUEST['order']) ? $_REQUEST['order'] : 'ASC';

$start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
$limit = $xoopsModuleConfig['items_per_page'] ;

//Todo: use getList
$cat_attObjs = $smartshop_category_attribut_handler->getObjects();
$valid_fields = array();
foreach($cat_attObjs as $cat_attObj){
	$valid_fields[$cat_attObj->getVar('attributid', 'n')] = $cat_attObj->getVar('name');
}

if($categoryid){
	$categoryObj = $smartshop_category_handler->get($categoryid);
	$tpl = $categoryObj->getVar('template') == 'default' ? $xoopsModuleConfig['category_tpl'] :$categoryObj->getVar('template');
	$xoopsTpl->assign('categoryid', $categoryid);
	$customFieldsObj =& $categoryObj->getCustomFields();
	$aCustomFields = array();
	foreach ($customFieldsObj as $customFieldObj) {
		if($customFieldObj->getVar('searchdisp') == 1){
			$aCustomFields[] = $customFieldObj->toArray();
		}
	}
	$xoopsTpl->assign('customFields', $aCustomFields);
}else{
	$tpl = $xoopsModuleConfig['category_tpl'] ;

	$criteria = new CriteriaCompo();
    $criteria->add(new Criteria('parentid', 0));
    $criteria->add(new Criteria('searchdisp', 1));
	$criteria->setSort('weight');
	$customFieldsObj =& $smartshop_category_attribut_handler->getObjects($criteria);

	$aCustomFields = array();
	foreach ($customFieldsObj as $customFieldObj) {
		$aCustomFields[] = $customFieldObj->toArray();
	}
	$xoopsTpl->assign('customFields', $aCustomFields);

}
if($tpl == 'list'){
	$xoopsTpl->assign('view_type', 'list_view');
}else{
	$xoopsTpl->assign('view_type', 'table_view');
}
$query_string = isset($_REQUEST['categoryid']) ? "&categoryid=".$_REQUEST['categoryid'] : '';
$query_string .= isset($_REQUEST['title']) ? "&title=".$_REQUEST['title'] : '';
$query_string .= isset($_REQUEST['name_desc']) ? "&name_desc=".$_REQUEST['name_desc'] : '';
$query_string .= isset($_REQUEST['desc']) ? "&desc=".$_REQUEST['desc'] : '';
$query_string .= "&andor=".$_REQUEST['andor'];
$query_string .= "&op=post";
foreach($_REQUEST as $field => $keyword){
	if(in_array($field, $valid_fields)){
		if(is_array($keyword)){
			$query_string .= "&".$field."=".implode(' ', $keyword);
		}else{
			$query_string .= "&".$field."=".$keyword;
		}
	}
}
$xoopsTpl->assign('query_string', $query_string);


switch ($op) {
	case 'post' :
		$criteria = new CriteriaCompo();
		$criteria->SetSort($sort);
		$criteria->SetOrder($order);
		$criteria->SetStart($start);
		$criteria->SetLimit($limit);

		if ($name_desc != '') {
			$keywords_array = explode(' ', $name_desc);
			if (count($keywords_array) > 0) {
				foreach ($keywords_array as $keyword) {
					if($keyword != ''){
						$criteria->add(new Criteria('name', "%$keyword%", 'LIKE'), 'OR');
						$criteria->add(new Criteria('description', "%$keyword%", 'LIKE'), 'OR');
					}
				}
			}
		}
		if ($title  != '') {
			$keywords_array = explode(' ', $title);
			if (count($keywords_array) > 0) {
				$isFirst = true;
				foreach ($keywords_array as $keyword) {
					if($keyword != ''){
						$lclAndOr = ($isFirst) ? 'AND' : $andOr;
						$criteria->add(new Criteria('name', "%$keyword%", 'LIKE'), $lclAndOr );
						$isFirt = false;
					}
				}
			}
		}

		if ($desc  != '') {
			$keywords_array = explode(' ', $desc);
			if (count($keywords_array) > 0) {
				$isFirst = true;
				foreach ($keywords_array as $keyword) {
					if($keyword != ''){
						$lclAndOr = ($title != '' && $isFirst) ? 'AND' : $andOr;
						$criteria->add(new Criteria('description', "%$keyword%", 'LIKE'), $lclAndOr);
						$isFirst = false;
					}
				}
			}
		}


		$custom_field_kw_array = array();
		foreach($_REQUEST as $field => $keyword){
			if(in_array($field, $valid_fields)){
				foreach($valid_fields as $att_id => $field_name){
					if($field_name == $field){
						$custom_field_kw_array[$field]['attribut_id'] =	$att_id;
					}
				}
				$multi = strpos($keyword, ' ');
				if ($multi !== false) {
					$custom_field_kw_array[$field]['kw'] = explode(' ', $keyword);
				}else{
					$custom_field_kw_array[$field]['kw'] =  $keyword;
				}
			}
		}

		$totalItemsCount = $smartshop_item_handler->getObjectsForSearchForm($criteria, $custom_field_kw_array, $categoryid, intval($_REQUEST['andor']), true);
		$itemsObj = $smartshop_item_handler->getObjectsForSearchForm($criteria, $custom_field_kw_array, $categoryid, intval($_REQUEST['andor']));
		$items_array = array();
		if($smartshop_module_use == 'boutique'){
			$basket = $smartshop_basket_handler->get();
			if(!$basket->isNew()){
				$basketItemArray =$basket->getItems(1);
			}
		}
		if ($itemsObj) {
			foreach ($itemsObj as $itemObj) {
				$itemArray = $itemObj->toArray(true);
				if($smartshop_module_use == 'boutique'  && $xoopsModuleConfig['max_qty_basket']){
					$itemArray['in_basket'] = (isset($basketItemArray[$itemObj->getVar('itemid')]) && intval($basketItemArray[$itemObj->getVar('itemid')]['quantity']) > 0);
					if($itemArray['in_basket']){
						if($xoopsModuleConfig['max_qty_basket'] > 1){
							$itemArray['message'] = sprintf(_MD_SSHOP_ALREADY_IN_BASKET, $basketItemArray[$itemid]['quantity']);
						}else{
							$itemArray['message'] = _MD_SSHOP_ALREADY_IN_BASKET1;
						}
					}
				}
				$items_array[] = $itemArray;
			}
		}

		/*if ($itemsObj) {
			$i =0;
			foreach ($itemsObj as $itemObj) {
				//var_dump(count($itemObj->vars));echo " Cat: ".$itemObj->getVar('parentid')."Id: ".$itemObj->getVar('itemid')."<br><br>";
				if($tpl == 'table' || ($i >= $start && $i < ($start+$limit))){
					$itemArray = $itemObj->toArray(true);
					$sortArray [$i] = $itemArray[$sort];
					if($smartshop_module_use == 'boutique'  && $xoopsModuleConfig['max_qty_basket']){
						$itemArray['in_basket'] = (isset($basketItemArray[$itemObj->getVar('itemid')]) && intval($basketItemArray[$itemObj->getVar('itemid')]['quantity']) > 0);
						if($itemArray['in_basket']){
							if($xoopsModuleConfig['max_qty_basket'] > 1){
								$xoopsTpl->assign('message', sprintf(_MD_SSHOP_ALREADY_IN_BASKET, $basketItemArray[$itemid]['quantity']));
							}else{
								$xoopsTpl->assign('message', _MD_SSHOP_ALREADY_IN_BASKET1);
							}
						}
					}//var_dump($itemArray);exit;
					$items_array[$i] = $itemArray;
				}
				$i++;
			}
		}*/

		if($tpl == 'table'){
			$xoopsTpl->assign('rev_order', $order == 'ASC' ? 'DESC' : 'ASC');
			$order_icon = "<img src='".SMARTOBJECT_URL."images/actions/".($order == 'ASC' ? 'desc.png' : 'asc.png')."'/>";
			$xoopsTpl->assign('order_icon', $order_icon);
			$xoopsTpl->assign('current_sort', $sort);
			$xoopsTpl->assign('max_qty_basket', $xoopsModuleConfig['max_qty_basket']);
		}

		if($xoopsModuleConfig['max_qty_basket'] > 1){
			for($i=1;$i<=intval($xoopsModuleConfig['max_qty_basket']);$i++){
				$qty_opt .= "<option value='".$i."'>".$i."</option>";
			}
			$xoopsTpl->assign('qty_opt', $qty_opt);
		}

		$xoopsTpl->assign('items', $items_array);
		$xoopsTpl->assign('smartshop_search_results', true);

		if (count($items_array) == 0) {
			$xoopsTpl->assign('lang_searchresultstext', _MD_SSHOP_SEARCH_NORESULTS);
		} else {
			$xoopsTpl->assign('lang_searchresultstext', _MD_SSHOP_SEARCH_RESULTS_TEXT);
		}

		$xoopsTpl->assign('categoryPath', _MD_SSHOP_SEARCH_RESULTS_TITLE);


		include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
		if($tpl == 'table'){
			$itemnav = new XoopsPageNav($totalItemsCount, $limit, $start, 'start', '&sort='.$sort.'&order='.$order.$query_string);
		}else{
			$itemnav = new XoopsPageNav($totalItemsCount, $limit, $start, 'start', $query_string);
		}
		$xoopsTpl->assign('itemnav', $itemnav->renderNav());

	break;

	case 'form' :
	$xoopsTpl->assign('smartshop_search_results', false);
	$xoopsTpl->assign('categoryPath', _MD_SSHOP_SEARCH);
	break;
}

include_once("include/searchform.php");

$moduleName = $myts->displayTarea($xoopsModule->getVar('name'));

$xoopsTpl->assign('indexfooter', smartshop_getConfig('indexfooter'));

$xoopsTpl->assign('lang_searchformtitle', _MD_SSHOP_SEARCH);
$xoopsTpl->assign('lang_searchformtext', _MD_SSHOP_SEARCH_INFO);

$xoopsTpl->assign('lang_searchresultstitle', _MD_SSHOP_SEARCH_RESULTS_TITLE);

$xoopsTpl->assign('smartshop_nosearchbox', true);


// MetaTag Generator
//smartshop_createMetaTags($moduleName, '', $myts->displayTarea($xoopsModuleConfig['indexwelcomemsg']));

include_once("footer.php");

include_once(XOOPS_ROOT_PATH . "/footer.php");

?>