@php
	$subtotal = 0;
	$sessionCart = session('cart', []);
@endphp
<div class="drawer dr-cart js-drawer" id="drawer-cart-id" tabindex="-1" aria-hidden="false">
	<div class="drawer__overlay js-drawer__close" tabindex="-1"></div>
	<div class="drawer__content bg-light inner-glow shadow-md flex flex-column" role="dialog" aria-labelledby="drawer-cart-title" aria-modal="true">
		<header class="minicart-header border-bottom">
			<h1 id="drawer-cart-title" class="text-base text-truncate">
				Your Cart (<span class="cart-count">{{ $cart_count  ?? 0 }}</span>)
			</h1>
			<button class="drawer__close-btn js-drawer__close" aria-label="Close cart">
				<i class="fa-solid fa-xmark"></i>
			</button>
		</header>
		<div class="drawer__body minicart-content">
			
			@if($cart_count > 0)
				<ol class="cart-items">
				@foreach($cartItems as $item)
					@php
						$quantity = $sessionCart[$item->id]['quantity'] ?? 1;
						$attributes_value ='na';
						if($item->ProductAttributesValues->isNotEmpty()){
							$attributes_value = $item->ProductAttributesValues->first()->attributeValue->slug;
						}
						
					@endphp
					@php
						$purchase_rate = $item->purchase_rate;
						$offer_rate = $item->offer_rate;
						$mrp = $item->mrp;
						$group_offer_rate = null;
						$special_offer_rate = null;
						
						// Group offer logic
						if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
						$group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
						if ($group_percentage > 0 && $offer_rate !== null) {
						$group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
						$group_offer_rate = floor($group_offer_rate);
						}
						}

						if(!empty($specialOffers)){
							if (isset($specialOffers[$item->product_id])) {
								$special_offer_rate = (float) $specialOffers[$item->product_id];
							}
						}
						$final_offer_rate = collect([
							$offer_rate,
							$group_offer_rate,
							$special_offer_rate
						])->filter()->min();

						
						$totalPrice = $final_offer_rate * $quantity;
						$subtotal += $totalPrice;
					@endphp

					<li class="item d-flex justify-content-center align-items-center">
						<a class="product-image rounded-3" href="{{ url('products/'.$item->slug.'/'.$attributes_value) }}">
							@if($item->images->isNotEmpty())
							<img src="{{ asset('images/product/thumb/' . $item->images->first()->image_path) }}"
								class="blur-up lazyload"
								alt="{{ $item->name }}" loading="lazy" width="120" height="170">
							@else
							<img src="{{ asset('images/default.png') }}"
								class="blur-up lazyload"
								alt="Default Image" loading="lazy" width="120" height="170">
							@endif
						</a>
						<div class="product-details">
							<a class="product-title" href="{{ url('products/'.$item->slug.'/'.$attributes_value) }}">{{ucwords(strtolower($item->title))}}</a>
							<div class="priceRow">
								<div class="product-price">
									<span class="price">Rs. {{ number_format($final_offer_rate, 2) }}</span>
								</div>
								
							</div>
						</div>
						<div class="qtyDetail text-center">
							<div class="qtyField">
								<a class="qtyBtn minus"
									href="{{ route('cart.changeQuantity', ['id' => $item->id, 'quantity' => max(0, $quantity - 1)]) }}">
									<i class="fa fa-minus ms-0"></i>
								</a>

								<input type="text" name="quantity" value="{{ $quantity }}"
									class="qty" readonly>

								<a class="qtyBtn plus"
									href="{{ route('cart.changeQuantity', ['id' => $item->id, 'quantity' => $quantity + 1]) }}">
									<i class="fa fa-plus ms-0"></i>
								</a>
							</div>


							<a href="javascript:void(0);" class="remove cartDrawerRemove" data-action="remove" data-id="{{ $item->id }}">
								<i class="fa fa-trash ms-0" data-bs-toggle="tooltip"
									data-bs-placement="top" title="Remove" aria-label="Remove"></i>
							</a>
						</div>
					</li>
				@endforeach
			</ol>
			
			@else
				<div class="cart-empty-message">
					<p>Your cart is empty</p>
					<a href="{{URL::to('')}}" class="btn btn-animation proceed-btn fw-bold">Continue shopping</a>
				</div>
			@endif
		</div>
							
		@if($cart_count > 0)
			<footer class="cart-footer border-top border-contrast-lower minicart-bottom">
				<div class="subtotal clearfix">
					<div class="totalInfo clearfix">
						<span>Total: </span>
						<span class="product-price">Rs. {{ number_format($subtotal, 2) }}</span>
					</div>

					<div class="minicart-action d-flex mt-3">
						<a href="{{ route('checkout') }}" class="proceed-to-checkout btn btn-primary w-50 me-1">Check Out</a>
						<a href="{{ route('cart') }}" class="cart-btn btn btn-secondary w-50 ms-1">View Cart</a>
					</div>
				</div>
			</footer>
		@else

		@endif
		
	</div>
</div>