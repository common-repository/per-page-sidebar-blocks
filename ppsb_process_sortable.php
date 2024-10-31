<?php 

/**
* @plugin Per Page Sidebar Blocks Plugin
* @title  Init and markup admin menus
* @author Jason Michael Cross - www.jasonmichaelcross.com
* @author Immense Networks - www.immense.net
*/

/* Old method. Removed for version 1.0.3 */
//require_once('../../../wp-blog-header.php');

/*
New v1.0.3. Fixed weird 404 bug causing errors on PPSB Settings page.
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

/*
Thanks to http://www.ballyhooblog.com/tag/wp-blog-header-php/, the method below also works. Please notify me if this is a better solution than the one above.
*/
//define('WP_USE_THEMES', false);
//include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

/*
Assign each sidebar block a new position number.
*/
foreach ($_GET['ppsb_side'] as $new_position => $name) : 
  update_option('ppsb_sidebar_'.$name, $new_position);
endforeach; 

?>