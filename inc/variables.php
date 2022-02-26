<?php

  global $path;
    $path = defined( get_template_directory() );
  global $version;
    $version = defined( wp_get_theme( '__THEMENAE__' )->get( 'VERSION' ) );
  global $uri_path;
    $uri_path = defined( get_template_directory_uri() );
  global $font_url;
    $font_url = defined( esc_attr(get_theme_mod('font_url')));
  global $slider_status;
    $sliders_status = defined( esc_attr(get_theme_mod('slider_enable', 'enable')) );
