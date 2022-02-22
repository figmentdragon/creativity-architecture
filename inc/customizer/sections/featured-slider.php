<?php
/**
 * Featured Slider Options
 *
 * @package MYTHEME
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function MYTHEME_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'MYTHEME_featured_slider', array(
			'panel' => 'MYTHEME_theme_options',
			'title' => esc_html__( 'Featured Slider', 'MYTHEME' ),
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'choices'           => MYTHEME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'MYTHEME' ),
			'section'           => 'MYTHEME_featured_slider',
			'type'              => 'select',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'MYTHEME_sanitize_number_range',

			'active_callback'   => 'MYTHEME_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'MYTHEME' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'MYTHEME' ),
			'section'           => 'MYTHEME_featured_slider',
			'type'              => 'number',
		)
	);

	$slider_number = get_theme_mod( 'MYTHEME_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {

		MYTHEME_register_option( $wp_customize, array(
				'name'              => 'MYTHEME_slider_logo_image_' . $i,
				'sanitize_callback' => 'MYTHEME_sanitize_image',
				'custom_control'    => 'WP_Customize_Image_Control',
				'active_callback'   => 'MYTHEME_is_slider_active',
				'label'             => esc_html__( 'Logo Image #', 'MYTHEME' ) . $i,
				'section'           => 'MYTHEME_featured_slider',
			)
		);

		// Page Sliders
		MYTHEME_register_option( $wp_customize, array(
				'name'              => 'MYTHEME_slider_page_' . $i,
				'sanitize_callback' => 'MYTHEME_sanitize_post',
				'active_callback'   => 'MYTHEME_is_slider_active',
				'label'             => esc_html__( 'Page', 'MYTHEME' ) . ' # ' . $i,
				'section'           => 'MYTHEME_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'MYTHEME_slider_options' );

/** Active Callback Functions */

if ( ! function_exists( 'MYTHEME_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since MYTHEME 1.0
	*/
	function MYTHEME_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'MYTHEME_slider_option' )->value();

		//return true only if previwed page on customizer matches the type option selected
		return MYTHEME_check_section( $enable );
	}
endif;
