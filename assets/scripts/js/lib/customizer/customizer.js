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
      if ( 127 > GetHexLum( value ) ) {
        api.control( 'respect_user_color_preference' ).deactivate();
        api.control( 'respect_user_color_preference_notice' ).activate();
      } else {
        api.control( 'respect_user_color_preference' ).activate();
        api.control( 'respect_user_color_preference_notice' ).deactivate();
      }
    } );
  } );
  api( 'background_color', function( value ) {
    value.bind( function( to ) {
      var lum = GetHexLum( to ),
        isDark = 127 > lum,
        textColor = ! isDark ? 'var(--global--color-dark-gray)' : 'var(--global--color-light-gray)',
        tableColor = ! isDark ? 'var(--global--color-light-gray)' : 'var(--global--color-dark-gray)',
        stylesheetID = 'customizer-inline-styles',
        stylesheet,
        styles;

        // Modify the html & body classes depending on whether this is a dark background or not.
      if ( isDark ) {
        document.body.classList.add( 'is-dark-theme' );
        document.documentElement.classList.add( 'is-dark-theme' );
        document.body.classList.remove( 'is-light-theme' );
        document.documentElement.classList.remove( 'is-light-theme' );
        document.documentElement.classList.remove( 'respect-color-scheme-preference' );
      } else {
        document.body.classList.remove( 'is-dark-theme' );
        document.documentElement.classList.remove( 'is-dark-theme' );
        document.body.classList.add( 'is-light-theme' );
        document.documentElement.classList.add( 'is-light-theme' );
        if ( ap( 'respect_user_color_preference' ).get() ) {
          document.documentElement.classList.add( 'respect-color-scheme-preference' );
        }
      }

      // Toggle the white background class.
      if ( 225 <= lum ) {
        document.body.classList.add( 'has-background-white' );
      } else {
        document.body.classList.remove( 'has-background-white' );
      }

      stylesheet = jQuery( '#' + stylesheetID );
      styles = '';
      // If the stylesheet doesn't exist, create it and append it to <head>.
      if ( ! stylesheet.length ) {
        jQuery( '#themename-style-inline-css' ).after( '<style id="' + stylesheetID + '"></style>' );
        stylesheet = jQuery( '#' + stylesheetID );
      }

      // Generate the styles.
      styles += '--global--color-primary:' + textColor + ';';
      styles += '--global--color-secondary:' + textColor + ';';
      styles += '--global--color-background:' + to + ';';

      styles += '--button--color-background:' + textColor + ';';
      styles += '--button--color-text:' + to + ';';
      styles += '--button--color-text-hover:' + textColor + ';';

      styles += '--table--stripes-border-color:' + tableColor + ';';
      styles += '--table--stripes-background-color:' + tableColor + ';';

      // Add the styles.
      stylesheet.html( ':root{' + styles + '}' );
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
