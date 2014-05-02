<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package Runway
 * @since Runway 1.0
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if (is_home()) { ?>
                 <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'runway' ), the_title_attribute( 'echo=0' ) ) ); ?>">
			<?php the_post_thumbnail( 'post_blog_thumb' ); ?>
		</a>
            <?php } ?>
		<header class="entry-header">
			<?php if ( is_single() ) { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php }
			else { ?>
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'runway' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
			<?php } // is_single() ?>
			<?php runway_posted_on(); ?>
			<?php if ( has_post_thumbnail() && !is_search() && is_single() || is_archive()) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'runway' ), the_title_attribute( 'echo=0' ) ) ); ?>">
					<?php the_post_thumbnail( 'post_feature_full_width' ); ?>
				</a>
			<?php } ?>
		</header> <!-- /.entry-header -->

		<?php if ( is_search() || is_home() || is_archive() ) { // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div> <!-- /.entry-summary -->
		<?php }
		else { ?>
			<div class="entry-content">
				<?php the_content( wp_kses( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'runway' ), array( 'span' => array( 
					'class' => array() ) ) )
					); ?>
				<?php wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'runway' ),
					'after' => '</div>',
					'link_before' => '<span class="page-numbers">',
					'link_after' => '</span>'
				) ); ?>
			</div> <!-- /.entry-content -->
		<?php } ?>

		
	</article> <!-- /#post -->
