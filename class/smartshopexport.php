<?php
/**
 * Contains the classes for easily exporting data
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id$
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartObject
 */

/**
 * SmartObjectExport class
 *
 * Class to easily export data from SmartObjects
 *
 * @package SmartObject
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
include_once(SMARTOBJECT_ROOT_PATH . 'class/smartexport.php');

class SmartShopExport extends SmartObjectExport {


	/**
	 * Renders the export
	 */
	function render($filename) {
		global $smartshop_category_attribut_handler;
		$this->filename = $filename;

		$objects = $this->handler->getObjects($this->criteria, false, true, false, false, true);
		if(strtolower(get_class($this->handler)) == 'smartshoptransactionhandler'){
			$parentid = -1;
		}else{
			$parentid = $objects[0]->getVar('parentid');
		}
		$rows = array();
		$columnsHeaders = array();
		$firstObject = true;
		$optionFields = $smartshop_category_attribut_handler->getOptionsFields($parentid);
    	// Loop through the array and change special custom vars all array value for a string

		foreach ($objects as $object) {
			$object->initiateCustomFields();
			$row = array();
			if(!$this->notDisplayFields){
				$this->notDisplayFields = array();
			}
			foreach ($object->vars as $key=>$var) {
				if ((!$this->fields || in_array($key, $this->fields)) && !in_array($key, $this->notDisplayFields))  {
					if ($this->outputMethods && (isset($this->outputMethods[$key])) && (method_exists($object, $this->outputMethods[$key]))) {
						$method = $this->outputMethods[$key];
						$row[$key] = $object->$method();
					}
					elseif(isset($optionFields[$key])){
						//Get value for each selected option if option field
						$object->vars[$key]['value'] = explode('|', $object->vars[$key]['value']);
						if(is_array($object->vars[$key]['value'])){
								foreach($object->vars[$key]['value'] as $val){
	    						$option_val[] = $optionFields[$key][$val];
							}
		    				$row[$key] =  implode(', ', $option_val);
						}else{
							$option_val = $optionFields[$key][$object->vars[$key]['value']];
							$row[$key] =  $option_val;

						}
		    			unset($option_val);
		    		}
			    	else {
						$row[$key] = $object->getVar($key);
					}
					if ($firstObject) {
						// then set the columnsHeaders array as well
						$columnsHeaders[$key] = $var['form_caption'];
					}
				}
			}
			$firstObject = false;
			$rows[] = $row;
			unset($row);
		}
		$data = array();
		$data['rows'] = $rows;
		$data['columnsHeaders'] = $columnsHeaders;
		$smartExportRenderer = new SmartExportRenderer($data, $this->filename, $this->filepath, $this->format, $this->options);
		$smartExportRenderer->execute();
	}


}

?>