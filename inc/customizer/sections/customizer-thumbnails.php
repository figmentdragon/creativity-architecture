<?php
/**
 * Thumbnail Settings
 * Register Thumbnails section, settings and controls for the Theme Customizer
 * Settings and controls to manage image thumbnail cropping
 *
 * @package MYTHEME
 */

/**
 * Adds all layout settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function MYTHEME_customize_register_thumbnail_settings( $wp_customize ) {

	// Add Section for Theme Options.
	$wp_customize->add_section( 'MYTHEME_section_thumbnails', array(
		'title'    => esc_html__( 'Thumbnail Settings', 'MYTHEME' ),
		'priority' => 50,
		'panel'    => 'MYTHEME_options_panel',
	) );

	// Add Featured Images Headline.
	$wp_customize->add_control( new MYTHEME_Customize_Header_Control(
		$wp_customize, 'MYTHEME_theme_options[crop_featured_images]', array(
		'label' => esc_html__( 'Crop Blog Featured Images', 'MYTHEME' ),
		'section' => 'MYTHEME_section_thumbnails',
		'settings' => array(),
		)
	) );
	
	// Add Setting and Control for cropping the recent posts thumbnails
	$wp_customize->add_setting( 'MYTHEME_crop_recent', array(
		'default'           => false,
		'sanitize_callback' => 'MYTHEME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'MYTHEME_crop_recent', array(
		'label'    => esc_html__( 'Crop images for the recent posts thumbnails.', 'MYTHEME' ),
		'section'  => 'MYTHEME_section_thumbnails',
		'type'     => 'checkbox',
	) );	
	
	// Add Setting and Control for cropping Large featured images on blog and archives.
	$wp_customize->add_setting( 'MYTHEME_crop_large_featured', array(
		'default'           => false,
		'sanitize_callback' => 'MYTHEME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'MYTHEME_crop_large_featured', array(
		'label'    => esc_html__( 'Crop featured images for the large blog Layout', 'MYTHEME' ),
		'section'  => 'MYTHEME_section_thumbnails',
		'type'     => 'checkbox',
	) );	
	
}
add_action( 'customize_register', 'MYTHEME_customize_register_thumbnail_settings' );
