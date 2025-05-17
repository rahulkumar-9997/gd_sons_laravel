<div class="col-md-9 col-lg-9">
    <div class="cart-table cart-wrapper">
        <div class="table-responsive-xl">
            @php
            $subtotal = 0;
            $discount = 0;
            $shipping = 0;
            @endphp
            @if($carts->isEmpty())
                <div class="alert alert-warning">
                    Your cart is currently empty. Please add some products to your cart.
                </div>
            @else
                <table class="table" id="shopping-cart-table">
                    <tbody>
                        @foreach($carts as $cart)
                        @php
                            $purchase_rate = $cart->product->purchase_rate ?? 0;
                            $offer_rate = $cart->product->offer_rate ?? 0;
                            $mrp = $cart->product->mrp ?? 0;

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
                            $totalPrice = $final_offer_rate * $cart->quantity;
                            $subtotal += $totalPrice;

                            // Optional: Discount total
                            // $discount += $product_discount_rate * $cart->quantity;
                            $attributes_value ='na';
                            if($cart->product->ProductAttributesValues->isNotEmpty()){
                            $attributes_value = $cart->product->ProductAttributesValues->first()->attributeValue->slug;
                        }
                        @endphp
                        
                        <tr class="product-box-contain">
                            <td class="product-image">
                                <div class="product border-0">
                                    <a href="{{ url('products/'.$cart->product->slug.'/'.$attributes_value) }}" class="product-image">
                                        @if($cart->product->images->isNotEmpty())
                                        <img src="{{ asset('images/product/thumb/' . $cart->product->images->first()->image_path) }}"
                                            class="img-fluid blur-up lazyload" alt="{{ ucwords(strtolower($cart->product->title)) }}" loading="lazy">
                                        @else
                                        <img src="{{ asset('images/default.png') }}"
                                            class="img-fluid blur-up lazyload" alt="{{ ucwords(strtolower($cart->product->title)) }}" loading="lazy">
                                        @endif
                                    </a>
                                </div>
                            </td>
                            <td class="product-detail">
                                <div class="product border-0">
                                    <div class="product-detail">
                                        <ul>
                                            <li class="name">
                                                <a href="{{ url('products/'.$cart->product->slug.'/'.$attributes_value) }}">{{ ucwords(strtolower($cart->product->title)) }}</a>
                                            </li>
                                            <li class="text-content">
                                                @if($cart->product->offer_rate)
                                                <h5>
                                                    Rs. {{ number_format($final_offer_rate, 2) }}
                                                    @if($cart->product->mrp)
                                                        <del class="text-content">
                                                        Rs. {{ number_format($cart->product->mrp, 2) }}</del>
                                                    @endif
                                                </h5>
                                                @else
                                                    <h5>Rs. 0.00</h5>
                                                @endif

                                                
                                                <h6 class="theme-color">You Save: Rs. {{ number_format($product_discount_rate, 2) }}/Item</h6>
                                                
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="quantity">
                                <h4 class="table-title text-content">Qty</h4>
                                <div class="quantity-price">
                                    <div class="cart_qty">
                                        <div class="input-group">
                                            <button type="button" class="btn qty-left-minus-cart" data-type="minus" data-id="{{ $cart->id }}"
                                            data-url="{{ route('cart', ['cart_id' => $cart->id]) }}">
                                                <i class="fa fa-minus ms-0"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text" name="quantity" value="{{ $cart->quantity }}" data-id="{{ $cart->id }}">
                                            <button type="button" class="btn qty-right-plus-cart" data-type="plus" data-id="{{ $cart->id }}"
                                            data-url="{{ route('cart', ['cart_id' => $cart->id]) }}">
                                                <i class="fa fa-plus ms-0"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="save-remove product-action d-block-mobile">
                                    <a class="remove close_button remove-cart" data-cart-id="{{ $cart->id }}" data-url="{{ route('cart.remove', ['cart_id' => $cart->id]) }}" href="javascript:void(0)">Remove</a>
                                </div>
                            </td>
                            <td class="save-remove product-action d-none-mobile">
                                <h4 class="table-title text-content">Action</h4>
                                <a class="remove close_button remove-cart" data-cart-id="{{ $cart->id }}" data-url="{{ route('cart.remove', ['cart_id' => $cart->id]) }}" href="javascript:void(0)">Remove</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
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
    </div>
</div>