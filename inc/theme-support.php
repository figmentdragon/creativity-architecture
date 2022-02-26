<?php
/**
 * Theme Support
 */

 function theme_support() {
   add_filter( 'rss_widget_feed_link', '__return_false' );

  add_post_type_support( 'page', 'excerpt' );

  add_theme_support( 'align-wide' );
  add_theme_support( 'automatic-feed-links' );

  $background_color = get_theme_mod( 'background_color', '000100' );
  if ( 127 > Custom_Colors::get_relative_luminance_from_hex( $background_color ) ) {
    add_theme_support( 'dark-editor-style' );
  }
  add_theme_support( 'custom-background',
    $defaults = array(
      'default-color' => $background_color,
      'default-image' => get_template_directory . 'images/backgrounds/architect/compbulb.png',
      'default-repeat'     => 'repeat',
      'default-position-x' => 'left',
      'default-position-y' => 'top',
      'default-size'       => 'auto',
      'default-attachment' => 'scroll',
    )
  );
  add_theme_support( 'custom-background', $defaults );
  add_theme_support( 'custom-header' );
  add_theme_support( 'custom-line-height' );

  $logo_width  = 250;
  $logo_height = 250;
  add_theme_support( 'custom-logo',
   array(
     'width'       => $logo_width,
     'height'      => $logo_height,
     'flex-width'           => true,
     'flex-height'          => true,
  		'header-text' => array( 'site-title', 'site-description' ),
     'unlink-homepage-logo' => true,));

  add_theme_support( 'custom-spacing' );
  add_theme_support( 'custom-units' );
  add_theme_support( 'customize-selective-refresh-widgets' );
  add_theme_support( 'editor-styles' );
	add_theme_support( 'ew-newsletter-image' );
  add_theme_support( 'experimental-link-color' );
  add_theme_support(
    'html5',
    array(
      'caption',
      'comment-form',
      'comment-list',
      'gallery',
      'script',
      'style',
      'navigation-widgets',
    )
  );

  add_theme_support( 'post-formats',
    array(
      'aside',
      'image',
      'video',
      'quote',
      'link',
    ) );

  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 960, 640, true );
    add_image_size( 'thumb-600', 600, 150, true );
    add_image_size( 'thumb-300', 300, 100, true );
    add_image_size( 'block-image', 606, 404, true ); // Ratio 3:2
    // Used in featured slider
    add_image_size( 'slider', 1920, 1080, true ); // Ratio 16:9
    // Used in Portfolio
    add_image_size( 'portfolio', 1920, 9999, true ); // Flexible Height
    add_image_size( 'large', 700, '', true ); // Large Thumbnail.
    add_image_size( 'medium', 250, '', true ); // Medium Thumbnail.
    add_image_size( 'small', 120, '', true ); // Small Thumbnail.
    add_image_size( 'custom-size', 700, 200, true );

  add_theme_support( 'responsive-embeds' );
	add_theme_support( 'styles' );

  add_theme_support( 'title-tag' );
	add_theme_support( 'woocommerce' );
 }
 ?>
