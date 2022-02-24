<?php
/**
 * Theme BFCM notice template.
 *
 * @package THEMENAME
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$bfcm_url = 'https://wp-pagebuilderframework.com/pricing/?utm_source=repository&utm_medium=bfcm_banner&utm_campaign=themename';
?>

<div class="notice notice-info bfcm-notice is-dismissible">
	<div class="notice-body">
		<div class="notice-icon">
			<img src="<?php echo esc_url( THEME_URI ); ?>/img/THEMENAME-logo-blue.png" alt="THEMENAME Logo">
		</div>
		<div class="notice-content">
			<h2>
				<?php _e( 'Huge Black Friday Sale - Up to 30% Off!*', 'THEMENAME' ); ?>
			</h2>
			<p>
				<?php _e( 'Upgrade to the <strong>Premium Add-On</strong> for THEMENAME, today!', 'THEMENAME' ); ?>
			</p>
			<p>
				<?php _e( 'Hurry up! The deal will expire soon!', 'THEMENAME' ); ?><br>
				<em><?php _e( 'All prices are reduced. No coupon code required.', 'THEMENAME' ); ?></em>
			</p>
			<p>
				<a href="<?php echo esc_url( $bfcm_url ); ?>" class="button button-primary">
					<?php _e( 'Get the Deal', 'THEMENAME' ); ?>
				</a>
				<small><?php _e( '*Only Administrators will see this message!', 'THEMENAME' ); ?></small>
			</p>
		</div>
	</div>
</div>
