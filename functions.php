<?php
	/*-----------------------------------------------------------------------------------*/
	/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'VERSION', 1.0 );
define('MYTHEME_TEMPLATE_DIRECTORY_URI', get_template_directory_uri());
define('MYTHEME_INC_DIR', get_template_directory() . '/inc' );
define('MYTHEME_IMAGE_URL', MYTHEME_TEMPLATE_DIRECTORY_URI . '/images' );

require_once( 'inc/MYTHEME-support.php' );
require_once( 'inc/MYTHEME-functions.php' );
require_once( 'inc/MYTHEME-cleanup.php' );
require_once( 'inc/custom/custom-post-type.php' );

require( get_template_directory() . '/inc/custom-functions/template-tags.php' );
require( get_template_directory() . '/inc/custom-functions/icon-functions.php' );
require( get_template_directory() . '/inc/custom-functions/menu-functions.php');
require( get_template_directory() . '/inc/custom-functions/template-functions.php' );

// Custom script loader class.
require get_template_directory() . '/inc/classes/class-MYTHEME-script-loader.php';

require get_template_directory() . '/inc/custom/custom-header.php';
require get_template_directory() . '/inc/customizer.php';

function setup() {
  global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 1400;

  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  add_action( 'after_setup_theme', 'MYTHEME_head_cleanup');
  add_action( 'after_setup_theme', 'theme_support' );
  add_action( 'after_setup_theme', 'custom-logo-setup' );
  add_action( 'customize_preview_init', 'MYTHEME_customize_preview_js' );
  add_action( 'customize_register', 'MYTHEME_customize_register' );
  add_action( 'edit_category', 'MYTHEME_category_transient_flusher' );
  add_action( 'init', 'MYTHEME_head_cleanup' );
  add_action( 'save_post', 'MYTHEME_category_transient_flusher' );
  add_action( 'widgets_init', 'widgets_init' );
  add_action( 'wp_enqueue_scripts', 'MYTHEME_scripts_and_styles' );
  add_action( 'wp_enqueue_scripts', 'THEME_styles' );
  add_action( 'wp_enqueue_scripts', 'THEME_scripts' );
  add_action( 'wp_enqueue_scripts', 'THEME_conditional_scripts' );
  add_action( 'wp_head', 'MYTHEME_customizer_css' );
  add_action( 'wp_head', 'MYTHEME_remove_recent_comments_style', 1 );

  add_filter( 'excerpt_more', 'MYTHEME_excerpt_more' );
  add_filter( 'gallery_style', 'MYTHEME_gallery_style' );
  add_filter( 'image_size_names_choose', 'MYTHEME_custom_image_sizes' );
  add_filter( 'rss_widget_feed_link', '__return_false' );
  add_filter( 'the_content', 'MYTHEME_filter_ptags_on_images' );
  add_filter( 'the_generator', 'MYTHEME_rss_version' );
  add_filter( 'wp_head', 'MYTHEME_remove_wp_widget_recent_comments_style', 1 );
  add_filter( 'wp_title', 'rw_title', 10, 3 );

  MYTHEME_theme_support();
  MYTHEME_template_functions();

  load_theme_textdomain( 'MYTHEME', get_template_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'setup' );

register_nav_menus(
	array(
		'primary-menu'    => esc_html__( 'Primary', 'MYTHEME' ),
		'social-menu'     => esc_html__( 'Social Menu', 'MYTHEME' ),
	));

function widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'MYTHEME' ),
			'id'            => 'sidebar-1',
      'description' => 'Take it on the side...', // Dumb description for the admin side
			'before_widget' => '<div id="%1$s" class="widget %2$s">',// What to display before each widget
			'after_widget'  => '</div>',	// What to display following each widget
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
      'empty_title'=> '',					// What to display in the case of no title defined for a widget
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Top Widget', 'MYTHEME' ),
			'id'            => 'sidebar-2',
      'description' => 'Take it on the side...', // Dumb description for the admin side
			'before_widget' => '<div id="%1$s" class="widget %2$s">',// What to display before each widget
			'after_widget'  => '</div>',	// What to display following each widget
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
      'empty_title'=> '',					// What to display in the case of no title defined for a widget
		)
	);
}

function copyright() {
  global $wpdb;
    $copyright_dates = $wpdb->get_results("
      SELECT
      YEAR(min(post_date_gmt)) AS firstdate,
      YEAR(max(post_date_gmt)) AS lastdate
      FROM
    $wpdb->posts
      WHERE
      post_status = 'publish'"
    );
    $output = '';
    if($copyright_dates) {
      $copyright = "&copy; " . $copyright_dates[0]->firstdate;
      if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
        $copyright .= '-' . $copyright_dates[0]->lastdate;
      }
      $output = $copyright;
    }
    return $output;
  }

