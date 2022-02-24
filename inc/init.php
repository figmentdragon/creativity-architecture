<?php
/**
 * Init.
 *
 * @package THEMENAME
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Check if Premium Add-On exists.
 *
 * @return bool True or false.
 */
function is_premium() {
	return function_exists( 'premium' ) ? true : false;
}

require THEME_DIR . '/inc/classes/class-svg-icons.php';

require THEME_DIR . '/inc/theme-functions.php';

// Backwards compatibility.
require_once THEME_DIR . '/inc/backwards-compatibility.php';

// Options.
require_once THEME_DIR . '/inc/options.php';

// Quick edit.
require_once THEME_DIR . '/inc/quick-edit.php';

// Customizer settings.
require_once THEME_DIR . '/inc/customizer/customizer-settings.php';

// Body classes.
require_once THEME_DIR . '/inc/body-classes.php';

// Breadcrumbs.
if ( ! function_exists( 'breadcrumb_trail' ) ) {
	require_once THEME_DIR . '/inc/breadcrumbs.php';
}

// Helpers.
require_once THEME_DIR . '/inc/class-vars.php';
require_once THEME_DIR . '/inc/helpers.php';

// Local Gravatars.
require_once THEME_DIR . '/inc/gravatar.php';

// Misc.
require_once THEME_DIR . '/inc/misc.php';

// Customizer functions.
require_once THEME_DIR . '/inc/customizer/customizer-functions.php';

// Theme mods.
require_once THEME_DIR . '/inc/theme-mods.php';

// Theme settings.
require_once THEME_DIR . '/inc/theme-settings.php';

/* Integration */

// Gutenberg integration.
require_once THEME_DIR . '/inc/integration/gutenberg/gutenberg.php';

// Header/Footer Elementor integration.
if ( ! function_exists( 'header_footer_elementor_support' ) ) {
	// Backwards compatibility check as this was included in the Premium Add-On earlier.
	require_once THEME_DIR . '/inc/integration/header-footer-elementor.php';
}

/**
 * Elementor Pro integration.
 *
 * @since 2.1
 */
function do_elementor_pro_integration() {

	// Backwards compatibility check as this was included in the Premium Add-On earlier.
	if ( function_exists( 'elementor_pro_integration' ) ) {
		return;
	}

	require_once THEME_DIR . '/inc/integration/elementor-pro.php';

}
add_action( 'elementor_pro/init', 'do_elementor_pro_integration' );

// Beaver Builder integration.
if ( class_exists( 'FLBuilderLoader' ) ) {
	require_once THEME_DIR . '/inc/integration/beaver-builder.php';
}

// Beaver Themer integration.
// Backwards compatibility check as this was included in the Premium Add-On earlier.
if ( ! function_exists( 'bb_header_footer_support' ) && class_exists( 'FLThemeBuilderLoader' ) && class_exists( 'FLBuilderLoader' ) ) {
	require_once THEME_DIR . '/inc/integration/beaver-themer.php';
}

// Divi integration.
// if ( class_exists( 'ET_Builder_Plugin' ) ) {
// 	require_once THEME_DIR . '/inc/integration/divi.php';
// }

// Easy Digital Downloads integration.
if ( class_exists( 'Easy_Digital_Downloads' ) ) {
	require_once THEME_DIR . '/inc/integration/edd/edd.php';
}

// WooCommerce integration.
if ( class_exists( 'WooCommerce' ) ) {
	require_once THEME_DIR . '/inc/integration/woocommerce/woocommerce.php';
}

// LifterLMS integration.
if ( class_exists( 'LifterLMS' ) ) {
	require_once THEME_DIR . '/inc/integration/lifterlms/lifterlms.php';
}

/**
 * Render pre header.
 */
function do_pre_header() {
	get_template_part( 'template-parts/header/pre-header' );
}
add_action( 'pre_header', 'do_pre_header' );

/**
 * Render header.
 */
function do_header() {
	get_template_part( 'template-parts/header' );
}
add_action( 'header', 'do_header' );

/**
 * Render footer.
 */
function do_footer() {
	get_template_part( 'template-parts/footer' );
}
add_action( 'footer', 'do_footer' );

/**
 * Render 404 page.
 */
function do_404() {
	get_template_part( 'template-parts/404' );
}
add_action( '404', 'do_404' );
