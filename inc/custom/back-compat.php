<?php

/**
 * Prevent switching to THEMENAME on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 */
function THEMENAME_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'THEMENAME_upgrade_notice' );
}
add_action( 'after_switch_theme', 'THEMENAME_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * THEMENAME on WordPress versions prior to 4.5.
 *
 * @global string $wp_version WordPress version.
 */
function THEMENAME_upgrade_notice() {
	$message = sprintf( __( 'THEMENAME requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'THEMENAME' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.5.
 
 * @global string $wp_version WordPress version.
 */
function THEMENAME_customize() {
	wp_die( sprintf( __( 'THEMENAME requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'THEMENAME' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'THEMENAME_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.5.
 
 * @global string $wp_version WordPress version.
 */
function THEMENAME_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'THEMENAME requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'THEMENAME' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'THEMENAME_preview' );
?>
