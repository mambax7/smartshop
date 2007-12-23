<?php
/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

$i = -1;

$i++;
$adminmenu[$i]['title'] = _MI_SSHOP_INVENTORY;
$adminmenu[$i]['link'] = "admin/category.php";

$i++;
$adminmenu[$i]['title'] = _MI_SSHOP_GLOBAL_CSTMFLDS;
$adminmenu[$i]['link'] = "admin/category_attribut.php";

$i++;
$adminmenu[$i]['title'] = _MI_SSHOP_TRANSACTION;
$adminmenu[$i]['link'] = "admin/transaction.php";

$i++;
$adminmenu[$i]['title'] = _MI_SSHOP_CHECKOUT_CONFIG;
$adminmenu[$i]['link'] = "admin/checkout.php";

$i++;
$adminmenu[$i]['title'] = _MI_SSHOP_WAIT_APPROVAL;
$adminmenu[$i]['link'] = "admin/submit_items.php";

$i++;
$adminmenu[$i]['title'] = _MI_SSHOP_RENEW;
$adminmenu[$i]['link'] = "admin/renew.php";


if (isset($xoopsModule)) {

	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$i++;
	$headermenu[$i]['title'] = _CO_SOBJECT_GOTOMODULE;
	$headermenu[$i]['link'] = SMARTSHOP_URL;

	$i++;
	$headermenu[$i]['title'] = _CO_SOBJECT_UPDATE_MODULE;
	$headermenu[$i]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _AM_SOBJECT_ABOUT;
	$headermenu[$i]['link'] = SMARTSHOP_URL . "admin/about.php";
}
?>
