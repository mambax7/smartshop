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

include_once XOOPS_ROOT_PATH.'/modules/smartshop/include/common.php';

function smartshop_create_upload_folders()
{
	$handlers_array = array('category', 'item');
	foreach($handlers_array as $item) {
		$hanlder =& xoops_getmodulehandler($item, 'smartshop');
		smart_admin_mkdir($hanlder->getImagePath());
	}
}


function smartshop_getAllCategoriesObj() {

	static $smartshop_allCategoriesObj;
	if (!isset($smartshop_allCategoriesObj)) {

		global $smartshop_category_handler;

		if (!isset($smartshop_category_handler)) {
			$smartshop_category_handler =& xoops_getmodulehandler('category', 'smartshop');
		}
		$smartshop_allCategoriesObj = $smartshop_category_handler->getObjects(null, true);
	}
	return $smartshop_allCategoriesObj;
}

function smartshop_getOrderBy($sort)
{
	if ($sort == "datesub") {
		return "DESC";
	} elseif ($sort == "counter") {
		return "DESC";
	} elseif ($sort == "weight") {
		return "ASC";
	}
}
/**
 * Detemines if a table exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @return bool True if table exists, false if not
 *
 * @access public
 * @author xhelp development team
 */
function smartshop_TableExists($table)
{

	$bRetVal = false;
	//Verifies that a MySQL table exists
	$xoopsDB =& Database::getInstance();
	$realname = $xoopsDB->prefix($table);
	$ret = mysql_list_tables(XOOPS_DB_NAME, $xoopsDB->conn);
	while (list($m_table)=$xoopsDB->fetchRow($ret)) {

		if ($m_table ==  $realname) {
			$bRetVal = true;
			break;
		}
	}
	$xoopsDB->freeRecordSet($ret);
	return ($bRetVal);
}
/**
 * Gets a value from a key in the xhelp_meta table
 *
 * @param string $key
 * @return string $value
 *
 * @access public
 * @author xhelp development team
 */
function smartshop_GetMeta($key)
{
	$xoopsDB =& Database::getInstance();
	$sql = sprintf("SELECT metavalue FROM %s WHERE metakey=%s", $xoopsDB->prefix('smartshop_meta'), $xoopsDB->quoteString($key));
	$ret = $xoopsDB->query($sql);
	if (!$ret) {
		$value = false;
	} else {
		list($value) = $xoopsDB->fetchRow($ret);

	}
	return $value;
}

/**
 * Sets a value for a key in the xhelp_meta table
 *
 * @param string $key
 * @param string $value
 * @return bool TRUE if success, FALSE if failure
 *
 * @access public
 * @author xhelp development team
 */
