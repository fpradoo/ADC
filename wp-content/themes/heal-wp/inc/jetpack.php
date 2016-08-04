<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package heal-wp
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function heal_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'heal_jetpack_setup' );
