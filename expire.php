<?php
//get smartshop module config
if(!isset($xoopsModuleConfig)){
	$modhandler =& xoops_gethandler('module');
	$config_handler  =& xoops_gethandler('config');
    $xoopsModule =& $modhandler->getByDirname('smartshop');
	$xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
}

//On execute ce script si la config 'exp_manageby_cron' est à false et nous sommes dans xoops
if(!$xoopsModuleConfig['exp_manageby_cron']){
	$xoopsDB =& Database::getInstance();

	//vérification du dernier check
	$sql = 'SELECT last_check FROM '.$xoopsDB->prefix('smartshop_meta');
	$result = $xoopsDB->queryF($sql);
	if($result){
		 while ($myrow = $xoopsDB->fetchArray($result)) {
		 	$last_check = $myrow['last_check'];
		 }
	}
	//pas de check si 6 heures ou moins
	if(time() - $last_check > (3600*6)){

		//update des items expirés
		$sql2 = 'UPDATE '.$xoopsDB->prefix('smartshop_item').'
					SET status = 0
		        	WHERE exp_date < '.time().'
		        	AND status = 3 ';
		$result = $xoopsDB->queryF($sql2);

		//update du last check
		$sql3 = 'UPDATE '.$xoopsDB->prefix('smartshop_meta').'
					SET last_check = '.time();
		$result = $xoopsDB->queryF($sql3);
	}

}

?>