function MYTHEME_scripts_and_styles() {
  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
  function THEME_styles() {
    wp_enqueue_style( 'style.css', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'animate-style', get_template_directory_uri() . 'assets/scripts/css/animate.css', array(), '1', 'screen' );
  }

  function THEME_scripts() {
    wp_register_script( 'js', get_stylesheet_directory_uri() . '/assets/scripts/js/scripts.js', array( 'jquery' ), '', true );
    wp_register_script( 'ie11-polyfills-asset',    get_template_directory_uri() . '/assets/scripts/js/polyfills.js', array(), wp_get_theme()->get( 'Version' ), true );

    wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/scripts/js/theme.min.js', array(), VERSION, true );
    wp_enqueue_script( 'fitvid', get_template_directory_uri() . '/assets/scripts/js/jquery/jquery.fitvids.js', array( 'jquery' ), VERSION, true );
    wp_enqueue_script( 'animate', get_template_directory_uri() . '/assets/scripts/js/animate.js', array( 'jquery' ), '0.1.0', true );
    wp_enqueue_script( 'html5' . get_template_directory_uri() . '/assets/scripts/js/html5.js' );
    wp_enqueue_script( 'responsive-videos', get_template_directory_uri() . '/assets/scripts/js/responsive-videos.js' );
    wp_enqueue_script( 'customscripts', get_template_directory_uri() .'/assets/scripts/js/customscripts.js' );
  }

  function THEME_conditional_scripts() {
    if ( has_nav_menu( 'primary-menu' ) ) {
      wp_enqueue_script( 'primary-navigation-script', get_template_directory_uri() . '/assets/scripts/js/primary-navigation.js',
      array( 'ie11-polyfills' ), wp_get_theme()->get( 'Version' ), true );
    }
    if (!is_admin()) {
      wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/assets/scripts/js/modernizr.js', array(), '2.8.3', true );

      if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
        wp_enqueue_script( 'comment-reply' );
      }
      wp_register_style( 'ie-only', get_stylesheet_directory_uri() . '/assets/scripts/css/ie.css', array(), '' );
    }
  }

  function vendor_styles() {
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css' );
    wp_register_style( 'boxicons', get_template_directory_uri() . '/assets/vendor/boxicons/css/boxicons.min.css' );
    wp_register_style( 'glightbox', get_template_directory_uri() . '/assets/vendor/glightbox/css/glightbox.min.css' );
    wp_register_style( 'swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.css' );
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/vendor/fontawesome/css/all.css' );
  }

  function vendor_scripts() {
    wp_register_script( 'purecounter', get_template_directory_uri() . '/assets/vendor/purecounter/purecounter.js' );
    wp_register_script( 'aos', get_template_directory_uri() . '/assets/vendor/aos/aos.js' );
    wp_register_script( 'bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js' );
    wp_register_script( 'glightbox', get_template_directory_uri() . '/assets/vendor/glightbox/js/glightbox.min.js' );
    wp_register_script( 'isotope', get_template_directory_uri() . '/assets/vendor/isotope-layout/isotope.pkgd.min.js' );
    wp_register_script( 'swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js' );
    wp_register_script( 'typed', get_template_directory_uri() . '/assets/vendor/typed.js/typed.min.js' );
    wp_register_script( 'waypoint', get_template_directory_uri() . '/assets/vendor/waypoints/noframework.waypoints.js' );
    wp_register_script( 'validate', get_template_directory_uri() . '/assets/vendor/php-email-form/validate.js' );
    wp_register_script( 'fontawesome', get_template_directory_uri() . '/assets/vendor/fontawesome/js/all.js' );
  }

  wp_enqueue_style( 'style.css' );
  wp_enqueue_style( 'animate-style' );
  wp_enqueue_style( 'ie-only' );
  wp_enqueue_style( 'bootstrap' );
  wp_enqueue_style( 'fontawesome' );
  wp_enqueue_style( 'boxicons' );
  wp_enqueue_style( 'glightbox' );
  wp_enqueue_style( 'swiper' );


  wp_enqueue_script( 'js' );
  wp_enqueue_script( 'ie11-polyfills-asset' );
  wp_enqueue_script( 'scripts' );
  wp_enqueue_script( 'fitvid' );
  wp_enqueue_script( 'animate' );
  wp_enqueue_script( 'primary-navigation-script' );
  wp_enqueue_script( 'modernizr' );
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'purecounter' );
  wp_enqueue_script( 'aos' );
  wp_enqueue_script( 'bootstrap' );
  wp_enqueue_script( 'glightbox' );
  wp_enqueue_script( 'isotope' );
  wp_enqueue_script( 'swiper' );
  wp_enqueue_script( 'typed' );
  wp_enqueue_script( 'waypoint' );
  wp_enqueue_script( 'validate' );
  wp_enqueue_script( 'fontawesome' );
}
