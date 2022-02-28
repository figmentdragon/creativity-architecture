<?php

# -----------------------------------------------------------------
# Theme activation: Wonder Theme ACTIVATE
# -----------------------------------------------------------------

// run when this theme is activated

function setup() {

    // make sure our categories are present, accounted for, named
	wp_insert_term( 'In Progress', 'category' );
	wp_insert_term( 'Published', 'category' );

	// Look for existence of pages with the appropriate template, if not found
	// make 'em cause it's good to make the pages

	if (! page_with_template_exists( 'page-write.php' ) ) {

		// create the writing form page if it does not exist
		// backdate creation date 2 days just to make sure they do not end up future dated
		// which causes all kinds of disturbances in the force

		$page_data = array(
			'post_title' 	=> 'Write? Write. Right.',
			'post_content'	=> 'Here is the place to compose,  , and hone your fine words. If you are building this site, maybe edit this page to customize this wee bit of text.',
			'post_name'		=> 'write',
			'post_status'	=> 'publish',
			'post_type'		=> 'page',
			'post_author' 	=> 1,
			'post_date' 	=> date('Y-m-d H:i:s', time() - 172800),
			'page_template'	=> 'page-write.php',
		);

		wp_insert_post( $page_data );
	}

	// add rewrite rules, then flush to make sure they stick.
	rewrite_rules();
	flush_rewrite_rules();
}

# ----------------------------------------------------------------
# Admin has style!
# -----------------------------------------------------------------



function custom_admin_styles(){
    wp_enqueue_style( 'admin_css',  get_stylesheet_directory_uri() . '/includes/admin.css');
}

# -----------------------------------------------------------------
# Query vars and Redirects
# -----------------------------------------------------------------
function queryvars( $qvars ) {
	$qvars[] = 'tk'; // token key for editing previously made stuff
	$qvars[] = 'wid'; // post id for editing
	$qvars[] = 'random'; // random flag
	$qvars[] = 'elink'; // edit link flag
	$qvars[] =  'ispre'; // another preview flag

	return $qvars;
}


/* set up rewrite rules */
function rewrite_rules() {
	// for sending to random item
   add_rewrite_rule('random/?$', 'index.php?random=1','top');

   // for edit link requests
   add_rewrite_rule( '^get-edit-link/([^/]+)/?',  'index.php?elink=1&wid=$matches[1]','top');

}

// redirections for rewrites on the /random and /get-edit-link


function save_post_random_check( $post_id ) {
    // verify post is not a revision and that the post slug is "random"

    $new_post = get_post( $post_id );
    if ( ! wp_is_post_revision( $post_id ) and  $new_post->post_name == 'random' ) {
        // unhook this function to prevent infinite looping
        remove_action( 'save_post', 'save_post_random_check' );

        // update the post slug
        wp_update_post( array(
            'ID' => $post_id,
            'post_name' => 'randomly' // do your thing here
        ));

        // re-hook this function
        add_action( 'save_post', 'save_post_random_check' );

    }
}


# -----------------------------------------------------------------
# Comments
# -----------------------------------------------------------------

// possibly add writer email to comment notifications
// add_filter( 'comment_moderation_recipients', 'comment_notification_recipients', 15, 2 );

function comment_notification_recipients( $emails, $comment_id ) {

	 $comment = get_comment( $comment_id );

	 // check if we should send notifications
	 if ( ok_to_notify( $comment ) ) {
	 	// find post id from comment ID and fetch the email address to append to notifications
		$emails[] = get_post_meta(  $comment->comment_post_ID, 'wEmail', 1 );
	}
 	return ( $emails );
}

// modify the comment notification for content creators, non users dont need the wordpress comment mod stuff
// h/t https://wordpress.stackexchange.com/a/170151/14945


function comment_notification_text( $notify_message, $comment_id ){
    // get the current comment
    $comment = get_comment( $comment_id );

    // change notification only for recipient who is the author of this an item (e.g. skip for admins)
    if ( ok_to_notify( $comment ) ) {
    	// get post data
    	$post = get_post( $comment->comment_post_ID );

		// don't modify trackbacks or pingbacks
		if ( '' == $comment->comment_type ){
			// build the new message text
			$notify_message  = sprintf( __( 'New comment on  "%s" published at "%s"' ), $post->post_title, get_bloginfo( 'name' ) ) . "\r\n\r\n----------------------------------------\r\n";
			$notify_message .= sprintf( __('Author : %1$s'), $comment->comment_author ) . "\r\n";
			$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= sprintf( __('Comment Link: %s'), get_comment_link( $comment_id ) ) . "\r\n\r\n----------------------------------------\r\n";
			$notify_message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n----------------------------------------\r\n\r\n";

			$notify_message .= __('See all comments: ') . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";

		}
	}

	// return the notification text
    return $notify_message;
}

function ok_to_notify( $comment ) {
	// check if theme options are set to use comments and that the post associated with comment has the notify flag activated
	return ( sort_option('allow_comments') and get_post_meta( $comment->comment_post_ID, 'wCommentNotify', 1 ) );
}

# -----------------------------------------------------------------
# Tiny-MCE mods
# --------------------------------------------------------------

