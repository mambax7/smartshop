<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

/**
 * An email text field
 */
class SmartshopDependencyFieldOptionsElement extends XoopsFormElementTray {
	    function SmartshopDependencyFieldOptionsElement($object, $key) {
	    $var = $object->vars[$key];
	    $control = $object->controls[$key];

        $this->XoopsFormElementTray($var['form_caption'], '<br /><br />', $key . '_dependency_tray');

		global $smartshop_attribut_option_handler;
		$option_array = $smartshop_attribut_option_handler->getOptionsByAttribut($object->getVar('dependent_attributid'));

        $options_count = isset($_POST['options_count_' . $key]) ? intval($_POST['options_count_' . $key]) : 5;
        $new_options_toadd = isset($control['moreoptions']) ? $control['moreoptions'] : 0;
        $options_count = $options_count + $new_options_toadd;

		$aOptions = $object->getVar('options', 'n');

        for($i=0; $i<$options_count; $i++) {
        	$option_tray = new XoopsFormElementTray('', ' ', 'option_tray_' . $key . '_' . $i);

        	$text_box = new XoopsFormText('', 'option_text_' . $key . '_' . $i, 15, 255, isset($aOptions[$i]['text']) ? $aOptions[$i]['text'] : '');
        	$option_tray->addElement($text_box);

        	$select_box = new XoopsFormSelect('', 'option_select_' . $key . '_' . $i, isset($aOptions[$i]['select']) ? $aOptions[$i]['select'] : '');
        	$select_box->addOptionArray($option_array);
        	$option_tray->addElement($select_box);

        	$this->addElement($option_tray);
        	unset($option_tray);
        	unset($text_box);
        	unset($select_box);
        }
		$more_options_tray = new XoopsFormElementTray('', ' ', 'more_options_tray_' . $key);
		$add_label = new XoopsFormLabel('', _CO_SSHOP_ADD);
		$more_options_label = new XoopsFormLabel('', _CO_SSHOP_MORE_OPTIONS);
        $more_options_text = new XoopsFormText('', 'more_options_' . $key, 2, 2, '4' );
        $more_options_button = new XoopsFormButton('', 'more_options_button_' . $key, _SUBMIT, 'submit');
        $more_options_button->setExtra('onclick="this.form.elements.op.value=\'moreoptions\'"');
        $options_count = new XoopsFormHidden('options_count_' . $key, $options_count);

		$more_options_tray->addElement($options_count);
        $more_options_tray->addElement($add_label);
        $more_options_tray->addElement($more_options_text);
        $more_options_tray->addElement($more_options_label);
        $more_options_tray->addElement($more_options_button);

        $this->addElement($more_options_tray);
    }
}
?>