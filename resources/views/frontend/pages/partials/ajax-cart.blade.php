@php
$subtotal = 0;
$discount = 0;
$shipping = 0;
$sessionCart = session('cart', []);
$columnClass = $carts->isEmpty() ? 'col-md-12 col-lg-12' : 'col-md-9 col-lg-9';
@endphp
<div class="{{ $columnClass }}">
    <div class="cart-table cart-wrapper">
        <div class="cart-container">
            @if($carts->isEmpty())
            <div class="alert alert-warning">
                Your cart is currently empty. Please add some products to your cart.
            </div>
            @else
            <div class="row g-3">
                @foreach($carts as $cart)
                @php
                $quantity = $sessionCart[$cart->id]['quantity'] ?? 1;
                $purchase_rate = $cart->purchase_rate ?? 0;
                $offer_rate = $cart->offer_rate ?? 0;
                $mrp = $cart->mrp ?? 0;

                $group_offer_rate = null;
                $special_offer_rate = null;

                // Group Offer Rate Calculation
                if ($groupCategory && $offer_rate !== null) {
                $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                if ($group_percentage > 0) {
                $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                $group_offer_rate = floor($group_offer_rate);
                }
                }

                // Special Offer Rate (if available)
                if (isset($specialOffers[$cart->product_id])) {
                $special_offer_rate = (float) $specialOffers[$cart->product_id];
                }

                // Final offer rate — take minimum from all available
                $final_offer_rate = collect([
                $offer_rate,
                $group_offer_rate,
                $special_offer_rate
                ])->filter()->min();

                // Calculate discount and total
                $product_discount_rate = $mrp - $final_offer_rate;
                $totalPrice = $final_offer_rate * $quantity;
                $subtotal += $totalPrice;

                // Optional: Discount total
                // $discount += $product_discount_rate * $quantity;
                $attributes_value ='na';
                if($cart->ProductAttributesValues->isNotEmpty()){
                $attributes_value = $cart->ProductAttributesValues->first()->attributeValue->slug;
                }
                @endphp

                <div class="col-12">
                    <div class="cart-item card p-3 product-box-contain">
                        <div class="row g-2 align-items-center">
                            <!-- Product Image -->
                            <div class="col-12 col-md-2">
                                <div class="cart-img">
                                    <a href="{{ url('products/'.$cart->slug.'/'.$attributes_value) }}" class="product-image">
                                        @if($cart->images->isNotEmpty())
                                        <img src="{{ asset('images/product/thumb/' . $cart->images->first()->image_path) }}"
                                            class="img-fluid rounded blur-up lazyload" alt="{{ ucwords(strtolower($cart->title)) }}" loading="lazy">
                                        @else
                                        <img src="{{ asset('images/default.png') }}"
                                            class="img-fluid rounded blur-up lazyload" alt="{{ ucwords(strtolower($cart->title)) }}" loading="lazy">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <!-- Product Details -->
                            <div class="col-9 col-md-6">
                                <div class="product-details">
                                    <h5 class="product-title mb-1">
                                        <a href="{{ url('products/'.$cart->slug.'/'.$attributes_value) }}">{{ ucwords(strtolower($cart->title)) }}</a>
                                    </h5>

                                    <div class="price-container mb-2">
                                        @if($cart->offer_rate)
                                        <div class="current-price">
                                            Rs. {{ number_format($final_offer_rate, 2) }}
                                            @if($cart->mrp)
                                            <del class="text-muted small ms-1">
                                                Rs. {{ number_format($cart->mrp, 2) }}</del>
                                            @endif
                                        </div>
                                        @else
                                        <div class="current-price">Rs. 0.00</div>
                                        @endif

                                        <div class="text-success small">
                                            You Save: Rs. {{ number_format($product_discount_rate, 2) }}/Item
                                        </div>
                                    </div>

                                    <!-- Quantity Controls - Mobile Only -->
                                    <div class="d-md-none">
                                        <div class="quantity-price">
                                            <div class="cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus-cart" data-type="minus" data-id="{{ $cart->id }}"
                                                        data-url="{{ route('cart', ['cart_id' => $cart->id]) }}">
                                                        <i class="fa fa-minus ms-0"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text" name="quantity" value="{{ $quantity }}" data-id="{{ $cart->id }}">
                                                    <button type="button" class="btn qty-right-plus-cart" data-type="plus" data-id="{{ $cart->id }}"
                                                        data-url="{{ route('cart', ['cart_id' => $cart->id]) }}">
                                                        <i class="fa fa-plus ms-0"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Quantity Controls - Desktop -->
                            <div class="col-2 d-none d-md-block">
                                <div class="quantity-controls-desktop quantity-price">
                                    <div class="cart_qty">
                                        <div class="input-group">
                                            <button type="button" class="btn qty-left-minus-cart" data-type="minus" data-id="{{ $cart->id }}"
                                                data-url="{{ route('cart', ['cart_id' => $cart->id]) }}">
                                                <i class="fa fa-minus ms-0"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text" name="quantity" value="{{ $quantity }}" data-id="{{ $cart->id }}">
                                            <button type="button" class="btn qty-right-plus-cart" data-type="plus" data-id="{{ $cart->id }}"
                                                data-url="{{ route('cart', ['cart_id' => $cart->id]) }}">
                                                <i class="fa fa-plus ms-0"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Remove Button -->
                            <div class="col-3 col-md-2 text-end">
                                <a class="btn btn-sm btn-outline-danger remove-cart"
                                    data-productid="{{ $cart->id }}"
                                    data-url="{{ route('cart.remove', ['productId' => $cart->id]) }}" href="javascript:void(0)">
                                    <i class="fa fa-trash me-1 d-none d-md-inline"></i> Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="continue-shopping-btn">
        <a href="{{ url('/') }}" class="cntshop">
            <i class="fa fa-caret-left"></i>Continue Shopping
        </a>
    </div>
</div>
<div class="col-md-3 col-lg-3">
    <div class="summery-box p-sticky">
        @if($carts->isNotEmpty())
        <div class="summery-header">
            <h3>Cart Total</h3>
        </div>

        <div class="summery-contain">
            <!--<div class="coupon-cart">
                    <h6 class="text-content mb-2">Coupon Apply</h6>
                    <div class="mb-3 coupon-box input-group">
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter Coupon Code Here...">
                        <button class="btn-apply">Apply</button>
                    </div>
                </div>-->
            <ul>
                <li>
                    <h4>Subtotal</h4>
                    <h4 class="price">Rs. {{ number_format($subtotal, 2) }}</h4>
                </li>

                <!--<li>
                        <h4>Coupon Discount</h4>
                        <h4 class="price">(-) Rs. 0.00</h4>
                    </li>-->

                <li class="align-items-start">
                    <h4>Delivery Charges </h4>
                    <h4 class="price text-end">Rs. 0.00 (Free)</h4>
                </li>
            </ul>
        </div>

        <ul class="summery-total">
            <li class="list-total border-top-0">
                <h4>Total (Rs.)</h4>
                <h4 class="price theme-color">Rs. {{ number_format($subtotal + $shipping, 2) }}</h4>
            </li>
        </ul>

        <div class="button-group cart-button">
            <ul>
                <li>
                    <button onclick="location.href = '{{ route('checkout') }}';"
                        class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button>
                    <!-- <button id="rzp-button1" class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button> -->
                </li>

                <!--<li>
                        <button onclick="location.href = '{{ url('/') }}';"
                            class="btn btn-light shopping-button text-dark">
                            <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                    </li>-->
            </ul>
        </div>
        @endif
    </div>
</div>