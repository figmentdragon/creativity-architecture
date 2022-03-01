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
	 * Adds our "__THEMENAE__" dashboard menu item
	 *
	 */
	function create_menu() {
		$page = add_theme_page( '__THEMENAE__', '__THEMENAE__', apply_filters( 'dashboard_page_capability', 'edit_theme_options' ), '__THEMENAE-options', 'settings_page' );
		add_action( "admin_print_styles-$page", 'options_styles' );
	}
}

if ( ! function_exists( 'options_styles' ) ) {
	/**
	 * Adds any necessary scripts to the __THEMENAE__ dashboard page
	 *
	 */
	function options_styles() {
		wp_enqueue_style( '__THEMENAE-options', get_template_directory_uri() . '/css/admin/admin-style.css', array(), VERSION );
	}
}

if ( ! function_exists( 'settings_page' ) ) {
	/**
	 * Builds the content of our __THEMENAE__ dashboard page
	 *
	 */
	function settings_page() {
		?>
		<div class="wrap">
			<div class="metabox-holder">
				<div class="__THEMENAE-masthead clearfix">
					<div class="__THEMENAE-container">
						<div class="__THEMENAE-title">
							<a href="<?php echo esc_url(theme_uri_link()); ?>" target="_blank"><?php esc_html_e( '__THEMENAE__', '__THEMENAE__' ); ?></a> <span class="__THEMENAE-version"><?php echo esc_html( VERSION ); ?></span>
						</div>
						<div class="__THEMENAE-masthead-links">
							<?php if ( ! defined( 'PREMIUM_VERSION' ) ) : ?>
								<a class="__THEMENAE-masthead-links-bold" href="<?php echo esc_url(theme_uri_link()); ?>" target="_blank"><?php esc_html_e( 'Premium', '__THEMENAE__' );?></a>
							<?php endif; ?>
							<a href="<?php echo esc_url(WPKOI_AUTHOR_URL); ?>" target="_blank"><?php esc_html_e( 'WPKoi', '__THEMENAE__' ); ?></a>
                            <a href="<?php echo esc_url(DOCUMENTATION); ?>" target="_blank"><?php esc_html_e( 'Documentation', '__THEMENAE__' ); ?></a>
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

				<div class="__THEMENAE-container">
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
									<?php settings_fields( '__THEMENAE-settings-group' ); ?>
									<?php do_settings_sections( '__THEMENAE-settings-group' ); ?>
									<div class="customize-button hide-on-desktop">
										<?php
										printf( '<a id="customize_button" class="button button-primary" href="%1$s">%2$s</a>',
											esc_url( admin_url( 'customize.php' ) ),
											esc_html__( 'Customize', '__THEMENAE__' )
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
								);

								if ( ! defined( 'PREMIUM_VERSION' ) ) : ?>
									<div class="postbox __THEMENAE-metabox">
										<h3 class="hndle"><?php esc_html_e( 'Premium Modules', '__THEMENAE__' ); ?></h3>
										<div class="inside" style="margin:0;padding:0;">
											<div class="premium-addons">
												<?php foreach( $modules as $module => $info ) { ?>
												<div class="add-on activated __THEMENAE-clear addon-container grid-parent">
													<div class="addon-name column-addon-name" style="">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php echo esc_html( $module ); ?></a>
													</div>
													<div class="addon-action addon-addon-action" style="text-align:right;">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php esc_html_e( 'More info', '__THEMENAE__' ); ?></a>
													</div>
												</div>
												<div class="__THEMENAE-clear"></div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php
								endif;

								/**
								 * options_items hook.
								 *
								 */
								do_action( 'options_items' );
								?>
							</div>

							<div class="__THEMENAE-right-sidebar grid-30" style="padding-right: 0;">
								<div class="customize-button hide-on-mobile">
									<?php
									printf( '<a id="customize_button" class="button button-primary" href="%1$s">%2$s</a>',
										esc_url( admin_url( 'customize.php' ) ),
										esc_html__( 'Customize', '__THEMENAE__' )
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

                                <div class="wpkoi-doc">
                                	<h3><?php esc_html_e( '__THEMENAE__ documentation', '__THEMENAE__' ); ?></h3>
                                	<p><?php esc_html_e( 'If You`ve stuck, the documentation may help on WPKoi.com', '__THEMENAE__' ); ?></p>
                                    <a href="<?php echo esc_url(DOCUMENTATION); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( '__THEMENAE__ documentation', '__THEMENAE__' ); ?></a>
                                </div>

                                <div class="wpkoi-social">
                                	<h3><?php esc_html_e( 'WPKoi on Facebook', '__THEMENAE__' ); ?></h3>
                                	<p><?php esc_html_e( 'If You want to get useful info about WordPress and the theme, follow WPKoi on Facebook.', '__THEMENAE__' ); ?></p>
                                    <a href="<?php echo esc_url(WPKOI_SOCIAL_URL); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Go to Facebook', '__THEMENAE__' ); ?></a>
                                </div>

                                <div class="wpkoi-review">
                                	<h3><?php esc_html_e( 'Help with You review', '__THEMENAE__' ); ?></h3>
                                	<p><?php esc_html_e( 'If You like __THEMENAE__ theme, show it to the world with Your review. Your feedback helps a lot.', '__THEMENAE__' ); ?></p>
                                    <a href="<?php echo esc_url(WORDPRESS_REVIEW); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Add my review', '__THEMENAE__' ); ?></a>
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

		if ( 'appearance_page___THEMENAE-options' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
			 add_settings_error( '__THEMENAE-notices', 'true', esc_html__( 'Settings saved.', '__THEMENAE__' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'imported' == $_GET['status'] ) {
			 add_settings_error( '__THEMENAE-notices', 'imported', esc_html__( 'Import successful.', '__THEMENAE__' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'reset' == $_GET['status'] ) {
			 add_settings_error( '__THEMENAE-notices', 'reset', esc_html__( 'Settings removed.', '__THEMENAE__' ), 'updated' );
		}

		settings_errors( '__THEMENAE-notices' );
	}
}
