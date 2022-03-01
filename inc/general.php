<?php
/**
 * General functions.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'scripts' );
	/**
	 * Enqueue scripts and styles
	 */
	function scripts() {
		$settings = wp_parse_args(
			get_option( 'settings', array() ),
			get_defaults()
		);

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$dir_uri = get_template_directory_uri();

		wp_enqueue_style( '__THEMENAE-style-grid', $dir_uri . "/css/unsemantic-grid{$suffix}.css", false, VERSION, 'all' );
		wp_enqueue_style( '__THEMENAE-style', $dir_uri . "/style{$suffix}.css", array( '__THEMENAE-style-grid' ), VERSION, 'all' );
		wp_enqueue_style( '__THEMENAE-mobile-style', $dir_uri . "/css/mobile{$suffix}.css", array( '__THEMENAE-style' ), VERSION, 'all' );

		if ( is_child_theme() ) {
			wp_enqueue_style( '__THEMENAE-child', get_stylesheet_uri(), array( '__THEMENAE-style' ), filemtime( get_stylesheet_directory() . '/style.css' ), 'all' );
		}

		wp_enqueue_style( 'font-awesome', $dir_uri . "/css/font-awesome{$suffix}.css", false, '5.1', 'all' );

		if ( function_exists( 'wp_script_add_data' ) ) {
			wp_enqueue_script( '__THEMENAE-classlist', $dir_uri . "/js/classList{$suffix}.js", array(), VERSION, true );
			wp_script_add_data( '__THEMENAE-classlist', 'conditional', 'lte IE 11' );
		}

		wp_enqueue_script( '__THEMENAE-menu', $dir_uri . "/js/menu{$suffix}.js", array( 'jquery'), VERSION, true );
		wp_enqueue_script( '__THEMENAE-a11y', $dir_uri . "/js/a11y{$suffix}.js", array(), VERSION, true );
		wp_enqueue_script( '__THEMENAE-menu-control', $dir_uri . "/js/menu-control.js", array( 'jquery'), VERSION, true );

		if ( 'click' == $settings[ 'nav_dropdown_type' ] || 'click-arrow' == $settings[ 'nav_dropdown_type' ] ) {
			wp_enqueue_script( '__THEMENAE-dropdown-click', $dir_uri . "/js/dropdown-click{$suffix}.js", array( '__THEMENAE-menu' ), VERSION, true );
		}

		if ( 'enable' == $settings['nav_search'] ) {
			wp_enqueue_script( '__THEMENAE-navigation-search', $dir_uri . "/js/navigation-search{$suffix}.js", array( '__THEMENAE-menu' ), VERSION, true );
		}

		if ( 'enable' == $settings['back_to_top'] ) {
			wp_enqueue_script( '__THEMENAE-back-to-top', $dir_uri . "/js/back-to-top{$suffix}.js", array(), VERSION, true );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

if ( ! function_exists( 'widgets_init' ) ) {
	add_action( 'widgets_init', 'widgets_init' );
	/**
	 * Register widgetized area and update sidebar with default widgets
	 */
	function widgets_init() {
		$widgets = array(
			'sidebar-1' => __( 'Right Sidebar', '__THEMENAE__' ),
			'sidebar-2' => __( 'Left Sidebar', '__THEMENAE__' ),
			'header' => __( 'Header', '__THEMENAE__' ),
			'footer-1' => __( 'Footer Widget 1', '__THEMENAE__' ),
			'footer-2' => __( 'Footer Widget 2', '__THEMENAE__' ),
			'footer-3' => __( 'Footer Widget 3', '__THEMENAE__' ),
			'footer-4' => __( 'Footer Widget 4', '__THEMENAE__' ),
			'footer-5' => __( 'Footer Widget 5', '__THEMENAE__' ),
			'footer-bar' => __( 'Footer Bar','__THEMENAE__' ),
			'top-bar' => __( 'Top Bar','__THEMENAE__' ),
		);

		foreach ( $widgets as $id => $name ) {
			register_sidebar( array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => apply_filters( 'start_widget_title', '<h2 class="widget-title">' ),
				'after_title'   => apply_filters( 'end_widget_title', '</h2>' ),
			) );
		}
	}
}

if ( ! function_exists( 'smart_content_width' ) ) {
	add_action( 'wp', 'smart_content_width' );
	/**
	 * Set the $content_width depending on layout of current page
	 * Hook into "wp" so we have the correct layout setting from get_layout()
	 * Hooking into "after_setup_theme" doesn't get the correct layout setting
	 */
	function smart_content_width() {
		global $content_width;

		$container_width = get_setting( 'container_width' );
		$right_sidebar_width = apply_filters( 'right_sidebar_width', '25' );
		$left_sidebar_width = apply_filters( 'left_sidebar_width', '25' );
		$layout = get_layout();

		if ( 'left-sidebar' == $layout ) {
			$content_width = $container_width * ( ( 100 - $left_sidebar_width ) / 100 );
		} elseif ( 'right-sidebar' == $layout ) {
			$content_width = $container_width * ( ( 100 - $right_sidebar_width ) / 100 );
		} elseif ( 'no-sidebar' == $layout ) {
			$content_width = $container_width;
		} else {
			$content_width = $container_width * ( ( 100 - ( $left_sidebar_width + $right_sidebar_width ) ) / 100 );
		}
	}
}

if ( ! function_exists( 'disable_title' ) ) {
	add_filter( 'show_title', 'disable_title' );
	/**
	 * Remove our title if set.
	 *
	 *
	 * @return bool Whether to display the content title.
	 */
	function disable_title() {
		global $post;

		$disable_headline = ( isset( $post ) ) ? get_post_meta( $post->ID, '___THEMENAE-disable-headline', true ) : '';

		if ( ! empty( $disable_headline ) && false !== $disable_headline ) {
			return false;
		}

		return true;
	}
}

if ( ! function_exists( 'resource_hints' ) ) {
	add_filter( 'wp_resource_hints', 'resource_hints', 10, 2 );
	/**
	 * Add resource hints to our Google fonts call.
	 *
	 *
	 * @param array  $urls           URLs to print for resource hints.
	 * @param string $relation_type  The relation type the URLs are printed.
	 * @return array $urls           URLs to print for resource hints.
	 */
	function resource_hints( $urls, $relation_type ) {
		if ( wp_style_is( '__THEMENAE-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
			if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
				$urls[] = array(
					'href' => 'https://fonts.gstatic.com',
					'crossorigin',
				);
			} else {
				$urls[] = 'https://fonts.gstatic.com';
			}
		}
		return $urls;
	}
}

if ( ! function_exists( 'remove_caption_padding' ) ) {
	add_filter( 'img_caption_shortcode_width', 'remove_caption_padding' );
	/**
	 * Remove WordPress's default padding on images with captions
	 *
	 * @param int $width Default WP .wp-caption width (image width + 10px)
	 * @return int Updated width to remove 10px padding
	 */
	function remove_caption_padding( $width ) {
		return $width - 10;
	}
}

if ( ! function_exists( 'enhanced_image_navigation' ) ) {
	add_filter( 'attachment_link', 'enhanced_image_navigation', 10, 2 );
	/**
	 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
	 */
	function enhanced_image_navigation( $url, $id ) {
		if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
			return $url;
		}

		$image = get_post( $id );
		if ( ! empty( $image->post_parent ) && $image->post_parent != $id ) {
			$url .= '#main';
		}

		return $url;
	}
}

if ( ! function_exists( 'categorized_blog' ) ) {
	/**
	 * Determine whether blog/site has more than one category.
	 *
	 *
	 * @return bool True of there is more than one category, false otherwise.
	 */
	function categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so twentyfifteen_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so twentyfifteen_categorized_blog should return false.
			return false;
		}
	}
}

if ( ! function_exists( 'category_transient_flusher' ) ) {
	add_action( 'edit_category', 'category_transient_flusher' );
	add_action( 'save_post',     'category_transient_flusher' );
	/**
	 * Flush out the transients used in {@see categorized_blog()}.
	 *
	 */
	function category_transient_flusher() {
		// Like, beat it. Dig?
		delete_transient( 'categories' );
	}
}

add_filter( 'fontawesome_essentials', 'set_font_awesome_essentials' );
/**
 * Check to see if we should include the full Font Awesome library or not.
 *
 *
 * @param bool $essentials
 * @return bool
 */
function set_font_awesome_essentials( $essentials ) {
	if ( get_setting( 'font_awesome_essentials' ) ) {
		return true;
	}

	return $essentials;
}
