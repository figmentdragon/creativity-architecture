<?php
		/*-----------------------------------------------------------------------------------*/
		/* This file will be referenced every time a template/page loads on your Wordpress site
		/* This is the place to define custom fxns and specialty code
		/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'architecture_VERSION', 1.0 );

require_once( 'theme/man/assets/inc/architecture.php' );
require_once( 'theme/man/assets/inc/custom/custom-functions.php' );
require_once( 'theme/man/assets/inc/flei_wp_toolkit.php' );
require_once get_template_directory() . '/theme/man/assets/inc/classes/class-architecture-dark-mode.php';
  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
require_once( 'theme/man/assets/inc/custom/custom-post-type.php' );
require get_template_directory() . '/theme/man/assets/inc/functions/menu-functions.php';
require get_template_directory() . '/theme/man/assets/inc/functions/template-functions.php';
require get_template_directory() . '/theme/man/assets/inc/functions/template-tags.php';

// SVG Icons class.
require get_template_directory() . '/theme/man/assets/inc/classes/class-architecture-svg-icons.php';
// Customizer additions.
require get_template_directory() . '/theme/man/assets/inc/classes/class-architecture-customize.php';
new architecture_Customize();

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*_____________________________________________________ SETUP */
function architecture_setup() {

	architecture_theme_support();

	add_editor_style( get_stylesheet_directory_uri() . 'theme/man/assets/scripts/css/editor-style.css' );

	//add_action( 'admin_menu' , 'front_page_on_pages_menu' );
  	add_action( 'after_setup_theme', 'architecture_register_nav_menus', 0 );
	add_action( 'customize_controls_enqueue_scripts', 'architecture_customize_controls_enqueue_scripts' );
	add_action( 'customize_preview_init', 'architecture_customize_preview_init' );
	add_action( 'customize_register', 'architecture_theme_customizer' );

	add_action( 'init', 'architecture_head_cleanup' );
 	add_action( 'init', 'architecture_custom_new_menu' );

	add_action( 'widgets_init', 'architecture_register_sidebars' );

	add_action( 'wp_enqueue_scripts', 'architecture_fonts' );
	add_action( 'wp_enqueue_scripts', 'architecture_scripts' );
	add_action( 'wp_enqueue_scripts', 'architecture_style' );
	add_action( 'wp_footer', 'deregister_scripts' );
	add_action( 'wp_head', 'add_gtag_to_head' );
	add_action( 'wp_head', 'architecture_head_cleanup' );
	add_action( 'wp_head', 'architecture_remove_recent_comments_style', 1 );

	add_action( 'wp_print_styles', 'deregister_styles', 100 );

    add_filter( 'architecture_starter_content', 'starter_content' );
  	add_filter( 'excerpt_more', 'architecture_excerpt_more' );
	add_filter( 'gallery_style', 'architecture_gallery_style' );
	add_filter( 'image_size_names_choose', 'architecture_custom_image_sizes' );
	add_filter( 'post_comments_feed_link', 'architecture_post_comments_feed_link');
	add_filter( 'script_loader_tag', 'defer_scripts', 10, 3 );
	add_filter( 'show_admin_bar', '__return_false' );
  	add_filter( 'the_content', 'architecture_filter_ptags_on_images' );
	add_filter( 'the_generator', 'architecture_rss_version' );
	add_filter( 'wp_head', 'architecture_remove_wp_widget_recent_comments_style', 1 );
	add_filter( 'wp_nav_menu_args', 'architecture_nav_menu_args');
	add_filter( 'wp_title', 'rw_title', 10, 3 );

	add_shortcode('button', 'architecture_button_shortcode');
}
add_action( 'after_setup_theme', 'architecture_setup' );


if ( ! isset( $content_width ) ) $content_width = 900;

/*________________________________________________ THUMBNAILS */
add_image_size( 'architecture-thumb-600', 600, 150, true );
add_image_size( 'architecture-thumb-300', 300, 100, true );
add_image_size( 'architecture-fullscreen', 1980, 9999 );

function architecture_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'architecture-thumb-600' => __( '600px by 150px' ),
        'architecture-thumb-300' => __( '300px by 100px' ),
		'architecutre-fullscreen' => __( '1980 by 9999' )
    ) );
}

/*__________________________________________ REGISTER SIDEBAR */
function architecture_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar,
		// just change the values of id and name to another word/name
	));
}


