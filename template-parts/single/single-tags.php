<?php
/**
 * Tags.
 *
 * Renders tags on posts.
 *
 * @package __THEMENAE__
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop here if this is not a blog post.
if ( 'post' !== get_post_type() ) {
	return;
}

the_tags( '<p class="footer-tags"><span class="tags-title">' . apply_filters( 'tags_title', __( 'Tags:', '__THEMENAE__' ) ) . '</span> ', ', ', '</p>' );
