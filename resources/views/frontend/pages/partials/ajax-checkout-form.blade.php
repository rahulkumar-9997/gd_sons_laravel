@php
$customerId = auth('customer')->id();
if (auth('customer')->check()) {
$customer = auth('customer')->user();
$customerId = $customer->id;
$customerName = $customer->name;
$customerEmail = $customer->email;
$customerPhone = $customer->phone_number;
} else {
$customerName = '';
$customerEmail = '';
$customerPhone = '';
}
@endphp
<form action="{{route('checkout.submit')}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="checkoutFormSubmit">
    @csrf
    <input type="hidden" name="pick_up_status" value="pick_up_online">
    <div class="row">
        <div class="col-lg-8">
            <div class="left-sidebar-checkout">
                <div class="checkout-detail-box">
                    <ul>
                        <li>
                            <div class="checkout-icon">
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                    trigger="loop-on-hover"
                                    colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a"
                                    class="lord-icon">
                                </lord-icon>
                            </div>
                            <div class="checkout-box">
                                <div class="checkout-title">
                                    <h4>Billing & Shipping</h4>
                                </div>
                                <div class="checkout-detail">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if(isset($customer_address) && $customer_address->isNotEmpty())
                                            <div class="row" id="address-list">
                                                @foreach($customer_address as $address)
                                                <div class="col-xxl-6 col-lg-12 col-md-6 mb-2">
                                                    <div class="delivery-address-box">
                                                        <div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="customer_address_id" id="{{$address->id}}" value="{{$address->id}}" checked>
                                                            </div>
                                                            <div class="label label-svg">
                                                                <div class="docts-svg toggle-popup">
                                                                    <!-- Add a class to the SVG container for targeting -->
                                                                    <img src="{{asset('frontend/assets/svg/docs.svg')}}" class="toggle-popup" data-target="{{$address->id}}" loading="lazy">
                                                                </div>
                                                                <ul class="address-edit-popup" id="popup-{{$address->id}}">
                                                                    <li class="address-edit-section address-edit-click address-edited-section">
                                                                        <a href="javascript:void(0);"
                                                                            type="button"
                                                                            data-toggle="modal"
                                                                            class="edit-address-btn-container w-100 address-edit-link btn-show-details"
                                                                            data-id="{{ $address->id }}"
                                                                            data-url="{{ route('edit.address', $address->id) }}"
                                                                            data-cuid="{{$customerId}}"
                                                                            data-ajax-editaddress-popup="true"
                                                                            data-title="Edit Address">
                                                                            <i class="fa fa-edit"></i>
                                                                            <span class="address-edit">Edit Address</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <ul class="delivery-address-detail">
                                                                <li>
                                                                    <h4 class="fw-500">{{$address->name}}</h4>
                                                                </li>
                                                                <li>
                                                                    <p class="text-content">
                                                                        <span class="text-title">Address:</span> {{$address->address}}, {{$address->state}} {{$address->city}}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <h6 class="text-content">
                                                                        <span class="text-title">Pin Code:</span> {{$address->zip_code}}
                                                                    </h6>
                                                                </li>
                                                                <li>
                                                                    <h6 class="text-content mb-0">
                                                                        <span class="text-title">Phone:</span> {{$address->phone_number}}
                                                                    </h6>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="col-xxl-12 col-lg-12 col-md-12">
                                                    <div data-ajax-address-popup="true" data-size="md" data-title="Add New Address" data-url="{{route('add.address')}}" data-bs-toggle="tooltip" data-bs-original-title="Add New Address" type="button" data-customer-id="{{$customerId}}" class="right-container btn-add-new d-flex" aria-label="Add New Address">
                                                        <div class="img-container-second">
                                                            <span class="plus-icon"><i class="fa fa-plus"></i></span>
                                                        </div>
                                                        <span class="shipping-detail-heading">
                                                            Add New Address
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-xxl-12 col-lg-12 col-md-12 mb-2">
                                                <div class="row">
                                                    <!-- Full Name -->
                                                    <div class="col-md-6">
                                                        <div class="form-floating mb-4 theme-form-floating">
                                                            <input type="text" class="form-control" name="ship_full_name"
                                                                value="{{  $customerName }}"
                                                                placeholder="Enter full name">
                                                            <label for="full_name">Enter full name</label>
                                                        </div>
                                                    </div>

                                                    <!-- Phone Number -->
                                                    <div class="col-md-6">
                                                        <div class="form-floating mb-4 theme-form-floating">
                                                            <input type="text" class="form-control" name="ship_phone_number" placeholder="Enter phone number"
                                                                value="{{  $customerPhone }}"
                                                                maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                            <label for="phone_number">Enter phone number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating mb-4 theme-form-floating">
                                                            <input type="email" class="form-control" name="ship_email" placeholder="Enter email id"
                                                                value="{{  $customerEmail }}">
                                                            <label for="ship_email">Enter email id</label>
                                                        </div>
                                                    </div>

                                                    <!-- Country -->
                                                    <div class="col-md-6">
                                                        <div class="form-floating theme-form-floating">
                                                            <select class="form-select theme-form-select" name="ship_country">
                                                                <option value="India">India</option>
                                                            </select>
                                                            <label for="country">Select Country</label>
                                                        </div>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="col-md-6">

                                                        <div class="form-floating mb-4 theme-form-floating">
                                                            <input type="text" class="form-control" name="ship_full_address" placeholder="Enter address">
                                                            <label for="full_address">Street address</label>
                                                        </div>
                                                    </div>

                                                    <!-- Apartment, Suite -->
                                                    <div class="col-md-6">
                                                        <div class="form-floating mb-4 theme-form-floating">
                                                            <input type="text" class="form-control" name="ship_apartment" placeholder="Apartment, suite, etc. (optional)">
                                                            <label for="apartment">Apartment, suite, etc. (optional)</label>
                                                        </div>
                                                    </div>

                                                    <!-- City -->
                                                    <div class="col-md-4">
                                                        <div class="form-floating theme-form-floating">
                                                            <input type="text" class="form-control" name="ship_city_name" placeholder="Town / City">

                                                            <label for="ship_city_name">Town / City</label>
                                                        </div>
                                                        <!-- <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" class="form-control" name="ship_city_name" placeholder="Enter city">
                                                                <label for="city_name">Enter city</label>
                                                            </div> -->
                                                    </div>

                                                    <!-- State -->
                                                    <div class="col-md-4">
                                                        <div class="form-floating theme-form-floating">
                                                            <select class="form-select theme-form-select" name="ship_state">
                                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                            </select>
                                                            <label for="state">Select State</label>
                                                        </div>
                                                    </div>

                                                    <!-- Pin Code -->
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-4 theme-form-floating">
                                                            <input type="text" name="ship_pin_code" class="form-control" placeholder="Enter pin code">
                                                            <label for="pin_code">Enter pin code</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                        <!--
                                        <div class="col-lg-12">
                                            <div class="accordion accordion-flush custom-accordion" id="billShip">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingSameShip">
                                                        <button class="accordion-button same_ship collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSameShip" aria-expanded="false" aria-controls="flush-collapseSameShip">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="same_ship_address">
                                                                    <input class="form-check-input mt-0" type="radio" name="same_ship_bill_address" id="same_ship_address" value="0" checked>
                                                                    Same as shipping address
                                                                </label>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    <div id="flush-collapseSameShip" class="accordion-collapse collapse" aria-labelledby="flush-headingSameShip" data-bs-parent="#billShip">
                                                       
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingDifferentBill">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseDifferentBill" aria-expanded="false" aria-controls="flush-collapseDifferentBill">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="different_billing_address">
                                                                    <input class="form-check-input mt-0" type="radio" name="same_ship_bill_address" id="different_billing_address" value="1">
                                                                    Use a different billing address
                                                                </label>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    <div id="flush-collapseDifferentBill" class="accordion-collapse collapse" aria-labelledby="flush-headingDifferentBill" data-bs-parent="#billShip">
                                                        <div class="accordion-body">
                                                            <div class="row g-2">
                                                                <div class="col-md-6">
                                                                    <div class="form-floating mb-4 theme-form-floating">
                                                                        <input type="text" class="form-control" name="bill_full_name" placeholder="Enter full name">
                                                                        <label for="full_name">Enter full name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating mb-4 theme-form-floating">
                                                                        <input type="text" class="form-control" name="bill_phone_number" placeholder="Enter phone number"
                                                                            maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                                        <label for="phone_number">Enter phone number</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating theme-form-floating">
                                                                        <select class="form-select theme-form-select" name="bill_country">
                                                                            <option value="India">India</option>
                                                                        </select>
                                                                        <label for="country">Select Country</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating mb-4 theme-form-floating">
                                                                        <input type="text" class="form-control" name="bill_full_address" placeholder="Enter address">
                                                                        <label for="full_address">Enter address</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-floating mb-4 theme-form-floating">
                                                                        <input type="text" class="form-control" name="bill_apartment" placeholder="Apartment, suite, etc. (optional)">
                                                                        <label for="apartment">Apartment, suite, etc. (optional)</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-floating theme-form-floating">
                                                                        <select class="form-select theme-form-select" name="bill_city_name">
                                                                            <option value="Varanasi">Varanasi</option>
                                                                        </select>
                                                                        <label for="city">Select City</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-floating theme-form-floating">
                                                                        <select class="form-select theme-form-select" name="bill_state">
                                                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                                        </select>
                                                                        <label for="state">Select State</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-floating mb-4 theme-form-floating">
                                                                        <input type="text" name="bill_pin_code" class="form-control" placeholder="Enter pin code">
                                                                        <label for="pin_code">Enter pin code</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="checkout-icon">
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                    trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                    class="lord-icon">
                                </lord-icon>
                            </div>
                            <div class="checkout-box">
                                <div class="checkout-title">
                                    <h4>Payment Option</h4>
                                </div>

                                <div class="checkout-detail">
                                    <div class="accordion accordion-flush custom-accordion" id="accordionFlushExample">

                                        <!-- Razorpay Payment Option -->
                                        <div class="accordion-item">
                                            <div class="accordion-header" id="flush-headingRazorpay">
                                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#flush-collapseRazorpay">
                                                    <div class="custom-form-check form-check mb-0">
                                                        <label class="form-check-label" for="payment_razorpay">
                                                            <input class="form-check-input mt-0" type="radio" name="payment_type" id="payment_razorpay" value="Razorpay" checked>
                                                            Credit Card/Debit Card/NetBanking <img src="https://cdn.razorpay.com/static/assets/logo/rzp_payment_icon.svg" alt="Credit Card/Debit Card/NetBanking" class="razorpayimg">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="flush-collapseRazorpay" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        Secure payment via Razorpay
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Cash on Delivery Option -->
                                        <div class="accordion-item">
                                            <div class="accordion-header" id="flush-headingCOD">
                                                <div class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseCOD">
                                                    <div class="custom-form-check form-check mb-0">
                                                        <label class="form-check-label" for="payment_cod">
                                                            <input class="form-check-input mt-0" type="radio" name="payment_type" id="payment_cod" value="Cash on Delivery">
                                                            Cash On Delivery
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="flush-collapseCOD" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    Pay with cash upon delivery.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Store Pickup Option -->
                                        <div class="accordion-item">
                                            <div class="accordion-header" id="flush-headingStore">
                                                <div class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseStore">
                                                    <div class="custom-form-check form-check mb-0">
                                                        <label class="form-check-label" for="payment_store">
                                                            <input class="form-check-input mt-0" type="radio" name="payment_type" id="payment_store" value="Pick Up From Store">
                                                            Pick Up From Store (Get Additional Discount)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="flush-collapseStore" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        You can pick up your order from our store during business hours.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
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
                        //echo $final_offer_rate;
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
        </div>
    </div>

</form>