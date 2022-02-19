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

function MYTHEME_template_functions() {
	add_action( 'wp_footer', 'MYTHEME_supports_js' );
	add_filter('loop_shop_columns', 'MYTHEME_loop_columns');
	add_action( 'body_class', 'MYTHEME_woo_body_class');
	add_filter( 'woocommerce_output_related_products_args', 'MYTHEME_related_products_args' );
	add_filter( 'get_calendar', 'MYTHEME_change_calendar_nav_arrows' );
	add_filter( 'body_class', 'MYTHEME_body_classes' );
	add_filter( 'post_class', 'MYTHEME_post_classes', 10, 3 );
	add_filter( 'the_content_more_link', 'MYTHEME_move_more_link' );
	add_filter( 'comment_form_defaults', 'MYTHEME_comment_form_defaults' );
	add_filter( 'the_title', 'MYTHEME_post_title' );
	add_filter( 'get_the_excerpt', 'MYTHEME_excerpt_more_for_manual_excerpts' );
	add_filter( 'get_custom_logo', 'MYTHEME_get_custom_logo' );
	add_filter( 'wp_get_attachment_image_attributes', 'MYTHEME_get_attachment_image_attributes', 10, 3 );
	add_filter( 'get_search_form', 'MYTHEME_search_form' );
	add_filter( 'excerpt_length', 'MYTHEME_excerpt_length' );
	add_filter( 'nav_menu_css_class', 'MYTHEME_remove_current_class_hash', 10, 2 );
	add_filter( 'the_content_more_link', 'MYTHEME_continue_reading_link' );

	add_action( 'wp_enqueue_scripts', 'MYTHEME_promo_head_bg_image_overlay_css', 11 );
	add_action( 'wp_enqueue_scripts', 'MYTHEME_header_media_image_overlay_css', 11 );
	add_action( 'pre_get_posts', 'MYTHEME_alter_home' );
}

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
	$classes[] = 'fluid-layout';


	$classes[] = 'excerpt';

	$classes['color-scheme'] = esc_attr( 'color-scheme-' . get_theme_mod( 'color_scheme', 'default' ) );

	$enable_slider = MYTHEME_check_section( get_theme_mod( 'MYTHEME_slider_option', 'disabled' ) );

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

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
function MYTHEME_post_classes( $classes ) {
	$classes[] = 'entry';

	return $classes;
}
function MYTHEME_comment_form_defaults( $defaults ) {

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $defaults['comment_field'] );

	return $defaults;
}
function MYTHEME_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'MYTHEME_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}

	}
}
function MYTHEME_check_section( $value ) {
	return ( 'entire-site' == $value  || ( is_front_page() && 'homepage' === $value ) );
}
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
function MYTHEME_sections( $selector = 'header' ) {
		get_template_part( 'template-parts/header/header-media' );
		get_template_part( 'template-parts/slider/display-slider' );
		get_template_part( 'template-parts/portfolio/display-portfolio' );
		get_template_part( 'template-parts/hero-content/content-hero' );
		get_template_part( 'template-parts/testimonial/display-testimonial' );
		get_template_part( 'template-parts/services/display-services' );
		get_template_part( 'template-parts/featured-content/display-featured' );
	}
function MYTHEME_excerpt_more_for_manual_excerpts( $excerpt ) {

    global $post;



    if ( has_excerpt( $post->ID ) ) {

        $excerpt .= MYTHEME_excerpt_more( '&hellip;' );

    }



    return $excerpt;

}
function MYTHEME_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}
		$excerpt_length = esc_attr(get_theme_mod( 'MYTHEME_excerpt_length', '35' ) );
		if ( $excerpt_length >= 0 ) :
			return absint( $excerpt_length );
			else :
				return 35; // Number of words.
			endif;
	}
function MYTHEME_post_title( $title ) {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'MYTHEME' ) : $title;
	}
