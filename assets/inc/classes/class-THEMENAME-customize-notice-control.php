<?php
/**
 * Customize API: THEMENAME_Customize_Notice_Control class
 *
 * @package WordPress
 * @subpackage THEMENAME
 * @since THEMENAME 1.0
 */

/**
 * Customize Notice Control class.
 *
 * @since THEMENAME 1.0
 *
 * @see WP_Customize_Control
 */
class THEMENAME_Customize_Notice_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @since THEMENAME 1.0
	 *
	 * @var string
	 */
	public $type = 'THEMENAME-notice';

	/**
	 * Renders the control content.
	 *
	 * This simply prints the notice we need.
	 *
	 * @since THEMENAME 1.0
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<div class="notice notice-warning">
			<p><?php esc_html_e( 'To access the Dark Mode settings, select a light background color.', 'THEMENAME' ); ?></p>
			<p><a href="<?php echo esc_url( __( 'https://wordpress.org/support/article/THEMENAME/#dark-mode-support', 'THEMENAME' ) ); ?>">
				<?php esc_html_e( 'Learn more about Dark Mode.', 'THEMENAME' ); ?>
			</a></p>
		</div>
		<?php
	}
}
