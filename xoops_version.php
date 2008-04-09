<?php

/**
* $Id$
* Module: SmartShop
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

$modversion['name'] = _MI_SSHOP_MD_NAME;
$modversion['version'] = 1.1;
$modversion['description'] = _MI_SSHOP_MD_DESC;
$modversion['author'] = "The SmartFactory [www.smartfactory.ca]";
$modversion['credits'] = "InBox Solutions, Sudhaker, Ampersand Design, Technigrapha";
$modversion['help'] = "";
$modversion['license'] = "GNU General Public License (GPL)";
$modversion['official'] = 0;
$modversion['image'] = "images/module_logo.gif";
$modversion['dirname'] = "smartshop";

// Added by marcan for the About page in admin section
$modversion['developer_lead'] = "marcan [Marc-André Lanciault]";
$modversion['developer_contributor'] = "Mithrandir, Sudhaker, Felix, Fred";
$modversion['developer_website_url'] = "http://smartfactory.ca";
$modversion['developer_website_name'] = "The SmartFactory";
$modversion['developer_email'] = "info@smartfactory.ca";
$modversion['status_version'] = "Beta 1";
$modversion['status'] = "Beta";
$modversion['date'] = "unreleased";

$modversion['warning'] = _AM_SOBJECT_WARNING_BETA;

$modversion['demo_site_url'] = "";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "";
$modversion['support_site_name'] = "";
$modversion['submit_bug'] = "";
$modversion['submit_feature'] = "";

$modversion['author_word'] = "";

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";

$modversion['tables'][0] = "smartshop_category";
$modversion['tables'][1] = "smartshop_meta";
$modversion['tables'][2] = "smartshop_item";
$modversion['tables'][3] = "smartshop_item_attribut";
$modversion['tables'][4] = "smartshop_category_attribut";
$modversion['tables'][5] = "smartshop_attribut_option";
$modversion['tables'][6] = "smartshop_transaction";

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "smartshop_search";
// Menu
$modversion['hasMain'] = 1;

$modversion['blocks'][1]['file'] = "submit_by_cat.php";
$modversion['blocks'][1]['name'] = _MI_SSHOP_SUBMIT_BY_CAT;
$modversion['blocks'][1]['description'] = "Shows new items";
$modversion['blocks'][1]['show_func'] = "smartshop_submit_by_cat_show";
$modversion['blocks'][1]['edit_func'] = "smartshop_submit_by_cat_edit";
$modversion['blocks'][1]['options'] = "select";
$modversion['blocks'][1]['template'] = "smartshop_submit_by_cat.html";


$modversion['blocks'][2]['file'] = "current_user_submissions.php";
$modversion['blocks'][2]['name'] = _MI_SSHOP_CURR_USER_SUB;
//$modversion['blocks'][2]['description'] = "Shows new items";
$modversion['blocks'][2]['show_func'] = "current_user_submissions_show";
$modversion['blocks'][2]['edit_func'] = "current_user_submissions_edit";
//$modversion['blocks'][1]['options'] = "0|datesub|5|65";
$modversion['blocks'][2]['template'] = "smartshop_current_user_submissions.html";


$modversion['blocks'][3]['file'] = "new_sellers.php";
$modversion['blocks'][3]['name'] = _MI_SSHOP_NEW_SELLERS;
$modversion['blocks'][3]['show_func'] = "new_sellers_show";
$modversion['blocks'][3]['edit_func'] = "new_sellers_edit";
$modversion['blocks'][3]['template'] = "smartshop_new_sellers.html";


$modversion['blocks'][4]['file'] = "new_adds.php";
$modversion['blocks'][4]['name'] = _MI_SSHOP_NEW_ADDS;
$modversion['blocks'][4]['show_func'] = "new_adds_show";
$modversion['blocks'][4]['edit_func'] = "new_adds_edit";
$modversion['blocks'][4]['template'] = "smartshop_new_adds.html";

$modversion['blocks'][5]['file'] = "search_block.php";
$modversion['blocks'][5]['name'] = _MI_SSHOP_NEW_SEARCH;
$modversion['blocks'][5]['show_func'] = "search_show";
$modversion['blocks'][5]['edit_func'] = "search_edit";
$modversion['blocks'][5]['template'] = "smartshop_search_block.html";

$modversion['blocks'][6]['file'] = "smartshop_basket_block.php";
$modversion['blocks'][6]['name'] = _MI_SSHOP_BASKET;
$modversion['blocks'][6]['show_func'] = "smartshop_basket_show";
$modversion['blocks'][6]['edit_func'] = "smartshop_basket_edit";
$modversion['blocks'][6]['template'] = "smartshop_basket_block.html";

global $xoopsModule;
// Templates
$i = 0;

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_header.html';
$modversion['templates'][$i]['description'] = 'Header template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_footer.html';
$modversion['templates'][$i]['description'] = 'Footer template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_index.html';
$modversion['templates'][$i]['description'] = 'Display Index page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_category.html';
$modversion['templates'][$i]['description'] = 'Display category page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_category_tableview.html';
$modversion['templates'][$i]['description'] = 'Display category page';
$i++;
$modversion['templates'][$i]['file'] = 'smartshop_item.html';
$modversion['templates'][$i]['description'] = 'Display item page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_submit.html';
$modversion['templates'][$i]['description'] = 'Submit item page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_search.html';
$modversion['templates'][$i]['description'] = 'Search page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_searchresults.html';
$modversion['templates'][$i]['description'] = 'Search results page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_presubmit.html';
$modversion['templates'][$i]['description'] = 'Tree list of category';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_category_node.html';
$modversion['templates'][$i]['description'] = 'Tree list of category';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_transaction.html';
$modversion['templates'][$i]['description'] = 'Transaction';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_buy.html';
$modversion['templates'][$i]['description'] = 'Buy page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_list_view.html';
$modversion['templates'][$i]['description'] = 'List view for search results';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_table_view.html';
$modversion['templates'][$i]['description'] = 'Table view for search results';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_category_print.html';
$modversion['templates'][$i]['description'] = 'Print category page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_category_tableview_print.html';
$modversion['templates'][$i]['description'] = 'Print category page';

$i++;
$modversion['templates'][$i]['file'] = 'smartshop_item_print.html';
$modversion['templates'][$i]['description'] = 'Display item page';

/*$i++;
$modversion['templates'][$i]['file'] = 'smartshop_buy.html';
$modversion['templates'][$i]['description'] = 'Buy page';*/
// Config Settings (only for modules that need config settings generated automatically)
$i = 0;
/*
$i++;
$modversion['config'][$i]['name'] = 'show_subcats';
$modversion['config'][$i]['title'] = '_MI_SSHOP_SHOW_SUBCATS';
$modversion['config'][$i]['description'] = '_MI_SSHOP_SHOW_SUBCATS_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'all';
$modversion['config'][$i]['options'] = array(_MI_SSHOP_SHOW_SUBCATS_NO  => 'no',
                                   		_MI_SSHOP_SHOW_SUBCATS_NOTEMPTY   => 'nonempty',
                                  		 _MI_SSHOP_SHOW_SUBCATS_ALL => 'all');
*/
if(!isset($smartshop_module_use)){
	include_once(XOOPS_ROOT_PATH."/modules/smartshop/include/common.php");
	$smartshop_module_use = smart_getMeta('module_usage', 'smartshop');
}
global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname']) {
    global $xoopsModuleConfig, $xoopsUser;
    $isAdmin = false;
    if (!empty($xoopsUser)) {
        $isAdmin = ($xoopsUser->isAdmin($xoopsModule->getVar('mid')));
    }
    // Add the Submit new item button
    if (($smartshop_module_use == 'dynamic_directory' ||$smartshop_module_use == 'adds' )&&
    		(is_object($xoopsUser) )) {
        $modversion['sub'][1]['name'] = _MI_SSHOP_SUB_MENU;
        $modversion['sub'][1]['url'] = "submit.php";
    }
}
// Retreive the group user list, because the autpmatic group_multi config formtype does not include Anonymous group :-(
$member_handler =& xoops_gethandler('member');
$groups_array = $member_handler->getGroupList();
foreach($groups_array as $k=>$v) {
	$select_groups_options[$v] = $k;
}
//common prefs for all module uses
$i++;
$modversion['config'][$i]['name'] = 'def_perm_category_view';
$modversion['config'][$i]['title'] = '_MI_SSHOP_DEFCATVIEWGR';
$modversion['config'][$i]['description'] = '_MI_SSHOP_DEFCATVIEWGRDSC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $select_groups_options;
$modversion['config'][$i]['default'] =  '1|2|3';

