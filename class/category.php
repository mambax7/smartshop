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

include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcategory.php";
class SmartshopCategory extends SmartObjectCategory {
	function SmartshopCategory() {
		$this->SmartobjectCategory();
		$this->initVar('hasitem', XOBJ_DTYPE_INT, true, false, null,'', false, _CO_SSHOP_CAT_HASITEM, _CO_SSHOP_CAT_HASITEM_DSC);
		$this->setControl('hasitem', "yesno");
		$this->initVar('searchable', XOBJ_DTYPE_INT, true, false, null,'', false, _CO_SSHOP_CAT_SEARCHABLE, _CO_SSHOP_CAT_SEARCHABLE_DSC);
		$this->setControl('searchable', "yesno");
		$this->initVar('template', XOBJ_DTYPE_TXTBOX, true, false, null,'', false, _CO_SSHOP_CAT_TEMPLATE, _CO_SSHOP_CAT_TEMPLATE_DSC);
		$this->initCommonVar('weight');

		$this->setControl('template', array('name' => false,
                                          'itemHandler' => 'category',
                                          'method' => 'getTemplate',
                                          'module' => 'smartshop'));

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
        if ($format == 's' && in_array($key, array('pub'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }


	function getCreateAttributLink() {

			$ret = '<a href="' . SMARTSHOP_URL . 'admin/category_attribut.php?op=mod&categoryid=' . $this->getVar('categoryid') . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'filenew2.png" style="vertical-align: middle;" alt="' . _AM_SSHOP_CAT_ATTRIBUT_CREATE . '" title="' . _AM_SSHOP_CAT_ATTRIBUT_CREATE . '" /></a>';

		return $ret;
	}

	function getCreateItemLink() {

		if($this->getVar('hasitem')){
			$ret = '<a href="' . SMARTSHOP_URL . 'admin/item.php?op=mod&categoryid=' . $this->getVar('categoryid') . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'filenew.png" style="vertical-align: middle;" alt="' . _AM_SSHOP_ITEM_CREATE . '" title="' . _AM_SSHOP_ITEM_CREATE . '" /></a>';
		}else{
			$ret = '';
		}
		return $ret;
	}

	function getListItemsLink() {
		$ret = '<a href="' . SMARTSHOP_URL . 'admin/category.php?op=listitems&categoryid=' . $this->getVar('categoryid') . '">' . $this->getVar('name') . '</a>';
		return $ret;
	}

	function getCreateItemLink4user() {
		$ret = '<a href="' . SMARTSHOP_URL . 'submit.php?op=mod&categoryid=' . $this->getVar('categoryid') . '">'.$this->getVar('name').'</a>';
		return $ret;
	}
	function getCustomFields()
    {
    	global $smartshop_category_attribut_handler, $smartshop_category_handler;

    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('parentid', '( 0, ' . $smartshop_category_handler->getParentIds($this->getVar('categoryid')) . ')', 'IN'));
    	$criteria->setSort('weight');
    	$category_attributObjs =& $smartshop_category_attribut_handler->getObjects($criteria);
    	return $category_attributObjs;
    }

    function getWeightControl() {
		$control = new XoopsFormText('', 'weight_' . $this->id(), 5, 100, $this->getVar('weight'));
		return $control->render();
    }

    function getSearchableControl() {
		$control = new XoopsFormRadioYN('', 'searchable_' . $this->id(),  $this->getVar('searchable'));
		return $control->render();
    }
}

class SmartshopCategoryHandler extends SmartObjectCategoryHandler {

	function SmartshopCategoryHandler($db) {
		$this->SmartobjectCategoryHandler($db, 'smartshop');
		$this->addPermission('category_view', _AM_SSHOP_CAT_PERM_READ, _AM_SSHOP_CAT_PERM_READ_DSC);
	}

	/**
	*Loop inside the array of all partners to match with current category
	*
	*param $categoryid - id of the current category
	*return array of partners for the current category
	*/
	function get_items_array($categoryid, $itemsArray){
		$partners = array();
		foreach ($itemsArray as $itemArray ){
			if($itemArray['categoryid'] == $categoryid ){
				$itemsArray[] = $itemArray;
			}
		}
		return $itemsArray;
	}

	/**
	*Loop inside the array of all categories to find subcats for current category
	*recusrive function: for each subcat found, call to function getcontent to
	*get partners and subcats within it
	*
	*param $categoryid - id of the current category
	*return array of subcats for the current category
	*/
	function get_subcats($categoriesArray,$categoryid, $level, $includeItems, $offsetMark){

		//global $every_categories_array;
		$subcatsArray = array();
		$level++;

		foreach ($categoriesArray as $categoryArray) {

			if($categoryArray['parentid'] == $categoryid ){
				$subcatsArray[] = $this->get_cat_content($categoriesArray,$categoryArray,$level, $includeItems, $offsetMark);
			}
		}
		return $subcatsArray;
	}

	function getTemplate(){
       return array('default' => _CO_SSHOP_CAT_TPL_DEF,
       				'list' => _CO_SSHOP_CAT_TPL_LIST,
       				'table' => _CO_SSHOP_CAT_TPL_TABLE
       );
    }
	function get_cat_content($categoriesArray, $categoryArray,$level, $includeItems, $offsetMark){

		$offset='';
		for($i=0;$i<$level;$i++){
			$offset .= $offsetMark;
		}
		$categoryArray['offset'] = $offset;
		if($includeItems){
			$categoryArray['items'] = $this->get_items_array($categoryArray['categoryid']);
		}
		$categoryArray['subcats'] = $this->get_subcats($categoriesArray,$categoryArray['categoryid'],$level, $includeItems, $offsetMark);
		return $categoryArray;
	}

	function getCategoryHierarchyArray($parentid=0, $includeItems = false, $offsetMark='&nbsp;&nbsp;&nbsp;&nbsp;' ){
		$categoriesArray = $this->getObjects(null, false, false);

		foreach ( $categoriesArray as $categoryArray)
		if ($categoryArray['parentid']==$parentid){

			$CategoryHierarchyArray[] = $this->get_cat_content($categoriesArray, $categoryArray, 0, $includeItems, $offsetMark);
		}

		return $CategoryHierarchyArray;
	}

	function afterDelete(&$obj) {

		global $smartshop_category_attribut_handler;

		/**
		 * Retreive all item_attribut of this item and delete them
		 */
		$criteria = new CriteriaCompo(new Criteria('parentid', $obj->getVar('categoryid')));
		$objects = $smartshop_category_attribut_handler->getObjects($criteria);

		unset($criteria);

		foreach($objects as $object) {
			$smartshop_category_attribut_handler->delete($object);
		}
		unset($criteria);

		/**
		 * @todo add some code to capture any error that may occur
		 */
		return true;
	}

	function beforeDelete(&$obj) {

		/**
		 * @internal to disable category deletion, make this method return false
		 */

		return true;
	}

	function getAscendency($categoryid){
		$categoriesArray = $this->getObjects(null, true, false);
		$look_for = $categoriesArray[$categoryid]['parentid'];
		$ascendency = array($categoryid , 0);

		while ($look_for){
			$ascendency[] = $look_for;
			$look_for = $categoriesArray[$look_for]['parentid'];
			$ascendency[] = $look_for;
		}
		return $ascendency;
	}


}
?>