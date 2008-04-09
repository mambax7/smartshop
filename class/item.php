<?php
// $Id$
// ------------------------------------------------------------------------ //
// 				 XOOPS - PHP Content Management System                      //
//					 Copyright (c) 2000 XOOPS.org                           //
// 						<http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //

// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //

// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// URL: http://www.xoops.org/												//
// Project: The XOOPS Project                                               //
// -------------------------------------------------------------------------//

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartseoobject.php";
class SmartshopItem extends SmartSeoObject {

    function SmartshopItem() {
    	global $smartShopConfig, $smartshop_module_use;

        $this->initVar('itemid', XOBJ_DTYPE_INT, '', true, null, '', false,  _CO_SSHOP_ITEM_ID);
         $this->initVar('parentid', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_ITEM_CATEGORY, _CO_SSHOP_ITEM_CATEGORY_DSC, true);
        $this->setControl('parentid', array('name' => 'parentcategory',
        									'options' => array('addNoParent' => false)));

        $this->initVar('name', XOBJ_DTYPE_TXTBOX, '', true, 255, '', false, _CO_SSHOP_ITEM_NAME, _CO_SSHOP_ITEM_NAME_DSC, true);

		$this->initVar('description', XOBJ_DTYPE_TXTAREA, '', false, null, '', false, _CO_SSHOP_ITEM_DESC, _CO_SSHOP_ITEM_DESC_DSC);

        //fields only relevant for sales oriented module use
		if($smartshop_module_use == 'boutique' ||$smartshop_module_use == 'adds'){
	        $this->initVar('price', XOBJ_DTYPE_CURRENCY, '', false, null,'', false,  _CO_SSHOP_ITEM_PRICE, _CO_SSHOP_ITEM_PRICE_DSC);
	        $this->initVar('currency', XOBJ_DTYPE_TXTBOX, '', false, null,'', false,  _CO_SSHOP_ITEM_CURRENCY, _CO_SSHOP_ITEM_CURRENCY_DSC);
			$this->setControl('currency', array('itemHandler' => 'item',
								            'method' => 'getCurrencies',
								            'module' => 'smartshop'));

		}

        $this->initVar('uid', XOBJ_DTYPE_INT, '', false, null, '', false, _CO_SSHOP_ITEM_UID, _CO_SSHOP_ITEM_UID_DSC);
        $this->setControl('uid', 'user');

        $this->initVar('date', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_ITEM_DATE, _CO_SSHOP_ITEM_DATE_DSC, true);
		$this->setControl('date', 'date_time');

      	//fields only relevant for user submiting oriented module use
        if($smartshop_module_use == 'dynamic_directory' ||$smartshop_module_use == 'adds'){
	        $this->initVar('no_exp', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_ITEM_NO_EXP, _CO_SSHOP_ITEM_NO_EXP_DSC);
	        $this->setControl('no_exp', 'yesno');

	        $this->initVar('exp_date', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_ITEM_DATE_EXP, _CO_SSHOP_ITEM_DATE_EXP_DSC, true);
        	$this->setControl('exp_date', 'date_time');

        	$this->initVar('mail_status', XOBJ_DTYPE_INT, 0, false, null,'', false, '', '', true, true, false);
        }
	    $this->initVar('status', XOBJ_DTYPE_INT, _SSHOP_STATUS_ONLINE, false, null,'', false, _CO_SSHOP_ITEM_STATUS, _CO_SSHOP_ITEM_STATUS_DSC, true);
		$this->setControl('status', array('name' => false,
                                          'itemHandler' => 'item',
                                          'method' => 'getStatus',
                                          'module' => 'smartshop'));

		$this->initVar('image', XOBJ_DTYPE_IMAGE, '', false, null, '',  false, _CO_SSHOP_ITEM_IMAGE, sprintf(_CO_SSHOP_ITEM_IMAGE_DSC, $smartShopConfig['img_max_width'], $smartShopConfig['img_max_height'], $smartShopConfig['maximum_imagesize']));
		$this->setControl('image', array('name' => 'image'));

        $this->initCommonVar('counter', false);
        $this->initCommonVar('weight');
        $this->initCommonVar('dohtml', false);
        $this->initCommonVar('dosmiley', false);
        $this->initCommonVar('doxcode', false);
        $this->initCommonVar('doimage', false);
        $this->initCommonVar('dobr', false);

        // call parent constructor to get SEO fields initiated
        $this->SmartSeoObject();
    }

