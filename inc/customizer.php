<?php
/**
 * MYTHEME: Customizer
 *
 * @package MYTHEME
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function MYTHEME_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'MYTHEME_theme_options',
		array(
			'title'    => esc_html__( 'Theme Options', 'MYTHEME' ),
			'priority' => 125,
		)
	);

	$wp_customize->add_setting( 'copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control( 'copyright_text',
		array(
			'label'   => esc_html__( 'Add copyright text in the footer.', 'MYTHEME' ),
			'section' => 'MYTHEME_theme_options',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting( 'text-color',
		array(
			'default'           => '#eaeaea',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
			'text-color',
			array(
				'label'    => esc_html__( 'General text color', 'MYTHEME' ),
				'section'  => 'colors',
				'settings' => 'text-color',
				'priority' => 8,
			)
		)
	);

	$wp_customize->add_setting( 'menu-links',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'menu-links',
			array(
				'label'    => esc_html__( 'Menu links', 'MYTHEME' ),
				'section'  => 'colors',
				'settings' => 'menu-links',
				'priority' => 10,
			)
		)
	);

	$wp_customize->add_setting( 'secondary-color',
		array(
			'default'           => '#f44336',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
			'secondary-color',
			array(
				'label'    => esc_html__( 'Change the theme red color throughout', 'MYTHEME' ),
				'section'  => 'colors',
				'settings' => 'secondary-color',
				'priority' => 12,
			)
		)
	);

	$wp_customize->add_setting( 'title-color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'title-color',
			array(
				'label'    => esc_html__( 'Titles color', 'MYTHEME' ),
				'section'  => 'colors',
				'settings' => 'title-color',
				'priority' => 14,
			)
		)
	);
}


function MYTHEME_customizer_css() {
	?>
	<style type="text/css">
		body {
			color: <?php echo esc_html( get_theme_mod( 'text-color', '#eaeaea' ) ); ?>;
		}
		.mainmenu ul li a {
			color: <?php echo esc_html( get_theme_mod( 'menu-links', '#ffffff' ) ); ?>;
		}
		.mainmenu ul li a:after, .error404 #searchform input#searchsubmit, .pagination a:hover, .pagination span.current, .search .search__button, .wpcf7 input.wpcf7-submit, #submit {
			background: <?php echo esc_html( get_theme_mod( 'secondary-color', '#f44336' ) ); ?>;
		}

		.button__link {
			background-color: <?php echo esc_html( get_theme_mod( 'secondary-color', '#f44336' ) ); ?>;
		}
		.wpcf7 label span.required {
			color: <?php echo esc_html( get_theme_mod( 'secondary-color', '#f44336' ) ); ?>;
		}
		h1, h2, h3, h4, h5, h6, h1.page-title, h1.entry-title, h2.entry-title, h2.entry-title a, #respond h3, #comments h2 {
			color: <?php echo esc_html( get_theme_mod( 'title-color', '#ffffff' ) ); ?>;
		}
	</style>
	<?php
}

function MYTHEME_customize_preview_js() {
	wp_enqueue_script( 'MYTHEME_customizer', get_template_directory_uri() . '/assets/scripts/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}

