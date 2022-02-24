<?php
/**
 * THEMENAME's functions and definitions
 *
 * @package THEMENAME
 * @since THEMENAME 1.0
 */
defined( 'ABSPATH' ) || die( "Can't access directly" );

define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );
define( 'VERSION', wp_get_theme( 'THEMENAME' )->get( 'Version' ) );

function THEMENAME_setup() {
  global $content_width;
  if ( ! isset( $content_width ) ) {
      $content_width = 1600;
  }

  require_once THEME_DIR . '/dev-templates/is-debug.php';
  require_once THEME_DIR . '/inc/init.php';

  add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );
  add_action( 'after_setup_theme', 'theme_support' );
  add_action( 'after_setup_theme', 'theme_setup' );
  add_action( 'get_header', 'enable_threaded_comments' );
  add_action( 'widgets_init', 'widgets_init' );
  add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_fonts' );
  add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
  add_action( 'wp_enqueue_scripts', 'enqueue_conditional_scripts' );
  add_action( 'wp_enqueue_scripts', 'enqueue_vendor_scripts_and_styles' );
  add_action( 'wp_head', 'javascript_detection', 0 );

  add_filter( 'show_admin_bar', 'remove_admin_bar' );

}
add_action( 'after_setup_theme', 'THEMENAME_setup' );

function nav_menus() {
  register_nav_menus(
    array(
      'main-menu' => esc_html__( 'Primary Menu', 'THEMENAME' ),
      'social'    => esc_html__( 'Social Menu', 'THEMENAME' ),
    )
	);
}

$pre_header_layout = get_theme_mod( 'pre_header_layout' );
$footer_layout     = get_theme_mod( 'footer_layout' );
if ( $pre_header_layout && 'none' !== $pre_header_layout ) {

  register_nav_menus(
    array(
      'pre_header_menu'       => __( 'Pre Header Left', 'THEMENAME' ),
      'pre_header_menu_right' => __( 'Pre Header Right', 'THEMENAME' ),
    )
  );
}
if ( 'none' !== $footer_layout ) {

  register_nav_menus(
    array(
      'footer_menu'       => __( 'Footer Left', 'THEMENAME' ),
      'footer_menu_right' => __( 'Footer Right', 'THEMENAME' ),
    )
  );
}


