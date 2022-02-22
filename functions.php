<?php
/**
 * MYTHEME's functions and definitions
 *
 * @package MYTHEME
 * @since MYTHEME 1.0
 */

/**
 * Set Content Width
 */

 if ( ! isset( $content_width ) ) {
   $content_width = 1380; /* pixels */
 }

function setup() {
  require_once( get_template_directory() . '/inc/MYTHEME-support.php' );
  require_once( get_template_directory() . '/inc/MYTHEME-cleanup.php' );
  require_once( get_template_directory() . '/inc/MYTHEME-functions.php' );

  require( get_template_directory() . '/inc/custom-functions/template-tags.php' );
  require( get_template_directory() . '/inc/custom-functions/template-functions.php' );
  require get_parent_theme_file_path( '/inc/custom-functions/icon-functions.php' );

  require get_parent_theme_file_path( '/inc/custom/events.php' );
  require get_parent_theme_file_path( '/inc/custom/color-scheme.php' );
  require get_parent_theme_file_path( '/inc/custom/custom-header.php' );

  require get_parent_theme_file_path( '/inc/customizer/customizer.php' );

  require get_parent_theme_file_path( '/inc/widgets/widget-social-icons.php' );

  require get_parent_theme_file_path( '/inc/classes/class-tgm-plugin-activation.php' );

  MYTHEME_theme_support();
  MYTHEME_functions();

  add_action( 'init', 'MYTHEME_head_cleanup' );

  add_action( 'tgmpa_register', 'register_required_plugins' );
  add_action( 'template_redirect', 'MYTHEME_template_redirect' );

  add_action( 'widgets_init', 'widgets_init' );
  add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_fonts' );
  add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
  add_action( 'wp_enqueue_scripts', 'enqueue_conditional_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_vendor_scripts_and_styles' );
  add_action( 'wp_head', 'javascript_detection', 0 );

  add_filter( 'excerpt_more', 'MYTHEME_excerpt_more' );
  add_filter( 'gallery_style', 'MYTHEME_gallery_style' );
  add_filter( 'image_size_names_choose', 'MYTHEME_custom_image_sizes' );
  add_filter( 'the_content', 'MYTHEME_filter_ptags_on_images' );
  add_filter( 'the_generator', 'MYTHEME_rss_version' );
  add_filter( 'widget_text', 'do_shortcode' );
  add_action( 'wp_head', 'MYTHEME_remove_recent_comments_style', 1 );
  add_filter( 'wp_head', 'MYTHEME_remove_wp_widget_recent_comments_style', 1 );
  add_filter( 'wp_title', 'rw_title', 10, 3 );

}
add_action( 'after_setup_theme', 'setup' );

// This theme uses wp_nav_menu() in one location.
function nav_menus() {
  register_nav_menus(
    array(
      'primary-menu'    => esc_html__( 'Primary', 'MYTHEME' ),
      'social-menu'     => esc_html__( 'Floating Social Menu', 'MYTHEME' ),
    )
  );
}

function widgets_init() {
  register_sidebar(
    array(
      'name' => __( 'Primary Widget Area', 'MYTHEME' ),
      'id' => 'sidebar-1',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>',
    )
  );

  register_sidebar(
    array(
      'name' => __( 'Secondary Widget Area', 'MYTHEME' ),
      'id' => 'sidebar-2',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>',
    )
  );
}

function register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
      'name' => 'Catch Web Tools', // Plugin Name, translation not required.
      'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs', // Plugin Name, translation not required.
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top', // Plugin Name, translation not required.
			'slug' => 'to-top',
		),
		// Catch Gallery.
    array(
      'name' => 'Catch Gallery', // Plugin Name, translation not required.
      'slug' => 'catch-gallery',
    ),
  );

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
			'slug' => 'catch-infinite-scroll',
		);
	}
	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types', // Plugin Name, translation not required.
			'slug' => 'essential-content-types',
		);
	}
	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets', // Plugin Name, translation not required.
			'slug' => 'essential-widgets',
		);
	}
	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	$config = array(
		'id'           => 'MYTHEME',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
  );

  tgmpa( $plugins, $config );
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

function javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

function wpb_copyright() {
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

function enqueue_scripts_and_styles() {
  function enqueue_styles() {
    wp_enqueue_style( 'style', get_template_directory() . '/style.css' );

  }

  function enqueue_scripts() {
    $min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/scripts/js/lib/' : 'assets/scripts/js/';

    wp_register_script( 'html5', get_theme_file_uri() .'/assets/scripts/js/lib/html5.js' );
    wp_register_script( 'MYTHEME-copyright', get_theme_file_uri() . '/assets/scripts/js/css_comment.js', array(), null, true );
    wp_register_script( 'scripts', get_stylesheet_directory_uri() . '/assets/scripts/js/scripts.js', array( 'jquery' ), '', true );
    wp_register_script( 'skip-link-focus-fix', get_theme_file_uri() . $path . 'skip-link-focus-fix' . $min . '.js', array(), '201800703', true );
    wp_enqueue_script( 'MYTHEME-html5',  get_theme_file_uri( $path . 'html5' . $min . '.js' ), array(), '3.7.3' );
    wp_enqueue_script( 'index', get_theme_file_uri() . '/assets/scripts/js/index.js' );
  }


  function enqueue_fonts() {
    wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
  }

  function enqueue_conditional_styles() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
    if ( is_singular() && wp_attachment_is_image() ) {
      wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/assets/scripts/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
    }


  }

  function enqueue_vendor_scripts_and_styles() {
    wp_enqueue_script( 'MYTHEME-fitvid', get_template_directory_uri() . '/assets/scripts/js/jquery.fitvids.js', array( 'jquery' ), true );
    wp_register_script( 'MYTHEME-modernizr', get_stylesheet_directory_uri() . '/assets/scripts/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

  }
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'MYTHEME-js' );
  wp_enqueue_script( 'MYTHEME-modernizr' );

  wp_script_add_data( 'MYTHEME-html5', 'conditional', 'lt IE 9' );

}

/************* COMMENT LAYOUT *********************/
// Comment Layout
function MYTHEME_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'MYTHEME' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'MYTHEME' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'MYTHEME' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'MYTHEME' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!
