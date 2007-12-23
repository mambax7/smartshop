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
function search_show()
{
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/expire.php");
	$block = array();
	$block['lang_search'] = _MB_SSHOP_SEARCH;
	$block['lang_advsearch'] = _MB_SSHOP_ADVS;
	return $block;
}

function search_edit()
{

}

?>