<?php
/**
 * Hero Content Options
 *
 * @package MYTHEME
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function MYTHEME_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'MYTHEME_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'MYTHEME' ),
			'panel' => 'MYTHEME_theme_options',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'choices'           => MYTHEME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'select',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'MYTHEME_sanitize_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_content_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Sub Headline', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'textarea',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_experience_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Experience Title', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_date_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Date 1', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_experience_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 1', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_date_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Date 2', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_experience_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 2', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_date_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Date 3', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_experience_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 3', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_date_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Date 4', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_hero_experience_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'MYTHEME_is_hero_content_active',
			'label'             => esc_html__( 'Experience 4', 'MYTHEME' ),
			'section'           => 'MYTHEME_hero_content_options',
			'type'              => 'text',
		)
	);

}
add_action( 'customize_register', 'MYTHEME_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'MYTHEME_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since MYTHEME 1.0
	*/
	function MYTHEME_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'MYTHEME_hero_content_visibility' )->value();

		return MYTHEME_check_section( $enable );
	}
endif;
