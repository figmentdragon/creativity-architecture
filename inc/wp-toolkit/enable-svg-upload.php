<?php

if (!function_exists('THEMENAME_mime_types')) {
  function THEMENAME_mime_types($mimes)
  {
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
  }
}
add_filter('upload_mimes', 'THEMENAME_mime_types', 99, 1);