    /**
    * returns a specific variable for the object in a proper format
    *
    * @access public
    * @param string $key key of the object's variable to be returned
    * @param string $format format to use for the output
    * @return mixed formatted value of the variable
    */
    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('categoryid', 'uid', 'date', 'status', 'currency'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function toArray($from_search = false) {
    	global $xoopsModuleConfig, $smartshop_category_attribut_handler;
    	$objectArray = parent::toArray();
		$myts =& MyTextSanitizer::getInstance();
		$objectArray['name'] = $myts->undoHtmlSpecialChars($objectArray['name'], 1);
		$objectArray["itemLink"] = $myts->undoHtmlSpecialChars($objectArray['itemLink'], 1);
    	if ($objectArray['image'] != -1 && $objectArray['image'] != '') {
    		$objectArray['image'] = str_replace('{XOOPS_URL}', XOOPS_URL, $objectArray['image']);
    		if(substr($objectArray['image'], 0,4 ) == 'http'){
    			$objectArray['image'] = $objectArray['image'];
    		}else{
    			$objectArray['image'] = $this->getImageDir() . $objectArray['image'];
    		}
    	}
    	elseif($xoopsModuleConfig['def_item_pic'] == ''){
    		$objectArray['image'] = SMARTSHOP_URL."images/blank.png";
    	}
    	else{
    		$objectArray['image'] = SMARTSHOP_URL."images/".$xoopsModuleConfig['def_item_pic'];
    	}if($from_search){
    		if (strlen($objectArray['description']) >= 100) {
                    $objectArray['description'] = smartshop_substr($objectArray['description'] , 0, 100);
                }
    	}
    	$optionFields = $smartshop_category_attribut_handler->getOptionsFields($this->getVar('parentid'));
		$custom_render_array = $smartshop_category_attribut_handler->getCustomRederingFields($this->getVar('parentid'));
		// Loop through the array and change special custom vars all array value for a string
		foreach($objectArray as $k => $v) {
    		if(isset($optionFields[$k])){
    			//Get value for each selected option if option field
    			if(is_array($v)){
	    			foreach($v as $val){
	    				$option_val[] = $optionFields[$k][$val];
	    			}
	    			$objectArray[$k] = implode(', ', $option_val);
    			}else{
    				$option_val = $optionFields[$k][$v];
	    			$objectArray[$k] =  $option_val;
    			}
    			unset($option_val);
    		}elseif($this->getVarInfo($k, 'custom_field_type') == 'file'){

				$fileObj = $this->getFileObj($k);
    			if($fileObj->isNew()){
    				$objectArray[$k] = '';
    			}elseif(isset($custom_render_array[$k]) ){
    				$objectArray[$k] = str_replace(array('{URL}', '{DESCRIPTION}', '{CAPTION}', '{XOOPS_URL}'), array(str_replace('{XOOPS_URL}', XOOPS_URL,$fileObj->getVar('url')),$fileObj->getVar('description'), $fileObj->getVar('caption'),
    							XOOPS_URL), $custom_render_array[$k]);
    			}else{
    				$caption = $fileObj->getVar('caption') != '' ? $fileObj->getVar('caption') : $fileObj->getVar('url');
    				$objectArray[$k] = "<a href='".str_replace('{XOOPS_URL}', XOOPS_URL,$fileObj->getVar('url'))."' alt='".$fileObj->getVar('description')."' title='".$fileObj->getVar('description')."'>".$caption."</a>";
    			}
    		}elseif($this->getVarInfo($k, 'custom_field_type') == 'urllink'){
				$urllinkObj = $this->getUrlLinkObj($k);
    			if($urllinkObj->isNew()){
    				$objectArray[$k] = '';
    			}elseif(isset($custom_render_array[$k])){
    				$objectArray[$k] =
    					str_replace(array('{URL}', '{DESCRIPTION}', '{CAPTION}', '{TARGET}', '{XOOPS_URL}'),
    					array(str_replace('{XOOPS_URL}', XOOPS_URL,	$urllinkObj->getVar('url')),
    							$urllinkObj->getVar('description'),
    							$urllinkObj->getVar('caption'),
    							$urllinkObj->getVar('target'),
    							XOOPS_URL),
    				$custom_render_array[$k]);
    			}else{
    				$caption = $urllinkObj->getVar('caption') != '' ? $urllinkObj->getVar('caption') : $urllinkObj->getVar('url');
    				$objectArray[$k] = "<a href='".str_replace('{XOOPS_URL}', XOOPS_URL,$urllinkObj->getVar('url'))."' alt='".$urllinkObj->getVar('description')."' title='".$urllinkObj->getVar('description')."' target='".$urllinkObj->getVar('target')."'>".$caption ."</a>";
    			}
    		}
    		elseif($this->getVarInfo($k, 'custom_field_type')  == 'image'){
    			if($objectArray[$k] == ''){
    				$objectArray[$k] = '';
    			}else {
    				$objectArray[$k] = substr($objectArray[$k], 0, 4) == 'http' ? $objectArray[$k] : $this->getImageDir().$objectArray[$k];
    				$objectArray[$k] = "<img src='$objectArray[$k]' />";
    			}
    		}elseif(isset($custom_render_array[$k])){
    			$objectArray[$k] = str_replace(array('{VALUE}', '{XOOPS_URL}'), array($v, XOOPS_URL) , $custom_render_array[$k]);

    		}
    	}

		include_once(SMARTOBJECT_ROOT_PATH . 'class/smarthighlighter.php');
		$highlight = smart_getConfig('module_search_highlighter', false, true);

		if($highlight && isset($_GET['keywords']))
		{
			$myts =& MyTextSanitizer::getInstance();
			$keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
			$h= new SmartHighlighter ($keywords, true , 'smart_highlighter');
			foreach($this-> getVarInfo() as $field=>$value) {
				$objectArray[$field] = $h->highlight($objectArray[$field]);
			}
		}

    	return $objectArray;
    }

    function initiateCustomFields() {

    	// $constantVars are the vars without the dynamic fields
    	$constantVars = $this->vars;
    	$category_attributObjs =& $this->getCustomFields();

    	global $smartshop_item_attribut_handler, $xoopsModuleConfig;
    	if(!isset($smartshop_item_attribut_handler)){
			$smartshop_item_attribut_handler =& xoops_getmodulehandler('item_attribut', 'smartshop');
		}
		$catAttIdArray = array();
    	if (!$this->isNew()) {
	    	foreach ($category_attributObjs as $category_attributObj) {
	    		$catAttIdArray[] = $category_attributObj->getVar('attributid');
	    	}

			if (!$this->isNew()) {
				//getObjects
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('attributid', '('.implode(', ', $catAttIdArray).')', 'IN'));
				$criteria->add(new Criteria('itemid', $this->getVar('itemid')));
				$item_attributsObj = $smartshop_item_attribut_handler->getObjects($criteria);
			}
		}
		foreach ($category_attributObjs as  $category_attributObj) {
			if (!$this->isNew()) {
				if(is_object($item_attributsObj[$this->getVar('itemid', 'e')][$category_attributObj->getVar('attributid', 'e')])){
					$value = $item_attributsObj[$this->getVar('itemid', 'e')][$category_attributObj->getVar('attributid', 'e')]->getVar('value', 'e');
				}
			}else{
				$value = $category_attributObj->getVar('att_default');
			}
    		$this->initVar($category_attributObj->getVar('name'), $category_attributObj->getObjectType(), $value, $category_attributObj->getVar('required'), null, '', false, $category_attributObj->getVar('caption'), $category_attributObj->getVar('description'));
    		$this->setVar($category_attributObj->getVar('name'), $value);

    		$this->setVarInfo($category_attributObj->getVar('name'), 'custom_field_type',$category_attributObj->getVar('att_type', 'n'));
			$this->setVarInfo($category_attributObj->getVar('name'), 'size',0);
	  		// Create the customControl if needed
	    	switch ($category_attributObj->getVar('att_type', 'n')) {


	    		case 'text' :
					$this->setControl($category_attributObj->getVar('name'), array('name' => 'text', 'js' => $category_attributObj->getJsForUnique()));
	    			break;

	    		case 'check' :
					$this->setControl($category_attributObj->getVar('name'), array('name' => 'check',
																					'options' => $category_attributObj->getOptionsArray()));
	    			break;

	    		case 'html' :

	    			break;

	    		case 'radio' :
					$this->setControl($category_attributObj->getVar('name'), array('name' => 'radio',
																					'options' => $category_attributObj->getOptionsArray()));

	    			break;

	    		case 'select' :
					$this->setControl($category_attributObj->getVar('name'), array('name' => 'select',
																				   'options' => $category_attributObj->getOptionsArray()));
	    			break;

				case 'select_multi' :
					$this->setControl($category_attributObj->getVar('name'), array('name' => 'select_multi',
																				   'options' => $category_attributObj->getOptionsArray()));
	    			break;

	    		case 'tarea' :
					$this->setControl($category_attributObj->getVar('name'), array('name' => 'textarea',
																				   'cols' => $xoopsModuleConfig['txtarea_width'],
																				   'rows' => $xoopsModuleConfig['txtarea_height']));


	    			break;

				case 'yn' :
					$this->setControl($category_attributObj->getVar('name'), "yesno");
	    			break;

				case 'file' :
					$this->setControl($category_attributObj->getVar('name'), "richfile");
					break;

				case 'image' :
					$this->setControl($category_attributObj->getVar('name'), "image");
					break;

	    		default:
	    		//case 'text' :

	    			break;
	    	}
    	}

       // Reorganize fields for the CustomFields to be inserted after the "description" field
        $startvars = array();
        $middlevars = array();
        $endvars = array();
        $middleReached = false;
        // Looping through all the vars to split them in 3 arrays, $startvars, $middlevars and $endvars
        foreach ($this->vars as $key=>$var) {
        	// if the middle (which in our this object is the "description" field) has not been reached,
        	// then we keep adding the field in the $startvars array
			if (!$middleReached) {
				$startvars[$key] = $var;
				if ($key=='description') {
					$middleReached = true;
				}
			} else {
				// if the middle has been reached, then we check to see if this field is a constant field or a dynamic one
				if (isset($constantVars[$key])) {
					$endvars[$key] = $var;
				} else {
					$middlevars[$key] = $var;
				}
			}
        }
        $this->vars = $startvars + $middlevars + $endvars;
    }

