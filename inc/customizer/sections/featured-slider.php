<?php
/**
 * Featured Slider Options
 *
 * @package THEMENAME
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function THEMENAME_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'THEMENAME_featured_slider', array(
			'panel' => 'THEMENAME_theme_options',
			'title' => esc_html__( 'Featured Slider', 'THEMENAME' ),
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'choices'           => THEMENAME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'THEMENAME' ),
			'section'           => 'THEMENAME_featured_slider',
			'type'              => 'select',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'THEMENAME_sanitize_number_range',

			'active_callback'   => 'THEMENAME_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'THEMENAME' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'THEMENAME' ),
			'section'           => 'THEMENAME_featured_slider',
			'type'              => 'number',
		)
	);

	$slider_number = get_theme_mod( 'THEMENAME_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {

		THEMENAME_register_option( $wp_customize, array(
				'name'              => 'THEMENAME_slider_logo_image_' . $i,
				'sanitize_callback' => 'THEMENAME_sanitize_image',
				'custom_control'    => 'WP_Customize_Image_Control',
				'active_callback'   => 'THEMENAME_is_slider_active',
				'label'             => esc_html__( 'Logo Image #', 'THEMENAME' ) . $i,
				'section'           => 'THEMENAME_featured_slider',
			)
		);

		// Page Sliders
		THEMENAME_register_option( $wp_customize, array(
				'name'              => 'THEMENAME_slider_page_' . $i,
				'sanitize_callback' => 'THEMENAME_sanitize_post',
				'active_callback'   => 'THEMENAME_is_slider_active',
				'label'             => esc_html__( 'Page', 'THEMENAME' ) . ' # ' . $i,
				'section'           => 'THEMENAME_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'THEMENAME_slider_options' );

/** Active Callback Functions */

if ( ! function_exists( 'THEMENAME_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since THEMENAME 1.0
	*/
	function THEMENAME_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'THEMENAME_slider_option' )->value();

		//return true only if previwed page on customizer matches the type option selected
		return THEMENAME_check_section( $enable );
	}
endif;