function smartshop_SetMeta($key, $value)
{
	$xoopsDB =& Database::getInstance();
	if($ret = smartshop_GetMeta($key)){
		$sql = sprintf("UPDATE %s SET metavalue = %s WHERE metakey = %s", $xoopsDB->prefix('smartshop_meta'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
	} else {
		$sql = sprintf("INSERT INTO %s (metakey, metavalue) VALUES (%s, %s)", $xoopsDB->prefix('smartshop_meta'), $xoopsDB->quoteString($key), $xoopsDB->quoteString($value));
	}
	$ret = $xoopsDB->queryF($sql);
	if (!$ret) {
		return false;
	}
	return true;
}

function smartshop_highlighter ($matches) {

	$smartShopConfig =& smartshop_getModuleConfig();
	$color = $smartShopConfig['highlight_color'];
	if(substr($color,0,1)!='#') {
		$color='#'.$color;
	}
	return '<span style="font-weight: bolder; background-color: '.$color.';">' . $matches[0] . '</span>';
}

// Thanks to Mithrandir :-)
function smartshop_substr($str, $start, $length, $trimmarker = '...')
{
	// If the string is empty, let's get out ;-)
	if ($str == '') {
		return $str;
	}

	// reverse a string that is shortened with '' as trimmarker
	$reversed_string = strrev(xoops_substr($str, $start, $length, ''));

	// find first space in reversed string
	$position_of_space = strpos($reversed_string, " ", 0);

	// truncate the original string to a length of $length
	// minus the position of the last space
	// plus the length of the $trimmarker
	$truncated_string = xoops_substr($str, $start, $length-$position_of_space+strlen($trimmarker), $trimmarker);

	return $truncated_string;
}

function smartshop_getConfig($key)
{
	$configs = smartshop_getModuleConfig();
	return $configs[$key];
}

function smartshop_metagen_html2text($document)
{
	// PHP Manual:: function preg_replace
	// $document should contain an HTML document.
	// This will remove HTML tags, javascript sections
	// and white space. It will also convert some
	// common HTML entities to their text equivalent.
	// Credits : newbb2

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
	"'<img.*?/>'si",       // Strip out img tags
	"'<[\/\!]*?[^<>]*?>'si",          // Strip out HTML tags
	"'([\r\n])[\s]+'",                // Strip out white space
	"'&(quot|#34);'i",                // Replace HTML entities
	"'&(amp|#38);'i",
	"'&(lt|#60);'i",
	"'&(gt|#62);'i",
	"'&(nbsp|#160);'i",
	"'&(iexcl|#161);'i",
	"'&(cent|#162);'i",
	"'&(pound|#163);'i",
	"'&(copy|#169);'i",
	"'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
	"",
	"",
	"\\1",
	"\"",
	"&",
	"<",
	">",
	" ",
	chr(161),
	chr(162),
	chr(163),
	chr(169),
	"chr(\\1)");

	$text = preg_replace($search, $replace, $document);
	return $text;
}

function smartshop_getAllowedImagesTypes()
{
	return array('jpg/jpeg', 'image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png', 'image/pjpeg');
}


function smartshop_module_home($withLink=true)
{
	global $smartshop_moduleName, $xoopsModuleConfig;
	if(!$xoopsModuleConfig['show_mod_name_breadcrumb']){
		return	'';
	}
	if (!$withLink)	{
		return $smartshop_moduleName;
	} else {
		return '<a href="' . SMARTSHOP_URL . '">' . $smartshop_moduleName . '</a>';
	}
}

/**
 * Copy a file, or a folder and its contents
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.0
 * @param       string   $source    The source
 * @param       string   $dest      The destination
 * @return      bool     Returns true on success, false on failure
 */
function smartshop_copyr($source, $dest)
{
	// Simple copy for a file
	if (is_file($source)) {
		return copy($source, $dest);
	}

	// Make destination directory
	if (!is_dir($dest)) {
		mkdir($dest);
	}

	// Loop through the folder
	$dir = dir($source);
	while (false !== $entry = $dir->read()) {
		// Skip pointers
		if ($entry == '.' || $entry == '..') {
			continue;
		}

		// Deep copy directories
		if (is_dir("$source/$entry") && ($dest !== "$source/$entry")) {
			copyr("$source/$entry", "$dest/$entry");
		} else {
			copy("$source/$entry", "$dest/$entry");
		}
	}

	// Clean up
	$dir->close();
	return true;
}

function smartshop_getEditor($caption, $name, $value, $dhtml = true)
{
	$smartShopConfig =& smartshop_getModuleConfig();
	switch ($smartShopConfig['use_wysiwyg']) {
		case 'tiny' :
		if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php");
			$editor = new XoopsFormTinyTextArea(array('caption'=> $caption, 'name'=>$name, 'value'=>$value, 'width'=>'100%', 'height'=>'300px'),true);
		} else {
			if ($dhtml) {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
			} else {
				$editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
			}
		}
		break;

		case 'koivi' :
		if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
			$editor = new XoopsFormWysiwygTextArea($caption, $name, $value, '100%', '400px');
		} else {
			if ($dhtml) {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
			} else {
				$editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
			}
		}
		break;

		default :
		if ($dhtml) {
			$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
		} else {
			$editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
		}

		break;
	}

	return $editor;
}

/**
* Thanks to the NewBB2 Development Team
*/
function &smartshop_admin_getPathStatus($item, $getStatus=false)
{
	if ($item == 'root') {
		$path = '';
	} else {
		$path = $item;
	}

	$thePath = smartshop_getUploadDir(true, $path);

	if(empty($thePath)) return false;
	if(@is_writable($thePath)){
		$pathCheckResult = 1;
		$path_status = _AM_SSHOP_AVAILABLE;
	}elseif(!@is_dir($thePath)){
		$pathCheckResult = -1;
		$path_status = _AM_SSHOP_NOTAVAILABLE." <a href=index.php?op=createdir&amp;path=$item>"._AM_SSHOP_CREATETHEDIR.'</a>';
	}else{
		$pathCheckResult = -2;
		$path_status = _AM_SSHOP_NOTWRITABLE." <a href=index.php?op=setperm&amp;path=$item>"._AM_SCS_SETMPERM.'</a>';
	}
	if (!$getStatus) {
		return $path_status;
	} else {
		return $pathCheckResult;
	}
}




