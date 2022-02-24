<?php
/**
 * Theme Support
 */

function THEMENAME_theme_support() {
  add_post_type_support( 'page', 'excerpt' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'custom-background' );
  add_theme_support( 'custom-header' );
  add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'ew-newsletter-image' );

	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'styles' );
	add_theme_support( 'title-tag' );

  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 960, 640, true );
    add_image_size( 'THEMENAME-thumb-600', 600, 150, true );
    add_image_size( 'THEMENAME-thumb-300', 300, 100, true );
		add_image_size( 'THEMENAME-block-image', 606, 404, true ); // Ratio 3:2
    // Used in featured slider
		add_image_size( 'THEMENAME-slider', 1920, 1080, true ); // Ratio 16:9
		// Used in Portfolio
		add_image_size( 'THEMENAME-portfolio', 1920, 9999, true ); // Flexible Height
    add_image_size( 'large', 700, '', true ); // Large Thumbnail.
    add_image_size( 'medium', 250, '', true ); // Medium Thumbnail.
    add_image_size( 'small', 120, '', true ); // Small Thumbnail.
    add_image_size( 'custom-size', 700, 200, true ); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');


  add_theme_support( 'html5',
    array(
      'caption',
      'comment-form',
      'comment-list',
      'gallery',
      'search-form',
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

  add_theme_support( 'custom-background',
    $args = array(
      'default-color' => 'ffffff',
      'default-image' => get_template_directory_uri() . '/assets/images/backgrounds/architect/compbulb.png',
    ) );
    add_theme_support( 'custom-background', $args );

  add_theme_support( 'custom-logo' );
    array(
      'height'      => 200,
      'width'       => 200,
      'flex-width'  => true,
      'flex-height' => true,
    );

}
