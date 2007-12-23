<?php
/**
* $Id$
* Module: SmartCourse
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/



include_once("admin_header.php");

smart_xoops_cp_header();

smart_adminMenu(5, _AM_SSHOP_RENEW);

//smart_addAdminAjaxSupport();
//smart_ajaxCollapsableBar('createditems', _AM_SSHOP_RENEW, _AM_SSHOP_RENEW_DSC);

smart_collapsableBar('renewitems', _AM_SSHOP_RENEW, _AM_SSHOP_RENEW_DSC);

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', _SSHOP_STATUS_EXPIRED));
$criteria->setOrder('uid');
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
$objectTable = new SmartObjectTable($smartshop_item_handler, $criteria, array( 'delete'));
$objectTable->setTableId('renewitems');
$objectTable->addColumn(new SmartObjectColumn('name', 'left'));
$objectTable->addColumn(new SmartObjectColumn('uid', 'center', 100));
$objectTable->addColumn(new SmartObjectColumn('date', 'center', 100));
$objectTable->addCustomAction('getRenewLink');
$objectTable->render();

echo "<br />";
smart_close_collapsable('renewitems');
echo "<br>";

smartshop_modFooter();
xoops_cp_footer();

?>