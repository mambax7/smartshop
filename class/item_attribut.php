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
class SmartshopItem_attribut extends SmartObject {

    function SmartshopItem_attribut() {
        $this->initVar('item_attributid', XOBJ_DTYPE_INT, '', true);
        $this->initVar('attributid', XOBJ_DTYPE_INT, '',  true);
        $this->initVar('itemid', XOBJ_DTYPE_INT, '', true);
        $this->initVar('value', XOBJ_DTYPE_TXTBOX, '');
    }

    function doUpload(&$itemObj){
    	global $smartshop_item_handler, $smartshop_category_attribut_handler;

		$category_attributObj = $smartshop_category_attribut_handler->get($this->getVar('attributid'));
		$key = $category_attributObj->getVar('name');

		if(isset($_POST['url_'.$key]) && $_POST['url_'.$key] != ''){
    		$value = $_POST['url_'.$key];
    		if(substr($value,0,4) != 'http'){
				$value = 'http://'.$value;
			}
			$this->setVar('value', $value);
		}

		//clone
		elseif(isset( $_POST['clone_'.$key])){
			$this->setVar('value', $_POST['clone_'.$key]);
		}

    	$error = false;
    	if (isset($_POST['smart_upload_file'])) {
		    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartuploader.php";
			$uploaderObj = new SmartUploader($smartshop_item_handler->getImagePath(true), $smartshop_item_handler->_allowedMimeTypes, $smartshop_item_handler->_maxFileSize, $smartshop_item_handler->_maxWidth, $smartshop_item_handler->_maxHeight);
			foreach ($_FILES as $name=>$file_array) {
				if (isset ($file_array['name']) && $file_array['name'] != "" && str_replace('upload_', '', $name)== $key) {
					if ($uploaderObj->fetchMedia($name)) {
						$uploaderObj->setTargetFileName(time()."_+_". $uploaderObj->getMediaName());
						if ($uploaderObj->upload()) {
							//file
							if($category_attributObj->getObjectType() == XOBJ_DTYPE_FILE) {
				    			$object_fileurl = $smartshop_item_handler->getImageURL(true);
				    			$fileObj = $this->getFileObj($key);
				    			$fileObj->setVar('url', $object_fileurl.$uploaderObj->getSavedFileName());
				    			$fileObj->setVar('caption', $_POST['caption_'.$key]);
	    						$fileObj->setVar('description', $_POST['desc_'.$key]);
	    			   			$this->storeFileObj(&$fileObj);
    							//todo : catch errors
				    			$this->setVar('value', $fileObj->getVar('fileid'));
				    		}
				    		//image
				    		else{
								//upload image
								if($uploaderObj->getSavedFileName() != ''){
									$this->setVar('value', $uploaderObj->getSavedFileName());
								}

							}
						} else {
							$error = true;
							$itemObj->setErrors($uploaderObj->getErrors(false));
						}
					} else {
						$error = true;
						$itemObj->setErrors($uploaderObj->getErrors(false));
					}
				}
			}
			return !$error;
		}
		return false;
    }