function MYTHEME_get_icon_svg( $group, $icon, $size = 24 ) {
	return MYTHEME_SVG_Icons::get_svg( $group, $icon, $size );
}
function MYTHEME_change_calendar_nav_arrows( $calendar_output ) {
	$calendar_output = str_replace( '&laquo; ', is_rtl() ? MYTHEME_get_icon_svg( 'ui', 'arrow_right' ) : MYTHEME_get_icon_svg( 'ui', 'arrow_left' ), $calendar_output );
	$calendar_output = str_replace( ' &raquo;', is_rtl() ? MYTHEME_get_icon_svg( 'ui', 'arrow_left' ) : MYTHEME_get_icon_svg( 'ui', 'arrow_right' ), $calendar_output );
	return $calendar_output;
}
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
function MYTHEME_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" for="s">' . __( 'Search for:', 'MYTHEME' ) . '</label>
	<input type="search" class="search-field" placeholder="'. __('Search..', 'MYTHEME').'" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="search-submit" value="'. __('Search..', 'MYTHEME').'" />
	</div>
	</form>';
	return $form;
}
function MYTHEME_custom_image_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'MYTHEME-thumbs-600' => __('600px by 150px'),
		'MYTHEME-thumbs-300' => __('300px by 100px'),
		'MYTHEME-fullscreen' => __('1980px by 9999'),
	) );
}
function MYTHEME_woo_body_class( $class ) {
          $class[] = 'columns-'.MYTHEME_loop_columns();
          return $class;
   }
function MYTHEME_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}
function MYTHEME_title( $title ) {
  if ( $title == '' ) {
    return '...';
  } else {
    return $title;
  }
}
function MYTHEME_get_the_archive_title(
$title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'MYTHEME-lite' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'MYTHEME-lite' ) );
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'MYTHEME-lite' ) );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} else {
		$title = esc_html__( 'Archives', 'MYTHEME-lite' );
	}
	return $title;
};
function MYTHEME_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
		return $args;
	}
}
function MYTHEME_document_title_separator( $sep ) {
  $sep = '|';
  return $sep;
}
function MYTHEME_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
function MYTHEME_image_insert_override( $sizes ) {
  unset( $sizes['medium_large'] );
  unset( $sizes['1536x1536'] );
  unset( $sizes['2048x2048'] );
  return $sizes;
}
function MYTHEME_schema_url( $atts ) {
  $atts['itemprop'] = 'url';
  return $atts;
}
function MYTHEME_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'MYTHEME_excerpt_more_text', esc_html__( 'Continue reading', 'MYTHEME' ) );

		return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
	}
function MYTHEME_new_excerpt_length( $length ) {
  return 70;
}
// This removes the annoying […] to a Read More link
function MYTHEME_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read ', 'MYTHEMEtheme' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more &raquo;', 'MYTHEME' ) .'</a>';
}
function MYTHEME_read_more_custom_excerpt( $text ) {
  if ( strpos( $text, '[&hellip;]' ) ) {
      $excerpt = str_replace( '[&hellip;]', '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'MYTHEME-lite' ) . '</a>', $text );
  } else {
    $excerpt = $text . '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'MYTHEME-lite' ) . '</a>';
  }
  return $excerpt;
}
function MYTHEME_nav_description( $item_output, $item, $depth, $args ) {
	if ( ! empty( $item->description ) ) {
		$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
	}
	return $item_output;
}
function MYTHEME_custom_pings( $comment ) {
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
  <?php
}
function MYTHEME_comment_count( $count ) {
  if ( !is_admin() ) {
    global $id;
    $get_comments = get_comments( 'status=approve&post_id=' . $id );
    $comments_by_type = separate_comments( $get_comments );
    return count( $comments_by_type['comment'] );
  } else {
    return $count;
  }
}
function MYTHEME_archives_count_span($links) {
		$links = str_replace('</a>&nbsp;(', '</a> <span class="counts">', $links);
		$links = str_replace(')', '</span>', $links);
		return $links;
	}
	add_filter( 'get_archives_link', 'MYTHEME_archives_count_span' );
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
function MYTHEME_events_cat_list( $echo = true ) {
			$icon = '';
			$output = '';

			if( get_theme_mod( 'MYTHEME_blog_meta_icon', 0 ) ) {
				$icon = '<i class="fa fa-folder-open" aria-hidden="true"></i>';
			}

			// Hide category and tag text for pages.
			if ( 'post' === get_post_type() ) {
				/* translators: used between list items, there is a space after the / */
				$categories_list = get_the_category_list( esc_html__( ', ', 'MYTHEME' ) );
				if ( $categories_list ) :
					$output = '<span class="cat-links">' . $icon  .  $categories_list . '</span>';
				endif;
			}

			if ( ! $echo ) {
				return $output;
			}

			echo $output;
		}
function MYTHEME_get_custom_logo( $html ) {
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( ! $logo_id ) {
		return $html;
	}
	$logo = wp_get_attachment_image_src( $logo_id, 'full' );
	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU', );

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}
			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}
