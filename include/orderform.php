<?php
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";



$sform = new XoopsThemeForm(_MD_SSHOP_ORDER_FORM , "form", XOOPS_URL."/modules/smartshop/transaction.php", 'POST');

$name = is_object($xoopsUser) && $xoopsUser->getVar('name') != '' ? $xoopsUser->getVar('name') : '';
$email = is_object($xoopsUser) && $xoopsUser->getVar('email') != '' ? $xoopsUser->getVar('email') : '';
$address = is_object($xoopsUser) && $xoopsUser->getVar('user_from') != '' ? $xoopsUser->getVar('user_from') : '';

// Name
$name_text = new XoopsFormText(_MD_SSHOP_ORDER_NAME, 'name', 30, 255, $name);
$sform->addElement($name_text, true);

// Email
$email_text = new XoopsFormText(_MD_SSHOP_ORDER_EMAIL, 'email', 30, 255, $email);
$sform->addElement($email_text, true);


//Address
$address_text = new XoopsFormTextArea(_MD_SSHOP_ORDER_ADDRESS, 'address', $address);
$sform->addElement($address_text, true);

$button_tray = new XoopsFormElementTray('', '');

$hidden = new XoopsFormHidden('op', 'proceed');
$button_tray->addElement($hidden);

$butt_order = new XoopsFormButton('', 'post', _MD_SSHOP_ORDER, 'submit');
//$butt_search->setExtra('onclick="this.form.elements.op.value=\'proceed\'"');
$button_tray->addElement($butt_order);

$sform->addElement($button_tray);

$sform->assign($xoopsTpl);

?>