$i++;
$modversion['config'][$i]['name'] = 'items_per_page';
$modversion['config'][$i]['title'] = '_MI_SSHOP_ITEMSPERPAGE';
$modversion['config'][$i]['description'] = '_MI_SSHOP_ITEMSPERPAGE_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array('5'  => 5,
                                   			'10'  => 10,
                                   			'15'  => 15,
                                   			'20'  => 20,
                                   			'25'  => 25,
                                   			'30'  => 30,
                                  		 );
$modversion['config'][$i]['default'] = '10';

$i++;
$modversion['config'][$i]['name'] = 'module_meta_description';
$modversion['config'][$i]['title'] = '_MI_SSHOP_MODMETADESC';
$modversion['config'][$i]['description'] = '_MI_SSHOP_MODMETADESC_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'category_nav';
$modversion['config'][$i]['title'] = '_MI_SSHOP_CATEGORY_NAV';
$modversion['config'][$i]['description'] = '_MI_SSHOP_CATEGORY_NAV_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'sort';
$modversion['config'][$i]['title'] = '_MI_SSHOP_SORT';
$modversion['config'][$i]['description'] = '_MI_SSHOP_SORT_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(  _MI_SSHOP_SORT_WEIGHT => 'weight ASC',
                                   			 _MI_SSHOP_SORT_DATE => 'date DESC',
                                   			 _MI_SSHOP_SORT_ALPHA => 'name ASC'
                                   			  );
