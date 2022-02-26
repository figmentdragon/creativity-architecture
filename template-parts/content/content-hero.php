<?php
/**
 * The template used for displaying hero content
 *
 * @package __THEMENAE__
 */

$enable_section = get_theme_mod( '__THEMENAE___hero_content_visibility', 'disabled' );

if ( ! __THEMENAE___check_section( $enable_section ) ) {
	// Bail if hero content is not enabled
	return;
}

get_template_part( 'template-parts/hero-content/post-type-hero' );

