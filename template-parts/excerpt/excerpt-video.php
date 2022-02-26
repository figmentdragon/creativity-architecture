<?php
/**
 * Show the appropriate content for the Video post format.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage __THEMENAE__
 * @since __THEMENAE__ 1.0
 */

$content = get_the_content();

if ( has_block( 'core/video', $content ) ) {
	__THEMENAE___print_first_instance_of_block( 'core/video', $content );
} elseif ( has_block( 'core/embed', $content ) ) {
	__THEMENAE___print_first_instance_of_block( 'core/embed', $content );
} else {
	__THEMENAE___print_first_instance_of_block( 'core-embed/*', $content );
}

// Add the excerpt.
the_excerpt();
