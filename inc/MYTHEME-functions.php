<?php
/**
 * Custom Functions
 */

 function MYTHEME_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'MYTHEME-thumb-600' => __('600px by 150px'),
        'MYTHEME-thumb-300' => __('300px by 100px'),
    ) );
}
