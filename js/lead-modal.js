/**
 * Lead request modal — open/close and error reopen.
 */
( function () {
	'use strict';

	var modal = document.querySelector( '[data-lead-modal]' );

	if ( ! modal ) {
		return;
	}

	var openTriggers = document.querySelectorAll( '[data-lead-modal-open]' );
	var closeTriggers = modal.querySelectorAll( '[data-lead-modal-close]' );
	var form = modal.querySelector( '[data-lead-form]' );
	var privacyCheckbox = form ? form.querySelector( 'input[name="lead_privacy"]' ) : null;

	function openModal() {
		modal.classList.remove( 'hidden' );
		modal.classList.add( 'flex' );
		modal.setAttribute( 'aria-hidden', 'false' );
		document.body.classList.add( 'overflow-hidden' );

		var firstInput = form ? form.querySelector( 'input[name="lead_name"]' ) : null;

		if ( firstInput ) {
			window.setTimeout( function () {
				firstInput.focus();
			}, 100 );
		}
	}

	function closeModal() {
		modal.classList.add( 'hidden' );
		modal.classList.remove( 'flex' );
		modal.setAttribute( 'aria-hidden', 'true' );
		document.body.classList.remove( 'overflow-hidden' );
	}

	openTriggers.forEach( function ( trigger ) {
		trigger.addEventListener( 'click', function ( event ) {
			event.preventDefault();

			var sourceInput = form ? form.querySelector( 'input[name="lead_source"]' ) : null;
			var source = trigger.getAttribute( 'data-lead-source' ) || 'site';

			if ( sourceInput ) {
				sourceInput.value = source;
			}

			openModal();
		} );
	} );

	closeTriggers.forEach( function ( trigger ) {
		trigger.addEventListener( 'click', function () {
			closeModal();
		} );
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'Escape' && ! modal.classList.contains( 'hidden' ) ) {
			closeModal();
		}
	} );

	if ( privacyCheckbox ) {
		var checkIcon = privacyCheckbox.parentElement
			? privacyCheckbox.parentElement.querySelector( 'svg' )
			: null;

		function syncCheckboxVisual() {
			if ( ! checkIcon ) {
				return;
			}

			checkIcon.style.opacity = privacyCheckbox.checked ? '1' : '0';
		}

		privacyCheckbox.addEventListener( 'change', syncCheckboxVisual );
		syncCheckboxVisual();
	}

	if ( modal.getAttribute( 'data-lead-open-on-load' ) === '1' ) {
		openModal();

		if ( window.history && window.history.replaceState ) {
			var url = new URL( window.location.href );
			url.searchParams.delete( 'lead_error' );
			window.history.replaceState( {}, '', url.pathname + url.search + url.hash );
		}
	}

	if ( window.location.hash === '#form' && window.location.search.indexOf( 'lead_inline=1' ) !== -1 ) {
		var formSection = document.getElementById( 'form' );

		if ( formSection ) {
			window.setTimeout( function () {
				formSection.scrollIntoView( { behavior: 'smooth', block: 'start' } );
			}, 100 );
		}
	}
} )();
