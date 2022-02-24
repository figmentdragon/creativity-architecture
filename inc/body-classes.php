<?php
/**
 * Body classes.
 *
 * @package THEMENAME
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Body classes.
 *
 * @param array $classes The body classes.
 *
 * @return array The updated body classes.
 */
function body_classes( $classes ) {

	// Add themename body class.
	$classes[] = 'themename';

	if ( get_theme_mod( 'page_boxed' ) ) {
		$classes[] = 'boxed-layout';
	}


	// Add {post-name} body class on singular.
	if ( is_singular() ) {
		global $post;
		$classes[] = '' . $post->post_name;
	}

	// Sidebar classes.
	$sidebar_layout = sidebar_layout();

	$classes[] = 'none' === $sidebar_layout ? 'no-sidebar' : 'sidebar-' . $sidebar_layout;

	// Full width body class.
	$inner_content = inner_content( $echo = false );

	if ( ! $inner_content ) {
		$classes[] = 'full-width';
	}

	// WooCommerce list layout.
	if ( 'list' === get_theme_mod( 'woocommerce_loop_layout' ) ) {
		$classes[] = 'woo-list-view';
	}

	return $classes;

}
add_filter( 'body_class', 'body_classes' );

/**
 * Post classes.
 *
 * @param array $classes The post classes.
 *
 * @return array The updated post classes.
 */
function post_classes( $classes ) {

	// Add post class to all posts.
	$classes[] = 'post';

	return $classes;

}
add_filter( 'post_class', 'post_classes' );
