<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once "../../mainfile.php";

if( !defined("SMARTSHOP_DIRNAME") ){
	define("SMARTSHOP_DIRNAME", 'smartshop');
}

include_once XOOPS_ROOT_PATH.'/modules/' . SMARTSHOP_DIRNAME . '/include/common.php';
smart_loadCommonLanguageFile();

if ($smartshop_module_use == 'dynamic_directory' ||$smartshop_module_use == 'adds') {
	if(!$xoopsModuleConfig['exp_manageby_cron']){
		include_once "expire.php";
	}
}
?>