/*____________________________________________ Comment Layout */
function architecture_comments( $comment, $args, $depth ) {
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
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'architecture' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'architecture' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'architecture' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'architecture' ) ?></p>
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






	/*-----------------------------------------------------------------------------------*/
	/* Enqueue Styles and Scripts
	/*-----------------------------------------------------------------------------------*/

function architecture_style() {
	wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');

	wp_enqueue_style( 'aos-css', get_stylesheet_directory_uri() . '/theme/man/assets/vendor/aos/aos.css' );

	wp_enqueue_style( 'glightbox-css',
	get_stylesheet_directory_uri() . '/theme/man/assets/vendor/glightbox/css/glightbox.min.css', );

	wp_enqueue_style( 'swiper-css', get_stylesheet_directory_uri() . '/theme/man/assets/vendor/swiper/swiper-bundle.min.css', );

	wp_enqueue_style( 'fontawesome-style', get_stylesheet_directory_uri() . '/theme/docs/visual-branding/audio+visual/icons/fontawesome/css/all.css' );
}

function architecture_scripts() {
//adding scripts file in the footer
	wp_register_script( 'architecture-index', get_stylesheet_directory_uri() . 'theme/man/assets/scripts/js/index.js', array( 'jquery' ), '', true );

	wp_register_script( 'architecture-main',
	get_stylesheet_directory_uri() . '/theme/man/assets/scripts/js/main.js' );

	wp_register_script( 'artchitecture', get_stylesheet_directory_uri() . '/theme/man/assets/scripts/js/architecture.js' );

// add theme scripts
	wp_enqueue_script( 'architecture-index' );
	wp_enqueue_script( 'architecture-main' );
	wp_enqueue_script( 'architecture' );
}

function architecture_customize_preview_init() {
	wp_enqueue_script(
		'architecture-customize-helpers',
		get_theme_file_uri( '/assets/scripts/js/wordpress/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	wp_enqueue_script(
		'architecture-customize-preview',
		get_theme_file_uri( '/assets/scripts/js/wordpress/customize-preview.js' ),
		array( 'customize-preview', 'customize-selective-refresh', 'jquery', 'architecture-customize-helpers' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}


/**
* Enqueue scripts for the customizer.
*
* @since architecture 1.0
*
* @return void
*/
function architecture_customize_controls_enqueue_scripts() {

	wp_enqueue_script(
		'architecture-customize-helpers',
		get_theme_file_uri( '/assets/scripts/js/wordpress/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}




/**
* Calculate classes for the main <html> element.
*
* @since architecture 1.0
*
* @return void
*/
function architecture_the_html_classes() {
/**
 * Filters the classes for the main <html> element.
 *
 * @since architecture 1.0
 *
 * @param string The list of classes. Default empty string.
 */
$classes = apply_filters( 'architecture_html_classes', '' );
if ( ! $classes ) {
	return;
}
echo 'class="' . esc_attr( $classes ) . '"';
}


/* ________________________________________________ COPYRIGHT */
function architecture_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results(
		"SELECT
			YEAR(min(post_date_gmt)) AS firstdate,
			YEAR(max(post_date_gmt)) AS lastdate
		FROM
			$wpdb->posts
		WHERE
			post_status = 'publish'
			");
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

	/************* THEME CUSTOMIZE *********************/

	/*
	  A good tutorial for creating your own Sections, Controls and Settings:
	  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

	  Good articles on modifying the default options:
	  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
	  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162

	  To do:
	  - Create a js for the postmessage transport method
	  - Create some sanitize functions to sanitize inputs
	  - Create some boilerplate Sections, Controls and Settings
	*/

	function architecture_theme_customizer($wp_customize) {
	  // $wp_customize calls go here.
	  //
	  // Uncomment the below lines to remove the default customize sections

	   $wp_customize->remove_section('title_tagline');
	   $wp_customize->remove_section('colors');
	   $wp_customize->remove_section('background_image');
	   $wp_customize->remove_section('static_front_page');
	   $wp_customize->remove_section('nav');

	  // Uncomment the below lines to remove the default controls
	   $wp_customize->remove_control('blogdescription');

	  // Uncomment the following to change the default section titles
	//   $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
	//   $wp_customize->get_section('background_image')->title = __( 'Images' );
	}

	/*
	This is a modification of a function found in the
	twentythirteen theme where we can declare some
	external fonts. If you're using Google Fonts, you
	can replace these fonts, change it in your scss files
	and be up and running in seconds.
	*/
	function architecture_fonts() {
	  wp_enqueue_style('architecture_fontface');
	}



	/* DON'T DELETE THIS CLOSING TAG */ ?>
