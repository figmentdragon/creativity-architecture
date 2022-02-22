<?php
/**
 * Custom Functions
 */

function MYTHEME_functions() {
  add_action( 'after_switch_theme', 'MYTHEME_setup_options' );
  add_action( 'template_redirect', 'MYTHEME_template_redirect' );
  add_action( 'wp_enqueue_scripts', 'MYTHEME_scripts' );

  add_filter( 'excerpt_length', 'MYTHEME_excerpt_length', 999 );
  add_filter( 'excerpt_more', 'MYTHEME_excerpt_more' );
  add_filter( 'the_content_more_link', 'MYTHEME_more_link', 10, 2 );
}
function MYTHEME_template_redirect() {
  $layout = MYTHEME_get_theme_layout();

  if ( 'no-sidebar-full-width' === $layout ) {
    $GLOBALS['content_width'] = 1510;
  }
}
$deps[] = 'jquery';

$enable_portfolio = get_theme_mod( 'MYTHEME_portfolio_option', 'disabled' );

if ( MYTHEME_check_section( $enable_portfolio ) ) {
  $deps[] = 'jquery-masonry';
}

$enable_featured_content = get_theme_mod( 'MYTHEME_featured_content_option', 'disabled' );

//Slider Scripts
$enable_slider      = MYTHEME_check_section( get_theme_mod( 'MYTHEME_slider_option', 'disabled' ) );

$enable_testimonial_slider      = MYTHEME_check_section( get_theme_mod( 'MYTHEME_testimonial_option', 'disabled' ) ) && get_theme_mod( 'MYTHEME_testimonial_slider', 1 );

if ( $enable_slider || $enable_testimonial_slider ) {
  // Enqueue owl carousel css. Must load CSS before JS.
  wp_enqueue_style( 'owl-carousel-core', get_theme_file_uri( 'assets/scripts/css/owl-carousel/owl.carousel.min.css' ), null, '2.3.4' );
  wp_enqueue_style( 'owl-carousel-default', get_theme_file_uri( 'assets/scripts/css/owl-carousel/owl.theme.default.min.css' ), null, '2.3.4' );

  // Enqueue script
  wp_enqueue_script( 'owl-carousel', get_theme_file_uri( $path . 'owl.carousel' . $min . '.js' ), array( 'jquery' ), '2.3.4', true );

  $deps[] = 'owl-carousel';

}
$enable_testimonial_slider      = MYTHEME_check_section( get_theme_mod( 'MYTHEME_testimonial_option', 'disabled' ) ) && get_theme_mod( 'MYTHEME_testimonial_slider', 1 );
}

wp_enqueue_script( 'MYTHEME_script', get_theme_file_uri( $path . 'functions' . $min . '.js' ), $deps, '201800703', true );

wp_localize_script( 'MYTHEME-script', 'MYTHEMEOptions', array(
  'screenReaderText' => array(
    'expand'   => esc_html__( 'expand child menu', 'MYTHEME' ),
    'collapse' => esc_html__( 'collapse child menu', 'MYTHEME' ),
    'icon'     => MYTHEME_get_svg( array(
        'icon'     => 'angle-down',
        'fallback' => true,
      )
    ),
  ),
  'iconNavPrev'     => MYTHEME_get_svg( array(
      'icon'     => 'angle-left',
      'fallback' => true,
    )
  ),
  'iconNavNext'     => MYTHEME_get_svg( array(
      'icon'     => 'angle-right',
      'fallback' => true,
    )
  ),
  'iconTestimonialNavPrev'     => '<span>' . esc_html__( 'PREV', 'MYTHEME' ) . '</span>',
  'iconTestimonialNavNext'     => '<span>' . esc_html__( 'NEXT', 'MYTHEME' ) . '</span>',
  'rtl' => is_rtl(),
  'dropdownIcon'     => MYTHEME_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
) );

function MYTHEME_custom_image_sizes( $sizes ) {
    return array_merge( $sizes,
      array(
        'MYTHEME-thumb-600' => __('600px by 150px'),
        'MYTHEME-thumb-300' => __('300px by 100px'),
      )
    );
  }
