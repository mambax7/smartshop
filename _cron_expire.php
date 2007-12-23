<?php
/* TODO
 * retravailler les reègles autour de la préférence de notification d'expiration
 */
	include"header.php";

	//items à expirer
	$zerojours = time();
	$id_array_0 = array();
	$sql0 = 'SELECT itemid FROM '.$xoopsDB->prefix('smartshop_item').'
				WHERE exp_date < '.$zerojours.'
	        	AND mail_status = 2 AND no_exp = 0';
	$result_0 = $xoopsDB->query($sql0);

	if($result_0){
		while($myrow = $xoopsDB->fetchArray($result_0)){
			$id_array_0[] = $myrow['itemid'];
		}

	}
	if(!empty($id_array_0)){
		$smartshop_item_handler->sendExpirationNotice($id_array_0, 3);
	}
	//items 7 jours
	$septjours = time()+(7*24*3600);
	$id_array_7 = array();
	$sql7 = 'SELECT itemid FROM '.$xoopsDB->prefix('smartshop_item').'
				WHERE exp_date < '.$septjours.'
	        	AND mail_status = 1  AND no_exp = 0';
	$result_7 = $xoopsDB->query($sql7);

	if($result_7){
		while($myrow = $xoopsDB->fetchArray($result_7)){
			$id_array_7[] = $myrow['itemid'];
		}

	}
	if(!empty($id_array_7)){
		$smartshop_item_handler->sendExpirationNotice($id_array_7, 2);
	}

	//items 30 jours
	$trentejours = time()+(30*24*3600);
	$id_array_30 = array();
	$sql30 = 'SELECT itemid FROM '.$xoopsDB->prefix('smartshop_item').'
				WHERE exp_date < '.$trentejours.'
	        	AND mail_status = 0  AND no_exp = 0';
	$result_30 = $xoopsDB->query($sql30);

	if($result_30){
		while($myrow = $xoopsDB->fetchArray($result_30)){
			$id_array_30[] = $myrow['itemid'];
		}

	}
	if(!empty($id_array_30)){
		$smartshop_item_handler->sendExpirationNotice($id_array_30, 1);
	}
?>
