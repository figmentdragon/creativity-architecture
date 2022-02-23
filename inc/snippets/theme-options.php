<?php

/**
 * Theme Options
 * Available in WP Backend through Design > Customize
 *
 * use get_theme_mod('option_name') to retrieve options
 *
 */

namespace Roots\Sage\Init;

function THEMENAME_customize_register($wp_customize)
{
  /**
   * Project Settings
   */

  // first declare settings
  $wp_customize->add_setting(
    'THEMENAME_projects_page_id',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  $wp_customize->add_setting(
    'THEMENAME_social_fb_url',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  $wp_customize->add_setting(
    'THEMENAME_social_xing_url',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  $wp_customize->add_setting(
    'THEMENAME_social_linkedin_url',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  // declare sections
  $wp_customize->add_section(
    'THEMENAME_projects_section',
    [
      'title'    => __('Projects', 'THEMENAME'),
      'priority' => 30,
    ]
  );

  $wp_customize->add_section(
    'THEMENAME_social_section',
    [
      'title'    => __('Social Media', 'THEMENAME'),
      'priority' => 30,
    ]
  );

  // add control elements to sections
  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'THEMENAME_projects_page_id',
      [
        'label'    => __('Side "Project":', 'THEMENAME'),
        'section'  => 'THEMENAME_projects_section',
        'settings' => 'THEMENAME_projects_page_id',
        'type'     => 'dropdown-pages',
      ]
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'THEMENAME_social_fb_url',
      [
        'label'    => __('URL Facebook', 'THEMENAME'),
        'section'  => 'THEMENAME_social_section',
        'settings' => 'THEMENAME_social_fb_url',
        'type'     => 'text',
      ]
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'THEMENAME_social_xing_url',
      [
        'label'    => __('URL XING', 'THEMENAME'),
        'section'  => 'THEMENAME_social_section',
        'settings' => 'THEMENAME_social_xing_url',
        'type'     => 'text',
      ]
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'THEMENAME_social_linkedin_url',
      [
        'label'    => __('URL LinkedIn', 'THEMENAME'),
        'section'  => 'THEMENAME_social_section',
        'settings' => 'THEMENAME_social_linkedin_url',
        'type'     => 'text',
      ]
    )
  );
}

add_action('customize_register', __NAMESPACE__.'\\THEMENAME_customize_register');
