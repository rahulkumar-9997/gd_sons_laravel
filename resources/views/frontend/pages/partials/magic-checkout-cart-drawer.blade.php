<div class="drawer dr-cart js-drawer" id="drawer-cart-id" tabindex="-1" aria-hidden="false">
    <div class="drawer__overlay js-drawer__close" tabindex="-1"></div>
    <div class="drawer__content bg-light inner-glow shadow-md flex flex-column" role="dialog" aria-labelledby="drawer-cart-title" aria-modal="true">
        <header class="minicart-header border-bottom">
            <h1 id="drawer-cart-title" class="text-base text-truncate">
                Your Cart (<span class="cart-count">{{ $cartCount ?? 0 }}</span>)
            </h1>
            <button class="drawer__close-btn js-drawer__close" aria-label="Close cart">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </header>
        
        <div class="drawer__body minicart-content">
            @php
            $subtotal = 0;
            @endphp
            
            @if(!$isCartEmpty)
                <ol class="cart-items">
                @foreach($cartItems as $item)
                    @php
                        $attributes_value = 'na';
                        if($item->product->ProductAttributesValues->isNotEmpty()){
                            $attributes_value = $item->product->ProductAttributesValues->first()->attributeValue->slug;
                        }
                        $quantity = $item->quantity;
                    @endphp
                    
                    @php
                        $purchase_rate = $item->product->purchase_rate;
                        $offer_rate = $item->product->offer_rate;
                        $mrp = $item->product->mrp;
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

                        // Special offer logic
                        if (isset($specialOffers[$item->product_id])) {
                            $special_offer_rate = (float) $specialOffers[$item->product_id];
                        }
                        
                        $final_offer_rate = collect([
                            $offer_rate,
                            $group_offer_rate,
                            $special_offer_rate
                        ])->filter()->min();

                        $totalPrice = $final_offer_rate * $item->quantity;
                        $subtotal += $totalPrice;
                    @endphp

                    <li class="item d-flex justify-content-center align-items-center">
                        <a class="product-image rounded-3" href="{{ url('products/'.$item->product->slug.'/'.$attributes_value) }}">
                            @if($item->product->images->isNotEmpty())
                            <img src="{{ asset('images/product/thumb/' . $item->product->images->first()->image_path) }}"
                                class="blur-up lazyload"
                                alt="{{ $item->product->name }}" loading="lazy" width="120" height="170">
                            @else
                            <img src="{{ asset('images/default.png') }}"
                                class="blur-up lazyload"
                                alt="Default Image" loading="lazy" width="120" height="170">
                            @endif
                        </a>
                        <div class="product-details">
                            <a class="product-title" href="{{ url('products/'.$item->product->slug.'/'.$attributes_value) }}">{{ucwords(strtolower($item->product->title))}}</a>
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
                            
        @if(!$isCartEmpty)
            <footer class="cart-footer border-top border-contrast-lower minicart-bottom">
                <div class="subtotal clearfix">
                    <div class="minicart-action d-flex mt-3">
                        <div class="minicart-de">
                            <button id="rzp-magic-button" class="rzp-magic-button proceed-to-checkout btn btn-primary w-100 me-1"> 
                                <span class="secure-checkout-lock">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="restricted" width="14.677" height="19.569" viewBox="0 0 14.677 19.569">
                                        <g id="Group_2267" data-name="Group 2267">
                                            <path id="Path_2311" data-name="Path 2311" d="M78.269,7.338H77.046V5.708a5.708,5.708,0,1,0-11.415,0V7.338H64.408A.407.407,0,0,0,64,7.746V17.938a1.632,1.632,0,0,0,1.631,1.631H77.046a1.632,1.632,0,0,0,1.631-1.631V7.746A.407.407,0,0,0,78.269,7.338Zm-5.71,8.516a.408.408,0,0,1-.405.453H70.523a.408.408,0,0,1-.405-.453l.257-2.313a1.613,1.613,0,0,1-.667-1.311,1.631,1.631,0,1,1,3.262,0,1.613,1.613,0,0,1-.667,1.311ZM74.6,7.338H68.077V5.708a3.261,3.261,0,0,1,6.523,0Z" transform="translate(-64)" fill="#fff"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span>Secure Checkout</span>
                            </button>
                        </div>
                        <div class="minicart-de">
                            <p class="product-price-min">Rs. {{ number_format($subtotal, 2) }}</p>
                        </div>
                    </div>
                </div>
            </footer>
        @endif
    </div>
</div>

<!-- Razorpay Magic Checkout Script -->
<script src="https://checkout.razorpay.com/v1/magic-checkout.js"></script>
<script>
document.getElementById('rzp-magic-button').onclick = async function(e) {
    e.preventDefault();
    
    const button = this;
    const originalHtml = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    button.disabled = true;
    
    try {
        const lineItems = {!! json_encode($cartItems->map(function($item) {
            $finalPrice = collect([
                $item->product->offer_rate,
            ])->filter()->min();
            
            return [
                'sku' => $item->product->sku ?? 'SKU'.$item->product_id,
                'name' => $item->product->title,
                'quantity' => $item->quantity,
                'offer_price' => round($finalPrice * 100),
                'tax_amount' => 0,
                'total_amount' => round($finalPrice * $item->quantity * 100)
            ];
        })) !!};
        const lineItemsTotal = lineItems.reduce((sum, item) => sum + item.total_amount, 0);
        const response = await fetch('{{ route("razorpay.magic.order.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                amount: {{ $subtotal * 100 }}, 
                currency: 'INR',
                receipt: 'ORDER_{{ now()->format('YmdHis') }}',
                line_items_total: lineItemsTotal,
                line_items: lineItems,
                cart_items: {!! json_encode($cartItems) !!}
            })
        });

        if (!response.ok) {
            throw new Error('Failed to create order');
        }

        const order = await response.json();
        const options = {
            key: "{{ config('services.razorpay.key') }}",
            order_id: order.id,
            amount: order.amount.toString(),
            currency: order.currency,
            name: "GD Sons",
            description: "Order Payment",
            image: "https://www.gdsons.co.in/public/frontend/assets/gd-img/fav-icon.png",
            callback_url: "{{ route('razorpay.magic.callback') }}",
            redirect: true,
            one_click_checkout: true,
            show_coupons: true,
            prefill: {
                name: "{{ Auth::guard('customer')->user()->name ?? 'Customer' }}",
                email: "{{ Auth::guard('customer')->user()->email ?? 'customer@example.com' }}",
                contact: "{{ Auth::guard('customer')->user()->phone ?? '9000000000' }}"
            },
            notes: {
                order_reference: order.order_id,
                source: "magic_checkout"
            },
            theme: {
                color: "#f8471d"
            },
        };

        const rzp = new Razorpay(options);
        rzp.open();
        
        rzp.on('close', function() {
            button.innerHTML = originalHtml;
            button.disabled = false;
        });

    } catch (error) {
        console.error('Magic Checkout Error:', error);
        alert('Failed to initialize Magic Checkout. Please try again.');
        button.innerHTML = originalHtml;
        button.disabled = false;
    }
};
</script>