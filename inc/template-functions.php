<?php
/**
 * Functions for page templates.
 *
 * @package __THEMENAE__
 */


if ( ! is_admin() ) {
	/**
	 * Defines new blog excerpt length and link text.
	 *
	 * @param array $length Configuration arguments.
	 */
	 function new_excerpt_length( $length ) {
		 return 70;
	 }
	 add_filter( 'excerpt_length', 'new_excerpt_length' );
	 add_filter( 'the_excerpt', 'read_more_custom_excerpt' );
	/**
	 * Defines new blog excerpt length and link text.
	 *
	 * @param array $text Configuration arguments.
	 */
	function read_more_custom_excerpt( $text ) {
		if ( strpos( $text, '[&hellip;]' ) ) {
				$excerpt = str_replace( '[&hellip;]', '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', '__THEMENAE__' ) . '</a>', $text );
		} else {
			$excerpt = $text . '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', '__THEMENAE__' ) . '</a>';
		}
		return $excerpt;
	}
}

/**
 * Defines new blog excerpt length and link text.
 *
 * @param array $item_output Configuration arguments.
 * @param array $item Configuration arguments.
 * @param array $depth Configuration arguments.
 * @param array $args Configuration arguments.
 */
function nav_description( $item_output, $item, $depth, $args ) {
	if ( ! empty( $item->description ) ) {
		$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'nav_description', 10, 4 );
