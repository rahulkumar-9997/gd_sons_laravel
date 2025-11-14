<li class="right-side" id="cartItem">
    <div class="onhover-dropdown header-badge">
        <button type="button" class="btn p-0 position-relative header-wishlist js-cart-drawer-open">
            <i data-feather="shopping-cart"></i>
            <span class="position-absolute countCartDisplay top-0 start-100 translate-middle badge" data-count="{{ $cart_count }}"
                aria-label="{{ $cart_count }}">
                {{ $cart_count }}
            </span>
        </button>
    </div>
</li>