<?php
/**
 * Builds our main Layout meta box.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'admin_enqueue_scripts', 'enqueue_meta_box_scripts' );
/**
 * Adds any scripts for this meta box.
 *
 *
 * @param string $hook The current admin page.
 */
function enqueue_meta_box_scripts( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		$post_types = get_post_types( array( 'public' => true ) );
		$screen = get_current_screen();
		$post_type = $screen->id;

		if ( in_array( $post_type, ( array ) $post_types ) ) {
			wp_enqueue_style( 'TheCreativityArchitect-layout-metabox', get_template_directory_uri() . '/css/admin/meta-box.css', array(), VERSION );
		}
	}
}

add_action( 'add_meta_boxes', 'register_layout_meta_box' );
/**
 * Generate the layout metabox
 *
 */
function register_layout_meta_box() {
	if ( ! current_user_can( apply_filters( 'metabox_capability', 'edit_theme_options' ) ) ) {
		return;
	}

	if ( ! defined( 'LAYOUT_META_BOX' ) ) {
		define( 'LAYOUT_META_BOX', true );
	}

	$post_types = get_post_types( array( 'public' => true ) );
	foreach ($post_types as $type) {
		if ( 'attachment' !== $type ) {
			add_meta_box (
				'layout_options_meta_box',
				esc_html__( 'Layout', 'TheCreativityArchitect' ),
				'do_layout_meta_box',
				$type,
				'normal',
				'high'
			);
		}
	}
}

/**
 * Build our meta box.
 *
 *
 * @param object $post All post information.
 */
