<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package THEMENAE
 */


/**
 * Adds custom overlay for Promotion Headline Background Image
 */
function promo_head_bg_image_overlay_css() {
	$overlay = get_theme_mod( 'promo_head_background_image_opacity', '0' );
	$css = '';
	$overlay_bg = $overlay / 100;
	if ( $overlay ) {
		$css = '.promotion-section .post-thumbnail-background:before {
					background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
			    } '; // Dividing by 100 as the option is shown as % for user
	}
	wp_add_inline_style( 'style', $css );
}
add_action( 'wp_enqueue_scripts', 'promo_head_bg_image_overlay_css', 11 );

/**
 * Adds custom overlay for Header Media
 */
function header_media_image_overlay_css() {
	$overlay = get_theme_mod( 'header_media_image_opacity' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
	$css = '.custom-header-overlay {
		background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
    } '; // Dividing by 100 as the option is shown as % for user
}
	wp_add_inline_style( 'style', $css );
}
add_action( 'wp_enqueue_scripts', 'header_media_image_overlay_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}

	}
}
add_action( 'pre_get_posts', 'alter_home' );

/**
 * Display navigation/pagination when applicable
 *
 * @since 1.0
 */
function content_nav() {
	global $wp_query;

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
		return;
	}

	$pagination_type = get_theme_mod( 'pagination_type', 'default' );

	if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
		// Support infinite scroll plugins.
		the_posts_navigation();
	} elseif ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
		the_posts_pagination( array(
			'prev_text'          => '<span>' . esc_html__( 'Prev', '__THEMENAE__' ) . '</span>',
			'next_text'          => '<span>' . esc_html__( 'Next', '__THEMENAE__' ) . '</span>',
			'screen_reader_text' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', '__THEMENAE__' ) . ' </span>',
		) );
	} else {
		the_posts_navigation();
	}
}


/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since 1.0
 */
function get_first_image( $postID, $size, $attr, $src = false ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if ( isset( $matches[1][0] ) ) {
		// Get first image.
		$first_img = $matches[1][0];

		if ( $src ) {
			//Return url of src is true
			return $first_img;
		}

		return '<img class="wp-post-image" src="'. esc_url( $first_img ) .'">';
	}

	return false;
}

function get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$layout = 'no-sidebar';
	} elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} else {
		$layout = get_theme_mod( 'default_layout', 'right-sidebar' );

		if ( is_home() || is_archive() ) {
			$layout = get_theme_mod( 'homepage_archive_layout', 'right-sidebar' );
		}
	}

	return $layout;
}

function get_sidebar_id() {
	$sidebar = $id = '';
	$layout = get_theme_layout();
	if ( 'no-sidebar' === $layout ) {
		return $sidebar;
	}
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}
	return $sidebar;
}


/**
 * Return a phrase shortened in length to a maximum number of characters.
 *
 * Result will be truncated at the last white space in the original string. In this function the word separator is a
 * single space. Other white space characters (like newlines and tabs) are ignored.
 *
 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
 *
 * @since 1.0
 *
 * @param string $text            A string to be shortened.
 * @param integer $max_characters The maximum number of characters to return.
 *
 * @return string Truncated string
 */
function truncate_phrase( $text, $max_characters ) {
	$text = trim( $text );
	if ( mb_strlen( $text ) > $max_characters ) {
		//* Truncate $text to $max_characters + 1
		$text = mb_substr( $text, 0, $max_characters + 1 );
		//* Truncate to the last space in the truncated string
		$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
	}
	return $text;
}

function get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {
	$content = get_the_content( '', $stripteaser );
	// Strip tags and shortcodes so the content truncation count is done correctly.
	$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );
	// Remove inline styles / .
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );
	// Truncate $content to $max_char
	$content = truncate_phrase( $content, $max_characters );
	// More link?
	if ( $more_link_text ) {
		$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="readmore"><a href="%s" class="more-link">%s</a></span>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
		$output = sprintf( '<p>%s %s</p>', $content, $link );
	} else {
		$output = sprintf( '<p>%s</p>', $content );
		$link = '';
	}
	return apply_filters( 'get_the_content_limit', $output, $content, $link, $max_characters );
}

