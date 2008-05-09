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
class SmartshopTransaction extends SmartObject {
		var $customfields = null;
    function SmartshopTransaction() {
    	global $smartShopConfig;

        $this->initVar('transactionid', XOBJ_DTYPE_INT, '', true, null, '', false, _CO_SSHOP_TRANS_TRANSACTIONID);
		$this->initVar('basketid', XOBJ_DTYPE_INT, '', true, null, '', false, _CO_SSHOP_TRANS_TRANSACTIONID);
		$this->initVar('tran_date', XOBJ_DTYPE_LTIME, 0, false, null,'', false, _CO_SSHOP_TRANS_DATE, _CO_SSHOP_TRANS_DATE_DSC, true);
        $this->initVar('tran_uid', XOBJ_DTYPE_INT, '', false, null, '', false, _CO_SSHOP_TRANS_UID, _CO_SSHOP_TRANS_UID_DSC);
		//$this->initVar('price', XOBJ_DTYPE_CURRENCY, '', false, null,'', false,  _CO_SSHOP_TRANS_PRICE, _CO_SSHOP_TRANS_PRICE_DSC);
		//$this->initVar('currency', XOBJ_DTYPE_TXTBOX, '', false, null,'', false,  _CO_SSHOP_TRANS_CURRENCY, _CO_SSHOP_TRANS_CURRENCY_DSC);
		/*$this->initVar('name', XOBJ_DTYPE_TXTBOX, '', false, null,'', false);
		$this->initVar('address', XOBJ_DTYPE_TXTAREA, '', false, null,'', false);
		$this->initVar('email', XOBJ_DTYPE_TXTBOX, '', false, null,'', false);*/

		$this->setControl('tran_uid', 'user');
       	$this->setControl('currency', array('itemHandler' => 'item',
							            'method' => 'getCurrencies',
							            'module' => 'smartshop'));
		$this->hideFieldFromSingleView('transactionid');
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
    	global $smartshop_item_attribut_handler, $smartshop_attribut_option_handler;
    	if(!isset($this->customfields)){
    		$this->customfields = $this->getCustomFields();
    	}
    	foreach($this->customfields as $customfieldObj){
    		if($key == $customfieldObj->getVar('name') && in_array($customfieldObj->getVar('att_type', 'n'), array('select', 'select_multi', 'radio', 'check', 'yn'))){
				$criteria = new CriteriaCompo();

				$criteria->add(new Criteria('attributid', $customfieldObj->getVar('attributid')));
				$criteria->add(new Criteria('itemid', $this->id()));
				$Objs = $smartshop_item_attribut_handler->getObjects($criteria);
				unset($criteria);
				$item_attributObj = $Objs[0];
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('attributid', $customfieldObj->getVar('attributid')));
				$criteria->add(new Criteria('itemid', $this->id()));

				$options = $smartshop_attribut_option_handler->getOptionsByAttribut($customfieldObj->getVar('attributid'));
    			if(isset($item_attributObj)){
    				return 	$options[$item_attributObj->getVar('value')];
    			}else{
    				return "";
    			}
    		}
      	}
    	if ($format == 's' && in_array($key, array('tran_uid', 'currency'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

/* 	function getVarForExport($key) {
		if (in_array($key, array('tran_uid', 'itemid'))) {
			return call_user_func(array($this . 'Export',$key));
		}
		return parent::getVar($key);
 	}
*/


    function tran_uid() {
        $ret = smart_getLinkedUnameFromId($this->getVar('tran_uid', 'e'), true);
        return $ret;
    }

    function currency() {
        global $currencyArray;
        $ret = isset($currencyArray[$this->getVar('currency', 'e')]) ? $currencyArray[$this->getVar('currency','e')] : _CO_SSHOP_CURRENCY_UNDEFINED;
        return $ret;
    }

    function basketToTransaction($save = true){
    	global  $smartshop_basket_handler, $xoopsUser;
    	$basket = $smartshop_basket_handler->get();

    	$this->setVar('basketid', $basket->id());
		$this->setVar('tran_date', time());
		$this->setVar('tran_uid', is_object($xoopsUser)? $xoopsUser->getVar('uid') : 0);
		$basket_itemsObj = $basket->getItems();
		$price = 0;
		foreach($basket_itemsObj as $basket_itemObj){
			$price += $basket_itemObj->getVar('item_price')*$basket_itemObj->getVar('quantity');
		}
		$this->setVar('price', $price);

		if($save){
			if($this->handler->insert($this)){
				$smartshop_basket_handler->delete($basket);
				return true;
			}else{
				return false;
			}
		}
		return true;
    }

    function getSummaryForEmail(){
    	global $smartshop_basket_item_handler, $xoopsModuleConfig, $smartshop_basket_handler, $myts;

    	$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('basketid', $this->getVar('basketid')));
		$basket_itemsObj = $smartshop_basket_item_handler->getObjects($criteria);
		$basket = $smartshop_basket_handler->get();
		$basket->prepareCheckout();
		$checkOutFields = $basket->getCheckoutFields();
		$summary = '<table><tr><td>'._CO_SSHOP_ITEM_NAME.'</td>';
		foreach($checkOutFields as $key => $checkOutField){
					$summary .= "<td>".$checkOutField."</td>";
				}
		if(in_array('price',$xoopsModuleConfig['display_fields'])){
			$summary .= '<td align="right">'._CO_SSHOP_TRANS_PRICE.'</td>';
		}
		$summary .= '<td align="right">'._CO_SSHOP_TRANS_QUANTITY.'</td></tr>';

		foreach($basket_itemsObj as $basket_itemObj){
			if(intVal($basket_itemObj->getVar('quantity')) > 0){
				$summary .= "<tr><td>".$myts->undoHtmlSpecialChars($basket_itemObj->getVar('item_name'))."</td>";
				foreach($checkOutFields as $key => $checkOutField){
					$summary .= "<td>".$basket_itemObj->getCheckoutFieldValue(array('basket'=>$basket, 'key'=>$key))."</td>";
				}
				if(in_array('price',$xoopsModuleConfig['display_fields'])){
					$summary .= "<td  align='right'>".$basket_itemObj->getVar('item_price')."</td>";
				}
				$summary .= "<td align='right'>".$basket_itemObj->getVar('quantity')."</td></tr>";
			}
		}
		$summary .= '</tr></table>';
		$summary .= '<br/><table>';
		if(in_array('price',$xoopsModuleConfig['display_fields'])){
			$summary .= "<tr><td>"._MD_SSHOP_TOTAL."</td><td>".$this->getVar('price')."</td></tr>";
		}

		$summary .= '</table>';

		return $summary;

    }

   /* function initiateCustomFields() {

    	// $constantVars are the vars without the dynamic fields
    	$constantVars = $this->vars;
    	$category_attributObjs =& $this->getCustomFields();

    	global $smartshop_item_attribut_handler, $xoopsModuleConfig;
    	foreach ($category_attributObjs as $category_attributObj) {

	    	if (!$this->isNew()) {
		    	$item_attributObj =& $smartshop_item_attribut_handler->get(array($category_attributObj->getVar('attributid'), $this->getVar('transactionid')));
		    	$value = $item_attributObj->getVar('value', 'e');
	    	} else {
	    		$value = $category_attributObj->getVar('att_default');
	    	}

			if($category_attributObj->getVar('att_type', 'n') == 'form_section'){
				$this->addFormSection($category_attributObj->getVar('name'), $category_attributObj->getVar('caption', 'n'));
			}
			//ajout d'un else
			else{
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
    	}//fin du else ajouté
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
*/
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
				$criteria->add(new Criteria('itemid', $this->getVar('transactionid')));
				$item_attributsObj = $smartshop_item_attribut_handler->getObjects($criteria);
			}
		}

