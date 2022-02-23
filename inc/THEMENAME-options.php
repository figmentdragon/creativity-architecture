<?php
/**
 * Theme Options
 *
 * @package THEMENAME
 */
 
 /**
  * Add theme options
  *
  * @param WP_Customize_Manager $wp_customize Theme Customizer object.
  */
 function THEMENAME_theme_options( $wp_customize ) {
 	$wp_customize->add_panel( 'THEMENAME_theme_options', array(
 		'title'    => esc_html__( 'Theme Options', 'THEMENAME' ),
 		'priority' => 130,
 	) );
 	THEMENAME_register_option( $wp_customize,
  array(
 			'name'              => 'THEMENAME_latest_posts_title',
 			'default'           => esc_html__( 'News', 'THEMENAME' ),
 			'sanitize_callback' => 'wp_kses_post',
 			'label'             => esc_html__( 'Latest Posts Title', 'THEMENAME' ),
 			'section'           => 'THEMENAME_theme_options',
 		)
 	);

 	// Layout Options
 	$wp_customize->add_section( 'THEMENAME_layout_options', array(
 		'title' => esc_html__( 'Layout Options', 'THEMENAME' ),
 		'panel' => 'THEMENAME_theme_options',
 		)
 	);

 	/* Default Layout */
 	THEMENAME_register_option( $wp_customize,
  array(
 			'name'              => 'THEMENAME_default_layout',
 			'default'           => 'right-sidebar',
 			'sanitize_callback' => 'THEMENAME_sanitize_select',
 			'label'             => esc_html__( 'Default Layout', 'THEMENAME' ),
 			'section'           => 'THEMENAME_layout_options',
 			'type'              => 'radio',
 			'choices'           => array(
 				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'THEMENAME' ),
 				'no-sidebar'            => esc_html__( 'No Sidebar', 'THEMENAME' ),
 			),
 		)
 	);

 	/* Homepage/Archive Layout */
 	THEMENAME_register_option( $wp_customize, array(
 			'name'              => 'THEMENAME_homepage_archive_layout',
 			'default'           => 'right-sidebar',
 			'sanitize_callback' => 'THEMENAME_sanitize_select',
 			'label'             => esc_html__( 'Homepage/Archive Layout', 'THEMENAME' ),
 			'section'           => 'THEMENAME_layout_options',
 			'type'              => 'radio',
 			'choices'           => array(
 				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'THEMENAME' ),
 				'no-sidebar'            => esc_html__( 'No Sidebar', 'THEMENAME' ),
 			),
 		)
 	);

 	// Excerpt Options.
 	$wp_customize->add_section( 'THEMENAME_excerpt_options',
   array(
 		'panel'     => 'THEMENAME_theme_options',
 		'title'     => esc_html__( 'Excerpt Options', 'THEMENAME' ),
 	) );
 	THEMENAME_register_option( $wp_customize, array(
 			'name'              => 'THEMENAME_excerpt_length',
 			'default'           => '20',
 			'sanitize_callback' => 'absint',
 			'input_attrs' => array(
 				'min'   => 10,
 				'max'   => 200,
 				'step'  => 5,
 				'style' => 'width: 60px;',
 			),
 			'label'    => esc_html__( 'Excerpt Length (words)', 'THEMENAME' ),
 			'section'  => 'THEMENAME_excerpt_options',
 			'type'     => 'number',
 		)
 	);
 	THEMENAME_register_option( $wp_customize, array(
 			'name'              => 'THEMENAME_excerpt_more_text',
 			'default'           => esc_html__( 'Continue reading', 'THEMENAME' ),
 			'sanitize_callback' => 'sanitize_text_field',
 			'label'             => esc_html__( 'Read More Text', 'THEMENAME' ),
 			'section'           => 'THEMENAME_excerpt_options',
 			'type'              => 'text',
 		)
 	);

 	// Excerpt Options.
 	$wp_customize->add_section( 'THEMENAME_search_options', array(
 		'panel'     => 'THEMENAME_theme_options',
 		'title'     => esc_html__( 'Search Options', 'THEMENAME' ),
 	) );
 	THEMENAME_register_option( $wp_customize, array(
 			'name'              => 'THEMENAME_search_text',
 			'default'           => esc_html__( 'Search', 'THEMENAME' ),
 			'sanitize_callback' => 'sanitize_text_field',
 			'label'             => esc_html__( 'Search Text', 'THEMENAME' ),
 			'section'           => 'THEMENAME_search_options',
 			'type'              => 'text',
 		)
 	);

 	// Homepage / Frontpage Options.
 	$wp_customize->add_section( 'THEMENAME_homepage_options', array(
 		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'THEMENAME' ),
 		'panel'       => 'THEMENAME_theme_options',
 		'title'       => esc_html__( 'Homepage / Frontpage Options', 'THEMENAME' ),
 	) );
 	THEMENAME_register_option( $wp_customize, array(
 			'name'              => 'THEMENAME_static_page_heading',
 			'sanitize_callback' => 'sanitize_text_field',
 			'active_callback'	=> 'THEMENAME_is_static_page_enabled',
 			'default'           => esc_html__( 'Archives', 'THEMENAME' ),
 			'label'             => esc_html__( 'Posts Page Header Text', 'THEMENAME' ),
 			'section'           => 'THEMENAME_homepage_options',
 		)
 	);
 	THEMENAME_register_option( $wp_customize, array(
 			'name'              => 'THEMENAME_front_page_category',
 			'sanitize_callback' => 'THEMENAME_sanitize_category_list',
 			'custom_control'    => 'THEMENAME_Multi_Cat',
 			'label'             => esc_html__( 'Categories', 'THEMENAME' ),
 			'section'           => 'THEMENAME_homepage_options',
 			'type'              => 'dropdown-categories',
 		)
 	);

 	// Pagination Options.
 	$pagination_type = get_theme_mod( 'THEMENAME_pagination_type', 'default' );
 	$nav_desc = '';

 	/**
 	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
 	*/
 	$nav_desc = sprintf(
 		wp_kses(
 			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'THEMENAME' ),
 			array(
 				'a' => array(
 					'href' => array(),
 					'target' => array(),
 				),
 				'br'=> array()
 			)
 		),
 		'<a target="_blank" href="https://wordpress.org/plugins/catch-infinite-scroll/">',
 		'</a>'
 	);

 	$wp_customize->add_section( 'THEMENAME_pagination_options', array(
 		'description'     => $nav_desc,
 		'panel'           => 'THEMENAME_theme_options',
 		'title'           => esc_html__( 'Pagination Options', 'THEMENAME' ),
 		'active_callback' => 'THEMENAME_scroll_plugins_inactive'
 	) );
 	THEMENAME_register_option( $wp_customize, array(
 			'name'              => 'THEMENAME_pagination_type',
 			'default'           => 'default',
 			'sanitize_callback' => 'THEMENAME_sanitize_select',
 			'choices'           => THEMENAME_get_pagination_types(),
 			'label'             => esc_html__( 'Pagination type', 'THEMENAME' ),
 			'section'           => 'THEMENAME_pagination_options',
 			'type'              => 'select',
 		)
 	);

 	// For WooCommerce layout: THEMENAME_woocommerce_layout, check woocommerce-options.php.
 	/* Scrollup Options */
  $wp_customize->add_section( 'THEMENAME_scrollup',
  array(
    'panel'    => 'THEMENAME_theme_options',
 		'title'    => esc_html__( 'Scrollup Options', 'THEMENAME' ),
    )
  );

 	$action = 'install-plugin';
 	$slug   = 'to-top';

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

 	// Add note to Scroll up Section
  THEMENAME_register_option( $wp_customize,
  array(
    'name'              => 'THEMENAME_to_top_note',
    'sanitize_callback' => 'sanitize_text_field',
    'custom_control'    => 'THEMENAME_Note_Control',
    'active_callback'   => 'THEMENAME_is_to_top_inactive',
     /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
    'label'             => sprintf( esc_html__( 'For Scroll Up, install %1$sTo Top%2$s Plugin', 'THEMENAME' ),
    '<a target="_blank" href="" . esc_url( $install_url ) . "" ></a>'
  ),
    'section'            => 'THEMENAME_scrollup',
    'type'              => 'description',
    'priority'          => 1,
  ));
 }
 add_action( 'customize_register', 'THEMENAME_theme_options' );

 /**
  * Returns an array of avaliable fonts registered for THEMENAME
  *
  * @since THEMENAME 1.0
  */
 function THEMENAME_avaliable_fonts() {
 	$avaliable_fonts = array(
 		'arial-black' => array(
 			'value' => 'arial-black',
 			'label' => '"Arial Black", Gadget, sans-serif',
 		),
 		'allan' => array(
 			'value' => 'allan',
 			'label' => '"Allan", sans-serif',
 		),
 		'allerta' => array(
 			'value' => 'allerta',
 			'label' => '"Allerta", sans-serif',
 		),
 		'amaranth' => array(
 			'value' => 'amaranth',
 			'label' => '"Amaranth", sans-serif',
 		),
 		'amatic-sc' => array(
 			'value' => 'amatic-sc',
 			'label' => '"Amatic SC", cursive',
 		),
 		'arial' => array(
 			'value' => 'arial',
 			'label' => 'Arial, Helvetica, sans-serif',
 		),
 		'bitter' => array(
 			'value' => 'bitter',
 			'label' => '"Bitter", sans-serif',
 		),
 		'cabin' => array(
 			'value' => 'cabin',
 			'label' => '"Cabin", sans-serif',
 		),
 		'cantarell' => array(
 			'value' => 'cantarell',
 			'label' => '"Cantarell", sans-serif',
 		),
 		'century-gothic' => array(
 			'value' => 'century-gothic',
 			'label' => '"Century Gothic", sans-serif',
 		),
 		'courier-new' => array(
 			'value' => 'courier-new',
 			'label' => '"Courier New", Courier, monospace',
 		),
 		'courgette' => array(
 			'value' => 'courgette',
 			'label' => '"Courgette", cursive',
 		),
 		'crimson-text' => array(
 			'value' => 'crimson-text',
 			'label' => '"Crimson Text", sans-serif',
 		),
 		'cuprum' => array(
 			'value' => 'cuprum',
 			'label' => '"Cuprum", sans-serif',
 		),
 		'dancing-script' => array(
 			'value' => 'dancing-script',
 			'label' => '"Dancing Script", sans-serif',
 		),
 		'droid-sans' => array(
 			'value' => 'droid-sans',
 			'label' => '"Droid Sans", sans-serif',
 		),
 		'droid-serif' => array(
 			'value' => 'droid-serif',
 			'label' => '"Droid Serif", sans-serif',
 		),
 		'exo' => array(
 			'value' => 'exo',
 			'label' => '"Exo", sans-serif',
 		),
 		'exo-2' => array(
 			'value' => 'exo-2',
 			'label' => '"Exo 2", sans-serif',
 		),
 		'georgia' => array(
 			'value' => 'georgia',
 			'label' => 'Georgia, "Times New Roman", Times, serif',
 		),
 		'helvetica' => array(
 			'value' => 'helvetica',
 			'label' => 'Helvetica, "Helvetica Neue", Arial, sans-serif',
 		),
 		'helvetica-neue' => array(
 			'value' => 'helvetica-neue',
 			'label' => '"Helvetica Neue",Helvetica,Arial,sans-serif',
 		),
 		'istok-web' => array(
 			'value' => 'istok-web',
 			'label' => '"Istok Web", sans-serif',
 		),
 		'impact' => array(
 			'value' => 'impact',
 			'label' => 'Impact, Charcoal, sans-serif',
 		),
 		'josefin-sans' => array(
 			'value' => 'josefin-sans',
 			'label' => '"Josefin Sans", sans-serif',
 		),
 		'lato' => array(
 			'value' => 'lato',
 			'label' => '"Lato", sans-serif',
 		),
 		'lucida-sans-unicode' => array(
 			'value' => 'lucida-sans-unicode',
 			'label' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
 		),
 		'lucida-grande' => array(
 			'value' => 'lucida-grande',
 			'label' => '"Lucida Grande", "Lucida Sans Unicode", sans-serif',
 		),
 		'lobster' => array(
 			'value' => 'lobster',
 			'label' => '"Lobster", sans-serif',
 		),
 		'lora' => array(
 			'value' => 'lora',
 			'label' => '"Lora", serif',
 		),
 		'monaco' => array(
 			'value' => 'monaco',
 			'label' => 'Monaco, Consolas, "Lucida Console", monospace, sans-serif',
 		),
 		'muli' => array(
 			'value' => 'muli',
 			'label' => 'Muli, sans-serif',
 		),
 		'mrs-saint-delafield' => array(
 			'value' => 'mrs-saint-delafield',
 			'label' => '"Mrs Saint Delafield", cursive',
 		),
 		'montserrat' => array(
 			'value' => 'montserrat',
 			'label' => '"Montserrat", sans-serif',
 		),
 		'nobile' => array(
 			'value' => 'nobile',
 			'label' => '"Nobile", sans-serif',
 		),
 		'noto-serif' => array(
 			'value' => 'noto-serif',
 			'label' => '"Noto Serif", serif',
 		),
 		'neuton' => array(
 			'value' => 'neuton',
 			'label' => '"Neuton", serif',
 		),
 		'open-sans' => array(
 			'value' => 'open-sans',
 			'label' => '"Open Sans", sans-serif',
 		),
 		'oswald' => array(
 			'value' => 'oswald',
 			'label' => '"Oswald", sans-serif',
 		),
 		'palatino' => array(
 			'value' => 'palatino',
 			'label' => 'Palatino, "Palatino Linotype", "Book Antiqua", serif',
 		),
 		'patua-one' => array(
 			'value' => 'patua-one',
 			'label' => '"Patua One", sans-serif',
 		),
 		'poppins' => array(
 			'value' => 'poppins',
 			'label' => '"Poppins", sans-serif',
 		),
 		'playfair-display' => array(
 			'value' => 'playfair-display',
 			'label' => '"Playfair Display", sans-serif',
 		),
 		'pt-sans' => array(
 			'value' => 'pt-sans',
 			'label' => '"PT Sans", sans-serif',
 		),
 		'pt-serif' => array(
 			'value' => 'pt-serif',
 			'label' => '"PT Serif", serif',
 		),
 		'quattrocento-sans' => array(
 			'value' => 'quattrocento-sans',
 			'label' => '"Quattrocento Sans", sans-serif',
 		),
 		'roboto' => array(
 			'value' => 'roboto',
 			'label' => '"Roboto", sans-serif',
 		),
 		'roboto-slab' => array(
 			'value' => 'roboto-slab',
 			'label' => '"Roboto Slab", serif',
 		),
 		'raleway' => array(
 			'value' => 'raleway',
 			'label' => '"Raleway", sans-serif',
 		),
 		'rubik' => array(
 			'value' => 'rubik',
 			'label' => '"Rubik", serif',
 		),
 		'sans-serif' => array(
 			'value' => 'sans-serif',
 			'label' => 'Sans Serif, Arial',
 		),
 		'source-sans-pro' => array(
 			'value' => 'source-sans-pro',
 			'label' => '"Source Sans Pro", sans-serif',
 		),
 		'tahoma' => array(
 			'value' => 'tahoma',
 			'label' => 'Tahoma, Geneva, sans-serif',
 		),
 		'trebuchet-ms' => array(
 			'value' => 'trebuchet-ms',
 			'label' => '"Trebuchet MS", "Helvetica", sans-serif',
 		),
 		'times-new-roman' => array(
 			'value' => 'times-new-roman',
 			'label' => '"Times New Roman", Times, serif',
 		),
 		'ubuntu' => array(
 			'value' => 'ubuntu',
 			'label' => '"Ubuntu", sans-serif',
 		),
 		'varela' => array(
 			'value' => 'varela',
 			'label' => '"Varela", sans-serif',
 		),
 		'verdana' => array(
 			'value' => 'verdana',
 			'label' => 'Verdana, Geneva, sans-serif',
 		),
 		'yanone-kaffeesatz' => array(
 			'value' => 'yanone-kaffeesatz',
 			'label' => '"Yanone Kaffeesatz", sans-serif',
 		),
 	);

 	return apply_filters( 'THEMENAME_avaliable_fonts', $avaliable_fonts );
 }

 /** Active Callback Functions */

 if ( ! function_exists( 'THEMENAME_scroll_plugins_inactive' ) ) :
 	/**
 	* Return true if infinite scroll functionality exists
 	*
 	* @since THEMENAME 1.0
 	*/
 	function THEMENAME_scroll_plugins_inactive( $control ) {
 		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
 			// Support infinite scroll plugins.
 			return false;
 		}

 		return true;
 	}
 endif;

 if ( ! function_exists( 'THEMENAME_is_static_page_enabled' ) ) :
 	/**
 	* Return true if A Static Page is enabled
 	*
 	* @since THEMENAME 1.1.2
 	*/
 	function THEMENAME_is_static_page_enabled( $control ) {
 		$enable = $control->manager->get_setting( 'show_on_front' )->value();
 		if ( 'page' === $enable ) {
 			return true;
 		}
 		return false;
 	}
 endif;

 if ( ! function_exists( 'THEMENAME_is_to_top_inactive' ) ) :
     /**
     * Return true if featured_content is active
     *
     * @since Simclick 0.1
     */
     function THEMENAME_is_to_top_inactive( $control ) {
         return ! ( class_exists( 'To_Top' ) );
     }
 endif;
