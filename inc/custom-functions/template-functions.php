<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage MYTHEME
 * @since MYTHEME 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since MYTHEME 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function MYTHEME_body_classes( $classes ) {
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'page-template-front-page';
	}

	if( is_front_page() && ! is_home() ) {
		$classes[] = 'blog';

	}

	// Helps detect if JS is enabled or not.
	$classes[] = 'no-js';

	// Adds `singular` to singular pages, and `hfeed` to all other pages.
	$classes[] = is_singular() ? 'singular' : 'hfeed';

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	// Add a body class if there are no footer widgets.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-widgets';
	}

	// Has no post thumbnail
	if ( ! has_post_thumbnail() && is_single()) {
		$classes[] = 'no-thumbnail';
	}

	// Adds a class of (full-width) to blogs.
	$classes[] = 'fluid-layout';

	$classes[] = 'navigation-default';

	// Adds a class with respect to layout selected.
	$layout  = MYTHEME_get_theme_layout();
	$sidebar = MYTHEME_get_sidebar_id();

	$layout_class = "no-sidebar content-width-layout";

	if ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$layout_class = 'two-columns-layout content-left';
		}
	}

	$classes[] = $layout_class;

	$classes[] = 'excerpt';

	$classes['color-scheme'] = esc_attr( 'color-scheme-' . get_theme_mod( 'color_scheme', 'default' ) );

	$enable_slider = MYTHEME_check_section( get_theme_mod( 'MYTHEME_slider_option', 'disabled' ) );

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Full post thumbnail disabled

	if ( is_single() && true == esc_attr(get_theme_mod( 'MYTHEME_show_single_image', false ) ) ) {

		$classes[] = 'hide-thumbnail';

	}



	// Set blog Style.

	$MYTHEME_blog_layout = esc_attr(get_theme_mod( 'MYTHEME_blog_layout', 'default' ) );



	if ( is_home() || is_archive() && !is_single() ) {

		if ( 'large' === $MYTHEME_blog_layout ) {

			$classes[] = 'blog-large';

		} else {

			$classes[] = 'blog-default';

		}

	}





	// Set Full Post Style

	$MYTHEME_single_layout = esc_attr(get_theme_mod( 'MYTHEME_single_layout', 'single-default' ) );

	if ( is_single() ) {

		if  ( 'single-centered' === $MYTHEME_single_layout ) {

			$classes[] = 'single-centered';

		} else {

			$classes[] = 'single-default';

		}

	}

	return $classes;
}
add_filter( 'body_class', 'MYTHEME_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 *
 * @since MYTHEME 1.0
 *
 * @param array $classes An array of CSS classes.
 * @return array
 */
function MYTHEME_post_classes( $classes ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'MYTHEME_post_classes', 10, 3 );

//	Move the read more link outside of the post summary paragraph

add_filter( 'the_content_more_link', 'MYTHEME_move_more_link' );

function MYTHEME_move_more_link() {

	return '<p><a class="more-link" href="'. esc_url(get_permalink()) . '">' . esc_html__( 'Continue Reading', 'MYTHEME' ) . '</a></p>';

}

function MYTHEME_template_redirect() {
  $layout = MYTHEME_get_theme_layout();

  if ( 'no-sidebar-full-width' === $layout ) {
    $GLOBALS['content_width'] = 1510;
  }
}
$deps[] = 'jquery';



/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 *
 * @since MYTHEME 1.0
 *
 * @return void
 */
function MYTHEME_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'MYTHEME_pingback_header' );

/**
 * Remove the `no-js` class from body if JS is supported.
 *
 * @since MYTHEME 1.0
 *
 * @return void
 */
function MYTHEME_supports_js() {
	echo '<script>document.body.classList.remove("no-js");</script>';
}
add_action( 'wp_footer', 'MYTHEME_supports_js' );

/**
 * Changes comment form default fields.
 *
 * @since MYTHEME 1.0
 *
 * @param array $defaults The form defaults.
 * @return array
 */
function MYTHEME_comment_form_defaults( $defaults ) {

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $defaults['comment_field'] );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'MYTHEME_comment_form_defaults' );

/**
 * Adds custom overlay for Promotion Headline Background Image
 */
