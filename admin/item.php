<?php
/**
* $Id$
* Module: SmartCourse
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function edititem($showmenu = false, $itemid = 0, $fct = '')
{
    global $smartshop_item_handler, $smartshop_category_handler, $xoopsUser, $op;

    $itemObj = $smartshop_item_handler->get($itemid);

    if ( isset($_GET['categoryid'])) {
      	$itemObj->setVar('parentid', $_GET['categoryid']);
    } elseif($itemObj->isNew()) {
    	trigger_error('Category needs to be defined before creating an item', E_USER_WARNING);
    }
    if($fct == 'app' || $fct == 'rnw' || $itemObj->isNew()){
	    if($itemObj->getVar('status', 'n') != _SSHOP_STATUS_MODIFIED){
	    	$itemObj->setVar('mail_status', 0);
	    	if(!isset($xoopsModuleConfig['def_delay_exp'])|| intval($xoopsModuleConfig['def_delay_exp']) < 1 ){
	    		$delay = 365;
	    	}
	    	else{
	    		$delay = intval($xoopsModuleConfig['def_delay_exp']);
	    	}
	    	$itemObj->setVar('exp_date',(time() + $delay * 24*3600));
    	}

    }

	if($fct == 'app' && $itemObj->getVar('status', 'n') != _SSHOP_STATUS_MODIFIED){
    	$itemObj->setVar('date',time());
    }

	if($itemObj->isNew()){
		$itemObj->setVar('uid',$xoopsUser->getVar('uid'));
	}

    $itemObj->setVar('status', _SSHOP_STATUS_ONLINE);
    $itemObj->initiateCustomFields();

    if ($op == 'clone') {
		$itemObj->setNew();
		$itemObj->setVar('date', time());
		$itemObj->setVar('meta_description', '');
		$itemObj->setVar('meta_keywords', '');
		$itemObj->setVar('short_url', '');
		$itemObj->setVar('counter', 0);
		$itemObj->setVar('itemid', 0);
    }

    if ($itemObj->isNew()){
    	$breadcrumb = _AM_SSHOP_ITEMS . " > " . _AM_SSHOP_CREATINGNEW;
    	$title = _AM_SSHOP_ITEM_CREATE;
    	$info = _AM_SSHOP_ITEM_CREATE_INFO;
    	$collaps_name = 'itemcreate';
    	$form_name = _AM_SSHOP_ITEM_CREATE;
    	$submit_button_caption = null;
    }
    elseif ($fct == 'app') {
    	$breadcrumb = _AM_SSHOP_ITEMS . " > " . _AM_SSHOP_APPROVING;
    	$title = _AM_SSHOP_ITEM_APPROVE;
    	$info = _AM_SSHOP_ITEM_APPROVE_INFO;
    	$collaps_name = 'itemapprove';
    	$form_name = _AM_SSHOP_ITEM_APPROVE;
    	$submit_button_caption = _AM_SSHOP_ITEM_APPROVE_BUTT;
    }
    else {
    	$breadcrumb = _AM_SSHOP_ITEMS . " > " . _AM_SSHOP_EDITING;
    	$title = _AM_SSHOP_ITEM_EDIT;
    	$info = _AM_SSHOP_ITEM_EDIT_INFO;
    	$collaps_name = 'itemedit';
    	$form_name = _AM_SSHOP_ITEM_EDIT;
    	$submit_button_caption = null;
    }
    $catObj = $smartshop_category_handler->get($itemObj->getVar('parentid'));

    $itemObj->hideFieldFromForm('parentid');

	if($fct == 'app') $menuTab=1;
	elseif($fct == 'rnw') $menuTab=2;
	else $menuTab=0;

    if ($showmenu) {
        smart_adminMenu($menuTab, $breadcrumb);
    }
    echo "<br />\n";
    smart_collapsableBar($collaps_name, $title, $info);

    $sform = $itemObj->getForm($form_name, 'additem', false,  $submit_button_caption);
    if ($fct == 'app') {
   		$sform->addElement(new XoopsFormHidden('fct','app'));
    }
    if($op == 'clone'){
    	foreach($itemObj->getVars() as $name => $var){
			if($var['custom_field_type'] == 'image'){
				$sform->addElement(new XoopsFormHidden('clone_'.$name, $var['value']));
			}
		}
    }
    $sform->display();
    smart_close_collapsable($collaps_name);
}

include_once("admin_header.php");

$op = '';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
    case "mod":
    case "clone":
        $itemid = isset($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
		$fct = isset($_GET['fct']) ? $_GET['fct'] :'' ;
        smart_xoops_cp_header();
        edititem(true, $itemid, $fct);
        break;

    case "additem":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_item_handler);
        $itemObj = $controller->storeSmartObject();
        $fct = isset($_POST['fct']) ? $_POST['fct'] :'' ;

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
       		if(($customField->getVar('att_type', 'n') == 'file'
       				&& isset($_FILES['upload_'.$customField->getVar('name')]['name']) && $_FILES['upload_'.$customField->getVar('name')]['name'] != '')
       			|| $customField->getVar('att_type', 'n') == 'image'){
        		$item_attributObj->doUpload($itemObj);

        	}elseif($customField->getVar('att_type', 'n') == 'file' || $customField->getVar('att_type', 'n') == 'urllink'){
       			$item_attributObj->storeBasedURl($customField->getVar('att_type', 'n'));
       		}else{
				$item_attributObj->setType('value', $customField->getObjectType());
	        	$field_value = isset($_POST[$customField->getVar('name')]) ? $_POST[$customField->getVar('name')] : '';
	        	$item_attributObj->setVar('value', $field_value);
			}

	        if (!$smartshop_item_attribut_handler->insert($item_attributObj)) {
        		$itemObj->setErrors($item_attributObj->getErrors());
        	}

        	unset($item_attributObj);
        }

        if ($itemObj->hasError()) {
        	redirect_header($smart_previous_page, 3, _CO_SOBJECT_SAVE_ERROR . $itemObj->getHtmlErrors());
        } else {
        	if($fct == 'app'){
        		$itemObj->sendNotifications(array(_SSHOP_NOT_ADD_APPROVED, _SSHOP_NOT_ADD_PUBLISHED));
        	}
        		redirect_header(smart_get_page_before_form(), 3, _CO_SOBJECT_SAVE_SUCCESS);
        }
		exit;
        break;

    case "del":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_item_handler);
        $controller->handleObjectDeletion();
        break;

    case "default":
    default:

        smart_xoops_cp_header();

        smart_adminMenu(0, _AM_SSHOP_ITEMS);

        echo "<br />\n";
        echo "<form><div style=\"margin-bottom: 12px;\">";
        echo "<input type='button' name='button' onclick=\"location='item.php?op=mod'\" value='" . _AM_SSHOP_ITEM_CREATE . "'>&nbsp;&nbsp;";
        echo "<input type='button' name='button' onclick=\"location='category.php?op=mod'\" value='" . _CO_SOBJECT_CATEGORY_CREATE . "'>&nbsp;&nbsp;";
        echo "</div></form>";

        smart_collapsableBar('createditems', _AM_SSHOP_ITEMS, _AM_SSHOP_ITEMS_DSC);

        $criteria = new CriteriaCompo();

        include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
        $objectTable = new SmartObjectTable($smartshop_item_handler, $criteria);
        $objectTable->addColumn(new SmartObjectColumn('name', 'left'));
        $objectTable->addColumn(new SmartObjectColumn('counter', 'center', 100));
        $objectTable->addColumn(new SmartObjectColumn('status', 'center', 100));

        $objectTable->render();

        echo "<br />";
        smart_close_collapsable('createditems');
        echo "<br>";

        break;
}

smartshop_modFooter();
xoops_cp_footer();

?>