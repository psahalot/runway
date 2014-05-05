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
    // Add footer text section
    $wp_customize->add_section('runway_footer', array(
        'title' => 'Footer Text', // The title of section
        'priority' => 75,
    ));

    $wp_customize->add_setting('runway_footer_footer_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'sanitize_js_callback' => 'runway_sanitize_escaping',
    ));
    
    $wp_customize->add_control(new runway_customize_textarea_control($wp_customize, 'runway_footer_footer_text', array(
        'section' => 'runway_footer', // id of section to which the setting belongs
        'settings' => 'runway_footer_footer_text',
    )));
	


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
                        __( 'Orange', 'locale' ) => 'Orange',
		),
	) );
       
        
        // Add custom CSS section 
    $wp_customize->add_section(
        'runway_custom_css_section', array(
        'title' => __('Custom CSS', 'smartshop'),
        'priority' => 80,
    ));

    $wp_customize->add_setting(
        'runway_custom_css', array(
        'default' => '',
        'sanitize_callback' => 'runway_sanitize_custom_css',
        'sanitize_js_callback' => 'runway_sanitize_escaping',
    ));

    $wp_customize->add_control(
        new runway_customize_textarea_control(
        $wp_customize, 'runway_custom_css', array(
        'label' => __('Add your custom css here and design live! (for advanced users)', 'smartshop'),
        'section' => 'runway_custom_css_section',
        'settings' => 'runway_custom_css'
    )));
    
    // Add full screen background option
   $wp_customize->add_setting( 'background-stretch', array(
    	'default' 	=> 10,
    ) );
    // This will be hooked into the default background_image section
    $wp_customize->add_control( 'background-stretch', array(
		'label'    => __( 'Full screen background', 'runway' ),
		'section'  => 'background_image',
		'type'     => 'checkbox',
		'priority' => 10
        ));
}

add_action( 'customize_register', 'runway_customizer', 11 );


/* 
 * Sanitize Custom CSS 
 * 
 * @since Runway 1.4
 */

function runway_sanitize_custom_css( $input) {
    $input = wp_kses_stripslashes( $input);
    return $input;
}

/*
 * Escaping for input values
 * 
 * @since Runway 1.4
 */
function runway_sanitize_escaping( $input) {
    $input = esc_attr( $input);
    return $input;
}

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

