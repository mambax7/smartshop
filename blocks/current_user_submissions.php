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

function current_user_submissions_show ($options)
{
	global $xoopsUser;

	include_once(XOOPS_ROOT_PATH."/modules/smartshop/expire.php");

	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/common.php");

	$block = array();

	$smartshop_category_handler =& smartshop_gethandler('category');
	$smartshop_item_handler =& smartshop_gethandler('item');
	$criteria = new CriteriaCompo();
	$criteria->setSort('weight');

	$categoriesObj = $smartshop_category_handler->getObjects($criteria);
	$totalcats = count($categoriesObj);

	//$smartshop_category_handler =& smartshop_gethandler('category');
	$criteria2 = new CriteriaCompo();
	$criteria2->add(new Criteria('uid', $xoopsUser->getVar('uid')));
	//$criteria2->add(new Criteria('status', _SSHOP_STATUS_ONLINE));

	$criteria2->setSort('status, weight');

	$itemsObj = $smartshop_item_handler->getObjects($criteria2);
	$totalitems = count($itemsObj);



	If ($categoriesObj) {
		for ( $i = 0; $i < $totalcats; $i++ ) {
            $category = array();

            $category['name'] = "<a href='".SMARTSHOP_URL."category.php?categoryid=".$categoriesObj[$i]->getVar('categoryid')."'>".$categoriesObj[$i]->getVar('name')."</a>";
            $category['items'] = array();
            for ( $j = 0; $j < $totalitems; $j++ ) {


            	$status = constant("_MB_SSHOP_STATUS_".$itemsObj[$j]->getVar('status', 'e'));
            	if($categoriesObj[$i]->getVar('categoryid')== $itemsObj[$j]->getVar('parentid')){
            		$category['items'][] = "<a href='".SMARTSHOP_URL."item.php?itemid=".$itemsObj[$j]->getVar('itemid')."'>".$itemsObj[$j]->getVar('name')." (".$status.")</a>";


            	}
            }
            if(!empty($category['items'])){
           	 $block['categories'][] = $category;
            }
            unset($category);
		}
	}

	return $block;
}

function current_user_submissions_edit($options)
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