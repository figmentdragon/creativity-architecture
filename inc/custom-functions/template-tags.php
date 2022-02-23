<?php
/**
 * Custom template tags/functions for this theme
 *
 * @package WordPress
 * @subpackage THEMENAME
 * @since THEMENAME 1.0
 */

function THEMENAME_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html__( 'Posted on ', 'THEMENAME' ) . $time_string . '</a>';

		echo '<span class="posted-on">' .  $posted_on . '</span>';
	}
function THEMENAME_posted_by() {
		if ( ! get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) {
			echo '<span class="byline">';
			printf(
				/* translators: %s: Author name. */
				esc_html__( 'By %s', 'THEMENAME' ),
				'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . esc_html( get_the_author() ) . '</a>'
			);
			echo '</span>';
		}
	}

function THEMENAME_author_bio() {
	if ( '' !== get_the_author_meta( 'description' ) ) {
		get_template_part( 'template-parts/biography' );
	}
}
function THEMENAME_by_line() {
		$post_id = get_queried_object_id();
		$post_author_id = get_post_field( 'post_author', $post_id );

		$byline = '<span class="author vcard">';

		$byline .= '<a class="url fn n" href="' . esc_url( get_author_posts_url( $post_author_id ) ) . '">' . esc_html( get_the_author_meta( 'nickname', $post_author_id ) ) . '</a></span>';

		echo '<span class="byline">' .  esc_html__( 'Posted By ', 'THEMENAME' ) . $byline . '</span>';
	}
function THEMENAME_cat_list() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the / */
			$categories_list = get_the_category_list( esc_html__( ', ', 'THEMENAME' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>', esc_html__(  'Cat Links', 'THEMENAME' ), $categories_list );
			}
		} elseif ( 'jetpack-portfolio' == get_post_type() ) {
			/* translators: used between list items, there is a space after the / */
			$categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', esc_html__( ' / ', 'THEMENAME' ) );

			if ( ! is_wp_error( $categories_list ) ) {
				printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>', esc_html__(  'Cat Links', 'THEMENAME' ), $categories_list );
			}
		}
	}

	/**
	 * Returns true if a blog has more than 1 category
	 *
	 * @since THEMENAME 1.0
	 */
function THEMENAME_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'THEMENAME_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'THEMENAME_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so THEMENAME_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so THEMENAME_categorized_blog should return false.
		return false;
	}
}

function THEMENAME_post_thumbnail() {
		if ( ! THEMENAME_can_show_post_thumbnail() ) {
			return;
		}
		?>

		<?php if ( is_singular() ) : ?>

			<figure class="post-thumbnail">
				<?php
				// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
				the_post_thumbnail( 'post-thumbnail', array( 'loading' => false ) );
				?>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php else : ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure>

		<?php endif; ?>
		<?php
	}

function THEMENAME_single_image() {
		global $post, $wp_query;

		if ( is_attachment() ) {
			$parent = $post->post_parent;
			$metabox_feat_img = get_post_meta( $parent, 'THEMENAME-featured-image', true );
		} else {
			$metabox_feat_img = get_post_meta( $post->ID, 'THEMENAME-featured-image', true );
		}

		if ( empty( $metabox_feat_img ) || ! is_singular() ) {
			$metabox_feat_img = 'default';
		}

		$featured_image = 'disabled';

		if ( ( 'disabled' == $metabox_feat_img  || ! has_post_thumbnail() || ( 'default' == $metabox_feat_img && 'disabled' == $featured_image ) ) ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		}
		else {
			$class = '';

			if ( 'default' == $metabox_feat_img ) {
				$class = $featured_image;
			}
			else {
				$class = 'from-metabox ' . $metabox_feat_img;
				$featured_image = $metabox_feat_img;
			}

			?>
			<figure class="entry-image <?php echo esc_attr( $class ); ?>">
                <?php the_post_thumbnail( $featured_image ); ?>
	        </figure>
	   	<?php
		}
	}
function THEMENAME_archive_image() {
		if ( ! has_post_thumbnail() ) {
			// Bail if there is no featured image.
			return;
		}

		THEMENAME_post_thumbnail();
	}

