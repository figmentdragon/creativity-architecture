<?php
/**
 * Metabox template for displaying review link.
 *
 * @package THEMENAME
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox review-metabox">
	<h2><?php _e( 'Leave us a Review', 'THEMENAME' ); ?></h2>
	<div class="heatbox-content">
		<p>
			<?php _e( 'Do you enjoy THEMENAME? Leave a review in the WordPress directory and spread the word!', 'THEMENAME' ); ?>
		</p>
		<a href="https://wordpress.org/support/theme/THEMENAME/reviews/#new-post" target="_blank" class="button">
			<?php _e( 'Leave a Review', 'THEMENAME' ); ?>
		</a>
	</div>
</div>
