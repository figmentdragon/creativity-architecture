<?php
/*****************************************/
## Theme set-up functions
/*****************************************/
if ( ! function_exists ( 'MYTHEME_setup' ) ) {
add_action('after_setup_theme', 'MYTHEME_setup');
function MYTHEME_setup(){

	load_theme_textdomain( 'MYTHEME', get_template_directory().'/languages' );
	
	add_theme_support('post-thumbnails'); // Add theme support for post thumbnails (featured images).
	add_theme_support('automatic-feed-links');  // Add theme support for automatic feed links.
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	
	$defaults = array(
		'default-color'          => '',
		'default-image'          => '',
		'default-repeat'         => '',
		'default-position-x'     => '',
		'default-attachment'     => '',
		
	);
	add_theme_support( 'custom-background', $defaults );
	
	add_theme_support( 'custom-logo', array(
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	add_theme_support('post-formats', array( 'link', 'gallery', 'quote', 'image', 'video', 'audio' ) );
	// Adds support for a variety of post formats.
	
	add_action( 'wp_enqueue_scripts', 'MYTHEME_enqueue_styles_scripts' );
	add_action( 'admin_enqueue_scripts', 'MYTHEME_enqueue_styles_scripts' );
	//add_action( 'wp_enqueue_scripts', 'MYTHEME_enqueue_scripts' );
	//add_action( 'wp_enqueue_scripts', 'MYTHEME_custom_enqueue_script' );
	add_image_size ( 'MYTHEME-slider', 1600, 9999, false );
	add_image_size ( 'MYTHEME-post-image', 780, 9999, false );
	
	//remove_filter( 'the_content', 'wpautop' );
	//add_filter( 'the_content', 'wpautop' , 12);
	
	add_theme_support( 'woocommerce' );
	
}
}

/**********************************************/
## Attach stylesheets & javascripts
/**********************************************/
if ( ! function_exists ( 'MYTHEME_enqueue_styles_scripts' ) ) {
	function MYTHEME_enqueue_styles_scripts() {

		$MYTHEME_uri_path   = get_template_directory_uri();
		$MYTHEME_font_url   = esc_attr(get_theme_mod('MYTHEME_font_url'));
		$slider_status     = esc_attr(get_theme_mod('MYTHEME_slider_enable', 'enable'));
		
		if (is_admin() ):
			wp_enqueue_script('MYTHEME-admin-custom-script', $MYTHEME_uri_path . '/assets/js/admin/MYTHEME-admin.js', array('jquery'), '1.0.0', true);
			
		else:
		wp_enqueue_style('MYTHEME-style', $MYTHEME_uri_path . '/style.css', null, false, 'all');
		
		if ( is_rtl() ) // if RTL language enabled.
		wp_enqueue_style('MYTHEME-rtl-style', $MYTHEME_uri_path . '/assets/css/style-rtl.css', null, false, 'all');
		else
		wp_enqueue_style('MYTHEME-main-style', $MYTHEME_uri_path . '/assets/css/style-ltr.css', null, false, 'all');
		
		if ( class_exists( 'WooCommerce' ) ):
			wp_enqueue_style('MYTHEME-woocommerce-style', $MYTHEME_uri_path . '/assets/css/woocommerce.css', null, false, 'all');
		endif;

		if($MYTHEME_font_url != ''):
			wp_enqueue_style('MYTHEME-google_fonts',$MYTHEME_font_url , null, false, 'all');
		endif;

		/********************************************/
		## Attach theme javascripts.
		/*******************************************/
		wp_enqueue_script('MYTHEME-pace', $MYTHEME_uri_path . '/assets/js/pace.min.js', array('jquery'), '1.0.0', true);
		
		wp_enqueue_script('MYTHEME-modernizr', $MYTHEME_uri_path . '/assets/js/modernizr.js', array('jquery'), '1.0.0', true);
		
		wp_enqueue_script('MYTHEME-cssua', $MYTHEME_uri_path . '/assets/js/cssua.min.js', array('jquery'), '1.0.0', true);
		
		wp_enqueue_script('MYTHEME-carousel', $MYTHEME_uri_path . '/assets/js/slick.min.js', array('jquery'), '1.0.0', true);
		
		wp_enqueue_script('MYTHEME-fitvids', $MYTHEME_uri_path . '/assets/js/jquery.fitvids.js', array('jquery'), '1.0.0', true);
		
		wp_enqueue_script('MYTHEME-scrollUp', $MYTHEME_uri_path . '/assets/js/jquery.scrollUp.min.js', array('jquery'), '1.0.0', true);

		/********************************************************/
		## custom footer js script
		/*********************************************************/
		wp_enqueue_script( 'MYTHEME-main-js', $MYTHEME_uri_path . '/assets/js/main.js', $MYTHEME_uri_path . '/assets/js/main.js', array('jquery'), '1.0.0', true);
		
		
		if($slider_status == 'enable'):
		   $slider_speed  = esc_attr(get_theme_mod('MYTHEME_slider_duration', '5000'));
		   
		    wp_add_inline_script('MYTHEME-main-js', 'jQuery(document).ready(function($){
				jQuery("#site-banner-carousel").slick({ dots: true, infinite: true,slidesToShow: 1,  slidesToScroll: 1, autoplay: true,autoplaySpeed: '.$slider_speed.', pauseOnHover: true,
				arrows: true,prevArrow : \'<span class="slick-prev"></span>\',nextArrow : \'<span class="slick-next"></span>\',customPaging: function(slider, i) {return \'<span>\' + (i + 1) + \'</span>\';},cssEase: \'ease-in-out\', easing: \'ease-in-out\',lazyLoad: true,
				rtl: RTL,responsive: [{ breakpoint: 1200, settings: {	slidesToShow: 1  }}]});});');
		endif;
		
		
		endif;
	}
}
/**
 * Registers an editor stylesheet for the theme.
 */
if ( ! function_exists ( 'MYTHEME_add_editor_styles' ) ) {
function MYTHEME_add_editor_styles() {
	$MYTHEME_uri_path   = get_template_directory_uri();
	
    add_editor_style( $MYTHEME_uri_path . '/assets/css/admin/editor.css' );
}
add_action( 'admin_init', 'MYTHEME_add_editor_styles' );
}

/**************************************************/
## body class filter.
/**************************************************/
if ( ! function_exists ( 'MYTHEME_body_class' ) ) {
add_filter('body_class', 'MYTHEME_body_class' );

function MYTHEME_body_class($classes){
	
	$classes[] = 'theme-header4';
	
    return $classes;
	
}
}
if ( ! function_exists ( 'MYTHEME_post_class' ) ) {
add_filter('post_class', 'MYTHEME_post_class' );

function MYTHEME_post_class($classes) {

	$classes[] = 'entry entry-center';
	
	return $classes;
}
}
/****************************************************/
## Social icons list
/****************************************************/
if ( ! function_exists ( 'MYTHEME_get_social' ) ) {
function MYTHEME_get_social($echo = true){
	
	$link_enabled = 0;
	
	$social_link = '';
	$MYTHEME_fb_link      = esc_url(get_theme_mod('MYTHEME_facebook'));
	$MYTHEME_twitter_link = esc_url(get_theme_mod('MYTHEME_twitter'));
	$MYTHEME_insta_link   = esc_url(get_theme_mod('MYTHEME_instagram'));
	$MYTHEME_github_link   = esc_url(get_theme_mod('MYTHEME_github'));
	$MYTHEME_linked_link  = esc_url(get_theme_mod('MYTHEME_linkedin'));
	$MYTHEME_ytube_link   = esc_url(get_theme_mod('MYTHEME_youtube'));
	$MYTHEME_pint_link    = esc_url(get_theme_mod('MYTHEME_pinterest'));
	$MYTHEME_drib_link    = esc_url(get_theme_mod('MYTHEME_dribble'));

	
	if($MYTHEME_fb_link):
		$social_link .='<li><a href="'.$MYTHEME_fb_link.'" target="_blank"><span class="fa fa-facebook"></span></a></li>';
		$link_enabled++;
	endif;
	
	if($MYTHEME_twitter_link):
		$social_link .='<li><a href="'.$MYTHEME_twitter_link.'" target="_blank"><span class="fa fa-twitter"></span></a></li>';
		$link_enabled++;
	endif;

	if($MYTHEME_insta_link):
		$social_link .='<li><a href="'.$MYTHEME_insta_link.'" target="_blank"><span class="fa fa-instagram"></span></a></li>';
		$link_enabled++;
	endif;
	
	if($MYTHEME_github_link):
		$social_link .='<li><a href="'.$MYTHEME_github_link.'" target="_blank"><span class="fa fa-github"></span></a></li>';
		$link_enabled++;
	endif;
	
	if($MYTHEME_linked_link):
		$social_link .='<li><a href="'.$MYTHEME_linked_link.'" target="_blank"><span class="fa fa-linkedin"></span></a></li>';
		$link_enabled++;
	endif;
	
	if($MYTHEME_ytube_link):
		$social_link .='<li><a href="'.$MYTHEME_ytube_link.'" target="_blank"><span class="fa fa-youtube"></span></a></li>';
		$link_enabled++;
	endif;
	
	if($MYTHEME_pint_link):
		$social_link .='<li><a href="'.$MYTHEME_pint_link.'" target="_blank"><span class="fa fa-pinterest-p"></span></a></li>';
		$link_enabled++;
	endif;
	
	if($MYTHEME_drib_link):
		$social_link .='<li><a href="'.$MYTHEME_drib_link.'" target="_blank"><span class="fa fa-dribbble"></span></a></li>';
		$link_enabled++;
	endif;
	
	$social_link_output = '';
	$MYTHEME_button_style = esc_html(get_theme_mod('MYTHEME_social_button_style', 'default-colors'));
	
	if($link_enabled > 0):
		$social_link_output .='
		<div class="site-header-top-right site-column-3">
			<nav id="social-navigation" class="social-navigation '.$MYTHEME_button_style.'"><ul>'.$social_link.'</ul></nav>
		</div>';
	endif;
	
	if($echo)
		echo $social_link_output;
	else
	return $social_link_output;
 
}
}

/***************************************************/
## social share buttons.
/***************************************************/
if ( ! function_exists ( 'MYTHEME_social_sharing_buttons' ) ) {
function MYTHEME_social_sharing_buttons() {
	global $post;
	// Show this on post only. if social shared enabled.
	
	// Get current page URL
	$shortURL = get_permalink();
		
	// Get current page title
	$shortTitle = get_the_title();
	$postmediaurl = get_the_post_thumbnail_url($post->id);
	// Construct sharing URL without using any script
	$twitterURL = esc_url('http://twitter.com/share?text='.$shortTitle.'&url='.$shortURL);
	$facebookURL = esc_url('https://www.facebook.com/sharer/sharer.php?u='.$shortURL);
	$linkedInURL = esc_url('https://www.linkedin.com/shareArticle?mini=true&url='.$shortURL.'&title='.$shortTitle);
	//$googleURL = esc_url('https://plus.google.com/share?url='.$shortURL);
	//$bufferURL = 'https://bufferapp.com/add?url='.$shortURL.'&amp;text='.$shortTitle;
	$pinterestURL = esc_url('http://pinterest.com/pin/create/button/?url='.$shortURL.'&media='.$postmediaurl.'&description='.$shortTitle);
	
	// Add sharing button at the end of page/page content
	$content = '<ul>';
	
	$content .= '<li><a href="'.$facebookURL.'" onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;"><span class="fa fa-facebook"></span></a></li>';
	
	$content .= '<li><a href="'. $twitterURL .'" onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;"><span class="fa fa-twitter"></span></a></li>';
	
	$content .= '<li><a href="'. $linkedInURL .'" onclick="window.open(this.href, \'linkedIn-share\', \'width=550,height=550\');return false;"><span class="fa fa-linkedin"></span></a></li>';
	
	$content .= '<li><a href="#" onclick="window.open(\''.$pinterestURL.'\', \'pinterest-share\', \'width=490,height=530\');return false;"><span class="fa fa-pinterest-p"></span></a></li>';
	
	/* $content .= '<li><a href="'.$googleURL.'" onclick="window.open(this.href, \'google-plus-share\', \'width=490,height=530\');return false;"><span class="fa fa-google-plus"></span></a></li>'; */
		
	$content .= '</ul>';
	
	return $content;
	
}
}

/**************************************************/
## pagination function
/**************************************************/
if ( ! function_exists ( 'MYTHEME_pagenavi' ) ) {
function MYTHEME_pagenavi(){

	the_posts_pagination( array(
		'mid_size' => 2,
		'prev_text' => __( '&larr; Previous', 'MYTHEME' ),
		'next_text' => __( 'Next &rarr;', 'MYTHEME' ),
	) );
	
}
}

/****************************************************/
## custom comments ping type call back function.
/****************************************************/
if ( ! function_exists ( 'MYTHEME_comment_list' ) ) {
function MYTHEME_comment_list( $comment, $args, $depth ) {

    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
      case 'pingback' :  // 1
      case 'trackback' : // 1
    ?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'MYTHEME' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'MYTHEME' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
        break;
      default : // 2
      GLOBAL $post;
      
      $avatar_variation = ' img-thumbnail';
    ?>
    <li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
      <?php
      printf( '<div class="comment-img">%1$s %2$s</div>',
         get_avatar( $comment, 120 ),
        ( $comment->user_id === $post->post_author ) ? '<span class="bypostauthor">' . __( 'Post<br>Author', 'MYTHEME' ) . '</span>' : ''
      );
      ?>
      <article id="comment-<?php comment_ID(); ?>" class="comment-meta">
        <header class="comment-header">
          <?php
          printf( '<cite class="comment-author">%1$s</cite>',
            get_comment_author_link()
          );
          printf( '<div> <a href="%1$s" class="comment-time"><time datetime="%2$s">%3$s</time></a> </div>',
            esc_url( get_comment_link( $comment->comment_ID ) ),
            get_comment_time( 'c' ),
            sprintf( __( '%1$s at %2$s', 'MYTHEME' ),
              get_comment_date(),
              get_comment_time()
            )
          );
          edit_comment_link( __( '<i class="icon-edit"></i> Edit', 'MYTHEME' ) );
          ?>
		  <div class="comment-reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div><!-- .reply -->
          
        </header>
        <?php if ( '0' == $comment->comment_approved ) : ?>
          <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'MYTHEME' ); ?></p>
        <?php endif; ?>
        <section class="comment-content">
          <?php comment_text(); ?>
        </section>
      </article>
    <?php
        break;
    endswitch;

}
}

/***********************************************************/
## excerpt filter
/***********************************************************/
if ( ! function_exists ( 'MYTHEME_trim_excerpt' ) ) {
function MYTHEME_trim_excerpt($text) {
  
  return str_replace('[&hellip;]', '&hellip;', $text);
  
}
add_filter('excerpt_more', 'MYTHEME_trim_excerpt');
}

if ( ! function_exists ( 'MYTHEME_enqueue_comments_reply' ) ) {
function MYTHEME_enqueue_comments_reply() {
	if( get_option( 'thread_comments' ) )  {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'comment_form_before', 'MYTHEME_enqueue_comments_reply' );

}
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
if ( ! function_exists ( 'MYTHEME_pingback_header' ) ) {
function MYTHEME_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'MYTHEME_pingback_header' );
}

if (( ! function_exists ( 'MYTHEME_woo_dequeue_styles' )) && class_exists( 'WooCommerce' ) ) {
	// Remove each woocomerce style one by one
	add_filter( 'woocommerce_enqueue_styles', 'MYTHEME_woo_dequeue_styles' );
	function MYTHEME_woo_dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
		//unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
		//unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
		return $enqueue_styles;
	}
}
?>
