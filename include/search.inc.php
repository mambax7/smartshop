<?php

/**
* $Id$
* Module: SmartSection
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

function smartshop_search($queryarray, $andor, $limit, $offset, $userid)
{
	include_once XOOPS_ROOT_PATH.'/modules/smartshop/include/common.php';
	ini_set('memory_limit','64M');
	$ret = array();

	if (!isset($smartshop_item_handler)) {
		$smartshop_item_handler = xoops_getmodulehandler('item', 'smartshop');
	}

	if ($queryarray == ''){
		$keywords= '';
		$hightlight_key = '';
	} else {
		$keywords=implode('+', $queryarray);
		$hightlight_key = "&amp;keywords=" . $keywords;
	}
	//hack for AMI
	foreach($queryarray as $kw){
		if(str_replace('-','', $kw) != $kw){
			$queryarray[] = str_replace('-','', $kw);
			$andor = 'OR';
		}
	}
	$itemsObj =& $smartshop_item_handler->getItemsFromSearch($queryarray, $andor, $limit, $offset, $userid);

	foreach ($itemsObj as $result) {

		$item['image'] = "images/item_icon.gif";
		$item['link'] = "item.php?itemid=" . $result['id'] . $hightlight_key;
		$item['title'] = "" . $result['title'];
		$item['time'] = $result['date_sub'];
		$item['uid'] = $result['uid'];
		$ret[] = $item;
		unset($item);
	}

	return $ret;
}

?>