<?php
/*
Plugin Name: Per Page Sidebar Blocks
Version: 1.0.3
Plugin URI: http://www.immense.net/per-page-sidebars-wordpress-plugin/
Description: Include sidebar templates on a per-page basis.
Author: Immense Networks | Jason Michael Cross
Author URI: http://www.immense.net/
*/

/* Definitions */
define('PPSB_VERSION', '1.0.3');
define('PPSB_URL', plugin_dir_url( __FILE__ ));
define('PPSB_SETTINGS_URL', 'options-general.php?page=ppsb_settings');
define('PUBLIC_THEME_DIR', get_bloginfo('template_directory'));
define('CURRENT_PAGE', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

/* Trigger on plugin activation */
register_activation_hook( __FILE__, 'set_ppsb_activate' );

if(ppsb_dbversion()) {
	set_ppsb_activate();
	update_option('ppsb_dbversion', PPSB_VERSION);
}

// Determine database version number of PPS
function ppsb_dbversion() {
	if(get_option('ppsb_dbversion') < PPSB_VERSION) {
		return true;
	} else {
		return false;
	}
}

/* Create default values in wp_options table when plugin is activated */
function set_ppsb_activate() {
	add_option('ppsb_dbversion', PPSB_VERSION);
	if(function_exists( 'ppsb_define_sidebars') ) :
		add_option('ppsb_array_init', 0); // send false to wp_options
	else :
		add_option('ppsb_array_init', 1); // send true to wp_options
	endif;
}

/* Create PPS Settings page in admin */
include ('ppsb_admin_menus.php');

/* Load the Admin CSS */
function ppsb_load_styles() {
	wp_enqueue_style('ppsb_admin_style', PPSB_URL.'css/ppsb_admin_styles.css');
}
add_action('admin_print_styles','ppsb_load_styles');

/* Put sidebar markup on post/page */
add_action('admin_menu', 'ppsb_meta_box');

function ppsb_meta_box () {
	add_meta_box(
		'ppsb_sidebox_id', // id
		'Per Page Sidebar Blocks', // title
		'ppsb_meta_content', // callback function
		'page', // page, post
		'side', // location (side, advanced)
		'low' // priority
	);
}

/**
*
* Display list of sidebars as checkboxes in PPS meta box
*
*/
function ppsb_meta_content ( $post ) {

	if( ppsb_has_sidebars() ) $ppsb_actives = ppsb_define_sidebars();
	if($ppsb_actives) :
		$content .= '<ul>';

		foreach($ppsb_actives as $ppsb_active) :
			$ppsb_active = ppsb_format_sidebar($ppsb_active);

			$checked = get_post_meta( $post->ID, 'sidebar_'.$ppsb_active, true );
			if($checked == 'yes') :
				$checked_markup = 'checked="checked"';
			else :
				$checked_markup = '';
			endif;
			$content .= '<li><label><input type="checkbox" name="sidebar_'.$ppsb_active.'" id="sidebar_'.$ppsb_active.'"'.$checked_markup.' /> <strong>'.ucfirst($ppsb_active).'</strong> (<em>sidebar-'.$ppsb_active.'.php</em>)</label></li>';
		endforeach;
		$content .= '</ul>';
		$content .= '<p>Select all blocks to be shown on this page. <a href="/wp-admin/options-general.php?page=ppsb_settings">Update order</a></p>';
	else :
		$content .= '<p align="center"><em>No sidebar blocks available</em></p>';
	endif;

	echo $content;
}

/* Do something with the data entered */
add_action( 'save_post', 'ppsb_save_postdata' );

/* Send PPS data to database when saved */
function ppsb_save_postdata ( $post_id ) {
	if($_REQUEST['save']) :
		$ppsb_actives = ppsb_define_sidebars();
		foreach($ppsb_actives as $ppsb_active) {
			$ppsb_active = ppsb_format_sidebar($ppsb_active);
			// Table prefix_postmeta. If value does not exist, add it. If does exist, update it.
			if(isset($_POST['sidebar_'.$ppsb_active])) :
				update_post_meta( $post_id, 'sidebar_'.$ppsb_active, 'yes' );
			else :
				update_post_meta( $post_id, 'sidebar_'.$ppsb_active, 'no' );
			endif;
		}
	endif;
}

/**
*
* Pull in functions for processing forms
*
* depracated v1.0.1 - replaced w/ AJAX
*/
include ('ppsb_form_process.php');


/**
* Find sidebar templates that exist in current theme's directory. Then use ksort to order values.
*
* @return array All files in current theme dir matching naming convention sidebar-testing.php
*/
function ppsb_define_sidebars () {
	$sidebars = glob(TEMPLATEPATH.'/sidebar-*.php');
	foreach( $sidebars as $sidebar ) :
		$sidebar = ppsb_format_sidebar($sidebar);
		$current_value = get_option('ppsb_sidebar_'.$sidebar);
		//$default_show = get_option('sidebar_'.$sidebar.'_checked');

		if( $current_value == NULL ) $current_value = update_option('ppsb_sidebar_'.$sidebar, rand(100,9999));
		//if( $default_show == NULL ) $default_show == 'no';


		$sorted[$current_value] = $sidebar;
	endforeach;
	if($sorted) ksort($sorted, SORT_NUMERIC);
	return $sorted;
}

/**
*
* Format sidebar name - removes path and extension, leaving just the specific name.
* For example, "/home/account/wp-content/theme/yourtheme/sidebar-testing.php" returns "testing"
*
* @param $ppsb_sidebar Full path to file
* @return string Name of sidebar template
*/
function ppsb_format_sidebar ($ppsb_sidebar) {
	$ppsb_sidebar = str_replace(TEMPLATEPATH.'/sidebar-', '', $ppsb_sidebar);
	$ppsb_sidebar = str_replace('.php', '', $ppsb_sidebar);
	if($sidebar_name) :
		$sidebar_name .= $ppsb_sidebar;
	else :
		$sidebar_name = $ppsb_sidebar;
	endif;

	return $sidebar_name;
}

/**
*
* Determine if sidebar template files exist.
*
* Save boolean true/false in wp_options as needed.
*/
function ppsb_arrayinit_check () {
	if( ppsb_define_sidebars() ) :
		update_option('ppsb_array_init', 1); // send true to wp_options
	else :
		update_option('ppsb_array_init', 0); // send false to wp_options
	endif;
}
add_action('admin_init', 'ppsb_arrayinit_check');

/**
*
* Grab value of ppsb_array_init, which determines if theme has sidebar template files for use.
*
*/
function ppsb_has_sidebars () {
	return get_option('ppsb_array_init');
}

/**
* Error message when no sidebar templates are found.
*
* @return string Error message
*/
function ppsb_not_init () {
	$content .= '
	    <div id="message" class="error fade">
	        <p><strong>Per Page Sidebar Blocks:</strong> You have no sidebars initialized. <a href="'.PPSB_SETTINGS_URL.'" title="Learn how to here">Learn how to here</a></p>
	    </div> <!-- /message -->';
	echo $content;
}
if( !get_option('ppsb_array_init') ) :
	add_action('admin_head', 'ppsb_not_init');
endif;

/**
*
* Display content of sidebar template using get_post_meta().
*
* @return Sidebars that are checked for this page, sorted by display order.
*/
function ppsb_show_sidebars () {
	// define available sidebars as array
	if( ppsb_has_sidebars() ) $ppsb_actives = ppsb_define_sidebars();
	if($ppsb_actives) :
		// loop through array and verify if value is checked
		foreach($ppsb_actives as $ppsb_active) :
			$ppsb_active = ppsb_format_sidebar($ppsb_active); // remove filepath and extension, leaving just name
			$checked = get_post_meta( get_the_id(), 'sidebar_'.$ppsb_active, true ); // check if supposed to be displayed on this page
			if($checked == 'yes') :
				$displayorder = get_option('ppsb_sidebar_'.$ppsb_active); // grab assigned display order from settings page
				$content .= get_sidebar($ppsb_active);
			endif;
		endforeach;
	endif;
	return $content;
}

?>