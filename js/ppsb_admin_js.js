 /**
 * @plugin Per Page Sidebar Blocks Plugin
 * @title  Admin JavaScript
 * @author Jason Michael Cross - www.jasonmichaelcross.com
 * @author Immense Networks - www.immense.net
 */

jQuery(document).ready(function ($) {
	$("#sortable").sortable({ 
		update : function () { 
			var order = $('#sortable').sortable('serialize');
			$.ajax({
				url: '/wp-content/plugins/per-page-sidebar-blocks/ppsb_process_sortable.php?'+order,
					success: function(data) {
					//alert(order);
				}
			});
		}
	});
});