function THEMENAME_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( ' ' ); // Separate list by space.

			if ( $categories_list  ) {
				echo '<span class="cat-links">' . THEMENAME_get_svg( array( 'icon' => 'folder-open' ) ) . '<span class="screen-reader-text">' . __( 'Categories', 'THEMENAME' ) . '</span>' . $categories_list . '</span>';
			}

			$tags_list = get_the_tag_list( '', ' ' ); // Separate list by space.

			if ( $tags_list  ) {
				echo '<span class="tags-links">' . THEMENAME_get_svg( array( 'icon' => 'tag' ) ) . '<span class="screen-reader-text">' . __( 'Tags', 'THEMENAME' ) . ',' . '</span>' . $tags_list . '</span>';
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">' . THEMENAME_get_svg( array( 'icon' => 'comment' ) );
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'THEMENAME' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'THEMENAME' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
function THEMENAME_entry_meta_footer() {

		// Early exit if not a post.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'THEMENAME' ) );
			if ( $categories_list && THEMENAME_categorized_blog() ) {
				/* translators: %1$s : category list */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'THEMENAME' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'THEMENAME' ) );
			if ( $tags_list ) {
				/* translators: %1$s : tag list */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'THEMENAME' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		// Hide meta information on pages.
		if ( ! is_single() ) {

		if ( is_sticky() ) {
				echo '<p>' . esc_html_x( 'Featured post', 'Label for sticky posts', 'THEMENAME' ) . '</p>';
			}

			$post_format = get_post_format();
			if ( 'aside' === $post_format || 'status' === $post_format ) {
				echo '<p><a href="' . esc_url( get_permalink() ) . '">' . THEMENAME_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}

			// Posted on.
			THEMENAME_posted_on();

			// Edit post link.
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'THEMENAME' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);

			if ( has_category() || has_tag() ) {

				echo '<div class="post-taxonomies">';

				/* translators: Used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list( __( ', ', 'THEMENAME' ) );
				if ( $categories_list ) {
					printf(
						/* translators: %s: List of categories. */
						'<span class="cat-links">' . esc_html__( 'Categorized as %s', 'THEMENAME' ) . ' </span>',
						$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}

				/* translators: Used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list( '', __( ', ', 'THEMENAME' ) );
				if ( $tags_list ) {
					printf(
						/* translators: %s: List of tags. */
						'<span class="tags-links">' . esc_html__( 'Tagged %s', 'THEMENAME' ) . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}
		} else {

			echo '<div class="posted-by">';
			// Posted on.
			THEMENAME_posted_on();
			// Posted by.
			THEMENAME_posted_by();
			// Edit post link.
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					esc_html__( 'Edit %s', 'THEMENAME' ),
					'<span class="screen-reader-text">' . get_the_title() . '</span>'
				),
				'<span class="edit-link">',
				'</span>'
			);
			echo '</div>';

			if ( has_category() || has_tag() ) {

				echo '<div class="post-taxonomies">';

				/* translators: Used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list( __( ', ', 'THEMENAME' ) );
				if ( $categories_list ) {
					printf(
						/* translators: %s: List of categories. */
						'<span class="cat-links">' . esc_html__( 'Categorized as %s', 'THEMENAME' ) . ' </span>',
						$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}

				/* translators: Used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list( '', __( ', ', 'THEMENAME' ) );
				if ( $tags_list ) {
					printf(
						/* translators: %s: List of tags. */
						'<span class="tags-links">' . esc_html__( 'Tagged %s', 'THEMENAME' ) . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}
		}
	}

function THEMENAME_entry_date_author() {
	$meta = '<div class="entry-meta">';

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$meta .= sprintf( '<span class="posted-on screen-reader-text">%3$s' . '<span class="date-label screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%4$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'THEMENAME' ),
		esc_url( get_permalink() ),
		esc_html__( 'Posted on ', 'THEMENAME' ),
		$time_string
	);

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '<span class="author-label screen-reader-text">By </span>%s', 'THEMENAME' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	$meta .= sprintf( '<span class="byline">%1$s%2$s</span>',
		esc_html__( ' By ', 'THEMENAME' ),
		$byline
	 );


	$meta .= '</div><!-- .entry-meta -->';

	return $meta;

}

