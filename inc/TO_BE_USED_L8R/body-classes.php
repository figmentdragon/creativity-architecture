<?php
/**
 * Body classes.
 *
 * @package THEMENAE
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

	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_singular() ) {
		global $post;
		$classes[] = '' . $post->post_name;
	}

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'page-template-front-page';
	}

	if( is_front_page() && ! is_home() ) {
		$classes[] = 'blog';
	}

	// Adds a class of (full-width) to blogs.
	$classes[] = 'fluid-layout';

	$classes[] = 'navigation-default';

	// Adds a class with respect to layout selected.
	$layout  = get_theme_layout();
	$sidebar = get_sidebar_id();
	$sidebar_layout = sidebar_layout();

	$layout_class = "no-sidebar content-width-layout";

	if ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$layout_class = 'two-columns-layout content-left';
		}
	}

	$classes[] = $layout_class;

	$classes[] = 'excerpt';

	// Sidebar classes.
	$classes[] = 'none' === $sidebar_layout ? 'no-sidebar' : 'sidebar-' . $sidebar_layout;

	// Full width body class.
	$inner_content = inner_content( $echo = false );

	if ( ! $inner_content ) {
		$classes[] = 'full-width';
	}

	if ( get_theme_mod( 'page_boxed' ) ) {
		$classes[] = 'boxed-layout';
	}

	$classes['color-scheme'] = esc_attr( 'color-scheme-' . get_theme_mod( 'color_scheme', 'default' ) );

	$enable_slider = check_section( get_theme_mod( 'slider_option', 'disabled' ) );

	$header_image = featured_overall_image();

	if ( 'disable' !== $header_image || $enable_slider ) {
		if ( 'disable' !== $header_image ) {
			$classes[] = 'has-header-media';
		}

		$classes[] = 'absolute-header';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add a class if there is header media text.
	if ( has_header_media_text() ) {
		$classes[] = 'has-header-text';
	}

	// Add THEMENAE body class.
	$classes[] = '__THEMENAE__';

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
