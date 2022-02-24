<?php
/**
 * Extra functions for this theme.
 *
 * @package THEMENAME
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function THEMENAME_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
		return $args;
	}
}
add_filter( 'wp_page_menu_args', 'THEMENAME_page_menu_args' );

if ( ! is_admin() ) {
	/**
	 * Defines new blog excerpt length and link text.
	 *
	 * @param array $length Configuration arguments.
	 */
	function THEMENAME_new_excerpt_length( $length ) {
		return 70;
	}
	add_filter( 'excerpt_length', 'THEMENAME_new_excerpt_length' );

	add_filter( 'the_excerpt', 'THEMENAME_read_more_custom_excerpt' );
	/**
	 * Defines new blog excerpt length and link text.
	 *
	 * @param array $text Configuration arguments.
	 */
	function THEMENAME_read_more_custom_excerpt( $text ) {
		if ( strpos( $text, '[&hellip;]' ) ) {
				$excerpt = str_replace( '[&hellip;]', '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'THEMENAME' ) . '</a>', $text );
		} else {
			$excerpt = $text . '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'THEMENAME' ) . '</a>';
		}
		return $excerpt;
	}
}

/**
 * Archives Titles
 *
 * @param array $title Configuration arguments.
 */
function THEMENAME_get_the_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'THEMENAME' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'THEMENAME' ) );
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'THEMENAME' ) );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} else {
		$title = esc_html__( 'Archives', 'THEMENAME' );
	}
	return $title;
};
add_filter( 'get_the_archive_title', 'THEMENAME_get_the_archive_title', 10, 1 );

/**
 * Defines new blog excerpt length and link text.
 *
 * @param array $item_output Configuration arguments.
 * @param array $item Configuration arguments.
 * @param array $depth Configuration arguments.
 * @param array $args Configuration arguments.
 */
function THEMENAME_nav_description( $item_output, $item, $depth, $args ) {
	if ( ! empty( $item->description ) ) {
		$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'THEMENAME_nav_description', 10, 4 );

/**
 * Skip link function.
 */
function THEMENAME_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#contentwrapper">' . esc_html__( 'Skip to the content', 'THEMENAME' ) . '</a>';
}
add_action( 'wp_body_open', 'THEMENAME_skip_link', 5 );

add_action( 'admin_head', 'THEMENAME_admin_style' );

function THEMENAME_admin_style() {
	echo '<style>
	.notice {position: relative;}
	a.notice-dismiss {text-decoration:none;}
	</style>';
}
