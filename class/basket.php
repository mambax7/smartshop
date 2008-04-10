<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
class SmartshopBasket extends SmartObject {
	var $_items = false;
	var $_item_attributs = false;
    function SmartshopBasket() {
    	global $smartShopConfig;

        $this->initVar('basketid', XOBJ_DTYPE_INT, '', true, null, '', false);
		$this->initVar('sessionid', XOBJ_DTYPE_TXTBOX, 0, false, null,'', false);
    	$this->initVar('time', XOBJ_DTYPE_LTIME, 0, false, null,'', false);

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

    function getItems($as_array = false){
    	global $smartshop_basket_item_handler, $smartshop_item_handler;
    	if(!$as_array && $this->_items){
    		return $this->_items;
    	}

    	if(!isset($smartshop_basket_item_handler)){
			$smartshop_basket_item_handler =& xoops_getmodulehandler('basket_item','smartshop');
		}
		if(!isset($smartshop_item_handler)){
			$smartshop_item_handler =& xoops_getmodulehandler('item', SMARTSHOP_DIRNAME);
		}
    	$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('basketid', $this->id()));
		$basket_itemsObj = $smartshop_basket_item_handler->getObjects($criteria, true);
		unset($criteria);
		foreach($basket_itemsObj as $basket_itemObj){
			$itemids[] = $basket_itemObj->getVar('itemid');
		}
		if(!empty($itemids)){
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('itemid', "(".implode(', ', $itemids).")", 'IN'));
			$itemsObj = $smartshop_item_handler->getObjects($criteria, true);
		}else{
			$itemsObj = array();
		}
		$myts =& MyTextSanitizer::getInstance();
		if($as_array){
			$itemArray = array();
			foreach($basket_itemsObj as  $basket_itemObj){
				$itemContent = array();
				$itemContent['id'] = $basket_itemObj->getVar('itemid');
				$itemContent['item_name'] = $myts->undoHtmlSpecialChars($itemsObj[$basket_itemObj->getVar('itemid')]->getVar('name'));
				$itemContent['item_price'] = $itemsObj[$basket_itemObj->getVar('itemid')]->getVar('price');
				$itemContent['quantity'] = $basket_itemObj->getVar('quantity');
				$itemArray[$basket_itemObj->getVar('itemid')] = $itemContent;
				unset($itemContent);
			}
			return $itemArray;
		}else{
			foreach($basket_itemsObj as $basket_itemObj){
				$basket_itemObj->setVar('item_name', $itemsObj[$basket_itemObj->getVar('itemid')]->getVar('name'));
				$basket_itemObj->setVar('item_price', $itemsObj[$basket_itemObj->getVar('itemid')]->getVar('price'));
			}
			$this->_items = $basket_itemsObj;
			return $basket_itemsObj;
		}
    }

     function getTotal(){
     	global $smartshop_basket_item_handler, $smartshop_item_handler;

    	$basket_itemsObj = $this->getItems();
		$total = 0;
		foreach($basket_itemsObj as  $basket_itemObj){
			$total += $basket_itemObj->getVar('item_price')*$basket_itemObj->getVar('quantity');
		}
		return smart_float($total);

     }

    function add($itemid, $qty){
		global $smartshop_basket_item_handler;

		if($this->isNew()){
			$this->setVar('time',time());
			$this->handler->insert($this);
		}
		else{
			$basketItemArray = $this->getItems(1);
			if(isset($basketItemArray[$itemid])){
				return true;
			}
		}
		$basket_item = $smartshop_basket_item_handler->create();
		$basket_item->setVar('itemid',$itemid);
		$basket_item->setVar('quantity', $qty);
		$basket_item->setVar('basketid', $this->id());
		return $smartshop_basket_item_handler->insert($basket_item);
	}

	function &prepareCheckout(){
		global $smartshop_item_attribut_handler;
		$basket_itemsObj = $this->getItems();
		foreach($basket_itemsObj as $itemObj){
			$itemKeysArray[] = $itemObj->getVar('itemid', 'e');
		}
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('itemid', '('.implode($itemKeysArray,', ').')', 'IN'));
		$item_attributsObj = $smartshop_item_attribut_handler->getObjects($criteria);
$this->_item_attributs = $item_attributsObj;
//var_dump($this->_item_attributs );exit;
		/*foreach($item_attributsObj as $item_attributObj){
			$this->_item_attributs[$item_attributObj->getVar('itemid', 'e')][$item_attributObj->getVar('attributid', 'e')] = $item_attributObj;
		}*/
	}

 	function getItem_attributs($itemid, $key){
 		if(isset($this->_item_attributs[$itemid][$key])){
 			return 	$this->_item_attributs[$itemid][$key]->getVar('value');
 		}
 		else{
 			return '';
 		}
 	}

	function getCheckoutFields(){
		global $smartshop_category_attribut_handler;
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', 0));
		$criteria->add(new Criteria('checkoutdisp', 1));
		$checkoutFields = $smartshop_category_attribut_handler->getList($criteria);

		return $checkoutFields;
	}


}
class SmartshopBasketHandler extends SmartPersistableObjectHandler {
    function SmartshopBasketHandler($db) {

        $this->SmartPersistableObjectHandler($db, 'basket', 'basketid', false, '', 'smartshop');
		}

	function get(){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('sessionid', session_id()));
		$baskets = $this->getObjects($criteria);
		if($baskets){
			return $baskets[0];
		}else{
			$basket = $this->create();
			$basket->setVar('sessionid', session_id());
			return $basket;
		}
	}
}
?>
