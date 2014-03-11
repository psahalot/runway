<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Runway
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function runway_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'runway_jetpack_setup' );
