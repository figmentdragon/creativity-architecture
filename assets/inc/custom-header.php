<?php
/**
 * Sample implementation of the Custom header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 *
 <?php $header_image = get_header_image();
 if ( ! empty( $header_image ) ) { ?>
		 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				 <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		 </a>
 <?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package THEMENAME
 * @since THEMENAME 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses THEMENAME_header_style()
 * @uses THEMENAME_admin_header_style()
 * @uses THEMENAME_admin_header_image()
 *
 * @package THEMENAME
 */
function THEMENAME_custom_header_setup() {
<<<<<<< HEAD:assets/inc/custom-header.php
	add_theme_support( 'custom-header',
		$args = array(
			'default-image'          => get_theme_file_path() . '/assets/images/backgrounds/mobile/7.png',
			'header-text'            => false,
			'default-text-color'     => '000',
			'width'                  => 198,
			'height'                 => 1080,
			'random-default'         => false,
			'uploads'                => false,
			'wp-head-callback'       => 'wphead_cb',
			'admin-head-callback'    => 'adminhead_cb',
			'admin-preview-callback' => 'adminpreview_cb'
		)
=======
	$args = array(
		'default-image' 			=> get_template_directory_uri() . '/assets/images/backgrounds/mobile/7.png',
		'header-text'					=> true,
		'default-text-color' 		=> '000',
		'flex-width' 			=> true,
		'width' 					=> '1000',
		'flex-height'			=> true,
		'height' 					=> '250',
		'flex-height' 				=> true,
		'random-default'			=> true,
		'wp-head-callback' 			=> 'THEMENAME_header_style',
		'admin-head-callback' 		=> 'wp_admin_header_style',
		'admin-preview-callback' 	=> 'wp_admin_header_image',
>>>>>>> ff3e4c46347454edb5e6fb34a0d248a6dc0dabb1:inc/custom-header.php
	);

	$args = apply_filters( 'THEMENAME_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',		$args['default-text-color'] );
		define( 'HEADER_IMAGE',			$args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',	$args['width'] );
		define( 'HEADER_IMAGE_HEIGHT',	$args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'THEMENAME_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backwards compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the current header image.
 *
 * @package THEMENAME
 * @since THEMENAME 1.0
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url' 			=> get_template_directory_uri() . '/assets/images/backgrounds/mobile/7.png',
			'thumbnail_url' => get_header_image(),
			'width'			=> HEADER_IMAGE_WIDTH,
			'height'		=> HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'THEMENAME_header_style' ) ) :
	/**
	 * Style for site title and tagline.
	 */
function THEMENAME_header_style() {
	// If no custom options for text are set, let's bail.
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
	if ( HEADER_TEXTCOLOR == get_header_textcolor() && '' == get_header_image() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
    <style type="text/css">
    <?php
		// Do we have a custom header image?
		if ( '' != get_header_image() ) :
	?>
		.site-header img {
			display: block;
			margin: 1.5em auto 0;
			}
	<?php endif;
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
			}
		.site-header hgroup {
			background: none;
			padding: 0;
			}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
			}
    <?php endif; ?>
    </style>
    <?php
}
endif; // THEMENAME_header_style

if (! function_exists( 'THEMENAME_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see THEMENAME_custom_header_setup().
 *
 * @since THEMENAME 1.0
 */
function THEMENAME_admin_header_style() {
?>
	<style type="text/css">
    .appearance_page_custom-header #headimg { /* This is the container for the Custom header preview */
		background: #333;
		border: none;
		min-height: 0 !important;
		}
	#headimg h1 { /* This is the site title displayed in the preview */
		font-size: 45px;
		font-family: Georgia, 'Times New Roman', serif;
		font-style: italic;
		font-weight: normal;
		padding: .8em .5em 0;
		}
	#desc { /* This is the site description (tagline) displayed in the preview */
		padding: 0 2em 2em;
		}
	#headimg h1 a,
	#desc {
		color: pink;
		text-decoration: none;
		}
    </style>
<?php
}
endif; // THEMENAME_admin_header_style

if ( ! function_exists( 'THEMENAME_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see THEMENAME_custom_header_setup().
 *
 * @since THEMENAME 1.0
 */
function THEMENAME_admin_header_image() { ?>
	<div id="headimg">
    	<?php
		if ( 'blank' == get_header_textcolor || '' == get_header_textcolor() )
			$style = ' style="display: none;"';
		else
			$style = ' style="color: #' . get_header_textcolor() . ';"';
		?>
        <h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url('/') ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' );?></div>
        <?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
        	<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
    </div>
<?php }
endif; // THEMENAME_admin_header_image
