<?php
/**
 * Metabox template for displaying additional resources.
 *
 * @package THEMENAME
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox resources-metabox">
	<h2>
		<?php _e( 'Additional Resources', 'THEMENAME' ); ?>
	</h2>
	<div class="heatbox-content">
		<ul>
			<li>
				<a href="https://wp-pagebuilderframework.com/?utm_source=repository&utm_medium=theme_settings&utm_campaign=themename" target="_blank">
					<span class="dashicons dashicons-admin-site-alt"></span>
					<?php _e( 'THEMENAME Website', 'THEMENAME' ); ?>
				</a>
			</li>
			<li>
				<a href="https://wp-pagebuilderframework.com/child-theme-generator/?utm_source=repository&utm_medium=theme_settings&utm_campaign=themename" target="_blank">
					<span class="dashicons dashicons-download"></span>
					<?php _e( 'Child Theme', 'THEMENAME' ); ?>
				</a>
			</li>
			<li>
				<a href="https://wordpress.org/support/theme/THEMENAME/" target="_blank">
					<span class="dashicons dashicons-sos"></span>
					<?php _e( 'Support Forum', 'THEMENAME' ); ?>
				</a>
			</li>
		</ul>
	</div>
</div>
