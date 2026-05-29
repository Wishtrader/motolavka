/**
 * Quantity +/- on single product page (gallery is inline in gallery.php).
 */
(function () {
	function initQuantityControls() {
		document.querySelectorAll('[data-qty-minus]').forEach(function (button) {
			button.addEventListener('click', function () {
				var input = button.parentElement.querySelector('[data-qty-input]');
				if (!input) {
					return;
				}
				var min = parseInt(input.getAttribute('min') || '1', 10);
				var next = Math.max(min, parseInt(input.value || '1', 10) - 1);
				input.value = String(next);
			});
		});

		document.querySelectorAll('[data-qty-plus]').forEach(function (button) {
			button.addEventListener('click', function () {
				var input = button.parentElement.querySelector('[data-qty-input]');
				if (!input) {
					return;
				}
				var maxAttr = input.getAttribute('max');
				var max = maxAttr && maxAttr !== '' ? parseInt(maxAttr, 10) : 9999;
				var next = Math.min(max, parseInt(input.value || '1', 10) + 1);
				input.value = String(next);
			});
		});
	}

	// Switch main gallery image when thumbnail is clicked
	window.motorcycleShopSwitchProductImage = function (button) {
		var gallery = button.closest('[data-product-gallery]');
		if (!gallery) {
			return false;
		}

		var mainImg = gallery.querySelector('[data-gallery-main]');
		if (!mainImg) {
			return false;
		}

		var fullUrl = button.getAttribute('data-full-url');
		if (!fullUrl) {
			return false;
		}

		// Update main image
		mainImg.src = fullUrl;

		// Update active state on thumbnails
		gallery.querySelectorAll('[data-gallery-thumb]').forEach(function (thumb) {
			var isActive = thumb === button;
			thumb.classList.toggle('is-active', isActive);
			thumb.setAttribute('aria-pressed', isActive ? 'true' : 'false');
			thumb.style.borderColor = isActive ? '#ff6b00' : 'transparent';
		});

		return false;
	};

	// Gallery carousel navigation
	function initGalleryCarousel() {
		document.querySelectorAll('[data-product-gallery]').forEach(function (gallery) {
			var track = gallery.querySelector('[data-gallery-track]');
			var viewport = gallery.querySelector('[data-gallery-viewport]');
			var prevBtn = gallery.querySelector('[data-gallery-prev]');
			var nextBtn = gallery.querySelector('[data-gallery-next]');

			if (!track || !viewport || !prevBtn || !nextBtn) {
				return;
			}

			var items = Array.from(track.querySelectorAll('[data-gallery-thumb]'));
			var currentIndex = 0;
			var visibleCount = window.innerWidth >= 768 ? 3 : 2;

			function getItemWidth() {
				var firstItem = items[0];
				if (!firstItem) return 0;
				var rect = firstItem.getBoundingClientRect();
				return rect.width + 12; // width + gap
			}

			function updateCarousel() {
				visibleCount = window.innerWidth >= 768 ? 3 : 2;
				var itemWidth = getItemWidth();
				var maxScroll = items.length - visibleCount;
				
				// Clamp current index
				if (currentIndex > maxScroll) {
					currentIndex = Math.max(0, maxScroll);
				}

				// Update button states
				prevBtn.disabled = currentIndex === 0;
				nextBtn.disabled = currentIndex >= maxScroll;

				// Calculate translate
				var translateX = -(currentIndex * itemWidth);
				track.style.transform = 'translateX(' + translateX + 'px)';
			}

			prevBtn.addEventListener('click', function () {
				if (currentIndex > 0) {
					currentIndex--;
					updateCarousel();
				}
			});

			nextBtn.addEventListener('click', function () {
				if (currentIndex < items.length - visibleCount) {
					currentIndex++;
					updateCarousel();
				}
			});

			// Recalculate on window resize
			window.addEventListener('resize', updateCarousel);

			// Initial setup
			updateCarousel();
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initQuantityControls();
			initGalleryCarousel();
		});
	} else {
		initQuantityControls();
		initGalleryCarousel();
	}
})();
