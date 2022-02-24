<?php
/**
 * THEMENAME's functions and definitions
 *
 * @package THEMENAME
 * @since THEMENAME 1.0
 */

function THEMENAME_setup() {
  global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width = 1600;
	}

  add_action( 'after_setup_theme', 'THEMENAME_theme_support' );
  add_action( 'after_setup_theme', 'THEMENAME_functions' );

  require_once 'dev-templates/is-debug.php';

  require_once( get_template_directory() . '/inc/THEMENAME-support.php' );
  require_once( get_template_directory() . '/inc/THEMENAME-extra-controls.php' );
  require_once( get_template_directory() . '/inc/THEMENAME-functions.php' );

  require get_parent_theme_file_path( '/inc/classes/class-tgm-plugin-activation.php' );
  require get_template_directory() . '/inc/classes/class-THEMENAME-svg-icons.php';
  require get_template_directory() . '/inc/classes/class-THEMENAME-custom-colors.php';
  new THEMENAME_Custom_Colors();
  require get_template_directory() . '/inc/classes/class-THEMENAME-customize.php';
  new THEMENAME_Customize();
  require_once get_template_directory() . '/inc/classes/class-THEMENAME-dark-mode.php';
  new THEMENAME_Dark_Mode();

  require get_parent_theme_file_path( '/inc/about.php' );
  require get_parent_theme_file_path( '/inc/color-scheme.php' );
  require get_parent_theme_file_path( '/inc/custom-header.php' );
  require get_parent_theme_file_path( '/inc/events.php' );
  require get_parent_theme_file_path( '/inc/icon-functions.php' );
  require get_parent_theme_file_path( '/inc/widget-social-icons.php' );


  require get_parent_theme_file_path( '/inc/customizer/customizer.php' );


  require get_template_directory() . '/inc/menu-functions.php';
  require get_parent_theme_file_path( '/inc/template-functions.php' );
  require get_parent_theme_file_path( '/inc/template-tags.php' );

  add_action( 'init', 'THEMENAME_customize_preview_js' );
  add_action( 'get_header', 'enable_threaded_comments' );

  add_action( 'widgets_init', 'widgets_init' );



  add_filter( 'rss_widget_feed_link', '__return_false' );


  add_filter( 'widget_text', 'do_shortcode' );
  add_filter( 'widget_text', 'shortcode_unautop' ); // Remove <p> tags in Dynamic Sidebars (better!)
  add_filter( 'wp_title', 'rw_title', 10, 3 );

  // Remove Actions
  remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
  remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
  remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
  remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
  remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
  remove_action( 'wp_head', 'rel_canonical' );
  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );


}
add_action( 'after_setup_theme', 'THEMENAME_setup' );

// This theme uses wp_nav_menu() in one location.




function enqueue_scripts_and_styles() {
  function header_scripts() {
    if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
      if ( THEMENAME_DEBUG ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', get_template_directory_uri() . '/assets/scripts/js/lib/jquery/jquery.js', array(), '1.11.1' );

        wp_register_script( 'conditionizr', get_template_directory_uri() . '/assets/scripts/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0' );

        wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/scripts/js/lib/modernizr.js', array(), '2.8.3' );

        wp_enqueue_script( 'THEMENAME_scripts', get_template_directory_uri() . '/assets/scripts/js/scripts.js', array( 'conditionizr', 'modernizr', 'jquery' ), '1.0.0' );
      }
    }
  }



  function enqueue_scripts() {
    $min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/scripts/js/lib/' : 'assets/scripts/js/';

    wp_register_script( 'html5', get_theme_file_uri() .'/assets/scripts/js/lib/html5.js' );
    wp_register_script( 'copyright', get_theme_file_uri() . '/assets/scripts/js/css_comment.js', array(), null, true );
    wp_register_script( 'scripts', get_theme_file_uri() . '/assets/scripts/js/scripts.js', array( 'jquery' ), '', true );
    wp_register_script( 'skip-link-focus-fix', get_theme_file_uri() . $path . 'skip-link-focus-fix' . $min . '.js', array(), '201800703', true );
    wp_enqueue_script( 'index', get_theme_file_uri() . '/assets/scripts/js/index.js' );
  }




  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'THEMENAME-js' );

  wp_script_add_data( 'THEMENAME-html5', 'conditional', 'lt IE 9' );
}
