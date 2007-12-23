<?php
/**
* $Id$
* Module: SmartCourse
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");

smart_xoops_cp_header();

smart_adminMenu(4, _AM_SSHOP_SUBMITTED);

smart_collapsableBar('submitteditems', _AM_SSHOP_SUBMITED, _AM_SSHOP_SUBMITED_DSC);

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', _SSHOP_STATUS_SUBMITTED));
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
$objectTable = new SmartObjectTable($smartshop_item_handler, $criteria, array( 'delete'));
$objectTable->setTableId('submitteditems');
$objectTable->addColumn(new SmartObjectColumn('name', 'left'));
$objectTable->addColumn(new SmartObjectColumn('uid', 'center', 100));
$objectTable->addColumn(new SmartObjectColumn('date', 'center', 100));
$objectTable->addColumn(new SmartObjectColumn('counter', 'center', 100));
$objectTable->addCustomAction('getApproveLink');

$objectTable->addFilter('uid', 'getSellers');
$objectTable->setDefaultFilter('uid');

$objectTable->render();

echo "<br />";
smart_close_collapsable('submitteditems');
echo "<br>";

smartshop_modFooter();
xoops_cp_footer();

?>