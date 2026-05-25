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

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initQuantityControls);
	} else {
		initQuantityControls();
	}
})();