function MYTHEME_promo_head_bg_image_overlay_css() {
	$overlay = get_theme_mod( 'MYTHEME_promo_head_background_image_opacity', '0' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
		$css = '.promotion-section .post-thumbnail-background:before {
					background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
			    } '; // Dividing by 100 as the option is shown as % for user
	}

	wp_add_inline_style( 'MYTHEME-style', $css );
}
add_action( 'wp_enqueue_scripts', 'MYTHEME_promo_head_bg_image_overlay_css', 11 );

/**
 * Adds custom overlay for Header Media
 */
function MYTHEME_header_media_image_overlay_css() {
	$overlay = get_theme_mod( 'MYTHEME_header_media_image_opacity' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
	$css = '.custom-header-overlay {
		background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
    } '; // Dividing by 100 as the option is shown as % for user
}

	wp_add_inline_style( 'MYTHEME-style', $css );
}
add_action( 'wp_enqueue_scripts', 'MYTHEME_header_media_image_overlay_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function MYTHEME_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'MYTHEME_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}

	}
}
add_action( 'pre_get_posts', 'MYTHEME_alter_home' );

if ( ! function_exists( 'MYTHEME_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since MYTHEME 1.0
	 */
	function MYTHEME_content_nav() {
		global $wp_query;

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$pagination_type = get_theme_mod( 'MYTHEME_pagination_type', 'default' );

		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			the_posts_navigation();
		} elseif ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination( array(
				'prev_text'          => '<span>' . esc_html__( 'Prev', 'MYTHEME' ) . '</span>',
				'next_text'          => '<span>' . esc_html__( 'Next', 'MYTHEME' ) . '</span>',
				'screen_reader_text' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'MYTHEME' ) . ' </span>',
			) );
		} else {
			the_posts_navigation();
		}
	}
endif; // MYTHEME_content_nav



/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since MYTHEME 1.0
 */
function MYTHEME_get_first_image( $postID, $size, $attr, $src = false ) {
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

function MYTHEME_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$layout = 'no-sidebar';
	} elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} else {
		$layout = get_theme_mod( 'MYTHEME_default_layout', 'right-sidebar' );

		if ( is_home() || is_archive() ) {
			$layout = get_theme_mod( 'MYTHEME_homepage_archive_layout', 'right-sidebar' );
		}
	}

	return $layout;
}

