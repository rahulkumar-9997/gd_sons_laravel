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
                                    <p class="mb-0">Order / Order Details / {{ $order->order_id }} -  {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i:s A') }}</p>
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
                                        @foreach($order->orderLines as $line)
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
                                                    <div>
                                                        <a href="#!" class="text-dark fw-medium fs-15">{{ ucwords(strtolower($line->product->title)) }}</a>

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
                    <!-- <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Order Timeline</h4>
                        </div>
                        <div class="card-body">
                            <div class="position-relative ms-2">
                                <span class="position-absolute start-0  top-0 border border-dashed h-100"></span>
                                <div class="position-relative ps-4">
                                    <div class="mb-4">
                                        <span class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle">
                                            <div class="spinner-border spinner-border-sm text-warning" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </span>
                                        <div class="ms-2 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                            <div>
                                                <h5 class="mb-1 text-dark fw-medium fs-15">The packing has been started</h5>
                                                <p class="mb-0">Confirmed by Gaston Lapierre</p>
                                            </div>
                                            <p class="mb-0">April 23, 2024, 09:40 am</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative ps-4">
                                    <div class="mb-4">
                                        <span class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                            <i class='bx bx-check-circle'></i>
                                        </span>
                                        <div class="ms-2 d-flex flex-wrap gap-2  align-items-center justify-content-between">
                                            <div>
                                                <h5 class="mb-1 text-dark fw-medium fs-15">The Invoice has been sent to the customer</h5>
                                                <p class="mb-2">Invoice email was sent to <a href="#!" class="link-primary">hello@dundermuffilin.com</a></p>
                                                <a href="#!" class="btn btn-light">Resend Invoice</a>
                                            </div>
                                            <p class="mb-0">April 23, 2024, 09:40 am</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative ps-4">
                                    <div class="mb-4">
                                        <span class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                            <i class='bx bx-check-circle'></i>
                                        </span>
                                        <div class="ms-2 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                            <div>
                                                <h5 class="mb-1 text-dark fw-medium fs-15">The Invoice has been created</h5>
                                                <p class="mb-2">Invoice created by Gaston Lapierre</p>
                                                <a href="#!" class="btn btn-primary">Download Invoice</a>
                                            </div>
                                            <p class="mb-0">April 23, 2024, 09:40 am</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative ps-4">
                                    <div class="mb-4">
                                        <span class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                            <i class='bx bx-check-circle'></i>
                                        </span>
                                        <div class="ms-2 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                            <div>
                                                <h5 class="mb-1 text-dark fw-medium fs-15">Order Payment</h5>
                                                <p class="mb-2">Using Master Card</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <p class="mb-1 text-dark fw-medium">Status :</p>
                                                    <span class="badge bg-success-subtle text-success  px-2 py-1 fs-13">Paid</span>
                                                </div>
                                            </div>
                                            <p class="mb-0">April 23, 2024, 09:40 am</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative ps-4">
                                    <div class="mb-2">
                                        <span class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                            <i class='bx bx-check-circle'></i>
                                        </span>
                                        <div class="ms-2 d-flex flex-wrap gap-2  align-items-center justify-content-between">
                                            <div>
                                                <h5 class="mb-2 text-dark fw-medium fs-15">4 Order conform by Gaston Lapierre</h5>
                                                <a href="#!" class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order 1</a>
                                                <a href="#!" class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order 2</a>
                                                <a href="#!" class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order 3</a>
                                                <a href="#!" class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order 4</a>
                                            </div>
                                            <p class="mb-0">April 23, 2024, 09:40 am</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

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
                                        <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon icon="solar:clipboard-text-broken"></iconify-icon> Sub Total : </p>
                                    </td>
                                    <td class="text-end text-dark fw-medium px-0">
                                        Rs. {{ number_format($order->grand_total_amount, 2)	}}</td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon icon="solar:ticket-broken" class="align-middle"></iconify-icon> Discount : </p>
                                    </td>
                                    <td class="text-end text-dark fw-medium px-0">Rs. 00</td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon icon="solar:kick-scooter-broken" class="align-middle"></iconify-icon> Delivery Charge : </p>
                                    </td>
                                    <td class="text-end text-dark fw-medium px-0">Rs. 00</td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon icon="solar:calculator-minimalistic-broken" class="align-middle"></iconify-icon> Estimated Tax (0%) : </p>
                                    </td>
                                    <td class="text-end text-dark fw-medium px-0">Rs. 00</td>
                                </tr>

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
                            $profileImg = $order->customer->profile_img ?? null;
                        @endphp

                        <img 
                            src="{{ $profileImg ? asset('images/customer/' . $profileImg) : asset('assets/images/users/avatar-1.jpg') }}" 
                            alt="Profile Image" 
                            class="avatar rounded-3 border border-light border-3">
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

@endpush