@extends('backend.layouts.master')
@section('title','Order details')
@section('main-content')
@push('styles')
@endpush
<!-- Start Container -->
<div class="container-xxl">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div>
                                    <h4 class="fw-medium text-dark d-flex align-items-center gap-2">
                                        {{ $order->order_id }}
                                        @if($order->payment_received == 1)
                                        <span class="badge bg-success-subtle text-success  px-2 py-1 fs-13">
                                            Paid
                                        </span>
                                        @else
                                        <span class="badge bg-danger-subtle text-danger  px-2 py-1 fs-13">
                                            Unpaid
                                        </span>
                                        @endif

                                        <span class="border border-warning text-warning fs-13 px-2 py-1 rounded">
                                            {{ $order->orderStatus->status_name }}
                                        </span>
                                    </h4>
                                    <p class="mb-0">Order / Order Details / {{ $order->order_id }} - {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i:s A') }}</p>
                                </div>
                                <!-- <div>
                                    <a href="#!" class="btn btn-outline-secondary">Refund</a>
                                    <a href="#!" class="btn btn-outline-secondary">Return</a>
                                    <a href="#!" class="btn btn-primary">Edit Order</a>
                                </div> -->

                            </div>

                            <!-- <div class="mt-4">
                                <h4 class="fw-medium text-dark">Progress</h4>
                            </div> -->
                            <!-- <div class="row row-cols-xxl-5 row-cols-md-2 row-cols-1">
                                <div class="col">
                                    <div class="progress mt-3" style="height: 10px;">
                                        <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">Order Confirming</p>
                                </div>
                                <div class="col">
                                    <div class="progress mt-3" style="height: 10px;">
                                        <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">Payment Pending</p>
                                </div>
                                <div class="col">
                                    <div class="progress mt-3" style="height: 10px;">
                                        <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 60%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-2">
                                        <p class="mb-0">Processing</p>
                                        <div class="spinner-border spinner-border-sm text-warning" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress mt-3" style="height: 10px;">
                                        <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">Shipping</p>
                                </div>
                                <div class="col">
                                    <div class="progress mt-3" style="height: 10px;">
                                        <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">Delivered</p>
                                </div>
                            </div> -->
                        </div>
                        <!-- <div class="card-footer d-flex flex-wrap align-items-center justify-content-between bg-light-subtle gap-2">
                            <p class="border rounded mb-0 px-2 py-1 bg-body"><i class='bx bx-arrow-from-left align-middle fs-16'></i> Estimated shipping date : <span class="text-dark fw-medium">Apr 25 , 2024</span></p>
                            <div>
                                <a href="#!" class="btn btn-primary">Make As Ready To Ship</a>
                            </div>
                        </div> -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle border-bottom">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($order->orderLines->isNotEmpty())
                                        @php
                                        $itemsSubTotal = $order->orderLines->sum(function ($line) {
                                        return $line->quantity * $line->price;
                                        });
                                        $shippingCharge = $order->shiprocketCourier->courier_shipping_rate ?? 0;
                                        $discountAmount = $order->coupon_discount_amount ?? 0;
                                        $finalPayable = ($itemsSubTotal - $discountAmount) + $shippingCharge;
                                        @endphp
                                        @foreach($order->orderLines as $line)
                                        @php
                                        $attributes_value ='na';
                                        if($line->product->ProductAttributesValues->isNotEmpty()){
                                        $attributes_value = $line->product->ProductAttributesValues->first()->attributeValue->slug;
                                        }
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                        @if($line->product->images->first())
                                                        <img src="{{ asset('images/product/thumb/' . $line->product->images->first()->image_path) }}"
                                                            class="avatar-md" alt="{{ $line->product->title }}">
                                                        @else
                                                        <img src="{{ asset('images/default.png') }}" class="avatar-md" alt="Default Image">
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                            <a href="{{ url('products/'.$line->product->slug.'/'.$attributes_value) }}" target="_blank" class="text-orange fw-medium text-decoration-none">
                                                                <span class="text-orange fw-medium fs-16">
                                                                    {{ ucwords(strtolower($line->product->title)) }}
                                                                </span>
                                                            </a>
                                                            <button type="button" 
                                                                class="btn btn-sm btn-link p-0 copy-product-btn" 
                                                                data-product-name="{{ ucwords(strtolower($line->product->title)) }}"
                                                                onclick="copyProductName(this); event.stopPropagation();"
                                                                style="text-decoration: none;">
                                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                                                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                                                </svg>
                                                            </button>
                                                            <span class="copy-feedback-{{ $line->id }}" style="display: none; font-size: 12px; color: green;">
                                                                Copied!
                                                            </span>
                                                        </div>
                                                        
                                                        @if($line->product->length && $line->product->breadth && $line->product->height && $line->product->weight)
                                                            <ul class="list-unstyled small mb-0">
                                                                <li><strong>Length in CM :</strong> {{ $line->product->length }}</li>
                                                                <li><strong>Breadth in CM :</strong> {{ $line->product->breadth }}</li>
                                                                <li><strong>Height in CM :</strong> {{ $line->product->height }}</li>
                                                                <li><strong>Weight in Kg :</strong> {{ $line->product->weight }}</li>
                                                                <li><strong>Volumetric Weight Kg :</strong> {{ $line->product->volumetric_weight_kg }}</li>
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $line->quantity }}</td>
                                            <td>Rs. {{ number_format($line->price, 2) }}</td>
                                            <td>
                                                Rs. {{ number_format($line->quantity * $line->price, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="bg-light">
                                            <td colspan="3" class="text-end fw-bold">
                                                Items Sub Total
                                            </td>
                                            <td class="fw-bold">
                                                Rs. {{ number_format($itemsSubTotal, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">
                                                Discount
                                                @if($order->coupon_code)
                                                <br>
                                                <small class="text-info">
                                                    Coupon : {{ $order->coupon_code }}
                                                </small>
                                                @endif

                                            </td>
                                            <td class="fw-bold text-danger">
                                                - Rs. {{ number_format($discountAmount, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">
                                                Shipping Charges
                                                @if($order->shiprocketCourier)
                                                <br>
                                                <small class="text-info">
                                                    {{ $order->shiprocketCourier->courier_name }}
                                                </small>
                                                @endif
                                            </td>
                                            <td class="fw-bold">
                                                Rs. {{ number_format($shippingCharge, 2) }}
                                            </td>
                                        </tr>
                                        <tr class="table-active">
                                            <td colspan="3" class="text-end fw-bold fs-16">
                                                Total Payable
                                            </td>
                                            <td class="fw-bold fs-16">
                                                Rs. {{ number_format($finalPayable, 2) }}
                                            </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="6" class="text-center">No order items found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Order Summary</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1">
                                            <iconify-icon icon="solar:clipboard-text-broken"></iconify-icon>
                                            Sub Total :
                                        </p>
                                    </td>
                                    <td class="text-end text-dark fw-medium px-0">
                                        Rs. {{
                                            number_format(
                                                $order->orderLines->sum(function ($line) {
                                                    return $line->quantity * $line->price;
                                                }),
                                            2)
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1">
                                            <iconify-icon icon="solar:ticket-broken" class="align-middle"></iconify-icon>
                                            Discount :
                                        </p>

                                        @if(!empty($order->coupon_code))
                                        <small class="text-success">
                                            Coupon : {{ $order->coupon_code }}
                                        </small>
                                        @endif
                                    </td>

                                    <td class="text-end text-dark fw-medium px-0">
                                        @if(!empty($order->coupon_discount_amount) && $order->coupon_discount_amount > 0)
                                        - Rs. {{ number_format($order->coupon_discount_amount, 2) }}
                                        @else
                                        Rs. 0.00
                                        @endif
                                    </td>
                                </tr>
                                @if($order->shiprocketCourier)
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1">
                                            <iconify-icon icon="solar:kick-scooter-broken" class="align-middle"></iconify-icon>
                                            Delivery Charge :

                                        </p>
                                        <p class="mb-0">
                                            <span class="text-success">
                                                <strong> Courier Partner :</strong>
                                                {{ $order->shiprocketCourier->courier_name }}
                                            </span>
                                        </p>
                                        <p>
                                            <span class="text-success">
                                                <strong> Delivery Expected Date :</strong>
                                                {{ $order->shiprocketCourier->delivery_expected_date }}
                                            </span>
                                        </p>
                                    </td>
                                    <td class="text-end text-dark fw-medium px-0">
                                        Rs. {{ number_format( $order->shiprocketCourier->courier_shipping_rate, 2) }}
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon icon="solar:kick-scooter-broken" class="align-middle"></iconify-icon> Delivery Charge : </p>
                                    </td>
                                    <td class="text-end text-dark fw-medium px-0">Rs. 00</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-light-subtle">
                    <div>
                        <p class="fw-medium text-dark mb-0">Total Amount</p>
                    </div>
                    <div>
                        <p class="fw-medium text-dark mb-0">
                            {{ number_format($order->grand_total_amount, 2)	}}
                        </p>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Payment Information</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-2">

                        <div>
                            <p class="mb-1 text-dark fw-medium">{{ $order->payment_mode }}</p>
                            <!-- <p class="mb-0 text-dark">xxxx xxxx xxxx 7812</p> -->
                        </div>
                        <div class="ms-auto">
                            <iconify-icon icon="solar:check-circle-broken" class="fs-22 text-success"></iconify-icon>
                        </div>
                    </div>
                    <p class="text-dark mb-1 fw-medium">Razorpay Order ID : <span class="text-muted fw-normal fs-13"> {{ $order->razorpay_order_id }}</span></p>
                    <p class="text-dark mb-1 fw-medium">Razorpay Payment ID : <span class="text-muted fw-normal fs-13"> {{ $order->razorpay_payment_id }}</span></p>
                    <p class="text-dark mb-1 fw-medium">Razorpay Signature ID : <span class="text-muted fw-normal fs-13"> {{ $order->signature_id }}</span></p>
                    <!-- <p class="text-dark mb-0 fw-medium">Card Holder Name : <span class="text-muted fw-normal fs-13"> Gaston Lapierre</span></p> -->

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customer Details</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        @php
                        $customer = $order->customer;
                        $profileImg = optional($customer)->profile_img;
                        $name = $customer->name ?? 'User';
                        @endphp

                        @if($profileImg && file_exists(public_path('images/customer/' . $profileImg)))
                        <img
                            src="{{ asset('images/customer/' . $profileImg) }}"
                            alt="{{ $name }}"
                            class="avatar rounded-3 border border-light border-3">
                        @else
                        <div class="avatar rounded-3 border border-light border-3 d-flex align-items-center justify-content-center bg-primary text-white">
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="mb-1">{{ $order->customer->name }}</p>
                            <a href="#!" class="link-primary fw-medium">
                                {{ $order->customer->email }}
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <h5 class="">Contact Number</h5>

                    </div>
                    <p class="mb-1">
                        {{ $order->customer->phone_number}}
                    </p>

                    <div class="d-flex justify-content-between mt-3">
                        <h5 class="">Shipping Address</h5>
                        <!-- <div>
                            <a href="#!"><i class='bx bx-edit-alt fs-18'></i></a>
                        </div> -->
                    </div>

                    <div>
                        <p class="mb-1">{{ $order->shippingAddress->full_name ?? 'N/A' }}</p>
                        <p class="mb-1">{{ $order->shippingAddress->full_address ?? 'N/A' }}</p>
                        @if($order->shippingAddress->apartment)
                        <p style="margin-top: 3px; margin-bottom: 3px;">
                            {{ $order->shippingAddress->apartment ?? 'N/A' }}
                        </p>
                        @endif
                        <p class="mb-1">{{ $order->shippingAddress->city_name ?? 'N/A' }}, {{ $order->shippingAddress->state ?? 'N/A' }} {{ $order->shippingAddress->pin_code ?? 'N/A' }}</p>
                        <p class="mb-1">{{ $order->shippingAddress->country ?? 'N/A' }}</p>
                        <p class="mb-1">{{ $order->shippingAddress->phone_number ?? 'N/A' }}</p>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <h5 class="">Billing Address</h5>
                        <!-- <div>
                            <a href="#!"><i class='bx bx-edit-alt fs-18'></i></a>
                        </div> -->
                    </div>

                    @if($order->billingAddress)
                    <div>
                        <p class="mb-1">{{ $order->billingAddress->full_name ?? 'N/A' }}</p>
                        <p class="mb-1">{{ $order->billingAddress->full_address ?? 'N/A' }}</p>
                        <p class="mb-1">{{ $order->billingAddress->city_name ?? 'N/A' }}, {{ $order->billingAddress->state ?? 'N/A' }} {{ $order->billingAddress->pin_code ?? 'N/A' }}</p>
                        <p class="mb-1">{{ $order->billingAddress->country ?? 'N/A' }}</p>
                        <p class="mb-1">{{ $order->billingAddress->phone_number ?? 'N/A' }}</p>
                    </div>
                    @else
                    <div>
                        <p class="mb-1">Same as shipping address</p>
                    </div>
                    @endif


                </div>
            </div>

        </div>
    </div>
</div>

@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')
<script>
function copyProductName(button) {
    const productName = button.getAttribute('data-product-name');
    navigator.clipboard.writeText(productName).then(function() {
        const feedbackSpan = button.nextElementSibling;
        feedbackSpan.style.display = 'inline-block';
        feedbackSpan.style.opacity = '1';
        setTimeout(function() {
            feedbackSpan.style.opacity = '0';
            setTimeout(function() {
                feedbackSpan.style.display = 'none';
                feedbackSpan.style.opacity = '1';
            }, 300);
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Failed to copy product name');
    });
}
</script>
@endpush