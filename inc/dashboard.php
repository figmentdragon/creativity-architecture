<?php
/**
 * Builds our admin page.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'create_menu' ) ) {
	add_action( 'admin_menu', 'create_menu' );
	/**
	 * Adds our "CreativityArchitect__" dashboard menu item
	 *
	 */
	function create_menu() {
		$page = add_theme_page( 'TheCreativityArchitect', 'TheCreativityArchitect', apply_filters( 'dashboard_page_capability', 'edit_theme_options' ), 'CreativityArchitect-options', 'settings_page' );
		add_action( "admin_print_styles-$page", 'options_styles' );
	}
}

if ( ! function_exists( 'options_styles' ) ) {
	/**
	 * Adds any necessary scripts to the The Creativity Architect dashboard page
	 *
	 */
	function options_styles() {
		wp_enqueue_style( 'CreativityArchitect-options', get_template_directory_uri() . '/assets/scripts/css/admin/admin-style.css', array(), 'VERSION' );
	}
}

if ( ! function_exists( 'settings_page' ) ) {
	/**
	 * Builds the content of our The Creativity Architect dashboard page
	 *
	 */
	function settings_page() {
		?>
		<div class="wrap">
			<div class="metabox-holder">
				<div class="CreativityArchitect-masthead clearfix">
					<div class="CreativityArchitect-container">
						<div class="CreativityArchitect-title">
							<a href="<?php echo esc_url( $site_url( $path = '', $scheme = null )()); ?>" target="_blank"><?php esc_html_e( 'TheCreativityArchitect', 'TheCreativityArchitect' ); ?></a> <span class="CreativityArchitect-version"><?php echo esc_html( 'VERSION' ); ?></span>
						</div>
						<div class="CreativityArchitect-masthead-links">
							 <a href="<?php echo esc_url( DOCUMENTATION ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'TheCreativityArchitect' ); ?></a>
						</div>
					</div>
				</div>

				<?php
				/**
				 * dashboard_after_header hook.
				 *
				 */
				 do_action( 'dashboard_after_header' );
				 ?>

				<div class="CreativityArchitect-container">
					<div class="postbox-container clearfix" style="float: none;">
						<div class="grid-container grid-parent">

							<?php
							/**
							 * dashboard_inside_container hook.
							 *
							 */
							 do_action( 'dashboard_inside_container' );
							 ?>

							<div class="form-metabox grid-70" style="padding-left: 0;">
								<h2 style="height:0;margin:0;"><!-- admin notices below this element --></h2>
								<form method="post" action="options.php">
									<?php settings_fields( 'CreativityArchitect-settings-group' ); ?>
									<?php do_settings_sections( 'CreativityArchitect-settings-group' ); ?>
									<div class="customize-button hide-on-desktop">
										<?php
										printf( '<a id="customize_button" class="button button-primary" href="%1$s">%2$s</a>',
											esc_url( admin_url( 'customize.php' ) ),
											esc_html__( 'Customize', 'TheCreativityArchitect' )
										);
										?>
									</div>

									<?php
									/**
									 * inside_options_form hook.
									 *
									 */
									 do_action( 'inside_options_form' );
									 ?>
								</form>

								<?php
								$modules = array(
									'Backgrounds' => array(
											'url' => theme_uri_link(),
									),
									'Blog' => array(
											'url' => theme_uri_link(),
									),
									'Colors' => array(
											'url' => theme_uri_link(),
									),
									'Copyright' => array(
											'url' => theme_uri_link(),
									),
									'Disable Elements' => array(
											'url' => theme_uri_link(),
									),
									'Demo Import' => array(
											'url' => theme_uri_link(),
									),
									'Hooks' => array(
											'url' => theme_uri_link(),
									),
									'Import / Export' => array(
											'url' => theme_uri_link(),
									),
									'Menu Plus' => array(
											'url' => theme_uri_link(),
									),
									'Page Header' => array(
											'url' => theme_uri_link(),
									),
									'Secondary Nav' => array(
											'url' => theme_uri_link(),
									),
									'Spacing' => array(
											'url' => theme_uri_link(),
									),
									'Typography' => array(
											'url' => theme_uri_link(),
									),
									'Elementor Addon' => array(
											'url' => theme_uri_link(),
									)
								); ?>

							<?php	/**
								 * options_items hook.
								 *
								 */
								do_action( 'options_items' );
								?>
                <div class="CreativityArchitect-right-sidebar grid-30" style="padding-right: 0;">
                  <div class="customize-button hide-on-mobile">
                    <?php
                    printf( '<a id="customize_button" class="button button-primary" href="%1$s">%2$s</a>',
                    esc_url( admin_url( 'customize.php' ) ),
                    esc_html__( 'Customize', 'TheCreativityArchitect' )
                  );
                  ?>
                </div>

                <?php
								/**
								 * admin_right_panel hook.
								 *
								 */
								 do_action( 'admin_right_panel' );
                 ?>

                 <div class="doc">
                   <h3><?php esc_html_e( 'documentation', 'TheCreativityArchitect' ); ?></h3>
                   <p><?php esc_html_e( 'If You`ve stuck, the documentation may help on thecreativityarchitect.com', 'TheCreativityArchitect' ); ?></p>
                   <a href="<?php echo esc_url(DOCUMENTATION); ?>" class="admin-button" target="_blank"><?php esc_html_e( 'documentation', 'TheCreativityArchitect' ); ?></a>
                 </div>
                 <div class="social">
                   <h3><?php esc_html_e( 'The Creativity Architect on Facebook', 'TheCreativityArchitect' ); ?></h3>
                   <p><?php esc_html_e( 'If You want to get useful info about WordPress and the theme, follow The Creativity Architect on Facebook.', 'TheCreativityArchitect' ); ?></p>
                   <a href="<?php echo esc_url(SOCIAL_URL); ?>" class="admin-button" target="_blank"><?php esc_html_e( 'Go to Facebook', 'TheCreativityArchitect' ); ?></a>
                 </div>
                 <div class="review">
                   <h3><?php esc_html_e( 'Help with You review', 'TheCreativityArchitect' ); ?></h3>
                   <p><?php esc_html_e( 'If You like The Creativity Architect theme, show it to the world with Your review. Your feedback helps a lot.', 'TheCreativityArchitect' ); ?></p>
                   <a href="<?php echo esc_url(WORDPRESS_REVIEW); ?>" class="admin-button" target="_blank"><?php esc_html_e( 'Add my review', 'TheCreativityArchitect' ); ?></a>
                 </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'admin_errors' ) ) {
	add_action( 'admin_notices', 'admin_errors' );
	/**
	 * Add our admin notices
	 *
	 */
	function admin_errors() {
		$screen = get_current_screen();

		if ( 'appearance_page_CreativityArchitect-options' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
			 add_settings_error( 'CreativityArchitect-notices', 'true', esc_html__( 'Settings saved.', 'TheCreativityArchitect' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'imported' == $_GET['status'] ) {
			 add_settings_error( 'CreativityArchitect-notices', 'imported', esc_html__( 'Import successful.', 'TheCreativityArchitect' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'reset' == $_GET['status'] ) {
			 add_settings_error( 'CreativityArchitect-notices', 'reset', esc_html__( 'Settings removed.', 'TheCreativityArchitect' ), 'updated' );
		}

		settings_errors( 'CreativityArchitect-notices' );
	}
}