function THEMENAME_entry_category_date() {
		$meta = '<div class="entry-meta">';

		$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta entry-meta">', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'THEMENAME' ), '</span>' );

		if ( 'jetpack-portfolio' === get_post_type() ) {
			$meta .= sprintf( '<span class="cat-links">%1$s%2$s</span>',
				sprintf( _x( '<span class="screen-reader-text">Categories: </span>', 'Used before category names.', 'THEMENAME' ) ),
				$portfolio_categories_list
			);
		}

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'THEMENAME' ) );
		if ( $categories_list && THEMENAME_categorized_blog() ) {
			$meta .= sprintf( '<span class="cat-links">%1$s%2$s</span>',
				sprintf( _x( '<span class="screen-reader-text">Categories: </span>', 'Used before category names.', 'THEMENAME' ) ),
				$categories_list
			);
		}

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$meta .= sprintf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			sprintf( __( '<span class="date-label">Posted on </span>', 'THEMENAME' ) ),
			esc_url( get_permalink() ),
			$time_string
		);

		$meta .= '</div><!-- .entry-meta -->';

		return $meta;
	}

if ( ! function_exists( 'THEMENAME_entry_date_author' ) ) :
if ( ! function_exists( 'THEMENAME_entry_category_date' ) ) :

function THEMENAME_footer_content() {
	$theme_data = wp_get_theme();

	$footer_content = sprintf( _x( 'Copyright &copy; %1$s %2$s %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'THEMENAME' ), '[the-year]', '[site-link]', '[privacy-policy-link]' ) . '<span class="sep"> | </span>' . esc_html( $theme_data->get( 'Name' ) ) . '&nbsp;' . esc_html__( 'by', 'THEMENAME' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( $theme_data->get( 'Author' ) ) . '</a>';

	if ( ! $footer_content ) {
		// Bail early if footer content is empty
		return;
	}

	$search  = array( '[the-year]', '[site-link]', '[privacy-policy-link]' );
	$replace = array( esc_attr( date_i18n( __( 'Y', 'THEMENAME' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', function_exists( 'get_the_privacy_policy_link' ) ? get_the_privacy_policy_link() : '' );

	$footer_content = str_replace( $search, $replace, $footer_content );

	echo '<div class="site-info">' . $footer_content . '</div><!-- .site-info -->';
}
add_action( 'THEMENAME_credits', 'THEMENAME_footer_content', 10 );

if ( ! function_exists( 'THEMENAME_the_posts_navigation' ) ) {
	/**
	 * Print the next and previous posts navigation.
	 *
	 * @since THEMENAME 1.0
	 *
	 * @return void
	 */
	function THEMENAME_the_posts_navigation() {
		the_posts_pagination(
			array(
				'before_page_number' => esc_html__( 'Page', 'THEMENAME' ) . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? THEMENAME_get_icon_svg( 'ui', 'arrow_right' ) : THEMENAME_get_icon_svg( 'ui', 'arrow_left' ),
					wp_kses(
						__( 'Newer <span class="nav-short">posts</span>', 'THEMENAME' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					)
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					wp_kses(
						__( 'Older <span class="nav-short">posts</span>', 'THEMENAME' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					is_rtl() ? THEMENAME_get_icon_svg( 'ui', 'arrow_left' ) : THEMENAME_get_icon_svg( 'ui', 'arrow_right' )
				),
			)
		);
	}
}

if ( ! function_exists( 'THEMENAME_slider_entry_category' ) ) :

function THEMENAME_slider_entry_category() {
	$meta = '<div class="entry-meta">';

	$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta entry-meta">', '', '</span>' );

	if ( 'jetpack-portfolio' === get_post_type( ) ) {
		$meta .= sprintf( '<span class="cat-links">' .'<span class="cat-label screen-reader-text">%1$s</span>%2$s</span>',
			sprintf( _x( 'Categories', 'Used before category names.', 'THEMENAME' ) ),
			$portfolio_categories_list
		);
	}

	$categories_list = get_the_category_list( ' ' );
	if ( $categories_list && THEMENAME_categorized_blog( ) ) {
		$meta .= sprintf( '<span class="cat-links">' . '<span class="cat-label screen-reader-text">%1$s</span>%2$s</span>',
			sprintf( _x( 'Categories', 'Used before category names.', 'THEMENAME' ) ),
			$categories_list
		);
	}

	$meta .= '</div><!-- .entry-meta -->';

	return $meta;

}
endif;

if ( ! function_exists( 'THEMENAME_events_cat_list' ) ) :
	/**
	 * Prints HTML with meta information for the categories
	 */
	function THEMENAME_events_cat_list( $echo = true ) {
		$icon = '';
		$output = '';

		if( get_theme_mod( 'THEMENAME_blog_meta_icon', 0 ) ) {
			$icon = '<i class="fa fa-folder-open" aria-hidden="true"></i>';
		}

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the / */
			$categories_list = get_the_category_list( esc_html__( ', ', 'THEMENAME' ) );
			if ( $categories_list ) :
				$output = '<span class="cat-links">' . $icon  .  $categories_list . '</span>';
			endif;
		}

		if ( ! $echo ) {
			return $output;
		}

		echo $output;
	}
endif;

if ( ! function_exists( 'THEMENAME_content_display' ) ) :
	/**
	 * Displays excerpt, content or nothing according to option.
	 */
	function THEMENAME_content_display( $show_content, $echo = true ) {
		$output = '';

		if ( $echo ) {
			if ( 'excerpt' === $show_content ) {
				?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
				<?php
			} elseif ( 'full-content' === $show_content ) {
				?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php
			}

			return;
		} else {
			if ( 'excerpt' === $show_content ) {
				$output = '<div class="entry-summary"><p>'. get_the_excerpt() . '</p></div>';
			} elseif ( 'full-content' === $show_content ) {
				$output = '<div class="entry-content">'. get_the_content() . '</div>';
			}
		}

		return wp_kses_post( $output );
	}
endif;

if ( ! function_exists( 'THEMENAME_category_count_span' ) ) :
	/**
	 * Used to wrap post count in Categories widget with a span tag
	 *
	 * @since 1.0.0
	 */
	function THEMENAME_category_count_span($links) {
		$links = str_replace('</a> (', '</a> <span class="counts">', $links);
		$links = str_replace(')', '</span>', $links);
		return $links;
	}
	add_filter( 'wp_list_categories', 'THEMENAME_category_count_span' );
endif;

if ( ! function_exists( 'THEMENAME_archives_count_span' ) ) :
	/**
	 * Used to wrap post count in Archives widget with a span tag
	 *
	 * @since 1.0.0
	 */
	function THEMENAME_archives_count_span($links) {
		$links = str_replace('</a>&nbsp;(', '</a> <span class="counts">', $links);
		$links = str_replace(')', '</span>', $links);
		return $links;
	}
	add_filter( 'get_archives_link', 'THEMENAME_archives_count_span' );
endif;

function THEMENAME_single_entry_meta() {
	echo '<ul class="post-details">' ;
	if ( false == esc_attr(get_theme_mod( 'THEMENAME_show_single_author', false ) ) ) {
		THEMENAME_posted_by();
	}
	if ( false == esc_attr(get_theme_mod( 'THEMENAME_show_single_date', false ) ) ) {
		THEMENAME_posted_on();
	}
	if ( false == esc_attr(get_theme_mod( 'THEMENAME_show_single_comments', false ) ) ) {
		THEMENAME_comment_count();
	}
	if ( false == esc_attr(get_theme_mod( 'THEMENAME_show_edit', false ) ) ) {
		THEMENAME_edit_link();
	}
	echo '</ul>';
}

if ( ! function_exists( 'THEMENAME_multipage_navigation' ) ) :

function THEMENAME_multipage_navigation() {

		wp_link_pages( array(

		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'THEMENAME' ),

		'after'  => '</div>',

		'link_before' => '<span class="page-wrap">',

		'link_after' => '</span>',

		) );

	}
endif;

if ( ! function_exists( 'THEMENAME_blog_navigation' ) ) :

function THEMENAME_blog_navigation() {

		the_posts_pagination( array(

			'mid_size'  => 2,

			'prev_text' => '<span class="nav-arrow">&laquo</span><span class="screen-reader-text">' . esc_html_x( 'Previous Posts', 'pagination', 'THEMENAME' ) . '</span>',

			'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next Posts', 'pagination', 'THEMENAME' ) . '</span><span class="nav-arrow">&raquo;</span>',

		) );

	}
endif;

if ( !function_exists( 'THEMENAME_comment' ) ) {



	function THEMENAME_comment( $comment, $args, $depth ) {  ?>

<li <?php comment_class(); ?> id="comment-

    <?php comment_ID() ?>">

    <article class="clearfix media" itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">

        <?php echo get_avatar( $comment, 90 ); ?>

        <div class="media-body">

            <div class="comment-author">

                <p class="vcard" itemprop="creator" itemscope="itemscope" itemtype="http://schema.org/Person">

                    <cite class="fn" itemprop="name">

                        <?php comment_author_link(); ?></cite>

                    <time itemprop="commentTime" datetime="<?php comment_time( 'c' ); ?>">

                        <?php echo get_comment_date(); ?>

                    </time>

                </p>

            </div>



            <div class="comment-content" itemprop="commentText">

                <?php comment_text() ?>

                <?php if ( $comment->comment_approved == '0' ) : ?>

                <p><em class="awaiting">

                        <?php esc_html_e( 'Your comment is awaiting moderation.', 'THEMENAME' ) ?></em></p>

                <?php endif; ?>

            </div>

            <div class="comment-reply">

                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>

                <?php edit_comment_link( __( 'Edit', 'THEMENAME'), ' &middot; ', '' ) ?>

            </div>

        </div>

    </article>

</li>

<?php }

}
if ( ! function_exists( 'THEMENAME_categories' ) ) :
	function THEMENAME_categories() {
		echo '<p id="post-categories">', esc_html_e( 'Categories: ', 'THEMENAME' ) .  the_category(' &bull; ') .'</p>';
	}
endif;

function THEMENAME_entry_tags() {
	echo get_the_tag_list( sprintf( // WPCS: XSS OK.
		'<span>%s: ', __( 'Tags: ', 'THEMENAME' ) ), ' &bull; ', '</span>' );
	}

function THEMENAME_comment_count() {
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<li class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'THEMENAME' ), get_the_title() ) );
		echo '</li>';
	}
} endif;

function THEMENAME_edit_link() {
	edit_post_link(
		sprintf(
			__( 'Edit<span class="screen-reader-text">%s</span>', 'THEMENAME' ),
				get_the_title()
			),
			'<li class="edit-link">',
			'</li>'
		);
	}

function THEMENAME_sticky_entry_post() {
	if ( is_sticky() && ! is_paged() ) {
		echo '<div class="featured-label">', esc_html_e('Featured', 'THEMENAME'), '</div>';
	}
} endif;



if ( ! function_exists( 'THEMENAME_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since THEMENAME 1.0
 */
function THEMENAME_posted_on() {
    printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'THEMENAME' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'THEMENAME' ), get_the_author() ) ),
        esc_html( get_the_author() )
    );
}
endif;