/**
* Thanks to the NewBB2 Development Team
*/
function smartshop_admin_mkdir($target)
{
	// http://www.php.net/manual/en/function.mkdir.php
	// saint at corenova.com
	// bart at cdasites dot com
	if (is_dir($target) || empty($target)) {
		return true; // best case check first
	}

	if (file_exists($target) && !is_dir($target)) {
		return false;
	}

	if (smartshop_admin_mkdir(substr($target,0,strrpos($target,'/')))) {
		if (!file_exists($target)) {
			$res = mkdir($target, 0777); // crawl back up & create dir tree
			smartshop_admin_chmod($target);
			return $res;
		}
	}
	$res = is_dir($target);
	return $res;
}

/**
* Thanks to the NewBB2 Development Team
*/
function smartshop_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}


function smartshop_getUploadDir($local=true, $item=false)
{
	if ($item) {
		if ($item=='root') {
			$item = '';
		} else {
			$item = $item . '/';
		}
	} else {
		$item = '';
	}

	If ($local) {
		return XOOPS_ROOT_PATH . "/uploads/smartshop/$item";
	} else {
		return XOOPS_URL . "/uploads/smartshop/$item";
	}
}

function smartshop_getImageDir($item='', $local=true)
{
	if ($item) {
		$item = "images/$item";
	} else {
		$item = 'images';
	}

	return smartshop_getUploadDir($local, $item);
}

function smartshop_imageResize($src, $maxWidth, $maxHeight)
{
	$width = '';
	$height = '';
	$type = '';
	$attr = '';

	if (file_exists($src)) {
		list($width, $height, $type, $attr) = getimagesize($src);
		If ($width > $maxWidth) {
			$originalWidth = $width;
			$width = $maxWidth;
			$height = $width * $height / $originalWidth;
		}

		If ($height > $maxHeight) {
			$originalHeight = $height;
			$height = $maxHeight;
			$width = $height * $width / $originalHeight;
		}

		$attr = " width='$width' height='$height'";
	}
	return array($width, $height, $type, $attr);
}

function smartshop_getHelpPath()
{
	$smartShopConfig =& smartshop_getModuleConfig();
	switch ($smartShopConfig['helppath_select'])
	{
		case 'docs.xoops.org' :
		return 'http://docs.xoops.org/help/ssectionh/index.htm';
		break;

		case 'inside' :
		return XOOPS_URL . "/modules/smartshop/doc/";
		break;

		case 'custom' :
		return $smartShopConfig['helppath_custom'];
		break;
	}
}

function &smartshop_getModuleInfo()
{
	static $smartShopModule;
	if (!isset($smartShopModule)) {
		global $xoopsModule;
		if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartshop') {
			$smartShopModule =& $xoopsModule;
		}
		else {
			$hModule = &xoops_gethandler('module');
			$smartShopModule = $hModule->getByDirname('smartshop');
		}
	}
	return $smartShopModule;
}

function &smartshop_getModuleConfig()
{
	static $smartShopConfig;
	if (!$smartShopConfig) {
		global $xoopsModule;
		if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartshop') {
			global $xoopsModuleConfig;
			$smartShopConfig =& $xoopsModuleConfig;
		}
		else {
			$smartShopModule =& smartshop_getModuleInfo();
			$hModConfig = &xoops_gethandler('config');
			if(is_object($smartShopModule)){
				$smartShopConfig = $hModConfig->getConfigsByCat(0, $smartShopModule->getVar('mid'));
			}
		}
	}
	return $smartShopConfig;
}


function smartshop_deleteFile($dirname)
{
	// Simple delete for a file
	if (is_file($dirname)) {
		return unlink($dirname);
	}
}

function smartshop_formatErrors($errors=array())
{
	$ret = '';
	foreach ($errors as $key=>$value)
	{
		$ret .= "<br /> - " . $value;
	}
	return $ret;
}

