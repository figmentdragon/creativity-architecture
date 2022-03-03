<?php
/**
 * Post meta elements.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'TheCreativityArchitectcontent_nav' ) ) {
	/**
	 * Display navigation to next/previous pages when applicable.
	 *
	 *
	 * @param string $nav_id The id of our navigation.
	 */
	function TheCreativityArchitectcontent_nav( $nav_id ) {
		if ( ! apply_filters( 'TheCreativityArchitectshow_post_navigation', true ) ) {
			return;
		}

		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';
		$category_specific = apply_filters( 'TheCreativityArchitectcategory_post_navigation', false );
		?>
		<nav id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo esc_attr( $nav_class ); ?>">
			<span class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'TheCreativityArchitect' ); ?></span>

			<?php if ( is_single() ) : // navigation links for single posts.

				previous_post_link( '<div class="nav-previous"><span class="prev" title="' . esc_attr__( 'Previous', 'TheCreativityArchitect' ) . '">%link</span></div>', '%title', $category_specific );
				next_post_link( '<div class="nav-next"><span class="next" title="' . esc_attr__( 'Next', 'TheCreativityArchitect' ) . '">%link</span></div>', '%title', $category_specific );

			elseif ( is_home() || is_archive() || is_search() ) : // navigation links for home, archive, and search pages.

				if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><span class="prev" title="<?php esc_attr_e( 'Previous', 'TheCreativityArchitect' );?>"><?php next_posts_link( __( 'Older posts', 'TheCreativityArchitect' ) ); ?></span></div>
				<?php endif;

				if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><span class="next" title="<?php esc_attr_e( 'Next', 'TheCreativityArchitect' );?>"><?php previous_posts_link( __( 'Newer posts', 'TheCreativityArchitect' ) ); ?></span></div>
				<?php endif;

				the_posts_pagination( array(
					'mid_size' => apply_filters( 'TheCreativityArchitectpagination_mid_size', 1 ),
					'prev_text' => apply_filters( 'TheCreativityArchitectprevious_link_text', __( '&larr; Previous', 'TheCreativityArchitect' ) ),
					'next_text' => apply_filters( 'TheCreativityArchitectnext_link_text', __( 'Next &rarr;', 'TheCreativityArchitect' ) ),
				) );

				/**
				 * TheCreativityArchitectpaging_navigation hook.
				 *
				 */
				do_action( 'TheCreativityArchitectpaging_navigation' );

			endif; ?>
		</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
		<?php
	}
}

if ( ! function_exists( 'TheCreativityArchitectmodify_posts_pagination_template' ) ) {
	add_filter( 'navigation_markup_template', 'TheCreativityArchitectmodify_posts_pagination_template', 10, 2 );
	/**
	 * Remove the container and screen reader text from the_posts_pagination()
	 * We add this in ourselves in TheCreativityArchitectcontent_nav()
	 *
	 *
	 * @param string $template The default template.
	 * @param string $class The class passed by the calling function.
	 * @return string The HTML for the post navigation.
	 */
	function TheCreativityArchitectmodify_posts_pagination_template( $template, $class ) {
	    if ( ! empty( $class ) && false !== strpos( $class, 'pagination' ) ) {
	        $template = '<div class="nav-links">%3$s</div>';
	    }

	    return $template;
	}
}

if ( ! function_exists( 'TheCreativityArchitectposted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 */
	function TheCreativityArchitectposted_on() {
		$date = apply_filters( 'TheCreativityArchitectpost_date', true );
		$author = apply_filters( 'TheCreativityArchitectpost_author', true );

		// If our date is enabled, show it.
		if ( $date ) {
			echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_time() ) . '" rel="bookmark">';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				echo '<time class="updated" datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '" itemprop="dateModified">' . esc_html( get_the_modified_date() ) . '</time>';
			}
			echo '<time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" itemprop="datePublished">' . esc_html( get_the_date() ) . '</time>';
			echo '</a></span>';
		}

		// If our author is enabled, show it.
		if ( $author ) {
			echo ' <span class="byline"><span class="author vcard" itemtype="https://schema.org/Person" itemscope="itemscope" itemprop="author">' . esc_html__( 'by','TheCreativityArchitect') . ' <a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr__( 'View all posts by ', 'TheCreativityArchitect' ) . esc_html( get_the_author() ) . '" rel="author" itemprop="url"><span class="author-name" itemprop="name">' . esc_html( get_the_author() ) . '</span></a></span></span>';
		}
	}
}

