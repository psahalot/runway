<?php
/**
 * Runway Theme Customizer
 *
 * @package Runway
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function runway_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
       
}
add_action( 'customize_register', 'runway_customize_register', 12 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function runway_customize_preview_js() {
	wp_enqueue_script( 'runway_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'runway_customize_preview_js' );


function runway_customizer( $wp_customize ) {
    $wp_customize->add_section( 'runway_footer', array(
        'title' => 'Footer', // The title of section
		'priority'    => 50,
        'description' => 'Footer Text', // The description of section
    ) );
 
  $wp_customize->add_setting( 'runway_footer_footer_text', array(
    'default' => 'Hello world',
    // Let everything else default
) );
$wp_customize->add_control( 'runway_footer_footer_text', array(
    // wptuts_welcome_text is a id of setting that this control handles
    'label' => 'Footer Text',
    // 'type' =>, // Default is "text", define the content type of setting rendering.
    'section' => 'runway_footer', // id of section to which the setting belongs
    // Let everything else default
) );

	


$wp_customize->add_section( 'runway_color_scheme_settings', array(
		'title'       => __( 'Color Scheme', 'runway' ),
		'priority'    => 30,
		'description' => 'Select your color scheme',
	) );

	$wp_customize->add_setting( 'runway_color_scheme', array(
		'default'        => 'black',
	) );

	$wp_customize->add_control( 'runway_color_scheme', array(
		'label'   => 'Choose your color scheme',
		'section' => 'runway_color_scheme_settings',
		'type'       => 'radio',
                'default'   => 'black',
		'choices'    => array(
			__( 'Blue', 'locale' ) => 'Blue',
			__( 'Red', 'locale' ) => 'Red',
			__( 'Green', 'locale' ) => 'Green',
                        __( 'Black', 'locale' ) => 'Black',
		),
	) );
	
	/** ===============
	 * Extends CONTROLS class to add textarea
	 */
	class runway_customize_textarea_control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() { ?>
	
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:98%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	
	<?php
		}
	}	

        // Displays a list of categories in dropdown
        class WP_Customize_Dropdown_Categories_Control extends WP_Customize_Control {
		public $type = 'dropdown-categories';	

			public function render_content() {
				$dropdown = wp_dropdown_categories( 
					array( 
						'name'             => '_customize-dropdown-categories-' . $this->id,
						'echo'             => 0,
						'hide_empty'       => false,
						'show_option_none' => '&mdash; ' . __('Select', 'runway') . ' &mdash;',
						'hide_if_empty'    => false,
						'selected'         => $this->value(),
					 )
				 );

				$dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

				printf( 
					'<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
					$this->label,
					$dropdown
				 );
			}
        }
        
        // Add new section for displaying Featured Posts on Front Page
        $wp_customize->add_section( 'runway_front_page_post_options', array(
        'title'       	=> __( 'Front Page Featured Posts', 'runway' ),
                'description' 	=> __( 'Settings for displaying featured posts on Front Page', 'runway' ),
                'priority'   	=> 60,
        ) );
        // enable featured posts on front page?
        $wp_customize->add_setting( 'runway_front_featured_posts_check', array( 'default' => 0 ) );
        $wp_customize->add_control( 'runway_front_featured_posts_check', array(
                'label'		=> __( 'Show featured posts on Front Page', 'runway' ),
                'section'	=> 'runway_front_page_post_options',
                'priority'	=> 10,
                'type'      => 'checkbox',
        ) );
        
        // Front featured posts section headline
        $wp_customize->add_setting( 'runway_front_featured_posts_title', array( 'default' => __( 'Latest Posts', 'runway') ) );
        $wp_customize->add_control( 'runway_front_featured_posts_title', array(
                'label'		=> __( 'Main Title', 'runway' ),
                'section'	=> 'runway_front_page_post_options',
                'settings'	=> 'runway_front_featured_posts_title',
                'priority'	=> 10,
        ) );
        
        // select number of posts for featured posts on front page
        $wp_customize->add_setting( 'runway_front_featured_posts_count', array( 'default' => 3 ) );		
        $wp_customize->add_control( 'runway_front_featured_posts_count', array(
            'label' 	=> __( 'Number of posts to display (multiple of 4)', 'runway' ),
            'section' 	=> 'runway_front_page_post_options',
                'settings' 	=> 'runway_front_featured_posts_count',
                'priority'	=> 20,
        ) );
        
        // select category for featured posts 
        $wp_customize->add_setting( 'runway_front_featured_posts_cat', array( 'default' => 0 ) );
        $wp_customize->add_control( new WP_Customize_Dropdown_Categories_Control( $wp_customize, 'runway_front_post_category', array( 
                'label'    => __('Post Category', 'runway'),
                'section'  => 'runway_front_page_post_options',
                'type'     => 'dropdown-categories',
                'settings' => 'runway_front_featured_posts_cat',
                'priority' => 20,
         ) ) );
        
        // featured post read more link
        $wp_customize->add_setting( 'runway_front_featured_link_text', array( 'default' => __( 'Read more', 'runway' ) ) );	
        $wp_customize->add_control( 'runway_front_featured_link_text', array(
            'label' 	=> __( 'Posts Read More Link Text', 'runway' ),
            'section' 	=> 'runway_front_page_post_options',
                'settings' 	=> 'runway_front_featured_link_text',
                'priority'	=> 30,
        ) );
}
add_action( 'customize_register', 'runway_customizer', 11 );


function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
    return $return;
}
	
function header_output() {
      ?>
      <!--Customizer CSS--> 
      <style type="text/css">
           <?php generate_css('.site-title h1', 'color', 'title_textcolor', ''); ?>
            <?php generate_css('.sidebarwidget a', 'color', 'link_textcolor', ''); ?>
           
      </style> 
      <!--/Customizer CSS-->
      <?php
   }
  
// Output custom CSS to live site
add_action( 'wp_head' , 'header_output');
