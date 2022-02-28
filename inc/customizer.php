<?php
/**
 * __THEMENAE__: Customizer
 *
 * @package __THEMENAE__
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'theme_options',
		array(
			'title'    => esc_html__( 'Theme Options', '__THEMENAE__' ),
			'priority' => 125,
		)
	);

	$wp_customize->add_setting( 'copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control('copyright_text',
		array(
			'label'   => esc_html__( 'Add copyright text in the footer.', '__THEMENAE__' ),
			'section' => 'theme_options',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting('text-color',
		array(
			'default'           => '#eaeaea',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text-color',
			array(
				'label'    => esc_html__( 'General text color', '__THEMENAE__' ),
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

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu-links',
		array(
			'label'    => esc_html__( 'Menu links', '__THEMENAE__' ),
			'section'  => 'colors',
			'settings' => 'menu-links',
			'priority' => 10,
		)));

	$wp_customize->add_setting( 'secondary-color',
		array(
			'default'           => '#f44336',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary-color',
			array(
				'label'    => esc_html__( 'Change the theme red color throughout', '__THEMENAE__' ),
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

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'title-color',
			array(
				'label'    => esc_html__( 'Titles color', '__THEMENAE__' ),
				'section'  => 'colors',
				'settings' => 'title-color',
				'priority' => 14,
			)
		)
	);

	$wp_customize->add_panel( 'customize_writer',
		array(
			'priority'       => 500,
			'theme_supports' => '',
			'title'          => __( 'TRU Writer', 	'radcliffe'),
			'description'    => __( 'Customizer Stuff', 'radcliffe'), ) );

	$wp_customize->add_section( 'write_form' ,
		array(
			'title'    => __('Writing Form','radcliffe'),
			'panel'    => 'customize_writer',
			'priority' => 10
		) );

	$wp_customize->add_setting( 'default_prompt',
		array(
		 	'default'           => __( 'Enter the content for your writing below. You must save first and preview once before it goes into the system as a draft. After that, continue to edit, save, and preview as much as needed. Remember to click  "Publish Final" when you are done. If you include your email address, we can send you a link that will allow you to make changes later.', 'radcliffe'),
			'type' => 'theme_mod',
			'sanitize_callback' => 'sanitize_text'
		) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'default_prompt',
		array(
			'label'    => __( 'Default Prompt', 'radcliffe'),
			'priority' => 10,
			'description' => __( 'The opening message greeting above the form.' ),
			'section'  => 'write_form',
			'settings' => 'default_prompt',
			'type'     => 'textarea'
		)));

		$wp_customize->add_setting( 're_edit_prompt', array(
			 'default'           => __( 'You can now re-edit any part of this previously published writing. If you do not save any final changes, it will be left as it was before.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Add control for re-edit prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			're_edit_prompt',
			    array(
			        'label'    => __( 'Return Edit Prompt', 'radcliffe'),
			        'priority' => 12,
			        'description' => __( 'The opening message greeting above the form for a request to edit a previously published item.' ),
			        'section'  => 'write_form',
			        'settings' => 're_edit_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for title label
		$wp_customize->add_setting( 'item_title', array(
			 'default'           => __( 'The Title', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control fortitle label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_title',
			    array(
			        'label'    => __( 'Title Label', 'radcliffe'),
			        'priority' => 16,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_title',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for title description
		$wp_customize->add_setting( 'item_title_prompt', array(
			 'default'           => __( 'A good title is important! Create an eye-catching title for your story, one that would make a person who sees it want to stop whatever they are doing and read it.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for title description
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_title_prompt',
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

		// setting for byline label
		$wp_customize->add_setting( 'item_byline', array(
			 'default'           => __( 'How to List Author', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for byline label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_byline',
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

		// setting for byline  prompt
		$wp_customize->add_setting( 'item_byline_prompt', array(
			 'default'           => __( 'Publish under your name, twitter handle, secret agent name, or remain "Anonymous". If you include a twitter handle such as @billyshakespeare, when someone tweets your work you will get a lovely notification.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

	// Control for byline  prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_byline_prompt',
			    array(
			        'label'    => __( 'Author Byline Prompt', 'radcliffe'),
			        'priority' => 19,
			        'description' => __( 'Directions for the author entry field' ),
			        'section'  => 'write_form',
			        'settings' => 'item_byline_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for writing field  label
		$wp_customize->add_setting( 'item_writing_area', array(
			 'default'           => __( 'Writing Area', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for description  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_writing_area',
			    array(
			        'label'    => __( 'Writing Area Label', 'radcliffe'),
			        'priority' => 20,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_writing_area',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for description  label prompt
		$wp_customize->add_setting( 'item_writing_area_prompt', array(
			 'default'           => __( 'Use the editing area below the toolbar to write and format your writing. You can also paste formatted content here (e.g. from MS Word or Google Docs). The editing tool will do its best to preserve standard formatting--headings, bold, italic, lists, footnotes, and hypertext links. Click "Add Media" to upload images to include in your writing or choose from the media already in the media library (click on the tab labelled "media library"). You can also embed audio and video from many social sites simply by putting the URL of the media on a separate line (you will see a place holder in the editor, but the media will only show in preview and when published).  Click and drag the icon in the lower right to resize the editing space.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for description  label prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_writing_area_prompt',
			    array(
			        'label'    => __( 'Writing Area Prompt', 'radcliffe'),
			        'priority' => 22,
			        'description' => __( 'Directions for the main writing entry field' ),
			        'section'  => 'write_form',
			        'settings' => 'item_writing_area_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for footer  label
		$wp_customize->add_setting( 'item_footer', array(
			 'default'           => __( 'Additional Information for Footer', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for description  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_footer',
			    array(
			        'label'    => __( 'Footer Entry Label', 'radcliffe'),
			        'priority' => 24,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_footer',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for description  label prompt
		$wp_customize->add_setting( 'item_footer_prompt', array(
			 'default'           => __( 'Add any endnote / credits information you wish to append to the end of your writing, such as a citation to where it was previously published or any other meta information. URLs will be automatically hyperlinked when published.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for description  label prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_footer_prompt',
			    array(
			        'label'    => __( 'Footer Prompt', 'radcliffe'),
			        'priority' => 26,
			        'description' => __( 'Directions for the footer entry field' ),
			        'section'  => 'write_form',
			        'settings' => 'item_footer_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for header image upload label
		$wp_customize->add_setting( 'item_header_image', array(
			 'default'           => __( 'Header Image', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for header image upload  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_header_image',
			    array(
			        'label'    => __( 'Header Image Upload Label', 'radcliffe'),
			        'priority' => 30,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_header_image',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for header image upload prompt
		$wp_customize->add_setting( 'item_header_image_prompt', array(
			 'default'           => __( 'You can upload any image file to be used in the header or choose from ones that have already been added to the site. Ideally this image should be at least 1440px wide for photos. Any uploaded image should either be your own or one licensed for re-use; provide an attribution credit for the image in the caption field below.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for image upload prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_header_image_prompt',
			    array(
			        'label'    => __( 'Header Image Upload Prompt', 'radcliffe'),
			        'priority' => 32,
			        'description' => __( 'Directions for image uploads' ),
			        'section'  => 'write_form',
			        'settings' => 'item_header_image_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for header image caption label
		$wp_customize->add_setting( 'item_header_caption', array(
			 'default'           => __( 'Caption/credits for header image', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for header image caption   label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_header_caption',
			    array(
			        'label'    => __( 'Header Image Caption Label', 'radcliffe'),
			        'priority' => 34,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_header_caption',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for header image caption   label prompt
		$wp_customize->add_setting( 'item_header_caption_prompt', array(
			 'default'           => __( 'Provide full credit / attribution for the header image.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for header image caption   label prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_header_caption_prompt',
			    array(
			        'label'    => __( 'Header Image Caption Prompt', 'radcliffe'),
			        'priority' => 36,
			        'description' => __( 'Directions for the header caption field' ),
			        'section'  => 'write_form',
			        'settings' => 'item_header_caption_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for categories  label
		$wp_customize->add_setting( 'item_categories', array(
			 'default'           => __( 'Kind of Writing', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for categories  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_categories',
			    array(
			        'label'    => __( 'Categories Label', 'radcliffe'),
			        'priority' => 40,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_categories',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for categories  prompt
		$wp_customize->add_setting( 'item_categories_prompt', array(
			 'default'           => __( 'Check as many that apply.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for categories prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_categories_prompt',
			    array(
			        'label'    => __( 'Categories Prompt', 'radcliffe'),
			        'priority' => 42,
			        'description' => __( 'Directions for the categories selection' ),
			        'section'  => 'write_form',
			        'settings' => 'item_categories_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for tags  label
		$wp_customize->add_setting( 'item_tags', array(
			 'default'           => __( 'Tags', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for tags  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_tags',
			    array(
			        'label'    => __( 'Tags Label', 'radcliffe'),
			        'priority' => 44,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_tags',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for tags  prompt
		$wp_customize->add_setting( 'item_tags_prompt', array(
			 'default'           => __( 'Add any descriptive tags for your writing. Separate multiple ones with commas.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for tags prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_tags_prompt',
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

		// setting for email address  label
		$wp_customize->add_setting( 'item_email', array(
			 'default'           => __( 'Your Email Address', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for email address  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_email',
			    array(
			        'label'    => __( 'Email Address Label', 'radcliffe'),
			        'priority' => 50,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_email',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for email address  prompt
		$wp_customize->add_setting( 'item_email_prompt', array(
			 'default'           => __( 'If you provide an email address when your writing is published, you can request a special link that will allow you to edit it again in the future.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for email address prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_email_prompt',
			    array(
			        'label'    => __( 'Email Address Prompt', 'radcliffe'),
			        'priority' => 52,
			        'description' => __( 'Directions for email address entry' ),
			        'section'  => 'write_form',
			        'settings' => 'item_email_prompt',
			        'type'     => 'textarea'
			    )
		    )
		);

		// setting for editor notes  label
		$wp_customize->add_setting( 'item_editor_notes', array(
			 'default'           => __( 'Extra Information for Editors', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for editor notes  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_editor_notes',
			    array(
			        'label'    => __( 'Editor Notes Label', 'radcliffe'),
			        'priority' => 54,
			        'description' => __( '' ),
			        'section'  => 'write_form',
			        'settings' => 'item_editor_notes',
			        'type'     => 'text'
			    )
		    )
		);

		// setting for editor notes  prompt
		$wp_customize->add_setting( 'item_editor_notes_prompt', array(
			 'default'           => __( 'This information will *not* be published with your work, it is informational for the editor use only.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for editor notes prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_editor_notes_prompt',
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

		// setting for license  label
		$wp_customize->add_setting( 'item_license', array(
			 'default'           => __( 'Creative Commons License', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for license  label
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_license',
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

		// setting for license  prompt
		$wp_customize->add_setting( 'item_license_prompt', array(
			 'default'           => __( 'Choose your preferred license.', 'radcliffe'),
			 'type' => 'theme_mod',
			 'sanitize_callback' => 'sanitize_text'
		) );

		// Control for license prompt
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'item_license_prompt',
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
		// Add Adarsa customizer section
		$wp_customize->add_section(
			'layout_effects',
			array(
				'title' => __( 'Adarsa Effects', 'adarsa' ),
				'priority' => 24,
			)
		);


		// BG dots
		$wp_customize->add_setting(
			'settings[bg_dots]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'settings[bg_dots]',
			array(
				'type' => 'select',
				'label' => __( 'BG dots', 'adarsa' ),
				'choices' => array(
					'enable' => __( 'Enable', 'adarsa' ),
					'disable' => __( 'Disable', 'adarsa' )
				),
				'settings' => 'settings[bg_dots]',
				'section' => 'layout_effects',
				'priority' => 1
			)
		);


		// Magic cursor
		$wp_customize->add_setting(
			'settings[magic_cursor]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'settings[magic_cursor]',
			array(
				'type' => 'select',
				'label' => __( 'Magic cursor', 'adarsa' ),
				'choices' => array(
					'enable' => __( 'Enable', 'adarsa' ),
					'disable' => __( 'Disable', 'adarsa' )
				),
				'settings' => 'settings[magic_cursor]',
				'section' => 'layout_effects',
				'priority' => 2
			)
		);

		// Blog post background
		$wp_customize->add_setting(
			'settings[blog_bg]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'settings[blog_bg]',
			array(
				'type' => 'select',
				'label' => __( 'Blog post background', 'adarsa' ),
				'choices' => array(
					'enable' => __( 'Enable', 'adarsa' ),
					'disable' => __( 'Disable', 'adarsa' )
				),
				'settings' => 'settings[blog_bg]',
				'section' => 'layout_effects',
				'priority' => 3
			)
		);

		// Add navigation extra button text
		$wp_customize->add_setting(
			'settings[nav_btn_text]',
			array(
				'default' => '',
				'type' => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'settings[nav_btn_text]',
			array(
				'type' => 'text',
				'label' => __( 'Extra button text', 'adarsa' ),
				'section' => 'layout_effects',
				'settings' => 'settings[nav_btn_text]',
				'priority' => 25
			)
		);

		// Add navigation extra button url
		$wp_customize->add_setting(
			'settings[nav_btn_url]',
			array(
				'default' => '',
				'type' => 'option',
				'sanitize_callback' => 'esc_url'
			)
		);

		$wp_customize->add_control(
			'settings[nav_btn_url]',
			array(
				'type' => 'text',
				'label' => __( 'Extra button URL', 'adarsa' ),
				'section' => 'layout_effects',
				'settings' => 'settings[nav_btn_url]',
				'priority' => 25
			)
		);

	//Sanitize choices.
	if ( ! function_exists( 'sanitize_choices' ) ){
		function sanitize_choices( $input, $setting ){
			// Ensure input is a slug
			$input = sanitize_key( $input );
			// Get list of choices from the control
			// associated with the setting
			$choices = $setting->manager->get_control( $setting->id )->choices;
			// If the input is a valid key, return it;
			// otherwise, return the default
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
		}
	}
	// Sanitize text
	function sanitize_text( $text ) {
		return sanitize_text_field( $text );
	}
}

if ( ! function_exists( 'extra_colors_css' ) ) {
	function extra_colors_css() {
		// Get our settings
		$settings = wp_parse_args(
			get_option( 'settings', array() ),
			get_color_defaults()
		);

		$bg_color = get_background_color();

		$extracolors = 'header .main-navigation .main-nav ul li a.wpkoi-nav-btn {background-color: ' . esc_attr( $settings[ 'navigation_text_color' ] ) . '; color: ' . esc_attr( $settings[ 'navigation_background_color' ] ) . ';} header .main-navigation .main-nav ul li a.wpkoi-nav-btn:hover {background-color: ' . esc_attr( $settings[ 'navigation_text_hover_color' ] ) . '; color: ' . esc_attr( $settings[ 'navigation_background_color' ] ) . ';}.transparent-header.home .main-navigation.is_stuck {background-color: #' . esc_attr( $bg_color ) . ';}';

		return $extracolors;
	}
}

if ( ! function_exists( 'remove_dynamic_css' ) ) {
	add_action( 'init', 'remove_dynamic_css' );
	function remove_dynamic_css() {
		remove_action( 'wp_enqueue_scripts', 'enqueue_dynamic_css', 50 );
	}
}

if ( ! function_exists( 'enqueue_dynamic_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'enqueue_dynamic_css', 50 );
	function enqueue_dynamic_css() {
		$css = base_css() . font_css() . advanced_css() . spacing_css() . no_cache_dynamic_css() .extra_colors_css();

		// escaped secure before in parent theme
		wp_add_inline_style( 'lalita-child', $css );
	}
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
add_action( 'wp_head', 'customizer_css' );

function customize_preview_js() {
	wp_enqueue_script( 'customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
