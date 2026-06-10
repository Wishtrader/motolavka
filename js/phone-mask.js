/**
 * Phone number mask via IMask for all phone inputs
 * (lead forms, contact form, WooCommerce checkout).
 */
( function () {
	'use strict';

	var MASK_OPTIONS = {
		mask: '+{375} (00) 000-00-00',
		lazy: true,
		placeholderChar: '_',
	};

	function getPhoneInputs() {
		return document.querySelectorAll(
			'input[name="lead_phone"], input[name="contact_phone"], #billing_phone'
		);
	}

	function initMasks() {
		var inputs = getPhoneInputs();

		inputs.forEach( function ( input ) {
			if ( input._imask ) {
				return;
			}

			input.removeAttribute( 'maxlength' );

			try {
				input._imask = IMask( input, MASK_OPTIONS );
			} catch ( e ) {
				// IMask not loaded yet
			}
		} );
	}

	initMasks();

	document.addEventListener( 'wc_fragments_loaded', initMasks );
	document.addEventListener( 'wc_fragments_refreshed', initMasks );
	document.addEventListener( 'updated_wc_div', initMasks );
	document.addEventListener( 'updated_checkout', initMasks );

	window._initPhoneMasks = initMasks;
} )();
