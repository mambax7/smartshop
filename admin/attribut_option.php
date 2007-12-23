<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editattribut_option($showmenu = false, $optionid = 0, $attributid =0)
{
	global $smartshop_attribut_option_handler, $smartshop_category_attribut_handler;

	$attribut_optionObj = $smartshop_attribut_option_handler->get($optionid);
	$category_attributObj = $smartshop_category_attribut_handler->get($attribut_optionObj->getVar('attributid', 'n'));

	if (!$attribut_optionObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(0, _AM_SSHOP_ATTRIBUT_OPTIONS . " > " . _AM_SSHOP_EDITING);
		}
		smart_collapsableBar('attribut_optionedit', _AM_SSHOP_ATTRIBUT_OPTION_EDIT, _AM_SSHOP_ATTRIBUT_OPTION_EDIT_INFO);

		if ($category_attributObj->getVar('dependent_attributid') == 0) {
			$attribut_optionObj->hideFieldFromForm(array('linked_attribut_option_id', 'attributid'));
		} else {
			$attribut_optionObj->hideFieldFromForm(array('attributid'));
		}
		$sform = $attribut_optionObj->getForm(_AM_SSHOP_ATTRIBUT_OPTION_EDIT, 'addattribut_option');
		$sform->display();
		smart_close_collapsable('attribut_optionedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(0, _AM_SSHOP_ATTRIBUT_OPTIONS . " > " . _AM_SSHOP_CREATINGNEW);
		}

		smart_collapsableBar('attribut_optioncreate', _AM_SSHOP_ATTRIBUT_OPTION_CREATE, _AM_SSHOP_ATTRIBUT_OPTION_CREATE_INFO);
		if ($category_attributObj->getVar('dependent_attributid') == 0) {
			$attribut_optionObj->hideFieldFromForm(array('linked_attribut_option_id', 'attributid'));
		} else {
			$attribut_optionObj->hideFieldFromForm(array('attributid'));
		}
		$attribut_optionObj->setVar('attributid', $attributid);
		$sform = $attribut_optionObj->getForm(_AM_SSHOP_ATTRIBUT_OPTION_CREATE, 'addattribut_option');
		$sform->display();
		smart_close_collapsable('attribut_optioncreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
	case "mod":

		$optionid = isset($_GET['optionid']) ? intval($_GET['optionid']) : 0 ;
		$attributid = isset($_GET['attributid']) ? intval($_GET['attributid']) : 0 ;

		smart_xoops_cp_header();

		editattribut_option(true, $optionid, $attributid);
		break;

	case "listitems":

		smart_xoops_cp_header();
		smart_adminMenu(0, _AM_SSHOP_ATTRIBUT_OPTIONS . " > " . _AM_SSHOP_LISTING_ITEMS);

		$optionid = isset($_GET['optionid']) ? intval($_GET['optionid']) : 0 ;
		$attribut_optionObj =& $smartshop_attribut_option_handler->get($optionid);

		smart_collapsableBar('attribut_optionlistitems', sprintf(_AM_SSHOP_ATTRIBUT_OPTION_LIST_ITEMS, $attribut_optionObj->getVar('name')), _AM_SSHOP_ATTRIBUT_OPTION_ITEMS_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', $optionid));

		$objectTable = new SmartObjectTable($smartshop_item_handler, $criteria, array('delete'));
		$objectTable->addColumn(new SmartObjectColumn('name', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('uid', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('date', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('counter', 'center', 100));

		$objectTable->addIntroButton('additem', 'item.php?op=mod&optionid=' . $optionid, _AM_SSHOP_ITEM_CREATE);

		$objectTable->addCustomAction('getEditItemLink');

		$objectTable->addFilter('uid', 'getSellers');
		$objectTable->setDefaultFilter('uid');

		$objectTable->render();

		smart_close_collapsable('attribut_optionlistitems');

		break;

	case "addattribut_option":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_attribut_option_handler);
		$controller->storeFromDefaultForm(_AM_SSHOP_ATTRIBUT_OPTION_MODIFIED, _AM_SSHOP_ATTRIBUT_OPTION_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_attribut_option_handler);
		$controller->handleObjectDeletion();

		break;

	default:

		smart_xoops_cp_header();

		smart_adminMenu(0, _AM_SSHOP_ATTRIBUT_OPTIONS);

		echo "<br />\n";
		echo "<form><div style=\"margin-bottom: 12px;\">";
		echo "<input type='button' name='button' onclick=\"location='attribut_option.php?op=mod'\" value='" . _AM_SSHOP_ATTRIBUT_OPTION_CREATE . "'>&nbsp;&nbsp;";
		echo "</div></form>";

		smart_collapsableBar('createdattribut_options', _AM_SSHOP_ATTRIBUT_OPTIONS, _AM_SSHOP_ATTRIBUT_OPTIONS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttreetable.php";
		$objectTable = new SmartObjectTreeTable($smartshop_attribut_option_handler);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left', false, "getListItemsLink"));
		$objectTable->addCustomAction('getCreateItemLink');
		$objectTable->addCustomAction('getCreateAttributLink');

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdattribut_options');
		echo "<br>";

		break;
}

smartshop_modFooter();
xoops_cp_footer();

?>