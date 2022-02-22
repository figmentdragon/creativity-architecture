<?php
/**
 * Basic Settings
 *
 * Register Basic Settings section, settings and controls for Theme Customizer
 *
 * @package MYTHEME
 */

/**
 * Adds post settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function MYTHEME_customize_register_basic_settings( $wp_customize ) {

	$wp_customize->add_section( 'MYTHEME_section_basic', array(
			'title'    => esc_html__( 'Basic Settings', 'MYTHEME' ),
			'priority' => 8,
			'panel' => 'MYTHEME_options_panel',
		) );

	$wp_customize->add_setting( 'MYTHEME_copyright', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	 );

	$wp_customize->add_control( 'MYTHEME_copyright', array(
			'label'    => esc_html__( 'Copyright Name', 'MYTHEME' ),
			'section'  => 'MYTHEME_section_basic',
			'type'     => 'text',
		) );

	$wp_customize->add_setting( 'MYTHEME_attachment_comments', array(
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'MYTHEME_sanitize_checkbox',
		) );

	$wp_customize->add_control( 'MYTHEME_attachment_comments', array(
			'label'    => esc_html__( 'Enable Gallery View Comments', 'MYTHEME' ),
			'section'  => 'MYTHEME_section_basic',
			'type'     => 'checkbox',
		) );
	
	$wp_customize->add_setting( 'MYTHEME_default_google_fonts',array(
		'default'           => true,
		'description' 			=> esc_html__( 'This theme has a couple Google Fonts included. If you choose to use a plugin for different fonts, you can disable them.', 'MYTHEME' ),
		'sanitize_callback' => 'MYTHEME_sanitize_checkbox',
	)	);
}
add_action( 'customize_register', 'MYTHEME_customize_register_basic_settings' );

function MYTHEME_register_customize_header_control( $wp_customize ) {

$wp_customize->add_control( new MYTHEME_Customize_Header_Control(
	$wp_customize, 'MYTHEME_theme_options[basic_options]',array(
			'label' => esc_html__( 'WP Gallery Options', 'MYTHEME' ),
			'section' => 'MYTHEME_section_basic',
			'settings' => array(),
		) );

$wp_customize->add_control(	new MYTHEME_Customize_Header_Control(
		$wp_customize, 'MYTHEME_google_fonts_option', array(
			'label' => esc_html__( 'Default Google Font Option', 'MYTHEME' ),
			'section' => 'MYTHEME_section_basic',
			'settings' => array(),
		) );

$wp_customize->add_control( new	MYTHEME_Customize_Header_Control(
	$wp_customize, 'MYTHEME_default_google_fonts',.array(
		'label' => esc_html__( 'Default Google Fonts', 'MYTHEME' ),
		'section' => 'MYTHEME_section_basic',
		'settings' => array(),
	) );
}
add_action( 'customize_register', 'MYTHEME_register_customize_header_control' )
