<?php
/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once('header.php');

$itemid = isset($_POST['itemid']) ? intval($_POST['itemid']) : 0;

$op = isset($_POST['op']) ? $_POST['op'] : false;

// Creating the item object for the selected itemid
$itemObj = $smartshop_item_handler->get($itemid);

// if the selected item is new, it means that this itemid was not found, OR if the item is not active, exit
if ($itemObj->isNew() || ($itemObj->getVar('status','n') != _SSHOP_STATUS_ONLINE && !$can_edit)) {
    redirect_header(SMARTSHOP_URL, 1, _MD_SSHOP_PAGE_NOT_FOUND);
    exit();
}

// Checking if registered user
if (!is_object($xoopsUser)) {
    redirect_header(SMARTSHOP_URL, 1, _NOPERM);
    exit();
}

$quantity = isset($_POST['quantity']) && intval($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$item_price = $itemObj->getVar('price');
$total_cost = $item_price * $quantity;
$enough_credit = $credits_balance > $total_cost;
if (!$enough_credit) {
	redirect_header($itemObj->getItemLink(true), 4, _MD_SSHOP_NOT_ENOUGH_CREDIT_FOR_QUANTITY);
    exit();
}

if (!isset($_SESSION['smartshop_buy']) || !$_SESSION['smartshop_buy']) {
	redirect_header(SMARTSHOP_URL, 1, _MD_SSHOP_PAGE_NOT_FOUND);
    exit();
}

$xoopsOption['template_main'] = 'smartshop_buy.html';
include_once(XOOPS_ROOT_PATH . "/header.php");

// Setting a flag to mark that the user is buying something now, so he cannot refresh
$_SESSION['smartshop_buy'] = false;

// store the transaction
$transactionObj = $smartshop_transaction_handler->create();
$transactionObj->setVar('tran_date', time());
$transactionObj->setVar('tran_uid', $xoopsUser->uid());
$transactionObj->setVar('itemid', $itemid);
$transactionObj->setVar('price', $itemObj->getVar('price'));
$transactionObj->setVar('currency', $itemObj->getVar('currency'));
$transactionObj->setVar('quantity', $quantity);

if (!$smartshop_transaction_handler->insert($transactionObj)) {
	$xoopsTpl->append('errorMessages', _MD_SSHOP_TRANSACTION_ERROR);
} else {
	$xoopsTpl->append('infoMessages', _MD_SSHOP_TRANSACTION_SUCCESS);
}

$xoopsTpl->assign('item', $itemObj->toArray());

$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
$xoopsTpl->assign('categoryPath', _MD_SSHOP_BUY);

include_once(SMARTSHOP_ROOT_PATH . "footer.php");
include_once(XOOPS_ROOT_PATH . '/footer.php');
?>