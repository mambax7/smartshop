<?php
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}
function smartshop_basket_show()
{
	include_once (XOOPS_ROOT_PATH."/modules/smartshop/include/common.php");
	global $smartshop_basket_handler, $smartshop_item_handler;
	if(!isset($smartshop_basket_handler)){
		$smartshop_basket_handler =& xoops_getmodulehandler('basket','smartshop');
	}
	if(!isset($smartshop_item_handler)){
		$smartshop_item_handler =& xoops_getmodulehandler('item','smartshop');
	}

	$basket = $smartshop_basket_handler->get();
	if(!$basket->isNew()){
		$itemList = $basket->getItems(1);
	}
	$block['items'] = $itemList;
	return $block;
}

function smartshop_basket_edit()
{

}
?>
