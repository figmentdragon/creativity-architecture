<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package MYTHEME
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function MYTHEME_portfolio_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_jetpack_portfolio_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'MYTHEME_Note_Control',
			'label'             => sprintf( esc_html__( 'For Portfolio Options for MYTHEME Theme, go %1$shere%2$s', 'MYTHEME' ),
				 '<a href="javascript:wp.customize.section( \'MYTHEME_portfolio\' ).focus();">',
				 '</a>'
			),
			'section'           => 'jetpack_portfolio',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'MYTHEME_portfolio', array(
			'panel'    => 'MYTHEME_theme_options',
			'title'    => esc_html__( 'Portfolio', 'MYTHEME' ),
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
            'name'              => 'MYTHEME_portfolio_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'MYTHEME_Note_Control',
          	'active_callback'   => 'MYTHEME_is_ect_portfolio_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Type Enabled', 'MYTHEME' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'MYTHEME_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_portfolio_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'MYTHEME_sanitize_select',
			'active_callback'   => 'MYTHEME_is_ect_portfolio_active',
			'choices'           => MYTHEME_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'MYTHEME' ),
			'section'           => 'MYTHEME_portfolio',
			'type'              => 'select',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_portfolio_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'MYTHEME_Note_Control',
			'active_callback'   => 'MYTHEME_is_portfolio_active',
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'MYTHEME' ),
				 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
				 '</a>'
			),
			'section'           => 'MYTHEME_portfolio',
			'type'              => 'description',
		)
	);

	MYTHEME_register_option( $wp_customize, array(
			'name'              => 'MYTHEME_portfolio_number',
			'default'           => 6,
			'sanitize_callback' => 'MYTHEME_sanitize_number_range',
			'active_callback'   => 'MYTHEME_is_portfolio_active',
			'label'             => esc_html__( 'Number of items to show', 'MYTHEME' ),
			'section'           => 'MYTHEME_portfolio',
			'type'              => 'number',
			'input_attrs'       => array(
				'style'             => 'width: 100px;',
				'min'               => 0,
			),
		)
	);

	$number = get_theme_mod( 'MYTHEME_portfolio_number', 6 );

	for ( $i = 1; $i <= $number ; $i++ ) {
		//for CPT
		MYTHEME_register_option( $wp_customize, array(
				'name'              => 'MYTHEME_portfolio_cpt_' . $i,
				'sanitize_callback' => 'MYTHEME_sanitize_post',
				'active_callback'   => 'MYTHEME_is_portfolio_active',
				'label'             => esc_html__( 'Portfolio', 'MYTHEME' ) . ' ' . $i ,
				'section'           => 'MYTHEME_portfolio',
				'type'              => 'select',
				'choices'           => MYTHEME_generate_post_array( 'jetpack-portfolio' ),
			)
		);


	} // End for().

}
add_action( 'customize_register', 'MYTHEME_portfolio_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'MYTHEME_is_portfolio_active' ) ) :
	/**
	* Return true if portfolio is active
	*
	* @since MYTHEME 1.0
	*/
	function MYTHEME_is_portfolio_active( $control ) {
		$enable = $control->manager->get_setting( 'MYTHEME_portfolio_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( MYTHEME_is_ect_portfolio_active( $control ) && MYTHEME_check_section( $enable ) );
	}
endif;


if ( ! function_exists( 'MYTHEME_is_ect_portfolio_inactive' ) ) :
    /**
    *
    * @since MYTHEME 1.0
    */
    function MYTHEME_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'MYTHEME_is_ect_portfolio_active' ) ) :
    /**
    *
    * @since MYTHEME 1.0
    */
    function MYTHEME_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;
