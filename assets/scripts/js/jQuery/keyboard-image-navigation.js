jQuery( document ).ready( function( $ ) {
	$( document ).keydown( function( e ) {
		var url = false;

		if ( e.which == 37 ) {  // Left arrow key code
			url = $( '.previous-image a' ).attr( 'href' );
			url = $( '.nav-previous a' ).attr( 'href' );
		}
		else if ( e.which == 39 ) {  // Right arrow key code
			url = $( '.entry-attachment a' ).attr( 'href' );
		}
		else if ( 39 === e.which ) {
		url = $( '.nav-next a' ).attr( 'href' );

	// Other key code.
	} else {
		return;
	}
		if ( url && ! $( 'textarea, input' ).is( ':focus' ) ) {
			window.location = url;
		}
	} );
} )( jQuery );