$modversion['config'][$i]['default'] = 'weight ASC';

$i++;
$modversion['config'][$i]['name'] = 'cat_sort';
$modversion['config'][$i]['title'] = '_MI_SSHOP_CAT_SORT';
$modversion['config'][$i]['description'] = '_MI_SSHOP_SORT_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(  _MI_SSHOP_SORT_WEIGHT => 'weight',
                                   			 _MI_SSHOP_SORT_ALPHA => 'name'
                                   			  );
$modversion['config'][$i]['default'] = 'weight';

$i++;
$modversion['config'][$i]['name'] = 'nav_mode';
$modversion['config'][$i]['title'] = '_MI_SSHOP_NAV_MODE';
$modversion['config'][$i]['description'] = '_MI_SSHOP_NAV_MODE_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(  _MI_SSHOP_NAV_MODE_BREAD => 'bread',
                                   			 _MI_SSHOP_NAV_MODE_BACK => 'back',
                                   			 _MI_SSHOP_NAV_MODE_NONE => 'none'
                                   			  );
$modversion['config'][$i]['default'] = 'bread';

$i++;
$modversion['config'][$i]['name'] = 'category_tpl';
$modversion['config'][$i]['title'] = '_MI_SSHOP_CAT_TPL';
$modversion['config'][$i]['description'] = '_MI_SSHOP_CAT_TPL_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(  _MI_SSHOP_TPL_LIST => 'list',
                                   			 _MI_SSHOP_TPL_TABLE => 'table'
                                   			 );
$modversion['config'][$i]['default'] = 'table';

$i++;
$modversion['config'][$i]['name'] = 'display_fields';
$modversion['config'][$i]['title'] = '_MI_SSHOP_DISP_FIELDS';
$modversion['config'][$i]['description'] = '_MI_SSHOP_DISP_FIELDS_DSC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = array(_MI_SSHOP_DISP_FIELDS_COUNT => 'counter',
                                   			 _MI_SSHOP_DISP_FIELDS_DATE => 'date',
                                   			 _MI_SSHOP_DISP_FIELDS_DESC => 'description'
                                   			  );
if($smartshop_module_use == 'boutique' ||$smartshop_module_use == 'adds'){
	$modversion['config'][$i]['options'][_MI_SSHOP_DISP_FIELDS_PRICE] = 'price';
}

$modversion['config'][$i]['default'] = 'description|image|external_link|counter|date';

