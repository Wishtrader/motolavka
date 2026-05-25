/**
 * Cookie consent banner — accept / decline with persistent storage.
 */
( function () {
	'use strict';

	var config = window.motorcycleShopCookies || {};
	var CONSENT_KEY = config.consentCookieName || 'motorcycle_shop_cookie_consent';
	var COOKIE_DAYS = config.cookieDays || 365;
	var STORAGE_KEY = 'motorcycle_shop_cookie_consent';

	function getCookie( name ) {
		var match = document.cookie.match(
			new RegExp( '(?:^|; )' + name.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' ) + '=([^;]*)' )
		);
		return match ? decodeURIComponent( match[1] ) : '';
	}

	function setCookie( name, value, days ) {
		var expires = '';
		if ( days ) {
			var date = new Date();
			date.setTime( date.getTime() + days * 24 * 60 * 60 * 1000 );
			expires = '; expires=' + date.toUTCString();
		}
		var secure = window.location.protocol === 'https:' ? '; Secure' : '';
		document.cookie =
			name +
			'=' +
			encodeURIComponent( value ) +
			expires +
			'; path=/' +
			secure +
			'; SameSite=Lax';
	}

	function getStoredConsent() {
		var cookie = getCookie( CONSENT_KEY );

		if ( cookie === 'accepted' || cookie === 'declined' ) {
			try {
				localStorage.setItem( STORAGE_KEY, cookie );
			} catch ( e ) {}
			return cookie;
		}

		// Cookie cleared in browser — drop stale localStorage so the banner can show again.
		try {
			localStorage.removeItem( STORAGE_KEY );
		} catch ( e ) {}

		return null;
	}

	function persistConsent( value, syncServer ) {
		try {
			localStorage.setItem( STORAGE_KEY, value );
		} catch ( e ) {}

		setCookie( CONSENT_KEY, value, COOKIE_DAYS );

		if ( syncServer ) {
			syncConsentWithServer( value );
		}
	}

	function syncConsentWithServer( value ) {
		var banner = document.querySelector( '[data-cookie-banner]' );
		if ( ! banner ) {
			return;
		}

		var ajaxUrl = banner.getAttribute( 'data-ajax-url' );
		var nonce = banner.getAttribute( 'data-ajax-nonce' );

		if ( ! ajaxUrl || ! nonce || typeof fetch !== 'function' ) {
			return;
		}

		var body = new FormData();
		body.append( 'action', 'motorcycle_shop_cookie_consent' );
		body.append( 'nonce', nonce );
		body.append( 'consent', value );

		fetch( ajaxUrl, {
			method: 'POST',
			body: body,
			credentials: 'same-origin',
		} ).catch( function () {} );
	}

	function hideBanner( banner ) {
		banner.classList.add( 'translate-y-full', 'pointer-events-none' );
		banner.setAttribute( 'aria-hidden', 'true' );
	}

	function applyConsent( value, syncServer, skipPersist ) {
		if ( ! skipPersist ) {
			persistConsent( value, syncServer );
		}

		document.documentElement.setAttribute( 'data-cookie-consent', value );
		document.documentElement.classList.toggle( 'cookie-consent-accepted', value === 'accepted' );
		document.documentElement.classList.toggle( 'cookie-consent-declined', value === 'declined' );

		window.dispatchEvent(
			new CustomEvent( 'motorcycleShopCookieConsent', {
				detail: { consent: value },
			} )
		);

		if ( value === 'accepted' ) {
			loadOptionalCookies();
		}
	}

	function loadOptionalCookies() {
		// Hook for analytics / marketing scripts when consent is granted.
		if ( window.motorcycleShopOnCookieAccept && typeof window.motorcycleShopOnCookieAccept === 'function' ) {
			window.motorcycleShopOnCookieAccept();
		}
	}

	function init() {
		var banner = document.querySelector( '[data-cookie-banner]' );
		if ( ! banner ) {
			return;
		}

		var existing = getStoredConsent();
		var initial = banner.getAttribute( 'data-initial-consent' );

		if ( ! existing && ( initial === 'accepted' || initial === 'declined' ) ) {
			existing = initial;
		}

		if ( existing ) {
			hideBanner( banner );
			applyConsent( existing, false, true );
			return;
		}

		var acceptBtn = banner.querySelector( '[data-cookie-accept]' );
		var declineBtn = banner.querySelector( '[data-cookie-decline]' );

		if ( acceptBtn ) {
			acceptBtn.addEventListener( 'click', function () {
				applyConsent( 'accepted', true );
				hideBanner( banner );
			} );
		}

		if ( declineBtn ) {
			declineBtn.addEventListener( 'click', function () {
				applyConsent( 'declined', true );
				hideBanner( banner );
			} );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
