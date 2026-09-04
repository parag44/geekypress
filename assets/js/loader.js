/**
 * Controls the optional terminal-style site loader.
 */
( function () {
	'use strict';

	const loader = document.getElementById( 'pt-site-loader' );

	if ( ! loader ) {
		return;
	}

	const configuredDuration = Number.parseInt( loader.dataset.duration || '3000', 10 );
	const duration = Number.isFinite( configuredDuration )
		? Math.min( 10000, Math.max( 1000, configuredDuration ) )
		: 3000;
	const logLines = loader.querySelectorAll( '.pt-loader-logs p' );
	const siteContent = document.querySelector( '.wp-site-blocks' );

	document.body.setAttribute( 'aria-busy', 'true' );

	if ( siteContent ) {
		siteContent.inert = true;
	}

	logLines.forEach( function ( line, index ) {
		window.setTimeout( function () {
			line.classList.add( 'is-visible' );
		}, Math.round( ( duration * index ) / 5 ) );
	} );

	window.setTimeout( function () {
		loader.classList.add( 'is-leaving' );
		document.body.classList.remove( 'pt-loader-active' );
		document.body.classList.add( 'pt-loader-complete' );
		document.body.removeAttribute( 'aria-busy' );

		if ( siteContent ) {
			siteContent.inert = false;
		}

		window.setTimeout( function () {
			loader.remove();
		}, 320 );
	}, duration );
}() );