function register_buttons( $plugin_array ) {
	$plugin_array['imgbutton'] = get_stylesheet_directory_uri() . '/js/image-button.js';
	return $plugin_array;
}

// remove  buttons from the visual editor
// this is the handler used in the tiny_mce editor to manage image upload


function upload_action() {

    $newupload = 0;

    if ( !empty($_FILES) ) {
        $files = $_FILES;
        foreach($files as $file) {
            $newfile = array (
                    'name' => $file['name'],
                    'type' => $file['type'],
                    'tmp_name' => $file['tmp_name'],
                    'error' => $file['error'],
                    'size' => $file['size']
            );

            $_FILES = array('upload'=>$newfile);
            foreach($_FILES as $file => $array) {
                $newupload = media_handle_upload( $file, 0);
            }
        }
    }
    echo json_encode( array('id'=> $newupload, 'location' => wp_get_attachment_image_src( $newupload, 'large' )[0], 'caption' => get_attachment_caption_by_id( $newupload ) ) );
    die();
}

# -----------------------------------------------------------------
# For the Writing Form
# -----------------------------------------------------------------


function no_featured_image() {
	if ( is_page( get_write_page() ) and isset( $_POST['form_make_submitted'] ) ) {
    ?>
        <style>
            .featured-media {
                display:none;
            }
        </style>
    <?php
    }
}


// filter content on writing page so we do not submit the page content if form is submitted


function firstview( $content ) {
    // Check if we're inside the main loop on the writing page
    if ( is_page( get_write_page() ) && in_the_loop() && is_main_query() ) {

    	if ( isset( $_POST['form_make_submitted'] ) ) {
    		return '';
    	} else {
    		 return $content;
    	}

    }

    return $content;
}



function send_cors_headers( $headers ) {
	if ( is_page( get_write_page() ) ) {
    	$headers['Access-Control-Allow-Origin'] = '*';
    }
    return $headers;
}

// this is the handler used in the tiny_mce editor to manage image upload



/* local version of wp_ajax_ajax_tag_search without exit for user capabilties
   (this requires a logged in user which we do not always have

   modified from
   https://developer.wordpress.org/reference/functions/wp_ajax_ajax_tag_search
*/

function ajax_tag_search() {
    if ( ! isset( $_GET['tax'] ) ) {
        wp_die( 0 );
    }

    $taxonomy = sanitize_key( $_GET['tax'] );
    $tax      = get_taxonomy( $taxonomy );

    if ( ! $tax ) {
        wp_die( 0 );
    }

    $s = wp_unslash( $_GET['q'] );

    $comma = _x( ',', 'tag delimiter' );
    if ( ',' !== $comma ) {
        $s = str_replace( $comma, ',', $s );
    }

    if ( false !== strpos( $s, ',' ) ) {
        $s = explode( ',', $s );
        $s = $s[ count( $s ) - 1 ];
    }

    $s = trim( $s );

    /**
     * Filters the minimum number of characters required to fire a tag search via Ajax.
     *
     * @since 4.0.0
     *
     * @param int         $characters The minimum number of characters required. Default 2.
     * @param WP_Taxonomy $tax        The taxonomy object.
     * @param string      $s          The search term.
     */
    $term_search_min_chars = (int) apply_filters( 'term_search_min_chars', 2, $tax, $s );

    /*
     * Require $term_search_min_chars chars for matching (default: 2)
     * ensure it's a non-negative, non-zero integer.
     */
    if ( ( 0 == $term_search_min_chars ) || ( strlen( $s ) < $term_search_min_chars ) ) {
        wp_die();
    }

    $results = get_terms(
        array(
            'taxonomy'   => $taxonomy,
            'name__like' => $s,
            'fields'     => 'names',
            'hide_empty' => false,
        )
    );

    echo implode( "\n", $results );
    wp_die();
}


# -----------------------------------------------------------------
# Grab Bag
# -----------------------------------------------------------------

function  show_drafts( $query ) {
// show drafts only for single previews
    if ( is_user_logged_in() || is_feed() || !is_single() )
        return;

    $query->set( 'post_status', array( 'publish', 'draft' ) );
}



// enable previews of posts for non-logged in users
// ----- h/t https://wordpress.stackexchange.com/a/164088/14945



function reveal_previews( $posts, $wp_query ) {

    //making sure the post is a preview to avoid showing published private posts
    if ( !is_preview() )
        return $posts;

    if ( is_user_logged_in() )
    	 return $posts;

    if ( count( $posts ) )
        return $posts;

    if ( !empty( $wp_query->query['p'] ) ) {
        return array ( get_post( $wp_query->query['p'] ) );
    }
}

# -----------------------------------------------------------------
# login stuff - things to set up special user, prevent access to WP
# -----------------------------------------------------------------

// Add custom logo to entry screen... because we can
// While we are at it, use CSS to hide the back to blog and retried password links


function login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);
            height:90px;
			width:320px;
			background-size: 320px 90px;
			background-repeat: no-repeat;
			padding-bottom: 0px;
        }
    </style>
<?php }


function add_login_message() {
	return '<p class="message">To do all that is SPLOT!</p>';
}

// login page title

function login_logo_url_title() {
	return 'The grand mystery of all things SPLOT';
}

?>
