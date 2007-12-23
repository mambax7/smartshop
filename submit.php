<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function addItem() {
	global $smartshop_item_handler, $smartshop_item_attribut_handler;

    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
    $controller = new SmartObjectController($smartshop_item_handler);

	$itemObj = $controller->storeSmartObject();

    if ($itemObj->hasError()) {
    	redirect_header($smart_previous_page, 3, _CO_SOBJECT_SAVE_ERROR . $itemObj->getHtmlErrors());
    	exit;
    }
    // no errors, we are good to go to save the custom fields
    $customFieldsObj =& $itemObj->getCustomFields();
    foreach($customFieldsObj as $customField) {
    	$item_attributObj =& $smartshop_item_attribut_handler->get(array($customField->getVar('attributid'), $itemObj->getVar('itemid')));
    	if ($item_attributObj->isNew()) {
    		$item_attributObj->setVar('attributid', $customField->getVar('attributid'));
    		$item_attributObj->setVar('itemid', $itemObj->getVar('itemid'));
    	}
    	$field_value = isset($_POST[$customField->getVar('name')]) ? $_POST[$customField->getVar('name')] : '';
    	$item_attributObj->setVar('value', $field_value);
    	if (!$smartshop_item_attribut_handler->insert($item_attributObj)) {
    		$itemObj->setErrors($item_attributObj->getErrors(), $customField->getVar('name'));
    	}

    	unset($item_attributObj);
    }
    if ($itemObj->hasError()) {
    	redirect_header($smart_previous_page, 3, _CO_SOBJECT_SAVE_ERROR . $itemObj->getHtmlErrors());
    	exit;
    } else {


		include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';

		$notification_handler = &xoops_gethandler('notification');
		$notification_handler->subscribe('item', $itemObj->getVar('itemid'), 'approved', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);

		$itemObj->sendNotifications(array(_SSHOP_NOT_ADD_SUBMITTED));

     	redirect_header(smart_get_page_before_form(), 3, _MD_SSHOP_WILL_BE_APPROVED);
    	exit;
    }
}

include_once("header.php");
include_once(XOOPS_ROOT_PATH . "/header.php");
if (!is_object($xoopsUser)) {
	redirect_header(XOOPS_URL."/user.php", 3, _MD_SSHOP_MUST_BE_REG);
	exit;
}