function do_layout_meta_box( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'layout_nonce' );
	$stored_meta = (array) get_post_meta( $post->ID );
	$stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0] = ( isset( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0] ) ) ? $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0] : '';
	$stored_meta['_TheCreativityArchitect-footer-widget-meta'][0] = ( isset( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0] ) ) ? $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0] : '';
	$stored_meta['_TheCreativityArchitect-full-width-content'][0] = ( isset( $stored_meta['_TheCreativityArchitect-full-width-content'][0] ) ) ? $stored_meta['_TheCreativityArchitect-full-width-content'][0] : '';
	$stored_meta['_TheCreativityArchitect-disable-headline'][0] = ( isset( $stored_meta['_TheCreativityArchitect-disable-headline'][0] ) ) ? $stored_meta['_TheCreativityArchitect-disable-headline'][0] : '';
	$stored_meta['_TheCreativityArchitect-transparent-header'][0] = ( isset( $stored_meta['_TheCreativityArchitect-transparent-header'][0] ) ) ? $stored_meta['_TheCreativityArchitect-transparent-header'][0] : '';

	$tabs = apply_filters( 'metabox_tabs',
		array(
			'sidebars' => array(
				'title' => esc_html__( 'Sidebars', 'TheCreativityArchitect' ),
				'target' => '#TheCreativityArchitect-layout-sidebars',
				'class' => 'current',
			),
			'footer_widgets' => array(
				'title' => esc_html__( 'Footer Widgets', 'TheCreativityArchitect' ),
				'target' => '#TheCreativityArchitect-layout-footer-widgets',
				'class' => '',
			),
			'disable_elements' => array(
				'title' => esc_html__( 'Disable Elements', 'TheCreativityArchitect' ),
				'target' => '#TheCreativityArchitect-layout-disable-elements',
				'class' => '',
			),
			'container' => array(
				'title' => esc_html__( 'Page Builder Container', 'TheCreativityArchitect' ),
				'target' => '#TheCreativityArchitect-layout-page-builder-container',
				'class' => '',
			),
			'transparent_header' => array(
				'title' => esc_html__( 'Transparent Header', 'TheCreativityArchitect' ),
				'target' => '#TheCreativityArchitect-layout-transparent-header',
				'class' => '',
			),
		)
	);
	?>
	<script>
		jQuery(document).ready(function($) {
			$( '.TheCreativityArchitect-meta-box-menu li a' ).on( 'click', function( event ) {
				event.preventDefault();
				$( this ).parent().addClass( 'current' );
				$( this ).parent().siblings().removeClass( 'current' );
				var tab = $( this ).attr( 'data-target' );

				// Page header module still using href.
				if ( ! tab ) {
					tab = $( this ).attr( 'href' );
				}

				$( '.TheCreativityArchitect-meta-box-content' ).children( 'div' ).not( tab ).css( 'display', 'none' );
				$( tab ).fadeIn( 100 );
			});
		});
	</script>
	<div id="TheCreativityArchitect-meta-box-container">
		<ul class="TheCreativityArchitect-meta-box-menu">
			<?php
			foreach ( ( array ) $tabs as $tab => $data ) {
				echo '<li class="' . esc_attr( $data['class'] ) . '"><a data-target="' . esc_attr( $data['target'] ) . '" href="#">' . esc_html( $data['title'] ) . '</a></li>';
			}

			do_action( 'layout_meta_box_menu_item' );
			?>
		</ul>
		<div class="TheCreativityArchitect-meta-box-content">
			<div id="TheCreativityArchitect-layout-sidebars">
				<div class="layouts">
					<label for="meta-TheCreativityArchitect-layout-global" style="display:block;margin-bottom:10px;">
						<input type="radio" name="_TheCreativityArchitect-sidebar-layout-meta" id="meta-TheCreativityArchitect-layout-global" value="" <?php checked( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0], '' ); ?>>
						<?php esc_html_e( 'Default', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-layout-one" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( 'Right Sidebar', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-sidebar-layout-meta" id="meta-TheCreativityArchitect-layout-one" value="right-sidebar" <?php checked( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0], 'right-sidebar' ); ?>>
						<?php esc_html_e( 'Content', 'TheCreativityArchitect' );?> / <strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong>
					</label>

					<label for="meta-TheCreativityArchitect-layout-two" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( 'Left Sidebar', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-sidebar-layout-meta" id="meta-TheCreativityArchitect-layout-two" value="left-sidebar" <?php checked( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0], 'left-sidebar' ); ?>>
						<strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong> / <?php esc_html_e( 'Content', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-layout-three" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( 'No Sidebars', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-sidebar-layout-meta" id="meta-TheCreativityArchitect-layout-three" value="no-sidebar" <?php checked( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0], 'no-sidebar' ); ?>>
						<?php esc_html_e( 'Content (no sidebars)', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-layout-four" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( 'Both Sidebars', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-sidebar-layout-meta" id="meta-TheCreativityArchitect-layout-four" value="both-sidebars" <?php checked( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0], 'both-sidebars' ); ?>>
						<strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong> / <?php esc_html_e( 'Content', 'TheCreativityArchitect' );?> / <strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong>
					</label>

					<label for="meta-TheCreativityArchitect-layout-five" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( 'Both Sidebars on Left', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-sidebar-layout-meta" id="meta-TheCreativityArchitect-layout-five" value="both-left" <?php checked( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0], 'both-left' ); ?>>
						<strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong> / <strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong> / <?php esc_html_e( 'Content', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-layout-six" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( 'Both Sidebars on Right', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-sidebar-layout-meta" id="meta-TheCreativityArchitect-layout-six" value="both-right" <?php checked( $stored_meta['_TheCreativityArchitect-sidebar-layout-meta'][0], 'both-right' ); ?>>
						<?php esc_html_e( 'Content', 'TheCreativityArchitect' );?> / <strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong> / <strong><?php echo esc_html_x( 'Sidebar', 'Short name for meta box', 'TheCreativityArchitect' ); ?></strong>
					</label>
				</div>
			</div>
			<div id="TheCreativityArchitect-layout-footer-widgets" style="display: none;">
				<div class="footer_widget">
					<label for="meta-TheCreativityArchitect-footer-widget-global" style="display:block;margin-bottom:10px;">
						<input type="radio" name="_TheCreativityArchitect-footer-widget-meta" id="meta-TheCreativityArchitect-footer-widget-global" value="" <?php checked( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0], '' ); ?>>
						<?php esc_html_e( 'Default', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-footer-widget-zero" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( '0 Widgets', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-footer-widget-meta" id="meta-TheCreativityArchitect-footer-widget-zero" value="0" <?php checked( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0], '0' ); ?>>
						<?php esc_html_e( '0 Widgets', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-footer-widget-one" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( '1 Widget', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-footer-widget-meta" id="meta-TheCreativityArchitect-footer-widget-one" value="1" <?php checked( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0], '1' ); ?>>
						<?php esc_html_e( '1 Widget', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-footer-widget-two" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( '2 Widgets', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-footer-widget-meta" id="meta-TheCreativityArchitect-footer-widget-two" value="2" <?php checked( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0], '2' ); ?>>
						<?php esc_html_e( '2 Widgets', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-footer-widget-three" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( '3 Widgets', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-footer-widget-meta" id="meta-TheCreativityArchitect-footer-widget-three" value="3" <?php checked( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0], '3' ); ?>>
						<?php esc_html_e( '3 Widgets', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-footer-widget-four" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( '4 Widgets', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-footer-widget-meta" id="meta-TheCreativityArchitect-footer-widget-four" value="4" <?php checked( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0], '4' ); ?>>
						<?php esc_html_e( '4 Widgets', 'TheCreativityArchitect' );?>
					</label>

					<label for="meta-TheCreativityArchitect-footer-widget-five" style="display:block;margin-bottom:3px;" title="<?php esc_attr_e( '5 Widgets', 'TheCreativityArchitect' );?>">
						<input type="radio" name="_TheCreativityArchitect-footer-widget-meta" id="meta-TheCreativityArchitect-footer-widget-five" value="5" <?php checked( $stored_meta['_TheCreativityArchitect-footer-widget-meta'][0], '5' ); ?>>
						<?php esc_html_e( '5 Widgets', 'TheCreativityArchitect' );?>
					</label>
				</div>
			</div>
			<div id="TheCreativityArchitect-layout-page-builder-container" style="display: none;">
				<p class="page-builder-content" style="color:#666;font-size:13px;margin-top:0;">
					<?php esc_html_e( 'Choose your page builder content container type. Both options remove the content padding for you.', 'TheCreativityArchitect' ) ;?>
				</p>

				<p class="full_width_template">
					<label for="default-content" style="display:block;margin-bottom:10px;">
						<input type="radio" name="_TheCreativityArchitect-full-width-content" id="default-content" value="" <?php checked( $stored_meta['_TheCreativityArchitect-full-width-content'][0], '' ); ?>>
						<?php esc_html_e( 'Default', 'TheCreativityArchitect' );?>
					</label>

					<label id="full-width-content" for="_TheCreativityArchitect-full-width-content" style="display:block;margin-bottom:10px;">
						<input type="radio" name="_TheCreativityArchitect-full-width-content" id="_TheCreativityArchitect-full-width-content" value="true" <?php checked( $stored_meta['_TheCreativityArchitect-full-width-content'][0], 'true' ); ?>>
						<?php esc_html_e( 'Full Width', 'TheCreativityArchitect' );?>
					</label>

					<label id="TheCreativityArchitect-remove-padding" for="_TheCreativityArchitect-remove-content-padding" style="display:block;margin-bottom:10px;">
						<input type="radio" name="_TheCreativityArchitect-full-width-content" id="_TheCreativityArchitect-remove-content-padding" value="contained" <?php checked( $stored_meta['_TheCreativityArchitect-full-width-content'][0], 'contained' ); ?>>
						<?php esc_html_e( 'Contained', 'TheCreativityArchitect' );?>
					</label>
				</p>
			</div>
			<div id="TheCreativityArchitect-layout-transparent-header" style="display: none;">
				<p class="transparent-header-content" style="color:#666;font-size:13px;margin-top:0;">
					<?php esc_html_e( 'Switch to transparent header if You want to put content behind the header.', 'TheCreativityArchitect' ) ;?>
				</p>

				<p class="transparent_header">
					<label for="default" style="display:block;margin-bottom:10px;">
						<input type="radio" name="_TheCreativityArchitect-transparent-header" id="default" value="" <?php checked( $stored_meta['_TheCreativityArchitect-transparent-header'][0], '' ); ?>>
						<?php esc_html_e( 'Default', 'TheCreativityArchitect' );?>
					</label>

					<label id="transparent" for="_TheCreativityArchitect-transparent-header" style="display:block;margin-bottom:10px;">
						<input type="radio" name="_TheCreativityArchitect-transparent-header" id="transparent" value="true" <?php checked( $stored_meta['_TheCreativityArchitect-transparent-header'][0], 'true' ); ?>>
						<?php esc_html_e( 'Transparent', 'TheCreativityArchitect' );?>
					</label>
				</p>
			</div>
			<div id="TheCreativityArchitect-layout-disable-elements" style="display: none;">
				<?php if ( ! defined( 'DE_VERSION' ) ) : ?>
					<div class="disable_elements">
						<label for="meta-TheCreativityArchitect-disable-headline" style="display:block;margin: 0 0 1em;" title="<?php esc_attr_e( 'Content Title', 'TheCreativityArchitect' );?>">
							<input type="checkbox" name="_TheCreativityArchitect-disable-headline" id="meta-TheCreativityArchitect-disable-headline" value="true" <?php checked( $stored_meta['_TheCreativityArchitect-disable-headline'][0], 'true' ); ?>>
							<?php esc_html_e( 'Content Title', 'TheCreativityArchitect' );?>
						</label>

						<?php if ( ! defined( 'PREMIUM_VERSION' ) ) : ?>
							<span style="display:block;padding-top:1em;border-top:1px solid #EFEFEF;">
								<a href="<?php echo esc_url( theme_uri_link() ); ?>" target="_blank"><?php esc_html_e( 'Premium module available', 'TheCreativityArchitect' ); ?></a>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php do_action( 'layout_disable_elements_section', $stored_meta ); ?>
			</div>
			<?php do_action( 'layout_meta_box_content', $stored_meta ); ?>
		</div>
	</div>
    <?php
}

add_action( 'save_post', 'save_layout_meta_data' );
/**
 * Saves the sidebar layout meta data.
 *
 *
 * @param int Post ID.
 */
function save_layout_meta_data( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'layout_nonce' ] ) && wp_verify_nonce( sanitize_key( $_POST[ 'layout_nonce' ] ), basename( __FILE__ ) ) ) ? true : false;

	if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$sidebar_layout_key   = '_TheCreativityArchitect-sidebar-layout-meta';
	$sidebar_layout_value = filter_input( INPUT_POST, $sidebar_layout_key, FILTER_SANITIZE_STRING );

	if ( $sidebar_layout_value ) {
		update_post_meta( $post_id, $sidebar_layout_key, $sidebar_layout_value );
	} else {
		delete_post_meta( $post_id, $sidebar_layout_key );
	}

	$footer_widget_key   = '_TheCreativityArchitect-footer-widget-meta';
	$footer_widget_value = filter_input( INPUT_POST, $footer_widget_key, FILTER_SANITIZE_STRING );

	// Check for empty string to allow 0 as a value.
	if ( '' !== $footer_widget_value ) {
		update_post_meta( $post_id, $footer_widget_key, $footer_widget_value );
	} else {
		delete_post_meta( $post_id, $footer_widget_key );
	}

	$page_builder_container_key   = '_TheCreativityArchitect-full-width-content';
	$page_builder_container_value = filter_input( INPUT_POST, $page_builder_container_key, FILTER_SANITIZE_STRING );

	if ( $page_builder_container_value ) {
		update_post_meta( $post_id, $page_builder_container_key, $page_builder_container_value );
	} else {
		delete_post_meta( $post_id, $page_builder_container_key );
	}

	$transparent_header_key   = '_TheCreativityArchitect-transparent-header';
	$transparent_header_value = filter_input( INPUT_POST, $transparent_header_key, FILTER_SANITIZE_STRING );

	if ( $transparent_header_value ) {
		update_post_meta( $post_id, $transparent_header_key, $transparent_header_value );
	} else {
		delete_post_meta( $post_id, $transparent_header_key );
	}

	// We only need this if the Disable Elements module doesn't exist
	if ( ! defined( 'DE_VERSION' ) ) {
		$disable_content_title_key   = '_TheCreativityArchitect-disable-headline';
		$disable_content_title_value = filter_input( INPUT_POST, $disable_content_title_key, FILTER_SANITIZE_STRING );

		if ( $disable_content_title_value ) {
			update_post_meta( $post_id, $disable_content_title_key, $disable_content_title_value );
		} else {
			delete_post_meta( $post_id, $disable_content_title_key );
		}
	}

	do_action( 'layout_meta_box_save', $post_id );
}
