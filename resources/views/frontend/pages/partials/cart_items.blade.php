<div class="onhover-dropdown header-badge">
    <button type="button" class="btn p-0 position-relative header-wishlist">
        <i data-feather="shopping-cart"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge">
            {{ $cartCount }}
        </span>
    </button>
    <div class="onhover-div" id="cart-items">
        @php 
        $subtotal = 0;
        @endphp
        @if(!$isCartEmpty)
            <ul class="cart-list">
                @foreach($cartItems as $item)
                @php
                $attributes_value ='na';
                    if($item->product->ProductAttributesValues->isNotEmpty()){
                    $attributes_value = $item->product->ProductAttributesValues->first()->attributeValue->slug;
                }
                @endphp
                <li class="product-box-contain">
                    <div class="drop-cart">
                        <a href="{{ url('products/'.$item->product->slug.'/'.$attributes_value) }}" class="drop-image">
                            @if($item->product->images->isNotEmpty())
                            <img src="{{ asset('images/product/thumb/' . $item->product->images->first()->image_path) }}"
                                class="blur-up lazyload"
                                alt="{{ $item->product->name }}" loading="lazy">
                            @else
                            <img src="{{ asset('images/default.png') }}"
                                class="blur-up lazyload"
                                alt="Default Image" loading="lazy">
                            @endif
                        </a>
                        <div class="drop-contain">
                            <a href="{{ url('products/'.$item->product->slug.'/'.$attributes_value) }}">
                                <h5>{{ucwords(strtolower($item->product->title))}}</h5>
                            </a>
                            <h6>
                                <span>{{ $item->quantity }} x</span>
                               
                                Rs.
                                    @php
                                        $final_offer_rate = $item->product->offer_rate;
                                        if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
                                            $group_categoty_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                            if ($group_categoty_percentage > 0) {
                                                $purchase_rate = $item->product->purchase_rate;
                                                $offer_rate = $item->product->offer_rate;
                                                $percent_discount = 100/$group_categoty_percentage;
                                                $final_offer_rate =
                                                $purchase_rate+($offer_rate-$purchase_rate)*$percent_discount/100;
                                                $final_offer_rate = floor($final_offer_rate);
                                            }
                                        }
                                        $totalPrice = $final_offer_rate * $item->quantity;
                                        $subtotal += $totalPrice;

                                        
                                    @endphp
                                    {{$final_offer_rate}}
                            </h6>
                            <h6>
                                <h6>
                                    <span>Total:</span>
                                    Rs. {{ number_format($item->quantity * ($final_offer_rate ?? 0), 2) }}
                                </h6>
                                <!-- <button class="close-button close_button">
                                    <i class="fa-solid fa-xmark"></i>
                                </button> -->
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="price-box">
                <h5>Total :</h5>
                <h4 class="theme-color fw-bold">Rs. {{ number_format($subtotal, 2) }}</h4>
            </div>
            <div class="button-group">
                <a href="{{route('cart')}}" class="btn btn-sm cart-button">View Cart</a>
                <a href="{{route('order-param')}}" class="btn btn-sm cart-button theme-bg-color text-white">Checkout</a>
            </div>
        @else
            <h5>Your cart is empty</h5>
        @endif
    </div>
</div>