/*function smartshop_addCategoryOption($categoryObj, $selectedid=0, $level = 0, $ret='')
{
// Creating the category handler object
$category_handler =& smartshop_gethandler('category');
$spaces = '';
for ( $j = 0; $j < $level; $j++ ) {
$spaces .= '--';
}

$ret .= "<option value='" . $categoryObj->categoryid() . "'";
if ($selectedid == $categoryObj->categoryid()) {
$ret .= " selected='selected'";
}
$ret .= ">" . $spaces . $categoryObj->name() . "</option>\n";

$subCategoriesObj = $category_handler->getCategories(0, 0, $categoryObj->categoryid());
if (count($subCategoriesObj) > 0) {
$level++;
foreach ( $subCategoriesObj as $catID => $subCategoryObj) {
$ret .= smartshop_addCategoryOption($subCategoryObj, $selectedid, $level);
}
}
return $ret;
}*/

function smartshop_createCategoryOptions($selectedid=0, $parentcategory=0, $allCatOption=true)
{
	$ret = "";
	If ($allCatOption) {
		$ret .= "<option value='0'";
		$ret .= ">" . _MB_SSHOP_ALLCAT . "</option>\n";
	}

	// Creating the category handler object
	$category_handler =& smartshop_gethandler('category');

	// Creating category objects
	$categoriesObj = $category_handler->getCategories(0, 0, $parentcategory);
	if (count($categoriesObj) > 0) {
		foreach ( $categoriesObj as $catID => $categoryObj) {
			$ret .= smartshop_addCategoryOption($categoryObj, $selectedid);
		}
	}
	return $ret;
}


function smartshop_getStatusArray ()
{
	$result = array("1" => _AM_SSHOP_STATUS1,
	"2" => _AM_SSHOP_STATUS2,
	"3" => _AM_SSHOP_STATUS3,
	"4" => _AM_SSHOP_STATUS4,
	"5" => _AM_SSHOP_STATUS5,
	"6" => _AM_SSHOP_STATUS6,
	"7" => _AM_SSHOP_STATUS7,
	"8" => _AM_SSHOP_STATUS8);
	return $result;
}

function smartshop_moderator ()
{
	global $xoopsUser, $xoopsDB, $xoopsConfig, $xoopsUser;

	If (!$xoopsUser) {
		$result = false;
	} else {
		$hModule = &xoops_gethandler('module');
		$hModConfig = &xoops_gethandler('config');

		if ($smartShopModule = &$hModule->getByDirname('smartshop')) {
			$module_id = $smartShopModule->getVar('mid');
		}

		$module_name = $smartShopModule->getVar('dirname');
		$smartShopConfig = &$hModConfig->getConfigsByCat(0, $smartShopModule->getVar('mid'));

		$gperm_handler = &xoops_gethandler('groupperm');

		$categories = $gperm_handler->getItemIds('category_moderation', $xoopsUser->getVar('uid'), $module_id);
		If (count($categories) == 0) {
			$result = false;
		} else {
			$result = true;
		}
	}
	return $result;
}

function smartshop_modFooter ()
{
	global $xoopsUser, $xoopsDB, $xoopsConfig;

	$hModule = &xoops_gethandler('module');
	$hModConfig = &xoops_gethandler('config');

	$smartShopModule = &$hModule->getByDirname('smartshop');
	$module_id = $smartShopModule->getVar('mid');

	$module_name = $smartShopModule->getVar('dirname');
	$smartShopConfig = &$hModConfig->getConfigsByCat(0, $smartShopModule->getVar('mid'));

	$module_id = $smartShopModule->getVar('mid');

	$versioninfo = &$hModule->get($smartShopModule->getVar('mid'));
	$modfootertxt = "Module " . $versioninfo->getInfo('name') . " - Version " . $versioninfo->getInfo('version') . "";

	$modfooter = "<a href='" . $versioninfo->getInfo('support_site_url') . "' target='_blank'><img src='" . XOOPS_URL . "/modules/smartshop/images/sscssbutton.gif' title='" . $modfootertxt . "' alt='" . $modfootertxt . "'/></a>";

	echo '<div style="text-align: center; padding-top: 10px;">' . $modfooter . '</div>';
	return $modfooter;
}

