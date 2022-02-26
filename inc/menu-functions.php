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
 * @subpackage _THEMENAE_
 * @since _THEMENAE_ 1.0
 */

function menu_functions_and_filters() {
	add_action( 'mobile_navigation', 'mobile_menu' );
	add_action( 'navigation', 'menu' );

	add_filter( 'nav_menu_item_args', 'add_menu_description_args', 10, 3 );
	add_filter( 'nav_menu_item_title', 'sub_menu_indicators', 10, 4 );

	add_filter( 'walker_nav_menu_start_el', 'add_sub_menu_toggle', 10, 4 );
	add_filter( 'walker_nav_menu_start_el', 'mobile_sub_menu_indicators', 10, 4 );
	add_filter( 'wp_page_menu_args', 'page_menu_args' );
}
add_action( 'after_setup_theme', 'menu_functions_and_filters' );

function nav_menus() {
	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Primary Menu', '__THEMENAE__' ),
			'social'    => esc_html__( 'Social Menu', '__THEMENAE__' ),
		)
	);

	$pre_header_layout = get_theme_mod( 'pre_header_layout' );
	$footer_layout     = get_theme_mod( 'footer_layout' );

	if ( $pre_header_layout && 'none' !== $pre_header_layout ) {
		register_nav_menus(
			array(
				'pre_header_menu'       => __( 'Pre Header Left', '__THEMENAE__' ),
				'pre_header_menu_right' => __( 'Pre Header Right', '__THEMENAE__' ),
			)
		);
	}
	if ( 'none' !== $footer_layout ) {
		register_nav_menus(
			array(
				'footer_menu'       => __( 'Footer Left', '__THEMENAE__' ),
				'footer_menu_right' => __( 'Footer Right', '__THEMENAE__' ),
			)
		);
	}
}

function menu() {
 	get_template_part( 'template-parts/navigation/' . apply_filters( 'menu_variation', get_theme_mod( 'menu_position', 'menu-right' ) ) );
 }

function mobile_menu() {
 	get_template_part( 'template-parts/navigation/' . apply_filters( 'mobile_menu_variation', get_theme_mod( 'mobile_menu_options', 'menu-mobile-hamburger' ) ) );
 }

function add_sub_menu_toggle( $output, $item, $depth, $args ) {
	if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add toggle button.
		$output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="ExpandSubMenu(this)">';
		$output .= '<span class="icon-plus">' . get_icon_svg( 'ui', 'plus', 18 ) . '</span>';
		$output .= '<span class="icon-minus">' . get_icon_svg( 'ui', 'minus', 18 ) . '</span>';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Open menu', '__THEMENAE__' ) . '</span>';
		$output .= '</button>';
	}
	return $output;
}

function get_social_link_svg( $uri, $size = 24 ) {
	return SVG_Icons::get_social_link_svg( $uri, $size );
}

function add_menu_description_args( $args, $item, $depth ) {
	$args->link_after = '';
	if ( 0 === $depth && isset( $item->description ) && $item->description ) {
		// The extra <span> element is here for styling purposes: Allows the description to not be underlined on hover.
		$args->link_after = '<p class="menu-item-description"><span>' . $item->description . '</span></p>';
	}
	return $args;
}

function page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
		return $args;
	}
}

function is_off_canvas_menu() {
	if ( in_array( get_theme_mod( 'menu_position' ), array( 'menu-off-canvas', 'menu-off-canvas-left', 'menu-full-screen' ) ) ) {
		return true;
	} else {
		return false;
	}
}

function sub_menu_indicators( $title, $item, $args, $depth ) {

	// Let's stop if menu is not meant to have sub-menu's.
	if ( strpos( $args->menu_class, 'sub-menu' ) === false ) {
		return $title;
	}

	// Add arrow icon if menu item has children.
	if ( isset( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {

		if ( svg_enabled() ) {
			$title .= ' ' . svg( 'arrow-down' );
		} else {
			$title .= ' <i class="THEMENAEf THEMENAEf-arrow-down" aria-hidden="true"></i>';
		}

	}

	return $title;

}

function mobile_sub_menu_indicators( $item_output, $item, $depth, $args ) {

	if ( 'mobile_menu' === $args->theme_location || ( in_array( get_theme_mod( 'menu_position' ), array( 'menu-off-canvas', 'menu-off-canvas-left' ) ) && 'main_menu' === $args->theme_location ) ) {

		if ( isset( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {

			if ( svg_enabled() ) {

				$item_output .=
				'<button class="submenu-toggle" aria-expanded="false">
					<span class="screen-reader-text">' . __( 'Menu Toggle', '__THEMENAE__' ) . '</span>
					' . svg( 'arrow-down' ) . svg( 'arrow-up' ) . '
				</button>';

			} else {

				$item_output .= '<button class="submenu-toggle" aria-expanded="false"><span class="screen-reader-text">' . __( 'Menu Toggle', '__THEMENAE__' ) . '</span><i class="THEMENAEf THEMENAEf-arrow-down" aria-hidden="true"></i></button>';

			}

		}

	}

	return $item_output;

}

function sub_menu_alignment() {
	$sub_menu_alignment = get_theme_mod( 'sub_menu_alignment', 'left' );
	return ' sub-menu-align-' . $sub_menu_alignment;
}

function sub_menu_animation() {
	$sub_menu_animation = get_theme_mod( 'sub_menu_animation', 'fade' );
	return ' sub-menu-animation-' . $sub_menu_animation;
}

function menu_alignment() {
	$alignment = get_theme_mod( 'menu_alignment', 'left' );
	return ' menu-align-' . $alignment;
}

function menu_hover_effect() {

	$menu_effect           = get_theme_mod( 'menu_effect', 'none' );
	$menu_effect_animation = get_theme_mod( 'menu_effect_animation', 'fade' );
	$menu_effect_alignment = get_theme_mod( 'menu_effect_alignment', 'center' );

	$hover_effect  = ' menu-effect-' . $menu_effect;
	$hover_effect .= ' menu-animation-' . $menu_effect_animation;
	$hover_effect .= ' menu-align-' . $menu_effect_alignment;

	return $hover_effect;

}

function navigation_attributes() {

	$submenu_animation_duration = get_theme_mod( 'sub_menu_animation_duration' );
	$navigation_attributes      = $submenu_animation_duration ? 'data-sub-menu-animation-duration="' . esc_attr( $submenu_animation_duration ) . '"' : 'data-sub-menu-animation-duration="250"';

	echo apply_filters( 'navigation_attributes', $navigation_attributes );

}
