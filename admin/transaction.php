<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function edittransaction($showmenu = false, $transactionid = 0, $parentid =0)
{
	global $smartshop_transaction_handler;

	$transactionObj = $smartshop_transaction_handler->get($transactionid);

	if (!$transactionObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(2, _AM_SSHOP_TRANSACTIONS . " > " . _CO_SOBJECT_EDITING);
		}
		smart_collapsableBar('transactionedit', _AM_SSHOP_TRANSACTION_EDIT, _AM_SSHOP_TRANSACTION_EDIT_INFO);

		$sform = $transactionObj->getForm(_AM_SSHOP_TRANSACTION_EDIT, 'addtransaction');
		$sform->display();
		smart_close_collapsable('transactionedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(2, _AM_SSHOP_TRANSACTIONS . " > " . _CO_SOBJECT_CREATINGNEW);
		}

		smart_collapsableBar('transactioncreate', _AM_SSHOP_TRANSACTION_CREATE, _AM_SSHOP_TRANSACTION_CREATE_INFO);
		$sform = $transactionObj->getForm(_AM_SSHOP_TRANSACTION_CREATE, 'addtransaction');
		$sform->display();
		smart_close_collapsable('transactioncreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$transactionid = isset($_GET['transactionid']) ? intval($_GET['transactionid']) : 0 ;

switch ($op) {

	case "export":
		if (!isset($_POST['createdtransactions_objects']) || count($_POST['createdtransactions_objects']) == 0) {
			redirect_header($smart_previous_page, 3);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('transactionid', '(' . implode(', ', $_POST['createdtransactions_objects']) . ')', 'IN'));

		include_once(SMARTOBJECT_ROOT_PATH . 'class/smartexport.php');
		$fields = array(
			'transactionid',
			'tran_date',
			'itemid',
			'price',
			'quantity',
			'uname',
			'vendor_adp'
		);
		$smartObjectExport = new SmartObjectExport($smartshop_transaction_handler, $criteria, $fields);
		$smartObjectExport->render();
		exit;

	break;

	case "mod":

		smart_xoops_cp_header();

		edittransaction(true, $transactionid, $parentid);
		break;

	case "addtransaction":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_transaction_handler);
		$controller->storeFromDefaultForm(_AM_SSHOP_TRANSACTION_CREATED, _AM_SSHOP_TRANSACTION_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartshop_transaction_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :

		$transactionObj = $smartshop_transaction_handler->get($transactionid);
		smart_xoops_cp_header();

		$transaction_title = _CO_SSHOP_TRANS_TRANSACTIONID . ' - ' . $transactionObj->getVar('transactionid', 'e');

		smart_adminMenu(2, _AM_SSHOP_TRANSACTION_VIEW . ' > ' . $transaction_title);

		smart_collapsableBar('transactionview', $transaction_title . ' ' . $transactionObj->getEditItemLink(), _AM_SSHOP_TRANSACTION_VIEW_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjectsingleview.php";
		$singleview = new SmartObjectSingleView($transactionObj);
		$singleview->addRow(new SmartObjectRow('transactionid'));
		$singleview->addRow(new SmartObjectRow('tran_date'));
		$singleview->addRow(new SmartObjectRow('itemid', 'getItemidLink'));
		$singleview->addRow(new SmartObjectRow('tran_uid'));
		$singleview->addRow(new SmartObjectRow('price'));
		$singleview->addRow(new SmartObjectRow('quantity'));
		$singleview->render($fetchOnly);

		echo "<br />";
		smart_close_collapsable('transactionview');
		echo "<br>";

		break;



		break;

	case 'with_selected_actions':
		if($_POST["selected_action"] == 'delete_sel'){
			smart_xoops_cp_header();
			smart_adminMenu(2, _AM_SSHOP_TRANSACTIONS);

			echo "Delete";
			break;
		}elseif($_POST["selected_action"] == 'export_sel'){
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('transactionid', '(' . implode(', ', $_POST['selected_smartobjects']) . ')', 'IN'));

				include_once(SMARTSHOP_ROOT_PATH . 'class/smartshopexport.php');
				$fields = array(
					'transactionid',
					'tran_date',
					'itemid',
					'price',
					'quantity',
					'uname',
					'vendor_adp'
				);
				$smartObjectExport = new SmartShopExport($smartshop_transaction_handler, $criteria, $fields);
				$smartObjectExport->render();
				exit;
			break;
		}


	default:

		smart_xoops_cp_header();

		smart_adminMenu(2, _AM_SSHOP_TRANSACTIONS);

		smart_collapsableBar('createdtransactions', _AM_SSHOP_TRANSACTIONS, _AM_SSHOP_TRANSACTIONS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		unset($criteria);
		$criteria = new CriteriaCompo();
		$criteria->setSort('trans_date');
		$criteria->setOrder('DESC');
		$objectTable = new SmartObjectTable($smartshop_transaction_handler, $criteria, array('delete'));
		$objectTable->addWithSelectedActions(array('delete_sel' => _CO_SOBJECT_DELETE, 'export_sel'=>_CO_SOBJECT_EXPORT));
		$objectTable->setTableId('createdtransactions');
		$objectTable->addColumn(new SmartObjectColumn('tran_date', 'center', 175));
		//$objectTable->addColumn(new SmartObjectColumn('tran_uid', 'left', 150));
		//$objectTable->addColumn(new SmartObjectColumn('price', 'center', 100));

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', -1));
		$custom_fields = $smartshop_category_attribut_handler->getObjects($criteria);

		foreach($custom_fields as $custom_field){
			if($custom_field->getVar('att_type', 'e') != 'form_section' && $custom_field->getVar('display')){
				$objectTable->addColumn(new SmartObjectColumn($custom_field->getVar('name'), 'center', 100, false, false, $custom_field->getVar('caption')));
			}
		}

		$objectTable->addActionButton('export', _SUBMIT, _CO_SOBJECT_EXPORT);

		$objectTable->render();
		unset($criteria);
		echo "<br />";
		smart_close_collapsable('createdtransactions');
		echo "<br>";


		break;
}

smart_modFooter();
xoops_cp_footer();

?>