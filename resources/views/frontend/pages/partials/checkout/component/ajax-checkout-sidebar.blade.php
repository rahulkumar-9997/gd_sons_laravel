<div class="right-side-summery-box">
    <div class="summery-box-2">
        <div class="summery-header">
            <h3>Order Summary</h3>
        </div>
        <ul class="summery-contain">
            @php
                $subtotal = 0;
                $sessionCart = session('cart', []);
            @endphp
            @foreach ($carts as $cart)
            @php
                $quantity = $sessionCart[$cart->id]['quantity'] ?? 1;
                $purchase_rate = $cart->purchase_rate ?? 0;
                $offer_rate = $cart->offer_rate ?? 0;
                $mrp = $cart->mrp ?? 0;
                $group_offer_rate = null;
                $special_offer_rate = null;
                /*Group discount calculation*/
                if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
                    $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                    if ($group_percentage > 0) {
                        $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                        $group_offer_rate = floor($group_offer_rate);
                    }
                }
                /*Special offer logic (make sure $specialOffers is available)*/
                if (isset($specialOffers[$cart->product_id])) {
                    $special_offer_rate = (float) $specialOffers[$cart->product_id];
                }
                $final_offer_rate = collect([
                    $offer_rate,
                    $group_offer_rate,
                    $special_offer_rate
                ])->filter()->min();
                /*Total calculation*/
                $totalPrice = $final_offer_rate * $quantity;
                $subtotal += $totalPrice;
            @endphp
            <input type="hidden" name="product_id[]" value="{{ $cart->id }}">
            <input type="hidden" name="cart_quantity[]" value="{{  $quantity }}">
            <input type="hidden" name="cart_offer_rate[]" value="{{ $final_offer_rate }}">
            <input type="hidden" name="total_price[]" value="{{ $totalPrice }}">
            <li>
                <div class="flex-detail">
                    <div class="cart-det-img">
                        @if ($cart->images->first())
                        <img src="{{ asset('images/product/thumb/' . $cart->images->first()->image_path) }}"
                            class="img-fluid blur-up lazyloaded checkout-image" alt="{{ $cart->name }}" loading="lazy">
                        @else
                        <img src="{{ asset('images/default.png') }}" class="img-fluid blur-up lazyloaded checkout-image" alt="Default Image" loading="lazy">
                        @endif
                    </div>
                    <h4>
                        {{ ucwords(strtolower($cart->title)) }}
                        <p>
                            <span>{{$final_offer_rate}} X {{ $quantity }}</span>
                        </p>
                    </h4>
                </div>
                <div class="flex-detail">
                    <h4 class="price">
                        Rs.
                        {{ number_format($totalPrice, 2) }}
                    </h4>
                </div>
            </li>
            @endforeach
        </ul>
        <ul class="summery-total">
            <li>
                <h4>Subtotal</h4>
                <h4 class="price">Rs.
                    {{ number_format($subtotal, 2) }}
                </h4>
            </li>
            <li>
                <h4>Shipping</h4>
                <h4 class="price">Free shipping</h4>
            </li>
            <!-- <li>
                <h4>Tax</h4>
                <h4 class="price">Rs. 0</h4>
            </li>

            <li>
                <h4>Coupon/Code</h4>
                <h4 class="price">Rs. 0</h4>
            </li> -->
            <li class="list-total">
                <h4>Total (Rs.)</h4>
                <h4 class="price">Rs.
                    @php
                    $total = $subtotal;
                    @endphp
                    {{ number_format($total, 2) }}
                    <input type="hidden" name="grand_total_amount" value="{{$total}}">
                </h4>
            </li>
        </ul>
    </div>
    <!--<div class="checkout-offer">
        <div class="offer-title">
            <div class="offer-icon">
                <img src="{{ asset('images/offer.svg') }}" class="img-fluid" alt="">
            </div>
            <div class="offer-name">
                <h6>Available Offers</h6>
            </div>
        </div>
        <ul class="offer-detail">
            <li>
                <p>Combo: BB Royal Almond/Badam Californian, Extra Bold 100 gm...</p>
            </li>
            <li>
                <p>combo: Royal Cashew Californian, Extra Bold 100 gm + BB Royal Honey 500 gm</p>
            </li>
        </ul>
    </div>-->
    <button type="submit" class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
</div>