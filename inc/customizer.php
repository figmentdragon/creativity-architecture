<?php
/**
 * TheCreativityArchitect: Customizer
 *
 * @package TheCreativityArchitect
 *
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
*/

function customize_register( $wp_customize ) {
		$defaults = get_defaults();

	if ( $wp_customize->get_control( 'custom_logo' ) ) {
    $wp_customize->get_control( 'custom_logo' )->priority = 4;
    $wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
  }
	if ( $wp_customize->get_control( 'blogname' ) ) {
    $wp_customize->get_control('blogname')->priority = 1;
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  }
	if ( $wp_customize->get_control( 'blogdescription' ) ) {
    $wp_customize->get_control('blogdescription')->priority = 3;
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  }
  if ( method_exists( $wp_customize, 'register_control_type' ) ) {
    $wp_customize->register_control_type( 'Customize_Misc_Control' );
    $wp_customize->register_control_type( 'Range_Slider_Control' );
  }
  if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'blogname',
      array(
        'selector' => '.main-title a',
        'render_callback' => 'customize_partial_blogname',
      )
    );
		$wp_customize->selective_refresh->add_partial( 'blogdescription',
      array(
        'selector' => '.site-description',
        'render_callback' => 'customize_partial_blogdescription',
      )
    );
  }
  if ( class_exists( 'WP_Customize_Panel' ) ) {
    if ( ! $wp_customize->get_panel( 'layout_panel' ) ) {
      $wp_customize->add_panel( 'layout_panel',
        array(
          'priority' => 25,
          'title' => __( 'Layout', 'TheCreativityArchitect' ),
          'description' => esc_html__( 'Page Layouts' ),
          'capability' => 'edit_theme_options',
        )
      );
    }
  }
  if ( ! apply_filters( 'fontawesome_essentials', false ) ) {
    $wp_customize->add_setting( 'settings[font_awesome_essentials]',
      array(
        'default' => $defaults['font_awesome_essentials'],
        'type' => 'option',
        'sanitize_callback' => 'sanitize_checkbox'
      )
    );
    wp_customize->add_control( 'settings[font_awesome_essentials]',
      array(
        'type' => 'checkbox',
        'label' => __( 'Load essential icons only', 'TheCreativityArchitect' ),
        'description' => __( 'Load essential Font Awesome icons instead of the full library.', 'TheCreativityArchitect' ),
        'section' => 'general_section',
        'settings' => 'settings[font_awesome_essentials]',
      )
    );
  }

  $wp_customize->add_section( 'layout_container',
    array(
      'title' => __( 'Container', 'TheCreativityArchitect' ),
      'priority' => 10,
      'panel' => 'layout_panel'
    )
  );
  $wp_customize->add_section( 'write_form' ,
    array(
			'title'    => __('Writing Form','radcliffe'),
			'panel'    => 'customize_writer',
			'priority' => 10,
		) );
  $wp_customize->add_section( 'theme_options',
    array(
      'title'    => __( 'Theme Options' ),
      'description' => esc_html__( 'Theme Options' ),
      'priority' => 125,
      'capability' => 'edit_theme_options',
      'description_hidden' => 'false',
    )
  );
  $wp_customize->add_section( 'layout_effects',
    array(
			'title' => __( 'Effects', 'TheCreativityArchitect' ),
			'priority' => 24,
		)
	);
  $wp_customize->add_section( 'top_bar',
    array(
			'title' => __( 'Top Bar', 'TheCreativityArchitect' ),
			'priority' => 15,
			'panel' => 'layout_panel',
    )
  );

  $wp_customize->add_panel( 'customize_writer',
    array(
			'priority'       => 500,
			'theme_supports' => '',
			'title'          => __( 'TRU Writer', 	'radcliffe'),
			'description'    => __( 'Customizer Stuff', 'radcliffe'),
		)
	);

	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_setting( 'copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage', ) );
	$wp_customize->add_control( 'copyright_text',
		array(
			'label'   => esc_html__( 'Add copyright text in the footer.', 'TheCreativityArchitect' ),
			'section' => 'theme_options',
			'type'    => 'textarea',
		) );

	$wp_customize->add_setting('text-color',
		array(
			'default'           => '#eaeaea',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'text-color',
			array(
				'label'    => esc_html__( 'General text color', 'TheCreativityArchitect' ),
				'section'  => 'colors',
				'settings' => 'text-color',
				'priority' => 8,
			)
		)
	);

	$wp_customize->add_setting( 'menu-links',
		array(
      'default'           => '#ffffff',
      'sanitize_callback' => 'sanitize_hex_color',
    )
  );
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'menu-links',
		array(
			'label'    => esc_html__( 'Menu links', 'TheCreativityArchitect' ),
			'section'  => 'colors',
			'settings' => 'menu-links',
			'priority' => 10,
    )
    )
  );

	$wp_customize->add_setting( 'secondary-color',
		array(
			'default'           => '#f44336',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'secondary-color',
		array(
				'label'    => esc_html__( 'Change the theme red color throughout', 'TheCreativityArchitect' ),
				'section'  => 'colors',
				'settings' => 'secondary-color',
				'priority' => 12,
			)
		)
	);

	$wp_customize->add_setting( 'title-color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'title-color',
			array(
				'label'    => esc_html__( 'Titles color', 'TheCreativityArchitect' ),
				'section'  => 'colors',
				'settings' => 'title-color',
				'priority' => 14,
			)
		)
	);

	$wp_customize->add_setting( 'default_prompt',
		array(
		 	'default'           => __( 'Enter the content for your writing below. You must save first and preview once before it goes into the system as a draft. After that, continue to edit, save, and preview as much as needed. Remember to click  "Publish Final" when you are done. If you include your email address, we can send you a link that will allow you to make changes later.', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'default_prompt',
    array(
			'label'    => __( 'Default Prompt', 'radcliffe'),
			'priority' => 10,
			'description' => __( 'The opening message greeting above the form.' ),
			'section'  => 'write_form',
			'settings' => 'default_prompt',
			'type'     => 'textarea',
    )
    )
  );

	$wp_customize->add_setting( 're_edit_prompt',
		array(
			'default'           => __( 'You can now re-edit any part of this previously published writing. If you do not save any final changes, it will be left as it was before.', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		)
  );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 're_edit_prompt',
			array(
				'label'    => __( 'Return Edit Prompt', 'radcliffe'),
				'priority' => 12,
				'description' => __( 'The opening message greeting above the form for a request to edit a previously published item.' ),
				'section'  => 'write_form',
				'settings' => 're_edit_prompt',
				'type'     => 'textarea',
			)
			)
		);

		// setting for title label

  $wp_customize->add_setting( 'item_title',
    array(
		  'default'           => __( 'The Title', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text'
		)
  );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_title',
      array(
        'label'    => __( 'Title Label', 'radcliffe'),
			  'priority' => 16,
			  'description' => __( '' ),
			  'section'  => 'write_form',
			  'settings' => 'item_title',
			  'type'     => 'text'
      ),
      )
    );

  $wp_customize->add_setting( 'item_title_prompt',
    array(
      'default'           => __( 'A good title is important! Create an eye-catching title for your story, one that would make a person who sees it want to stop whatever they are doing and read it.', 'radcliffe' ),
      'type' => 'theme_mod',
      'sanitize_callback' => 'sanitize_text',
    )
  );
	$wp_customize->add_control( new WP_Customize_Control (
    $wp_customize, 'item_title_prompt',
      array(
        'label'    => __( 'Title Prompt', 'radcliffe'),
        'priority' => 17,
  			'description' => __( '' ),
  			'section'  => 'write_form',
  			'settings' => 'item_title_prompt',
  			'type'     => 'textarea'
      )
  	  )
  	);

	$wp_customize->add_setting( 'item_byline',
    array(
	    'default'           => __( 'How to List Author', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text'
		)
  );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_byline',
      array(
        'label'    => __( 'Author Byline Label', 'radcliffe'),
        'priority' => 18,
        'description' => __( '' ),
        'section'  => 'write_form',
        'settings' => 'item_byline',
        'type'     => 'text'
      )
    )
  );

	$wp_customize->add_setting( 'item_byline_prompt',
    array(
			 'default'           => __( 'Publish under your name, twitter handle, secret agent name, or remain "Anonymous". If you include a twitter handle such as @billyshakespeare, when someone tweets your work you will get a lovely notification.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_byline_prompt',
      array(
  			'label'    => __( 'Author Byline Prompt', 'radcliffe'),
  			'priority' => 19,
  			'description' => __( 'Directions for the author entry field' ),
  			'section'  => 'write_form',
  			'settings' => 'item_byline_prompt',
  			'type'     => 'textarea',
      )
    )
  );

	$wp_customize->add_setting( 'item_writing_area',
		array(
			'default'           => __( 'Writing Area', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_writing_area',
		array(
			'label'    => __( 'Writing Area Label', 'radcliffe'),
			'priority' => 20,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_writing_area',
			'type'     => 'text',
		)
		)
	);

	$wp_customize->add_setting( 'item_writing_area_prompt',
		array(
		 'default'           => __( 'Use the editing area below the toolbar to write and format your writing. You can also paste formatted content here (e.g. from MS Word or Google Docs). The editing tool will do its best to preserve standard formatting--headings, bold, italic, lists, footnotes, and hypertext links. Click "Add Media" to upload images to include in your writing or choose from the media already in the media library (click on the tab labelled "media library"). You can also embed audio and video from many social sites simply by putting the URL of the media on a separate line (you will see a place holder in the editor, but the media will only show in preview and when published).  Click and drag the icon in the lower right to resize the editing space.', 'radcliffe'),
		 'type' => 'theme_mod',
		 'sanitize_callback' => 'sanitize_text',
	 ) );
  $wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_writing_area_prompt',
		array(
			'label'    => __( 'Writing Area Prompt', 'radcliffe'),
			'priority' => 22,
			'description' => __( 'Directions for the main writing entry field' ),
			'section'  => 'write_form',
			'settings' => 'item_writing_area_prompt',
			'type'     => 'textarea',
		)
		)
	);

	$wp_customize->add_setting( 'item_footer',
		array(
			'default'           => __( 'Additional Information for Footer', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_footer',
		array(
			'label'    => __( 'Footer Entry Label', 'radcliffe'),
			'priority' => 24,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_footer',
			'type'     => 'text',
		)
		)
		);

	$wp_customize->add_setting( 'item_footer_prompt',
		array(
		 'default'           => __( 'Add any endnote / credits information you wish to append to the end of your writing, such as a citation to where it was previously published or any other meta information. URLs will be automatically hyperlinked when published.', 'radcliffe'),
		 'type' => 'theme_mod',
		 'sanitize_callback' => 'sanitize_text',
	 ) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_footer_prompt',
		array(
			'label'    => __( 'Footer Prompt', 'radcliffe'),
			'priority' => 26,
			'description' => __( 'Directions for the footer entry field' ),
			'section'  => 'write_form',
			'settings' => 'item_footer_prompt',
			'type'     => 'textarea',
		)
		)
	);

	$wp_customize->add_setting( 'item_header_image',
		array(
			'default'           => __( 'Header Image', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_header_image',
		array(
			'label'    => __( 'Header Image Upload Label', 'radcliffe'),
			'priority' => 30,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_header_image',
			'type'     => 'text',
		)
		)
	);

	$wp_customize->add_setting( 'item_header_image_prompt',
		array(
			'default'           => __( 'You can upload any image file to be used in the header or choose from ones that have already been added to the site. Ideally this image should be at least 1440px wide for photos. Any uploaded image should either be your own or one licensed for re-use; provide an attribution credit for the image in the caption field below.', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text'
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_header_image_prompt',
		array(
			'label'    => __( 'Header Image Upload Prompt', 'radcliffe'),
			'priority' => 32,
			'description' => __( 'Directions for image uploads' ),
			'section'  => 'write_form',
			'settings' => 'item_header_image_prompt',
			'type'     => 'textarea',
		)
		)
	);

	$wp_customize->add_setting( 'item_header_caption',
		array(
			'default'           => __( 'Caption/credits for header image', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text'
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_header_caption',
		array(
			'label'    => __( 'Header Image Caption Label', 'radcliffe'),
			'priority' => 34,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_header_caption',
			'type'     => 'text',
		)
		)
	);

	$wp_customize->add_setting( 'item_header_caption_prompt',
			array(
			 'default'           => __( 'Provide full credit / attribution for the header image.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_header_caption_prompt',
		array(
			'label'    => __( 'Header Image Caption Prompt', 'radcliffe'),
			'priority' => 36,
			'description' => __( 'Directions for the header caption field' ),
			'section'  => 'write_form',
			'settings' => 'item_header_caption_prompt',
			'type'     => 'textarea',
			)
		  )
		);

	$wp_customize->add_setting( 'item_categories',
		array(
			'default'           => __( 'Kind of Writing', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_categories',
			array(
				'label'    => __( 'Categories Label', 'radcliffe'),
				'priority' => 40,
				'description' => __( '' ),
				'section'  => 'write_form',
				'settings' => 'item_categories',
				'type'     => 'text',
			)
			)
		);

	$wp_customize->add_setting( 'item_categories_prompt',
		array(
			'default'           => __( 'Check as many that apply.', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_categories_prompt',
		array(
			'label'    => __( 'Categories Prompt', 'radcliffe'),
			'priority' => 42,
			'description' => __( 'Directions for the categories selection' ),
			'section'  => 'write_form',
			'settings' => 'item_categories_prompt',
			'type'     => 'textarea',
		)
		)
	);

	$wp_customize->add_setting( 'item_tags',
		array(
			'default'           => __( 'Tags', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_tags',
		array(
			'label'    => __( 'Tags Label', 'radcliffe'),
			'priority' => 44,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_tags',
			'type'     => 'text',
		)
		)
	);

	$wp_customize->add_setting( 'item_tags_prompt',
		array(
			'default'           => __( 'Add any descriptive tags for your writing. Separate multiple ones with commas.', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		)
	);
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_tags_prompt',
      array(
        'label'    => __( 'Tags Prompt', 'radcliffe'),
        'priority' => 46,
			  'description' => __( 'Directions for tags entry' ),
			  'section'  => 'write_form',
			  'settings' => 'item_tags_prompt',
			  'type'     => 'textarea'
        )
			)
		);

	$wp_customize->add_setting( 'item_email',
		array(
			 'default'           => __( 'Your Email Address', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for email address  label
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_email',
	   array(
	    'label'    => __( 'Email Address Label', 'radcliffe'),
			'priority' => 50,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_email',
			'type'     => 'text',
		)
		)
	);

	$wp_customize->add_setting( 'item_email_prompt',
		array(
			'default'           => __( 'If you provide an email address when your writing is published, you can request a special link that will allow you to edit it again in the future.', 'radcliffe'),
		 'type' => 'theme_mod',
		 'sanitize_callback' => 'sanitize_text',
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_email_prompt',
		array(
			'label'    => __( 'Email Address Prompt', 'radcliffe'),
			'priority' => 52,
			'description' => __( 'Directions for email address entry' ),
			'section'  => 'write_form',
			'settings' => 'item_email_prompt',
			'type'     => 'textarea',
		 )
		 )
	 );

	$wp_customize->add_setting( 'item_editor_notes',
		array(
			'default'           => __( 'Extra Information for Editors', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text',
		) );
  $wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_editor_notes',
		array(
			'label'    => __( 'Editor Notes Label', 'radcliffe'),
			'priority' => 54,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_editor_notes',
			'type'     => 'text',
		)
		)
	);

	$wp_customize->add_setting( 'item_editor_notes_prompt',
		array(
			'default'           => __( 'This information will *not* be published with your work, it is informational for the editor use only.', 'radcliffe'),
		 	'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text'
		) );
	$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_editor_notes_prompt',
		array(
			'label'    => __( 'Editor Notes Prompt', 'radcliffe'),
			'priority' => 56,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_editor_notes_prompt',
			'type'     => 'textarea'
		)
	  )
	);

	$wp_customize->add_setting( 'item_license',
		array(
		 'default'           => __( 'Creative Commons License', 'radcliffe'),
		 'type' => 'theme_mod',
		 'sanitize_callback' => 'sanitize_text'
		)
	);
  $wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_license',
		array(
			'label'    => __( 'License Label', 'radcliffe'),
			'priority' => 27,
			'description' => __( '' ),
			'section'  => 'write_form',
			'settings' => 'item_license',
			'type'     => 'text'
	   )
	   )
	);

	$wp_customize->add_setting( 'item_license_prompt',
		array(
			'default'           => __( 'Choose your preferred license.', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text'
		)
	);
  $wp_customize->add_control( new WP_Customize_Control(
    $wp_customize, 'item_license_prompt',
		array(
			'label'    => __( 'Image Source Prompt', 'radcliffe'),
			'priority' => 28,
		  'description' => __( 'Directions for the license selection' ),
		  'section'  => 'write_form',
		  'settings' => 'item_license_prompt',
		  'type'     => 'textarea'
	  )
	  )
	);

	$wp_customize->add_setting( 'settings[bg_dots]',
		array(
			'default' => 'enable',
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);
	$wp_customize->add_control( 'settings[bg_dots]',
		array(
			'type' => 'select',
			'label' => __( 'BG dots', 'TheCreativityArchitect' ),
			'choices' => array(
				'enable' => __( 'Enable', 'TheCreativityArchitect' ),
				'disable' => __( 'Disable', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[bg_dots]',
			'section' => 'layout_effects',
			'priority' => 1
		)
	);

	$wp_customize->add_setting( 'settings[magic_cursor]',
		array(
			'default' => 'enable',
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
			)
		);
	$wp_customize->add_control( 'settings[magic_cursor]',
		array(
			'type' => 'select',
			'label' => __( 'Magic cursor', 'TheCreativityArchitect' ),
			'choices' => array(
				'enable' => __( 'Enable', 'TheCreativityArchitect' ),
				'disable' => __( 'Disable', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[magic_cursor]',
			'section' => 'layout_effects',
			'priority' => 2
		)
	);

	$wp_customize->add_setting( 'settings[blog_bg]',
		array(
			'default' => 'enable',
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);
	$wp_customize->add_control( 'settings[blog_bg]',
		array(
			'type' => 'select',
			'label' => __( 'Blog post background', 'TheCreativityArchitect' ),
			'choices' => array(
				'enable' => __( 'Enable', 'TheCreativityArchitect' ),
				'disable' => __( 'Disable', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[blog_bg]',
			'section' => 'layout_effects',
			'priority' => 3
		)
	);

	$wp_customize->add_setting( 'settings[nav_btn_text]',
		array(
			'default' => '',
			'type' => 'option',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'settings[nav_btn_text]',
		array(
			'type' => 'text',
			'label' => __( 'Extra button text', 'TheCreativityArchitect' ),
			'section' => 'layout_effects',
			'settings' => 'settings[nav_btn_text]',
			'priority' => 25
		)
	);

	$wp_customize->add_setting( 'settings[nav_btn_url]',
		array(
			'default' => '',
			'type' => 'option',
			'sanitize_callback' => 'esc_url'
		)
	);
	$wp_customize->add_control( 'settings[nav_btn_url]',
		array(
			'type' => 'text',
			'label' => __( 'Extra button URL', 'TheCreativityArchitect' ),
			'section' => 'layout_effects',
			'settings' => 'settings[nav_btn_url]',
			'priority' => 25
		)
	);

	$wp_customize->add_setting( 'settings[hide_title]',
    array(
		  'default' => $defaults['hide_title'],
		  'type' => 'option',
		  'sanitize_callback' => 'sanitize_checkbox'
    )
  );
	$wp_customize->add_control( 'settings[hide_title]',
		array(
			'type' => 'checkbox',
			'label' => __( 'Hide site title', 'TheCreativityArchitect' ),
			'section' => 'title_tagline',
			'priority' => 2
		)
	);

	$wp_customize->add_setting( 'settings[hide_tagline]',
		array(
			'default' => $defaults['hide_tagline'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_checkbox'
		)
	);
	$wp_customize->add_control( 'settings[hide_tagline]',
		array(
			'type' => 'checkbox',
			'label' => __( 'Hide site tagline', 'TheCreativityArchitect' ),
			'section' => 'title_tagline',
			'priority' => 4
		)
	);

	$wp_customize->add_setting( 'settings[retina_logo]',
		array(
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
    $wp_customize, 'settings[retina_logo]',
		array(
			'label' => __( 'Retina Logo', 'TheCreativityArchitect' ),
			'section' => 'title_tagline',
			'settings' => 'settings[retina_logo]',
			'active_callback' => 'has_custom_logo_callback'
		)
		)
	);

	$wp_customize->add_setting( 'settings[side_inside_color]',
    array(
			'default' => $defaults['side_inside_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'settings[side_inside_color]',
		array(
			'label' => __( 'Inside padding', 'TheCreativityArchitect' ),
			'section' => 'colors',
			'settings' => 'settings[side_inside_color]',
			'active_callback' => 'is_side_padding_active',
		)
		)
	);

	$wp_customize->add_setting( 'settings[text_color]',
		array(
			'default' => $defaults['text_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'settings[text_color]',
		array(
			'label' => __( 'Text Color', 'TheCreativityArchitect' ),
			'section' => 'colors',
			'settings' => 'settings[text_color]'
		)
		)
	);

	$wp_customize->add_setting( 'settings[link_color]',
		array(
			'default' => $defaults['link_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'settings[link_color]',
		array(
			'label' => __( 'Link Color', 'TheCreativityArchitect' ),
			'section' => 'colors',
			'settings' => 'settings[link_color]'
		)
		)
	);

	$wp_customize->add_setting( 'settings[link_color_hover]',
		array(
			'default' => $defaults['link_color_hover'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'settings[link_color_hover]',
		array(
			'label' => __( 'Link Color Hover', 'TheCreativityArchitect' ),
			'section' => 'colors',
			'settings' => 'settings[link_color_hover]'
		)
		)
	);

	$wp_customize->add_setting( 'settings[link_color_visited]',
		array(
			'default' => $defaults['link_color_visited'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'refresh',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 'settings[link_color_visited]',
		array(
			'label' => __( 'Link Color Visited', 'TheCreativityArchitect' ),
			'section' => 'colors',
			'settings' => 'settings[link_color_visited]'
			)
		)
	);

  $wp_customize->add_setting( 'settings[container_width]',
    array(
			'default' => $defaults['container_width'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_integer',
			'transport' => 'postMessage'
    )
  );
	$wp_customize->add_control( new Range_Slider_Control(
    $wp_customize, 'settings[container_width]',
      array(
			'type' => 'lalita-range-slider',
			'label' => __( 'Container Width', 'TheCreativityArchitect' ),
			'section' => 'layout_container',
			'settings' => array(
				'desktop' => 'settings[container_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 700,
					'max' => 2000,
					'step' => 5,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 0,
		  )
    )
	);

	// Add Top Bar section

	// Add Top Bar width
	$wp_customize->add_setting( 'settings[top_bar_width]',
		array(
			'default' => $defaults['top_bar_width'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);
  $wp_customize->add_control( 'settings[top_bar_width]',
    array(
			'type' => 'select',
			'label' => __( 'Top Bar Width', 'TheCreativityArchitect' ),
			'section' => 'top_bar',
			'choices' => array(
        'full' => __( 'Full', 'TheCreativityArchitect' ),
        'contained' => __( 'Contained', 'TheCreativityArchitect' )
      ),
			'settings' => 'settings[top_bar_width]',
			'priority' => 5,
			'active_callback' => 'is_top_bar_active',
    )
	);

	// Add Top Bar inner width
	$wp_customize->add_setting( 'settings[top_bar_inner_width]',
		array(
			'default' => $defaults['top_bar_inner_width'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);
  $wp_customize->add_control( 'settings[top_bar_inner_width]',
		array(
			'type' => 'select',
			'label' => __( 'Top Bar Inner Width', 'TheCreativityArchitect' ),
			'section' => 'top_bar',
			'choices' => array(
				'full' => __( 'Full', 'TheCreativityArchitect' ),
				'contained' => __( 'Contained', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[top_bar_inner_width]',
			'priority' => 10,
			'active_callback' => 'is_top_bar_active',
		)
	);

	// Add top bar alignment
	$wp_customize->add_setting( 'settings[top_bar_alignment]',
		array(
			'default' => $defaults['top_bar_alignment'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);
  $wp_customize->add_control( 'settings[top_bar_alignment]',
    array(
			'type' => 'select',
			'label' => __( 'Top Bar Alignment', 'TheCreativityArchitect' ),
			'section' => 'top_bar',
			'choices' => array(
				'left' => __( 'Left', 'TheCreativityArchitect' ),
				'center' => __( 'Center', 'TheCreativityArchitect' ),
				'right' => __( 'Right', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[top_bar_alignment]',
			'priority' => 15,
			'active_callback' => 'is_top_bar_active',
		)
	);

	// Add Header section
	$wp_customize->add_section(
		'layout_header',
		array(
			'title' => __( 'Header', 'TheCreativityArchitect' ),
			'priority' => 20,
			'panel' => 'layout_panel'
		)
	);

	// Add Header Layout setting
	$wp_customize->add_setting(
		'settings[header_layout_setting]',
		array(
			'default' => $defaults['header_layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add Header Layout control
	$wp_customize->add_control(
		'settings[header_layout_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Header Width', 'TheCreativityArchitect' ),
			'section' => 'layout_header',
			'choices' => array(
				'fluid-header' => __( 'Full', 'TheCreativityArchitect' ),
				'contained-header' => __( 'Contained', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[header_layout_setting]',
			'priority' => 5
		)
	);

	// Add Inside Header Layout setting
	$wp_customize->add_setting(
		'settings[header_inner_width]',
		array(
			'default' => $defaults['header_inner_width'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add Header Layout control
	$wp_customize->add_control(
		'settings[header_inner_width]',
		array(
			'type' => 'select',
			'label' => __( 'Inner Header Width', 'TheCreativityArchitect' ),
			'section' => 'layout_header',
			'choices' => array(
				'contained' => __( 'Contained', 'TheCreativityArchitect' ),
				'full-width' => __( 'Full', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[header_inner_width]',
			'priority' => 6
		)
	);

	// Add navigation setting
	$wp_customize->add_setting(
		'settings[header_alignment_setting]',
		array(
			'default' => $defaults['header_alignment_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add navigation control
	$wp_customize->add_control(
		'settings[header_alignment_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Header Alignment', 'TheCreativityArchitect' ),
			'section' => 'layout_header',
			'choices' => array(
				'left' => __( 'Left', 'TheCreativityArchitect' ),
				'center' => __( 'Center', 'TheCreativityArchitect' ),
				'right' => __( 'Right', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[header_alignment_setting]',
			'priority' => 10
		)
	);

	$wp_customize->add_section(
		'layout_navigation',
		array(
			'title' => __( 'Primary Navigation', 'TheCreativityArchitect' ),
			'priority' => 30,
			'panel' => 'layout_panel'
		)
	);

	// Add navigation setting
	$wp_customize->add_setting(
		'settings[nav_layout_setting]',
		array(
			'default' => $defaults['nav_layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add navigation control
	$wp_customize->add_control(
		'settings[nav_layout_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Navigation Width', 'TheCreativityArchitect' ),
			'section' => 'layout_navigation',
			'choices' => array(
				'fluid-nav' => __( 'Full', 'TheCreativityArchitect' ),
				'contained-nav' => __( 'Contained', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[nav_layout_setting]',
			'priority' => 15
		)
	);

	// Add navigation setting
	$wp_customize->add_setting(
		'settings[nav_inner_width]',
		array(
			'default' => $defaults['nav_inner_width'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add navigation control
	$wp_customize->add_control(
		'settings[nav_inner_width]',
		array(
			'type' => 'select',
			'label' => __( 'Inner Navigation Width', 'TheCreativityArchitect' ),
			'section' => 'layout_navigation',
			'choices' => array(
				'contained' => __( 'Contained', 'TheCreativityArchitect' ),
				'full-width' => __( 'Full', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[nav_inner_width]',
			'priority' => 16
		)
	);

	// Add navigation setting
	$wp_customize->add_setting(
		'settings[nav_alignment_setting]',
		array(
			'default' => $defaults['nav_alignment_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add navigation control
	$wp_customize->add_control(
		'settings[nav_alignment_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Navigation Alignment', 'TheCreativityArchitect' ),
			'section' => 'layout_navigation',
			'choices' => array(
				'left' => __( 'Left', 'TheCreativityArchitect' ),
				'center' => __( 'Center', 'TheCreativityArchitect' ),
				'right' => __( 'Right', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[nav_alignment_setting]',
			'priority' => 20
		)
	);

	// Add navigation setting
	$wp_customize->add_setting(
		'settings[nav_position_setting]',
		array(
			'default' => $defaults['nav_position_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => ( '' !== get_setting( 'nav_position_setting' ) ) ? 'postMessage' : 'refresh'
		)
	);

	// Add navigation control
	$wp_customize->add_control(
		'settings[nav_position_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Navigation Location', 'TheCreativityArchitect' ),
			'section' => 'layout_navigation',
			'choices' => array(
				'nav-below-header' => __( 'Below Header', 'TheCreativityArchitect' ),
				'nav-above-header' => __( 'Above Header', 'TheCreativityArchitect' ),
				'nav-float-right' => __( 'Float Right', 'TheCreativityArchitect' ),
				'nav-float-left' => __( 'Float Left', 'TheCreativityArchitect' ),
				'nav-left-sidebar' => __( 'Left Sidebar', 'TheCreativityArchitect' ),
				'nav-right-sidebar' => __( 'Right Sidebar', 'TheCreativityArchitect' ),
				'' => __( 'No Navigation', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[nav_position_setting]',
			'priority' => 22
		)
	);

	// Add navigation setting
	$wp_customize->add_setting(
		'settings[nav_dropdown_type]',
		array(
			'default' => $defaults['nav_dropdown_type'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);

	// Add navigation control
	$wp_customize->add_control(
		'settings[nav_dropdown_type]',
		array(
			'type' => 'select',
			'label' => __( 'Navigation Dropdown', 'TheCreativityArchitect' ),
			'section' => 'layout_navigation',
			'choices' => array(
				'hover' => __( 'Hover', 'TheCreativityArchitect' ),
				'click' => __( 'Click - Menu Item', 'TheCreativityArchitect' ),
				'click-arrow' => __( 'Click - Arrow', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[nav_dropdown_type]',
			'priority' => 22
		)
	);

	// Add navigation setting
	$wp_customize->add_setting( 'settings[nav_search]',
		array(
			'default' => $defaults['nav_search'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);

	// Add navigation control
	$wp_customize->add_control( 'settings[nav_search]',
		array(
			'type' => 'select',
			'label' => __( 'Navigation Search', 'TheCreativityArchitect' ),
			'section' => 'layout_navigation',
			'choices' => array(
				'enable' => __( 'Enable', 'TheCreativityArchitect' ),
				'disable' => __( 'Disable', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[nav_search]',
			'priority' => 23
		)
	);

	// Add navigation setting
	$wp_customize->add_setting( 'settings[nav_effect]',
		array(
			'default' => $defaults['nav_effect'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);

	// Add navigation control
	$wp_customize->add_control( 'settings[nav_effect]',
		array(
			'type' => 'select',
			'label' => __( 'Navigation Effects', 'TheCreativityArchitect' ),
			'section' => 'layout_navigation',
			'choices' => array(
				'none' => __( 'None', 'TheCreativityArchitect' ),
				'stylea' => __( 'Brackets', 'TheCreativityArchitect' ),
				'styleb' => __( 'Borders', 'TheCreativityArchitect' ),
				'stylec' => __( 'Switch', 'TheCreativityArchitect' ),
				'styled' => __( 'Fall down', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[nav_effect]',
			'priority' => 24
		)
	);

	// Add content setting
	$wp_customize->add_setting( 'settings[content_layout_setting]',
		array(
			'default' => $defaults['content_layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add content control
	$wp_customize->add_control( 'settings[content_layout_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Content Layout', 'TheCreativityArchitect' ),
			'section' => 'layout_container',
			'choices' => array(
				'separate-containers' => __( 'Separate Containers', 'TheCreativityArchitect' ),
				'one-container' => __( 'One Container', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[content_layout_setting]',
			'priority' => 25
		)
	);

	$wp_customize->add_section( 'layout_sidecontent',
		array(
			'title' => __( 'Fixed Side Content', 'TheCreativityArchitect' ),
			'priority' => 39,
			'panel' => 'layout_panel'
		)
	);

	$wp_customize->add_setting( 'settings[fixed_side_content]',
		array(
			'default' => $defaults['fixed_side_content'],
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control( 'settings[fixed_side_content]',
		array(
			'type' 		 => 'textarea',
			'label'      => __( 'Fixed Side Content', 'TheCreativityArchitect' ),
			'description'=> __( 'Content that You want to display fixed on the left.', 'TheCreativityArchitect' ),
			'section'    => 'layout_sidecontent',
			'settings'   => 'settings[fixed_side_content]',
		)
	);

	$wp_customize->add_section( 'layout_sidebars',
		array(
			'title' => __( 'Sidebars', 'TheCreativityArchitect' ),
			'priority' => 40,
			'panel' => 'layout_panel'
		)
	);

	// Add Layout setting
	$wp_customize->add_setting( 'settings[layout_setting]',
		array(
			'default' => $defaults['layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);

	// Add Layout control
	$wp_customize->add_control( 'settings[layout_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Sidebar Layout', 'TheCreativityArchitect' ),
			'section' => 'layout_sidebars',
			'choices' => array(
				'left-sidebar' => __( 'Sidebar / Content', 'TheCreativityArchitect' ),
				'right-sidebar' => __( 'Content / Sidebar', 'TheCreativityArchitect' ),
				'no-sidebar' => __( 'Content (no sidebars)', 'TheCreativityArchitect' ),
				'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'TheCreativityArchitect' ),
				'both-left' => __( 'Sidebar / Sidebar / Content', 'TheCreativityArchitect' ),
				'both-right' => __( 'Content / Sidebar / Sidebar', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[layout_setting]',
			'priority' => 30
		)
	);

	// Add Layout setting
	$wp_customize->add_setting( 'settings[blog_layout_setting]',
		array(
			'default' => $defaults['blog_layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);

	// Add Layout control
	$wp_customize->add_control( 'settings[blog_layout_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Blog Sidebar Layout', 'TheCreativityArchitect' ),
			'section' => 'layout_sidebars',
			'choices' => array(
				'left-sidebar' => __( 'Sidebar / Content', 'TheCreativityArchitect' ),
				'right-sidebar' => __( 'Content / Sidebar', 'TheCreativityArchitect' ),
				'no-sidebar' => __( 'Content (no sidebars)', 'TheCreativityArchitect' ),
				'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'TheCreativityArchitect' ),
				'both-left' => __( 'Sidebar / Sidebar / Content', 'TheCreativityArchitect' ),
				'both-right' => __( 'Content / Sidebar / Sidebar', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[blog_layout_setting]',
			'priority' => 35
		)
	);

	// Add Layout setting
	$wp_customize->add_setting( 'settings[single_layout_setting]',
		array(
			'default' => $defaults['single_layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);

	// Add Layout control
	$wp_customize->add_control( 'settings[single_layout_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Single Post Sidebar Layout', 'TheCreativityArchitect' ),
			'section' => 'layout_sidebars',
			'choices' => array(
				'left-sidebar' => __( 'Sidebar / Content', 'TheCreativityArchitect' ),
				'right-sidebar' => __( 'Content / Sidebar', 'TheCreativityArchitect' ),
				'no-sidebar' => __( 'Content (no sidebars)', 'TheCreativityArchitect' ),
				'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'TheCreativityArchitect' ),
				'both-left' => __( 'Sidebar / Sidebar / Content', 'TheCreativityArchitect' ),
				'both-right' => __( 'Content / Sidebar / Sidebar', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[single_layout_setting]',
			'priority' => 36
		)
	);

	$wp_customize->add_section( 'layout_footer',
		array(
			'title' => __( 'Footer', 'TheCreativityArchitect' ),
			'priority' => 50,
			'panel' => 'layout_panel'
		)
	);

	// Add footer setting
	$wp_customize->add_setting( 'settings[footer_layout_setting]',
		array(
			'default' => $defaults['footer_layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add content control
	$wp_customize->add_control( 'settings[footer_layout_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Footer Width', 'TheCreativityArchitect' ),
			'section' => 'layout_footer',
			'choices' => array(
				'fluid-footer' => __( 'Full', 'TheCreativityArchitect' ),
				'contained-footer' => __( 'Contained', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[footer_layout_setting]',
			'priority' => 40
		)
	);

	// Add footer setting
	$wp_customize->add_setting( 'settings[footer_widgets_inner_width]',
		array(
			'default' => $defaults['footer_widgets_inner_width'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
		)
	);

	// Add content control
	$wp_customize->add_control( 'settings[footer_widgets_inner_width]',
		array(
			'type' => 'select',
			'label' => __( 'Inner Footer Widgets Width', 'TheCreativityArchitect' ),
			'section' => 'layout_footer',
			'choices' => array(
				'contained' => __( 'Contained', 'TheCreativityArchitect' ),
				'full-width' => __( 'Full', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[footer_widgets_inner_width]',
			'priority' => 41
		)
	);

	// Add footer setting
	$wp_customize->add_setting( 'settings[footer_inner_width]',
		array(
			'default' => $defaults['footer_inner_width'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add content control
	$wp_customize->add_control( 'settings[footer_inner_width]',
		array(
			'type' => 'select',
			'label' => __( 'Inner Footer Width', 'TheCreativityArchitect' ),
			'section' => 'layout_footer',
			'choices' => array(
				'contained' => __( 'Contained', 'TheCreativityArchitect' ),
				'full-width' => __( 'Full', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[footer_inner_width]',
			'priority' => 41
		)
	);

	// Add footer widget setting
	$wp_customize->add_setting( 'settings[footer_widget_setting]',
		array(
			'default' => $defaults['footer_widget_setting'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add footer widget control
	$wp_customize->add_control( 'settings[footer_widget_setting]',
		array(
			'type' => 'select',
			'label' => __( 'Footer Widgets', 'TheCreativityArchitect' ),
			'section' => 'layout_footer',
			'choices' => array(
				'0' => '0',
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5'
			),
			'settings' => 'settings[footer_widget_setting]',
			'priority' => 45
		)
	);

	// Add footer widget setting
	$wp_customize->add_setting( 'settings[footer_bar_alignment]',
		array(
			'default' => $defaults['footer_bar_alignment'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices',
			'transport' => 'postMessage'
		)
	);

	// Add footer widget control
	$wp_customize->add_control( 'settings[footer_bar_alignment]',
		array(
			'type' => 'select',
			'label' => __( 'Footer Bar Alignment', 'TheCreativityArchitect' ),
			'section' => 'layout_footer',
			'choices' => array(
				'left' => __( 'Left','TheCreativityArchitect' ),
				'center' => __( 'Center','TheCreativityArchitect' ),
				'right' => __( 'Right','TheCreativityArchitect' )
			),
			'settings' => 'settings[footer_bar_alignment]',
			'priority' => 47,
			'active_callback' => 'is_footer_bar_active'
		)
	);

	// Add back to top setting
	$wp_customize->add_setting( 'settings[back_to_top]',
		array(
			'default' => $defaults['back_to_top'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_choices'
		)
	);

	// Add content control
	$wp_customize->add_control( 'settings[back_to_top]',
		array(
			'type' => 'select',
			'label' => __( 'Back to Top Button', 'TheCreativityArchitect' ),
			'section' => 'layout_footer',
			'choices' => array(
				'enable' => __( 'Enable', 'TheCreativityArchitect' ),
				'' => __( 'Disable', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[back_to_top]',
			'priority' => 50
		)
	);

	// Add Layout section
	$wp_customize->add_section( 'blog_section',
		array(
			'title' => __( 'Blog', 'TheCreativityArchitect' ),
			'priority' => 55,
			'panel' => 'layout_panel'
		)
	);

	$wp_customize->add_setting( 'settings[blog_header_image]',
		array(
			'default' => $defaults['blog_header_image'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'settings[blog_header_image]',
		array(
			'label' => __( 'Blog Header image', 'TheCreativityArchitect' ),
			'section' => 'blog_section',
			'settings' => 'settings[blog_header_image]',
			'description' => __( 'Recommended size: 1520*660px', 'TheCreativityArchitect' )
			)
		)
	);

	// Blog header texts
	$wp_customize->add_setting( 'settings[blog_header_title]',
		array(
			'default' => $defaults['blog_header_title'],
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control( 'settings[blog_header_title]',
		array(
			'type' 		 => 'textarea',
			'label'      => __( 'Blog Header title', 'TheCreativityArchitect' ),
			'section'    => 'blog_section',
			'settings'   => 'settings[blog_header_title]',
			'description' => __( 'HTML allowed.', 'TheCreativityArchitect' )
		)
	);

	$wp_customize->add_setting( 'settings[blog_header_text]',
		array(
			'default' => $defaults['blog_header_text'],
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control( 'settings[blog_header_text]',
		array(
			'type' 		 => 'textarea',
			'label'      => __( 'Blog Header text', 'TheCreativityArchitect' ),
			'section'    => 'blog_section',
			'settings'   => 'settings[blog_header_text]',
		)
	);

	$wp_customize->add_setting( 'settings[blog_header_button_text]',
		array(
			'default' => $defaults['blog_header_button_text'],
			'type' => 'option',
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control( 'settings[blog_header_button_text]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Blog Header button text', 'TheCreativityArchitect' ),
			'section'    => 'blog_section',
			'settings'   => 'settings[blog_header_button_text]',
		)
	);

	$wp_customize->add_setting( 'settings[blog_header_button_url]',
		array(
			'default' => $defaults['blog_header_button_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[blog_header_button_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Blog Header button url', 'TheCreativityArchitect' ),
			'section'    => 'blog_section',
			'settings'   => 'settings[blog_header_button_url]',
		)
	);

	// Add Layout setting
	$wp_customize->add_setting( 'settings[post_content]',
		array(
			'default' => $defaults['post_content'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_blog_excerpt'
		)
	);

	// Add Layout control
	$wp_customize->add_control( 'blog_content_control',
		array(
			'type' => 'select',
			'label' => __( 'Content Type', 'TheCreativityArchitect' ),
			'section' => 'blog_section',
			'choices' => array(
				'full' => __( 'Full', 'TheCreativityArchitect' ),
				'excerpt' => __( 'Excerpt', 'TheCreativityArchitect' )
			),
			'settings' => 'settings[post_content]',
			'priority' => 10
		)
	);

	$wp_customize->add_section( 'general_section',
		array(
			'title' => __( 'General', 'TheCreativityArchitect' ),
			'priority' => 99
		)
	);

	$wp_customize->add_section( 'socials_section',
		array(
			'title' => __( 'Socials', 'TheCreativityArchitect' ),
			'priority' => 99
		)
	);

	$wp_customize->add_setting( 'settings[socials_display_side]',
		array(
			'default' => $defaults['socials_display_side'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_checkbox'
		)
	);

	$wp_customize->add_control( 'settings[socials_display_side]',
		array(
			'type' => 'checkbox',
			'label' => __( 'Display on fixed side', 'TheCreativityArchitect' ),
			'section' => 'socials_section'
		)
	);

	$wp_customize->add_setting( 'settings[socials_display_top]',
		array(
			'default' => $defaults['socials_display_top'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_checkbox'
		)
	);

	$wp_customize->add_control( 'settings[socials_display_top]',
		array(
			'type' => 'checkbox',
			'label' => __( 'Display on top bar', 'TheCreativityArchitect' ),
			'section' => 'socials_section'
		)
	);

	$wp_customize->add_setting( 'settings[socials_facebook_url]',
		array(
			'default' => $defaults['socials_facebook_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_facebook_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Facebook url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_facebook_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_twitter_url]',
		array(
			'default' => $defaults['socials_twitter_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_twitter_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Twitter url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_twitter_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_google_url]',
		array(
			'default' => $defaults['socials_google_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_google_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Google url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_google_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_tumblr_url]',
		array(
			'default' => $defaults['socials_tumblr_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_tumblr_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Tumblr url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_tumblr_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_pinterest_url]',
		array(
			'default' => $defaults['socials_pinterest_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_pinterest_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Pinterest url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_pinterest_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_youtube_url]',
		array(
			'default' => $defaults['socials_youtube_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_youtube_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Youtube url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_youtube_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_linkedin_url]',
		array(
			'default' => $defaults['socials_linkedin_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_linkedin_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Linkedin url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_linkedin_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_linkedin_url]',
		array(
			'default' => $defaults['socials_linkedin_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_linkedin_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Linkedin url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_linkedin_url]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_custom_icon_1]',
		array(
			'default' => $defaults['socials_custom_icon_1'],
			'type' => 'option',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control( 'settings[socials_custom_icon_1]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Custom icon 1', 'TheCreativityArchitect' ),
			'description'=> sprintf(
				'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
				esc_html__( 'You can add icon code for Your button.', 'TheCreativityArchitect' ),
				esc_html__( 'Example: ', 'TheCreativityArchitect' ),
				esc_html__( 'Use the codes from ', 'TheCreativityArchitect' ),
				esc_url( 'FONT_AWESOME_LINK' ),
				esc_html__( 'this link', 'TheCreativityArchitect' )
			),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_custom_icon_1]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_custom_icon_url_1]',
		array(
			'default' => $defaults['socials_custom_icon_url_1'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_custom_icon_url_1]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Custom icon 1 url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_custom_icon_url_1]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_custom_icon_2]',
		array(
			'default' => $defaults['socials_custom_icon_2'],
			'type' => 'option',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control( 'settings[socials_custom_icon_2]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Custom icon 2', 'TheCreativityArchitect' ),
			'description'=> sprintf(
				'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
				esc_html__( 'You can add icon code for Your button.', 'TheCreativityArchitect' ),
				esc_html__( 'Example: ', 'TheCreativityArchitect' ),
				esc_html__( 'Use the codes from ', 'TheCreativityArchitect' ),
				esc_url( 'FONT_AWESOME_LINK' ),
				esc_html__( 'this link', 'TheCreativityArchitect' )
			),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_custom_icon_2]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_custom_icon_url_2]',
		array(
			'default' => $defaults['socials_custom_icon_url_2'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_custom_icon_url_2]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Custom icon 2 url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_custom_icon_url_2]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_custom_icon_3]',
		array(
			'default' => $defaults['socials_custom_icon_3'],
			'type' => 'option',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control( 'settings[socials_custom_icon_3]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Custom icon 3', 'TheCreativityArchitect' ),
			'description'=> sprintf(
				'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
				esc_html__( 'You can add icon code for Your button.', 'TheCreativityArchitect' ),
				esc_html__( 'Example: ', 'TheCreativityArchitect' ),
				esc_html__( 'Use the codes from ', 'TheCreativityArchitect' ),
				esc_url( 'FONT_AWESOME_LINK' ),
				esc_html__( 'this link', 'TheCreativityArchitect' )
			),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_custom_icon_3]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_custom_icon_url_3]',
		array(
			'default' => $defaults['socials_custom_icon_url_3'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url',
		)
	);

	$wp_customize->add_control( 'settings[socials_custom_icon_url_3]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'Custom icon 3 url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_custom_icon_url_3]',
		)
	);

	$wp_customize->add_setting( 'settings[socials_mail_url]',
		array(
			'default' => $defaults['socials_mail_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control( 'settings[socials_mail_url]',
		array(
			'type' 		 => 'text',
			'label'      => __( 'E-mail url', 'TheCreativityArchitect' ),
			'section'    => 'socials_section',
			'settings'   => 'settings[socials_mail_url]',
		)
	);
}

function sanitize_choices( $input, $setting ) {
	$input = sanitize_key( $input );
	$choices = $setting->manager->get_control(
		$setting->id )->choices;
	return (
		array_key_exists( $input, $choices ) ? $input : $setting->default
	);
}

function sanitize_text( $text ) {
	return sanitize_text_field( $text );
}

function extra_colors_css() {
	$settings = wp_parse_args(
		get_option( 'settings', array() ),
		get_color_defaults() );
	$bg_color = get_background_color();
	$extracolors = 'header .main-navigation .main-nav ul li a.wpkoi-nav-btn {background-color: ' . esc_attr( $settings[ 'navigation_text_color' ] ) . '; color: ' . esc_attr( $settings[ 'navigation_background_color' ] ) . ';} header .main-navigation .main-nav ul li a.wpkoi-nav-btn:hover {background-color: ' . esc_attr( $settings[ 'navigation_text_hover_color' ] ) . '; color: ' . esc_attr( $settings[ 'navigation_background_color' ] ) . ';}.transparent-header.home .main-navigation.is_stuck {background-color: #' . esc_attr( $bg_color ) . ';}';

	return $extracolors;
}

function remove_dynamic_css() {
  remove_action( 'wp_enqueue_scripts', 'enqueue_dynamic_css', 50 );
}

function customizer_css() {
  ?>
  <style type="text/css">
    body {
			color: <?php echo esc_html( get_theme_mod( 'text-color', '#eaeaea' ) ); ?>;
		}
		.mainmenu ul li a {
			color: <?php echo esc_html( get_theme_mod( 'menu-links', '#ffffff' ) ); ?>;
		}
		.mainmenu ul li a:after, .error404 #searchform input#searchsubmit, .pagination a:hover, .pagination span.current, .wp-block-search .wp-block-search__button, .wpcf7 input.wpcf7-submit, #submit {
			background: <?php echo esc_html( get_theme_mod( 'secondary-color', '#f44336' ) ); ?>;
		}

		.wp-block-button__link {
			background-color: <?php echo esc_html( get_theme_mod( 'secondary-color', '#f44336' ) ); ?>;
		}
		.wpcf7 label span.required {
			color: <?php echo esc_html( get_theme_mod( 'secondary-color', '#f44336' ) ); ?>;
		}
		h1, h2, h3, h4, h5, h6, h1.page-title, h1.entry-title, h2.entry-title, h2.entry-title a, #respond h3, #comments h2 {
			color: <?php echo esc_html( get_theme_mod( 'title-color', '#ffffff' ) ); ?>;
		}
	</style>
	<?php
}

function customize_preview_js() {
	wp_enqueue_script( 'customizer', get_template_directory_uri() . '/assets/scripts/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
