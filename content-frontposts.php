<?php
/**
 * The template for displaying featured posts on Front Page 
 *
 * @package Runway
 * @since Runway 1.0
 */
?>

<?php 
        // Start a new query for displaying featured posts on Front Page
                
        if(get_theme_mod('runway_front_featured_posts_check')) {
                $featured_count = intval( get_theme_mod( 'runway_front_featured_posts_count' ) );
                $var = get_theme_mod('runway_front_featured_posts_cat');
                
                // if no category is selected then return 0 
                $featured_cat_id = max((int)$var, 0);
                
                $featured_post_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $featured_count,
                        'cat' => $featured_cat_id,
                        'post__not_in' => get_option( 'sticky_posts' ),
                );
                $featuredposts = new WP_Query($featured_post_args);
                ?>
        <div id="front-featured-posts">
                
            <div id="featured-posts-container" class="row">
            
                <div id="featured-posts" class="col grid_12_of_12">
                    <?php if ( get_theme_mod( 'runway_front_featured_posts_title' ) ) : ?>
                        <h3 class="featured-section-title">
                            <?php echo get_theme_mod('runway_front_featured_posts_title'); ?>
                        </h3>
                    <?php endif; ?>
                        <?php if ($featuredposts->have_posts()) : $i = 1; ?>
                    
                                <?php while ($featuredposts->have_posts()) : $featuredposts->the_post(); ?>
                    
                                        <div class="col grid_3_of_12 home-featured-post">
                    
                                            <div class="featured-post-content">
                                            
                                                <a href="<?php the_permalink(); ?>">
                                                
                                                            <?php the_post_thumbnail('post_feature_thumb'); ?>
                                            
                                                            <span class="feature-more-link"><?php echo get_theme_mod('runway_front_featured_link_text'); ?></span>
                                                        
                                                </a>
                                              
                                            </div> <!--end .featured-post-content -->
                                            
                                            <a href="<?php the_permalink(); ?>">
                                            
                                                <h3 class="home-featured-post-title"><?php the_title(); ?></h3>
                                                
                                            </a>
                                        
                                        </div><!--end .home-featured-post-->
                                        
                                            <?php $i+=1; ?>
                                    
                                      <?php endwhile; ?>
                        
                           <?php else : ?>

                                    
                                        <h2 class="center">Not Found</h2>
                                
                                        <p class="center">Sorry, but you are looking for something that isn't here.</p>
                                
                                            <?php get_search_form(); ?>

                            <?php endif; ?>

                     </div> <!-- /#featured-posts -->
                     
                </div> <!-- /#featured-posts-container -->
                
        </div> <!-- /#front-featured-posts -->
            
<?php } // end Featured post query ?>