$i++;
$modversion['config'][$i]['name'] = 'def_item_pic';
$modversion['config'][$i]['title'] = '_MI_SSHOP_DEF_ITEM_PIC';
$modversion['config'][$i]['description'] = '_MI_SSHOP_DEF_ITEM_PIC_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'na_item.jpg';

$i++;
$modversion['config'][$i]['name'] = 'include_search';
$modversion['config'][$i]['title'] = '_MI_SSHOP_INCLUDESEARCH';
$modversion['config'][$i]['description'] = '_MI_SSHOP_INCLUDESEARCHDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'cat_inputtype_search';
$modversion['config'][$i]['title'] = '_MI_SSHOP_INPUTTYPE_SEARCH';
$modversion['config'][$i]['description'] = '_MI_SSHOP_INPUTTYPE_SEARCHDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(  _MI_SSHOP_INPUTTYPE_RADIO => 'radio',
                                   			 _MI_SSHOP_INPUTTYPE_SELECT => 'select',
                                   			  );
$modversion['config'][$i]['default'] = 'radio';

$member_handler = &xoops_gethandler('member');
$group_list = &$member_handler->getGroupList();
foreach ($group_list as $key=>$group) {
	$groups[$group] = $key;
}
$i++;
$modversion['config'][$i]['name'] = 'order_mail_groups';
$modversion['config'][$i]['title'] = '_MI_SSHOP_ORDER_MAIL';
$modversion['config'][$i]['description'] = '_MI_SSHOP_ORDER_MAIL_DSC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $groups;
$modversion['config'][$i]['default'] = array(1);

$i++;
$modversion['config'][$i]['name'] = 'extra_emails';
$modversion['config'][$i]['title'] = '_MI_SSHOP_EXTRA_EMAILS';
$modversion['config'][$i]['description'] = '_MI_SSHOP_EXTRA_EMAILS_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'signature';
$modversion['config'][$i]['title'] = '_MI_SSHOP_SIGNATURE';
$modversion['config'][$i]['description'] = '_MI_SSHOP_SIGNATURE_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'header_print';
$modversion['config'][$i]['title'] = '_MI_SSHOP_HEADER_PRINT';
$modversion['config'][$i]['description'] = '_MI_SSHOP_HEADER_PRINT_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'footer_print';
$modversion['config'][$i]['title'] = '_MI_SSHOP_FOOTER_PRINT';
$modversion['config'][$i]['description'] = '_MI_SSHOP_FOOTER_PRINT_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';


$i++;
$modversion['config'][$i]['name'] = 'footer';
$modversion['config'][$i]['title'] = '_MI_SSHOP_FOOTER';
$modversion['config'][$i]['description'] = '_MI_SSHOP_FOOTER_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'footer_display';
$modversion['config'][$i]['title'] = '_MI_SSHOP_FOOTER_DISP';
$modversion['config'][$i]['description'] = '_MI_SSHOP_FOOTER_DISP_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(_MI_SSHOP_FOOTER_DISP_ITEM  => 'item',
                                   			 _MI_SSHOP_FOOTER_DISP_CAT => 'category',
                                   			 _MI_SSHOP_FOOTER_DISP_BOTH => 'both'
                                  		 );
$modversion['config'][$i]['default'] = 'both';

$i++;
$modversion['config'][$i]['name'] = 'header_transac';
$modversion['config'][$i]['title'] = '_MI_SSHOP_HEADER_TRANSAC';
$modversion['config'][$i]['description'] = '_MI_SSHOP_HEADER_TRANSAC_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'footer_transac';
$modversion['config'][$i]['title'] = '_MI_SSHOP_FOOTER_TRANSAC';
$modversion['config'][$i]['description'] = '_MI_SSHOP_FOOTER_TRANSAC_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'maximum_imagesize';
$modversion['config'][$i]['title'] = '_MI_SSHOP_MAX_SIZE';
$modversion['config'][$i]['description'] = '_MI_SSHOP_MAX_SIZEDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '1000000';

$i++;
$modversion['config'][$i]['name'] = 'img_max_width';
$modversion['config'][$i]['title'] = '_MI_SSHOP_IMG_MAX_WIDTH';
$modversion['config'][$i]['description'] = '_MI_SSHOP_IMG_MAX_WIDTH_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '150';
$modversion['config'][$i]['category'] = 'format_options';

