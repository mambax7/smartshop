<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

function new_sellers_show ($options)
{

	include_once(XOOPS_ROOT_PATH."/modules/smartshop/expire.php");
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/common.php");


	$smartshop_item_handler =& xoops_getmodulehandler('item', 'smartshop');
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('status', _SSHOP_STATUS_ONLINE));
	$itemsObj = $smartshop_item_handler->getObjects($criteria);


	$member_handler =& xoops_gethandler('member');
	$sellers = $member_handler->getUsersByGroup(4, true);
	//var_dump($sellers);exit;
	$total = sizeof($sellers)-1;
	$start = $total > 5 ? $total-5 : 0;
	If ($sellers) {

		for ( $i = $total; $i > $start; $i-- ) {
			$add = true;
			//vérifier si le user n'est pas un doublon
			foreach($block['sellers'] as $blockSeller){
				if($sellers[$i]->uname() == $blockSeller['name']){
					$add = false;
					$start > 0 ? $start-- : $start=0 ;
				}
			}
			if($add){
				$add = false;
				//vérifier s'il a au moins un item en ligne
				foreach($itemsObj as $onLineItems){
					if($sellers[$i]->uid() == $onLineItems->getVar('uid', 'e')){
						$add = true;

					}
				}
				if(!$add){
					$start > 0 ? $start-- : $start=0 ;
				}
			}

			if($add){
				$seller= array();
	            $seller['name'] = $sellers[$i]->uname();
	            $seller['link'] = XOOPS_URL."/userinfo.php?uid=".$sellers[$i]->uid();
	            $block['sellers'][] = $seller;
	            unset($seller);
			}

		}
	}

	return $block;
}

function new_sellers_edit($options)
{
   /*global $xoopsDB, $xoopsModule, $xoopsUser;
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/functions.php");

	$form = smartshop_createCategorySelect($options[0]);

    $form .= "&nbsp;<br>" . _MB_SSHOP_ORDER . "&nbsp;<select name='options[]'>";

    $form .= "<option value='datesub'";
    if ($options[1] == "datesub") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ($options[1] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_HITS . "</option>\n";

    $form .= "<option value='weight'";
    if ($options[1] == "weight") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_SSHOP_WEIGHT . "</option>\n";

    $form .= "</select>\n";

    $form .= "&nbsp;" . _MB_SSHOP_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_SSHOP_ITEMS . "";

    return $form;*/
}

?>