$op = isset($_GET['op']) ? $_GET['op'] : "";
$op = isset($_POST['op']) ? $_POST['op'] : $op;
switch ($op){
case 'additem':

	addItem();
break;

case 'sold':
	//soldItem();
	global $smartshop_item_handler;

	$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : "";
	$itemid = isset($_GET['itemid']) ? $_GET['itemid'] : $itemid;

	$itemObj = $smartshop_item_handler->get($itemid);
	if ($itemObj->isNew()) {
		redirect_header("javascript:history.go(-1)", 3, _CO_SOBJECT_NOT_SELECTED);
		exit();
	}
	$smartshop_item_handler->markAsSold('submit.php', $itemObj, SMARTSHOP_URL);
	include_once(XOOPS_ROOT_PATH . "/footer.php");
break;

case '':
 	$xoopsOption['template_main'] = 'smartshop_presubmit.html';
 	include_once(XOOPS_ROOT_PATH . "/header.php");

	$groups = $xoopsUser->getGroups();
	$allowed = array_intersect($groups, $xoopsModuleConfig['allowed_groups']);
	if(empty($allowed)){
		redirect_header(XOOPS_URL, 3, _MD_SSHOP_NOT_ALLOWED2SUBMIT);
		exit;
	}
	$categoriesArray = $smartshop_category_handler->getCategoryHierarchyArray();
 	$xoopsTpl->assign('submit_intro', $xoopsModuleConfig['submit_intro']);
	$xoopsTpl->assign('lang_choose_cat', _MD_SSHOP_CHOOSE_CAT);
	$xoopsTpl->assign('categories_array', $categoriesArray);
	include_once("footer.php");

	include_once(XOOPS_ROOT_PATH . "/footer.php");
break;

case 'mod':

	$xoopsOption['template_main'] = 'smartshop_submit.html';
	if(!$_GET['no_intro']){
		$xoopsTpl->assign('submit_intro', $xoopsModuleConfig['submit_intro']);
	}
	//global $smartshop_item_handler, $smartshop_category_handler, $xoopsUser;

	if(!isset($_GET['itemid'])){//si on crée un nouvel item
		$groups = $xoopsUser->getGroups();
		$allowed = array_intersect($groups, $xoopsModuleConfig['allowed_groups']);
		if(empty($allowed)){
			redirect_header(XOOPS_URL, 3, _MD_SSHOP_NOT_ALLOWED2SUBMIT);
			exit;
		}
		$itemObj = $smartshop_item_handler->create();
			$hidden_array = array('uid','parentid', 'date', 'status', 'meta_keywords', 'meta_description', 'short_url', 'weight', 'exp_date', 'no_exp', 'currency');
		if (isset($_GET['categoryid'])) {
		  	$itemObj->setVar('parentid', $_GET['categoryid']);
		  	$itemObj->setVar('uid', $xoopsUser->getVar('uid'));
		  	//si délai d'exp == 0 , on marque "pas d'exp"
		  	if($xoopsModuleConfig['def_delay_exp'] == 0){
	  			$itemObj->setVar('no_exp', 1);
	  		}
	  		//si pas auto approve, marquer comme soumis
		  	if(!$xoopsModuleConfig['autoapprove']){
		  		$itemObj->setVar('status', _SSHOP_STATUS_SUBMITTED);
		  	}
		  	// si auto approve, marquer online et setter date_exp si def_delay_exp != 0
		  	else{
		  		$itemObj->setVar('status', _SSHOP_STATUS_ONLINE);
		  		if($xoopsModuleConfig['def_delay_exp'] != 0){
		  			$itemObj->setVar('exp_date', (time()+ (intval($xoopsModuleConfig['def_delay_exp'])*24*3600)));
		  		}
		  	}
		  	$itemObj->setVar('date', time());
		  	$catObj = $smartshop_category_handler->get($_GET['categoryid']);

		} else {
			redirect_header(SMARTSHOP_URL, 3, _MD_SSHOP_SUBMIT_CATEGORY_NOT_FOUND);
			exit;
		}

	}

	else{
		//si on édite un item, on le restaure de la bd
		$itemObj = $smartshop_item_handler->get($_GET['itemid']);
		$hidden_array = array('uid', 'parentid', 'date', 'status', 'meta_keywords', 'meta_description', 'short_url', 'weight', 'exp_date', 'no_exp');
		$xoopsTpl->assign('modif_intro', _MD_SSHOP_MODIF_WARNING);
		$catObj = $smartshop_category_handler->get($_GET['categoryid']);
		if(!$xoopsModuleConfig['autoapprove']){
			$itemObj->setVar('status', _SSHOP_STATUS_MODIFIED);
		}

    	//Vérifier la correspondance du user avec le uid de l'item
		if($itemObj->getVar('uid', 'n') != $xoopsUser->getVar('uid') && !$smartshop_isAdmin){
			redirect_header(SMARTSHOP_URL, 3, _NOPERM);
			exit;
		}
	}

	$categoryObj = $smartshop_category_handler->get($itemObj->getVar('parentid'));
	if ($categoryObj->isNew()) {
		redirect_header(SMARTSHOP_URL, 3, _MD_SSHOP_SUBMIT_CATEGORY_NOT_FOUND);
		exit;
	}

	$itemObj->initiateCustomFields();

	$itemObj->hideFieldFromForm($hidden_array);

	if ($itemObj->isNew()){
		$title = _MD_SSHOP_ITEM_SUBMIT;
		$form_name = sprintf(_MD_SSHOP_ITEM_SUBMIT,$categoryObj->getVar('name')) ;
	} else {
		$title = _MD_SSHOP_ITEM_EDIT;
		$form_name = sprintf(_MD_SSHOP_ITEM_EDIT , $itemObj->getVar('name')) ;
	}

	$sform = $itemObj->getForm($form_name, 'additem');

	$sform->assign($xoopsTpl);

	include_once("footer.php");

	include_once(XOOPS_ROOT_PATH . "/footer.php");
break;
}

?>