<?php
/**
 * This is the file for all of the theme specific, or  a page, category, etc, functions
 */


function MYTHEME_functions() {
  add_action( 'admin_head', 'MYTHEME_admin_style' );
  add_action( 'admin_init', 'MYTHEME_add_editor_styles' );
  add_action( 'admin_init', 'MYTHEME_notice_dismissed' );
  add_action( 'admin_init', 'MYTHEME_notice_ignore' );
  add_action( 'admin_notices', 'MYTHEME_notice' );
  add_action( 'after_switch_theme', 'MYTHEME_setup_options' );
  add_filter( 'excerpt_length', 'MYTHEME_new_excerpt_length' );
  add_filter( 'get_the_archive_title', 'MYTHEME_get_the_archive_title', 10, 1 );
  add_action( 'template_redirect', 'MYTHEME_template_redirect' );
  add_action( 'tgmpa_register', 'MYTHEME_register_required_plugins' );
  add_filter( 'the_content_more_link', 'MYTHEME_more_link', 10, 2 );
  add_filter( 'the_excerpt', 'MYTHEME_read_more_custom_excerpt' );
  add_filter( 'walker_nav_menu_start_el', 'MYTHEME_nav_description', 10, 4 );
  add_action( 'wp_body_open', 'MYTHEME_skip_link', 5 );
  add_action( 'wp_footer', 'MYTHEME_footer' );
  add_action( 'wp_head', 'MYTHEME_dynamic_style', 15 );
  add_action( 'wp_head', 'MYTHEME_javascript_detection', 0 );
  add_action( 'comment_form_before', 'MYTHEME_enqueue_comment_reply_script' );
  
  add_filter( 'big_image_size_threshold', '__return_false' );
  add_filter( 'intermediate_image_sizes_advanced', 'MYTHEME_image_insert_override' );
  add_filter( 'document_title_separator', 'MYTHEME_document_title_separator' );
  add_filter( 'the_title', 'MYTHEME_title' );
  add_filter( 'get_comments_number', 'MYTHEME_comment_count', 0 );
  add_filter( 'nav_menu_link_attributes', 'MYTHEME_schema_url', 10 );
  add_filter( 'wp_page_menu_args', 'MYTHEME_page_menu_args' );
}

function MYTHEME_contact_details_sidebar_class() {
	$count = 0;
  if ( is_active_sidebar( 'contact-details-1' ) ) {
		$count++;
  }
  if ( is_active_sidebar( 'contact-details-2' ) ) {
		$count++;
  }
  if ( is_active_sidebar( 'contact-details-3' ) ) {
		$count++;
  }
  if ( is_active_sidebar( 'contact-details-4' ) ) {
		$count++;
  }
  
  $class = '';
  switch ( $count ) {
    case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
    }
    if ( $class ) {
      echo 'class="widget-area footer-widget-area contact-details-widget-area  ' . esc_attr( $class ) . '"';
    }
  }
function MYTHEME_post_comments_feed_link() {
    return;
}
function MYTHEME_template_redirect() {
		$layout = MYTHEME_get_theme_layout();

		if ( 'no-sidebar-full-width' === $layout ) {
			$GLOBALS['content_width'] = 1510;
		}
	}
function MYTHEME_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
function MYTHEME_footer() {
  ?>
  <script>
  jQuery(document).ready(function($) {
    var deviceAgent = navigator.userAgent.toLowerCase();
    if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
      $("html").addClass("ios");
    }
    if (navigator.userAgent.search("MSIE") >= 0) {
      $("html").addClass("ie");
    }
    else if (navigator.userAgent.search("Chrome") >= 0) {
      $("html").addClass("chrome");
    }
    else if (navigator.userAgent.search("Firefox") >= 0) {
      $("html").addClass("firefox");
    }
    else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
      $("html").addClass("safari");
    }
    else if (navigator.userAgent.search("Opera") >= 0) {
      $("html").addClass("opera");
    }
  });
