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
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";
class SmartshopCategory_attribut extends SmartObject {

    function SmartshopCategory_attribut() {
        $this->initVar('attributid', XOBJ_DTYPE_INT, '', true);
        $this->initVar('parentid', XOBJ_DTYPE_INT, '', false, null,'', false, _CO_SSHOP_CAT_ATTRIBUT_CAT, _CO_SSHOP_CAT_ATTRIBUT_CAT_DSC, true);
        $this->hideFieldFromForm('parentid');
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, '', true);
        $this->hideFieldFromForm('name');
        $this->initVar('caption', XOBJ_DTYPE_TXTBOX, '', true, 255, '', false, _CO_SSHOP_CAT_ATT_CAPTION, _CO_SSHOP_CAT_ATT_CAPTION_DSC, true);
        $this->initVar('description', XOBJ_DTYPE_TXTAREA, '', false, null,'', false, _CO_SSHOP_CAT_ATT_DESCRIPTION, _CO_SSHOP_CAT_ATT_DESCRIPTION_DSC);
        $this->initVar('att_type', XOBJ_DTYPE_TXTBOX, 'text', false, null, '', false, _CO_SSHOP_CAT_ATT_TYPE, _CO_SSHOP_CAT_ATT_TYPE_DSC);
        $this->initVar('dependent_attributid', XOBJ_DTYPE_TXTBOX, 0, false, null, '', false, _CO_SSHOP_CAT_DEPENDENT_ATT_ID, _CO_SSHOP_CAT_DEPENDENT_ATT_ID_DSC);

		// not persistent options
        $this->initVar('options', XOBJ_DTYPE_TXTAREA, '', false, null,'', false,  _CO_SSHOP_CAT_OPTIONS, _CO_SSHOP_CAT_OPTIONS_DSC, false, false);

        $this->initVar('required', XOBJ_DTYPE_INT, '', false, null,'', false,  _CO_SSHOP_CAT_ATT_REQ, _CO_SSHOP_CAT_ATT_REQ_DSC);
        $this->initVar('att_default', XOBJ_DTYPE_TXTAREA, '', false, null,'', false,  _CO_SSHOP_CAT_ATT_DEFAULT, _CO_SSHOP_CAT_ATT_DEFAULT_DSC);
        $this->initVar('sortable', XOBJ_DTYPE_INT, '', false, null, '', false, _CO_SSHOP_CAT_ATT_SORTABLE, _CO_SSHOP_CAT_ATT_SORTABLE_DSC);
        $this->initVar('searchable', XOBJ_DTYPE_INT, 1, false, null,'', false, _CO_SSHOP_CAT_ATT_SEARCHABLE, _CO_SSHOP_CAT_ATT_SEARCHABLE_DSC, true);
        $this->initVar('display', XOBJ_DTYPE_INT, 1, false, null,'', false, _CO_SSHOP_CAT_ATT_DISPLAY, _CO_SSHOP_CAT_ATT_DISPLAY_DSC, true);
        $this->initVar('summarydisp', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_CAT_ATT_SUMMARYDISPLAY, _CO_SSHOP_CAT_ATT_SUMMARYDISPLAY_DSC, true);
		$this->initVar('searchdisp', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_CAT_ATT_SEARCHDISPLAY, _CO_SSHOP_CAT_ATT_SEARCHDISPLAY_DSC, true);
		$this->initVar('checkoutdisp', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_CAT_ATT_CHECKOUTDISPLAY, _CO_SSHOP_CAT_ATT_CHECKOUTDISPLAY_DSC, true);
		$this->initVar('unicity', XOBJ_DTYPE_INT, 0, false, null,'', false, _CO_SSHOP_CAT_ATT_UNIQUE, _CO_SSHOP_CAT_ATT_UNIQUE_DSC, true);
		$this->initVar('custom_rendering', XOBJ_DTYPE_TXTAREA, '', false, null,'', false, _CO_SSHOP_CUSTOM_RENDERING, _CO_SSHOP_CUSTOM_RENDERING_DSC);
		$this->initVar('size', XOBJ_DTYPE_INT, '', false, null,'', false, _CO_SSHOP_CAT_ATT_SIZE, _CO_SSHOP_CAT_ATT_SIZE_DSC);

        $this->initCommonVar('weight');

        $this->setControl('parentid', array('name' => 'parentcategory',
        									'options' => array('addNoParent'=>false)));
        $this->setControl('options', array('name' => 'textarea',
        									'options' => array('editor'=>'text')));

        $this->setControl('description', array('name' => 'textarea',
        									'options' => array('editor'=>'text')));

