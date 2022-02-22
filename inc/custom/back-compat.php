<?php

/**
 * Prevent switching to MYTHEME on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 */
function MYTHEME_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'MYTHEME_upgrade_notice' );
}
add_action( 'after_switch_theme', 'MYTHEME_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * MYTHEME on WordPress versions prior to 4.5.
 *
 * @global string $wp_version WordPress version.
 */
function MYTHEME_upgrade_notice() {
	$message = sprintf( __( 'MYTHEME requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'MYTHEME' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.5.
 
 * @global string $wp_version WordPress version.
 */
function MYTHEME_customize() {
	wp_die( sprintf( __( 'MYTHEME requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'MYTHEME' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'MYTHEME_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.5.
 
 * @global string $wp_version WordPress version.
 */
function MYTHEME_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'MYTHEME requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'MYTHEME' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'MYTHEME_preview' );
?>
