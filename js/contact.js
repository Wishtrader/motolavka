/**
 * Contact form validation and submission handling.
 */
( function () {
	'use strict';

	var form = document.querySelector( '[data-contact-form]' );

	if ( ! form ) {
		return;
	}

	var nameInput = form.querySelector( '.contact-name' );
	var phoneInput = form.querySelector( '.contact-phone' );
	var privacyCheckbox = form.querySelector( '.contact-privacy' );
	var submitButton = form.querySelector( '.contact-submit' );
	var privacyLabel = privacyCheckbox ? privacyCheckbox.closest( 'label' ) : null;
	var checkIcon = privacyLabel ? privacyLabel.querySelector( 'svg' ) : null;
	var resetButton = document.getElementById( 'contact-form-reset' );

	// Validate phone number
	function validatePhone( phone ) {
		var digits = phone.replace( /\D+/g, '' );
		return digits.length >= 7;
	}

	// Update checkbox visual state
	function syncCheckboxVisual() {
		if ( ! checkIcon ) {
			return;
		}
		checkIcon.style.opacity = privacyCheckbox.checked ? '1' : '0';
	}

	// Check form validity
	function isFormValid() {
		var nameValid = nameInput && nameInput.value.trim().length >= 2;
		var phoneValid = phoneInput && validatePhone( phoneInput.value );
		var privacyValid = privacyCheckbox && privacyCheckbox.checked;
		return nameValid && phoneValid && privacyValid;
	}

	// Update button state
	function updateButtonState() {
		if ( ! submitButton ) {
			return;
		}
		var valid = isFormValid();
		submitButton.disabled = ! valid;
	}

	// Event listeners for inputs
	if ( nameInput ) {
		nameInput.addEventListener( 'input', updateButtonState );
	}

	if ( phoneInput ) {
		phoneInput.addEventListener( 'input', updateButtonState );
	}

	if ( privacyCheckbox ) {
		privacyCheckbox.addEventListener( 'change', function () {
			syncCheckboxVisual();
			updateButtonState();
		} );
		syncCheckboxVisual();
	}

	// Form submission
	form.addEventListener( 'submit', function ( event ) {
		event.preventDefault();

		if ( ! isFormValid() ) {
			return;
		}

		if ( submitButton ) {
			submitButton.disabled = true;
			submitButton.textContent = 'Отправка...';
		}

		// Submit the form
		form.submit();
	} );

	// Reset button - reload page without success param
	if ( resetButton ) {
		resetButton.addEventListener( 'click', function () {
			// Reload page without the contact_sent parameter
			var url = new URL( window.location.href );
			url.searchParams.delete( 'contact_sent' );
			window.location.href = url.toString();
		} );
	}

	// Initial button state
	updateButtonState();
} )();
