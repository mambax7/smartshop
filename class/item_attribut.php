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
}
?>