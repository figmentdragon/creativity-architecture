<?php
/**
 * LifterLMS customizer settings.
 *
 * @package THEMENAME
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Textdomain. This is required, otherwise strings aren't translateable.
load_theme_textdomain( 'THEMENAME' );

/* Panels */

// LifterLMS.
Kirki::add_panel( 'lifterlms_panel', array(
	'priority' => 200,
	'title'    => __( 'LifterLMS', 'THEMENAME' ),
) );

/* Sections */

// Menu item.
Kirki::add_section( 'lifterlms_color_options', array(
	'title'    => __( 'Colors', 'THEMENAME' ),
	'panel'    => 'lifterlms_panel',
	'priority' => 1,
) );

// Sidebar.
// Kirki::add_section( 'lifterlms_sidebar_options', array(
// 	'title'    => __( 'Sidebar', 'THEMENAME' ),
// 	'panel'    => 'lifterlms_panel',
// 	'priority' => 2,
// ) );

/* Fields - Colors */

// Primary color.
Kirki::add_field( 'themename', array(
	'type'            => 'color',
	'settings'        => 'lifterlms_primary_color',
	'label'           => __( 'Primary Color', 'THEMENAME' ),
	'section'         => 'lifterlms_color_options',
	'default'         => '#2295ff',
	'priority'        => 1,
	// 'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
) );

// Action color.
Kirki::add_field( 'themename', array(
	'type'            => 'color',
	'settings'        => 'lifterlms_action_color',
	'label'           => __( 'Action Color', 'THEMENAME' ),
	'section'         => 'lifterlms_color_options',
	'default'         => '#f8954f',
	'priority'        => 1,
	// 'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'themename', array(
	'type'            => 'color',
	'settings'        => 'lifterlms_accent_color',
	'label'           => __( 'Accent Color', 'THEMENAME' ),
	'section'         => 'lifterlms_color_options',
	'default'         => '#ef476f',
	'priority'        => 1,
	// 'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
) );