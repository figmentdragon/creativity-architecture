<?php
/**
 * Basic Settings
 *
 * Register Basic Settings section, settings and controls for Theme Customizer
 *
 * @package THEMENAME
 */

/**
 * Adds post settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function THEMENAME_customize_register_basic_settings( $wp_customize ) {

	$wp_customize->add_section( 'THEMENAME_section_basic', array(
			'title'    => esc_html__( 'Basic Settings', 'THEMENAME' ),
			'priority' => 8,
			'panel' => 'THEMENAME_options_panel',
		) );

	$wp_customize->add_setting( 'THEMENAME_copyright', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	 );

	$wp_customize->add_control( 'THEMENAME_copyright', array(
			'label'    => esc_html__( 'Copyright Name', 'THEMENAME' ),
			'section'  => 'THEMENAME_section_basic',
			'type'     => 'text',
		) );

	$wp_customize->add_setting( 'THEMENAME_attachment_comments', array(
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
		) );

	$wp_customize->add_control( 'THEMENAME_attachment_comments', array(
			'label'    => esc_html__( 'Enable Gallery View Comments', 'THEMENAME' ),
			'section'  => 'THEMENAME_section_basic',
			'type'     => 'checkbox',
		) );
	
	$wp_customize->add_setting( 'THEMENAME_default_google_fonts',array(
		'default'           => true,
		'description' 			=> esc_html__( 'This theme has a couple Google Fonts included. If you choose to use a plugin for different fonts, you can disable them.', 'THEMENAME' ),
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	)	);
}
add_action( 'customize_register', 'THEMENAME_customize_register_basic_settings' );

function THEMENAME_register_customize_header_control( $wp_customize ) {

$wp_customize->add_control( new THEMENAME_Customize_Header_Control(
	$wp_customize, 'THEMENAME_theme_options[basic_options]',array(
			'label' => esc_html__( 'WP Gallery Options', 'THEMENAME' ),
			'section' => 'THEMENAME_section_basic',
			'settings' => array(),
		) );

$wp_customize->add_control(	new THEMENAME_Customize_Header_Control(
		$wp_customize, 'THEMENAME_google_fonts_option', array(
			'label' => esc_html__( 'Default Google Font Option', 'THEMENAME' ),
			'section' => 'THEMENAME_section_basic',
			'settings' => array(),
		) );

$wp_customize->add_control( new	THEMENAME_Customize_Header_Control(
	$wp_customize, 'THEMENAME_default_google_fonts',.array(
		'label' => esc_html__( 'Default Google Fonts', 'THEMENAME' ),
		'section' => 'THEMENAME_section_basic',
		'settings' => array(),
	) );
}
add_action( 'customize_register', 'THEMENAME_register_customize_header_control' )
