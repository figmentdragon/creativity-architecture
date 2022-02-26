<?php
/**
 * Metabox template for displaying additional resources.
 *
 * @package _THEMENAE_
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox resources-metabox">
	<h2>
		<?php _e( 'Additional Resources', '__THEMENAE__' ); ?>
	</h2>
	<div class="heatbox-content">
		<ul>
			<li>
				<a href="https://wp-pagebuilderframework.com/?utm_source=repository&utm_medium=theme_settings&utm_campaign=themename" target="_blank">
					<span class="dashicons dashicons-admin-site-alt"></span>
					<?php _e( '_THEMENAE_ Website', '__THEMENAE__' ); ?>
				</a>
			</li>
			<li>
				<a href="https://wp-pagebuilderframework.com/child-theme-generator/?utm_source=repository&utm_medium=theme_settings&utm_campaign=_THEMENAE_" target="_blank">
					<span class="dashicons dashicons-download"></span>
					<?php _e( 'Child Theme', '__THEMENAE__' ); ?>
				</a>
			</li>
			<li>
				<a href="https://wordpress.org/support/theme/_THEMENAE_/" target="_blank">
					<span class="dashicons dashicons-sos"></span>
					<?php _e( 'Support Forum', '__THEMENAE__' ); ?>
				</a>
			</li>
		</ul>
	</div>
</div>