</script>
<?php
}
// Numeric Page Navi (built into the theme by default)
function MYTHEME_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
} /* end page navi */
function MYTHEME_wp_body_open() {
    do_action( 'wp_body_open' );
}
function MYTHEME_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#contentwrapper">' . esc_html__( 'Skip to the content', 'MYTHEME-lite' ) . '</a>';
}
function MYTHEME_notice() {
	global $current_user;
	$user_id = $current_user->ID;
	if ( ! get_user_meta( $user_id, 'MYTHEME_notice_ignore' ) ) {
		echo '<div class="updated notice"><p>' . esc_html__( 'Thanks for installing MYTHEME Lite! Want more features?', 'MYTHEME-lite' ) . '<a href="https://vivathemes.com/wordpress-theme/MYTHEME/" target="blank">' . esc_html__( 'Check Out the Pro Version  &#8594;', 'MYTHEME-lite' ) . '</a><a class="notice-dismiss" href="?MYTHEME-ignore-notice"><span class="screen-reader-text">Dismiss Notice</span></a></p></div>';
	}
}
function MYTHEME_notice_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	if ( isset( $_GET['MYTHEME-ignore-notice'] ) ) {
		add_user_meta( $user_id, 'MYTHEME_notice_ignore', 'true', true );
	}
}
function MYTHEME_admin_notice() {
  $user_id = get_current_user_id();
  if ( !get_user_meta( $user_id, 'MYTHEME_notice_dismissed_4' ) && current_user_can( 'manage_options' ) )
  echo '<div class="notice notice-info"><p>' . __( '<big><strong>MYTHEME</strong>:</big> Help keep the project alive! <a href="?notice-dismiss" class="alignright">Dismiss</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">Make a Donation</a>', 'MYTHEME' ) . '</p></div>';
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
function MYTHEME_can_show_post_thumbnail() {
	return apply_filters(
		'MYTHEME_can_show_post_thumbnail',
		! post_password_required() && ! is_attachment() && has_post_thumbnail()
	);
}
function MYTHEME_continue_reading_text() {
	$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
		esc_html__( 'Continue reading %s', 'MYTHEME' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);

	return $continue_reading;
}
function MYTHEME_continue_reading_link_excerpt() {
	if ( ! is_admin() ) {
		return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . MYTHEME_continue_reading_text() . '</a>';
	}
}
function MYTHEME_continue_reading_link() {
	if ( ! is_admin() ) {
		return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . MYTHEME_continue_reading_text() . '</a></div>';
	}
}
function MYTHEME_get_avatar_size() {
	return 60;
}
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
function MYTHEME_move_more_link() {
	return '<p><a class="more-link" href="'. esc_url(get_permalink()) . '">' . esc_html__( 'Continue Reading', 'MYTHEME' ) . '</a></p>';
}
function MYTHEME_supports_js() {
	echo '<script>document.body.classList.remove("no-js");</script>';
}
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
function MYTHEME_get_sidebar_layout()  {
	global $post;
	$post_sidebar = 'right_sidebar';if( is_singular() ) {
		$post_sidebar = get_post_meta( $post->ID, 'MYTHEME_sidebar_layout', true );	}return $post_sidebar;
	}
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
function MYTHEME_loop_columns() {
  $xr = 3;
  return $xr;
}
function woo_related_products_limit() {
  global $product;
		$args['posts_per_page'] = 6;
		return $args;
}
function MYTHEME_admin_style() {
	echo '<style>
	.notice {position: relative;}
	a.notice-dismiss {text-decoration:none;}
	</style>';
}
function MYTHEME_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
function MYTHEME_dynamic_style() {
    $preloader = get_theme_mod( 'MYTHEME_preloader' );
    $disp_cap_in_mobile = absint(get_theme_mod('MYTHEME_disp_caption_in_mobile', 0));

    if( isset( $preloader ) && $preloader == '' ) :
    ?>
    <style>
    .no-js #loader { display: none; }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .MYTHEME-preloader { position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 9999999; background: url('<?php echo esc_url(get_template_directory_uri()."/images/loading.gif"); ?>') center no-repeat #fff;}

	<?php if(!$disp_cap_in_mobile) : ?>
    @media screen and (max-width:580px) {
	.slide-desc{
			display: none;
		}
	}
	<?php endif; ?>
    </style>
    <?php
    endif;
}
function MYTHEME_pingback_header() {
  if ( is_singular() && pings_open() ) {
    printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
  }
}
// Related Posts Function (call using MYTHEME_related_posts(); )
function MYTHEME_related_posts() {
	echo '<ul id="MYTHEME-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'MYTHEMEtheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_postdata();
	echo '</ul>';
} /* end MYTHEME related posts function */
function MYTHEME_enqueue() {
  wp_enqueue_style( 'MYTHEME-style', get_stylesheet_uri() );wp_enqueue_script( 'jquery' );
}
function MYTHEME_enqueue_comment_reply_script() {
  if ( get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
