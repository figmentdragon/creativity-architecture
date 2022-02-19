<?php
/**
 * Add WooCommerce Elements in header
 *
 * @package MYTHEME
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

if ( get_theme_mod( 'MYTHEME_header_cart_enable', 0 ) && function_exists( 'MYTHEME_header_cart' ) ) {
	MYTHEME_header_cart();
}