		foreach ($category_attributObjs as  $category_attributObj) {
			if (!$this->isNew()) {
				$value = $item_attributsObj[$this->getVar('transactionid')][$category_attributObj->id()]->getVar('value', 'e');
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

				case 'form_section' :
					$this->setControl($category_attributObj->getVar('name'), "section");
					break;

	    		default:

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

    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('parentid', '-1'));
    	$criteria->setSort('weight');
    	$category_attributObjs =& $smartshop_category_attribut_handler->getObjects($criteria);
    	return $category_attributObjs;
    }

       function toArray() {
    	global  $smartshop_category_attribut_handler;
    	$objectArray = parent::toArray();

    	$optionFields = $smartshop_category_attribut_handler->getOptionsFields($this->getVar('parentid'));
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
    		}
    	}

    	return $objectArray;
    }

	function getCustomFieldForEmail(){
		$ret = "<table>";
		foreach($this->getCustomFields() as $cf){
			if($cf->att_type() != _CO_SSHOP_FORM_SECTION)
			$ret .= "<tr><td>".$cf->getVar('caption')."</td><td>".$this->getVar($cf->getVar('name'))."</td></tr>";
		}
		$ret .= "</table>";
		return $ret;
	}

}

class SmartshopTransactionHandler extends SmartPersistableObjectHandler {
    function SmartshopTransactionHandler($db) {

        $this->SmartPersistableObjectHandler($db, 'transaction', 'transactionid', 'transactionid', '', 'smartshop');
	}