    function getCustomFields()
    {
    	global $smartshop_category_attribut_handler, $smartshop_category_handler;
		if(!isset($smartshop_category_handler)){
			//$smartshop_category_handler =& xoops_getmodulehandler('category', 'smartshop');
			$smartshop_category_attribut_handler =& xoops_getmodulehandler('category_attribut', 'smartshop');

		}
		$category_attributObjs = $smartshop_category_attribut_handler->getCatAtt4Cat($this->getVar('parentid'));
    	return $category_attributObjs;
    }

    function getEditItemLink() {
		$ret = '<a href="' . SMARTSHOP_URL . 'admin/item.php?op=mod&itemid=' . $this->getVar('itemid') . '&categoryid=' . $this->getVar('parentid') . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'edit.png" style="vertical-align: middle;" alt="' . _CO_SOBJECT_MODIFY . '" title="' . _CO_SOBJECT_MODIFY . '" /></a>';
		return $ret;
	}

    function getAutoEditLinks() {
		$ret = '<a href="' . SMARTSHOP_URL . 'submit.php?op=mod&itemid=' . $this->getVar('itemid') . '&categoryid=' . $this->getVar('parentid') . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'edit.png" style="vertical-align: middle;" alt="' . _CO_SOBJECT_MODIFY . '" title="' . _CO_SOBJECT_MODIFY . '" /></a>';

		global $smartshop_module_use, $smartshop_category_handler;
		if ($smartshop_module_use == 'adds') {
	    	$categoryObj =& $smartshop_category_handler->get($this->getVar('parentid'));
			if($this->getVar('status', 'n') != _SSHOP_STATUS_SOLD){
				$ret .=	'<a href="' . SMARTSHOP_URL . 'submit.php?op=sold&itemid=' . $this->getVar('itemid') . '&categoryid=' . $this->getVar('parentid') . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'sold.png" style="vertical-align: middle;" alt="' . _CO_SOBJECT_SOLD . '" title="' . _CO_SOBJECT_SOLD . '" /></a>';
			}
		}

		return $ret;
	}