function content_image() {
	if ( has_post_thumbnail() && jetpack_featured_image_display() && is_singular() ) {
		global $post, $wp_query;

		// Get Page ID outside Loop.
		$page_id = $wp_query->get_queried_object_id();

		if ( $post ) {
	 		if ( is_attachment() ) {
				$parent = $post->post_parent;

				$individual_featured_image = get_post_meta( $parent, 'featured-image', true );
			} else {
				$individual_featured_image = get_post_meta( $page_id, 'featured-image', true );
			}
		}

		if ( empty( $individual_featured_image ) ) {
			$individual_featured_image = 'default';
		}

		if ( 'disable' === $individual_featured_image ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		} else {
			$class = array();

			$image_size = 'post-thumbnail';

			if ( 'default' !== $individual_featured_image ) {
				$image_size = $individual_featured_image;
				$class[]    = 'from-metabox';
			} else {
				$layout = get_theme_layout();

				if ( 'no-sidebar-full-width' === $layout ) {
					$image_size = 'post-thumbnail';
				}
			}

			$class[] = $individual_featured_image;
			?>
			<div class="post-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
				<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( $image_size ); ?>
				</a>
			</div>
	   	<?php
		}
	} // End if ().
}

function sections( $selector = 'header' ) {
	get_template_part( 'template-parts/header/header-media' );
	get_template_part( 'template-parts/display/display-slider' );
	get_template_part( 'template-parts/display/display-portfolio' );
	get_template_part( 'template-parts/content/content-hero' );
	get_template_part( 'template-parts/display/display-testimonial' );
	get_template_part( 'template-parts/display/display-services' );
	get_template_part( 'template-parts/display/display-featured' );
}