$i++;
$modversion['config'][$i]['name'] = 'img_max_height';
$modversion['config'][$i]['title'] = '_MI_SSHOP_IMG_MAX_HEIGHT';
$modversion['config'][$i]['description'] = '_MI_SSHOP_IMG_MAX_HEIGHT_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '150';
$modversion['config'][$i]['category'] = 'format_options';

$i++;

$modversion['config'][$i]['name'] = 'default_editor';
$modversion['config'][$i]['title'] = '_MI_SSHOP_DEFEDITOR';
$modversion['config'][$i]['description'] = '_MI_SSHOP_DEFEDITOR_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array('TextArea'  => 'textarea',
                                   			 'DHTML Text Area' => 'dhtmltextarea',
                                   			 'TinyEditor' => 'tiny',
                                   			 'FCKEditor' => 'fckeditor',
                                   			 'InBetween' => 'inbetween',
                                   			 'Koivi' => 'koivi',
                                   			 'Spaw' => 'spaw',
                                   			 'HTMLArea' => 'htmlarea'
                                  		 );
$modversion['config'][$i]['default'] = 'fckeditor';

$i++;
$modversion['config'][$i]['name'] = 'show_mod_name_breadcrumb';
$modversion['config'][$i]['title'] = '_MI_SSHOP_BCRUMB';
$modversion['config'][$i]['description'] = '_MI_SSHOP_BCRUMBDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'txtarea_width';
$modversion['config'][$i]['title'] = '_MI_SSHOP_TAREA_WIDTH';
$modversion['config'][$i]['description'] = '_MI_SSHOP_TAREA_WIDTH_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '60';

$i++;
$modversion['config'][$i]['name'] = 'txtarea_height';
$modversion['config'][$i]['title'] = '_MI_SSHOP_TAREA_HEIGHT';
$modversion['config'][$i]['description'] = '_MI_SSHOP_TAREA_HEIGHT_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '5';

if($smartshop_module_use == 'boutique'){
	$i++;
	$modversion['config'][$i]['name'] = 'max_qty_basket';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_MAX_QTY_BASKET';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_MAX_QTY_BASKET_DSC';
	$modversion['config'][$i]['formtype'] = 'textbox';
	$modversion['config'][$i]['valuetype'] = 'text';
	$modversion['config'][$i]['default'] =  '10';

}
//submission and expiration configs --  only for dynamic_dir and adds
if($smartshop_module_use == 'dynamic_directory' ||$smartshop_module_use == 'adds'){
	$i++;
	$modversion['config'][$i]['name'] = 'allowed_groups';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_ALLWD_GRP';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_ALLWD_GRP_DSC';
	$modversion['config'][$i]['formtype'] = 'select_multi';
	$modversion['config'][$i]['valuetype'] = 'array';
	$modversion['config'][$i]['options'] = $select_groups_options;
	$modversion['config'][$i]['default'] =  '1|2|3';

	$i++;
	$modversion['config'][$i]['name'] = 'autoapprove';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_AUTO_APP';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_AUTO_APP_DSC';
	$modversion['config'][$i]['formtype'] = 'yesno';
	$modversion['config'][$i]['valuetype'] = 'int';
	$modversion['config'][$i]['default'] = 1;

	$i++;
	$modversion['config'][$i]['name'] = 'display_poster';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_DISPLAY_POSTER';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_DISPLAY_POSTER_DSC';
	$modversion['config'][$i]['formtype'] = 'yesno';
	$modversion['config'][$i]['valuetype'] = 'int';
	$modversion['config'][$i]['default'] = 1;

	$i++;
	$modversion['config'][$i]['name'] = 'def_avatar';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_DEF_AVATAR';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_DEF_AVATAR_DSC';
	$modversion['config'][$i]['formtype'] = 'textbox';
	$modversion['config'][$i]['valuetype'] = 'text';
	$modversion['config'][$i]['default'] = 'na_avatar.jpg';

	$i++;
	$modversion['config'][$i]['name'] = 'submit_intro';
	$modversion['config'][$i]['title'] = '_MI_SSHOPSUBMIT_INTRO';
	$modversion['config'][$i]['description'] = '_MI_SSHOPSUBMIT_INTRO_DSC';
	$modversion['config'][$i]['formtype'] = 'textarea';
	$modversion['config'][$i]['valuetype'] = 'text';
	$modversion['config'][$i]['default'] = '';


	$i++;
	$modversion['config'][$i]['name'] = 'def_delay_exp';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_DEF_DELAY_EXP';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_DEF_DELAY_EXP_DSC';
	$modversion['config'][$i]['formtype'] = 'textbox';
	$modversion['config'][$i]['valuetype'] = 'text';
	$modversion['config'][$i]['default'] = '365';

	$i++;
	$modversion['config'][$i]['name'] = 'notif_exp';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_NOTIF_EXP';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_NOTIF_EXP_DSC';
	$modversion['config'][$i]['formtype'] = 'select';
	$modversion['config'][$i]['valuetype'] = 'text';
	$modversion['config'][$i]['options'] = array(_MI_SSHOP_NONE => '0' ,
												1 => '1',
												3 => '3',
	                                   			5 => '5',
	                                   			7 => '7',
	                                   			15 => '15',
	                                   			20 => '20',
	                                   			30 => '30',
	                                   			_MI_SSHOP_ONLY_EXP => '100'
	                                  		 );
	$modversion['config'][$i]['default'] = '7';

	$i++;
	$modversion['config'][$i]['name'] = 'exp_manageby_cron';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_EXP_MANAGEBY_CRON';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_EXPMANAGEBYCRONDSC';
	$modversion['config'][$i]['formtype'] = 'yesno';
	$modversion['config'][$i]['valuetype'] = 'int';
	$modversion['config'][$i]['default'] = 0;



}
/*$i++;
	$modversion['config'][$i]['name'] = 'use_custom_version';
	$modversion['config'][$i]['title'] = '_MI_SSHOP_CUSTOM_VERSION';
	$modversion['config'][$i]['description'] = '_MI_SSHOP_CUSTOM_VERSIONDSC';
	$modversion['config'][$i]['formtype'] = 'select';
	$modversion['config'][$i]['options'] = array(_MI_SSHOP_STANDARD => 'std' ,
												'Auburn manufacturing inc.' => 'ami'
	                                  		 );
	$modversion['config'][$i]['default'] = 'std';
*/
// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'smartshop_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_SSHOP_GLOBAL_ITEM_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_SSHOP_GLOBAL_ITEM_NOTIFY_DSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php', 'category.php', 'item.php');

