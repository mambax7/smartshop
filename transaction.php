<?php
/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once('header.php');


$op ='';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
case "updateBasket":
	if (!isset($_POST['SmartshopBasket_item_objects']) || count($_POST['SmartshopBasket_item_objects']) == 0) {
		redirect_header($smart_previous_page, 2, _CO_SOBJECT_NO_RECORDS_TO_UPDATE);
		exit;
	}

	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('basket_itemid', '(' . implode(', ', $_POST['SmartshopBasket_item_objects']) . ')', 'IN'));
	$basket_itemObj = $smartshop_basket_item_handler->getObjects($criteria, true);
	foreach($basket_itemObj as $basket_itemid=>$basket_itemobj) {
		$basket_itemobj->setVar('quantity', isset($_POST['quantity_' . $basket_itemid]) ? intval($_POST['quantity_' . $basket_itemid]) : 0);
		$smartshop_basket_item_handler->insert($basket_itemobj);
	}

	redirect_header($smart_previous_page, 2, _CO_SOBJECT_NO_RECORDS_UPDATED);
	exit;

	break;
case "form":
	include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
    $controller = new SmartObjectController($smartshop_transaction_handler);
    //$transactionObj = $controller->storeSmartObject();
    $transactionObj = $smartshop_transaction_handler->create();
    $transactionObj->basketToTransaction();
    $transactionObj->initiateCustomFields();
    foreach($_POST as $key => $value){
    	$transactionObj->setVar($key, $value);
    }
    $customInfo = $transactionObj->getCustomFieldForEmail();
	$details = $transactionObj->getSummaryForEmail();
    $fct = isset($_POST['fct']) ? $_POST['fct'] :'' ;


    if ($transactionObj->hasError()) {
    	redirect_header($smart_previous_page, 3, _CO_SOBJECT_SAVE_ERROR . $transactionObj->getHtmlErrors());
    } else {


		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setToEmails($transactionObj->getVar('email'));
		$xoopsMailer->setTemplateDir(SMARTSHOP_ROOT_PATH.'language/'.$xoopsConfig['language'].'/mail_template/');
		$xoopsMailer->setTemplate('user_order.tpl');
		$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
		$xoopsMailer->setFromName($xoopsConfig['sitename']);
		$xoopsMailer->setSubject(_MD_SSHOP_CONFIRM_ORDER);
		$xoopsMailer->multimailer->IsHTML(true);
		$xoopsMailer->assign('XOOPS_URL', $xoopsConfig['sitename']);
		$xoopsMailer->assign('DETAILS', $details);
		$xoopsMailer->assign('XINFO', $customInfo);
		$xoopsMailer->assign('SIG', $xoopsModuleConfig['signature']);

		if(!$xoopsMailer->send(1)){

			var_dump($xoopsMailer->getErrors());exit;
		}
		unset($xoopsMailer);

		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();
		$group_handler = &xoops_gethandler('group');
		foreach($xoopsModuleConfig['order_mail_groups'] as $groupid){
			$groups[] = $group_handler->get($groupid);
		}
		$xoopsMailer->setToGroups($groups);
		$xoopsMailer->setToEmails(explode(';',$xoopsModuleConfig['extra_emails']));

		$xoopsMailer->setTemplateDir(SMARTSHOP_ROOT_PATH.'language/'.$xoopsConfig['language'].'/mail_template/');
		$xoopsMailer->setTemplate('admin_order.tpl');
		$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
		$xoopsMailer->setFromName($xoopsConfig['sitename']);
		$xoopsMailer->setSubject(_MD_SSHOP_RECEIVED_ORDER);
		$xoopsMailer->multimailer->IsHTML(true);
		$xoopsMailer->assign('XOOPS_URL', XOOPS_URL);
		$xoopsMailer->assign('DETAILS', $details);
		$xoopsMailer->assign('XINFO', $customInfo);

		if(!$xoopsMailer->send(1)){

			var_dump($xoopsMailer->getErrors());exit;
		}

		redirect_header(str_replace('{XOOPS_URL}', XOOPS_URL, smartshop_GetMeta('checkout_redirect')), 3, sprintf(_CO_SHOP_THANKS_SHOPPING_HERE, $xoopsConfig['sitename']));
		exit;
    }

	break;
default:
	$xoopsOption['template_main'] = 'smartshop_transaction.html';
	include_once(XOOPS_ROOT_PATH . "/header.php");

	$basket = $smartshop_basket_handler->get();
	$basket->prepareCheckout();

	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('basketid', $basket->id()));
	include_once(SMARTOBJECT_ROOT_PATH . "class/smartobjecttable.php");
	$objectTable = new SmartObjectTable($smartshop_basket_item_handler, $criteria, array());
	$objectTable->isForUserSide();
	$objectTable->disableColumnsSorting();
	$objectTable->hideFilterAndLimit();
	$objectTable->addColumn(new SmartObjectColumn('item_name', 'left'));
	if(in_array('description', $xoopsModuleConfig['display_fields'])){
		$objectTable->addColumn(new SmartObjectColumn('description', 'left'));
	}
	foreach($basket->getCheckoutFields() as $key => $checkOutField){
		$objectTable->addColumn(new SmartObjectColumn($checkOutField, 'left', false, 'getCheckoutFieldValue', array('key' => $key, 'basket' => $basket)));
	}

	if(in_array('price',$xoopsModuleConfig['display_fields'])){
		$objectTable->addColumn(new SmartObjectColumn('price', 'center'));
	}
	$objectTable->addColumn(new SmartObjectColumn('quantity', 'center', 100, 'getQtyControl'));
	$objectTable->addActionButton('updateBasket', _SUBMIT, _MD_SSHOP_SAVE_CHANGES);

	$xoopsTpl->assign('table', $objectTable->fetch());
	//custom version for AMI
	if(in_array('price',$xoopsModuleConfig['display_fields'])){
		$xoopsTpl->assign('total', $basket->getTotal());
	}
	$transactionObj = $smartshop_transaction_handler->create();
	$transactionObj->basketToTransaction(false);
	$transactionObj->initiateCustomFields();
	$transactionObj->hideFieldFromForm(array('transactionid', 'basketid', 'tran_date', 'tran_uid'));
	$transactionObj->makeFieldReadOnly(array('price', 'currency'));
	$t_form = $transactionObj->getForm(_MD_SSHOP_ORDER_FORM , "form");
	$xoopsTpl->assign('use_custom_version', $xoopsModuleConfig['use_custom_version']);
	$t_form->assign($xoopsTpl);

	//include_once("include/orderform.php");

	break;
}
include_once(SMARTSHOP_ROOT_PATH . "footer.php");
include_once(XOOPS_ROOT_PATH . '/footer.php');
?>