<?php
/**
 * Elementor Pro integration.
 *
 * @package THEMENAME
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Register Elementor locations.
 *
 * @param object $elementor_theme_manager The elementor theme manager.
 */
function elementor_locations( $elementor_theme_manager ) {

	// Replace
	$elementor_theme_manager->register_location(
		'pre-header',
		[
			'label'        => __( 'Pre Header (Replace)', 'THEMENAME' ),
			'hook'         => 'before_header',
			'remove_hooks' => ['do_pre_header'],
		]
	);

	$elementor_theme_manager->register_location(
		'header',
		[
			'label'        => __( 'Header (Replace)', 'THEMENAME' ),
			'hook'         => 'header',
			'remove_hooks' => ['do_header'],
		]
	);

	$elementor_theme_manager->register_location(
		'footer',
		[
			'label'        => __( 'Footer (Replace)', 'THEMENAME' ),
			'hook'         => 'footer',
			'remove_hooks' => ['do_footer'],
		]
	);

	$elementor_theme_manager->register_location(
		'before-header',
		[
			'label'    => __( 'Before Header', 'THEMENAME' ) . ' (before_header)',
			'multiple' => true,
			'hook'     => 'before_header',
		]
	);

	$elementor_theme_manager->register_location(
		'after-header',
		[
			'label'    => __( 'After Header', 'THEMENAME' ) . ' (after_header)',
			'multiple' => true,
			'hook'     => 'after_header',
		]
	);

	// Hooks
	$elementor_theme_manager->register_location(
		'before-content',
		[
			'label'    => __( 'Before Content', 'THEMENAME' ) . ' (content_open)',
			'multiple' => true,
			'hook'     => 'content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-content',
		[
			'label'    => __( 'After Content', 'THEMENAME' ) . ' (content_close)',
			'multiple' => true,
			'hook'     => 'content_close',
		]
	);

	$elementor_theme_manager->register_location(
		'before-inner-content',
		[
			'label'    => __( 'Before Inner Content', 'THEMENAME' ) . ' (inner_content_open)',
			'multiple' => true,
			'hook'     => 'inner_content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-inner-content',
		[
			'label'    => __( 'After Inner Content', 'THEMENAME' ) . ' (inner_content_close)',
			'multiple' => true,
			'hook'     => 'inner_content_close',
		]
	);

	$elementor_theme_manager->register_location(
		'before-main-content',
		[
			'label'    => __( 'Before Main Content', 'THEMENAME' ) . ' (main_content_open)',
			'multiple' => true,
			'hook'     => 'main_content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-main-content',
		[
			'label'    => __( 'After Main Content', 'THEMENAME' ) . ' (main_content_open)',
			'multiple' => true,
			'hook'     => 'main_content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'before-footer',
		[
			'label'    => __( 'Before Footer', 'THEMENAME' ) . ' (before_footer)',
			'multiple' => true,
			'hook'     => 'before_footer',
		]
	);

	$elementor_theme_manager->register_location(
		'after-footer',
		[
			'label'    => __( 'After Footer', 'THEMENAME' ) . ' (after_footer)',
			'multiple' => true,
			'hook'     => 'after_footer',
		]
	);

	$elementor_theme_manager->register_location(
		'before-post',
		[
			'label'    => __( 'Before Post', 'THEMENAME' ) . ' (before_article)',
			'multiple' => true,
			'hook'     => 'before_article',
		]
	);

	$elementor_theme_manager->register_location(
		'after-post',
		[
			'label'    => __( 'After Post', 'THEMENAME' ) . ' (after_article)',
			'multiple' => true,
			'hook'     => 'after_article',
		]
	);

	$elementor_theme_manager->register_location(
		'before-sidebar',
		[
			'label'    => __( 'Before Sidebar', 'THEMENAME' ) . ' (sidebar_open)',
			'multiple' => true,
			'hook'     => 'sidebar_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-sidebar',
		[
			'label'    => __( 'After Sidebar', 'THEMENAME' ) . ' (sidebar_close)',
			'multiple' => true,
			'hook'     => 'sidebar_close',
		]
	);

}
add_action( 'elementor/theme/register_locations', 'elementor_locations' );
