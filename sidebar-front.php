<?php
/**
 * The sidebar containing the front page widget areas.
 * If there are no active widgets, the sidebar will be hidden completely.
 *
 * @package Runway
 * @since Runway 1.0
 */
?>
	
        <?php 
        // check if any of the home sidebars is active
        if(is_active_sidebar('home-one-left') || is_active_sidebar('home-one-right') || is_active_sidebar('home-two-left') || is_active_sidebar('home-two-right') || is_active_sidebar('home-three-left') || is_active_sidebar('home-three-right')|| is_active_sidebar('home-four-left') || is_active_sidebar('home-four-right')) { ?>
        <div id="home-widget-container">
		
                    <!-- Starting Home One Container -->
			<?php 
				// Count how many Home one sidebars are active so we can work out how many containers we need
				$homeoneSidebar = 0;
				for ( $x=1; $x<=3; $x++ ) {
					if ( is_active_sidebar( 'home-one' . $x ) ) {
						$homeoneSidebar++;
					}
				}

				// If there's one or more one active sidebars, create a row and add them
				if ( $homeoneSidebar > 0 ) { ?>
                                <div id="home-one" class="row">
                                    <div class="wrap clearfix">
                                    
					<?php
					// Work out the container class name based on the number of active Home One sidebars
					$containerClass = "grid_" . 12 / $homeoneSidebar . "_of_12";

					// Display the active Home One sidebars
					for ( $x=1; $x<=3; $x++ ) {
						if ( is_active_sidebar( 'home-one'. $x ) ) { ?>
							<div class="col <?php echo $containerClass?>">
								<div class="widget-area" role="complementary">
									<?php dynamic_sidebar( 'home-one'. $x ); ?>
								</div> <!-- /.widget-area -->
							</div> <!-- /.col.<?php echo $containerClass?> -->
						<?php }
					} ?>
                                 </div> <!-- /.wrap  -->
                            </div> <!-- /.home-one .row -->
				<?php }
			?>
                     
                    <div id="home-cta" class="row">
						<?php if (is_active_sidebar('home-cta')) { ?>
						<div class="wrap clearfix">
								 <div class="col grid_12_of_12">
										   <?php dynamic_sidebar('home-cta'); ?>
								</div>
						</div> <!-- /.home-cta .row -->
						 <?php } ?>
					</div> <!-- /#home-cta -->

                     
                    <?php // Display featured posts on front page
							get_template_part('content','frontposts'); ?>
                     
                     
                     <?php 
                    // check if a any of Home #4 sidebar is active 
                    if (is_active_sidebar('home-four-left') || is_active_sidebar('home-four-right')) { ?>
                        <div id="home-four" class="row">
                             <div class="wrap clearfix">
                                    <?php 
                                    // check if both Home #4 sidebars are active then display both sidebars
                                    if(is_active_sidebar('home-four-left') && is_active_sidebar('home-four-right')) { ?> 
                                             <div class="col grid_6_of_12">
                                                    <?php dynamic_sidebar ('home-four-left'); ?>
                                             </div>
                                             <div class="col grid_6_of_12">
                                                    <?php dynamic_sidebar ('home-four-right'); ?>
                                             </div>
                                            
                                    <?php } ?>
                                    <?php 
                                    // check if only Home #4 left is active and Home #4 right is NOT active
                                    if (is_active_sidebar('home-four-left') && !is_active_sidebar('home-four-right')) { ?>
                                             <div class="col grid_12_of_12">
                                                    <?php dynamic_sidebar ('home-four-left'); ?>
                                             </div>
                                    <?php } ?>
                                     <?php 
                                     // check if only Home #4 right  is active and Home #4 left is NOT active
                                     if (is_active_sidebar('home-four-right') && !is_active_sidebar('home-four-left')) { ?>
                                             <div class="col grid_12_of_12">
                                                    <?php dynamic_sidebar ('home-four-right'); ?>
                                             </div>
                                    <?php } ?>
                              </div> <!-- end .wrap -->
                     </div> <!-- end #home-four -->
                  <?php } ?>
                     
        <?php } ?>
                                
                     
         </div> <!-- end #home-widget-container -->
                           