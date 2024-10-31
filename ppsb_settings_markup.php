<?php

/**
* @plugin Per Page Sidebar Blocks Plugin
* @title  Init and markup admin menus
* @author Jason Michael Cross - www.jasonmichaelcross.com
* @author Immense Networks - www.immense.net
*/

 ?>
<div class="wrap">
   <div class="icon32" id="icon-options-general"><br /></div>
   <h2>Per Page Sidebar Blocks Settings</h2>
      <div class="postbox-container" style="width:70%;">
            <div class="metabox-holder ppsb_box">
                  <form name="ppsb_settings_form" method="post">
                        <div class="postbox">
                              <h3>Available Sidebars</h3>
                              <div class="section">
                              <?php
                              if( ppsb_has_sidebars() ) $ppsb_actives = ppsb_define_sidebars();
                                    if($ppsb_actives) :
                                          $content .= '<p>Drag sidebar blocks into preferred display order. The new order is saved automatically.</p>';
                                          $content .= '<ul id="sortable">';
                                          foreach($ppsb_actives as $ppsb_active) :
                                                $ppsb_active = ppsb_format_sidebar($ppsb_active);
                                                $current_value = get_option('ppsb_sidebar_'.$ppsb_active);

                                                $content .= '<li id="ppsb_side_'.$ppsb_active.'" class="menu-item-handle"><span class="item-title">'.ucfirst($ppsb_active).'</span> <span class="item-controls"><span class="item-type">sidebar-'.$ppsb_active.'.php</span></span><input type="hidden" class="regular-text" id="ppsb_sidebar_'.$ppsb_active.'" name="ppsb_sidebar_'.$ppsb_active.'" value="'.$current_value.'" /></li>';
                                          endforeach;
                                    else :
                                          $content .= '<ul>';
                                          $content .= '<li><h4>Sorry, there are no sidebar templates in your theme\'s directory.</h4></li>';
                                    $content .= '</ul>';

                              $content .= '
                              <p>For this plugin to work, do the following:</p>
                              <ol>
                                    <li>Add the following to your theme\'s <strong>sidebar.php</strong> template:<br />
                                          <pre>&lt;?php if( function_exists( \'ppsb_show_sidebars\' ) ) echo ppsb_show_sidebars(); ?&gt;</pre></li>
                                    <li>Create a sidebar template file for each of your sidebar blocks in your theme\'s directory. Name them <strong>sidebar-<em>name</em>.php</strong><br /></li>
                              </ol>
                                    ';
                              endif; // if no sidebars init
                        echo $content; ?>
                        <pre style="position:absolute;left:-9999em;top:0;"><div id="info">Debug box</div></pre>
                              </div> <!-- /section -->
                              <div class="submit-box">
                                    <p><a href="http://www.immense.net/per-page-sidebar-blocks/" title="Per Page Sidebar Blocks WordPress plugin">Plugin page</a>. Developed by <a href="http://www.immense.net?ppsb_plugin" title="Immense Networks">Immense Networks</a></p>
                                    <?php /* <input type="submit" value="<?php _e('Save All Changes') ?>" class="button-primary" id="submit" name="submit"> */ ?>
                              </div> <!-- submit-box -->
                        </div> <!-- /postbox -->
                  </form>
            </div> <!-- /metabox-holder -->
      </div> <!-- /postbox-container -->
</div> <!-- /wrap -->