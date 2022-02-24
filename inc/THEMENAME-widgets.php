<?php
/**
 * THEMENAME Custom Widgets
 *
 * @package THEMENAME
 */
require get_template_directory() . '/inc/widgets/widget-about-me.php' ;
/**
  * Call to Action
  *
  * @since THEMENAME Widget Pack 1.0
  */
require get_template_directory() . '/inc/widgets/widget-calltoaction.php' ;

/**
 * Feature Box
 *
 * @since THEMENAME Widget Pack 1.0
 */
require get_template_directory() . '/inc/widgets/widget-feature-box.php' ;

/**
 * Widgets helper functions
 *
 * @since THEMENAME Widget Pack 1.0
 */
require get_template_directory() . '/inc/widgets/widget-fields.php';

/**
 * Number Counter
 *
 * @since THEMENAME Widget Pack 1.0
 */
require get_template_directory() . '/inc/widgets/widget-number-counter.php';

/**
 * Number Counter
 *
 * @since THEMENAME Widget Pack 1.0
 */
require get_template_directory() . '/inc/widgets/widget-pricing.php';

require get_template_directory() . '/inc/widgets/widget-recent-posts.php' ;

require get_parent_theme_file_path( '/inc/widgets/widget-social-icons.php' );
