<?php
/**
 * Header Media Options
 *
 * @package THEMENAME
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function THEMENAME_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'THEMENAME' );

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_option',
			'default'           => 'entire-site',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'THEMENAME' ),
				'exclude-home'           => esc_html__( 'Excluding Homepage', 'THEMENAME' ),
				'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'THEMENAME' ),
				'entire-site'            => esc_html__( 'Entire Site', 'THEMENAME' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'THEMENAME' ),
				'pages-posts'            => esc_html__( 'Pages and Posts', 'THEMENAME' ),
				'disable'                => esc_html__( 'Disabled', 'THEMENAME' ),
			),
			'label'             => esc_html__( 'Enable on', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	/* Scroll Down option */
	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_scroll_down',
			'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
			'default'           => 1,
			'label'             => esc_html__( 'Scroll Down Button', 'THEMENAME' ),
			'section'           => 'header_image',
			'custom_control'    => 'THEMENAME_Toggle_Control',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_image_position_desktop',
			'default'           => 'center center',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'label'             => esc_html__( 'Image Position (Desktop View)', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'THEMENAME' ),
				'left center'   => esc_html__( 'Left Center', 'THEMENAME' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'THEMENAME' ),
				'right top'     => esc_html__( 'Right Top', 'THEMENAME' ),
				'right center'  => esc_html__( 'Right Center', 'THEMENAME' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'THEMENAME' ),
				'center top'    => esc_html__( 'Center Top', 'THEMENAME' ),
				'center center' => esc_html__( 'Center Center', 'THEMENAME' ),
				'center bottom' => esc_html__( 'Center Bottom', 'THEMENAME' ),
			),
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_image_position_mobile',
			'default'           => 'center center',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'label'             => esc_html__( 'Image Position (Mobile View)', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'THEMENAME' ),
				'left center'   => esc_html__( 'Left Center', 'THEMENAME' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'THEMENAME' ),
				'right top'     => esc_html__( 'Right Top', 'THEMENAME' ),
				'right center'  => esc_html__( 'Right Center', 'THEMENAME' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'THEMENAME' ),
				'center top'    => esc_html__( 'Center Top', 'THEMENAME' ),
				'center center' => esc_html__( 'Center Center', 'THEMENAME' ),
				'center bottom' => esc_html__( 'Center Bottom', 'THEMENAME' ),
			),
		)
	);

	/*Overlay Option for Header Media*/
	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_image_opacity',
			'default'           => '0',
			'sanitize_callback' => 'THEMENAME_sanitize_number_range',
			'label'             => esc_html__( 'Header Media Overlay', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_text_alignment',
			'default'           => 'text-align-left',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'choices'           => array(
				'text-align-center' => esc_html__( 'Center', 'THEMENAME' ),
				'text-align-right'  => esc_html__( 'Right', 'THEMENAME' ),
				'text-align-left'   => esc_html__( 'Left', 'THEMENAME' ),
			),
			'label'             => esc_html__( 'Text Alignment', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_content_alignment',
			'default'           => 'content-align-right',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'choices'           => array(
				'content-align-center' => esc_html__( 'Center', 'THEMENAME' ),
				'content-align-right'  => esc_html__( 'Right', 'THEMENAME' ),
				'content-align-left'   => esc_html__( 'Left', 'THEMENAME' ),
			),
			'label'             => esc_html__( 'Content Alignment', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_logo',
			'sanitize_callback' => 'esc_url_raw',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Header Media Logo', 'THEMENAME' ),
			'section'           => 'header_image',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_logo_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'active_callback'   => 'THEMENAME_is_header_media_logo_active',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'THEMENAME' ),
				'entire-site'            => esc_html__( 'Entire Site', 'THEMENAME' ) ),
			'label'             => esc_html__( 'Enable Header Media logo on', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Tagline', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Site Header Text', 'THEMENAME' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'THEMENAME' ),
			'section'           => 'header_image',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'THEMENAME' ),
			'section'           => 'header_image',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_header_url_target',
			'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
			'label'             => esc_html__( 'Open Link in New Window/Tab', 'THEMENAME' ),
			'section'           => 'header_image',
			'custom_control'    => 'THEMENAME_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'THEMENAME_header_media_options' );

/** Active Callback Functions */

if ( ! function_exists( 'THEMENAME_is_header_media_logo_active' ) ) :
	/**
	* Return true if header logo is active
	*
	* @since 1.0
	*/
	function THEMENAME_is_header_media_logo_active( $control ) {
		$logo = $control->manager->get_setting( 'THEMENAME_header_media_logo' )->value();
		if ( '' != $logo ) {
			return true;
		} else {
			return false;
		}
	}
endif;