	function getApproveLink(){
		$ret = '<a href="' . SMARTSHOP_URL . 'admin/item.php?fct=app&op=mod&itemid=' . $this->getVar('itemid') . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'up2.png" style="vertical-align: middle;" alt="' . _CO_SOBJECT_APPROVE . '" title="' . _CO_SOBJECT_APPROVE . '" /></a>';
		return $ret;
	}

	function getRenewLink(){
		$ret = '<a href="' . SMARTSHOP_URL . 'admin/item.php?fct=rnw&op=mod&itemid=' . $this->getVar('itemid') . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'up2.png" style="vertical-align: middle;" alt="' . _AM_SSHOP_RENEW_IT . '" title="' . _AM_SSHOP_RENEW_IT . '" /></a>';
		return $ret;
	}


    function categoryid(){

        global $smartshop_category_handler;

        $obj =& $smartshop_category_handler->get($this->getVar('parentid', 'e'));
        $ret = $obj->getVar('name');

        return $ret;
    }

    function uid() {
        $ret = smart_getLinkedUnameFromId($this->getVar('uid', 'e'), false);

        return $ret;
    }

    function date() {
        $ret = formatTimestamp($this->getVar('date','e'), 'Y-m-d');
        return $ret;
    }

    function status() {
        global $statusArray;
        $ret = isset($statusArray[$this->getVar('status', 'e')]) ? $statusArray[$this->getVar('status','e')] : _CO_SSHOP_STATUS_UNDEFINED;
        return $ret;
    }

    function currency() {
        global $currencyArray;
        $ret = isset($currencyArray[$this->getVar('currency', 'e')]) ? $currencyArray[$this->getVar('currency','e')] : _CO_SSHOP_CURRENCY_UNDEFINED;
        return $ret;
    }

    function getPosterInfo(){
        $user_handler = &xoops_gethandler('user');
		$poster = &$user_handler->get($this->getVar('uid', 'n'));
		if($poster){
			$ret = array();

	        $ret['pmlink'] =  "<a href=\"javascript:openWithSelfMain('".XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$poster->getVar('uid')."', 'pmlite', 450, 380);\"><img src=\"".XOOPS_URL."/images/icons/pm.gif\" alt=\"".sprintf(_SENDPMTO,$poster->getVar('uname'))."\" /></a>";

	        if($poster->getVar('user_viewemail')){
				$ret['email'] = $poster->getVar('email');
			}
			if ($poster->getVar('user_avatar') && ($poster->getVar('user_avatar') != 'blank.gif')) {
				$ret['avatar'] = XOOPS_URL.'/uploads/'.$poster->getVar('user_avatar');
			}
			return $ret;
		}else{
			global $smartshop_item_handler;
			$smartshop_item_handler->delete($this,true);
			redirect_header(SMARTSHOP_URL, 1, _CO_SSHOP_NO_USER);
		}

    }

    function sendNotifications($notifications=array())

