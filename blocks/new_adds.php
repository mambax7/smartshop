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

function new_adds_show ($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/expire.php");
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/common.php");
	$block = array();

	$smartshop_category_handler =& smartshop_gethandler('category');
	$categoriesObj = $smartshop_category_handler->getObjects();
	$categories = array();
	foreach($categoriesObj as $catObj){
		$categories[$catObj->getVar('categoryid')] = $catObj->getVar('name');
	}
	$smartshop_item_handler =& xoops_getmodulehandler('item', 'smartshop');
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('status', _SSHOP_STATUS_ONLINE));
	$criteria->setSort('date');
    $criteria->setOrder('DESC');
    $criteria->setStart(0);
	$criteria->setLimit(5);
	$itemsObj = $smartshop_item_handler->getObjects($criteria);
	$totalitems = sizeof($itemsObj);


	If ($itemsObj) {
		for ( $i = 0; $i < $totalitems; $i++ ) {
	            $item = array();

	            $item['link'] = "<a href='".SMARTSHOP_URL."item.php?itemid=".$itemsObj[$i]->getVar('itemid')."'>".$itemsObj[$i]->getVar('name')."</a>";
	            $item['cat'] = $categories[$itemsObj[$i]->getVar('parentid')];
	            $block['items'][] = $item;
	           	unset($item);
			}
		}
	return $block;
}

function new_adds_edit($options)
{
   /*global $xoopsDB, $xoopsModule, $xoopsUser;
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/functions.php");

	$form = smartshop_createCategorySelect($options[0]);

    $form .= "&nbsp;<br>" . _MB_SSHOP_ORDER . "&nbsp;<select name='options[]'>";

    $form .= "<option value='datesub'";
    if ($options[1] == "datesub") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ($options[1] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_HITS . "</option>\n";

    $form .= "<option value='weight'";
    if ($options[1] == "weight") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_WEIGHT . "</option>\n";

    $form .= "</select>\n";

    $form .= "&nbsp;" . _MB_SSHOP_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_SSHOP_ITEMS . "";

    return $form;*/
}

?>