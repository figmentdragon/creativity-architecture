<?php
/**
 * Theme Support
 */

 function theme_support() {

   // Automatic feed links.
   add_theme_support( 'automatic-feed-links' );
   // Selective refresh for widgets.
   add_theme_support( 'customize-selective-refresh-widgets' );
   // Post thumbnails.
 	add_theme_support( 'post-thumbnails' );
  // Title tag.
  add_theme_support( 'title-tag' );


   // Custom logo.
   add_theme_support(
     'custom-logo',
     array(
       'width'       => 180,
       'height'      => 48,
       'flex-width'  => true,
       'flex-height' => true,
     )
   );

   // Custom background.
   add_theme_support(
     'custom-background',
     array(
       'default-color'      => 'ffffff',
       'default-image'      => '',
       'default-repeat'     => 'repeat',
       'default-position-x' => 'left',
       'default-position-y' => 'top',
       'default-size'       => 'auto',
       'default-attachment' => 'scroll',
     )
   );

   // HTML5 support.
   add_theme_support(
     'html5',
     array(
       'search-form',
       'comment-form',
       'comment-list',
       'gallery',
       'caption',
       'script',
       'style',
     )
   );


 }
 ?>
