<?php
/**
 * Theme activation notice template.
 *
 * @package THEMENAME
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$screen = get_current_screen();
?>

<div class="notice notice-info activation-notice is-dismissible">
	<div class="notice-body">
		<div class="notice-icon">
			<img src="<?php echo esc_url( THEME_URI ); ?>/img/THEMENAME-logo-blue.png" alt="THEMENAME Logo">
		</div>
		<div class="notice-content">
			<h2>
				<?php _e( 'Welcome to THEMENAME!', 'THEMENAME' ); ?>
			</h2>
			<p>
				<?php _e( 'Thank you for choosing THEMENAME! Please visit the theme settings page to get started.', 'THEMENAME' ); ?>
			</p>
			<?php if ( 'appearance_page_premium' !== $screen->id ) { ?> 
			<p>
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=premium' ) ); ?>" class="button button-primary">
					<?php _e( 'Get Started', 'THEMENAME' ); ?>
				</a>
			</p>
			<?php } ?>
		</div>
	</div>
</div>
