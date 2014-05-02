<?php
/**
 * Runway functions and definitions
 *
 * @package Runway
 * @since Runway 1.0
 */



/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/theme-extras.php';

// customizer addition
require get_template_directory() . '/inc/customizer.php';

add_action( 'after_setup_theme', 'runway_setup' );

/* Include plugin activation file to install plugins */
include get_template_directory() . '/inc/plugin-activation/plugin-details.php';


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Runway 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 790; /* Default the embedded content width to 790px */


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Runway 1.0
 *
 * @return void
 */
if ( ! function_exists( 'runway_setup' ) ) {
	function runway_setup() {
		global $content_width;

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on Runway, use a find and replace
		 * to change 'runway' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'runway', trailingslashit( get_template_directory() ) . 'languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );

		// Create an extra image size for the Post featured image
		add_image_size( 'post_feature_full_width', 792, 300, true );
                
                // create extra image size for blog page
                add_image_size ('post_blog_thumb', 362, 239, true); 

		// This theme uses wp_nav_menu() in one location
		register_nav_menus( array(
				'primary' => esc_html__( 'Primary Menu', 'runway' )
			) );

		// This theme supports a variety of post formats
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

		// Enable support for Custom Backgrounds
		add_theme_support( 'custom-background', array(
				// Background color default
				'default-color' => 'fff',
				// Background image default
				'default-image' => trailingslashit( get_template_directory_uri() ) . 'images/squares.jpg'
			) );

		// Enable support for Custom Headers (or in our case, a custom logo)
		add_theme_support( 'custom-header', array(
				// Header image default
				'default-image' => trailingslashit( get_template_directory_uri() ) . 'images/logo.png',
				// Header text display default
				'header-text' => false,
				// Header text color default
				'default-text-color' => '000',
				// Flexible width
				'flex-width' => true,
				// Header image width (in pixels)
				'width' => 300,
				// Flexible height
				'flex-height' => true,
				// Header image height (in pixels)
				'height' => 80
			) );

	}
}


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of PT Sans and Arvo by default is localized. For languages that use characters not supported by the fonts, the fonts can be disabled.
 *
 * @since Runway 1.2.5
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function runway_fonts_url() {
	$fonts_url = '';
	$subsets = 'latin';

	/* translators: If there are characters in your language that are not supported by PT Sans, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	$pt_sans = _x( 'on', 'Open Sans font: on or off', 'runway' );

	/* translators: To add an additional PT Sans character subset specific to your language, translate this to 'greek', 'cyrillic' or 'vietnamese'.
	 * Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Open Sans font: add new subset (cyrillic)', 'runway' );

	if ( 'cyrillic' == $subset )
		$subsets .= ',cyrillic';

	/* translators: If there are characters in your language that are not supported by Arvo, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	$arvo = _x( 'on', 'Arvo font: on or off', 'runway' );

	if ( 'off' !== $pt_sans || 'off' !== $arvo ) {
		$font_families = array();

		if ( 'off' !== $pt_sans )
			$font_families[] = 'Open+Sans:400,300,400italic,700,700italic';

		if ( 'off' !== $arvo )
			$font_families[] = 'Arvo:400';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => $subsets,
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @since Runway 1.2.5
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string The filtered CSS paths list.
 */
function runway_mce_css( $mce_css ) {
	$fonts_url = runway_fonts_url();

	if ( empty( $fonts_url ) ) {
		return $mce_css;
	}

	if ( !empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $fonts_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'runway_mce_css' );


/**
 * Register widgetized areas
 *
 * @since Runway 1.0
 *
 * @return void
 */
function runway_widgets_init() {
	register_sidebar( array(
			'name' => esc_html__( 'Main Sidebar', 'runway' ),
			'id' => 'sidebar-main',
			'description' => esc_html__( 'Appears in the sidebar on posts and pages except the optional Front Page template, which has its own widgets', 'runway' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		) );

	register_sidebar( array(
			'name' => esc_html__( 'Footer #1', 'runway' ),
			'id' => 'sidebar-footer1',
			'description' => esc_html__( 'Appears in the footer sidebar', 'runway' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title title-wrap">',
			'after_title' => '</h3>'
		) );

	register_sidebar( array(
			'name' => esc_html__( 'Footer #2', 'runway' ),
			'id' => 'sidebar-footer2',
			'description' => esc_html__( 'Appears in the footer sidebar', 'runway' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		) );

	register_sidebar( array(
			'name' => esc_html__( 'Footer #3', 'runway' ),
			'id' => 'sidebar-footer3',
			'description' => esc_html__( 'Appears in the footer sidebar', 'runway' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		) );
}
add_action( 'widgets_init', 'runway_widgets_init' );


/**
 * Enqueue scripts and styles
 *
 * @since Runway 1.0
 *
 * @return void
 */
function runway_scripts_styles() {

	/**
	 * Register and enqueue our stylesheets
	 */

	// Register and enqueue our icon font
	// We're using the awesome Font Awesome icon font. http://fortawesome.github.io/Font-Awesome
	wp_enqueue_style( 'fontawesome', trailingslashit( get_template_directory_uri() ) . 'assets/css/font-awesome.min.css' , array(), '4.0.3', 'all' );
        
	/*
	 * Load our Google Fonts.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'runway-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */
	$fonts_url = runway_fonts_url();
	if ( !empty( $fonts_url ) ) {
		wp_enqueue_style( 'runway-fonts', esc_url_raw( $fonts_url ), array(), null );
	}

	// Enqueue the default WordPress stylesheet
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.2.3', 'all' );


	/**
	 * Register and enqueue our scripts
	 */

	// Load Modernizr at the top of the document, which enables HTML5 elements and feature detects
	wp_enqueue_script( 'modernizr', trailingslashit( get_template_directory_uri() ) . 'assets/js/modernizr-2.7.1-min.js', array(), '2.7.1', false );
       
        
        wp_enqueue_script( 'jquery-masonry', array( 'jquery' ) );
        
        if (is_home() || is_archive()) {
            wp_enqueue_script( 'masonry-init', trailingslashit( get_template_directory_uri() ) . 'assets/js/masonry-init.js', array( 'jquery-masonry' ), '1.0', false );
        }

        wp_enqueue_script( 'runway-slicknav', get_template_directory_uri() . '/assets/js/jquery.slicknav.min.js' );
        
        
        
	// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'runway_scripts_styles' );


if (!function_exists('runway_footer_js')) {
    function runway_footer_js() { ?>
            <script>     

            jQuery(document).ready(function($) {   

            $('#site-navigation .menu>ul').slicknav({prependTo:'#mobile-menu'});

            });
            </script>
        <?php }
}
add_action( 'wp_footer', 'runway_footer_js', 20, 1 );    

/**
 * Adjusts content_width value for full-width templates and attachments
 *
 * @since Runway 1.0
 *
 * @return void
 */
function runway_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() ) {
		global $content_width;
		$content_width = 1140;
	}
}

add_action( 'template_redirect', 'runway_content_width' );



/**
 * Extend the user contact methods to include Twitter, Facebook and Google+
 *
 * @since Runway 1.0
 *
 * @param array List of user contact methods
 * @return array The filtered list of updated user contact methods
 */
function runway_new_contactmethods( $contactmethods ) {
	// Add Twitter
	$contactmethods['twitter'] = 'Twitter';

	//add Facebook
	$contactmethods['facebook'] = 'Facebook';

	//add Google Plus
	$contactmethods['googleplus'] = 'Google+';

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'runway_new_contactmethods', 10, 1 );

/**
 * Add Filter to allow Shortcodes to work in the Sidebar
 *
 * @since Runway 1.0
 */
add_filter( 'widget_text', 'do_shortcode' );


/**
 * Recreate the default filters on the_content
 * This will make it much easier to output the Theme Options Editor content with proper/expected formatting.
 * We don't include an add_filter for 'prepend_attachment' as it causes an image to appear in the content, on attachment pages.
 * Also, since the Theme Options editor doesn't allow you to add images anyway, no big deal.
 *
 * @since Runway 1.0
 */
add_filter( 'meta_content', 'wptexturize' );
add_filter( 'meta_content', 'convert_smilies' );
add_filter( 'meta_content', 'convert_chars'  );
add_filter( 'meta_content', 'wpautop' );
add_filter( 'meta_content', 'shortcode_unautop'  );


add_filter('body_class', 'runway_body_classes');

function runway_body_classes($classes) {
        
        if (is_home() || is_archive()) {
            $classes[] = 'runway-masonry';
            return $classes;
        }
        
        $slug = strtolower(get_theme_mod( 'runway_color_scheme' ));
        $classes[] = 'runway-'.$slug;
        return $classes;
        
        if ( get_theme_mod( 'background-stretch' ) ) {
		$classes[] = 'full-width-bg';
                return $classes;
 	}
        
}
