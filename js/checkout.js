/**
 * Checkout delivery option cards and address fields toggle.
 */
( function ( $ ) {
	'use strict';

	function setActiveOption( $root, type ) {
		var activeCard =
			'border-[#FF6B00] bg-[#1F242B]';
		var inactiveCard =
			'border-transparent bg-[#1A1A1A] hover:border-[#434C58]';
		var activeRadio = 'border-[#FF6B00]';
		var inactiveRadio = 'border-[#434C58]';
		var activeDot = 'bg-[#FF6B00] scale-100';
		var inactiveDot = 'bg-transparent scale-0';
		var isDelivery = 'delivery' === type;

		$root.find( '[data-delivery-option]' ).each( function () {
			var $btn = $( this );
			var isActive = $btn.data( 'delivery-option' ) === type;

			$btn
				.attr( 'aria-checked', isActive ? 'true' : 'false' )
				.removeClass( activeCard + ' ' + inactiveCard )
				.addClass( isActive ? activeCard : inactiveCard );

			$btn.find( 'span.absolute' )
				.removeClass( activeRadio + ' ' + inactiveRadio )
				.addClass( isActive ? activeRadio : inactiveRadio );

			$btn.find( 'span.absolute span' )
				.removeClass( activeDot + ' ' + inactiveDot )
				.addClass( isActive ? activeDot : inactiveDot );
		} );

		$root.find( '[data-delivery-type-input]' ).val( type );
		toggleAddressFields( $root, isDelivery );
		syncShippingMethod( type );
	}

	function toggleAddressFields( $root, isDelivery ) {
		var $deliveryFields = $root.find( '[data-delivery-field]' );
		var $pickupFields = $root.find( '[data-pickup-address-fields]' );

		$deliveryFields.toggleClass( 'hidden', ! isDelivery );
		$deliveryFields.find( 'input, textarea, select' ).each( function () {
			$( this ).prop( 'disabled', ! isDelivery );
		} );

		$pickupFields.toggleClass( 'hidden', isDelivery );
		$pickupFields.find( 'input' ).each( function () {
			$( this ).prop( 'disabled', isDelivery );
		} );
	}

	function syncShippingMethod( type ) {
		var $methods = $( 'input[name^="shipping_method"]' );

		if ( ! $methods.length ) {
			return;
		}

		var $target = null;

		$methods.each( function () {
			var label = $( this ).closest( 'li' ).text().toLowerCase();

			if ( 'pickup' === type && ( label.indexOf( 'самовывоз' ) !== -1 || label.indexOf( 'local pickup' ) !== -1 ) ) {
				$target = $( this );
				return false;
			}

			if ( 'delivery' === type && label.indexOf( 'достав' ) !== -1 ) {
				$target = $( this );
				return false;
			}
		} );

		if ( ! $target ) {
			$target = 'pickup' === type ? $methods.first() : $methods.last();
		}

		if ( $target && ! $target.is( ':checked' ) ) {
			$target.prop( 'checked', true ).trigger( 'change' );
		}
	}

	$( document ).on( 'click', '[data-delivery-option]', function () {
		var type = $( this ).data( 'delivery-option' );
		setActiveOption( $( this ).closest( '[data-checkout-delivery]' ), type );
	} );

	function syncBillingLastName() {
		var $first = $( '#billing_first_name' );
		var $last = $( '#billing_last_name' );

		if ( $first.length && $last.length && $first.val() ) {
			$last.val( $first.val() );
		}
	}

	$( 'form.checkout' ).on( 'checkout_place_order checkout_place_order_ajax', function () {
		syncBillingLastName();
		return true;
	} );

	$( 'form.checkout' ).on( 'submit', function () {
		syncBillingLastName();
	} );

	$( document.body ).on( 'click', '#place_order', function () {
		syncBillingLastName();
	} );

	$( function () {
		var $root = $( '[data-checkout-delivery]' );

		if ( $root.length ) {
			var initial = $root.find( '[data-delivery-type-input]' ).val() || 'pickup';
			setActiveOption( $root, initial );
		}

		syncBillingLastName();
	} );
}( jQuery ) );
