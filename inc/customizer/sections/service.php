<?php
/**
 * Services options
 *
 * @package MYTHEME
 */

/**
 * Add services content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function MYTHEME_service_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
    MYTHEME_register_option( $wp_customize, array(
            'name'              => 'MYTHEME_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'MYTHEME_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Services Options, go %1$shere%2$s', 'MYTHEME' ),
                '<a href="javascript:wp.customize.section( \'MYTHEME_service\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'services',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'MYTHEME_service', array(
			'title' => esc_html__( 'Services', 'MYTHEME' ),
			'panel' => 'MYTHEME_theme_options',
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
            'name'              => 'MYTHEME_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'MYTHEME_Note_Control',
            'active_callback'   => 'MYTHEME_is_ect_services_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Type Enabled', 'MYTHEME' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'MYTHEME_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_service_option',
			'default'           => 'disabled',
			'active_callback'   => 'MYTHEME_is_ect_services_active',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'choices'           => MYTHEME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'MYTHEME' ),
			'section'           => 'MYTHEME_service',
			'type'              => 'select',
		)
	);

    MYTHEME_register_option( $wp_customize, array(
            'name'              => 'MYTHEME_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'MYTHEME_Note_Control',
            'active_callback'   => 'MYTHEME_is_services_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'MYTHEME' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'MYTHEME_service',
            'type'              => 'description',
        )
    );

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_service_number',
			'default'           => 4,
			'sanitize_callback' => 'MYTHEME_sanitize_number_range',
			'active_callback'   => 'MYTHEME_is_services_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Services is changed (Max no of Services is 20)', 'MYTHEME' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of items', 'MYTHEME' ),
			'section'           => 'MYTHEME_service',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$number = get_theme_mod( 'MYTHEME_service_number', 4 );

	//loop for services post content
	for ( $i = 1; $i <= $number ; $i++ ) {
		MYTHEME_register_option( $wp_customize, array(
				'name'              => 'MYTHEME_service_cpt_' . $i,
				'sanitize_callback' => 'MYTHEME_sanitize_post',
				'active_callback'   => 'MYTHEME_is_services_active',
				'label'             => esc_html__( 'Services', 'MYTHEME' ) . ' ' . $i ,
				'section'           => 'MYTHEME_service',
				'type'              => 'select',
                'choices'           => MYTHEME_generate_post_array( 'ect-service' ),
			)
		);

	} // End for().
}
add_action( 'customize_register', 'MYTHEME_service_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'MYTHEME_is_services_active' ) ) :
	/**
	* Return true if services content is active
	*
	* @since MYTHEME 1.0
	*/
	function MYTHEME_is_services_active( $control ) {
		$enable = $control->manager->get_setting( 'MYTHEME_service_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( MYTHEME_is_ect_services_active( $control ) && MYTHEME_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'MYTHEME_is_ect_services_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since MYTHEME 1.0
    */
    function MYTHEME_is_ect_services_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'MYTHEME_is_ect_services_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since MYTHEME 1.0
    */
    function MYTHEME_is_ect_services_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
