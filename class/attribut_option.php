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
class SmartshopAttribut_option extends SmartObject {

    function SmartshopAttribut_option() {
        $this->initVar('optionid', XOBJ_DTYPE_INT, '', true);
        $this->initVar('attributid', XOBJ_DTYPE_INT, '', true, false, '', false, _CO_SSHOP_ATT_OPT_ATTRIBUTID, _CO_SSHOP_ATT_OPT_ATTRIBUTID_DSC);
        $this->initVar('linked_attribut_option_id', XOBJ_DTYPE_INT, '', true, false, '', false, _CO_SSHOP_ATT_OPT_LINKED_ATT, _CO_SSHOP_ATT_OPT_LINKED_ATT_DSC);
        $this->initVar('caption', XOBJ_DTYPE_TXTBOX, '', true, 255, '', false, _CO_SSHOP_ATT_OPT_CAPTION, _CO_SSHOP_ATT_OPT_CAPTION_DSC, true);

        $this->setControl('linked_attribut_option_id', array(
                                          	'object' => &$this,
                                          	'method' => 'getLinkedAttributOptions'
                                          ));
		$this->initCommonVar('weight');
        $this->makeFieldReadOnly('attributid');
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('linked_attribut_option_id', 'attributid'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

	function getLinkedAttributOptions() {
		global $smartshop_attribut_option_handler;
		return $smartshop_attribut_option_handler->getOptionsByAttribut($this->getVar('linked_attribut_option_id', 'n'));
	}

	function linked_attribut_option_id() {
		global $smartshop_attribut_option_handler;
		$linked_attributid = $this->getVar('linked_attribut_option_id', 'n');
		if ($linked_attributid == 0) {
			return '';
		} else {
			$linked_attribut_object = $smartshop_attribut_option_handler->get($linked_attributid);
			if ($linked_attribut_object->isNew()) {
				return '';
			} else {
				return $linked_attribut_object->getVar('caption');
			}
		}
	}

	function attributid() {
		global $smartshop_category_attribut_handler;
		$ret = $smartshop_category_attribut_handler->get($this->getVar('attributid', 'n'));
		return $ret->getVar('name');
	}

	function getWeightControl() {
		$control = new XoopsFormText('', 'weight_' . $this->id(), 5, 100, $this->getVar('weight'));
		return $control->render();
    }
}
class SmartshopAttribut_optionHandler extends SmartPersistableObjectHandler {
    function SmartshopAttribut_optionHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'attribut_option', 'optionid', 'caption', false, 'smartshop');
    }

    function getOptionsByAttribut($attributid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('attributid', $attributid));
    	$criteria->setSort('weight, attributid');
    	return $this->getList($criteria);
    }

}
?>