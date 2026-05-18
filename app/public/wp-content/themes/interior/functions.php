<?php
/**
 * Interior theme functions.
 *
 * @package Interior
 */

if ( ! defined( 'INTERIOR_VERSION' ) ) {
	define( 'INTERIOR_VERSION', '1.0.0' );
}

/**
 * Set up theme defaults and WordPress feature support.
 */
function interior_setup() {
	load_theme_textdomain( 'interior', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'interior' ),
		)
	);
}
add_action( 'after_setup_theme', 'interior_setup' );

/**
 * Register the compiled stylesheet so WordPress recognizes the theme stylesheet.
 * The source template CSS is linked in header.php to preserve the original order.
 */
function interior_scripts() {
	wp_enqueue_style( 'interior-style', get_stylesheet_uri(), array(), INTERIOR_VERSION );
}
add_action( 'wp_enqueue_scripts', 'interior_scripts' );
