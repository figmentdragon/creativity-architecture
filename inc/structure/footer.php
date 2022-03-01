<?php
/**
 * Footer elements.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( '__THEMENAE__construct_footer' ) ) {
	add_action( '__THEMENAE__footer', '__THEMENAE__construct_footer' );
	/**
	 * Build our footer.
	 *
	 */
	function __THEMENAE__construct_footer() {
		?>
		<footer class="site-info" itemtype="https://schema.org/WPFooter" itemscope="itemscope">
			<div class="inside-site-info <?php if ( 'full-width' !== __THEMENAE__get_setting( 'footer_inner_width' ) ) : ?>grid-container grid-parent<?php endif; ?>">
				<?php
				/**
				 * __THEMENAE__before_copyright hook.
				 *
				 *
				 * @hooked __THEMENAE__footer_bar - 15
				 */
				do_action( '__THEMENAE__before_copyright' );
				?>
				<div class="copyright-bar">
					<?php
					/**
					 * __THEMENAE__credits hook.
					 *
					 *
					 * @hooked __THEMENAE__add_footer_info - 10
					 */
					do_action( '__THEMENAE__credits' );
					?>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( '__THEMENAE__footer_bar' ) ) {
	add_action( '__THEMENAE__before_copyright', '__THEMENAE__footer_bar', 15 );
	/**
	 * Build our footer bar
	 *
	 */
	function __THEMENAE__footer_bar() {
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

if ( ! function_exists( '__THEMENAE__add_footer_info' ) ) {
	add_action( '__THEMENAE__credits', '__THEMENAE__add_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 */
	function __THEMENAE__add_footer_info() {
		echo '<span class="copyright">&copy; ' . esc_html( date( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) ) . '</span> &bull; ' . esc_html__( 'Powered by', '__THEMENAE__' ) . ' <a href="' . esc_url( __THEMENAE__theme_uri_link() ) . '" itemprop="url">' . esc_html__( 'WPKoi', '__THEMENAE__' ) . '</a>';
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
function __THEMENAE__do_footer_widget( $widget_width, $widget ) {
	$widget_width = apply_filters( "__THEMENAE__footer_widget_{$widget}_width", $widget_width );
	$tablet_widget_width = apply_filters( "__THEMENAE__footer_widget_{$widget}_tablet_width", '50' );
	?>
	<div class="footer-widget-<?php echo absint( $widget ); ?> grid-parent grid-<?php echo absint( $widget_width ); ?> tablet-grid-<?php echo absint( $tablet_widget_width ); ?> mobile-grid-100">
		<?php if ( ! dynamic_sidebar( 'footer-' . absint( $widget ) ) ) :
	        $current_user = wp_get_current_user();
	        if (user_can( $current_user, 'administrator' )) { ?>
			<aside class="widget inner-padding widget_text">
				<h4 class="widget-title"><?php esc_html_e( 'Footer Widget', '__THEMENAE__' );?></h4>
				<div class="textwidget">
					<p>
						<?php esc_html_e( 'Replace this widget content by going to ', '__THEMENAE__' ); ?><a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><strong><?php esc_html_e('Appearance / Widgets', '__THEMENAE__' ); ?></strong></a><?php esc_html_e( ' and dragging widgets into this widget area.', '__THEMENAE__' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'To remove or choose the number of footer widgets, go to ', '__THEMENAE__' ); ?><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><strong><?php esc_html_e('Appearance / Customize / Layout / Footer Widgets', '__THEMENAE__' ); ?></strong></a><?php esc_html_e( '.', '__THEMENAE__' ); ?>
					</p>
				</div>
			</aside>
		<?php } endif; ?>
	</div>
	<?php
}

if ( ! function_exists( '__THEMENAE__construct_footer_widgets' ) ) {
	add_action( '__THEMENAE__footer', '__THEMENAE__construct_footer_widgets', 5 );
	/**
	 * Build our footer widgets.
	 *
	 */
	function __THEMENAE__construct_footer_widgets() {
		// Get how many widgets to show.
		$widgets = __THEMENAE__get_footer_widgets();

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
				<div <?php __THEMENAE__inside_footer_class(); ?>>
					<div class="inside-footer-widgets">
						<?php
						if ( $widgets >= 1 ) {
							__THEMENAE__do_footer_widget( $widget_width, 1 );
						}

						if ( $widgets >= 2 ) {
							__THEMENAE__do_footer_widget( $widget_width, 2 );
						}

						if ( $widgets >= 3 ) {
							__THEMENAE__do_footer_widget( $widget_width, 3 );
						}

						if ( $widgets >= 4 ) {
							__THEMENAE__do_footer_widget( $widget_width, 4 );
						}

						if ( $widgets >= 5 ) {
							__THEMENAE__do_footer_widget( $widget_width, 5 );
						}
						?>
					</div>
				</div>
			</div>
		<?php
		endif;

		/**
		 * __THEMENAE__after_footer_widgets hook.
		 *
		 */
		do_action( '__THEMENAE__after_footer_widgets' );
	}
}

if ( ! function_exists( '__THEMENAE__back_to_top' ) ) {
	add_action( '__THEMENAE__after_footer', '__THEMENAE__back_to_top', 2 );
	/**
	 * Build the back to top button
	 *
	 */
	function __THEMENAE__back_to_top() {
		$__THEMENAE__settings = wp_parse_args(
			get_option( '__THEMENAE__settings', array() ),
			__THEMENAE__get_defaults()
		);

		if ( 'enable' !== $__THEMENAE__settings[ 'back_to_top' ] ) {
			return;
		}

		echo '<a title="' . esc_attr__( 'Scroll back to top', '__THEMENAE__' ) . '" rel="nofollow" href="#" class="__THEMENAE-back-to-top" style="opacity:0;visibility:hidden;" data-scroll-speed="' . absint( apply_filters( '__THEMENAE__back_to_top_scroll_speed', 400 ) ) . '" data-start-scroll="' . absint( apply_filters( '__THEMENAE__back_to_top_start_scroll', 300 ) ) . '">
				<span class="screen-reader-text">' . esc_html__( 'Scroll back to top', '__THEMENAE__' ) . '</span>
			</a>';
	}
}

add_action( '__THEMENAE__after_footer', '__THEMENAE__side_padding_footer', 5 );
/**
 * Add holder div if sidebar padding is enabled
 *
 */
function __THEMENAE__side_padding_footer() {
	$__THEMENAE__settings = wp_parse_args(
		get_option( '__THEMENAE__spacing_settings', array() ),
		__THEMENAE__spacing_get_defaults()
	);

	$fixed_side_content   =  __THEMENAE__get_setting( 'fixed_side_content' );
	$socials_display_side =  __THEMENAE__get_setting( 'socials_display_side' );

	if ( ( $__THEMENAE__settings[ 'side_top' ] != 0 ) || ( $__THEMENAE__settings[ 'side_right' ] != 0 ) || ( $__THEMENAE__settings[ 'side_bottom' ] != 0 ) || ( $__THEMENAE__settings[ 'side_left' ] != 0 ) ) { ?>
    	<div class="__THEMENAE-side-left-cover"></div>
    	<div class="__THEMENAE-side-right-cover"></div>
	</div>
	<?php }
	if ( ( $fixed_side_content != '' ) || ( $socials_display_side == true ) ) { ?>
    <div class="__THEMENAE-side-left-content">
        <?php if ( $socials_display_side == true ) { ?>
        <div class="__THEMENAE-side-left-socials">
        <?php do_action( '__THEMENAE__social_bar_action' ); ?>
        </div>
        <?php } ?>
        <?php if ( $fixed_side_content != '' ) { ?>
    	<div class="__THEMENAE-side-left-text">
        <?php echo wp_kses_post( $fixed_side_content ); ?>
        </div>
        <?php } ?>
    </div>
    <?php
	}
}
