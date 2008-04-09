<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
class SmartshopBasket_item extends SmartObject {

    function SmartshopBasket_item() {
    	global $smartShopConfig;

		$this->initVar('basket_itemid', XOBJ_DTYPE_INT, '', true, null, '', false);
		$this->initVar('basketid', XOBJ_DTYPE_INT, '', true, null, '', false);
		$this->initVar('itemid', XOBJ_DTYPE_INT, 0, false, null,'', false);
       	$this->initVar('quantity', XOBJ_DTYPE_INT, 1, false, null,'', false, _CO_SSHOP_TRANS_QUANTITY);
		$this->initNonPersistableVar('item_name', XOBJ_DTYPE_TXTBOX, false, _CO_SSHOP_ITEM);
		$this->initNonPersistableVar('item_price', XOBJ_DTYPE_FLOAT, false, _CO_SSHOP_ITEM_PRICE);

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
    	if ($format == 's' && in_array($key, array())) {
            return call_user_func(array($this,$key));
        }

        return parent::getVar($key, $format);
    }

	function getQtyControl() {

		$control = new XoopsFormText('', 'quantity_' . $this->id(), 2,3, $this->getVar('quantity'));

		return $control->render();
    }

    function getCheckoutFieldValue($keyAndBasketArr){
		return $keyAndBasketArr['basket']->getItem_attributs($this->getVar('itemid', 'e'), $keyAndBasketArr['key']);
	}

	function getTitileHtml() {
		global $myts;
		return $myts->undoHtmlSpecialChars($this->getVar('item_name', 'n'));
    }

}
class SmartshopBasket_itemHandler extends SmartPersistableObjectHandler {
    function SmartshopBasket_itemHandler($db) {

        $this->SmartPersistableObjectHandler($db, 'basket_item', 'basket_itemid', 'basket_itemid', '', 'smartshop');
		}

	 function getObjects($criteria = null, $id_as_key = false, $as_object = true, $sql=false, $debug=false){
		global $smartshop_item_handler, $myts;
		if(!isset($smartshop_item_handler)){
			$smartshop_item_handler =& xoops_getmodulehandler('item', SMARTSHOP_DIRNAME);
		}
		$basket_itemsObj = parent:: getObjects($criteria, $id_as_key, $as_object, $sql, $debug);
		if(!empty($basket_itemsObj)){

			foreach($basket_itemsObj as $basket_itemObj){
				$itemids[] = $basket_itemObj->getVar('itemid');
			}

			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('itemid', "(".implode(', ', $itemids).")", 'IN'));
			$itemsObj = $smartshop_item_handler->getObjects($criteria, true);
			$basket_itemsObj2 = array();
			foreach($basket_itemsObj as $basket_itemObj){
				$basket_itemObj->setVar('item_name', $itemsObj[$basket_itemObj->getVar('itemid')]->getVar('name'));
				$basket_itemObj->setVar('item_price', $itemsObj[$basket_itemObj->getVar('itemid')]->getVar('price'));
				$basket_itemsObj2[$basket_itemObj->id()] = $basket_itemObj;
			}
		}
		return $basket_itemsObj2;

	}
}
?>
