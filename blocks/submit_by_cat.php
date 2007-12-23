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

function smartshop_submit_by_cat_show ($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/common.php");
	global $xoopsUser;
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/expire.php");


	$block = array();
	$block['format'] = $options[0];

	if($options[0] == 'list' || empty($options[0])){
		$smartshop_category_handler =& xoops_getmodulehandler('category', 'smartshop');
		$criteria = new CriteriaCompo();
		$criteria->setSort('weight');
		$criteria->add(new Criteria('hasitem', 1));

		$categoriesObj = $smartshop_category_handler->getObjects($criteria);
		$totalcats = count($categoriesObj);
		If ($categoriesObj ) {
			for ( $i = 0; $i < $totalcats; $i++ ) {
	            $categories = array();
	            $categories['link'] = $categoriesObj[$i]->getCreateItemLink4user();
	            $block['categories'][] = $categories;
			}
		}
	}
	else{
		$block['lang_choose'] = _MB_SSHOP_CHOOSE;
		$categories_options = array();
		include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
		global $xoopsDB;
		$mytree = new XoopsTree( $xoopsDB -> prefix( "smartshop_category" ), "categoryid", "parentid" );
		ob_start();
		$mytree -> makeMySelBox( "name","", 0, 1, 'categoryid', "submit()");
		$block['select'] = ob_get_contents() ;
		ob_end_clean();
	}
	return $block;
}

function smartshop_submit_by_cat_edit($options)
{
   global $xoopsDB, $xoopsModule, $xoopsUser;
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/functions.php");



    $form .= "&nbsp;<br>" . _MB_SSHOP_SUBMIT_BL_FORMAT . "&nbsp;<select name='options[]'>";
    $form .= "<option value='list'";
    if ($options[0] == "list" || empty($options[0])) {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_LIST . "</option>\n";

    $form .= "<option value='select'";
    if ($options[0] == "select") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_SELECT . "</option>\n";

    $form .= "</select>\n\n";

    $form .= "&nbsp;" . _MB_SSHOP_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_SSHOP_ITEMS . "";

    return $form;
}

?>