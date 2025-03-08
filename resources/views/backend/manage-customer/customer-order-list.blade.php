@extends('backend.layouts.master')
@section('title','Customer Order List')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/css/order.css')}}" rel="stylesheet" type="text/css" media="screen" />
<!-- <link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/>  -->
@endpush

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1 anchor" id="always-open">
                        {{$customer->name}} ({{$customer->email}})
                        <a href="{{ url()->previous() }}" data-title="Go Back to Previous Page" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-original-title="Go Back to Previous Page">
                            << Go Back to Previous Page
                                </a>
                    </h5>

                    <div class="mb-3">
                        <div class="accordion" id="accordionExample">
                            @if ($orders->isEmpty())
                            <p>No orders found for this customer.</p>
                            @else
                            @foreach ($orders as $index => $order)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                                        <span class="order_id">{{ $order->order_id }}  </span>
                                        <span class="order_date">
                                            <strong>Order Date :</strong>{{ $order->created_at->translatedFormat('d F Y') }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <!--<div class="row mb-3">
                                            <div class="col-lg-6">
                                                <fieldset>
                                                    <legend>Customer Details</legend>
                                                    <p><strong>Customer Name : </strong>{{ $customer->name }}</p>
                                                    <p><strong>Customer Email : </strong>{{ $customer->email }}</p>
                                                    <p><strong>Customer Phone : </strong>{{ $customer->phone_number }}</p>
                                                </fieldset>
                                            </div>
                                        </div>-->

                                        <div class="row mb-3">
                                            <div class="col-lg-12">
                                                <fieldset class="shadow-sm p-0 order-details">
                                                    <!-- <legend class="order-details">Order Details</legend> -->
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <fieldset class="shadow-sm p-3">
                                                                <legend>Shipping Address :</legend>
                                                                <p>
                                                                    <strong>Full Name:</strong> {{ $order->shippingAddress->full_name }}
                                                                </p>
                                                                <p>
                                                                    <strong>Phone No.:</strong> {{ $order->shippingAddress->phone_number }}
                                                                </p>
                                                                <p>
                                                                    <strong>Address:</strong> {{ $order->shippingAddress->full_address }}
                                                                </p>
                                                                <p>
                                                                    <strong>City:</strong> {{ $order->shippingAddress->city_name }}
                                                                </p>
                                                                <p>
                                                                    <strong>State & Country:</strong> {{ $order->shippingAddress->state }}, {{ $order->shippingAddress->country }}
                                                                </p>
                                                                <p>
                                                                    <strong>PIN Code:</strong> {{ $order->shippingAddress->pin_code }}
                                                                </p>
                                                            </fieldset>
                                                        </div>


                                                        @if ($order->billingAddress)
                                                        <div class="col-lg-6">
                                                            <fieldset class="shadow-sm p-3">
                                                                <legend>Billing Address :</legend>
                                                                <p>
                                                                    <strong>Name:</strong> {{ $order->billingAddress->full_name }}
                                                                </p>
                                                                <p>
                                                                    <strong>Phone No.:</strong> {{ $order->billingAddress->phone_number }}
                                                                </p>
                                                                <p>
                                                                    <strong>Address:</strong> {{ $order->billingAddress->full_address }}
                                                                </p>
                                                                <p>
                                                                    <strong>City:</strong> {{ $order->billingAddress->city_name }}
                                                                </p>
                                                                <p>
                                                                    <strong>State & Country:</strong> {{ $order->billingAddress->state }}, {{ $order->billingAddress->country }}
                                                                </p>
                                                                <p>
                                                                    <strong>PIN Code:</strong> {{ $order->billingAddress->pin_code }}
                                                                </p>
                                                            </fieldset>
                                                        </div>
                                                        @else
                                                        <div class="col-lg-6">
                                                            <fieldset class="shadow-sm p-3">
                                                                <legend>Billing Address (Same as shipping address) :</legend>
                                                                <p>
                                                                    <strong>Full Name:</strong> {{ $order->shippingAddress->full_name }}
                                                                </p>
                                                                <p>
                                                                    <strong>Phone No.:</strong> {{ $order->shippingAddress->phone_number }}
                                                                </p>
                                                                <p>
                                                                    <strong>Address:</strong> {{ $order->shippingAddress->full_address }}
                                                                </p>
                                                                <p>
                                                                    <strong>City:</strong> {{ $order->shippingAddress->city_name }}
                                                                </p>
                                                                <p>
                                                                    <strong>State & Country:</strong> {{ $order->shippingAddress->state }}, {{ $order->shippingAddress->country }}
                                                                </p>
                                                                <p>
                                                                    <strong>PIN Code:</strong> {{ $order->shippingAddress->pin_code }}
                                                                </p>
                                                            </fieldset>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-lg-12"><br>
                                                        <div style="overflow-x:auto;">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Item</th>
                                                                        <th>Image</th>
                                                                        <th>Qty</th>
                                                                        <th>Rate</th>
                                                                        <th align="right">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($order->orderLines as $orderLine)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>
                                                                            {{ucwords(strtolower($orderLine->product->title))}}
                                                                            <br>
                                                                            <b>Product path : </b><br>
                                                                            <input type="text" value="{{ url('product', $orderLine->product->slug) }}">
                                                                        </td>
                                                                        <td>
                                                                        @if($orderLine->product->images->first())
                                                                            <img src="{{ asset('images/product/thumb/' . $orderLine->product->images->first()->image_path) }}"
                                                                                class="blur-up lazyload order-image" alt="{{ $orderLine->product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                                                            @else
                                                                            <img src="{{ asset('images/default.png') }}" class="blur-up order-image lazyload" alt="Default Image" style="width: 50px; height: 50px; object-fit: cover;">
                                                                            @endif
                                                                            
                                                                        </td>
                                                                        <td>
                                                                            {{ $orderLine->quantity }}
                                                                        </td>
                                                                        <td>
                                                                            Rs. {{ number_format($orderLine->price, 2) }}
                                                                        </td>
                                                                        <td align="right">
                                                                            Rs. 
                                                                            {{ number_format($orderLine->quantity * $orderLine->price, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="4"></td>
                                                                        <td>
                                                                            <strong>Order Total :</strong>
                                                                        </td>
                                                                        <td align="right">
                                                                            Rs. 
                                                                            {{ number_format($order->grand_total_amount, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                    </div>
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