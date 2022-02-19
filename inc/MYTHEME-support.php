<?php
/**
 * Theme Support
 */

function theme_support() {
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
    add_image_size( 'MYTHEME-thumb-600', 600, 150, true );
    add_image_size( 'MYTHEME-thumb-300', 300, 100, true );


  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ) );
  add_theme_support( 'post-formats', array(
    'aside',
    'image',
    'video',
    'quote',
    'link',
  ) );
  add_theme_support( 'custom-background', apply_filters( 'MYTHEME_custom_background_args', array(
    'default-color' => 'ffffff',
    'default-image' => '',
  ) ) );

  // Add theme support for selective refresh for widgets.
  add_theme_support( 'customize-selective-refresh-widgets' );

  /**
   * Add support for core custom logo.
   *
   * @link https://codex.wordpress.org/Theme_Logo
   */
  add_theme_support( 'custom-logo', array(
    'height'      => 200,
    'width'       => 50,
    'flex-width'  => true,
    'flex-height' => true,
  ) );
}
