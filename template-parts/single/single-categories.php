<?php
/**
 * Categories.
 *
 * Renders categories on posts.
 *
 * @package __THEMENAE__
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop here if this is not a blog post.
if ( 'post' !== get_post_type() ) {
	return;
}

echo '<p class="footer-categories">';

echo '<span class="categories-title">' . apply_filters( 'categories_title', __( 'Filed under:', '__THEMENAE__' ) ) . '</span> ';

echo get_the_category_list( ', ' );

echo '</p>';
