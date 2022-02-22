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
function MYTHEME_testimonial_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_jetpack_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'MYTHEME_Note_Control',
			'label'             => sprintf( esc_html__( 'For Testimonial Options for Theme, go %1$shere%2$s', 'MYTHEME' ),
				'<a href="javascript:wp.customize.section( \'MYTHEME_testimonials\' ).focus();">',
				 '</a>'
			),
		   'section'            => 'jetpack_testimonials',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'MYTHEME_testimonials', array(
			'panel'    => 'MYTHEME_theme_options',
			'title'    => esc_html__( 'Testimonials', 'MYTHEME' ),
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

    MYTHEME_register_option( $wp_customize, array(
            'name'              => 'MYTHEME_testimonial_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'MYTHEME_Note_Control',
            'active_callback'   => 'MYTHEME_is_ect_testimonial_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with testimonial Type Enabled', 'MYTHEME' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'MYTHEME_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_testimonial_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'active_callback'   => 'MYTHEME_is_ect_testimonial_active',
			'choices'           => MYTHEME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'MYTHEME' ),
			'section'           => 'MYTHEME_testimonials',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'MYTHEME_Note_Control',
			'active_callback'   => 'MYTHEME_is_testimonial_active',
			/* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'MYTHEME' ),
				'<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
				'</a>'
			),
			'section'           => 'MYTHEME_testimonials',
			'type'              => 'description',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_testimonial_number',
			'default'           => '3',
			'sanitize_callback' => 'MYTHEME_sanitize_number_range',
			'active_callback'   => 'MYTHEME_is_testimonial_active',
			'label'             => esc_html__( 'Number of items', 'MYTHEME' ),
			'section'           => 'MYTHEME_testimonials',
			'type'              => 'number',
			'input_attrs'       => array(
				'style'             => 'width: 100px;',
				'min'               => 0,
			),
		)
	);

	$number = get_theme_mod( 'MYTHEME_testimonial_number', 3 );

	for ( $i = 1; $i <= $number ; $i++ ) {

		//for CPT
		MYTHEME_register_option( $wp_customize, array(
				'name'              => 'MYTHEME_testimonial_cpt_' . $i,
				'sanitize_callback' => 'MYTHEME_sanitize_post',
				'active_callback'   => 'MYTHEME_is_testimonial_active',
				'label'             => esc_html__( 'Testimonial', 'MYTHEME' ) . ' ' . $i ,
				'section'           => 'MYTHEME_testimonials',
				'type'              => 'select',
				'choices'           => MYTHEME_generate_post_array( 'jetpack-testimonial' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'MYTHEME_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'MYTHEME_is_testimonial_active' ) ) :
	/**
	* Return true if testimonial is active
	*
	* @since 1.0
	*/
	function MYTHEME_is_testimonial_active( $control ) {
		$enable = $control->manager->get_setting( 'MYTHEME_testimonial_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( MYTHEME_is_ect_testimonial_active( $control ) && MYTHEME_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'MYTHEME_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since 1.0
    */
    function MYTHEME_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;

if ( ! function_exists( 'MYTHEME_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since 1.0
    */
    function MYTHEME_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;
