( function( $ ) {
	'use strict';

	$( document ).ready( function() {
		// Use 4 spaces as tab-size
		$( '#content' ).css( {
				'-webkit-tab-size': '4',
				'-moz-tab-size':    '4',
				'-o-tab-size':      '4',
				'tab-size':         '4'
		} );

		// Init tabOverride
		$( '#content' ).tabOverride();

		// Enable auto indentation for tabOverride
		$.fn.tabOverride.autoIndent( true );
	});
} )( jQuery );
