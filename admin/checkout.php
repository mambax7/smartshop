<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editcheckoutpage()
{
	$sform = new XoopsThemeForm(_AM_SSHOP_CHECKOUT_CONFIG, "op", xoops_getenv('PHP_SELF'));
	$sform->setExtra('enctype="multipart/form-data"');

	$checkout_redirect = smartshop_GetMeta('checkout_redirect');
	$sform->addElement(new XoopsFormText(_AM_SSHOP_MODIFY_COP_REDIRECT, 'checkout_redirect', 25, 255, $checkout_redirect));

	global $smartshop_category_attribut_handler;
	include_once(SMARTOBJECT_ROOT_PATH."class/form/elements/smartformcheckelement.php");
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('parentid', 0));
	$gcfObjs = $smartshop_category_attribut_handler->getList($criteria);
	$criteria->add(new Criteria('checkoutdisp', 1));
	$selGcfObjs = $smartshop_category_attribut_handler->getList($criteria);
	$globalCustomFieldCheck = new SmartFormCheckElement(_AM_SSHOP_MODIFY_COP_GCF, 'globalcustomfields', array_keys($selGcfObjs));
	$globalCustomFieldCheck->addOptionArray($gcfObjs);
	$sform->addElement($globalCustomFieldCheck);

	$button_tray = new XoopsFormElementTray('', '');
	$hidden = new XoopsFormHidden('op', 'save');
	$button_tray->addElement($hidden);


	$butt_create = new XoopsFormButton('', '', _AM_SSHOP_MODIFY_COP_SUBMIT, 'submit');
	//$butt_create->setExtra('onclick="this.form.elements.op.value=\'save\'"');
	$button_tray->addElement($butt_create);

	$butt_cancel = new XoopsFormButton('', '', _AM_SSHOP_MODIFY_COP_CANCEL, 'button');
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement($butt_cancel);


	$sform->addElement($button_tray);
	$sform->display();
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];


switch ($op) {



	case 'save' :
		smartshop_SetMeta('checkout_redirect', $_POST['checkout_redirect']);
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', 0));
		$gcfObjs = $smartshop_category_attribut_handler->getList($criteria);
		$criteria->add(new Criteria('checkoutdisp', 1));
		$selGcfObjs = $smartshop_category_attribut_handler->getList($criteria);

		foreach($_POST['globalcustomfields'] as $globalcustomfield){
			if(!isset($selGcfObjs[$globalcustomfield])){
				$gcf = $smartshop_category_attribut_handler->get($globalcustomfield);
				$gcf->setVar('checkoutdisp', 1);
				$smartshop_category_attribut_handler->insert($gcf);
			}
		}
		foreach(array_keys($selGcfObjs) as $selglobalcustomfield){
			if(!in_array($selglobalcustomfield, $_POST['globalcustomfields'])){
				$gcf = $smartshop_category_attribut_handler->get($selglobalcustomfield);
				$gcf->setVar('checkoutdisp', 0);
				$smartshop_category_attribut_handler->insert($gcf);
			}
		}

		redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		case "updateCustomFields":
		if (!isset($_POST['SmartshopCategory_attribut_objects']) || count($_POST['SmartshopCategory_attribut_objects']) == 0) {
			redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_TO_UPDATE);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('attributid', '(' . implode(', ', $_POST['SmartshopCategory_attribut_objects']) . ')', 'IN'));
		$attributsObj = $smartshop_category_attribut_handler->getObjects($criteria, true);
		foreach($attributsObj as $attributid=>$attributobj) {
			$attributobj->setVar('weight', isset($_POST['weight_' . $attributid]) ? intval($_POST['weight_' . $attributid]) : 0);
			$attributobj->setVar('required', isset($_POST['required_' . $attributid]) ? intval($_POST['required_' . $attributid]) : 0);

			$smartshop_category_attribut_handler->insert($attributobj);
		}

		redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		break;


	break;

	default:

		smart_xoops_cp_header();
		require_once XOOPS_ROOT_PATH.'/class/template.php';
		$xoopsTpl = new XoopsTpl();
		smart_adminMenu(3, _AM_SSHOP_CHECKOUT_CONFIG);
		smart_collapsableBar('cop_config', _AM_SSHOP_CHECKOUT_CONFIG, _AM_SSHOP_CHECKOUT_CONFIG_DSC);

		editcheckoutpage();

		echo "<br />";
		smart_close_collapsable('cop_config');
		echo "<br>";

		smart_collapsableBar('createdcategory_attribut', _AM_SSHOP_TRANS_ATTRIBUT, _AM_SSHOP_TRANS_ATTRIBUT_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', -1));
		$objectTable = new SmartObjectTable($smartshop_category_attribut_handler, $criteria);
		$objectTable->addIntroButton('add_trans_att', 'category_attribut.php?op=mod&categoryid=-1', _AM_SSHOP_TRANS_ATTRIBUT_CREATE);
		//$objectTable->addIntroButton('mod_check_conf', 'checkout.php?op=mod', _AM_SSHOP_MODIFY_COP_CONFIG);

		$objectTable->addColumn(new SmartObjectColumn('caption', 'left', false, _CO_SSHOP_CAT_ATTRIBUT_CAOPTION));
		$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
		$objectTable->addColumn(new SmartObjectColumn('required', 'center', 100, 'getRequiredControl'));
		$objectTable->addActionButton('updateCustomFields', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdcategory_attribut');
		echo "<br>";


		break;
}

smart_modFooter();
xoops_cp_footer();

?>