	function afterSave(&$transactionObj){
		// no errors, we are good to go to save the custom fields
        global $smartshop_item_attribut_handler;
        $customFieldsObj =& $transactionObj->getCustomFields();
        foreach($customFieldsObj as $customField) {
        	$item_attributObj =& $smartshop_item_attribut_handler->get(array($customField->getVar('attributid'), $transactionObj->getVar('transactionid')));
        	if ($item_attributObj->isNew()) {
        		$item_attributObj->setVar('attributid', $customField->getVar('attributid'));
        		$item_attributObj->setVar('itemid', $transactionObj->getVar('transactionid'));
        	}
       		/*if(($customField->getVar('att_type', 'n') == 'file'
       				&& isset($_FILES['upload_'.$customField->getVar('name')]['name']) && $_FILES['upload_'.$customField->getVar('name')]['name'] != '')
       			|| $customField->getVar('att_type', 'n') == 'image'){
        		$item_attributObj->doUpload($transactionObj);

        	}elseif($customField->getVar('att_type', 'n') == 'file' || $customField->getVar('att_type', 'n') == 'urllink'){
       			$item_attributObj->storeBasedURl($customField->getVar('att_type', 'n'));
       		}else{*/
				$item_attributObj->setType('value', $customField->getObjectType());
	        	$field_value = isset($_POST[$customField->getVar('name')]) ? $_POST[$customField->getVar('name')] : '';
	        	$item_attributObj->setVar('value', $field_value);
			//}

	        if (!$smartshop_item_attribut_handler->insert($item_attributObj)) {
        		$transactionObj->setErrors($item_attributObj->getErrors());
        	}

        	unset($item_attributObj);
        }
        return !$transactionObj->hasError();
	}

	function batchDelete($ids){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('transactionid', '('.implode(', ', $ids).')', 'IN'));
		return $this->deleteAll($criteria);
	}

	function getObjects($criteria = null, $id_as_key = false, $as_object = true, $sql=false, $debug=false, $dropCF=false){
    	$transactionsObj = parent::getObjects($criteria , $id_as_key, $as_object, $sql, $debug);
		//patch PHP4
		if($dropCF){
			return $transactionsObj;
		}else{
			$transactionsObj2 = $this->initiateCustomFields($transactionsObj);
			return $transactionsObj2;
		}
		/*$this->initiateCustomFields($itemsObj);
		return $itemsObj;*/
		// End patch PHP4
   	}

	function initiateCustomFields($transactionsObj) {

		global $smartshop_item_attribut_handler, $smartshop_category_attribut_handler;
		if(!isset($smartshop_item_attribut_handler)){
			$smartshop_item_attribut_handler =& xoops_getmodulehandler('item_attribut','smartshop');
			$smartshop_category_attribut_handler =& xoops_getmodulehandler('category_attribut','smartshop');
		}
		foreach($transactionsObj as $transactionObj){
			$transactionidArray[] = $transactionObj->getVar('transactionid', 'e');
		}
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('itemid', '('.implode(', ', $transactionidArray).')', 'IN'));
		$item_attributsObj = $smartshop_item_attribut_handler->getObjects($criteria);

		$category_attributsObj = $smartshop_category_attribut_handler->getObjects(null, true);
		foreach($transactionsObj as $key =>$transactionObj){
	    	$constantVars = $transactionObj->vars;
	    	foreach($item_attributsObj[$transactionObj->getVar('transactionid', 'e')] as $item_attributObj){
		    	if($transactionObj->getVar('transactionid', 'e') == $item_attributObj->getVar('itemid', 'e')){
			    	$attributid = $item_attributObj->getVar('attributid', 'e');
					if(is_object($category_attributsObj[$attributid])){
				    	$transactionObj->initVar($category_attributsObj[$attributid]->getVar('name'), $category_attributsObj[$attributid]->getObjectType(),
					    	$item_attributObj->getVar('value'),	$category_attributsObj[$attributid]->getVar('required'), null, '', false,
					    	$category_attributsObj[$attributid]->getVar('caption'),	$category_attributsObj[$attributid]->getVar('description'));
					    	$transactionObj->setVar($category_attributsObj[$attributid]->getVar('name'), $item_attributObj->getVar('value'));

				    	$transactionObj->setVarInfo($category_attributsObj[$attributid]->getVar('name'), 'custom_field_type',$category_attributsObj[$attributid]->getVar('att_type', 'n'));
						$transactionObj->setVarInfo($category_attributsObj[$attributid]->getVar('name'), 'size',0);
					}
		    	}


	    	}
			//patch PHP4
			$transactionsObj2[$key] = $transactionObj;
		}
		//patch PHP4
	    return $transactionsObj2;

    }

}
?>