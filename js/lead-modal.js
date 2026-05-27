/**
 * Lead request modal — open/close, validation and error reopen.
 * Also handles inline lead forms.
 */
( function () {
	'use strict';

	var modal = document.querySelector( '[data-lead-modal]' );

	if ( ! modal ) {
		return;
	}

	var form = modal.querySelector( '[data-lead-form]' );
	var privacyCheckbox = form ? form.querySelector( 'input[name="lead_privacy"]' ) : null;
	var nameInput = form ? form.querySelector( 'input[name="lead_name"]' ) : null;
	var phoneInput = form ? form.querySelector( 'input[name="lead_phone"]' ) : null;
	var submitButton = form ? form.querySelector( 'button[type="submit"]' ) : null;
	var privacyLabel = privacyCheckbox ? privacyCheckbox.closest( 'label' ) : null;
	var checkIcon = privacyLabel ? privacyLabel.querySelector( 'svg' ) : null;
	var initializedTriggers = [];
	var initializedCloseTriggers = [];

	// Validate phone number
	function validatePhone( phone ) {
		var digits = phone.replace( /\D+/g, '' );
		return digits.length >= 7;
	}

	// Update checkbox visual state
	function syncCheckboxVisual( checkbox, icon ) {
		if ( ! icon ) {
			return;
		}
		icon.style.opacity = checkbox.checked ? '1' : '0';
	}

	// Check form validity
	function isFormValid( formEl ) {
		var nameEl = formEl.querySelector( 'input[name="lead_name"]' );
		var phoneEl = formEl.querySelector( 'input[name="lead_phone"]' );
		var privacyEl = formEl.querySelector( 'input[name="lead_privacy"]' );
		
		var nameValid = nameEl && nameEl.value.trim().length >= 2;
		var phoneValid = phoneEl && validatePhone( phoneEl.value );
		var privacyValid = privacyEl && privacyEl.checked;
		return nameValid && phoneValid && privacyValid;
	}

	// Update button state for a form
	function updateButtonState( formEl ) {
		var submitBtn = formEl.querySelector( 'button[type="submit"]' );
		if ( ! submitBtn ) {
			return;
		}
		var valid = isFormValid( formEl );
		submitBtn.disabled = ! valid;
		submitBtn.classList.toggle( 'opacity-50', ! valid );
		submitBtn.classList.toggle( 'cursor-not-allowed', ! valid );
	}

	// Initialize form validation (for modal and inline forms)
	function initFormValidation( formEl ) {
		var nameEl = formEl.querySelector( 'input[name="lead_name"]' );
		var phoneEl = formEl.querySelector( 'input[name="lead_phone"]' );
		var privacyEl = formEl.querySelector( 'input[name="lead_privacy"]' );
		var privacyLabelEl = privacyEl ? privacyEl.closest( 'label' ) : null;
		var checkIconEl = privacyLabelEl ? privacyLabelEl.querySelector( 'svg' ) : null;
		var submitBtn = formEl.querySelector( 'button[type="submit"]' );

		// Checkbox visual sync
		if ( privacyEl && checkIconEl ) {
			syncCheckboxVisual( privacyEl, checkIconEl );
			privacyEl.addEventListener( 'change', function () {
				syncCheckboxVisual( privacyEl, checkIconEl );
				updateButtonState( formEl );
			} );
		}

		// Input validation
		if ( nameEl ) {
			nameEl.addEventListener( 'input', function () {
				updateButtonState( formEl );
			} );
		}

		if ( phoneEl ) {
			phoneEl.addEventListener( 'input', function () {
				updateButtonState( formEl );
			} );
		}

		// Form submission
		formEl.addEventListener( 'submit', function ( event ) {
			if ( ! isFormValid( formEl ) ) {
				event.preventDefault();
				return false;
			}

			if ( submitBtn ) {
				submitBtn.disabled = true;
				submitBtn.classList.add( 'opacity-50', 'cursor-not-allowed' );
				var originalText = submitBtn.textContent;
				submitBtn.textContent = 'Отправка...';
			}

			return true;
		} );

		// Initial button state
		updateButtonState( formEl );
	}

	function openModal() {
		modal.classList.remove( 'hidden' );
		modal.classList.add( 'flex' );
		modal.setAttribute( 'aria-hidden', 'false' );
		document.body.classList.add( 'overflow-hidden' );

		// Reset form when opening modal
		if ( form ) {
			var nameEl = form.querySelector( 'input[name="lead_name"]' );
			var phoneEl = form.querySelector( 'input[name="lead_phone"]' );
			var privacyEl = form.querySelector( 'input[name="lead_privacy"]' );
			
			if ( nameEl ) nameEl.value = '';
			if ( phoneEl ) phoneEl.value = '';
			if ( privacyEl ) privacyEl.checked = true;
			
			if ( checkIcon ) syncCheckboxVisual( privacyCheckbox, checkIcon );
			updateButtonState( form );
		}

		var firstInput = nameInput;

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

	function initOpenTriggers() {
		var openTriggers = document.querySelectorAll( '[data-lead-modal-open]' );

		openTriggers.forEach( function ( trigger ) {
			// Skip if already initialized
			if ( initializedTriggers.indexOf( trigger ) !== -1 ) {
				return;
			}

			trigger.addEventListener( 'click', function ( event ) {
				event.preventDefault();

				var sourceInput = form ? form.querySelector( 'input[name="lead_source"]' ) : null;
				var source = trigger.getAttribute( 'data-lead-source' ) || 'site';

				if ( sourceInput ) {
					sourceInput.value = source;
				}

				openModal();
			} );

			initializedTriggers.push( trigger );
		} );
	}

	function initCloseTriggers() {
		var closeTriggers = modal.querySelectorAll( '[data-lead-modal-close]' );

		closeTriggers.forEach( function ( trigger ) {
			// Skip if already initialized
			if ( initializedCloseTriggers.indexOf( trigger ) !== -1 ) {
				return;
			}

			trigger.addEventListener( 'click', function () {
				closeModal();
			} );

			initializedCloseTriggers.push( trigger );
		} );
	}

	function initModal() {
		initOpenTriggers();
		initCloseTriggers();
	}

	// Initialize on page load
	initModal();

	// Initialize modal form validation
	if ( form ) {
		initFormValidation( form );
	}

	// Initialize inline forms
	var inlineForms = document.querySelectorAll( '[data-lead-inline-form]' );
	inlineForms.forEach( function ( inlineForm ) {
		initFormValidation( inlineForm );
	} );

	// Re-initialize after WooCommerce AJAX updates
	document.addEventListener( 'wc_fragments_loaded', function () {
		initModal();
		var newInlineForms = document.querySelectorAll( '[data-lead-inline-form]' );
		newInlineForms.forEach( function ( inlineForm ) {
			initFormValidation( inlineForm );
		} );
	} );
	document.addEventListener( 'wc_fragments_refreshed', function () {
		initModal();
		var newInlineForms = document.querySelectorAll( '[data-lead-inline-form]' );
		newInlineForms.forEach( function ( inlineForm ) {
			initFormValidation( inlineForm );
		} );
	} );
	document.addEventListener( 'updated_wc_div', function () {
		initModal();
		var newInlineForms = document.querySelectorAll( '[data-lead-inline-form]' );
		newInlineForms.forEach( function ( inlineForm ) {
			initFormValidation( inlineForm );
		} );
	} );

	// Also use event delegation for dynamically added triggers
	document.addEventListener( 'click', function ( event ) {
		var trigger = event.target.closest( '[data-lead-modal-open]' );
		if ( ! trigger ) {
			return;
		}

		event.preventDefault();

		// Check if already handled by direct listener
		if ( initializedTriggers.indexOf( trigger ) !== -1 ) {
			return;
		}

		var sourceInput = form ? form.querySelector( 'input[name="lead_source"]' ) : null;
		var source = trigger.getAttribute( 'data-lead-source' ) || 'site';

		if ( sourceInput ) {
			sourceInput.value = source;
		}

		openModal();
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'Escape' && ! modal.classList.contains( 'hidden' ) ) {
			closeModal();
		}
	} );

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
