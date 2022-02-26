<?php
/**
 * Metabox template for displaying customizer settings.
 *
 * @package _THEMENAE_
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Output customizer links.
 */
function do_customizer_links() {

	$customizer_links = array(
		array(
			'text' => __( 'Logo', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=title_tagline' ),
		),
		array(
			'text' => __( 'Site Navigation', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=menu_options' ),
		),
		array(
			'text' => __( 'Header', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=header_panel' ),
		),
		array(
			'text' => __( 'Footer', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=footer_options' ),
		),
		array(
			'text' => __( 'Layout', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=page_options' ),
		),
		array(
			'text' => __( 'Sidebar', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=sidebar_options' ),
		),
		array(
			'text' => __( 'Blog', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=blog_panel' ),
		),
		array(
			'text' => __( 'Post Layout', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=single_options' ),
		),
		array(
			'text' => __( 'Typography', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=typo_panel' ),
		),
		array(
			'text' => __( 'Theme Buttons', '__THEMENAE__' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=button_options' ),
		),
	);

	foreach ( $customizer_links as $link_item ) {

		?>

		<li>
			<a href="<?php echo esc_url( $link_item['url'] ); ?>">
				<?php echo esc_html( $link_item['text'] ); ?>
			</a>
		</li>

		<?php

	}

}
add_action( 'customizer_links', 'do_customizer_links' );

?>

<div class="heatbox customizer-metabox">

	<h2>
		<?php _e( 'Customizer Settings', '__THEMENAE__' ); ?>
	</h2>

	<ul class="customizer-list">

		<?php
		do_action( 'before_customizer_links' );
		do_action( 'customizer_links' );
		do_action( 'after_customizer_links' );
		?>

		<li>
			<h3>
				<?php _e( 'Launch WordPress Customizer', '__THEMENAE__' ); ?>
			</h3>
			<p>
				<?php _e( 'Explore all of the _THEMENAE_ features.', '__THEMENAE__' ); ?>
			</p>
			<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class="button button-larger button-primary"><?php _e( 'Customize', '__THEMENAE__' ); ?></a>
		</li>

	</ul>

</div>
