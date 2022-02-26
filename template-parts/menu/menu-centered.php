<?php
/**
 * Centered menu.
 *
 * @package __THEMENAE__
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="container container-center visible-large nav-wrapper menu-centered">

	<li class="menu-item logo-container">

		<?php get_template_part( 'inc/template-parts/logo/logo' ); ?>

	</li>

	<?php do_action( 'before_main_menu' ); ?>

	<nav id="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php _e( 'Site Navigation', '__THEMENAE__' ); ?>">

		<?php do_action( 'main_menu_open' ); ?>

		<?php do_action( 'main_menu' ); ?>

		<?php do_action( 'main_menu_close' ); ?>

	</nav>

	<?php do_action( 'after_main_menu' ); ?>

</div>