function MYTHEME_setup_options( $old_theme_name ) {
  	if ( $old_theme_name ) {
  		$old_theme_slug = sanitize_title( $old_theme_name );
  		$free_version_slug = array(
  			'MYTHEME',
  		);

  		$pro_version_slug  = 'MYTHEME';

  		$free_options = get_option( 'theme_mods_' . $old_theme_slug );

  		// Perform action only if theme_mods_photoFocus free version exists.
  		if ( in_array( $old_theme_slug, $free_version_slug ) && $free_options && '1' !== get_theme_mod( 'free_pro_migration' ) ) {
  			$new_options = wp_parse_args( get_theme_mods(), $free_options );

  			if ( update_option( 'theme_mods_' . $pro_version_slug, $free_options ) ) {
  				// Set Migration Parameter to true so that this script does not run multiple times.
  				set_theme_mod( 'free_pro_migration', '1' );
  			}
  		}
  	}
  }





  $deps[] = 'jquery';

	$enable_portfolio = get_theme_mod( 'MYTHEME_portfolio_option', 'disabled' );

	if ( MYTHEME_check_section( $enable_portfolio ) ) {
		$deps[] = 'jquery-masonry';
	}

	$enable_featured_content = get_theme_mod( 'MYTHEME_featured_content_option', 'disabled' );

	//Slider Scripts
	$enable_slider      = MYTHEME_check_section( get_theme_mod( 'MYTHEME_slider_option', 'disabled' ) );

	$enable_testimonial_slider      = MYTHEME_check_section( get_theme_mod( 'MYTHEME_testimonial_option', 'disabled' ) ) && get_theme_mod( 'MYTHEME_testimonial_slider', 1 );

	if ( $enable_slider || $enable_testimonial_slider ) {
		// Enqueue owl carousel css. Must load CSS before JS.
		wp_enqueue_style( 'owl-carousel-core', get_theme_file_uri( 'assets/css/owl-carousel/owl.carousel.min.css' ), null, '2.3.4' );
		wp_enqueue_style( 'owl-carousel-default', get_theme_file_uri( 'assets/css/owl-carousel/owl.theme.default.min.css' ), null, '2.3.4' );

		// Enqueue script
		wp_enqueue_script( 'owl-carousel', get_theme_file_uri( $path . 'owl.carousel' . $min . '.js' ), array( 'jquery' ), '2.3.4', true );

		$deps[] = 'owl-carousel';

	}

  function MYTHEME_entry_category( $echo = true ) {
  	$output = '';

  		// Hide category and tag text for pages.
  		if ( 'post' === get_post_type() ) {
  			/* translators: used between list items, there is a space after the comma */
  			$categories_list = get_the_category_list( ' ' );
  			if ( $categories_list ) {
  				/* translators: 1: list of categories. */
  				$output = sprintf( '<span class="cat-links">%1$s%2$s</span>',
  					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'MYTHEME' ) ),
  					$categories_list
  				); // WPCS: XSS OK.
  			}
  		}

  		if ( 'ect-service' === get_post_type() || 'featured-content' === get_post_type() || 'jetpack-portfolio' === get_post_type() ) {
  			/* translators: used between list items, there is a space after the comma */
  			$term_list = get_the_term_list( get_the_ID(), get_post_type() . '-type' );
  			if ( $term_list ) {
  				/* translators: 1: list of categories. */
  				$output = sprintf( '<span class="cat-links">%1$s%2$s</span>',
  					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'MYTHEME' ) ),
  					$term_list
  				); // WPCS: XSS OK.
  			}
  		}

  		if ( $echo ) {
  			echo $output;
  		} else {
  			return $output;
  		}
  	}

    function MYTHEME_comment( $comment, $args, $depth ) {
    		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

    		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
    			<div class="comment-body">
    				<?php esc_html_e( 'Pingback:', 'MYTHEME' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'MYTHEME' ), '<span class="edit-link">', '</span>' ); ?>
    			</div>

    		<?php else : ?>

    		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
    			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

    				<div class="comment-author vcard">
    					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    				</div><!-- .comment-author -->

    				<div class="comment-container">
    					<header class="comment-meta">
    						<?php printf( __( '%s <span class="says screen-reader-text">says:</span>', 'MYTHEME' ), sprintf( '<cite class="fn author-name">%s</cite>', get_comment_author_link() ) ); ?>

    						<a class="comment-permalink entry-meta" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
    						<?php echo MYTHEME_get_svg( array( 'icon' => 'clock-o' ) ); ?>
    						<time datetime="<?php comment_time( 'c' ); ?>"><?php printf( esc_html__( '%s ago', 'MYTHEME' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
    					<?php edit_comment_link( esc_html__( 'Edit', 'MYTHEME' ), '<span class="edit-link">', '</span>' ); ?>
    					</header><!-- .comment-meta -->

    					<?php if ( '0' == $comment->comment_approved ) : ?>
    						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'MYTHEME' ); ?></p>
    					<?php endif; ?>

    					<div class="comment-content">
    						<?php comment_text(); ?>
    					</div><!-- .comment-content -->

    					<?php
    						comment_reply_link( array_merge( $args, array(
    							'add_below' => 'div-comment',
    							'depth'     => $depth,
    							'max_depth' => $args['max_depth'],
    							'before'    => '<span class="reply">',
    							'after'     => '</span>',
    						) ) );
    					?>
    				</div><!-- .comment-content -->

    			</article><!-- .comment-body -->
    		<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>

    		<?php
    		endif;
    	}
function MYTHEME_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	// Getting data from Customizer Options
	$length	= get_theme_mod( 'MYTHEME_excerpt_length', 30 );
		return absint( $length );
	}
function MYTHEME_excerpt_more( $more ) {
  if ( is_admin() ) {
    return $more;
  }
  $more_tag_text = get_theme_mod( 'MYTHEME_excerpt_more_text',  esc_html__( 'Continue reading', 'MYTHEME' ) );

  $link = sprintf( '<p class="more-link"><a class="button" href="%1$s" class="readmore">%2$s</a></p>',
  esc_url( get_permalink() ),
  /* translators: %s: Name of current post */
  wp_kses_data( $more_tag_text ) . '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
  );
  return $link;

  }
function MYTHEME_more_link( $more_link, $more_link_text ) {
	$more_tag_text = get_theme_mod( 'MYTHEME_excerpt_more_text', esc_html__( 'Continue reading', 'MYTHEME' ) );
	return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
}
