<?php
/**
 * Load necessary Customizer controls and functions.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Controls
//get_template_part( 'inc/customizer/controls/class', 'range-control' );
//get_template_part( 'inc/customizer/controls/class', 'typography-control' );

if ( ! function_exists( 'is_posts_page' ) ) {
	/**
	 * Check to see if we're on a posts page
	 *
	 */
	function is_posts_page() {
		return ( is_home() || is_archive() || is_tax() ) ? true : false;
	}
}

if ( ! function_exists( 'is_side_padding_active' ) ) {
	/**
	 * Check to see if we're using our footer bar widget
	 *
	 */
	function is_side_padding_active() {
		$settings = wp_parse_args(
			get_option( 'spacing_settings', array() ),
			__THEMENAE___spacing_get_defaults()
		);

		if ( ( $settings[ 'side_top' ] == 0 ) && ( $settings[ 'side_right' ] == 0 ) && ( $settings[ 'side_bottom' ] == 0 ) && ( $settings[ 'side_left' ] == 0 ) ) {
			return false;
		}
	}
}


if ( ! function_exists( 'is_footer_bar_active' ) ) {
	/**
	 * Check to see if we're using our footer bar widget
	 *
	 */
	function is_footer_bar_active() {
		return ( is_active_sidebar( 'footer-bar' ) ) ? true : false;
	}
}

if ( ! function_exists( 'is_top_bar_active' ) ) {
	/**
	 * Check to see if the top bar is active
	 *
	 */
	function is_top_bar_active() {
		$top_bar_sidebar = is_active_sidebar( 'top-bar' ) ? true : false;
		$top_bar_socials = get_setting( 'socials_display_top' );
		$top_bar = false;
		if ( ( $top_bar_sidebar == true ) || ( $top_bar_socials == true ) ) {
			$top_bar = true;
		}
		return apply_filters( 'is_top_bar_active', $top_bar );
	}
}

if ( ! function_exists( 'hidden_navigation' ) && function_exists( 'is_customize_preview' ) ) {
	add_action( 'wp_footer', 'hidden_navigation' );
	/**
	 * Adds a hidden navigation if no navigation is set
	 * This allows us to use postMessage to position the navigation when it doesn't exist
	 *
	 */
	function hidden_navigation() {
		if ( is_customize_preview() && function_exists( 'navigation_position' ) ) {
			?>
			<div style="display:none;">
				<?php __THEMENAE___navigation_position(); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'customize_partial_blogname' ) ) {
	/**
	 * Render the site title for the selective refresh partial.
	 *
	 */
	function customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

if ( ! function_exists( 'customize_partial_blogdescription' ) ) {
	/**
	 * Render the site tagline for the selective refresh partial.
	 *
	 */
	function customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}

if ( ! function_exists( 'enqueue_color_palettes' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'enqueue_color_palettes' );
	/**
	 * Add our custom color palettes to the color pickers in the Customizer.
	 *
	 */
	function enqueue_color_palettes() {
		// Old versions of WP don't get nice things
		if ( ! function_exists( 'wp_add_inline_script' ) )
			return;

		// Grab our palette array and turn it into JS
		$palettes = json_encode( get_default_color_palettes() );

		// Add our custom palettes
		// json_encode takes care of escaping
		wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $palettes . ';' );
	}
}

if ( ! function_exists( 'sanitize_integer' ) ) {
	/**
	 * Sanitize integers.
	 *
	 */
	function sanitize_integer( $input ) {
		return absint( $input );
	}
}

if ( ! function_exists( 'sanitize_decimal_integer' ) ) {
	/**
	 * Sanitize integers that can use decimals.
	 *
	 */
	function sanitize_decimal_integer( $input ) {
		return abs( floatval( $input ) );
	}
}

if ( ! function_exists( 'sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox values.
	 *
	 */
	function sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'sanitize_blog_excerpt' ) ) {
	/**
	 * Sanitize blog excerpt.
	 * Needed because __THEMENAE__ Premium calls the control ID which is different from the settings ID.
	 *
	 */
	function sanitize_blog_excerpt( $input ) {
	    $valid = array(
	        'full',
			'excerpt'
	    );

	    if ( in_array( $input, $valid ) ) {
	        return $input;
	    } else {
	        return 'full';
	    }
	}
}

if ( ! function_exists( 'sanitize_hex_color' ) ) {
	/**
	 * Sanitize colors.
	 * Allow blank value.
	 *
	 */
	function sanitize_hex_color( $color ) {
	    if ( '' === $color ) {
	        return '';
		}

	    // 3 or 6 hex digits, or the empty string.
	    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
	        return $color;
		}

	    return '';
	}
}

if ( ! function_exists( 'sanitize_choices' ) ) {
	/**
	 * Sanitize choices.
	 *
	 */
	function sanitize_choices( $input, $setting ) {
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

/**
 * Sanitize our Google Font variants
 *
 */
function sanitize_variants( $input ) {
	if ( is_array( $input ) ) {
		$input = implode( ',', $input );
	}
	return sanitize_text_field( $input );
}


/**
 * Add misc inline scripts to our controls.
 *
 * We don't want to add these to the controls themselves, as they will be repeated
 * each time the control is initialized.
 *
 */
function do_control_inline_scripts() {
	wp_localize_script( 'typography-customizer', 'customize', array( 'nonce' => wp_create_nonce( 'customize_nonce' ) ) );
	wp_localize_script( 'typography-customizer', 'typography_defaults', typography_default_fonts() );
}

/**
 * Check to see if we has_action( $tag, $function_to_check = false )ve a logo or not.
 *
 * Used as an active callback. Calling has_custom_logo creates a PHP notice for
 * multisite users.
 *.1
 */
function has_custom_logo_callback() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		return true;
	}
  return false;
}

function wp_enqueue_customizer_scripts() {
  wp_enqueue_script( 'customizer-live-preview', get_template_directory_uri() . '/inc/customizer/controls/js/customizer-live-preview.js' );
  wp_enqueue_script( 'slider-control', get_template_directory_uri() . '/inc/customizer/controls/js/slider-control.js' );
  wp_enqueue_script( 'typography-customizer', get_template_directory_uri() . '/inc/customizer/controls/js/typography-customizer.js' );
}
