<?php
/**
 * Easy Digital Downloads customizer settings.
 *
 * @package THEMENAME
 * @subpackage Integration/EDD
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Load textdomain. This is required to make strings translatable.
load_theme_textdomain( '__THEMENAE__' );

/* Panels */

// Easy Digital Downloads.
Kirki::add_panel( 'edd_panel', array(
	'priority' => 200,
	'title'    => __( 'Easy Digital Downloads', '__THEMENAE__' ),
) );

/* Sections */

// Menu item.
Kirki::add_section( 'edd_menu_item_options', array(
	'title'    => __( 'Cart Menu Item', '__THEMENAE__' ),
	'panel'    => 'edd_panel',
	'priority' => 1,
) );

// Sidebar.
Kirki::add_section( 'edd_sidebar_options', array(
	'title'    => __( 'Sidebar', '__THEMENAE__' ),
	'panel'    => 'edd_panel',
	'priority' => 2,
) );

/* Fields - Sidebar */

// Shop sidebar layout.
Kirki::add_field( '__THEMENAE__', array(
	'type'     => 'select',
	'settings' => 'edd_sidebar_layout',
	'label'    => __( 'Shop Page Sidebar', '__THEMENAE__' ),
	'section'  => 'edd_sidebar_options',
	'default'  => 'global',
	'priority' => 0,
	'multiple' => 1,
	'choices'  => array(
		'global' => __( 'Inherit Global Settings', '__THEMENAE__' ),
		'right'  => __( 'Right', '__THEMENAE__' ),
		'left'   => __( 'Left', '__THEMENAE__' ),
		'none'   => __( 'No Sidebar', '__THEMENAE__' ),
	),
) );

// Product sidebar layout.
Kirki::add_field( '__THEMENAE__', array(
	'type'     => 'select',
	'settings' => 'edd_single_sidebar_layout',
	'label'    => __( 'Product Page Sidebar', '__THEMENAE__' ),
	'section'  => 'edd_sidebar_options',
	'default'  => 'global',
	'priority' => 0,
	'multiple' => 1,
	'choices'  => array(
		'global' => __( 'Inherit Global Settings', '__THEMENAE__' ),
		'right'  => __( 'Right', '__THEMENAE__' ),
		'left'   => __( 'Left', '__THEMENAE__' ),
		'none'   => __( 'No Sidebar', '__THEMENAE__' ),
	),
) );

/* Fields - Menu Item */

// Hide from non-EDD pages.
Kirki::add_field( '__THEMENAE__', array(
	'type'        => 'toggle',
	'settings'    => 'edd_menu_item_hide_if_not_edd',
	'label'       => __( 'Hide from non-Shop Pages', '__THEMENAE__' ),
	'description' => __( 'Display Menu Item only on EDD related pages', '__THEMENAE__' ),
	'section'     => 'edd_menu_item_options',
	'default'     => 0,
	'priority'    => 5,
) );

// Separator.
Kirki::add_field( '__THEMENAE__', array(
	'type'     => 'custom',
	'settings' => 'edd_menu_item_separator_1',
	'section'  => 'edd_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 5,
) );

// Menu item.
Kirki::add_field( '__THEMENAE__', array(
	'type'            => 'select',
	'settings'        => 'edd_menu_item_desktop',
	'label'           => __( 'Visibility (Desktop)', '__THEMENAE__' ),
	'description'     => __( 'Adds a Cart Icon to your Main Navigation', '__THEMENAE__' ),
	'section'         => 'edd_menu_item_options',
	'default'         => 'show',
	'priority'        => 10,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', '__THEMENAE__' ),
		'hide' => __( 'Hide', '__THEMENAE__' ),
	),
	'partial_refresh' => array(
		'eddmenuitemdesktop' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Menu item color.
Kirki::add_field( '__THEMENAE__', array(
	'type'            => 'color',
	'settings'        => 'edd_menu_item_desktop_color',
	'label'           => __( 'Color', '__THEMENAE__' ),
	'section'         => 'edd_menu_item_options',
	'default'         => '',
	'priority'        => 11,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'edd_menu_item_desktop',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'setting'  => 'edd_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Separator.
Kirki::add_field( '__THEMENAE__', array(
	'type'     => 'custom',
	'settings' => 'edd_menu_item_separator_2',
	'section'  => 'edd_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 12,
) );

// Mobile menu item.
Kirki::add_field( '__THEMENAE__', array(
	'type'            => 'select',
	'settings'        => 'edd_menu_item_mobile',
	'label'           => __( 'Visibility (Mobile)', '__THEMENAE__' ),
	'description'     => __( 'Adds a Cart Icon to your Mobile Navigation', '__THEMENAE__' ),
	'section'         => 'edd_menu_item_options',
	'default'         => 'show',
	'priority'        => 13,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', '__THEMENAE__' ),
		'hide' => __( 'Hide', '__THEMENAE__' ),
	),
	'partial_refresh' => array(
		'eddmenuitemmobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Menu item color.
Kirki::add_field( '__THEMENAE__', array(
	'type'            => 'color',
	'settings'        => 'edd_menu_item_mobile_color',
	'label'           => __( 'Color', '__THEMENAE__' ),
	'section'         => 'edd_menu_item_options',
	'default'         => '',
	'priority'        => 14,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'edd_menu_item_mobile',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'setting'  => 'edd_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Separator.
Kirki::add_field( '__THEMENAE__', array(
	'type'     => 'custom',
	'settings' => 'edd_menu_item_separator_3',
	'section'  => 'edd_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 15,
) );

// Menu item count.
Kirki::add_field( '__THEMENAE__', array(
	'type'            => 'select',
	'settings'        => 'edd_menu_item_count',
	'label'           => __( 'Count', '__THEMENAE__' ),
	'section'         => 'edd_menu_item_options',
	'default'         => 'show',
	'priority'        => 16,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', '__THEMENAE__' ),
		'hide' => __( 'Hide', '__THEMENAE__' ),
	),
	'partial_refresh' => array(
		'eddmenuitemcount' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );
