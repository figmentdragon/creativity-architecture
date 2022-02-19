<?php
/**
 * Functions and filters related to the menus.
 *
 * Makes the default WordPress navigation use an HTML structure similar
 * to the Navigation block.
 *
 * @link https://make.wordpress.org/themes/2020/07/06/printing-navigation-block-html-from-a-legacy-menu-in-themes/
 *
 * @package WordPress
 * @subpackage MYTHEME
 * @since MYTHEME 1.0
 */

function MYTHEME_menu() {
	add_filter( 'nav_menu_item_args', 'MYTHEME_add_menu_description_args', 10, 3 );
	add_filter( 'walker_nav_menu_start_el', 'MYTHEME_add_sub_menu_toggle', 10, 4 );
}
add_action( 'after_setup_theme', 'MYTHEME_menu' );

function MYTHEME_add_sub_menu_toggle( $output, $item, $depth, $args ) {
	if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add toggle button.
		$output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="MYTHEMEExpandSubMenu(this)">';
		$output .= '<span class="icon-plus">' . MYTHEME_get_icon_svg( 'ui', 'plus', 18 ) . '</span>';
		$output .= '<span class="icon-minus">' . MYTHEME_get_icon_svg( 'ui', 'minus', 18 ) . '</span>';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Open menu', 'MYTHEME' ) . '</span>';
		$output .= '</button>';
	}
	return $output;
}

function MYTHEME_get_social_link_svg( $uri, $size = 24 ) {
	return MYTHEME_SVG_Icons::get_social_link_svg( $uri, $size );
}

function MYTHEME_add_menu_description_args( $args, $item, $depth ) {
	$args->link_after = '';
	if ( 0 === $depth && isset( $item->description ) && $item->description ) {
		// The extra <span> element is here for styling purposes: Allows the description to not be underlined on hover.
		$args->link_after = '<p class="menu-item-description"><span>' . $item->description . '</span></p>';
	}
	return $args;
}
