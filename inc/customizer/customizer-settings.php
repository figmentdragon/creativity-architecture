<?php
/**
 * Theme customizer settings.
 *
 * @package THEMENAME
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Load textdomain. This is required to make strings translatable.
load_theme_textdomain( 'THEMENAME' );

// Load customizer helpers & setup.
require_once THEME_DIR . '/inc/customizer/settings/settings-helpers.php';
require_once THEME_DIR . '/inc/customizer/settings/settings-setup.php';

// Load customizer settings.
require_once THEME_DIR . '/inc/customizer/settings/settings-premium.php';