/**
* Checks if a user is admin of SmartShop
*
* smartshop_userIsAdmin()
*
* @return boolean : array with userids and uname
*/
function smartshop_userIsAdmin()
{
	global $xoopsUser;
	static $smartshop_isAdmin;

	if (isset($smartshop_isAdmin)) {
		return $smartshop_isAdmin;
	}

	if (!$xoopsUser) {
		$smartshop_isAdmin = false;
		return $smartshop_isAdmin;
	}

	$smartshop_isAdmin = false;

	$smartShopModule = smartshop_getModuleInfo();
	if(is_object($smartShopModule)){
		$module_id = $smartShopModule->getVar('mid');
		$smartshop_isAdmin = $xoopsUser->isAdmin($module_id);
	}
	else{
		$smartshop_isAdmin = false;
	}

	return $smartshop_isAdmin;
}

/**
* Checks if a user has access to a selected item. If no item permissions are
* set, access permission is denied. The user needs to have necessary category
* permission as well.
*
* smartshop_itemAccessGranted()
*
* @param integer $itemid : itemid on which we are setting permissions
* @param integer $ categoryid : categoryid of the item
* @return boolean : TRUE if the no errors occured
*/

// TODO : Move this function to SmartcontentItem class
function smartshop_itemAccessGranted($itemid, $categoryid)
{
	Global $xoopsUser;

	if (smartshop_userIsAdmin()) {
		$result = true;
	} else {
		$result = false;

		$groups = ($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

		$gperm_handler = &xoops_gethandler('groupperm');
		$hModule = &xoops_gethandler('module');
		$hModConfig = &xoops_gethandler('config');

		$smartShopModule = &$hModule->getByDirname('smartshop');

		$module_id = $smartShopModule->getVar('mid');
		// Do we have access to the parent category
		If ($gperm_handler->checkRight('category_read', $categoryid, $groups, $module_id)) {
			// Do we have access to the item ?
			If ($gperm_handler->checkRight('item_read', $itemid, $groups, $module_id)) {
				$result = true;
			} else { // No we don't !
			$result = false;
			}
		} else { // No we don't !
		$result = false;
		}
	}

	return $result;
}

/**
* Override ITEMs permissions of a category by the category read permissions
*
*   smartshop_overrideItemsPermissions()
*
* @param array $groups : group with granted permission
* @param integer $categoryid :
* @return boolean : TRUE if the no errors occured
*/
function smartshop_overrideItemsPermissions($groups, $categoryid)
{
	Global $xoopsDB;

	$result = true;
	$hModule = &xoops_gethandler('module');
	$smartShopModule = &$hModule->getByDirname('smartshop');

	$module_id = $smartShopModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');

	$sql = "SELECT itemid FROM " . $xoopsDB->prefix("smartshop_items") . " WHERE categoryid = '$categoryid' ";
	$result = $xoopsDB->query($sql);

	if (count($result) > 0) {
		while (list($itemid) = $xoopsDB->fetchrow($result)) {
			// First, if the permissions are already there, delete them
			$gperm_handler->deleteByModule($module_id, 'item_read', $itemid);
			// Save the new permissions
			if (count($groups) > 0) {
				foreach ($groups as $group_id) {
					$gperm_handler->addRight('item_read', $itemid, $group_id, $module_id);
				}
			}
		}
	}

	return $result;
}

/**
* Saves permissions for the selected item
*
*   smartshop_saveItemPermissions()
*
* @param array $groups : group with granted permission
* @param integer $itemID : itemid on which we are setting permissions
* @return boolean : TRUE if the no errors occured

*/
function smartshop_saveItemPermissions($groups, $itemID)
{
	$result = true;
	$hModule = &xoops_gethandler('module');
	$smartShopModule = &$hModule->getByDirname('smartshop');

	$module_id = $smartShopModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');
	// First, if the permissions are already there, delete them
	$gperm_handler->deleteByModule($module_id, 'item_read', $itemID);
	// Save the new permissions
	if (count($groups) > 0) {
		foreach ($groups as $group_id) {
			$gperm_handler->addRight('item_read', $itemID, $group_id, $module_id);
		}
	}
	return $result;
}

/**
* Saves permissions for the selected category
*
*   smartshop_saveCategory_Permissions()
*
* @param array $groups : group with granted permission
* @param integer $categoryid : categoryid on which we are setting permissions
* @param string $perm_name : name of the permission
* @return boolean : TRUE if the no errors occured
*/

function smartshop_saveCategory_Permissions($groups, $categoryid, $perm_name)
{
	$result = true;
	$hModule = &xoops_gethandler('module');
	$smartShopModule = &$hModule->getByDirname('smartshop');

	$module_id = $smartShopModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');
	// First, if the permissions are already there, delete them
	$gperm_handler->deleteByModule($module_id, $perm_name, $categoryid);

	// Save the new permissions
	if (count($groups) > 0) {
		foreach ($groups as $group_id) {
			$gperm_handler->addRight($perm_name, $categoryid, $group_id, $module_id);
		}
	}
	return $result;
}

/**
* Saves permissions for the selected category
*
*   smartshop_saveModerators()
*
* @param array $moderators : moderators uids
* @param integer $categoryid : categoryid on which we are setting permissions
* @return boolean : TRUE if the no errors occured
*/

function smartshop_saveModerators($moderators, $categoryid)
{
	$result = true;
	$hModule = &xoops_gethandler('module');
	$smartShopModule = &$hModule->getByDirname('smartshop');
	$module_id = $smartShopModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');
	// First, if the permissions are already there, delete them
	$gperm_handler->deleteByModule($module_id, 'category_moderation', $categoryid);
	// Save the new permissions
	if (count($moderators) > 0) {
		foreach ($moderators as $uid) {
			$gperm_handler->addRight('category_moderation', $categoryid, $uid, $module_id);
		}
	}
	return $result;
}

function smartshop_getxoopslink($url = '')
{
	$xurl = $url;
	If (strlen($xurl) > 0) {
		If ($xurl[0] = '/') {
			$xurl = str_replace('/', '', $xurl);
		}
		$xurl = str_replace('{SITE_URL}', XOOPS_URL, $xurl);
	}
	$xurl = $url;
	return $xurl;
}

function &smartshop_gethandler($name)
{
	static $smartshop_handlers;

	if (!isset($smartshop_handlers[$name])) {
		$smartshop_handlers[$name] =& xoops_getmodulehandler($name, 'smartshop');
	}
	return $smartshop_handlers[$name];
}

/*function smartshop_addCategoryOption($categoryObj, $selectedid=0, $level = 0, $ret='')
{
	// Creating the category handler object
	$category_handler =& smartshop_gethandler('category');

	$spaces = '';
	for ( $j = 0; $j < $level; $j++ ) {
		$spaces .= '--';
	}

	$ret .= "<option value='" . $categoryObj->categoryid() . "'";
	if ($selectedid == $categoryObj->categoryid()) {
		$ret .= " selected='selected'";
	}
	$ret .= ">" . $spaces . $categoryObj->name() . "</option>\n";

	$subCategoriesObj = $category_handler->getCategories(0, 0, $categoryObj->categoryid());
	if (count($subCategoriesObj) > 0) {
		$level++;
		foreach ( $subCategoriesObj as $catID => $subCategoryObj) {
			$ret .= smartshop_addCategoryOption($subCategoryObj, $selectedid, $level);
		}
	}
	return $ret;
}

function smartshop_createCategorySelect($selectedid=0, $parentcategory=0, $allCatOption=true)
{
	$ret = "" . _MB_SSHOP_SELECTCAT . "&nbsp;<select name='options[]'>";
	If ($allCatOption) {
		$ret .= "<option value='0'";
		$ret .= ">" . _MB_SSHOP_ALLCAT . "</option>\n";
	}

	// Creating the category handler object
	$category_handler =& smartshop_gethandler('category');

	// Creating category objects
	$categoriesObj = $category_handler->getCategories(0, 0, $parentcategory);

	if (count($categoriesObj) > 0) {
		foreach ( $categoriesObj as $catID => $categoryObj) {
			$ret .= smartshop_addCategoryOption($categoryObj, $selectedid);
		}
	}
	$ret .= "</select>\n";
	return $ret;
}
*/
function smartshop_renderErrors(&$err_arr, $reseturl = '')
{

	if (is_array($err_arr) && count($err_arr) > 0) {
		echo '<div id="readOnly" class="errorMsg" style="border:1px solid #D24D00; background:#FEFECC url('. SMARTSHOP_URL.'images/important-32.png) no-repeat 7px 50%;color:#333;padding-left:45px;">';

		echo '<h4 style="text-align:left;margin:0; padding-top:0">'._AM_SSHOP_MSG_SUBMISSION_ERR;

		if ($reseturl) {
			echo ' <a href="' . $reseturl . '">[' . _AM_SSHOP_TEXT_SESSION_RESET . ']</a>';
		}

		echo '</h4><ul>';

		foreach($err_arr as $key=>$error) {
			if (is_array($error)) {
				foreach ($error as $err) {
					echo '<li><a href="#'. $key .'" onclick="var e = xoopsGetElementById(\''.$key.'\'); e.focus();">' . htmlspecialchars($err) . '</a></li>';
				}
			} else {
				echo '<li><a href="#'. $key .'" onclick="var e = xoopsGetElementById(\''.$key.'\'); e.focus();">' . htmlspecialchars($error) . '</a></li>';
			}
		}
		echo "</ul></div><br />";
	}
}

/**
 * Generate smartshop URL
 *
 * @param string $page
 * @param array $vars
 * @return
 *
 * @access public
 * @credit : xHelp module, developped by 3Dev
 */
function smartshop_makeURI($page, $vars = array(), $encodeAmp = true)
{
	$joinStr = '';

	$amp = ($encodeAmp ? '&amp;': '&');

	if (! count($vars)) {
		return $page;
	}
	$qs = '';
	foreach($vars as $key=>$value) {
		$qs .= $joinStr . $key . '=' . $value;
		$joinStr = $amp;
	}
	return $page . '?'. $qs;
}
function getReservPrevForm()
{
	global $regionsArray, $smartshop_category_handler;

	$sform = new XoopsThemeForm(_CO_SSHOP_RESERV_CREATE, "reserv", xoops_getenv('PHP_SELF'));
	$sform->setExtra('enctype="multipart/form-data"');

	$options = $regionsArray;
	$region_select = new XoopsFormSelect(_CO_SSHOP_RESERV_REGION, 'regionid');
	$region_select->addOptionArray($options);
	$region_select->setDescription(_CO_SSHOP_RESERV_REGION_DSC);
	$sform -> addElement( $region_select );

	$options = array();
    $categoriesArray = $smartshop_category_handler->getObjects(null, true, false);

    foreach($categoriesArray as $cat){
    	$options[$cat['categoryid']] = $cat['name'];
    }
	$category_select = new XoopsFormSelect(_CO_SSHOP_RESERV_CAT, 'categoryid');
	$category_select->addOptionArray($options);
	$category_select->setDescription(_CO_SSHOP_RESERV_CAT_DSC);
	$sform -> addElement( $category_select );

	$button_tray = new XoopsFormElementTray('', '');
	$hidden = new XoopsFormHidden('op', 'mod');
	$button_tray->addElement($hidden);

	$butt_create = new XoopsFormButton('', '', _CO_SSHOP_CONTINUE, 'submit');
	$butt_create->setExtra('onclick="this.form.elements.op.value=\'mod\'"');
	$button_tray->addElement($butt_create);

	$butt_cancel = new XoopsFormButton('', '', _CO_SSHOP_CANCEL, 'button');
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement($butt_cancel);

	$sform->addElement($button_tray);

	return $sform;

}
function getCatSelectForm($options, $fname)
{
	global $smartshop_category_handler;

	$sform = new XoopsThemeForm(_CO_SSHOP_RESERV_CREATE, $fname, xoops_getenv('reservation.php'));
	$sform->setExtra('enctype="multipart/form-data"');


	$category_select = new XoopsFormSelect(_CO_SSHOP_RESERV_CAT, 'regionid');
	$category_select->addOptionArray($options);
	$category_select->setDescription(_CO_SSHOP_RESERV_CAT_DSC);
	$sform -> addElement( $category_select );

	$options = array();
    $categoriesArray = $smartshop_category_handler->getObjects(null, true, false);

	$button_tray = new XoopsFormElementTray('', '');
	$hidden = new XoopsFormHidden('op', 'mod');
	$button_tray->addElement($hidden);

	$butt_create = new XoopsFormButton('', '', _CO_SSHOP_RESERVE, 'submit');
	$butt_create->setExtra('onclick="this.form.elements.op.value=\'mod\'"');
	$button_tray->addElement($butt_create);

	$butt_cancel = new XoopsFormButton('', '', _CO_SSHOP_CANCEL, 'button');
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement($butt_cancel);

	$sform->addElement($button_tray);

	return $sform;

}


?>