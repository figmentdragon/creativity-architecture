<?php
/**
 * Customize API: _THEMENAE_Customize_Notice_Control class
 *
 * @package WordPress
 * @subpackage _THEMENAE_
 * @since _THEMENAE_ 1.0
 */

/**
 * Customize Notice Control class.
 *
 * @since _THEMENAE_ 1.0
 *
 * @see WP_Customize_Control
 */
class Customize_Notice_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @since _THEMENAE_ 1.0
	 *
	 * @var string
	 */
	public $type = '_THEMENAE_-notice';

	/**
	 * Renders the control content.
	 *
	 * This simply prints the notice we need.
	 *
	 * @since _THEMENAE_ 1.0
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<div class="notice notice-warning">
			<p><?php esc_html_e( 'To access the Dark Mode settings, select a light background color.', '__THEMENAE__' ); ?></p>
			<p><a href="<?php echo esc_url( __( 'https://wordpress.org/support/article/_THEMENAE_/#dark-mode-support', '__THEMENAE__' ) ); ?>">
				<?php esc_html_e( 'Learn more about Dark Mode.', '__THEMENAE__' ); ?>
			</a></p>
		</div>
		<?php
	}
}
