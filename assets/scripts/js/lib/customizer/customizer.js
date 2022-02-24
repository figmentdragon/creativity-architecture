/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
  "use strict";
  api = wp.customize;

	// Site title and description.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
		} );
	} );
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color without header media background.
	api( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.absolute-header .site-title a, a h1.site-title, h1.site-title a, .absolute-header h2.site-description, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative',
					'color' : to
				} );
			}
		} );
	} );

  // Handle changes to the background-color.
  api( 'background_color', function( setting ) {
    setting.bind( function( value ) {
      if ( 127 > twentytwentyoneGetHexLum( value ) ) {
        wp.customize.control( 'respect_user_color_preference' ).deactivate();
        wp.customize.control( 'respect_user_color_preference_notice' ).activate();
      } else {
        wp.customize.control( 'respect_user_color_preference' ).activate();
        wp.customize.control( 'respect_user_color_preference_notice' ).deactivate();
      }
    } );
  } );

  api( 'carousel_title', function( value ) {
		value.bind( function( to ) {
			$( '.carousel-title' ).text( to );
		} );
	} );
  api( 'featured_title', function( value ) {
		value.bind( function( to ) {
			$( '.featured-title' ).text( to );
		} );
	} );
} )( jQuery );
