<?php
/* Welcome to MYTHEME :)
This is the core MYTHEME file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/MYTHEME/

  - head cleanup (remove rsd, uri links, junk css, ect)
  - enqueueing scripts & styles
  - theme support functions
  - custom menu output & fallbacks
  - related post function
  - page-navi function
  - removing <p> from around images
  - customizing the post excerpt

*/

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function MYTHEME_head_cleanup() {
  remove_action( 'set_comment_cookies', 'wp_set_comment_cookies');
	// category feeds
  remove_action( 'wp_head', 'feed_links_extra', 3);
	// post and comment feeds
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'index_rel_link');
	// EditURI link
  remove_action( 'wp_head', 'rsd_link');
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7);
	// start link
  remove_action( 'wp_head', 'start_post_rel_link');
	// links for adjacent posts
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head');
	// WP version
  remove_action( 'wp_head', 'wp_generator');
	remove_action( 'wp_head', 'wlwmanifest_link');
  remove_action( 'wp_head', 'wp_shortlink_wp_head');
	remove_action( 'wp_print_styles', 'print_emoji_styles');

	add_filter( 'pre_option_link_manager_enabled', '__return_true');
	// remove WP version from css
  add_filter( 'style_loader_src', 'MYTHEME_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
  add_filter( 'script_loader_src', 'MYTHEME_remove_wp_ver_css_js', 9999 );
	add_filter( 'show_admin_bar', '__return_false' );
	add_filter( 'single_template', 'my_single_author_template');
  add_filter( 'the_generator', '__return_false');
  add_filter( 'wp_title', 'rw_title', 10, 3 );

	if (!empty ($GLOBALS['MYTHEME'])) {
    add_action(
      'wp_head',
      function () {
        remove_action(
          current_filter(),
          [$GLOBALS['MYTHEME'], 'meta_generator_tag']
        );
      },
      0
    );
  }
} /* end MYTHEME head cleanup */

// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
  }

  return $title;

} // end better title

// remove WP version from RSS
function MYTHEME_rss_version() { return ''; }

// remove WP version from scripts
function MYTHEME_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function MYTHEME_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function MYTHEME_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function MYTHEME_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

function defer_scripts( $tag, $handle, $src ) {
  	$defer_scripts = [
      'SCRIPT_ID'
    ];
    if ( in_array( $handle, $defer_scripts ) ) {
      return '<script type="text/javascript" src="' . $src . '" defer="defer"></script>' . "\n";
    }
    return $tag;
  }

function deregister_scripts() { wp_deregister_script( 'wp-embed' ); }
function deregister_styles() { wp_dequeue_style( 'library' );  }

foreach((array)get_the_category() as $cat) :
  if(file_exists(SINGLE_PATH . '/docs/theme/site-templates/single-cat-' . $cat->slug . '.php'))
  return SINGLE_PATH . '/docs/theme/theme-template/single-cat-' . $cat->slug . '.php';
  elseif(file_exists(SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php'))
  return SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php';

  define(SINGLE_PATH, TEMPLATEPATH . 'page-templates/single');


  function my_single_author_template($single) {
    global $wp_query, $post;
    $curauth = get_userdata($wp_query->post->post_author);
    if(file_exists(SINGLE_PATH . '/single-author-' . $curauth->user_nicename . '.php'))
    return SINGLE_PATH . '/single-author-' . $curauth->user_nicename . '.php';

    elseif(file_exists(SINGLE_PATH . '/single-author-' . $curauth->ID . '.php'))
    return SINGLE_PATH . '/single-author-' . $curauth->ID . '.php';
  }
endforeach;
?>