	{
    	$smartModule =& smart_getModuleInfo();
    	$module_id = $smartModule->getVar('mid');

		$myts =& MyTextSanitizer::getInstance();
		$notification_handler = &xoops_gethandler('notification');

		$tags = array();

		$tags['ADD_NAME'] = $this->getVar('name');
		$tags['ADD_CAT'] = $this->categoryid();

		foreach ( $notifications as $notification ) {
			switch ($notification) {
				case _SSHOP_NOT_ADD_APPROVED :
				$tags['ADD_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/item.php?itemid=' . $this->getVar('itemid');
				$notification_handler->triggerEvent('item', $this->getVar('itemid'), 'approved', $tags);
				break;


				case _SSHOP_NOT_ADD_SUBMITTED :
				$tags['WAITINGFILES_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/admin/item.php?fct=app&op=mod&itemid=' . $this->getVar('itemid');
				$notification_handler->triggerEvent('global', 0, 'submitted', $tags);
				break;

				case _SSHOP_NOT_ADD_PUBLISHED :
				$tags['ADD_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/item.php?itemid=' . $this->getVar('itemid');
				$notification_handler->triggerEvent('global', 0, 'published', $tags);
				break;


				case -1 :
				default:
				break;
			}
		}
	}
	function uidForExp() {

		$member_handler = & xoops_gethandler('member');
		$user = & $member_handler->getUser($this->getVar('uid', 'e'));

		$ret = is_object($user) ? $user->getVar('uname') : '';
	    return $ret;
    }

	function getPageCloneActionLink() {
		$ret = '<a href="' . SMARTSHOP_URL . 'admin/item.php?op=clone&itemid=' . $this->id() . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'editcopy.png" style="vertical-align: middle;" alt="' . _CO_SOBJECT_CLONE . '" title="' . _CO_SOBJECT_CLONE . '" /></a>';
		return $ret;
    }

	function getWeightControl() {
		$control = new XoopsFormText('', 'weight_' . $this->id(), 5, 100, $this->getVar('weight'));
		return $control->render();
    }


	function getStatusControl() {
    	$status_select = new XoopsFormSelect('', 'status_' . $this->id(), $this->getVar('status', 'e'));
    	$smartshop_item_handler = xoops_getModuleHandler('item', 'smartshop');
    	$status_select->addOptionArray($smartshop_item_handler->getStatus());
    	return $status_select->render();
    }

    /*function getForm($form_caption, $form_name, $form_action=false, $submit_button_caption = _CO_SOBJECT_SUBMIT, $cancel_js_action=false, $captcha=false)
    {
        include_once SMARTSHOP_ROOT_PATH . "class/form/smartshopform.php";
        $form = new SmartShopForm($this, $form_name, $form_caption, $form_action, null, $submit_button_caption, $cancel_js_action, $captcha);

        return $form;
    }*/

}

class SmartshopItemHandler extends SmartPersistableObjectHandler {

	var $currenciesList=false;

    function SmartshopItemHandler($db) {
    	global $xoopsModuleConfig, $smartobject_currenciesArray;

        $this->SmartPersistableObjectHandler($db, 'item', 'itemid', 'name', 'description', 'smartshop');

		//Get preferences about image upload(img_max_width, img_max_height, maximum_imagesize)
		// Making sure there is no invalid data
    	if(!isset($xoopsModuleConfig['img_max_width'])|| intval($xoopsModuleConfig['img_max_width']) < 1 ){
    		$img_max_width = 150;
    	}
    	else{
    		$img_max_width = intval($xoopsModuleConfig['img_max_width']);
    	}
    	if(!isset($xoopsModuleConfig['img_max_height'])|| intval($xoopsModuleConfig['img_max_height']) < 1 ){
    		$img_max_height = 150;
    	}
    	else{
    		$img_max_height = intval($xoopsModuleConfig['img_max_height']);
    	}

    	if(!isset($xoopsModuleConfig['maximum_imagesize'])|| intval($xoopsModuleConfig['maximum_imagesize']) < 1 ){
    		$maximum_imagesize = 1000000;
    	}
    	else{
    		$maximum_imagesize = intval($xoopsModuleConfig['maximum_imagesize']);
    	}

		$this->currenciesList = $smartobject_currenciesArray;
    	$this->setUploaderConfig(false, false, $maximum_imagesize, $img_max_width, $img_max_height);
    }

    function getStatus(){
        global $statusArray;
        return $statusArray;
    }

    function getSellers() {
    	/**
    	 * @todo return only users that are selling something
    	 */
		$ret = array();
		$ret['default'] = _CO_OBJ_ALL;

		$member_handler =& xoops_gethandler('member');
		$criteria = new CriteriaCompo();
		$criteria->setSort('uname');
		$aUsers = $member_handler->getUsers($criteria, true);
		foreach ($aUsers as $uid => $user) {
			$ret[$uid] = $user->getVar('uname');
		}
    	return $ret;
    }

	function afterDelete(&$obj) {

		global $smartshop_item_attribut_handler;

		/**
		 * Retreive all item_attribut of this item and delete them
		 */
		$criteria = new CriteriaCompo(new Criteria('itemid', $obj->getVar('itemid')));
		$objects = $smartshop_item_attribut_handler->getObjects($criteria);

		unset($criteria);

		foreach($objects as $object) {
			$smartshop_item_attribut_handler->delete($object);
		}
		unset($criteria);

		/**
		 * @todo add some code to capture any error that may occur
		 */
		return true;
	}

	function markAsSold($action, $itemObj, $redirect_page=false )
	{
		global $smart_previous_page;

		$confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
		if ($confirm) {
			$itemObj->setVar('status', _SSHOP_STATUS_SOLD);

			if (!$this->insert($itemObj)) {
		    	redirect_header($smart_previous_page, 3, _AM_SSHOP_SOLD_ERROR . $itemObj->getHtmlErrors());
		    	exit;
		    }

			redirect_header($_POST['redirect_page'], 3, _AM_SSHOP_SOLD_SUCCESS);
			exit();
		} else {
			$redirect_page = $redirect_page ? $redirect_page : $smart_previous_page;
			xoops_confirm(array('op' => 'sold', 'itemid' => $itemObj->getVar('itemid'), 'confirm' => 1, 'redirect_page' => $redirect_page), xoops_getenv('PHP_SELF'), sprintf(_AM_SSHOP_SOLD_CONFIRM , $itemObj->getVar('name')),_AM_SSHOP_YES);

		}

	}
	function &getD($id, $as_object = true, $initiate_c_f=true) {
		return $this->get($id, $as_object, true, false, $initiate_c_f);
    }

    function &get($id, $as_object = true, $debug=false, $criteria=false, $dropCF=false) {
        if (!$criteria) {
        	$criteria = new CriteriaCompo();
        }
        if (is_array($this->keyName)) {
            for ($i = 0; $i < count($this->keyName); $i++) {
	            /**
	             * In some situations, the $id is not an INTEGER. SmartObjectTag is an example.
	             * Is the fact that we removed the intval() represents a security risk ?
	             */
                //$criteria->add(new Criteria($this->keyName[$i], ($id[$i]), '=', $this->_itemname));
                $criteria->add(new Criteria($this->keyName[$i], $id[$i], '=', $this->_itemname));
            }
        }
        else {
            //$criteria = new Criteria($this->keyName, intval($id), '=', $this->_itemname);
            /**
             * In some situations, the $id is not an INTEGER. SmartObjectTag is an example.
             * Is the fact that we removed the intval() represents a security risk ?
             */
            $criteria->add(new Criteria($this->keyName, $id, '=', $this->_itemname));
        }
        $criteria->setLimit(1);

        if ($debug) {
        	$obj_array = $this->getObjectsD($criteria, false, $as_object, false, false, $dropCF);
        } else {
        	$obj_array = $this->getObjects($criteria, false, $as_object, false, false, $dropCF);
        	//patch : weird bug of indexing by id even if id_as_key = false;
        	if(!isset($obj_array[0]) && is_object($obj_array[$id])){
        		$obj_array[0] = $obj_array[$id];
        		unset($obj_array[$id]);
				$obj_array[0]->unsetNew();
        	}
        }

        if (count($obj_array) != 1) {
            $obj = $this->create();
            return $obj;
        }

        return $obj_array[0];
    }

	function getObjects($criteria = null, $id_as_key = false, $as_object = true, $sql=false, $debug=false, $dropCF=false){
    	$itemsObj = parent::getObjects($criteria , $id_as_key, $as_object, $sql, $debug);

		//patch PHP4
		if($dropCF){
			return $itemsObj;
		}else{
			$itemsObj2 = $this->initiateCustomFields($itemsObj);
			return $itemsObj2;
		}
		/*$this->initiateCustomFields($itemsObj);
		return $itemsObj;*/
		// End patch PHP4
   	}

	function initiateCustomFields($itemsObj) {

		global $smartshop_item_attribut_handler, $smartshop_category_attribut_handler;
		if(!isset($smartshop_item_attribut_handler)){
			$smartshop_item_attribut_handler =& xoops_getmodulehandler('item_attribut','smartshop');
			$smartshop_category_attribut_handler =& xoops_getmodulehandler('category_attribut','smartshop');
		}
		foreach($itemsObj as $itemObj){
			$itemidArray[] = $itemObj->getVar('itemid', 'e');
		}
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('itemid', '('.implode(', ', $itemidArray).')', 'IN'));
		$item_attributsObj = $smartshop_item_attribut_handler->getObjects($criteria);

		$category_attributsObj = $smartshop_category_attribut_handler->getObjects(null, true);
		foreach($itemsObj as $key =>$itemObj){
	    	$constantVars = $itemObj->vars;
	    	foreach($item_attributsObj[$itemObj->getVar('itemid', 'e')] as $item_attributObj){
		    	if($itemObj->getVar('itemid', 'e') == $item_attributObj->getVar('itemid', 'e')){
			    	$attributid = $item_attributObj->getVar('attributid', 'e');
					if(is_object($category_attributsObj[$attributid])){
				    	$itemObj->initVar($category_attributsObj[$attributid]->getVar('name'), $category_attributsObj[$attributid]->getObjectType(),
					    	$item_attributObj->getVar('value'),	$category_attributsObj[$attributid]->getVar('required'), null, '', false,
					    	$category_attributsObj[$attributid]->getVar('caption'),	$category_attributsObj[$attributid]->getVar('description'));
					    	$itemObj->setVar($category_attributsObj[$attributid]->getVar('name'), $item_attributObj->getVar('value'));

				    	$itemObj->setVarInfo($category_attributsObj[$attributid]->getVar('name'), 'custom_field_type',$category_attributsObj[$attributid]->getVar('att_type', 'n'));
						$itemObj->setVarInfo($category_attributsObj[$attributid]->getVar('name'), 'size',0);
					}
		    	}


	    	}
			//patch PHP4
			$itemsObj2[$key] = $itemObj;
		}
		//patch PHP4
	    return $itemsObj2;

    }
	function &getObjectsForSearchForm($criteria = null, $custom_field_kw_array = null, $categoryid = 0, $andOr=1)
	{
		global $smartpermissions_handler, $smartshop_category_handler;
		$smartpermissions_handler = new SmartobjectPermissionHandler($smartshop_category_handler);
		$grantedCats = $smartpermissions_handler->getGrantedItems('category_view');
		if($categoryid > 0){
			$childCats = array($categoryid);
			$childCatsArray = $smartshop_category_handler->getCategoryHierarchyArray($categoryid, 0, '');
			foreach($childCatsArray as $child){
				$childCats[] = $child['categoryid'];
			}
			$searchCats = array_intersect($childCats,$grantedCats);
			$ascendency = $smartshop_category_handler->getAscendency($categoryid);

		}else{
			$searchCats = $grantedCats;
			$ascendency = array(0);
		}

		$andOr = $andOr == 1 ? ' AND' : ' OR';
		$sql = "Select * FROM ".$this->db->prefix('smartshop_item');
		$sql .= " ".$criteria->renderWhere();
		$sql .= $criteria->renderWhere() == "" ? ' WHERE' : ' AND';
		$sql .= " status = "._SSHOP_STATUS_ONLINE." ";
		$sql .= " AND parentid IN (".implode(',', $searchCats).") ";
		//$sql .= $categoryid > 0 ? " AND parentid =".$categoryid : "";
 		if(!empty($custom_field_kw_array) ){ //if($categoryid && !empty($custom_field_kw_array)
 			$isFirst = true;

 			foreach($custom_field_kw_array as $field => $keyword){
				if($keyword != 'Any' && !is_array($keyword) && $keyword != ''){
					if($isFirst){
						$sql .= " AND";
					}else{
						$sql .= $andOr;
					}
				$sql .= " itemid IN
					(Select ".$this->db->prefix('smartshop_item_attribut').".itemid
					FROM ".$this->db->prefix('smartshop_item_attribut').", ".$this->db->prefix('smartshop_category_attribut')."
					WHERE ".$this->db->prefix('smartshop_category_attribut.attributid')." = ".$this->db->prefix('smartshop_item_attribut.attributid')."
					AND (".$this->db->prefix('smartshop_category_attribut').".parentid = ".$categoryid." OR ".$this->db->prefix('smartshop_category_attribut').".parentid = 0)";

					$sql .= " AND (".$this->db->prefix('smartshop_category_attribut.name')." = '".$field."'
							AND ".$this->db->prefix('smartshop_item_attribut.value')." LIKE '%".$keyword."%')) ";

				}
				elseif(is_array($keyword)){
					if($isFirst){
						$sql .= " AND";
					}else{
						$sql .= $andOr;
					}
					$sql .= " itemid IN
					(Select ".$this->db->prefix('smartshop_item_attribut').".itemid
					FROM ".$this->db->prefix('smartshop_item_attribut').", ".$this->db->prefix('smartshop_category_attribut')."
					WHERE ".$this->db->prefix('smartshop_category_attribut.attributid')." = ".$this->db->prefix('smartshop_item_attribut.attributid')."
					AND (".$this->db->prefix('smartshop_category_attribut').".parentid IN (".implode(', ',$ascendency)."))";

					$sql .= " AND (".$this->db->prefix('smartshop_category_attribut.name')." = '".$field."'
							AND (".$this->db->prefix('smartshop_item_attribut.value')." LIKE '%".implode("%' ".$andOr." ".$this->db->prefix('smartshop_item_attribut.value')." LIKE '%", $keyword)."%'))) ";
				}
				$isFirst = false;
			}
 		}

		$ret = false;

		$limit = $start = 0;


		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			echo "Please please copy the query below and contact the administrator about this problem. Thank you.<br><br>".$sql;
			exit;
			return $ret;
		}

