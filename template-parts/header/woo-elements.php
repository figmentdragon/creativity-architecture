<?php
/**
 * Add WooCommerce Elements in header
 *
 * @package __THEMENAE__
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

if ( get_theme_mod( '__THEMENAE___header_cart_enable', 0 ) && function_exists( '__THEMENAE___header_cart' ) ) {
	__THEMENAE___header_cart();
}
