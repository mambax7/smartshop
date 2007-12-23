<?php
ini_set('memory_limit','64M');
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
switch ($op) {
	case 'post' :
		$criteria = new CriteriaCompo();

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

		//if ($categoryid > 0) {
			$cat_attObjs = $smartshop_category_attribut_handler->getObjects();
			$valid_fields = array();
			foreach($cat_attObjs as $cat_attObj){
				$valid_fields[] = $cat_attObj->getVar('name');
			}
			$custom_field_kw_array = array();
			foreach($_REQUEST as $field => $keyword){
				if(in_array($field, $valid_fields)){
					$custom_field_kw_array[$field] = $keyword;
				}
			}
		//}
		$itemsObj = $smartshop_item_handler->getObjectsForSearchForm($criteria, $custom_field_kw_array, $categoryid, intval($_REQUEST['andor']));
		$items_array = array();

		if ($itemsObj) {

			foreach ($itemsObj as $itemObj) {
				$parentid = $itemObj->getVar('parentid');
				//$categoryObj = $smartshop_category_handler->get($categoryid);
				$itemArray = $itemObj->toArray(true);
				$items_array[] = $itemArray;
			}
		}
		$xoopsTpl->assign('items_array', $items_array);
		$xoopsTpl->assign('smartshop_search_results', true);

		if (count($items_array) == 0) {
			$xoopsTpl->assign('lang_searchresultstext', _MD_SSHOP_SEARCH_NORESULTS);
		} else {
			$xoopsTpl->assign('lang_searchresultstext', _MD_SSHOP_SEARCH_RESULTS_TEXT);
		}

		$xoopsTpl->assign('categoryPath', _MD_SSHOP_SEARCH_RESULTS_TITLE);

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