		if (count($result) == 0) {
			return $ret;
		}


		while ($myrow = $this->db->fetchArray($result)) {
			$item = new SmartshopItem();
			$item->assignVars($myrow);
			//$item->initiateCustomFields();
			$ret[] =& $item;
			unset($item);
		}
		$ret = $this->initiateCustomFields($ret);
		return $ret;
	}

	function getItemsFromSearch($queryarray = array(), $andor = 'OR', $limit = 0, $offset = 0, $userid = 0)
	{
	$ret = array();

	$sql = "SELECT * FROM ".$this->db->prefix('smartshop_item')." WHERE itemid IN (
			SELECT DISTINCT ".$this->db->prefix('smartshop_item.itemid')." FROM ".$this->db->prefix('smartshop_item')." LEFT JOIN ".
			$this->db->prefix('smartshop_item_attribut')." ON  ".
			$this->db->prefix('smartshop_item.itemid')." = ".$this->db->prefix('smartshop_item_attribut.itemid')." LEFT JOIN ".
			$this->db->prefix('smartshop_attribut_option')." ON (".
			$this->db->prefix('smartshop_item_attribut.attributid')." =  ".$this->db->prefix('smartshop_attribut_option.attributid')."
			AND  ".$this->db->prefix('smartshop_item_attribut.value')." =  ".$this->db->prefix('smartshop_attribut_option.optionid').")";

	$sql .= " WHERE status = "._SSHOP_STATUS_ONLINE;



	if ($userid != 0) {
		$sql .= " AND uid = ".$userid;
	}

	if ($queryarray) {
		$sql .= " AND (";
		for ($i = 0; $i < count($queryarray); $i++) {
			$sql .= " ( ".$this->db->prefix('smartshop_item').".name LIKE '%" . $queryarray[$i] . "%' OR ";
			$sql .= " ".$this->db->prefix('smartshop_item').".description LIKE '%" . $queryarray[$i] . "%' OR ";
			$sql .= " ".$this->db->prefix('smartshop_attribut_option.caption')." LIKE '%" . $queryarray[$i] . "%') ";
			//$sql .= " ".$this->db->prefix('smartshop_item_attribut.value')." LIKE '%" . $queryarray[$i] . "%' ) ";

			if($i < (count($queryarray) -1)){
				$sql .= $andor;
			}
		}
		$sql .= " )) OR ".$this->db->prefix('smartshop_item').".itemid IN ( SELECT DISTINCT ".$this->db->prefix('smartshop_item').".itemid FROM ".$this->db->prefix('smartshop_item').", ".$this->db->prefix('smartshop_item_attribut')."
			WHERE ".$this->db->prefix('smartshop_item').".itemid = ".$this->db->prefix('smartshop_item_attribut.itemid')."
			AND status = "._SSHOP_STATUS_ONLINE." AND (";

		for ($i = 0; $i < count($queryarray); $i++) {
			$sql .= " ".$this->db->prefix('smartshop_item_attribut.value')." LIKE '%" . $queryarray[$i] . "%'  ";
			if($i < (count($queryarray) -1)){
				$sql .= 'OR';
			}
		}



	}
	$sql .= " ))";

	$result = $this->db->query($sql, $limit, $offset);
	if (!$result) {
		echo "Please please copy the query below and contact the administrator about this problem. Thank you.<br><br>".$sql;
		exit;
		return $ret;
	}

	if (count($result) == 0) {
		return $ret;
	}


	while ($myrow = $this->db->fetchArray($result)) {
		$item = new SmartshopItem();
		$item->assignVars($myrow);
		$item->initiateCustomFields();
		$itemsObj[] =& $item;
		unset($item);
	}


	$smartshop_category_handler =& smartshop_gethandler('category');
	$categoriesObj = $smartshop_category_handler->getObjects();
	$categories = array();
	foreach($categoriesObj as $catObj){
		$categories[$catObj->getVar('categoryid')] = $catObj->getVar('name');
	}

	foreach ($itemsObj as $itemObj) {
		$item['id'] = $itemObj->getVar('itemid');
		$item['title'] = $itemObj->getVar('name') . " (" . $categories[$itemObj->getVar('parentid')] . ")";
		$item['date'] = $itemObj->getVar('date', 'e');
		$item['uid'] = $itemObj->getVar('uid', 'e');

		$ret[] = $item;
		unset($item);
	}

	return $ret;
	}

	function getCurrencies()  {
    	return $this->currenciesList;
    }

	/*function beforeSave(&$obj) {
		$error = false;
		$obj->initiateCustomFields();
		foreach($obj->controls as $key=>$control){
			if($control['name'] == 'file'){
				if (isset($_POST['smart_upload_file'])) {
				    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartuploader.php";
					$uploaderObj = new SmartUploader($this->getImagePath(true), $this->_allowedMimeTypes, $this->_maxFileSize, $this->_maxWidth, $this->_maxHeight);
					foreach ($_FILES as $name=>$file_array) {
						if (isset ($file_array['name']) && $file_array['name'] != "" ) {
							if ($uploaderObj->fetchMedia($name)) {
								$uploaderObj->setTargetFileName(time()."_+_". $uploaderObj->getMediaName());
								if ($uploaderObj->upload()) {
									// Find the related field in the SmartObject
									$related_field = $key;
									$obj->setVar($related_field, $uploaderObj->getSavedFileName());
								} else {
									$error = true;
									$obj->setErrors($uploaderObj->getErrors(false));
								}
							} else {
								$error = true;
								$obj->setErrors($uploaderObj->getErrors(false));
							}
						}
					}
				}
			}
		}
		if ($error) {
			return false;
		} else {
			return true;
		}
    }*/


}
?>