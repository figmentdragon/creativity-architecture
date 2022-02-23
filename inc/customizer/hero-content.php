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
function THEMENAME_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'THEMENAME_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'THEMENAME' ),
			'panel' => 'THEMENAME_theme_options',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'choices'           => THEMENAME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'select',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'THEMENAME_sanitize_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_content_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Sub Headline', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'textarea',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_experience_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Experience Title', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_date_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Date 1', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_experience_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 1', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_date_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Date 2', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_experience_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 2', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_date_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Date 3', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_experience_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 3', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_date_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Date 4', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_hero_experience_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'THEMENAME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 4', 'THEMENAME' ),
			'section'           => 'THEMENAME_hero_content_options',
			'type'              => 'text',
		)
	);

}
add_action( 'customize_register', 'THEMENAME_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'THEMENAME_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since 1.0
	*/
	function THEMENAME_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'THEMENAME_hero_content_visibility' )->value();

		return THEMENAME_check_section( $enable );
	}
endif;