        $this->setControl('required', "yesno");
        $this->setControl('sortable', "yesno");
        $this->setControl('searchable', "yesno");
        $this->setControl('display', "yesno");
        $this->setControl('summarydisp', "yesno");
        $this->setControl('searchdisp', "yesno");
        $this->setControl('checkoutdisp', "yesno");
        //$this->setControl('unicity', array('name' => "yesno", 'js' => '$smartshop_item_attribut_handler->getJsForUnique($key)'));
        $this->setControl('unicity', "yesno");
        $this->setControl('att_default', array('name' => 'textarea',
        									'options' => array('editor'=>'text')));

        $this->setControl('att_type', array('name' => false,
                                          'itemHandler' => 'category_attribut',
                                          'method' => 'getType',
                                          'module' => 'smartshop',
                                          'onSelect' => 'submit')
                                          );
        $this->setControl('dependent_attributid', array('name' => false,
                                          'object' => &$this,
                                          'method' => 'getOtherAttributsForParent',
                                          'module' => 'smartshop',
                                          'onSelect' => 'submit')
                                          );
		$this->setControl('custom_rendering', array('name' => 'textarea',
       											'options' => array('editor'=>'text')));
    }
    function getOtherAttributsForParent() {
		global $smartshop_category_attribut_handler;
		return $smartshop_category_attribut_handler->getCategoryAttributForId($this->getVar('parentid'));

    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('categoryid', 'att_type'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function categoryid(){

        global $smartshop_category_handler;

        $obj =& $smartshop_category_handler->get($this->getVar('categoryid', 'e'));
        $ret = $obj->getVar('name');
        return $ret;
    }
    function att_type() {
        global $typeArray;
        $ret = isset($typeArray[$this->getVar('att_type', 'e')]) ? $typeArray[$this->getVar('att_type','e')] : _CO_SSHOP_TYPE_UNDEFINED;
        return $ret;
    }

    function getObjectType() {
    	switch ($this->getVar('att_type', 'n')) {
    		case 'check' :
    			return XOBJ_DTYPE_SIMPLE_ARRAY;
    			break;

			case 'select_multi' :
    			return XOBJ_DTYPE_SIMPLE_ARRAY;
    			break;

    		case 'html' :
    			return XOBJ_DTYPE_TXTAREA;
    			break;

    		case 'radio' :
    			return XOBJ_DTYPE_TXTBOX;
    			break;

    		case 'select' :
    			return XOBJ_DTYPE_TXTBOX;
    			break;

    		case 'tarea' :
    			return XOBJ_DTYPE_TXTBOX;
    			break;

			case 'text' :
    			return XOBJ_DTYPE_TXTBOX;
    			break;

			case 'yn' :
    			return XOBJ_DTYPE_INT;
    			break;

			case 'file' :
    			return XOBJ_DTYPE_FILE;
    			break;

    		case 'urllink' :
    			return XOBJ_DTYPE_URLLINK;
    			break;

			case 'image' :
    			return XOBJ_DTYPE_IMAGE;
    			break;

    		default:
    		//case 'text' :
    			return XOBJ_DTYPE_TXTBOX;
    			break;
    	}
    }

    function getOptionsArray() {
    	/**$options = ($this->getVar('options', 'N'));
    	$aOptions = explode("\n", $options);
    	$ret = array();
    	foreach ($aOptions as $option) {
    		$option = trim($option);
    		$ret[$option] = $option;
    	}
    	return $ret;
    	**/
    	global $smartshop_attribut_option_handler;
    	if(!isset($smartshop_attribut_option_handler)){
			$smartshop_attribut_option_handler =& xoops_getmodulehandler('attribut_option', 'smartshop');
		}
    	return $smartshop_attribut_option_handler->getOptionsByAttribut($this->getVar('attributid', 'n'));
    }

	function getJsForUnique(){
    	global $smartshop_item_attribut_handler;
    	if(!isset($smartshop_item_attribut_handler)){
			$smartshop_item_attribut_handler =& xoops_getmodulehandler('item_attribut', 'smartshop');
		}
    	$js = '';
    	if($this->getVar('unicity') == 1){
	    	$values = $smartshop_item_attribut_handler->getExistingValues($this->getVar('attributid', 'n'));
	    	foreach($values as $val){
	    		$js .=  'if ( myform.'.$this->getVar('name').'.value == "'.$val.'" ) { window.alert(" '.$this->getVar('caption')._CO_SSHOP_ERROR_UNIQUE_MSG.'"); myform.'.$this->getVar('name').'.focus(); return false; }';
	    	}
    	}
    	return $js;
    }

    function getOptionsForTextarea() {
    	$ret = $this->getOptionsArray();
    	$ret = implode($ret, "\n");
    	return $ret;
    }

    function generateUniqueFieldName() {
	    $title   = rawurlencode(strtolower($this->getVar('caption')));

	    // Transformation des ponctuations
	    //                 Tab     Space      !        "        #        %        &        '        (        )        ,        /        :        ;        <        =        >        ?        @        [        \        ]        ^        {        |        }        ~       .
	    $pattern = array("/%09/", "/%20/", "/%21/", "/%22/", "/%23/", "/%25/", "/%26/", "/%27/", "/%28/", "/%29/", "/%2C/", "/%2F/", "/%3A/", "/%3B/", "/%3C/", "/%3D/", "/%3E/", "/%3F/", "/%40/", "/%5B/", "/%5C/", "/%5D/", "/%5E/", "/%7B/", "/%7C/", "/%7D/", "/%7E/", "/\./");
	    $rep_pat = array(  "_"  ,   "_"  ,   "_"  ,   "_"  ,   "_"  , "_100" ,   "_"  ,   "_"  ,   "_"  ,   "_"  ,   "_"  ,   "_"  ,  "_"   ,   "_"  ,   "_"  ,   "_"  ,  "_"   ,   "_"  , "_at_" ,   "_"  ,   "_"   ,  "_"  ,   "_"  ,   "_"  ,   "_"  ,   "_"  ,   "_"  ,   "_" );
	    $title   = preg_replace($pattern, $rep_pat, $title);

    	// Transformation des caractères accentués
    	//                  °        è        é        ê        ë        ç        à        â        ä        î        ï        ù        ü        û        ô        ö
    	$pattern = array("/%B0/", "/%E8/", "/%E9/", "/%EA/", "/%EB/", "/%E7/", "/%E0/", "/%E2/", "/%E4/", "/%EE/", "/%EF/", "/%F9/", "/%FC/", "/%FB/", "/%F4/", "/%F6/");
	    $rep_pat = array(  "_"  ,   "e"  ,   "e"  ,   "e"  ,   "e"  ,   "c"  ,   "a"  ,   "a"  ,   "a"  ,   "i"  ,   "i"  ,   "u"  ,   "u"  ,   "u"  ,   "o"  ,   "o"  );
    	$title   = preg_replace($pattern, $rep_pat, $title);

		$tableau = explode("_", $title); // Transforme la chaine de caractères en tableau
		$tableau = array_filter($tableau, array($this, "emptyString")); // Supprime les chaines vides du tableau
		$title   = implode("_", $tableau); // Transforme un tableau en chaine de caractères séparé par un tiret

		global $smartshop_category_attribut_handler;
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('name', $title));
		$result = $smartshop_category_attribut_handler->getCount($criteria);

		//some prefixes reserved for files and urlinks or for item obj variable name
		if(substr($title,0 ,4) == 'url_' || substr($title,0 ,8) == 'caption_' || substr($title,0 ,12) == 'description_' || substr($title,0 ,7) == 'target_'
			|| in_array($title, array( 'description' , 'price' ,  'parentid', 'name', 'weight', 'itemid', 'currency', 'uid', 'date',  'no_exp',  'exp_date',
										 'mail_status',  'status',  'image',  'counter',  'dohtml',  'dosmiley', 'doxcode',  'doimage',  'dobr'))){

			$title = '_'.$title;
		}

		if ($result > 1) {
			$title = $title . '_' . time();
		}
		return $title;
    }

	function emptyString($var)
	{
   		return (strlen($var) > 0);
	}

	function getWeightControl() {
		$control = new XoopsFormText('', 'weight_' . $this->id(), 5, 100, $this->getVar('weight'));
		return $control->render();
    }



	function getRequiredControl(){
		if($this->getVar('att_type', 'e') == 'form_section'){
			return '&nbsp;';
		}
		$control = new XoopsFormRadioYN('', 'required_' . $this->id(), $this->getVar('required'));
		return $control->render();
	}
	function getSortableControl(){
		if($this->getVar('att_type', 'e') == 'form_section'){
			return '&nbsp;';
		}
		$control = new XoopsFormRadioYN('', 'sortable_' . $this->id(), $this->getVar('sortable'));
		return $control->render();
	}
	function getSearchableControl(){
		if($this->getVar('att_type', 'e') == 'form_section'){
			return '&nbsp;';
		}
		$control = new XoopsFormRadioYN('', 'searchable_' . $this->id(), $this->getVar('searchable'));
		return $control->render();
	}
	function getDisplayControl(){
		if($this->getVar('att_type', 'e') == 'form_section'){
			return '&nbsp;';
		}
		$control = new XoopsFormRadioYN('', 'display_' . $this->id(), $this->getVar('display'));
		return $control->render();
	}
	function getSummarydispControl(){
		if($this->getVar('att_type', 'e') == 'form_section'){
			return '&nbsp;';
		}
		$control = new XoopsFormRadioYN('', 'summarydisp_' . $this->id(), $this->getVar('summarydisp'));
		return $control->render();
	}

	function getCheckoutdispControl(){
		if($this->getVar('att_type', 'e') == 'form_section'){
			return '&nbsp;';
		}
		$control = new XoopsFormRadioYN('', 'checkoutdisp_' . $this->id(), $this->getVar('checkoutdisp'));
		return $control->render();
	}
}