if ( ! function_exists( 'MYTHEME_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since MYTHEME 1.0
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function MYTHEME_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //MYTHEME_truncate_phrase

if ( ! function_exists( 'MYTHEME_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since MYTHEME 1.0
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function MYTHEME_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		// Strip tags and shortcodes so the content truncation count is done correctly.
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		// Remove inline styles / .
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		// Truncate $content to $max_char
		$content = MYTHEME_truncate_phrase( $content, $max_characters );

		// More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="readmore"><a href="%s" class="more-link">%s</a></span>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'MYTHEME_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //MYTHEME_get_the_content_limit

if ( ! function_exists( 'MYTHEME_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply fabulous-fluid your own MYTHEME_content_image(), and that function will be used instead.
	 *
	 * @since MYTHEME 1.0
	 */
	function MYTHEME_content_image() {
		if ( has_post_thumbnail() && MYTHEME_jetpack_featured_image_display() && is_singular() ) {
			global $post, $wp_query;

			// Get Page ID outside Loop.
			$page_id = $wp_query->get_queried_object_id();

			if ( $post ) {
		 		if ( is_attachment() ) {
					$parent = $post->post_parent;

					$individual_featured_image = get_post_meta( $parent, 'MYTHEME-featured-image', true );
				} else {
					$individual_featured_image = get_post_meta( $page_id, 'MYTHEME-featured-image', true );
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
					$layout = MYTHEME_get_theme_layout();

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
endif; // MYTHEME_content_image.

if ( ! function_exists( 'MYTHEME_sections' ) ) :
	/**
	 * Display Sections on header and footer with respect to the section option set in MYTHEME_sections_sort
	 */
	function MYTHEME_sections( $selector = 'header' ) {
		get_template_part( 'template-parts/header/header-media' );
		get_template_part( 'template-parts/slider/display-slider' );
		get_template_part( 'template-parts/portfolio/display-portfolio' );
		get_template_part( 'template-parts/hero-content/content-hero' );
		get_template_part( 'template-parts/testimonial/display-testimonial' );
		get_template_part( 'template-parts/services/display-services' );
		get_template_part( 'template-parts/featured-content/display-featured' );
	}
endif;

if ( ! function_exists( 'MYTHEME_post_thumbnail' ) ) :
	/**
	 * $image_size post thumbnail size
	 * $type html, html-with-bg, url
	 * $echo echo true/false
	 * $no_thumb display no-thumb image or not
	 */
	function MYTHEME_post_thumbnail( $image_size = 'post-thumbnail', $type = 'html', $echo = true, $no_thumb = false ) {
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
			$first_image_url = MYTHEME_get_first_image( get_the_ID(), $image_size, '', true );

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
endif;

/**
 * Determines if post thumbnail can be displayed.
 *
 * @since MYTHEME 1.0
 *
 * @return bool
 */
function MYTHEME_can_show_post_thumbnail() {
	/**
	 * Filters whether post thumbnail can be displayed.
	 *
	 * @since MYTHEME 1.0
	 *
	 * @param bool $show_post_thumbnail Whether to show post thumbnail.
	 */
	return apply_filters(
		'MYTHEME_can_show_post_thumbnail',
		! post_password_required() && ! is_attachment() && has_post_thumbnail()
	);
}

/**
 * Returns the size for avatars used in the theme.
 *
 * @since MYTHEME 1.0
 *
 * @return int
 */
function MYTHEME_get_avatar_size() {
	return 60;
}

/**
 * Creates continue reading text.
 *
 * @since MYTHEME 1.0
 */
function MYTHEME_continue_reading_text() {
	$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
		esc_html__( 'Continue reading %s', 'MYTHEME' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);

	return $continue_reading;
}

/**
 * Creates the continue reading link for excerpt.
 *
 * @since MYTHEME 1.0
 */
function MYTHEME_continue_reading_link_excerpt() {
	if ( ! is_admin() ) {
		return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . MYTHEME_continue_reading_text() . '</a>';
	}
}

/**
 * Creates the continue reading link.
 *
 * @since MYTHEME 1.0
 */
function MYTHEME_continue_reading_link() {
	if ( ! is_admin() ) {
		return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . MYTHEME_continue_reading_text() . '</a></div>';
	}
}

// Filter the excerpt more link.
add_filter( 'the_content_more_link', 'MYTHEME_continue_reading_link' );

function MYTHEME_excerpt_more_for_manual_excerpts( $excerpt ) {

    global $post;



    if ( has_excerpt( $post->ID ) ) {

        $excerpt .= MYTHEME_excerpt_more( '&hellip;' );

    }



    return $excerpt;

}

add_filter( 'get_the_excerpt', 'MYTHEME_excerpt_more_for_manual_excerpts' );


add_filter( 'excerpt_length', 'MYTHEME_excerpt_length' );




if ( ! function_exists( 'MYTHEME_post_title' ) ) {
	/**
	 * Adds a title to posts and pages that are missing titles.
	 *
	 * @since MYTHEME 1.0
	 *
	 * @param string $title The title.
	 * @return string
	 */
	function MYTHEME_post_title( $title ) {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'MYTHEME' ) : $title;
	}
}
add_filter( 'the_title', 'MYTHEME_post_title' );

/**
 * Gets the SVG code for a given icon.
 *
 * @since MYTHEME 1.0
 *
 * @param string $group The icon group.
 * @param string $icon  The icon.
 * @param int    $size  The icon size in pixels.
 * @return string
 */
function MYTHEME_get_icon_svg( $group, $icon, $size = 24 ) {
	return MYTHEME_SVG_Icons::get_svg( $group, $icon, $size );
}

/**
 * Changes the default navigation arrows to svg icons
 *
 * @since MYTHEME 1.0
 *
 * @param string $calendar_output The generated HTML of the calendar.
 * @return string
 */
function MYTHEME_change_calendar_nav_arrows( $calendar_output ) {
	$calendar_output = str_replace( '&laquo; ', is_rtl() ? MYTHEME_get_icon_svg( 'ui', 'arrow_right' ) : MYTHEME_get_icon_svg( 'ui', 'arrow_left' ), $calendar_output );
	$calendar_output = str_replace( ' &raquo;', is_rtl() ? MYTHEME_get_icon_svg( 'ui', 'arrow_left' ) : MYTHEME_get_icon_svg( 'ui', 'arrow_right' ), $calendar_output );
	return $calendar_output;
}
add_filter( 'get_calendar', 'MYTHEME_change_calendar_nav_arrows' );

/**
 * Get custom CSS.
 *
 * Return CSS for non-latin language, if available, or null
 *
 * @since MYTHEME 1.0
 *
 * @param string $type Whether to return CSS for the "front-end", "block-editor", or "classic-editor".
 * @return string
 */
function MYTHEME_get_non_latin_css( $type = 'front-end' ) {

	// Fetch site locale.
	$locale = get_bloginfo( 'language' );

	/**
	 * Filters the fallback fonts for non-latin languages.
	 *
	 * @since MYTHEME 1.0
	 *
	 * @param array $font_family An array of locales and font families.
	 */
	$font_family = apply_filters(
		'MYTHEME_get_localized_font_family_types',
		array(

			// Arabic.
			'ar'    => array( 'Tahoma', 'Arial', 'sans-serif' ),
			'ary'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
			'azb'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
			'ckb'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
			'fa-IR' => array( 'Tahoma', 'Arial', 'sans-serif' ),
			'haz'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
			'ps'    => array( 'Tahoma', 'Arial', 'sans-serif' ),

			// Chinese Simplified (China) - Noto Sans SC.
			'zh-CN' => array( '\'PingFang SC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif' ),

			// Chinese Traditional (Taiwan) - Noto Sans TC.
			'zh-TW' => array( '\'PingFang TC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif' ),

			// Chinese (Hong Kong) - Noto Sans HK.
			'zh-HK' => array( '\'PingFang HK\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif' ),

			// Cyrillic.
			'bel'   => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'bg-BG' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'kk'    => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'mk-MK' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'mn'    => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'ru-RU' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'sah'   => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'sr-RS' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'tt-RU' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
			'uk'    => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),

			// Devanagari.
			'bn-BD' => array( 'Arial', 'sans-serif' ),
			'hi-IN' => array( 'Arial', 'sans-serif' ),
			'mr'    => array( 'Arial', 'sans-serif' ),
			'ne-NP' => array( 'Arial', 'sans-serif' ),

			// Greek.
			'el'    => array( '\'Helvetica Neue\', Helvetica, Arial, sans-serif' ),

			// Gujarati.
			'gu'    => array( 'Arial', 'sans-serif' ),

			// Hebrew.
			'he-IL' => array( '\'Arial Hebrew\'', 'Arial', 'sans-serif' ),

			// Japanese.
			'ja'    => array( 'sans-serif' ),

			// Korean.
			'ko-KR' => array( '\'Apple SD Gothic Neo\'', '\'Malgun Gothic\'', '\'Nanum Gothic\'', 'Dotum', 'sans-serif' ),

			// Thai.
			'th'    => array( '\'Sukhumvit Set\'', '\'Helvetica Neue\'', 'Helvetica', 'Arial', 'sans-serif' ),

			// Vietnamese.
			'vi'    => array( '\'Libre Franklin\'', 'sans-serif' ),

		)
	);

	// Return if the selected language has no fallback fonts.
	if ( empty( $font_family[ $locale ] ) ) {
		return '';
	}

	/**
	 * Filters the elements to apply fallback fonts to.
	 *
	 * @since MYTHEME 1.0
	 *
	 * @param array $elements An array of elements for "front-end", "block-editor", or "classic-editor".
	 */
	$elements = apply_filters(
		'MYTHEME_get_localized_font_family_elements',
		array(
			'front-end'      => array( 'body', 'input', 'textarea', 'button', '.button', '.faux-button', '.button__link', '.file__button', '.has-drop-cap:not(:focus)::first-letter', '.has-drop-cap:not(:focus)::first-letter', '.entry-content .archives', '.entry-content .categories', '.entry-content .cover-image', '.entry-content .latest-comments', '.entry-content .latest-posts', '.entry-content .pullquote', '.entry-content .quote.is-large', '.entry-content .quote.is-style-large', '.entry-content .archives *', '.entry-content .categories *', '.entry-content .latest-posts *', '.entry-content .latest-comments *', '.entry-content p', '.entry-content ol', '.entry-content ul', '.entry-content dl', '.entry-content dt', '.entry-content cite', '.entry-content figcaption', '.entry-content .wp-caption-text', '.comment-content p', '.comment-content ol', '.comment-content ul', '.comment-content dl', '.comment-content dt', '.comment-content cite', '.comment-content figcaption', '.comment-content .wp-caption-text', '.widget_text p', '.widget_text ol', '.widget_text ul', '.widget_text dl', '.widget_text dt', '.widget-content .rssSummary', '.widget-content cite', '.widget-content figcaption', '.widget-content .wp-caption-text' ),
			'block-editor'   => array( '.editor-styles-wrapper > *', '.editor-styles-wrapper p', '.editor-styles-wrapper ol', '.editor-styles-wrapper ul', '.editor-styles-wrapper dl', '.editor-styles-wrapper dt', '.editor-post-title__block .editor-post-title__input', '.editor-styles-wrapper .wp-block h1', '.editor-styles-wrapper .wp-block h2', '.editor-styles-wrapper .wp-block h3', '.editor-styles-wrapper .wp-block h4', '.editor-styles-wrapper .wp-block h5', '.editor-styles-wrapper .wp-block h6', '.editor-styles-wrapper .has-drop-cap:not(:focus)::first-letter', '.editor-styles-wrapper cite', '.editor-styles-wrapper figcaption', '.editor-styles-wrapper .wp-caption-text' ),
			'classic-editor' => array( 'body#tinymce.wp-editor', 'body#tinymce.wp-editor p', 'body#tinymce.wp-editor ol', 'body#tinymce.wp-editor ul', 'body#tinymce.wp-editor dl', 'body#tinymce.wp-editor dt', 'body#tinymce.wp-editor figcaption', 'body#tinymce.wp-editor .wp-caption-text', 'body#tinymce.wp-editor .wp-caption-dd', 'body#tinymce.wp-editor cite', 'body#tinymce.wp-editor table' ),
		)
	);

	// Return if the specified type doesn't exist.
	if ( empty( $elements[ $type ] ) ) {
		return '';
	}

	// Include file if function doesn't exist.
	if ( ! function_exists( 'MYTHEME_generate_css' ) ) {
		require_once get_theme_file_path( 'inc/custom/custom-css.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	}

	// Return the specified styles.
	return MYTHEME_generate_css( // @phpstan-ignore-line.
		implode( ',', $elements[ $type ] ),
		'font-family',
		implode( ',', $font_family[ $locale ] ),
		null,
		null,
		false
	);
}

/**
 * Print the first instance of a block in the content, and then break away.
 *
 * @since MYTHEME 1.0
 *
 * @param string      $block_name The full block type name, or a partial match.
 *                                Example: `core/image`, `core-embed/*`.
 * @param string|null $content    The content to search in. Use null for get_the_content().
 * @param int         $instances  How many instances of the block will be printed (max). Default  1.
 * @return bool Returns true if a block was located & printed, otherwise false.
 */
function MYTHEME_print_first_instance_of_block( $block_name, $content = null, $instances = 1 ) {
	$instances_count = 0;
	$blocks_content  = '';

	if ( ! $content ) {
		$content = get_the_content();
	}

	// Parse blocks in the content.
	$blocks = parse_blocks( $content );

	// Loop blocks.
	foreach ( $blocks as $block ) {

		// Sanity check.
		if ( ! isset( $block['blockName'] ) ) {
			continue;
		}

		// Check if this the block matches the $block_name.
		$is_matching_block = false;

		// If the block ends with *, try to match the first portion.
		if ( '*' === $block_name[-1] ) {
			$is_matching_block = 0 === strpos( $block['blockName'], rtrim( $block_name, '*' ) );
		} else {
			$is_matching_block = $block_name === $block['blockName'];
		}

		if ( $is_matching_block ) {
			// Increment count.
			$instances_count++;

			// Add the block HTML.
			$blocks_content .= render_block( $block );

			// Break the loop if the $instances count was reached.
			if ( $instances_count >= $instances ) {
				break;
			}
		}
	}

	if ( $blocks_content ) {
		/** This filter is documented in wp-includes/post-template.php */
		echo apply_filters( 'the_content', $blocks_content ); // phpcs:ignore WordPress.Security.EscapeOutput
		return true;
	}

	return false;
}

/**
 * Filters the list of attachment image attributes.
 *
 * @since MYTHEME 1.0
 *
 * @param array        $attr       Array of attribute values for the image markup, keyed by attribute name.
 *                                 See wp_get_attachment_image().
 * @param WP_Post      $attachment Image attachment post.
 * @param string|array $size       Requested size. Image size or array of width and height values
 *                                 (in that order). Default 'thumbnail'.
 * @return array
 */
function MYTHEME_get_attachment_image_attributes( $attr, $attachment, $size ) {

	if ( is_admin() ) {
		return $attr;
	}

	if ( isset( $attr['class'] ) && false !== strpos( $attr['class'], 'custom-logo' ) ) {
		return $attr;
	}

	$width  = false;
	$height = false;

	if ( is_array( $size ) ) {
		$width  = (int) $size[0];
		$height = (int) $size[1];
	} elseif ( $attachment && is_object( $attachment ) && $attachment->ID ) {
		$meta = wp_get_attachment_metadata( $attachment->ID );
		if ( $meta['width'] && $meta['height'] ) {
			$width  = (int) $meta['width'];
			$height = (int) $meta['height'];
		}
	}

	if ( $width && $height ) {

		// Add style.
		$attr['style'] = isset( $attr['style'] ) ? $attr['style'] : '';
		$attr['style'] = 'width:100%;height:' . round( 100 * $height / $width, 2 ) . '%;max-width:' . $width . 'px;' . $attr['style'];
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'MYTHEME_get_attachment_image_attributes', 10, 3 );

// Remove current class on hash menu
add_filter('nav_menu_css_class', 'MYTHEME_remove_current_class_hash', 10, 2 );

function MYTHEME_remove_current_class_hash($classes, $item) {
	$class_names = array( 'current-menu-item', 'current-menu-ancestor', 'current-menu-parent', 'current_page_parent',  'current_page_ancestor', 'current_page_item' );
	if( strpos( $item->url, '#' ) !== false ) {
		foreach( $class_names as $class_name ) {
			if(($key = array_search($class_name, $classes)) !== false) {
				unset($classes[$key]);
			}
		}

	}
	return $classes;
}

/**
 * Custom Search Form
 */
function MYTHEME_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" for="s">' . __( 'Search for:', 'MYTHEME' ) . '</label>
	<input type="search" class="search-field" placeholder="'. __('Search..', 'MYTHEME').'" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="search-submit" value="'. __('Search..', 'MYTHEME').'" />
	</div>
	</form>';

	return $form;
}

add_filter( 'get_search_form', 'MYTHEME_search_form' );

/**
 * Sidebar Layout Class
 */
function MYTHEME_get_sidebar_layout()  {
	global $post;
	$post_sidebar = 'right_sidebar';

	if( is_singular() ) {
		$post_sidebar = get_post_meta( $post->ID, 'MYTHEME_sidebar_layout', true );
	}

	return $post_sidebar;
}
/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since MYTHEME 1.0
 */
function MYTHEME_get_sidebar_id() {
	$sidebar = $id = '';

	$layout = MYTHEME_get_theme_layout();

	if ( 'no-sidebar' === $layout ) {
		return $sidebar;
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	return $sidebar;
}

/** Woocommerce Tweaks **/
/**
	* Woo Commerce Number of row filter Function
**/
add_filter('loop_shop_columns', 'MYTHEME_loop_columns');
if (!function_exists('MYTHEME_loop_columns')) {
   function MYTHEME_loop_columns() {
       $xr = 3;
       return $xr;
   }
}

add_action( 'body_class', 'MYTHEME_woo_body_class');
if (!function_exists('MYTHEME_woo_body_class')) {
   function MYTHEME_woo_body_class( $class ) {
          $class[] = 'columns-'.MYTHEME_loop_columns();
          return $class;
   }
}

function woo_related_products_limit() {
	  global $product;

		$args['posts_per_page'] = 6;
		return $args;
	}
add_filter( 'woocommerce_output_related_products_args', 'MYTHEME_related_products_args' );

function MYTHEME_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}

if ( ! function_exists( 'MYTHEME_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since MYTHEME 1.0
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function MYTHEME_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //MYTHEME_truncate_phrase
