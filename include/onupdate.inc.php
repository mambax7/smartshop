<?php

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

global $modversion;
if( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	// referer check
	$ref = xoops_getenv('HTTP_REFERER');
	if( $ref == '' || strpos( $ref , XOOPS_URL.'/modules/system/admin.php' ) === 0 ) {
		/* module specific part */



		/* General part */

		// Keep the values of block's options when module is updated (by nobunobu)
		include dirname( __FILE__ ) . "/updateblock.inc.php" ;

	}
}

function xoops_module_update_smartshop($module) {

	include_once(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname') . "/include/functions.php");
	include_once(XOOPS_ROOT_PATH . "/modules/smartobject/class/smartdbupdater.php");

	$dbupdater = new SmartobjectDbupdater();

    ob_start();

    $dbVersion  = smart_GetMeta('version', 'smartshop');
    if (!$dbVersion) {
    	$dbVersion = 0;
    }

	echo "<code>" . _SDU_UPDATE_UPDATING_DATABASE . "<br />";

	smartshop_create_upload_folders();

    // db migrate version = 2
    $newDbVersion = 2;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

		// Adding transaction table
	    $table = new SmartDbTable('smartshop_transaction');
	    if (!$table->exists()) {
	    	$table->setStructure("`transactionid` int(11) NOT NULL auto_increment,
						  `tran_date` int(11) NOT NULL default '0',
						  `tran_status` int(1) NOT NULL default '-1',
						  `itemid` int(11) NOT NULL default '0',
						  `tran_uid` int(11) NOT NULL default '0',
						  `price` float NOT NULL default '0',
						  `currency` varchar(100) NOT NULL default '',
						  PRIMARY KEY  (`transactionid`)");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
		unset($table);

		// Adding custom_css field in smartshop_page
	    $table = new SmartDbTable('smartshop_attribut_option');
	    if (!$table->fieldExists('linked_attribut_option_id')) {
	    	$table->addNewField('linked_attribut_option_id', "INT(1) default '0'");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
		unset($table);

		// Adding custom_css field in smartshop_page
	    $table = new SmartDbTable('smartshop_attribut_option');
	    if ($table->fieldExists('attrinbutid')) {
	    	$table->addAlteredField('attrinbutid', "INT( 11 ) NOT NULL DEFAULT '0'", 'attributid');
	    }
	}

	    // db migrate version = 3
    $newDbVersion = 3;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

		$table = new SmartDbTable('smartshop_category_attribut');
	    if (!$table->fieldExists('summarydisp')) {
	    	$table->addNewField('summarydisp', "TINYINT(1) default '0'");
	    	$table->addNewField('custom_rendering', "TEXT NOT NULL");
	    	$table->addNewField('size', "INT( 11 ) NOT NULL DEFAULT '0'");
	    	$table->addNewField('unicity', "TINYINT( 1 ) NOT NULL DEFAULT '0'");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
		unset($table);


	$table = new SmartDbTable('smartshop_category');
	    if (!$table->fieldExists('searchable')) {
	    	$table->addNewField('searchable', "TINYINT(1) default '0'");
	    	$table->addNewField('template', "VARCHAR(20) default 'default'");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
		unset($table);

	$table = new SmartDbTable('smartshop_attribut_option');
	    if (!$table->fieldExists('weight')) {
	    	$table->addNewField('weight', "TINYINT(1) default '0'");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
		unset($table);

	}


	echo "</code>";

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    }
    else {
        echo $feedback;
    }
	 smart_SetMeta("version", $newDbVersion, "smartshop"); //Set meta version to current
	return true;
}

function xoops_module_install_smartshop($module) {

    ob_start();

	include_once(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname') . "/include/functions.php");

	smartshop_create_upload_folders();

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    }
    else {
        echo $feedback;
    }

	return true;
}


?>