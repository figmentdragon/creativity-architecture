<?php
/**
 * Custom Functions
 */

function functions() {
  add_action( 'after_switch_theme', 'setup_options' );
  add_action( 'init', 'nav' ); // Add THEMENAEMenu
  add_action( 'init', 'create_post_type' ); // Add our THEMENAECustom Post Type
  add_action( 'init', 'wp_pagination' );
  add_action( 'widgets_init', 'remove_recent_comments_style' ); // Remove inline Recent Comment Styles from wp_head()


  // Add Filters
  add_filter( 'avatar_defaults', 'gravatar' ); // Custom Gravatar in Settings > Discussion
  add_filter( 'body_class', 'add_slug_to_body_class' ); // Add slug to body class (Starkers build)
  add_filter( 'excerpt_length', 'excerpt_length', 999 );
  add_filter( 'excerpt_more', 'excerpt_more' );
  add_filter( 'gallery_style', 'gallery_style' );
  add_filter( 'image_size_names_choose', 'custom_image_sizes' );
  add_filter( 'style_loader_tag', 'style_remove' );
  add_filter( 'the_content_more_link', 'more_link', 10, 2 );
  add_filter( 'the_excerpt', 'shortcode_unautop' ); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
  add_filter( 'wp_nav_menu_args', 'nav_menu_args' ); // Remove  surrounding <div> from WP Navigation

  add_shortcode( 'shortcode_demo', 'shortcode_demo' ); // You can place [shortcode_demo] in Pages, Posts now.
  add_shortcode( 'shortcode_demo_2', 'shortcode_demo_2' );
}

function add_slug_to_body_class( $classes ) {
    global $post;
    if ( is_home() ) {
        $key = array_search( 'blog', $classes, true );
        if ( $key > -1 ) {
            unset( $classes[$key] );
        }
    } elseif ( is_page() ) {
        $classes[] = sanitize_html_class( $post->post_name );
    } elseif ( is_singular() ) {
        $classes[] = sanitize_html_class( $post->post_name );
    }

    return $classes;
}

function remove_category_rel_from_category_list( $thelist ) {
  return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
}

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
    return $html;
}

function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}

function gravatar ( $avatar_defaults ) {
    $myavatar                   = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = 'Custom Gravatar';
    return $avatar_defaults;
}

function check_section( $value ) {
	return ( 'entire-site' == $value  || ( is_front_page() && 'homepage' === $value ) );
}
function attributes_filter( $var ) {
    return is_array( $var ) ? array() : '';
}

function custom_image_sizes( $sizes ) {
    return array_merge( $sizes,
      array(
        'thumb-600' => __('600px by 150px'),
        'thumb-300' => __('300px by 100px'),
      )
    );
  }

function more_link( $more_link, $more_link_text ) {
	$more_tag_text = get_theme_mod( 'excerpt_more_text', esc_html__( 'Continue reading', '__THEMENAE__' ) );
	return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
}

function nav() {
    wp_nav_menu(
    array(
        'theme_location'  => 'header-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 0,
        'walker'          => '',
        )
    );
}

function remove_recent_comments_style() {
    global $wp_widget_factory;

    if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
        remove_action( 'wp_head', array(
            $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
            'recent_comments_style'
        ) );
    }
}

function shortcode_demo( $atts, $content = null ) {
    return '<div class="shortcode-demo">' . do_shortcode( $content ) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
function shortcode_demo_2( $atts, $content = null ) {
    return '<h2>' . $content . '</h2>';
}

function style_remove( $tag ) {
    return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}

function view_article( $more ) {
    global $post;
    return '... <a class="view-article" href="' . get_permalink( $post->ID ) . '">' . esc_html_e( 'View Article', '__THEMENAE__' ) . '</a>';
}

function wp_custom_post( $length ) {
    return 40;
}

function wp_excerpt( $length_callback = '', $more_callback = '' ) {
    global $post;
    if ( function_exists( $length_callback ) ) {
        add_filter( 'excerpt_length', $length_callback );
    }
    if ( function_exists( $more_callback ) ) {
        add_filter( 'excerpt_more', $more_callback );
    }
    $output = get_the_excerpt();
    $output = apply_filters( 'wptexturize', $output );
    $output = apply_filters( 'convert_chars', $output );
    $output = '<p>' . $output . '</p>';
    echo esc_html( $output );
}

function wp_index( $length ) {
    return 20;
}

function nav_menu_args( $args = '' ) {
    $args['container'] = false;
    return $args;
}

function wp_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links( array(
        'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        'format'  => '?paged=%#%',
        'current' => max( 1, get_query_var( 'paged' ) ),
        'total'   => $wp_query->max_num_pages,
    ) );
}

function create_post_type() {
    register_taxonomy_for_object_type( 'category', '__THEMENAE__' ); // Register Taxonomies for Category
    register_taxonomy_for_object_type( 'post_tag', '__THEMENAE__' );
    register_post_type( '__THEMENAE__', // Register Custom Post Type
        array(
        'labels'       => array(
            'name'               => esc_html( 'Custom Post', '__THEMENAE__' ), // Rename these to suit
            'singular_name'      => esc_html( 'Custom Post', '__THEMENAE__' ),
            'add_new'            => esc_html( 'Add New', '__THEMENAE__' ),
            'add_new_item'       => esc_html( 'Add New Custom Post', '__THEMENAE__' ),
            'edit'               => esc_html( 'Edit', '__THEMENAE__' ),
            'edit_item'          => esc_html( 'Edit Custom Post', '__THEMENAE__' ),
            'new_item'           => esc_html( 'New Custom Post', '__THEMENAE__' ),
            'view'               => esc_html( 'View Custom Post', '__THEMENAE__' ),
            'view_item'          => esc_html( 'View Custom Post', '__THEMENAE__' ),
            'search_items'       => esc_html( 'Search Custom Post', '__THEMENAE__' ),
            'not_found'          => esc_html( 'No Custom Posts found', '__THEMENAE__' ),
            'not_found_in_trash' => esc_html( 'No Custom Posts found in Trash', '__THEMENAE__' ),
        ),
        'public'       => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive'  => true,
        'supports'     => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom THEMENAEpost for supports
        'can_export'   => true, // Allows export in Tools > Export
        'taxonomies'   => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ) );
}

function comments( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  extract( $args, EXTR_SKIP );
  if ( 'div' == $args['style'] ) {
    $tag       = 'div';
    $add_below = 'comment';
  } else {
    $tag       = 'li';
    $add_below = 'div-comment';
  }
  ?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo esc_html( $tag ) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID(); ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
      <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
      <?php endif; ?>
      <div class="comment-author vcard">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php printf( esc_html( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ) ?>
      </div>
      <?php if ( $comment->comment_approved == '0' ) : ?>
        <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.' ) ?></em>
        <br />
      <?php endif; ?>
      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
        <?php
        printf( esc_html( '%1$s at %2$s' ), get_comment_date(), get_comment_time() ) ?></a><?php edit_comment_link( esc_html_e( '(Edit)' ), '  ', '' );
        ?>
      </div>
      <?php comment_text() ?>
      <div class="reply">
        <?php comment_reply_link( array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
      </div>
      <?php if ( 'div' != $args['style'] ) : ?>
      </div>
    <?php endif; ?>
  <?php
}