if ( ! function_exists( 'TheCreativityArchitectentry_meta' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 */
	function TheCreativityArchitectentry_meta() {
		$categories = apply_filters( 'TheCreativityArchitectshow_categories', true );
		$tags = apply_filters( 'TheCreativityArchitectshow_tags', true );
		$comments = apply_filters( 'TheCreativityArchitectshow_comments', true );

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'TheCreativityArchitect' ) );
		if ( $categories_list && $categories ) {
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html_x( 'Categories', 'Used before category names.', 'TheCreativityArchitect' ) . ' </span>' . wp_kses_post( $categories_list ) . '</span>';
		}

		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'TheCreativityArchitect' ) );
		if ( $tags_list && $tags ) {
			echo '<span class="tags-links"><span class="screen-reader-text">'. esc_html_x( 'Tags', 'Used before tag names.', 'TheCreativityArchitect' ) . ' </span>' . wp_kses_post( $tags_list ) . '</span>';
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) && $comments ) {
			echo '<span class="comments-link">';
				comments_popup_link( __( 'Leave a comment', 'TheCreativityArchitect' ), __( '1 Comment', 'TheCreativityArchitect' ), __( '% Comments', 'TheCreativityArchitect' ) );
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'TheCreativityArchitectexcerpt_more' ) ) {
	add_filter( 'excerpt_more', 'TheCreativityArchitectexcerpt_more' );
	/**
	 * Prints the read more HTML to post excerpts.
	 *
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The HTML for the more link.
	 */
	function TheCreativityArchitectexcerpt_more( $more ) {
		if ( is_admin() ) {
			return '[&hellip;]';
		} else {
			return apply_filters( 'TheCreativityArchitectexcerpt_more_output', sprintf( ' ... <a title="%1$s" class="read-more" href="%2$s">%3$s%4$s</a>',
				the_title_attribute( 'echo=0' ),
				esc_url( get_permalink( get_the_ID() ) ),
				__( 'Read more', 'TheCreativityArchitect' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			) );
		}
	}
}

if ( ! function_exists( 'TheCreativityArchitectcontent_more' ) ) {
	add_filter( 'the_content_more_link', 'TheCreativityArchitectcontent_more' );
	/**
	 * Prints the read more HTML to post content using the more tag.
	 *
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The HTML for the more link
	 */
	function TheCreativityArchitectcontent_more( $more ) {
		return apply_filters( 'TheCreativityArchitectcontent_more_link_output', sprintf( '<p class="read-more-container"><a title="%1$s" class="read-more content-read-more" href="%2$s">%3$s%4$s</a></p>',
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink( get_the_ID() ) . apply_filters( 'TheCreativityArchitectmore_jump','#more-' . get_the_ID() ) ),
			__( 'Read more', 'TheCreativityArchitect' ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
		) );
	}
}

if ( ! function_exists( 'TheCreativityArchitectpost_meta' ) ) {
	add_action( 'TheCreativityArchitectafter_entry_title', 'TheCreativityArchitectpost_meta' );
	/**
	 * Build the post meta.
	 *
	 */
	function TheCreativityArchitectpost_meta() {
		if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php TheCreativityArchitectposted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif;
	}
}

if ( ! function_exists( 'TheCreativityArchitectfooter_meta' ) ) {
	add_action( 'TheCreativityArchitectafter_entry_content', 'TheCreativityArchitectfooter_meta' );
	/**
	 * Build the footer post meta.
	 *
	 */
	function TheCreativityArchitectfooter_meta() {
		if ( 'post' == get_post_type() ) : ?>
			<footer class="entry-meta">
				<?php TheCreativityArchitectentry_meta(); ?>
				<?php if ( is_single() ) TheCreativityArchitectcontent_nav( 'nav-below' ); ?>
			</footer><!-- .entry-meta -->
		<?php endif;
	}
}
