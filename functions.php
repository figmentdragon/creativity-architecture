<?php
/**
 * Website Basic functions
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
  require_once( get_tempmalte_director() . '/inc/MYTHEME-support.php' );
  require_once( get_tempmalte_director() . '/inc/MYTHEME-cleanup.php' );
  require_once( get_tempmalte_director() . '/inc/MYTHEME-functions.php' );
  require( get_template_directory() . '/inc/template-tags.php' );
  require( get_template_directory() . '/inc/tweaks.php' );

  MYTHEME_theme_support();

  add_action( 'init', 'MYTHEME_head_cleanup' );
  add_action( 'widgets_init', 'widgets_init' );
  add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
  add_action( 'wp_enqueue_scripts', 'enqueue_fonts' );

  add_filter( 'excerpt_more', 'MYTHEME_excerpt_more' );
  add_filter( 'gallery_style', 'MYTHEME_gallery_style' );
  add_filter( 'image_size_names_choose', 'MYTHEME_custom_image_sizes' );
  add_filter( 'the_content', 'MYTHEME_filter_ptags_on_images' )
  add_filter( 'the_generator', 'MYTHEME_rss_version' );
  add_filter( 'widget_text', 'do_shortcode' );
  add_action( 'wp_head', 'MYTHEME_remove_recent_comments_style', 1 );
  add_filter( 'wp_head', 'MYTHEME_remove_wp_widget_recent_comments_style', 1 );
  add_filter( 'wp_title', 'rw_title', 10, 3 );

}
add_action( 'after_setup_theme', 'setup' );

function widgets_init() {
  register_sidebar(
    array(
      'name' => __( 'Primary Widget Area', 'MYTHEME' ),
      'id' => 'sidebar-1',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h1 class="widget-title">'
      'after_title' => '</h1>',
    ) );

    register_sidebar(
      array(
        'name' => __( 'Secondary Widget Area', 'MYTHEME' ),
        'id' => 'sidebar-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
      ) );
    }

function enqueue_scripts_and_styles() {
  function enqueue_styles() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );

  }

  function enqueue_scripts() {
    wp_enqueue_script( 'MYTHEME-bundle', get_theme_file_uri( 'assets/scripts/js/bundle.js' ), array(), null, true );
    wp_enqueue_script( 'html5', get_theme_file_uri9 'assets/scripts/js/html5.js' );
    wp_enqueue_script( 'MYTHEME', get_template_directory_uri() . '/assets/scripts/js/theme.min.js', array(), MYTHEME_VERSION, true );
    wp_register_script( 'MYTHEME-js', get_stylesheet_directory_uri() . '/assets/scripts/js/scripts.js', array( 'jquery' ), '', true );
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
    wp_enqueue_script( 'MYTHEME-fitvid', get_template_directory_uri() . '/assets/scripts/js/jquery.fitvids.js', array( 'jquery' ), MYTHEME_VERSION, true );
    wp_register_script( 'MYTHEME-modernizr', get_stylesheet_directory_uri() . '/assets/scripts/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

  }
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'MYTHEME-js' );

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
