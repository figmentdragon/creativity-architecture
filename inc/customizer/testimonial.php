<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function THEMENAME_testimonial_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_jetpack_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'THEMENAME_Note_Control',
			'label'             => sprintf( esc_html__( 'For Testimonial Options for Theme, go %1$shere%2$s', 'THEMENAME' ),
				'<a href="javascript:wp.customize.section( \'THEMENAME_testimonials\' ).focus();">',
				 '</a>'
			),
		   'section'            => 'jetpack_testimonials',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'THEMENAME_testimonials', array(
			'panel'    => 'THEMENAME_theme_options',
			'title'    => esc_html__( 'Testimonials', 'THEMENAME' ),
		)
	);

	$action = 'install-plugin';
    $slug   = 'essential-content-types';

    $install_url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => $action,
                'plugin' => $slug
            ),
            admin_url( 'update.php' )
        ),
        $action . '_' . $slug
    );

    THEMENAME_register_option( $wp_customize, array(
            'name'              => 'THEMENAME_testimonial_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'THEMENAME_Note_Control',
            'active_callback'   => 'THEMENAME_is_ect_testimonial_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with testimonial Type Enabled', 'THEMENAME' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'THEMENAME_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_testimonial_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'THEMENAME_sanitize_select',
			'active_callback'   => 'THEMENAME_is_ect_testimonial_active',
			'choices'           => THEMENAME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'THEMENAME' ),
			'section'           => 'THEMENAME_testimonials',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'THEMENAME_Note_Control',
			'active_callback'   => 'THEMENAME_is_testimonial_active',
			/* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'THEMENAME' ),
				'<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
				'</a>'
			),
			'section'           => 'THEMENAME_testimonials',
			'type'              => 'description',
		)
	);

	THEMENAME_register_option( $wp_customize, array(
			'name'              => 'THEMENAME_testimonial_number',
			'default'           => '3',
			'sanitize_callback' => 'THEMENAME_sanitize_number_range',
			'active_callback'   => 'THEMENAME_is_testimonial_active',
			'label'             => esc_html__( 'Number of items', 'THEMENAME' ),
			'section'           => 'THEMENAME_testimonials',
			'type'              => 'number',
			'input_attrs'       => array(
				'style'             => 'width: 100px;',
				'min'               => 0,
			),
		)
	);

	$number = get_theme_mod( 'THEMENAME_testimonial_number', 3 );

	for ( $i = 1; $i <= $number ; $i++ ) {

		//for CPT
		THEMENAME_register_option( $wp_customize, array(
				'name'              => 'THEMENAME_testimonial_cpt_' . $i,
				'sanitize_callback' => 'THEMENAME_sanitize_post',
				'active_callback'   => 'THEMENAME_is_testimonial_active',
				'label'             => esc_html__( 'Testimonial', 'THEMENAME' ) . ' ' . $i ,
				'section'           => 'THEMENAME_testimonials',
				'type'              => 'select',
				'choices'           => THEMENAME_generate_post_array( 'jetpack-testimonial' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'THEMENAME_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'THEMENAME_is_testimonial_active' ) ) :
	/**
	* Return true if testimonial is active
	*
	* @since 1.0
	*/
	function THEMENAME_is_testimonial_active( $control ) {
		$enable = $control->manager->get_setting( 'THEMENAME_testimonial_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( THEMENAME_is_ect_testimonial_active( $control ) && THEMENAME_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'THEMENAME_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since 1.0
    */
    function THEMENAME_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;

if ( ! function_exists( 'THEMENAME_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since 1.0
    */
    function THEMENAME_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;