    function storeBasedURl($data_type){
    	global $smartshop_category_attribut_handler, $smartshop_item_handler;
    	$category_attributObj = $smartshop_category_attribut_handler->get($this->getVar('attributid'));
		$key = $category_attributObj->getVar('name');


    	if($data_type == 'file' && $_POST['url_'.$key]) {
	    	$fileObj = $this->getFileObj('value');
	    	$fileObj->setVar('url', $_POST['url_'.$key]);
			$fileObj->setVar('caption', $_POST['caption_'.$key]);
			$fileObj->setVar('description', $_POST['desc_'.$key]);
			$this->storeFileObj(&$fileObj);
			//todo : catch errors
			$this->setVar('value', $fileObj->getVar('fileid'));
    	}elseif($data_type == 'image'){
			$oldFile = $smartshop_item_handler->getImagePath(true).$this->getVar('value', 'e');
			if(isset($_POST['delete_'.$key]) && $_POST['delete_'.$key] == '1'){
				$this->setVar('value', '');
				if(file_exists($oldFile)){
    				unlink($oldFile);
    			}
			}elseif(isset($_POST['url_'.$key]) && $_POST['url_'.$key] != ''){
				$this->setVar('value', $_POST['url_'.$key]);
				if(file_exists($oldFile)){
    				unlink($oldFile);
    			}
			}

    	}else{
    		$linkObj = $this->getUrlLinkObj('value');
			$linkObj->setVar('caption', $_POST['caption_'.$key]);
			$linkObj->setVar('description', $_POST['desc_'.$key]);
			$linkObj->setVar('target', $_POST['target_'.$key]);
			$linkObj->setVar('url', $_POST['url_'.$key]);
			if($linkObj->getVar('url') != '' ){
				$this->storeUrlLinkObj(&$linkObj);
			}
			//todo: catch errors
			$this->setVar('value', $linkObj->getVar('urllinkid'));
    	}
    }

}
class SmartshopItem_attributHandler extends SmartPersistableObjectHandler {
    function SmartshopItem_attributHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'item_attribut', array('attributid', 'itemid'), 'value', false, 'smartshop');
       }
	function resetValues($attributid, $value = ''){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('attributid', $attributid));
		return $this->updateAll('value', $value, $criteria);
	}
	function getExistingValues($attributid){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('attributid', $attributid));
		return $this->getList($criteria);
	}
	function getObjects($criteria = null, $id_as_key = false, $as_object = true, $sql=false, $debug=false){
    	$itemAttributsObj = parent::getObjects($criteria , $id_as_key, $as_object, $sql, $debug);
    	$attributIdIndexed = array();
    	foreach($itemAttributsObj as $iao){
    		$attributIdIndexed[$iao->getVar('itemid', 'e')][$iao->getVar('attributid', 'e')] = $iao;
    	}
    	unset($itemAttributsObj);
    	return $attributIdIndexed;
	}

	function &get($id, $as_object = true, $debug=false, $criteria=false) {
        if (!$criteria) {
        	$criteria = new CriteriaCompo();
        }
        for ($i = 0; $i < count($this->keyName); $i++) {
            /**
             * In some situations, the $id is not an INTEGER. SmartObjectTag is an example.
             * Is the fact that we removed the intval() represents a security risk ?
             */
            //$criteria->add(new Criteria($this->keyName[$i], ($id[$i]), '=', $this->_itemname));
            $criteria->add(new Criteria($this->keyName[$i], $id[$i], '=', $this->_itemname));
        }

        $criteria->setLimit(1);
        if ($debug) {
        	$obj_array = $this->getObjectsD($criteria, false, $as_object);
        } else {
        	$obj_array = $this->getObjects($criteria, false, $as_object);
        	if(is_object($obj_array[$id[1]][$id[0]])){
        		$obj_array[0] = $obj_array[$id[1]][$id[0]];
        		$obj_array[0]->unsetNew();
        		unset($obj_array[$id[1]]);
        	}
        }

        if (count($obj_array) < 1) {

            $obj = $this->create();
            return $obj;
        }

        return $obj_array[0];
    }

    /**
     * insert a new object in the database
     *
     * @param object $obj reference to the object
     * @param bool $force whether to force the query execution despite security settings
     * @param bool $checkObject check if the object is dirty and clean the attributes
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
  function insert(&$obj, $force = false, $checkObject = true, $debug=false)
    {
    	if ($checkObject != false) {
            if (!is_object($obj)) {
                return false;
            }

            if (!is_a($obj, $this->className)) {
            	$obj->setError(get_class($obj)." Differs from ".$this->className);
                return false;
            }
            if (!$obj->isDirty()) {
                $obj->setErrors("Not dirty"); //will usually not be outputted as errors are not displayed when the method returns true, but it can be helpful when troubleshooting code - Mith
                return true;
            }
        }



        $eventResult = $this->executeEvent('beforeSave', $obj);
    	if (!$eventResult) {
        	$obj->setErrors("An error occured during the BeforeSave event");
        	return false;
        }

        if ($obj->isNew()) {
	        $eventResult = $this->executeEvent('beforeInsert', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the BeforeInsert event");
	        	return false;
	        }

        }	else {
	        $eventResult = $this->executeEvent('beforeUpdate', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the BeforeUpdate event");
	        	return false;
	        }
        }
        if (!$obj->cleanVars()) {
        	$obj->setErrors('Variables were not cleaned properly.');
            return false;
        }
		$fieldsToStoreInDB = array();
        foreach ($obj->cleanVars as $k => $v) {
            if ($obj->vars[$k]['data_type'] == XOBJ_DTYPE_INT) {
                $cleanvars[$k] = intval($v);
            } elseif (is_array($v) ) {
            	$cleanvars[ $k ] = $this->db->quoteString( implode( ',', $v ) );
            } else {
                $cleanvars[$k] = $this->db->quoteString($v);
            }
            if ($obj->vars[$k]['persistent']) {
            	$fieldsToStoreInDB[$k] = $cleanvars[$k];
            }

        }
        if ($obj->isNew()) {
            if (!is_array($this->keyName)) {
                if ($cleanvars[$this->keyName] < 1) {
                    $cleanvars[$this->keyName] = $this->db->genId($this->table.'_'.$this->keyName.'_seq');
                }
            }

            $sql = "INSERT INTO ".$this->table." (".implode(',', array_keys($fieldsToStoreInDB)).") VALUES (".implode(',', array_values($fieldsToStoreInDB)) .")";

        } else {

			$value_string = is_array($obj->getVar('value')) ? implode('|', $obj->getVar('value', 'n')) : $obj->getVar('value');

            $sql = "UPDATE ".$this->table." SET value = '".$value_string."' WHERE item_attributid = ".$obj->getVar('item_attributid');


           /* foreach ($fieldsToStoreInDB as $key => $value) {
                if ((!is_array($this->keyName) && $key == $this->keyName) || (is_array($this->keyName) && in_array($key, $this->keyName))) {
                    continue;
                }
                if (isset($notfirst) ) {
                    $sql .= ",";
                }
                $sql .= " ".$key." = ".$value;
                $notfirst = true;
            }
            if (is_array($this->keyName)) {
                $whereclause = "";
                for ($i = 0; $i < count($this->keyName); $i++) {
                    if ($i > 0) {
                        $whereclause .= " AND ";
                    }
                    $whereclause .= $this->keyName[$i]." = ".$obj->getVar($this->keyName[$i]);
                }
            }
            else {
                $whereclause = $this->keyName." = ".$obj->getVar($this->keyName);
            }
            $sql .= " WHERE ".$whereclause;*/
        }

        if ($debug) {
        	xoops_debug($sql);
        }

        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }

        if (!$result) {
        	$obj->setErrors($this->db->error());
            return false;
        }

        if ($obj->isNew() && !is_array($this->keyName)) {
            $obj->assignVar($this->keyName, $this->db->getInsertId());
    	}
        $eventResult = $this->executeEvent('afterSave', $obj);
    	if (!$eventResult) {
        	$obj->setErrors("An error occured during the AfterSave event");
        	return false;
        }

        if ($obj->isNew()) {
        	$obj->unsetNew();
	        $eventResult = $this->executeEvent('afterInsert', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the AfterInsert event");
	        	return false;
	        }
        } else {
	        $eventResult = $this->executeEvent('afterUpdate', $obj);
	    	if (!$eventResult) {
	        	$obj->setErrors("An error occured during the AfterUpdate event");
	        	return false;
	        }
        }
        return true;
    }

    function clean(){
    	global $smartshop_item_handler;
    	$items = $smartshop_item_handler->getList();
		$deleted = array();
    	foreach ($items as $key => $item){
    		$criteria = new CriteriaCompo();
    		$criteria->add(new Criteria('itemid', $key));
    		$criteria->setSort('itemid, attributid');
    		$criteria->setOrder('ASC');
    		$attributs = parent::getObjects($criteria);


    		foreach($attributs as $att){
    			if(isset($previous)){

	    			if($previous->getVar('itemid') == $att->getVar('itemid') && $previous->getVar('attributid') == $att->getVar('attributid')){
	    				if($att->getVar('item_attributid', 'e') < $previous->getVar('item_attributid', 'e')){
	    					$deleted[] = $att->getVar('item_attributid', 'e');
	    					$this->cleanup($att, 1);
	       				}else{
	    					$deleted[] = $previous->getVar('item_attributid', 'e');
	    					$this->cleanup($previous, 1);
	    					$previous = $att;
	    				}
	    			}else {
	    				$previous = $att;
	    			}
    			}else{
    				$previous = $att;
    			}
	 		}
	 		unset($previous);
    	}
    	var_dump($deleted);exit;
    }

    function cleanup(&$obj, $force = false)
    {

        $sql = "DELETE FROM ".$this->table . " WHERE item_attributid = ".$obj->getVar('item_attributid', 'e');
        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }

        $eventResult = $this->executeEvent('afterDelete', $obj);
    	if (!$eventResult) {
        	$obj->setErrors("An error occured during the AfterDelete event");
        	return false;
        }
        return true;
    }


}
