<?php
/**
 * Hero Content Options
 *
 * @package THEMENAME
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'hero_content_options', array(
			'title' => esc_html__( 'Hero Content', '__THEMENAE__' ),
			'panel' => 'theme_options',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'sanitize_select',
			'choices'           => section_visibility_options(),
			'label'             => esc_html__( 'Enable on', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'select',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_content',
			'default'           => '0',
			'sanitize_callback' => 'sanitize_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Page', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_content_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Sub Headline', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'textarea',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_experience_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Experience Title', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_date_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Date 1', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_experience_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Experience 1', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_date_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Date 2', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_experience_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Experience 2', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_date_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Date 3', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_experience_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Experience 3', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_date_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Date 4', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

	register_option( $wp_customize, array(
			'name'              => 'hero_experience_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'is_hero_content_active',
			'label'             => esc_html__( 'Experience 4', '__THEMENAE__' ),
			'section'           => 'hero_content_options',
			'type'              => 'text',
		)
	);

}
add_action( 'customize_register', 'hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since 1.0
	*/
	function is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'hero_content_visibility' )->value();

		return check_section( $enable );
	}
endif;
