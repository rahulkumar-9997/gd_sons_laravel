<div class="right-side-summery-box">
    <div class="summery-box-2">
        <div class="summery-header">
            <h3>Order Summary</h3>
        </div>
        <div class="coupon-cart">
            <h6 class="text-content mb-2">Coupon Apply</h6>
            <div class="mb-3 coupon-box input-group apply-coupon-container">
                <input type="text" name="apply-coupon-input" class="form-control" id="apply-coupon-input" placeholder="Enter Coupon Code Here...">
                <button type="button" class="btn theme-bg-color text-white btn-md apply-coupon-btn">Apply</button>
            </div>   
            @if(session()->has('applied_coupon'))
                @php $appliedCoupon = session('applied_coupon'); @endphp
                <div class="alert alert-success alert-dismissible" id="applied-coupon-alert">
                    <strong>Coupon Applied:</strong> {{ $appliedCoupon['code'] }}
                    <button type="button" class="btn-close float-end" id="remove-coupon-btn" aria-label="Close"></button>
                </div>
            @endif
        </div>
        
        <ul class="summery-contain">
            @php
                $subtotal = 0;
                $sessionCart = session('cart', []);
                $cart_items_for_js = [];
            @endphp
            @foreach ($carts as $cart)
            @php
                $quantity = $sessionCart[$cart->id]['quantity'] ?? 1;
                $cart_items_for_js[] = [
                    'product_id' => $cart->id,
                    'qty' => $quantity,
                    'length' => (float) ($cart->length ?? 0),
                    'breadth' => (float) ($cart->breadth ?? 0),
                    'height' => (float) ($cart->height ?? 0),
                    'weight' => (float) ($cart->weight ?? 0),
                ];

                $purchase_rate = $cart->purchase_rate ?? 0;
                $offer_rate = $cart->offer_rate ?? 0;
                $mrp = $cart->mrp ?? 0;
                $group_offer_rate = null;
                $special_offer_rate = null;

                /* Group discount logic */
                if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
                    $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                    if ($group_percentage > 0) {
                        $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                        $group_offer_rate = floor($group_offer_rate);
                    }
                }

                /* Special offer */
                if (isset($specialOffers[$cart->product_id])) {
                    $special_offer_rate = (float) $specialOffers[$cart->product_id];
                }

                $final_offer_rate = collect([$offer_rate, $group_offer_rate, $special_offer_rate])->filter()->min();

                $totalPrice = $final_offer_rate * $quantity;
                $subtotal += $totalPrice;

                /* Discount percentage */
                $discountPercent = 0;
                if ($mrp && $final_offer_rate < $mrp) {
                    $discountPercent = (($mrp - $final_offer_rate)/$mrp) * 100;
                    $discountPercent = number_format($discountPercent, 2);
                }
            @endphp

            <input type="hidden" name="product_id[]" value="{{ $cart->id }}">
            <input type="hidden" name="cart_quantity[]" value="{{ $quantity }}">
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
                    </h4>
                </div>
                <div class="flex-detail">
                    <div class="price">
                        <h4>
                            Rs. {{ number_format($totalPrice, 2) }}
                            @if($discountPercent > 0)
                                <small class="text-success">({{ $discountPercent }}% off)</small>
                            @endif
                        </h4>
                        @if($mrp)
                            <span>M.R.P.</span>
                                <del class="text-content">Rs. {{ number_format($mrp, 2) }}</del>
                            </span>
                        @endif
                        
                    </div>
                </div>
            </li>
            @endforeach
            <input type="hidden" id="cart_items_json" value='@json($cart_items_for_js)'>
        </ul>
        <ul class="summery-total">
            <li>
                <h4>Subtotal</h4>
                <h4 class="price">Rs.
                    <span id="subtotal_amount">{{ number_format($subtotal, 2) }}</span>
                </h4>
            </li>
            <li id="shipping_section">
                <div class="courier-partner-title">
                    <h4>Shipping</h4>
                    <h4 class="price mt-2">
                        Rs. <span id="shipping_amount">{{ round($rate ?? 0) }}</span>
                    </h4>
                </div>
                <div class="courier-partner" id="courier_partner" style="display:none">
                    <div id="shipping_loader" class="checkout_loader_gif" style="display:none;"></div>
                    @if(!empty($couriers) && count($couriers) > 0 && ($paymentType ?? '') !== 'Pick Up From Store')
                        @foreach ($couriers as $index => $c)
                            @php $checked = $index === 0 ? 'checked' : ''; @endphp
                            <div class="form-check mt-2">
                                <input type="radio" 
                                    name="shipping_method" 
                                    class="form-check-input shipping_radio"
                                    value="{{ round($c['rate']) }}"
                                    data-courier-name="{{ $c['courier'] }}"
                                    data-rate="{{ round($c['rate']) }}"
                                    data-courier-company-id="{{ $c['courier_company_id'] ?? '' }}"
                                    data-cod-charges="{{ round($c['cod_charges']) ?? 0 }}"
                                    data-courier-id="{{ $c['id'] ?? '' }}"
                                    data-courier-delivery-expected-date="{{ \Carbon\Carbon::parse($c['etd'])->addDays(2)->format('M d, Y') }}"
                                    {{ $checked }}>
                                <label class="form-check-label">
                                    <strong>{{ $c['courier'] }}</strong>
                                    ({{ $c['service'] ?: 'Service' }}) — ₹{{ round($c['rate']) }}
                                </label>
                                <p><small class="text-muted">(ETD: {{ \Carbon\Carbon::parse($c['etd'])->addDays(2)->format('M d, Y') }})</small></p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </li>
            <li class="coupon-discount-row" style="{{ session()->has('applied_coupon') ? '' : 'display: none;' }}">
                <h4>Coupon Discount</h4>
                <h4 class="price text-success">- Rs.
                    <span id="coupon_discount_display">
                        {{ session()->has('applied_coupon') ? number_format(session('applied_coupon')['discount_amount'], 2) : '0.00' }}
                    </span>
                </h4>
            </li>

            <li class="list-total">
                <h4>Total (Rs.)</h4>
                <h4 class="price">Rs.
                    @php 
                        $shippingRate = round($rate ?? 0);
                        $discountAmount = session()->has('applied_coupon') ? session('applied_coupon')['discount_amount'] : 0;
                        $total = $subtotal + $shippingRate - $discountAmount;
                    @endphp
                    <span id="grand_total_amount_span">{{ number_format($total, 2) }}</span>
                    <input type="hidden" id="grand_total_amount_input" name="grand_total_amount" value="{{ $total }}">
                </h4>
            </li>
        </ul>
    </div>    
    {{-- Hidden Inputs --}}
    <input type="hidden" id="selected_courier_name" name="courier_name">
    <input type="hidden" id="selected_shipping_rate" name="shipping_rate">
    <input type="hidden" id="selected_courier_company_id" name="courier_company_id">
    <input type="hidden" id="selected_cod_charges" name="cod_charges">
    <input type="hidden" id="selected_courier_id" name="courier_id">
    <input type="hidden" id="selected_courier_delivery_expected_date" name="delivery_expected_date">
    <input type="hidden" id="applied_coupon_code" name="applied_coupon_code" value="{{ session()->has('applied_coupon') ? session('applied_coupon')['code'] : '' }}">
    <input type="hidden" id="coupon_discount_amount" name="coupon_discount_amount" value="{{ session()->has('applied_coupon') ? session('applied_coupon')['discount_amount'] : 0 }}">
    
    <button type="submit" class="btn theme-bg-color submit-checkout-btn text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
</div>