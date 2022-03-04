<?php
/**
 * Themes functions and definitions
 *
 * @package andre
 */

// This theme requires WordPress 5.6 or later.

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function setup() {
	global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width = 1600;
	}

	load_theme_textdomain( '', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-logo' );

	add_theme_support( 'responsive-embeds' );

	add_post_type_support( 'page', 'excerpt' );

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'align-wide' );

	add_theme_support( 'html5', array( 'gallery', 'caption' ) );

	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => esc_html__( 'Small', 'THEMENAE' ),
				'size' => 13,
				'slug' => 'small',
			),
			array(
				'name' => esc_html__( 'Regular', 'THEMENAE' ),
				'size' => 17,
				'slug' => 'regular',
			),
			array(
				'name' => esc_html__( 'Medium', 'THEMENAE' ),
				'size' => 26,
				'slug' => 'medium',
			),
			array(
				'name' => esc_html__( 'Large', 'THEMENAE' ),
				'size' => 36,
				'slug' => 'large',
			),
			array(
				'name' => esc_html__( 'Huge', 'THEMENAE' ),
				'size' => 50,
				'slug' => 'huge',
			),
		)
	);

	add_theme_support( 'editor-styles' );

	add_editor_style( 'style-editor.css' );


	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Primary Menu', 'THEMENAE' ),
			'social'    => esc_html__( 'Social Menu', 'THEMENAE' ),
		)
	);

	add_theme_support(
		'custom-background',
		array(
			'default-color' => '080808',
		)
	);

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'blogthumb', 1300, 9999 );
}
add_action( 'after_setup_theme', 'setup' );

/**
 * Register widget areas.
 */
function widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'THEMENAE' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Top Widget', 'THEMENAE' ),
			'id'            => 'sidebar-2',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'widgets_init' );

/**
 * Register Roboto Fonnt for andre.
 *
 * @return string
 */
function font_url() {;
}

/**
 * Including theme scripts and styles.
 */
function scripts_styles() {
	// Threaded comment reply styles.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( ! is_admin() ) {
		wp_enqueue_script( 'responsive-videos', get_template_directory_uri() . '/assets/scripts/js/responsive-videos.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'animate', get_template_directory_uri() . '/assets/scripts/js/animate.js', array( 'jquery' ), '0.1.0', true );
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/scripts/js/customscripts.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'animate-style', get_template_directory_uri() . '/assets/scripts/css/animate.css', array(), '1', 'screen' );
		wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.0' );
		wp_style_add_data( 'style', 'rtl', 'replace' );
	}
}
add_action( 'wp_enqueue_scripts', 'scripts_styles' );

function copyright() {
   global $wpdb;
   $copyright_dates = $wpdb->get_results("
   SELECT
   YEAR(min(post_date_gmt)) AS firstdate,
   YEAR(max(post_date_gmt)) AS lastdate
   FROM
   $wpdb->posts
   WHERE
   post_status = 'publish'
   ");

   $output = '';

   if($copyright_dates) {
     $copyright = "© " . $copyright_dates[0]->firstdate;
     if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
        $copyright .= '-' . $copyright_dates[0]->lastdate;
     }

     $output = $copyright;
   }
   return $output;
 }

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
