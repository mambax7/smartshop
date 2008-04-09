<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
function editcategory_attribut($showmenu = false, $categoryid, $attributid = 0)
{
	global $smartshop_category_attribut_handler, $smartshop_category_handler, $smartshop_item_handler, $smartshop_attribut_option_handler;

	$category_attributObj = $smartshop_category_attribut_handler->get($attributid);
	if(!$category_attributObj->isNew() && $categoryid == 0){
		$categoryid = $category_attributObj->getVar('parentid', 'e');
	}
	$category_attributObj->hideFieldFromForm(array('options', 'dependent_attributid', 'size'));
	if((isset($_POST['att_type']) && $_POST['att_type'] == 'select_multi' ) || $category_attributObj->getVar('att_type', 'n') == 'select_multi' ){
		$category_attributObj->showFieldOnForm('size');
		$category_attributObj->setVarInfo('att_default', 'size',0);
	}
	if (isset($_POST['op'])) {
		$controller = new SmartObjectController($smartshop_category_attribut_handler);
		$controller->postDataToObject($category_attributObj);

		if ($_POST['op'] == 'changedField') {

			switch($_POST['changedField']) {

				case 'att_type' :
					if (in_array($category_attributObj->getVar('att_type', 'n'), array('check', 'radio', 'select', 'select_multi'))) {
						$category_attributObj->showFieldOnForm(array('options', 'dependent_attributid'));
					}
				break;

				case 'dependent_attributid' :
					if (in_array($category_attributObj->getVar('att_type', 'n'), array('check', 'radio', 'select', 'select_multi'))) {
						$category_attributObj->showFieldOnForm(array('options', 'dependent_attributid'));
					}

					$category_attributObj->setControl('options', 'SmartshopDependencyFieldOptionsElement');
				break;

			}
		} elseif ($_POST['op'] == 'moreoptions') {

			// retreive the options already in POST
	    	$options_count = $_POST['options_count_options'];
	    	$aOptions = array();
	    	for ($i=0;$i<$options_count;$i++) {
	    		$aOptions[$i]['text'] = $_POST['option_text_options_' . $i];
	    		$aOptions[$i]['select'] = $_POST['option_select_options_' . $i];
	    	}
			$category_attributObj->setVar('options', $aOptions);
			$category_attributObj->showFieldOnForm(array('options', 'dependent_attributid'));
			$category_attributObj->setControl('options', array(
													'name' => 'SmartshopDependencyFieldOptionsElement',
													'moreoptions' => intval($_POST['more_options_options'])
												));
		}
	} elseif(!$category_attributObj->isNew()) {
		if (in_array($category_attributObj->getVar('att_type', 'n'), array('check', 'radio', 'select', 'select_multi'))) {
			//$category_attributObj->showFieldOnForm('options');
			//if ($category_attributObj->getVar('dependent_attributid') != 0) {
				$category_attributObj->makeFieldReadOnly('dependent_attributid');


			//}
		}
	}

	if($category_attributObj->isNew()) {
		$category_attributObj->hideFieldFromForm('att_default');
	}elseif (in_array($category_attributObj->getVar('att_type', 'n'), array('check', 'radio', 'select', 'select_multi', 'yes_no'))) {
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('attributid', $category_attributObj->id()));
		$criteria->setSort('weight');
		$criteria->setOrder('ASC');
		$optionArray = $smartshop_attribut_option_handler->getList($criteria, true);
		if(!empty($optionArray)){
			if($category_attributObj->getVar('att_type', 'n') == 'select'){
				$optionArray[''] = '---';
			}
			$value = $category_attributObj->getVar('att_default', 'n');
			$value = explode('|', $value);
			$category_attributObj->setControl('att_default', array('name' => $category_attributObj->getVar('att_type', 'n'),
																 'options' => $optionArray,
																 'value' => $value));
		}else{
			$category_attributObj->hideFieldFromForm('att_default');
		}
	}

    if ($category_attributObj->isNew()){
    	if($categoryid == 0){
    		$breadcrumb = _AM_SSHOP_CATEGORIES . " > " . _AM_SSHOP_GLBL_ATTRIBUT . " > " . _AM_SSHOP_CREATINGNEW;
	    	$title = _AM_SSHOP_GLBL_ATTRIBUT_CREATE;
	    	$info = _AM_SSHOP_GLBL_ATTRIBUT_CREATE_INFO;
	    	$collaps_name = 'category_attributcreate';
	    	$form_name = _AM_SSHOP_GLBL_ATTRIBUT_CREATE;
	    	$category_attributObj->hideFieldFromForm(array('checkoutdisp'));
	    	if ($showmenu) {
		        smart_adminMenu(1, $breadcrumb);
		    }
    	}elseif($categoryid == -1){
    		$breadcrumb = _AM_SSHOP_TRANSACTIONS . " > " . _AM_SSHOP_TRANS_ATTRIBUT . " > " . _AM_SSHOP_CREATINGNEW;
	    	$title = _AM_SSHOP_TRANS_ATTRIBUT_CREATE;
	    	$info = _AM_SSHOP_TRANS_ATTRIBUT_CREATE_INFO;
	    	$collaps_name = 'category_attributcreate';
	    	$form_name = _AM_SSHOP_TRANS_ATTRIBUT_CREATE;
	    	$category_attributObj->hideFieldFromForm(array('sortable', 'checkoutdisp' , 'searchable', 'summarydisp', 'searchdisp', 'unicity', 'custom_rendering', 'display', 'dependent_attributid'));
		   	if ($showmenu) {
		        smart_adminMenu(3, $breadcrumb);
		    }
    	}else{
	    	$breadcrumb = _AM_SSHOP_CATEGORIES . " > " . _AM_SSHOP_CAT_ATTRIBUT . " > " . _AM_SSHOP_CREATINGNEW;
	    	$title = _AM_SSHOP_CAT_ATTRIBUT_CREATE;
	    	$info = _AM_SSHOP_CAT_ATTRIBUT_CREATE_INFO;
	    	$collaps_name = 'category_attributcreate';
	    	$form_name = _AM_SSHOP_CAT_ATTRIBUT_CREATE;
	    	$category_attributObj->hideFieldFromForm(array('checkoutdisp'));
	    	if ($showmenu) {
		        smart_adminMenu(0, $breadcrumb);
		    }
    	}

    } else {
    	if($categoryid == -1){
    		$category_attributObj->hideFieldFromForm(array('sortable', 'searchable', 'summarydisp', 'searchdisp', 'unicity', 'custom_rendering', 'checkoutdisp', 'dependent_attributid'));
		}
    	$breadcrumb = _AM_SSHOP_CATEGORIES . " > " . _AM_SSHOP_CAT_ATTRIBUT . " > " . _AM_SSHOP_EDITING;
    	$title = _CO_SSHOP_CAT_ATTRIBUT_EDIT;
    	$info = _CO_SSHOP_CAT_ATTRIBUT_EDIT_INFO;
    	$collaps_name = 'category_attributedit';
    	$form_name = _CO_SSHOP_CAT_ATTRIBUT_EDIT;
    	$categoryid = $category_attributObj->getVar('parentid');
    	$category_attributObj->setVarInfo('display', 'form_caption', _AM_SSHOP_CH_OUT_ATTRIBUT_DISPLAY);
    	//'form_caption' => $form_caption,
    	if ($showmenu) {
	        smart_adminMenu(0, $breadcrumb);
	    }
    }
    $category_attributObj->setVar('parentid', $categoryid);


    echo "<br />\n";
    smart_collapsableBar($collaps_name, $title, $info);