function post_thumbnail( $image_size = 'post-thumbnail', $type = 'html', $echo = true, $no_thumb = false ) {
	$image = $image_url = '';

	if ( has_post_thumbnail() ) {
		$image_url = get_the_post_thumbnail_url( get_the_ID(), $image_size );
		$image     = get_the_post_thumbnail( get_the_ID(), $image_size );
	} else {
		if ( is_array( $image_size ) && $no_thumb ) {
			$image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb-' . $image_size[0] . 'x' . $image_size[1] . '.jpg';
			$image      = '<img src="' . esc_url( $image_url ) . '" alt="" />';
		} elseif ( $no_thumb ) {
			global $_wp_additional_image_sizes;

			$image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb-1920x822.jpg';

			if ( array_key_exists( $image_size, $_wp_additional_image_sizes ) ) {
				$image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb-' . $_wp_additional_image_sizes[ $image_size ]['width'] . 'x' . $_wp_additional_image_sizes[ $image_size ]['height'] . '.jpg';
			}

			$image      = '<img src="' . esc_url( $image_url ) . '" alt="" />';
		}

		// Get the first image in page, returns false if there is no image.
		$first_image_url = get_first_image( get_the_ID(), $image_size, '', true );

		// Set value of image as first image if there is an image present in the page.
		if ( $first_image_url ) {
			$image_url = $first_image_url;
			$image = '<img class="wp-post-image" src="'. esc_url( $image_url ) .'">';
		}
	}

	if ( ! $image_url ) {
		// Bail if there is no image url at this stage.
		return;
	}

	if ( 'url' === $type ) {
		return $image_url;
	}

	$output = '<div';

	if ( 'html-with-bg' === $type ) {
		$output .= ' class="post-thumbnail-background" style="background-image: url( ' . esc_url( $image_url ) . ' )"';
	} else {
		$output .= ' class="post-thumbnail"';
	}

	$output .= '>';

	if ( 'html-with-bg' !== $type ) {
		$output .= '<a href="' . esc_url( get_the_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '">' . $image;
	} else {
		$output .= '<a class="cover-link" href="' . esc_url( get_the_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
	}

	$output .= '</a></div><!-- .post-thumbnail -->';

	if ( ! $echo ) {
		return $output;
	}

	echo $output;
}

if ( ! function_exists ( 'get_social' ) ) {
function get_social($echo = true){

	$link_enabled = 0;

	$social_link = '';
	$fb_link      = esc_url(get_theme_mod('facebook'));
	$twitter_link = esc_url(get_theme_mod('twitter'));
	$insta_link   = esc_url(get_theme_mod('instagram'));
	$github_link   = esc_url(get_theme_mod('github'));
	$linked_link  = esc_url(get_theme_mod('linkedin'));
	$ytube_link   = esc_url(get_theme_mod('youtube'));
	$pint_link    = esc_url(get_theme_mod('pinterest'));
	$drib_link    = esc_url(get_theme_mod('dribble'));


	if($fb_link):
		$social_link .='<li><a href="'.$fb_link.'" target="_blank"><span class="fa fa-facebook"></span></a></li>';
		$link_enabled++;
	endif;

	if($twitter_link):
		$social_link .='<li><a href="'.$twitter_link.'" target="_blank"><span class="fa fa-twitter"></span></a></li>';
		$link_enabled++;
	endif;

	if($insta_link):
		$social_link .='<li><a href="'.$insta_link.'" target="_blank"><span class="fa fa-instagram"></span></a></li>';
		$link_enabled++;
	endif;

	if($github_link):
		$social_link .='<li><a href="'.$github_link.'" target="_blank"><span class="fa fa-github"></span></a></li>';
		$link_enabled++;
	endif;

	if($linked_link):
		$social_link .='<li><a href="'.$linked_link.'" target="_blank"><span class="fa fa-linkedin"></span></a></li>';
		$link_enabled++;
	endif;

	if($ytube_link):
		$social_link .='<li><a href="'.$ytube_link.'" target="_blank"><span class="fa fa-youtube"></span></a></li>';
		$link_enabled++;
	endif;

	if($pint_link):
		$social_link .='<li><a href="'.$pint_link.'" target="_blank"><span class="fa fa-pinterest-p"></span></a></li>';
		$link_enabled++;
	endif;

	if($drib_link):
		$social_link .='<li><a href="'.$drib_link.'" target="_blank"><span class="fa fa-dribbble"></span></a></li>';
		$link_enabled++;
	endif;

	$social_link_output = '';
	$button_style = esc_html(get_theme_mod('social_button_style', 'default-colors'));

	if($link_enabled > 0):
		$social_link_output .='
		<div class="site-header-top-right site-column-3">
			<nav id="social-navigation" class="social-navigation '.$button_style.'"><ul>'.$social_link.'</ul></nav>
		</div>';
	endif;

	if($echo)
		echo $social_link_output;
	else
	return $social_link_output;

}

if ( ! function_exists ( 'social_sharing_buttons' ) ) {
function social_sharing_buttons() {
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


if ( ! function_exists ( 'pagenavi' ) ) {
function pagenavi(){

	the_posts_pagination( array(
		'mid_size' => 2,
		'prev_text' => __( '&larr; Previous', '__THEMENAE__' ),
		'next_text' => __( 'Next &rarr;', '__THEMENAE__' ),
	) );

}
}

if ( ! function_exists ( 'comment_list' ) ) {
function comment_list( $comment, $args, $depth ) {

    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
      case 'pingback' :  // 1
      case 'trackback' : // 1
    ?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', '__THEMENAE__' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', '__THEMENAE__' ), '<span class="edit-link">', '</span>' ); ?></p>
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
        ( $comment->user_id === $post->post_author ) ? '<span class="bypostauthor">' . __( 'Post<br>Author', '__THEMENAE__' ) . '</span>' : ''
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
            sprintf( __( '%1$s at %2$s', '__THEMENAE__' ),
              get_comment_date(),
              get_comment_time()
            )
          );
          edit_comment_link( __( '<i class="icon-edit"></i> Edit', '__THEMENAE__' ) );
          ?>
		  <div class="comment-reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div><!-- .reply -->

        </header>
        <?php if ( '0' == $comment->comment_approved ) : ?>
          <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', '__THEMENAE__' ); ?></p>
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

if ( ! function_exists ( 'trim_excerpt' ) ) {
function trim_excerpt($text) {

  return str_replace('[&hellip;]', '&hellip;', $text);

}
add_filter('excerpt_more', 'trim_excerpt');
}

if ( ! function_exists ( 'enqueue_comments_reply' ) ) {
function enqueue_comments_reply() {
	if( get_option( 'thread_comments' ) )  {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'comment_form_before', 'enqueue_comments_reply' );

}

if (( ! function_exists ( 'woo_dequeue_styles' )) && class_exists( 'WooCommerce' ) ) {
	// Remove each woocomerce style one by one
	add_filter( 'woocommerce_enqueue_styles', 'woo_dequeue_styles' );
	function woo_dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
		//unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
		//unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
		return $enqueue_styles;
	}
}
?>