function widgets_init() {
  register_sidebar(
    array(
      'name'          => esc_html__( 'Sidebar', 'andre-lite' ),
      'id'            => 'sidebar-1',
      'description'   => '',
      'before_widget' => '<div id="%1$s" class="widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Top Widget', 'andre-lite' ),
      'id'            => 'sidebar-2',
      'description'   => '',
      'before_widget' => '<div id="%1$s" class="widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}

function reading_time() {
  $content = get_post_field( 'post_content', $post->ID );
  $word_count = str_word_count( strip_tags( $content ) );
  $readingtime = ceil($word_count / 200);
  if ($readingtime == 1) {
    $timer = " minute";
  } else {
    $timer = " minutes";
  } $totalreadingtime = $readingtime . $timer;
  return $totalreadingtime;
}

function html_classes() {
	/**
	 * Filters the classes for the main <html> element.
	 *
	 * @since THEMENAME 1.0
	 *
	 * @param string The list of classes. Default empty string.
	 */
	$classes = apply_filters( 'html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}

function javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
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

function remove_admin_bar() {
    return false;
}

function enable_threaded_comments() {
  if ( ! is_admin() ) {
    if ( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1 ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}

function enqueue_scripts_and_styles() {
  function enqueue_styles() {
    if ( 'SCRIPT_DEBUG'. 'true' ) {
      wp_register_style( 'animate-style', get_template_directory_uri() . '/assets/scripts/css/animate.css', array(), '1', 'screen' );
      wp_register_style( 'style', get_template_directory_uri() . '/style.css' );

      wp_enqueue_style( 'style' );
      wp_enqueue_style( 'animate-style' );
    } else {
      wp_register_style( 'animate-style', get_template_directory_uri() . '/assets/scripts/css/animate.css', array(), '1', 'screen' );
      wp_enqueue_style( 'icon-font', get_template_directory_uri() . '/css/min/iconfont-min.css', '', VERSION );
      wp_register_style( 'style', get_template_directory_uri() . '/style.css' );

      wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/min/responsive-min.css', '', VERSION );

      wp_enqueue_style( 'style' );
      wp_enqueue_style( 'animate-style' );
    }
  }

  function enqueue_fonts() {
    wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
  }

  function enqueue_scripts() {
    $min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/scripts/js/lib/' : 'assets/scripts/js/';

    wp_register_script( 'html5', get_theme_file_uri() .'/assets/scripts/js/lib/html5.js' );
    wp_register_script( 'copyright', get_theme_file_uri() . '/assets/scripts/js/css_comment.js', array(), null, true );
    wp_register_script( 'scripts', get_theme_file_uri() . '/assets/scripts/js/scripts.js', array( 'jquery' ), '', true );
    wp_register_script( 'skip-link-focus-fix', get_theme_file_uri() . $path . 'skip-link-focus-fix' . $min . '.js', array(), '201800703', true );
    wp_enqueue_script( 'site',

    get_template_directory_uri() . '/js/min/site-min.js', array( 'jquery' ), VERSION, true );

  	wp_add_inline_script(
  		'site',
  		'var Obj = {
  			ajaxurl: "' . admin_url( 'admin-ajax.php' ) . '"
  		};',
  		'before'
  	);
    wp_enqueue_script( 'index', get_theme_file_uri() . '/assets/scripts/js/index.js' );
  }

  function header_scripts() {
    if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
      if ( 'SCRIPT_DEBUG' ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', get_template_directory_uri() . '/assets/scripts/js/lib/jquery/jquery.js', array(), '1.11.1' );

        wp_register_script( 'conditionizr', get_template_directory_uri() . '/assets/scripts/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0' );

        wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/scripts/js/lib/modernizr.js', array(), '2.8.3' );

        wp_enqueue_script( 'THEMENAME_scripts', get_template_directory_uri() . '/assets/scripts/js/scripts.js', array( 'conditionizr', 'modernizr', 'jquery' ), '1.0.0' );
      }
    }
  }

  function enqueue_conditional_scripts() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
    if ( is_singular() && wp_attachment_is_image() ) {
      wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/assets/scripts/js/lib/jquery/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
    }
    if ( has_nav_menu( 'primary-menu' ) ) {
      wp_enqueue_script(
        'primary-navigation-script',
        get_template_directory_uri() . '/assets/scripts/js/lib/components/primary-navigation.js',
        array( 'ie11-polyfills' )
      );
    }
    if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
      echo '<script>';
      include get_template_directory() . '/assets/scripts/js/lib/skip-link-focus-fix.js';
      echo '</script>';
    } else {
      // The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
      ?>
      <script>
      /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())}),!1)
      </script>
      <?php
    }
  }

  function enqueue_vendor_scripts_and_styles() {
    $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '/assets/scripts/js/lib/' : 'assets/scripts/js/';

    wp_enqueue_script( 'fitvid', get_template_directory_uri() . $path . 'jquery/fitvids.js', array( 'jquery' ), true );
    wp_enqueue_script( 'animate', get_template_directory_uri() . $path . 'custom-scripts/animate.js', array( 'jquery' ), '0.1.0', true );

  }

  function enqueue_theme_mod_scripts() {
    $deps[] = 'jquery';

    $enable_portfolio = get_theme_mod( 'THEMENAME_portfolio_option', 'disabled' );

    if ( THEMENAME_check_section( $enable_portfolio ) ) {
      $deps[] = 'jquery-masonry';
    }

    $enable_featured_content = get_theme_mod( 'THEMENAME_featured_content_option', 'disabled' );

    //Slider Scripts
    $enable_slider      = THEMENAME_check_section( get_theme_mod( 'THEMENAME_slider_option', 'disabled' ) );

    $enable_testimonial_slider      = THEMENAME_check_section( get_theme_mod( 'THEMENAME_testimonial_option', 'disabled' ) ) && get_theme_mod( 'THEMENAME_testimonial_slider', 1 );

    if ( $enable_slider || $enable_testimonial_slider ) {
      // Enqueue owl carousel css. Must load CSS before JS.
      wp_enqueue_style( 'owl-carousel-core', get_theme_file_uri( 'assets/scripts/css/owl-carousel/owl.carousel.min.css' ), null, '2.3.4' );
      wp_enqueue_style( 'owl-carousel-default', get_theme_file_uri( 'assets/scripts/css/owl-carousel/owl.theme.default.min.css' ), null, '2.3.4' );

      // Enqueue script
      wp_enqueue_script( 'owl-carousel', get_theme_file_uri( $path . 'owl.carousel.js' ), array( 'jquery' ), '2.3.4', true );

      $deps[] = 'owl-carousel';
      $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '/assets/scripts/js/lib/' : 'assets/scripts/js/';

      wp_enqueue_script( 'functions', get_theme_file_uri( $path . '/custom-scripts/functions.js' ), $deps, '201800703', true );

    }
  }
}
