<?php
/**
 * Footer elements.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'TheCreativityArchitectconstruct_footer' ) ) {
	add_action( 'TheCreativityArchitectfooter', 'TheCreativityArchitectconstruct_footer' );
	/**
	 * Build our footer.
	 *
	 */
	function TheCreativityArchitectconstruct_footer() {
		?>
		<footer class="site-info" itemtype="https://schema.org/WPFooter" itemscope="itemscope">
			<div class="inside-site-info <?php if ( 'full-width' !== TheCreativityArchitectget_setting( 'footer_inner_width' ) ) : ?>grid-container grid-parent<?php endif; ?>">
				<?php
				/**
				 * TheCreativityArchitectbefore_copyright hook.
				 *
				 *
				 * @hooked TheCreativityArchitectfooter_bar - 15
				 */
				do_action( 'TheCreativityArchitectbefore_copyright' );
				?>
				<div class="copyright-bar">
					<?php
					/**
					 * TheCreativityArchitectcredits hook.
					 *
					 *
					 * @hooked TheCreativityArchitectadd_footer_info - 10
					 */
					do_action( 'TheCreativityArchitectcredits' );
					?>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'TheCreativityArchitectfooter_bar' ) ) {
	add_action( 'TheCreativityArchitectbefore_copyright', 'TheCreativityArchitectfooter_bar', 15 );
	/**
	 * Build our footer bar
	 *
	 */
	function TheCreativityArchitectfooter_bar() {
		if ( ! is_active_sidebar( 'footer-bar' ) ) {
			return;
		}
		?>
		<div class="footer-bar">
			<?php dynamic_sidebar( 'footer-bar' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'TheCreativityArchitectadd_footer_info' ) ) {
	add_action( 'TheCreativityArchitectcredits', 'TheCreativityArchitectadd_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 */
	function TheCreativityArchitectadd_footer_info() {
		echo '<span class="copyright">&copy; ' . esc_html( date( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) ) . '</span> &bull; ' . esc_html__( 'Powered by', 'TheCreativityArchitect' ) . ' <a href="' . esc_url( TheCreativityArchitecttheme_uri_link() ) . '" itemprop="url">' . esc_html__( 'WPKoi', 'TheCreativityArchitect' ) . '</a>';
	}
}

/**
 * Build our individual footer widgets.
 * Displays a sample widget if no widget is found in the area.
 *
 *
 * @param int $widget_width The width class of our widget.
 * @param int $widget The ID of our widget.
 */
function TheCreativityArchitectdo_footer_widget( $widget_width, $widget ) {
	$widget_width = apply_filters( "TheCreativityArchitectfooter_widget_{$widget}_width", $widget_width );
	$tablet_widget_width = apply_filters( "TheCreativityArchitectfooter_widget_{$widget}_tablet_width", '50' );
	?>
	<div class="footer-widget-<?php echo absint( $widget ); ?> grid-parent grid-<?php echo absint( $widget_width ); ?> tablet-grid-<?php echo absint( $tablet_widget_width ); ?> mobile-grid-100">
		<?php if ( ! dynamic_sidebar( 'footer-' . absint( $widget ) ) ) :
	        $current_user = wp_get_current_user();
	        if (user_can( $current_user, 'administrator' )) { ?>
			<aside class="widget inner-padding widget_text">
				<h4 class="widget-title"><?php esc_html_e( 'Footer Widget', 'TheCreativityArchitect' );?></h4>
				<div class="textwidget">
					<p>
						<?php esc_html_e( 'Replace this widget content by going to ', 'TheCreativityArchitect' ); ?><a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><strong><?php esc_html_e('Appearance / Widgets', 'TheCreativityArchitect' ); ?></strong></a><?php esc_html_e( ' and dragging widgets into this widget area.', 'TheCreativityArchitect' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'To remove or choose the number of footer widgets, go to ', 'TheCreativityArchitect' ); ?><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><strong><?php esc_html_e('Appearance / Customize / Layout / Footer Widgets', 'TheCreativityArchitect' ); ?></strong></a><?php esc_html_e( '.', 'TheCreativityArchitect' ); ?>
					</p>
				</div>
			</aside>
		<?php } endif; ?>
	</div>
	<?php
}

if ( ! function_exists( 'TheCreativityArchitectconstruct_footer_widgets' ) ) {
	add_action( 'TheCreativityArchitectfooter', 'TheCreativityArchitectconstruct_footer_widgets', 5 );
	/**
	 * Build our footer widgets.
	 *
	 */
	function TheCreativityArchitectconstruct_footer_widgets() {
		// Get how many widgets to show.
		$widgets = TheCreativityArchitectget_footer_widgets();

		if ( ! empty( $widgets ) && 0 !== $widgets ) :

			// Set up the widget width.
			$widget_width = '';
			if ( $widgets == 1 ) {
				$widget_width = '100';
			}

			if ( $widgets == 2 ) {
				$widget_width = '50';
			}

			if ( $widgets == 3 ) {
				$widget_width = '33';
			}

			if ( $widgets == 4 ) {
				$widget_width = '25';
			}

			if ( $widgets == 5 ) {
				$widget_width = '20';
			}
			?>
			<div id="footer-widgets" class="site footer-widgets">
				<div <?php TheCreativityArchitectinside_footer_class(); ?>>
					<div class="inside-footer-widgets">
						<?php
						if ( $widgets >= 1 ) {
							TheCreativityArchitectdo_footer_widget( $widget_width, 1 );
						}

						if ( $widgets >= 2 ) {
							TheCreativityArchitectdo_footer_widget( $widget_width, 2 );
						}

						if ( $widgets >= 3 ) {
							TheCreativityArchitectdo_footer_widget( $widget_width, 3 );
						}

						if ( $widgets >= 4 ) {
							TheCreativityArchitectdo_footer_widget( $widget_width, 4 );
						}

						if ( $widgets >= 5 ) {
							TheCreativityArchitectdo_footer_widget( $widget_width, 5 );
						}
						?>
					</div>
				</div>
			</div>
		<?php
		endif;

		/**
		 * TheCreativityArchitectafter_footer_widgets hook.
		 *
		 */
		do_action( 'TheCreativityArchitectafter_footer_widgets' );
	}
}

if ( ! function_exists( 'TheCreativityArchitectback_to_top' ) ) {
	add_action( 'TheCreativityArchitectafter_footer', 'TheCreativityArchitectback_to_top', 2 );
	/**
	 * Build the back to top button
	 *
	 */
	function TheCreativityArchitectback_to_top() {
		$TheCreativityArchitectsettings = wp_parse_args(
			get_option( 'TheCreativityArchitectsettings', array() ),
			TheCreativityArchitectget_defaults()
		);

		if ( 'enable' !== $TheCreativityArchitectsettings[ 'back_to_top' ] ) {
			return;
		}

		echo '<a title="' . esc_attr__( 'Scroll back to top', 'TheCreativityArchitect' ) . '" rel="nofollow" href="#" class="TheCreativityArchitect-back-to-top" style="opacity:0;visibility:hidden;" data-scroll-speed="' . absint( apply_filters( 'TheCreativityArchitectback_to_top_scroll_speed', 400 ) ) . '" data-start-scroll="' . absint( apply_filters( 'TheCreativityArchitectback_to_top_start_scroll', 300 ) ) . '">
				<span class="screen-reader-text">' . esc_html__( 'Scroll back to top', 'TheCreativityArchitect' ) . '</span>
			</a>';
	}
}

add_action( 'TheCreativityArchitectafter_footer', 'TheCreativityArchitectside_padding_footer', 5 );
/**
 * Add holder div if sidebar padding is enabled
 *
 */
function TheCreativityArchitectside_padding_footer() {
	$TheCreativityArchitectsettings = wp_parse_args(
		get_option( 'TheCreativityArchitectspacing_settings', array() ),
		TheCreativityArchitectspacing_get_defaults()
	);

	$fixed_side_content   =  TheCreativityArchitectget_setting( 'fixed_side_content' );
	$socials_display_side =  TheCreativityArchitectget_setting( 'socials_display_side' );

	if ( ( $TheCreativityArchitectsettings[ 'side_top' ] != 0 ) || ( $TheCreativityArchitectsettings[ 'side_right' ] != 0 ) || ( $TheCreativityArchitectsettings[ 'side_bottom' ] != 0 ) || ( $TheCreativityArchitectsettings[ 'side_left' ] != 0 ) ) { ?>
    	<div class="TheCreativityArchitect-side-left-cover"></div>
    	<div class="TheCreativityArchitect-side-right-cover"></div>
	</div>
	<?php }
	if ( ( $fixed_side_content != '' ) || ( $socials_display_side == true ) ) { ?>
    <div class="TheCreativityArchitect-side-left-content">
        <?php if ( $socials_display_side == true ) { ?>
        <div class="TheCreativityArchitect-side-left-socials">
        <?php do_action( 'TheCreativityArchitectsocial_bar_action' ); ?>
        </div>
        <?php } ?>
        <?php if ( $fixed_side_content != '' ) { ?>
    	<div class="TheCreativityArchitect-side-left-text">
        <?php echo wp_kses_post( $fixed_side_content ); ?>
        </div>
        <?php } ?>
    </div>
    <?php
	}
}
