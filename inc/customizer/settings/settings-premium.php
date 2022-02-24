<?php
/**
 * Premium customizer settings.
 *
 * @package THEMENAME
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop if Premium Add-On is installed.
if ( is_premium() ) {
	return;
}

$premium_ad_link = sprintf(
	__( 'Get all features with the <a href="%1s" target="_blank">Premium Add-On</a>!', 'THEMENAME' ),
	esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer&utm_campaign=themename#premium' )
);
