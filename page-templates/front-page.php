<?php
/**
 * Template Name: Front Page Template
 *
 * Description: Displays a full-width front page. The front page template provides an optional
 * banner section that allows for highlighting a key message. It can contain up to 2 widget areas,
 * in one or two columns. These widget areas are dynamic so if only one widget is used, it will be
 * displayed in one column. If two are used, then they will be displayed over 2 columns.
 * There are also four front page only widgets displayed just beneath the main content. Like the
 * banner widgets, they will be displayed in anywhere from one to four columns, depending on
 * how many widgets are active.
 *
 * @package Runway
 * @since Runway 1.0
 */

get_header(); ?>
<div id="home-featured-container">
             <?php if (is_active_sidebar('frontpage-banner')) { ?>
		<div class="home-featured row">
                         <div class="col grid_12_of_12">
                                   <?php dynamic_sidebar('frontpage-banner'); ?>
                                </div>
		</div> <!-- /.home-featured .row -->
                 <?php } ?>
	</div> <!-- /#home-featured-container -->
            
        <!-- Starting Testimonial Container -->
			<?php 
				// Count how many testimonial sidebars are active so we can work out how many containers we need
				$testimonialSidebars = 0;
				for ( $x=1; $x<=2; $x++ ) {
					if ( is_active_sidebar( 'home-testimonial' . $x ) ) {
						$testimonialSidebars++;
					}
				}

				// If there's one or more one active sidebars, create a row and add them
				if ( $testimonialSidebars > 0 ) { ?>
                                <div class="testimonial-container">
                                    <div class="testimonial row">
                                    
					<?php
					// Work out the container class name based on the number of active testimonial sidebars
					$containerClass = "grid_" . 12 / $testimonialSidebars . "_of_12";

					// Display the active testimonial sidebars
					for ( $x=1; $x<=2; $x++ ) {
						if ( is_active_sidebar( 'home-testimonial'. $x ) ) { ?>
							<div class="col <?php echo $containerClass?>">
								<div class="widget-area" role="complementary">
									<?php dynamic_sidebar( 'home-testimonial'. $x ); ?>
								</div> <!-- /.widget-area -->
							</div> <!-- /.col.<?php echo $containerClass?> -->
						<?php }
					} ?>
                                 </div> <!-- /.testimonial .row -->
                            </div> <!-- /.testimonial-container -->
				<?php }
			?>
        </div>
        </div>
        
	
	<?php get_sidebar( 'front' ); ?>
	
<?php get_footer(); ?>
