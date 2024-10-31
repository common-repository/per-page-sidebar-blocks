<?php

 /**
 * @plugin Per Page Sidebar Blocks Plugin
 * @title  Form processing, update database values
 * @author Jason Michael Cross - www.jasonmichaelcross.com
 * @author Immense Networks - www.immense.net
 */
 
function update_ppsb_settings () {
	$ppsb_actives = ppsb_define_sidebars();

	foreach($ppsb_actives as $ppsb_active) :
		$ppsb_active = ppsb_format_sidebar($ppsb_active);
		update_option('ppsb_sidebar_'.$ppsb_active, $_REQUEST['ppsb_sidebar_'.$ppsb_active]);
	endforeach;
}

function ppsb_update_order () {
	$content .= '
		<div id="message" class="updated fade">
			<p>Options saved.</p>
		</div> <!-- /message -->';

	return $content;
}

 ?>