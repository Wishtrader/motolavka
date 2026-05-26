/* global jQuery, motorcycleShopCart */
(function ($) {
  'use strict';

  function refreshCartFragments() {
    $(document.body).trigger('wc_fragment_refresh');
  }

  function updateCartCountBadges(count) {
    document.querySelectorAll('[data-cart-count]').forEach(function (badge) {
      badge.textContent = String(count);
      if (count < 1) {
        badge.classList.add('hidden');
      } else {
        badge.classList.remove('hidden');
      }
    });
  }

  function parseCartPage(html) {
    var parser = new DOMParser();
    var doc = parser.parseFromString(html, 'text/html');
    var root = doc.querySelector('[data-cart-page-root]');
    return root ? root.innerHTML : '';
  }

  function setCartLoading(isLoading) {
    var root = document.querySelector('[data-cart-page-root]');
    if (!root) {
      return;
    }
    root.classList.toggle('opacity-60', isLoading);
    root.classList.toggle('pointer-events-none', isLoading);
  }

  function postCartForm(extraData) {
    var form = document.querySelector('form.motorcycle-shop-cart-form');
    if (!form || !motorcycleShopCart) {
      return Promise.reject();
    }

    var formData = new FormData(form);
    formData.append('update_cart', '1');

    if (extraData) {
      Object.keys(extraData).forEach(function (key) {
        formData.append(key, extraData[key]);
      });
    }

    setCartLoading(true);

    return fetch(motorcycleShopCart.cartUrl, {
      method: 'POST',
      body: formData,
      credentials: 'same-origin',
    })
      .then(function (response) {
        return response.text();
      })
      .then(function (html) {
        var inner = parseCartPage(html);
        var root = document.querySelector('[data-cart-page-root]');
        if (root && inner) {
          root.innerHTML = inner;
          bindCartPageEvents();
          refreshCartFragments();
          setCartLoading(false);
          return;
        }
        if (!inner) {
          window.location.reload();
          return;
        }
        refreshCartFragments();
        setCartLoading(false);
      })
      .catch(function () {
        setCartLoading(false);
        window.alert(motorcycleShopCart.i18n.error);
      });
  }

  function removeCartItem(cartItemKey) {
    if (!motorcycleShopCart || !cartItemKey) {
      return;
    }

    setCartLoading(true);

    var url = motorcycleShopCart.wcAjaxUrl.replace('%%endpoint%%', 'remove_from_cart');

    $.ajax({
      type: 'POST',
      url: url,
      data: {
        cart_item_key: cartItemKey,
      },
      success: function () {
        if (motorcycleShopCart.isCartPage) {
          return postCartForm();
        }
        refreshCartFragments();
        setCartLoading(false);
      },
      error: function () {
        setCartLoading(false);
        window.location.href = motorcycleShopCart.cartUrl;
      },
    });
  }

  function scheduleCartUpdate() {
    if (!motorcycleShopCart || !motorcycleShopCart.isCartPage) {
      return;
    }
    clearTimeout(window.motorcycleShopCartUpdateTimer);
    window.motorcycleShopCartUpdateTimer = setTimeout(function () {
      postCartForm();
    }, 400);
  }

  function bindCartPageEvents() {
    var root = document.querySelector('[data-cart-page-root]');
    if (!root) {
      return;
    }

    root.querySelectorAll('[data-cart-qty-minus]').forEach(function (button) {
      button.onclick = function () {
        var input = button.parentElement.querySelector('[data-cart-qty-input]');
        if (!input) {
          return;
        }
        var min = parseInt(input.getAttribute('min') || '1', 10);
        input.value = String(Math.max(min, parseInt(input.value || '1', 10) - 1));
        scheduleCartUpdate();
      };
    });

    root.querySelectorAll('[data-cart-qty-plus]').forEach(function (button) {
      button.onclick = function () {
        var input = button.parentElement.querySelector('[data-cart-qty-input]');
        if (!input) {
          return;
        }
        var maxAttr = input.getAttribute('max');
        var max = maxAttr && maxAttr !== '' ? parseInt(maxAttr, 10) : 9999;
        input.value = String(Math.min(max, parseInt(input.value || '1', 10) + 1));
        scheduleCartUpdate();
      };
    });

    root.querySelectorAll('[data-cart-qty-input]').forEach(function (input) {
      input.onchange = scheduleCartUpdate;
    });

    root.querySelectorAll('[data-cart-remove]').forEach(function (button) {
      button.onclick = function (event) {
        event.preventDefault();
        removeCartItem(button.getAttribute('data-cart-item-key'));
      };
    });
  }

  function removeViewCartLink() {
    $('form.cart .added_to_cart').remove();
  }

  function syncAddToCartQuantity($button) {
    var $form = $button.closest('form.cart');
    var qty = $form.find('[data-qty-input]').val() || 1;
    $button.attr('data-quantity', qty);
  }

  $(document.body).on('added_to_cart', function (event, fragments) {
    if (fragments) {
      $.each(fragments, function (key, value) {
        $(key).replaceWith(value);
      });
    }
    refreshCartFragments();
    removeViewCartLink();
    window.setTimeout(removeViewCartLink, 0);
  });

  $(document.body).on('wc_cart_button_updated', function (event, $button) {
    if ($button && $button.length) {
      $button.siblings('.added_to_cart').remove();
    }
    removeViewCartLink();
  });

  $(document.body).on('wc_fragments_refreshed wc_fragments_loaded', function () {
    var first = document.querySelector('[data-cart-count]');
    if (first) {
      var count = parseInt(first.textContent, 10) || 0;
      updateCartCountBadges(count);
    }
  });

  $(function () {
    bindCartPageEvents();

    $('form.cart').on('click', '.single_add_to_cart_button', function () {
      syncAddToCartQuantity($(this));
    });
  });
})(jQuery);
