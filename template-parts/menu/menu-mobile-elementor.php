<?php
/**
 * Custom mobile menu.
 *
 * @package THEMENAME
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

echo '<div class="mobile-menu-custom hidden-large">';

do_action( 'mobile_menu' );

echo '</div>';