/**
 * Flush out the transients used in THEMENAME_categorized_blog
 *
 * @since THEMENAME 1.0
 */
function THEMENAME_category_transient_flusher() {
    // Like, beat it. Dig?
    delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'THEMENAME_category_transient_flusher' );
add_action( 'save_post', 'THEMENAME_category_transient_flusher' );

if ( ! function_exists( 'THEMENAME_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since THEMENAME 1.0
 */
function THEMENAME_content_nav( $nav_id ) {
    global $wp_query, $post;

    // Don't print empty markup on single pages if there's nowhere to navigate.
    if ( is_single() ) {
        $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
        $next = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous )
            return;
    }

    // Don't print empty markup in archives if there's only one page.
    if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
        return;

    $nav_class = 'site-navigation paging-navigation';
    if ( is_single() )
        $nav_class = 'site-navigation post-navigation';

    ?>
    <nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
        <h1 class="assistive-text"><?php _e( 'Post navigation', 'THEMENAME' ); ?></h1>

    <?php if ( is_single() ) : // navigation links for single posts ?>

        <?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'THEMENAME' ) . '</span> %title' ); ?>
        <?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'THEMENAME' ) . '</span>' ); ?>

    <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

        <?php if ( get_next_posts_link() ) : ?>
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'THEMENAME' ) ); ?></div>
        <?php endif; ?>

        <?php if ( get_previous_posts_link() ) : ?>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'THEMENAME' ) ); ?></div>
        <?php endif; ?>

    <?php endif; ?>

    </nav><!-- #<?php echo $nav_id; ?> -->
    <?php
}
endif; // THEMENAME_content_nav
