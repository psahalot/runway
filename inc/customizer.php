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