$modversion['notification']['category'][2]['name'] = 'item';
$modversion['notification']['category'][2]['title'] = _MI_SSHOP_ITEM_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_SSHOP_ITEM_NOTIFY_DSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('submit.php');
$modversion['notification']['category'][2]['item_name'] = 'itemid';

$modversion['notification']['event'][1]['name'] = 'approved';
$modversion['notification']['event'][1]['category'] = 'item';
$modversion['notification']['event'][1]['invisible'] = 1;
$modversion['notification']['event'][1]['title'] = _MI_SSHOP_ITEM_APPROVED_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_SSHOP_ITEM_APPROVED_NOTIFY_CAP;
$modversion['notification']['event'][1]['description'] = _MI_SSHOP_ITEM_APPROVED_NOTIFY_DSC;
$modversion['notification']['event'][1]['mail_template'] = 'item_approved';
$modversion['notification']['event'][1]['mail_subject'] = _MI_SSHOP_ITEM_APPROVED_NOTIFY_SBJ;


$modversion['notification']['event'][2]['name'] = 'submitted';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = _MI_SSHOP_ITEM_SUBMITTED_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_SSHOP_ITEM_SUBMITTED_NOTIFY_CAP;
$modversion['notification']['event'][2]['description'] = _MI_SSHOP_ITEM_SUBMITTED_NOTIFY_DSC;
$modversion['notification']['event'][2]['mail_template'] = 'item_submitted';
$modversion['notification']['event'][2]['mail_subject'] = _MI_SSHOP_ITEM_SUBMITTED_NOTIFY_SBJ;

$modversion['notification']['event'][3]['name'] = 'published';
$modversion['notification']['event'][3]['category'] = 'global';
$modversion['notification']['event'][3]['title'] = _MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP;
$modversion['notification']['event'][3]['description'] = _MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_published';
$modversion['notification']['event'][3]['mail_subject'] = _MI_SSHOP_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ;

?>