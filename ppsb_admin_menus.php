<?php 

/**
* @plugin Per Page Setting Blocks Plugin
* @title  Create admin menus
* @author Jason Michael Cross - www.jasonmichaelcross.com
* @author Immense Networks - www.immense.net
*/

/* Actions */
add_action('admin_menu', 'ppsb_settings_menu');

/* Settings menu */
function ppsb_settings_menu () {
	add_submenu_page('options-general.php', 'Per Page Sidebar Blocks', 'P/P Sidebar Blocks', 'manage_options', 'ppsb_settings', 'ppsb_admin_page');
}

/* Markup for main settings page */
function ppsb_admin_page() {
    if($_REQUEST['submit']) {
        ppsb_update_order();
    }
    include('ppsb_settings_markup.php');
}

/* Scripts for PPS Settings page sortable */
function ppsb_admin_scripts () {
	wp_register_script('ppsb_admin_js', PPSB_URL.'/js/ppsb_admin_js.js', array('jquery-ui-sortable'));
	wp_enqueue_script('ppsb_admin_js');
}

/* Enqueue scripts for file uploading on Manage Help page */
if (isset($_GET['page']) && $_GET['page'] == 'ppsb_settings') {
	add_action('admin_print_scripts', 'ppsb_admin_scripts');
}

?>