//	smart_addAdminAjaxSupport();

	$xoopsTpl =& new XoopsTpl();

	//$category_attributObj->setAdvancedFormFields(array('name', 'options'));
    $sform = $category_attributObj->getForm($form_name, 'addcategory_attribut');

	if(!$category_attributObj->isNew()) {
		//code for type change
		$oldType = (isset($_POST['old_type']) && $_POST['old_type'] != '' )? $_POST['old_type']: $category_attributObj->getVar('att_type', 'n');
		$oldtypeHidden = new xoopsFormHidden('old_type', $oldType);

	    $oldtypeHidden->customValidationCode[] =
			"var oldType = '';
			var newType = '';
			var uncompatible = false;

			if(myform.old_type.value != myform.att_type.value && (myform.old_type.value == 'file' ||  myform.att_type.value == 'file' ||
			myform.old_type.value == 'urllink' ||  myform.att_type.value == 'urllink' ||
			myform.old_type.value == 'yes_no' ||  myform.att_type.value == 'yes_no' ||
			myform.old_type.value == 'image' ||  myform.att_type.value == 'image')
			){
				if(myform.att_default.value != ''){
	    			return confirm('"._CO_SSHOP_SET_DEFAULT."');
	    		}else{
	    			return confirm('"._CO_SSHOP_RESET_VALUES."');
	    		}
			}

			if(myform.old_type.value == 'check' || myform.old_type.value == 'select_multi'){
	    		oldType = 'multi';
	    	}else if(myform.old_type.value == 'radio' ||  myform.old_type.value == 'select'){
	    		oldType = 'single';
	    	}else{
	    		oldType = 'free';
	    	}
	    	if(myform.att_type.value == 'check' || myform.att_type.value =='select_multi'){
	    		newType = 'multi';
	    	}else if(myform.att_type.value == 'radio' ||  myform.att_type.value == 'select'){
	    		newType = 'single';
	    	}else{
	    		newType = 'free';
	    	}
	    	if((oldType != newType && !(oldType == 'single' && newType == 'multi')) ){
	    		if(myform.att_default.value != ''){
	    			return confirm('"._CO_SSHOP_SET_DEFAULT."');
	    		}else{
	    			return confirm('"._CO_SSHOP_RESET_VALUES."');
	    		}
	    	}
	    	";

		$sform->addElement($oldtypeHidden);
	    //end type change
	}

    $sform->assign($xoopsTpl, 'form');

    $xoopsTpl->display( 'db:smartobject_form.html' );

    smart_close_collapsable($collaps_name);

	if (!$category_attributObj->isNew()){
		smart_collapsableBar('attribut_options', _AM_SSHOP_ATTRIBUT_OPTIONS, _AM_SSHOP_ATTRIBUT_OPTIONS_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('attributid', $attributid));

		$objectTable = new SmartObjectTable($smartshop_attribut_option_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('caption', 'left'));
		if ($category_attributObj->getVar('dependent_attributid') != 0) {
			$objectTable->addColumn(new SmartObjectColumn('linked_attribut_option_id'));
		}
		$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
		$objectTable->addActionButton('updateOptions', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$objectTable->addIntroButton('additem', 'attribut_option.php?op=mod&attributid=' . $attributid, _AM_SSHOP_ATTRIBUT_OPTION_CREATE);

		//$objectTable->addCustomAction('getEditItemLink');

		$objectTable->render();

		smart_close_collapsable('attribut_options');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH . "class/smartobjectcontroller.php";
include_once SMARTOBJECT_ROOT_PATH . "class/smartobjecttable.php";

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
	case "mod":
	case "changedField";
	case "moreoptions";

		$attributid = isset($_GET['attributid']) ? intval($_GET['attributid']) : 0 ;
		$categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0 ;

		smart_xoops_cp_header();

		editcategory_attribut(true, $categoryid, $attributid);
		break;

	case "addcategory_attribut":

		$controller = new SmartObjectController($smartshop_category_attribut_handler);
        $redirect_url = SMARTSHOP_ADMIN_URL . "category.php?op=mod&categoryid=" . $_POST['parentid'];
		$category_attributObj = $controller->storeSmartObject();
        if ($category_attributObj->hasError()) {
        	redirect_header($smart_previous_page, 3, _CO_SOBJECT_SAVE_ERROR . $category_attributObj->getHtmlErrors());
        } else {
			redirect_header(smart_get_page_before_form(), 3, _CO_SOBJECT_SAVE_SUCCESS);
        }
        exit;
		break;

	case "del":
        $controller = new SmartObjectController($smartshop_category_attribut_handler);
		$controller->handleObjectDeletion();

		break;

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
			$attributobj->setVar('sortable', isset($_POST['sortable_' . $attributid]) ? intval($_POST['sortable_' . $attributid]) : 0);
			$attributobj->setVar('searchable', isset($_POST['searchable_' . $attributid]) ? intval($_POST['searchable_' . $attributid]) : 0);
			$attributobj->setVar('display', isset($_POST['display_' . $attributid]) ? intval($_POST['display_' . $attributid]) : 0);
			$attributobj->setVar('summarydisp', isset($_POST['summarydisp_' . $attributid]) ? intval($_POST['summarydisp_' . $attributid]) : 0);
			$attributobj->setVar('checkoutdisp', isset($_POST['checkoutdisp' . $attributid]) ? intval($_POST['checkoutdisp' . $attributid]) : 0);

			$smartshop_category_attribut_handler->insert($attributobj, true);
		}

		redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		break;

	case "updateOptions":
		if (!isset($_POST['SmartshopAttribut_option_objects']) || count($_POST['SmartshopAttribut_option_objects']) == 0) {
			redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_TO_UPDATE);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('optionid', '(' . implode(', ', $_POST['SmartshopAttribut_option_objects']) . ')', 'IN'));
		$optionsObj = $smartshop_attribut_option_handler->getObjects($criteria, true);
		foreach($optionsObj as $optionid=>$optionobj) {
			$optionobj->setVar('weight', isset($_POST['weight_' . $optionid]) ? intval($_POST['weight_' . $optionid]) : 0);
			$smartshop_attribut_option_handler->insert($optionobj);
		}

		redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		break;
	default:

		smart_xoops_cp_header();

		smart_adminMenu(1, _AM_SSHOP_GLOBAL_CSTMFLDS);


		smart_collapsableBar('createdcategory_attribut', _AM_SSHOP_CAT_ATTRIBUT, _AM_SSHOP_CAT_ATTRIBUT_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', 0));
		$objectTable = new SmartObjectTable($smartshop_category_attribut_handler, $criteria);
		$objectTable->addIntroButton('addglbl_att', 'category_attribut.php?op=mod', _AM_SSHOP_GLOBAL_ATT_CREATE);
		$objectTable->addColumn(new SmartObjectColumn('caption', 'left', false, _CO_SSHOP_CAT_ATTRIBUT_CAOPTION));
		$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
		$objectTable->addColumn(new SmartObjectColumn('required', 'center', 100, 'getRequiredControl'));
		$objectTable->addColumn(new SmartObjectColumn('sortable', 'center', 100, 'getSortableControl'));
		$objectTable->addColumn(new SmartObjectColumn('searchable', 'center', 100, 'getSearchableControl'));
		$objectTable->addColumn(new SmartObjectColumn('display', 'center', 100, 'getDisplayControl'));
		$objectTable->addColumn(new SmartObjectColumn('summarydisp', 'center', 100, 'getSummarydispControl'));
		$objectTable->addColumn(new SmartObjectColumn('checkoutdisp', 'center', 100, 'getCheckoutdispControl'));
		$objectTable->addActionButton('updateCustomFields', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdcategory_attribut');
		echo "<br>";

		break;
}

smartshop_modFooter();
xoops_cp_footer();

?>