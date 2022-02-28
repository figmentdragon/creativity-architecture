<?php
/**
 * __THEMENAE__'s functions and definitions
 *
 * @package __THEMENAE__
 * @since __THEMENAE__ 1.0
 */

 defined( 'ABSPATH' ) || die( "Can't access directly" );
 global $path;
 define( $path, 'get_template_directory()' );


 add_action( 'after_setup_theme', 'THEMENAE_setup' );

 function THEMENAE_setup() {

  require get_template_directory() . '/dev-templates/is-debug.php';
  require get_template_directory() . '/inc/admin-options.php';
  require get_template_directory() . '/inc/template-functions.php';
  require get_template_directory() . '/inc/body-classes.php';
  require get_template_directory() . '/inc/custom-theme-functions.php';
  require get_template_directory() . '/inc/customizer.php';
  require get_template_directory() . '/inc/edit-link.php';
  require get_template_directory() . '/inc/helpers.php';
  require get_template_directory() . '/inc/licences.php';
  require get_template_directory() . '/inc/menu-functions.php';
  require get_template_directory() . '/inc/setup.php';
  require get_template_directory() . '/inc/splot-plugins.php';

  require get_template_directory() . '/inc/theme-functions.php';
  require get_template_directory() . '/inc/theme-support.php';
  require get_template_directory() . '/inc/tools.php';


  require get_template_directory() . '/inc/classes-theme-options.php';


   global $content_width;
   if ( !isset( $content_width ) ) { $content_width = 1920; }

   add_action( 'after_setup_theme', 'autologin' );
   add_action( 'after_setup_theme', 'background_setup' );
   add_action('after_switch_theme', 'custom_theme_functions');
   add_action( 'after_setup_theme', 'theme_functions' );
   add_action( 'after_setup_theme', 'theme_support' );
   add_action( 'after_setup_theme', 'theme_setup' );
   add_action( 'after_setup_theme', 'custom_logo_setup' );
   add_action( 'after_setup_theme', 'custom_header_setup' );
   add_action( 'after_setup_theme', 'menu_functions_and_filters' );
   add_action( 'after_setup_theme', 'load_theme_options', 9 );
   add_action('after_setup_theme', 'remove_admin_bar');


   add_action( 'add_meta_boxes', 'editlink_meta_box' );
   add_action( 'admin_enqueue_scripts', 'custom_admin_styles' );
   add_action( 'admin_notices', 'admin_notice' );
   add_action( 'admin_init', 'notice_dismissed' );
   add_action( 'admin_menu', 'change_post_label' );
   add_action( 'admin_menu', 'drafts_menu');
   add_action( 'after_switch_theme', 'setup' );

   add_action( 'comment_form_before', 'enqueue_comment_reply_script' );
   add_action( 'comment_form_before', 'enqueue_comments_reply' );
   add_action( 'customize_preview_init', 'customize_preview_js' );
   add_action( 'customize_register', 'customize_register' );
   add_action( 'customize_register', 'register_theme_customizer' );
   add_action( 'get_header', 'enable_threaded_comments' );
   add_action( 'init', 'change_post_object' );
   add_action( 'login_enqueue_scripts', 'login_logo' );
   add_action( 'pre_get_posts', 'show_drafts' );
   add_action(  'publish_post',  'publish', 10, 2 );
   add_action( 'rest_api_init', 'create_api_posts_meta_field' );
   add_action( 'widgets_init', 'widgets_init' );

   add_action( 'wp_ajax_nopriv_ajax_tag_search', 'ajax_tag_search' ); //allow on front-end
   add_action( 'wp_ajax_ajax_tag_search', 'ajax_tag_search' );
   add_action( 'wp_ajax_nopriv_upload_action', 'upload_action' ); //allow on front-end
   add_action( 'wp_ajax_upload_action', 'upload_action' );
   add_action( 'wp_before_admin_bar_render', 'options_to_admin' );
   add_action( 'wp_body_open', 'skip_link', 5 );

  add_action( 'wp_enqueue_scripts', 'add_scripts');
  add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_vendor_scripts_and_styles' );
  add_action( 'wp_head', 'enqueue_conditional_scripts' );
  add_action( 'wp_head', 'enqueue_fonts' );
  add_action('wp_head', 'no_featured_image');

  add_action( 'wp_head', 'enqueue_scripts' );
  add_action( 'wp_head', 'enqueue_support_scripts_and_styles' );
  add_action( 'wp_head', 'javascript_detection', 0 );
  add_action( 'wp_head', 'pingback_header' );
  add_action( 'wp_footer', 'footer' );

  add_filter('admin_footer_text', 'remove_footer_admin');
  add_filter( 'auth_cookie_expiration', 'cookie_expiration', 99, 3 );
  add_filter( 'big_image_size_threshold', '__return_false' );
  add_filter('comment_form_defaults', 'comment_mod');
  add_filter( 'comment_notification_recipients', 'comment_notification_recipients', 15, 2 );
  add_filter( 'comment_notification_text', 'comment_notification_text', 20, 2 );
  add_filter( 'document_title_separator', 'document_title_separator' );
  add_filter( 'excerpt_length', 'new_excerpt_length' );
  add_filter( 'excerpt_more', 'excerpt_read_more_link' );
  add_filter( 'excerpt_more', 'trim_excerpt' );
  add_filter( 'get_comments_number', 'comment_count', 0 );
  add_filter( 'get_the_archive_title', 'get_the_archive_title', 10, 1 );
  add_filter( 'intermediate_image_sizes_advanced', 'image_insert_override' );
  add_filter( 'login_headerurl', 'login_link' );
  add_filter('login_message', 'add_login_message');
  add_filter( 'login_headertext', 'login_logo_url_title' );

  add_filter( 'nav_menu_link_attributes', 'schema_url', 10 );
  add_filter( 'pre_option_image_default_size', 'my_default_image_size' );
  add_filter( 'query_vars', 'tqueryvars' );
  add_filter( 'show_admin_bar', 'remove_admin_bar' );
  add_filter( 'the_content_more_link', 'read_more_link' );
  add_filter( 'the_content', 'firstview' );
  add_filter( 'the_excerpt', 'read_more_custom_excerpt' );
  add_filter( 'the_generator', 'devfnctn_remove_version' );
  add_filter( 'the_posts', 'reveal_previews', 10, 2 );
  add_filter( 'the_title', 'title' );
  add_filter( 'wp_mail_content_type', 'set_html_content_type' );

	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

  add_shortcode('count', 'count');
  add_shortcode("taglist", "taglist");
 }


 function devfnctn_remove_version() {
   return '';
 }

 function remove_footer_admin () {
    echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | WordPress Tutorials: <a href="https://deardorffassociatesweb.wordpress.com/" target="_blank">Dev</a></p>';
  }



 function admin_notice() {
   $user_id = get_current_user_id();
   if ( !get_user_meta( $user_id, 'notice_dismissed_4' ) && current_user_can( 'manage_options' ) )
   echo '<div class="notice notice-info"><p>' . __( '<big><strong>BlankSlate</strong>:</big> Help keep the project alive! <a href="?notice-dismiss" class="alignright">Dismiss</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">Make a Donation</a>', '__THEMENAE__' ) . '</p></div>';
 }

 function notice_dismissed() {
   $user_id = get_current_user_id();
   if ( isset( $_GET['notice-dismiss'] ) )
   add_user_meta( $user_id, 'notice_dismissed_4', 'true', true );
 }

 function footer() {
   ?>
   <script>
   jQuery(document).ready(function($) {
     var deviceAgent = navigator.userAgent.toLowerCase();
     if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
       $("html").addClass("ios");
     }
     if (navigator.userAgent.search("MSIE") >= 0) {
       $("html").addClass("ie");
     }
     else if (navigator.userAgent.search("Chrome") >= 0) {
       $("html").addClass("chrome");
     }
     else if (navigator.userAgent.search("Firefox") >= 0) {
       $("html").addClass("firefox");
     }
     else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
       $("html").addClass("safari");
     }
     else if (navigator.userAgent.search("Opera") >= 0) {
       $("html").addClass("opera");
     }
   });
   </script>
   <?php
 }

 function document_title_separator( $sep ) {
   $sep = '|';
   return $sep;
 }

 function title( $title ) {
   if ( $title == '' ) {
     return '...';
   } else {
     return $title;
   }
 }

 function schema_url( $atts ) {
   $atts['itemprop'] = 'url';
   return $atts;
 }

 function remove_admin_bar() {
     return false;
 }

 function javascript_detection() {
 	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
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

 function enable_threaded_comments() {
   if ( ! is_admin() ) {
     if ( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1 ) ) {
       wp_enqueue_script( 'comment-reply' );
     }
   }
 }

 if ( !function_exists( 'wp_body_open' ) ) {
   function wp_body_open() {
     do_action( 'wp_body_open' );
   }
 }

 function skip_link() {
   echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', '__THEMENAE__' ) . '</a>';
 }

 function read_more_link() {
   if ( !is_admin() ) {
     return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', '__THEMENAE__' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
   }
 }

 function excerpt_read_more_link( $more ) {
   if ( !is_admin() ) {
     global $post;
     return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', '__THEMENAE__' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
   }
 }

 function image_insert_override( $sizes ) {
   unset( $sizes['medium_large'] );
   unset( $sizes['1536x1536'] );
   unset( $sizes['2048x2048'] );
   return $sizes;
 }

 function widgets_init() {
   register_sidebar(
     array(
       'name'          => esc_html__( 'Sidebar', '__THEMENAE__' ),
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
       'name'          => esc_html__( 'Top Widget', '__THEMENAE__' ),
       'id'            => 'sidebar-2',
       'description'   => '',
       'before_widget' => '<div id="%1$s" class="widget">',
       'after_widget'  => '</div>',
       'before_title'  => '<h2 class="widget-title">',
       'after_title'   => '</h2>',
     )
   );
 }

 function pingback_header() {
   if ( is_singular() && pings_open() ) {
     printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
   }
 }

 function enqueue_comment_reply_script() {
   if ( get_option( 'thread_comments' ) ) {
     wp_enqueue_script( 'comment-reply' );
   }
 }

 function custom_pings( $comment ) {
   ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
    <?php
  }

 function comment_count( $count ) {
   if ( !is_admin() ) {
     global $id;
     $get_comments = get_comments( 'status=approve&post_id=' . $id );
     $comments_by_type = separate_comments( $get_comments );
     return count( $comments_by_type['comment'] );
   } else {
     return $count;
   }
 }

 function html_classes() {
 	$classes = apply_filters( 'html_classes', '' );
 	if ( ! $classes ) {
 		return;
 	}
 	echo 'class="' . esc_attr( $classes ) . '"';
 }

 function enqueue_scripts_and_styles() {
   function enqueue_styles() {
     $css_path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/scripts/css/lib/' : 'assets/scripts/css/';

     wp_register_style( 'animate-style', get_template_directory_uri() . '/css/animate.css', array(), '1', 'screen' );
     wp_register_style( 'style', get_template_directory_uri() . '/style.css' );

     wp_enqueue_style( 'icon-font', get_template_directory_uri() . '/css/min/iconfont-min.css', '', 'VERSION' );
     wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/scripts/css/min/responsive-min.css', '', 'VERSION' );

     }
   }

   function enqueue_fonts() {
     wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
   }

   function enqueue_scripts() {
     $min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
     $js_path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/scripts/js/lib/' : 'assets/scripts/js/';

		wp_register_script( 'responsive-videos', get_template_directory_uri() . '/js/responsive-videos.js', array( 'jquery' ), '1.0', true );
		wp_register_script( 'animate', get_template_directory_uri() . '/js/animate.js', array( 'jquery' ), '0.1.0', true );
		wp_register_script( 'custom', get_template_directory_uri() . '/js/customscripts.js', array( 'jquery' ), '1.0', true );

    wp_register_script( 'html5', $js_path . 'html5.js' );
    wp_register_script( 'copyright', get_theme_file_uri() . '/js/css_comment.js', array(), null, true );
    wp_register_script( 'scripts', get_theme_file_uri() . '/assets/scripts/js/scripts.js', array( 'jquery' ), '', true );
    wp_register_script( 'skip-link-focus-fix', get_theme_file_uri() . $js_path . 'skip-link-focus-fix' . $min . '.js', array(), '201800703', true );
    wp_register_script( 'site', get_template_directory_uri() . '/assets/scripts/js/min/site-min.js', array( 'jquery' ), 'VERSION', true );
    wp_register_script( 'keyboard-image-navigation', get_template_directory_uri() . '/assets/scripts/js/lib/jquery/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
    wp_register_script( 'responsive-embeds-script', get_template_directory_uri() . '/assets/scripts/js/responsive-embeds.js', array( 'ie11-polyfills' ), wp_get_theme()->get( 'VERSION' ), true );

    wp_register_script( 'index', get_theme_file_uri() . '/assets/scripts/js/index.js' );
   }

   function header_scripts() {
     if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
       if ( 'SCRIPT_DEBUG' ) {
         wp_deregister_script( 'jquery' );
         wp_register_script( 'jquery', get_template_directory_uri() . '/assets/scripts/js/lib/jquery/jquery.js', array(), '1.11.1' );

         wp_register_script( 'conditionizr', get_template_directory_uri() . '/assets/scripts/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0' );

         wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/scripts/js/lib/modernizr.js', array(), '2.8.3' );
       }
     }
   }

   function enqueue_vendor_scripts_and_styles() {
     $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '/assets/scripts/js/lib/' : 'assets/scripts/js/';

     wp_register_script( 'fitvid', get_template_directory_uri() . $path . 'jquery/fitvids.js', array( 'jquery' ), true );
     wp_register_script( 'animate', get_template_directory_uri() . $path . 'custom-scripts/animate.js', array( 'jquery' ), '0.1.0', true );
   }

   function enqueue_support_scripts_and_styles() {
     wp_add_inline_script(
       'site',
       'var Obj = {
         ajaxurl: "' . admin_url( 'admin-ajax.php' ) . '"
       };',
       'before'
     );
     wp_style_add_data( 'style', 'rtl', 'replace' );
   }

   wp_enqueue_script( 'html5' );
   wp_enqueue_script( 'copyright' );
   wp_enqueue_script( 'scripts' );
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'skip-link-focus-fix' );
   wp_enqueue_script( 'site' );
   wp_enqueue_script( 'responsive-embeds-script' );
   wp_enqueue_script( 'index' );
   wp_enqueue_script( 'fitvid' );
   wp_enqueue_script( 'animate' );
   wp_enqueue_script( 'functions' );
   wp_enqueue_script( 'responsive-videos' );
   wp_enqueue_script( 'animate' );
   wp_enqueue_script( 'custom' );

   wp_enqueue_script( 'header_scripts', get_template_directory_uri() . '/assets/scripts/js/scripts.js', array( 'conditionizr', 'modernizr', 'jquery' ), '1.0.0' );

   wp_enqueue_style( 'owl-carousel-core' );
   wp_enqueue_style( 'owl-carousel-default' );
   wp_enqueue_style( 'owl-carousel' );

   wp_enqueue_style( 'animate' );
   wp_enqueue_style( 'style' );

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
      echo '<script>'; include get_template_directory() . '/assets/scripts/js/lib/skip-link-focus-fix.js'; echo '</script>';
    } else {
       // The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
       ?>
       <script>
       /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())}),!1)
       </script>
       <?php
     }
   }

 function customize_controls_enqueue_scripts() {
   wp_enqueue_script(
 		'customize-helpers',
 		get_theme_file_uri( '/assets/scripts/js/lib/customizer/customize-helpers.js' ),
 		array(),
 		wp_get_theme()->get( 'Version' ),
 		true
 	);
 }
