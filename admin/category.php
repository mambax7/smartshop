<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editcategory($showmenu = false, $categoryid = 0, $parentid =0)
{
	global $smartshop_category_handler, $smartshop_category_attribut_handler, $smartshop_item_handler;
	$categoryObj = $smartshop_category_handler->get($categoryid);
	if($parentid){
		$categoryObj->setVar('parentid', $parentid);
	}
	if (!$categoryObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(0, _AM_SSHOP_CATEGORIES . " > " . _AM_SSHOP_EDITING);
		}
		smart_collapsableBar('categoryedit', _CO_SOBJECT_CATEGORY_EDIT, _CO_SOBJECT_CATEGORY_EDIT_INFO);

		$sform = $categoryObj->getForm(_CO_SOBJECT_CATEGORY_EDIT, 'addcategory');
		$sform->display();
		smart_close_collapsable('categoryedit');

		smart_collapsableBar('categoryattributs', _AM_SSHOP_CAT_ATTRIBUT, _AM_SSHOP_CAT_ATTRIBUT_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', $categoryid));

		$objectTable = new SmartObjectTable($smartshop_category_attribut_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('caption', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('description', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
		$objectTable->addColumn(new SmartObjectColumn('required', 'center', 100, 'getRequiredControl'));
		$objectTable->addColumn(new SmartObjectColumn('sortable', 'center', 100, 'getSortableControl'));
		$objectTable->addColumn(new SmartObjectColumn('searchable', 'center', 100, 'getSearchableControl'));
		$objectTable->addColumn(new SmartObjectColumn('display', 'center', 100, 'getDisplayControl'));
		$objectTable->addColumn(new SmartObjectColumn('summarydisp', 'center', 100, 'getSummarydispControl'));

		$objectTable->addActionButton('updateCustomFields', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$objectTable->addIntroButton('addcategory_attribut', 'category_attribut.php?op=mod&categoryid=' . $categoryid, _AM_SSHOP_CAT_ATTRIBUT_CREATE);

		$objectTable->render();

		smart_close_collapsable('categoryattributs');

		if($categoryObj->getVar('hasitem')){
			smart_collapsableBar('categoryitems', _AM_SSHOP_CATEGORY_ITEMS, _AM_SSHOP_CATEGORY_ITEMS_DSC);

			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('parentid', $categoryid));

			$objectTable = new SmartObjectTable($smartshop_item_handler, $criteria, array('delete'));
			$objectTable->addColumn(new SmartObjectColumn('name', 'left'));
			$objectTable->addColumn(new SmartObjectColumn('counter', 'center', 100));
			$objectTable->addColumn(new SmartObjectColumn('status', 'center', 100, 'getStatusControl'));
			$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
			$objectTable->addActionButton('updatePages', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');


			$objectTable->addIntroButton('additem', 'item.php?op=mod&categoryid=' . $categoryid, _AM_SSHOP_ITEM_CREATE);


			$objectTable->addCustomAction('getEditItemLink');

			$objectTable->render();

			smart_close_collapsable('categoryitems');
		}

		smart_collapsableBar('subcategories', _AM_SSHOP_CATEGORY_SUBCATS, _AM_SSHOP_CATEGORY_SUBCATS_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', $categoryid));

		$objectTable = new SmartObjectTable($smartshop_category_handler, $criteria, array('delete'));
		$objectTable->addColumn(new SmartObjectColumn('name', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('description', 'left'));


		$objectTable->addIntroButton('addsubcat', 'category.php?op=mod&parentid=' . $categoryid, _AM_SSHOP_SUBCAT_CREATE);

		$objectTable->addCustomAction('getEditItemLink');

		$objectTable->render();

		smart_close_collapsable('subcategories');
	} else {
		if ($showmenu) {
			smart_adminMenu(0, _AM_SSHOP_CATEGORIES . " > " . _AM_SSHOP_CREATINGNEW);
		}

		smart_collapsableBar('categorycreate', _AM_SSHOP_CATEGORY_CREATE, _AM_SSHOP_CATEGORY_CREATE_INFO);
		$sform = $categoryObj->getForm(_AM_SSHOP_CATEGORY_CREATE, 'addcategory');
		$sform->display();
		smart_close_collapsable('categorycreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
	case "mod":

		$categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0 ;
		$parentid = isset($_GET['parentid']) ? intval($_GET['parentid']) : 0 ;

		smart_xoops_cp_header();

		editcategory(true, $categoryid, $parentid);
		break;

	case "listitems":

		smart_xoops_cp_header();
		smart_adminMenu(0, _AM_SSHOP_CATEGORIES . " > " . _AM_SSHOP_LISTING_ITEMS);

		$categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0 ;
		$categoryObj =& $smartshop_category_handler->get($categoryid);

		smart_collapsableBar('categorylistitems', sprintf(_AM_SSHOP_CATEGORY_LIST_ITEMS, $categoryObj->getVar('name')), _AM_SSHOP_CATEGORY_ITEMS_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', $categoryid));
		$criteria->setSort('weight');
		$criteria->setOrder('ASC');
		$objectTable = new SmartObjectTable($smartshop_item_handler, $criteria, array('delete'));
		$objectTable->addIntroButton('export', 'category.php?op=export&categoryid='.$categoryid, _AM_SSHOP_EXPORT);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('uid', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('date', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('counter', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('status', 'center', 100, 'getStatusControl'));
		$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
		if($categoryObj->getVar('hasitem')){
			$objectTable->addIntroButton('additem', 'item.php?op=mod&categoryid=' . $categoryid, _AM_SSHOP_ITEM_CREATE);
		}
		$objectTable->addCustomAction('getPageCloneActionLink');
       	$objectTable->addCustomAction('getEditItemLink');

       	$objectTable->addActionButton('updatePages', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$objectTable->addFilter('uid', 'getSellers');
		$objectTable->setDefaultFilter('uid');

		$objectTable->render();

		smart_close_collapsable('categorylistitems');

				smart_collapsableBar('categoryattributs', _AM_SSHOP_CAT_ATTRIBUT, _AM_SSHOP_CAT_ATTRIBUT_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', $categoryid));

		$objectTable = new SmartObjectTable($smartshop_category_attribut_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('caption', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('description', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
		$objectTable->addColumn(new SmartObjectColumn('required', 'center', 100, 'getRequiredControl'));
		$objectTable->addColumn(new SmartObjectColumn('sortable', 'center', 100, 'getSortableControl'));
		$objectTable->addColumn(new SmartObjectColumn('searchable', 'center', 100, 'getSearchableControl'));
		$objectTable->addColumn(new SmartObjectColumn('display', 'center', 100, 'getDisplayControl'));
		$objectTable->addColumn(new SmartObjectColumn('summarydisp', 'center', 100, 'getSummarydispControl'));
		$objectTable->addActionButton('updateCustomFields', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$objectTable->addIntroButton('addcategory_attribut', 'category_attribut.php?op=mod&categoryid=' . $categoryid, _AM_SSHOP_CAT_ATTRIBUT_CREATE);

		$objectTable->render();

		smart_close_collapsable('categoryattributs');

		break;

	case "updatePages":
		if (!isset($_POST['SmartshopItem_objects']) || count($_POST['SmartshopItem_objects']) == 0) {
			redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_TO_UPDATE);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('itemid', '(' . implode(', ', $_POST['SmartshopItem_objects']) . ')', 'IN'));
		$itemsObj = $smartshop_item_handler->getObjects($criteria, true);
		foreach($itemsObj as $itemid=>$itemobj) {
			$itemobj->setVar('weight', isset($_POST['weight_' . $itemid]) ? intval($_POST['weight_' . $itemid]) : 0);
			$itemobj->setVar('status', isset($_POST['status_' . $itemid]) ? intval($_POST['status_' . $itemid]) : 0);
			$smartshop_item_handler->insert($itemobj);
		}
			redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		break;

	case "updateCat":
		if (!isset($_POST['SmartshopCategory_objects']) || count($_POST['SmartshopCategory_objects']) == 0) {
			redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_TO_UPDATE);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('categoryid', '(' . implode(', ', $_POST['SmartshopCategory_objects']) . ')', 'IN'));
		$categoriesObj = $smartshop_category_handler->getObjects($criteria, true);
		foreach($categoriesObj as $categoryid=>$categoryObj) {
			$categoryObj->setVar('weight', isset($_POST['weight_' . $categoryid]) ? intval($_POST['weight_' . $categoryid]) : 0);
			$categoryObj->setVar('searchable', isset($_POST['searchable_' . $categoryid]) ? intval($_POST['searchable_' . $categoryid]) : 0);
			$smartshop_category_handler->insert($categoryObj);
		}
			redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

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

			$smartshop_category_attribut_handler->insert($attributobj);
		}

		redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		break;

	case "addcategory":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_category_handler);
		$controller->storeFromDefaultForm(_CO_SOBJECT_CATEGORY_CREATE_SUCCESS, _CO_SOBJECT_CATEGORY_MODIFY_SUCCESS);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_category_handler);
		$controller->handleObjectDeletion();

		break;

	case "export":

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid',$_GET['categoryid']));


		include_once(SMARTSHOP_ROOT_PATH . 'class/smartshopexport.php');
		$smartObjectExport = new SmartShopExport($smartshop_item_handler, $criteria);
		$smartObjectExport->setNotDisplayFields(array('currency','weight', 'dohtml', 'dosmiley', 'doxcode', 'doimage', 'dobr', 'meta_keywords', 'meta_description', 'short_url'));
		$smartObjectExport->setOuptutMethods(array('uid' => 'uidForExp', 'parentid' => 'categoryid'));
		$smartObjectExport->render();
		exit;

	break;

	default:

		smart_xoops_cp_header();

		smart_adminMenu(0, _AM_SSHOP_CATEGORIES);

		smart_collapsableBar('createdcategories', _AM_SSHOP_CATEGORIES, _AM_SSHOP_CATEGORIES_DSC);
//$smartshop_item_attribut_handler->clean();
		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttreetable.php";

		$objectTable = new SmartObjectTreeTable($smartshop_category_handler);

		$objectTable->addIntroButton('addcat', 'category.php?op=mod', _AM_SSHOP_CATEGORY_CREATE);
		$objectTable->addIntroButton('addglbl_att', 'category_attribut.php?op=mod', _AM_SSHOP_GLOBAL_ATT_CREATE);

		$objectTable->addColumn(new SmartObjectColumn('name', 'left', false, "getListItemsLink"));
		$objectTable->addCustomAction('getCreateItemLink');
		$objectTable->addCustomAction('getCreateAttributLink');
		$objectTable->addColumn(new SmartObjectColumn('weight', 'center', 100, 'getWeightControl'));
		$objectTable->addColumn(new SmartObjectColumn('searchable', 'center', 100, 'getSearchableControl'));
		$objectTable->addActionButton('updateCat', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdcategories');
		echo "<br>";

		break;
}

smartshop_modFooter();
xoops_cp_footer();

?>