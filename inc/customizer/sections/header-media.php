<?php
/**
 * Header Media Options
 *
 * @package MYTHEME
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function MYTHEME_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'MYTHEME' );

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_option',
			'default'           => 'entire-site',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'MYTHEME' ),
				'exclude-home'           => esc_html__( 'Excluding Homepage', 'MYTHEME' ),
				'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'MYTHEME' ),
				'entire-site'            => esc_html__( 'Entire Site', 'MYTHEME' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'MYTHEME' ),
				'pages-posts'            => esc_html__( 'Pages and Posts', 'MYTHEME' ),
				'disable'                => esc_html__( 'Disabled', 'MYTHEME' ),
			),
			'label'             => esc_html__( 'Enable on', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	/* Scroll Down option */
	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_scroll_down',
			'sanitize_callback' => 'MYTHEME_sanitize_checkbox',
			'default'           => 1,
			'label'             => esc_html__( 'Scroll Down Button', 'MYTHEME' ),
			'section'           => 'header_image',
			'custom_control'    => 'MYTHEME_Toggle_Control',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_image_position_desktop',
			'default'           => 'center center',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'label'             => esc_html__( 'Image Position (Desktop View)', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'MYTHEME' ),
				'left center'   => esc_html__( 'Left Center', 'MYTHEME' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'MYTHEME' ),
				'right top'     => esc_html__( 'Right Top', 'MYTHEME' ),
				'right center'  => esc_html__( 'Right Center', 'MYTHEME' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'MYTHEME' ),
				'center top'    => esc_html__( 'Center Top', 'MYTHEME' ),
				'center center' => esc_html__( 'Center Center', 'MYTHEME' ),
				'center bottom' => esc_html__( 'Center Bottom', 'MYTHEME' ),
			),
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_image_position_mobile',
			'default'           => 'center center',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'label'             => esc_html__( 'Image Position (Mobile View)', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'MYTHEME' ),
				'left center'   => esc_html__( 'Left Center', 'MYTHEME' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'MYTHEME' ),
				'right top'     => esc_html__( 'Right Top', 'MYTHEME' ),
				'right center'  => esc_html__( 'Right Center', 'MYTHEME' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'MYTHEME' ),
				'center top'    => esc_html__( 'Center Top', 'MYTHEME' ),
				'center center' => esc_html__( 'Center Center', 'MYTHEME' ),
				'center bottom' => esc_html__( 'Center Bottom', 'MYTHEME' ),
			),
		)
	);

	/*Overlay Option for Header Media*/
	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_image_opacity',
			'default'           => '0',
			'sanitize_callback' => 'MYTHEME_sanitize_number_range',
			'label'             => esc_html__( 'Header Media Overlay', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_text_alignment',
			'default'           => 'text-align-left',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'choices'           => array(
				'text-align-center' => esc_html__( 'Center', 'MYTHEME' ),
				'text-align-right'  => esc_html__( 'Right', 'MYTHEME' ),
				'text-align-left'   => esc_html__( 'Left', 'MYTHEME' ),
			),
			'label'             => esc_html__( 'Text Alignment', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_content_alignment',
			'default'           => 'content-align-right',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'choices'           => array(
				'content-align-center' => esc_html__( 'Center', 'MYTHEME' ),
				'content-align-right'  => esc_html__( 'Right', 'MYTHEME' ),
				'content-align-left'   => esc_html__( 'Left', 'MYTHEME' ),
			),
			'label'             => esc_html__( 'Content Alignment', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_logo',
			'sanitize_callback' => 'esc_url_raw',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Header Media Logo', 'MYTHEME' ),
			'section'           => 'header_image',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_logo_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'active_callback'   => 'MYTHEME_is_header_media_logo_active',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'MYTHEME' ),
				'entire-site'            => esc_html__( 'Entire Site', 'MYTHEME' ) ),
			'label'             => esc_html__( 'Enable Header Media logo on', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Tagline', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Site Header Text', 'MYTHEME' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'MYTHEME' ),
			'section'           => 'header_image',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'MYTHEME' ),
			'section'           => 'header_image',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_header_url_target',
			'sanitize_callback' => 'MYTHEME_sanitize_checkbox',
			'label'             => esc_html__( 'Open Link in New Window/Tab', 'MYTHEME' ),
			'section'           => 'header_image',
			'custom_control'    => 'MYTHEME_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'MYTHEME_header_media_options' );

/** Active Callback Functions */

if ( ! function_exists( 'MYTHEME_is_header_media_logo_active' ) ) :
	/**
	* Return true if header logo is active
	*
	* @since MYTHEME Pro 1.0
	*/
	function MYTHEME_is_header_media_logo_active( $control ) {
		$logo = $control->manager->get_setting( 'MYTHEME_header_media_logo' )->value();
		if ( '' != $logo ) {
			return true;
		} else {
			return false;
		}
	}
endif;