class SmartshopCategory_attributHandler extends SmartPersistableObjectHandler {
    function SmartshopCategory_attributHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'category_attribut', 'attributid', 'caption', false, 'smartshop');
    }

    function getStatus(){
        global $statusArray;
        return $statusArray;
    }

    function getType() {
    	global $typeArray;
        return $typeArray;
    }

	function beforeUpdate(&$category_attributObj){
		if(isset($_POST['att_default']) && is_array($_POST['att_default'])){
			$category_attributObj->setVar('att_default', implode('|', $_POST['att_default']));
		}
		return true;
	}

    function afterSave(&$category_attributObj) {
    	global $smartshop_attribut_option_handler;
    	if ($category_attributObj->getVar('dependent_attributid') == 0) {
	    	$aOptions = explode("\n", $_POST['options']);
	    	foreach ($aOptions as $k=>$v) {
	    		$v = trim($v);
	    		$aOptions[$k] = $v;
	    	}
    		foreach($aOptions as $caption) {
				$default = false;
				if(substr($caption, 0, 3) == '***'){
					$caption = substr($caption, 3);
					$default = true;
				}
				$newOption = $smartshop_attribut_option_handler->create();
				$newOption->setVar('attributid', $category_attributObj->getVar('attributid'));
				$newOption->setVar('caption', $caption);
				$smartshop_attribut_option_handler->insert($newOption);
				if($default){
					$defaultArray[] = $newOption->id();
				}
			}
			$this->disableEvent('afterSave');
			if($defaultArray){
				$category_attributObj->setVar('att_default',implode('|', $defaultArray));
				$this->insert($category_attributObj);
			}
	    	return true;
    	} else {
	    	$options_count = $_POST['options_count_options'];
	    	for ($i=0;$i<$options_count;$i++) {
				$option_text_value = $_POST['option_text_options_' . $i];
				$option_select_value = $_POST['option_select_options_' . $i];
				$newOption = $smartshop_attribut_option_handler->create();
				$newOption->setVar('attributid', $category_attributObj->getVar('attributid'));
				$newOption->setVar('caption', $option_text_value);
				$newOption->setVar('linked_attribut_option_id', $option_select_value);
				if (!$smartshop_attribut_option_handler->insertD($newOption)) {
					$category_attributObj->setErrors("Unable to store option '" . $option_text_value . "'.");
				}
	    	}
	    	return !$category_attributObj->hasError();
    	}
    }
       function afterUpdate(&$category_attributObj){
    	global $smartshop_item_attribut_handler;

    	if($_POST['old_type'] != $_POST['att_type'] && ($_POST['old_type'] == 'file' ||  $_POST['att_type'] == 'file' ||	$_POST['old_type'] == 'urllink' ||  $_POST['att_type'] == 'urllink' ||
				$_POST['old_type'] == 'yes_no' ||  $_POST['att_type'] == 'yes_no' ||$_POST['old_type'] == 'image' ||  $_POST['att_type'] == 'image')){
			if($_POST['att_default'] != ''){
    			return $smartshop_item_attribut_handler->resetValues($category_attributObj->id(), $category_attributObj->getVar('att_default'));

    		}else{
    			return $smartshop_item_attribut_handler->resetValues($category_attributObj->id());
			}
		}

    	if($_POST['old_type'] == 'check' || $_POST['old_type'] ==' select_multi'){
    		$oldType = 'multi';
    	}elseif($_POST['old_type'] == 'radio' ||  $_POST['old_type'] == 'select'){
    		$oldType = 'single';
    	}else{
    		$oldType = 'free';
    	}
    	if($_POST['att_type'] == 'check' || $_POST['att_type'] == 'select_multi'){
    		$newType = 'multi';
    	}elseif($_POST['att_type'] == 'radio' || $_POST['att_type'] == 'select'){
    		$newType = 'single';
    	}else{
    		$newType = 'free';
    	}

    	if($oldType != $newType && !($oldType == 'single' && $newType == 'multi') ){
    		if($_POST['att_default'] != ''){
    			return $smartshop_item_attribut_handler->resetValues($category_attributObj->id(), $category_attributObj->getVar('att_default'));

    		}else{
    			return $smartshop_item_attribut_handler->resetValues($category_attributObj->id());
			}
       	}else{
    		return true;
    	}

    }

    function beforeInsert(&$category_attributObj) {
    	$title  = $category_attributObj->generateUniqueFieldName();
    	$category_attributObj->setVar('name', $title);
    	return true;
    }

    function getCategoryAttributForId($parentid=0) {
    	$criteria = new CriteriaCompo();

    	if ($parentid == 0) {
    		$parentid = $_GET['categoryid'];
    	}

    	$criteria->add(new Criteria('parentid', "($parentid , 0 )", 'IN'));
    	$criteria->add(new Criteria('att_type', "('check', 'radio', 'select', 'select_multi')", 'IN'));
    	$attributsArray = $this->getList($criteria);
    	$ret = array (0 => _CO_SSHOP_NO_DEPENDENCY);
    	foreach($attributsArray as $k=>$v) {
    		$ret[$k] = $v;
    	}
    	return $ret;
    }

    function getOptionsFields($parentid){
    	global $smartshop_category_handler;
    	static $categoriesObj4getOptionsFields;
    	if(empty($categoriesObj4getOptionsFields)){
    		$categoriesObj4getOptionsFields = $smartshop_category_handler->getObjects(null, true);
   		}
    	$parentArray = array(0, $parentid);
    	$catObj = $categoriesObj4getOptionsFields[$parentid];
    	while($catObj->getVar('parentid', 'e') != 0){
    		$parentArray[] = $catObj->getVar('parentid', 'e');
    		$catObj = $categoriesObj4getOptionsFields[$catObj->getVar('parentid', 'e')];
    	}

    	/*$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('parentid', "(".implode(', ', $parentArray).")", 'IN'));
    	$criteria->add(new Criteria('att_type', "('check', 'radio', 'select', 'select_multi')", 'IN'));
    	$attributsObj = $this->getObjects($criteria);
    	foreach($attributsObj as $attributObj) {
    		$ret[$attributObj->getVar('name')] = $attributObj->getOptionsArray();
    	}*/
    	static $attributsObj4getOptionsFields;
    	if(!isset($attributsObj4getOptionsFields[$parentid])){
	    	$criteria = new CriteriaCompo();
	    	$criteria->add(new Criteria('parentid', "(".implode(', ', $parentArray).")", 'IN'));
	    	$criteria->add(new Criteria('att_type', "('check', 'radio', 'select', 'select_multi')", 'IN'));
	    	$attributsObj4getOptionsFields[$parentid] = $this->getObjects($criteria);
    	}
	    foreach($attributsObj4getOptionsFields[$parentid] as $attributObj) {
    		$ret[$attributObj->getVar('name')] = $attributObj->getOptionsArray();
    	}
    	return $ret;
    }

    function getCustomRederingFields($parentid){
    	static $attributsObj4getCustomRederingFields;
    	if(!isset($attributsObj4getCustomRederingFields[$parentid])){
	    	$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('parentid', '('.$parentid.', 0)', 'IN'));
			$criteria->add(new Criteria('custom_rendering', 0, '>'));
			$attributsObj4getCustomRederingFields[$parentid] = $this->getObjects($criteria,0,1);
    	}
		$ret = array();
		foreach($attributsObj4getCustomRederingFields[$parentid] as $crf){
			$ret[$crf->getVar('name')] = $crf->getVar('custom_rendering', 'n');
		}
		return $ret;
    }

    function getCatAtt4Cat($categoryid)
    {
     global $smartshop_category_attribut_handler, $smartshop_category_handler;
	  if(!isset($smartshop_category_handler)){
	   $smartshop_category_handler =& xoops_getmodulehandler('category', 'smartshop');
	   }
	  static $categoy_attributs_array;
	  if (!isset($categoy_attributs_array[$categoryid])) {
	      $criteria = new CriteriaCompo();
	      $criteria->add(new Criteria('parentid', '( 0, ' . $smartshop_category_handler->getParentIds($categoryid) . ')', 'IN'));
	      $criteria->setSort('weight');
	      $categoy_attributs_array[$categoryid] =& $this->getObjects($criteria);

	  }
     return $categoy_attributs_array[$categoryid];
    }



}
?>