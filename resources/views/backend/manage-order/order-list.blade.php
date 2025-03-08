@extends('backend.layouts.master')
@section('title','Manage Order')
@section('main-content')
@push('styles')

@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">All Order List</h4>
                    <!-- <a href="javascript:void(0)" 
                    data-category-popup="true" 
                    data-size="lg" 
                    data-title="Add Category" 
                    data-url="{{ route('category.create') }}" 
                    data-bs-toggle="tooltip" 
                    title="Add Category" 
                    class="btn btn-sm btn-primary">
                    Add Category
                </a> -->
                </div>
                <div class="card-body">
                    @if (isset($data['order_status']) && $data['order_status']->count() > 0)
                        @foreach($data['order_status'] as $status)
                            <a href="{{ route('order-list', ['order-status' => $status->id]) }}" class="btn btn-outline-primary rounded-pill 
                                {{ request()->query('order-status') == $status->id ? 'active' : '' }}">
                                {{ $status->status_name }}
                                
                            </a>
                        @endforeach
                    @endif
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Payment Mode</th>
                                    <th>Payment Status</th>
                                    <th>Items</th>
                                    <th>
                                        <span class="text-info">Order Status</span>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data['orders']->isNotEmpty())
                                    @foreach ($data['orders'] as $order)
                                        <tr>
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->created_at->format('d, M Y h:i A') }}</td>
                                            <td>
                                                <a href="#!" class="link-primary fw-medium">{{ $order->customer->name }}</a>
                                            </td>
                                            <td>Rs. {{ number_format($order->grand_total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge border border-success text-success  px-2 py-1 fs-13">{{ $order->payment_mode }}</span>
                                            </td>
                                            <td>
                                                @if($order->payment_received == 1)
                                                    <span class="badge bg-success text-light  px-2 py-1 fs-13">Paid</span>
                                                @else
                                                    <span class="badge bg-light text-dark  px-2 py-1 fs-13">Unpaid</span>
                                                @endif
                                                
                                            </td>
                                            <td>{{ $order->orderLines->count() }}</td>
                                            <td>
                                                <!--<span class="badge border border-secondary text-secondary px-2 py-1 fs-13">{{ $order->orderStatus->status_name }}</span>-->
                                                @if (isset($data['order_status']) && $data['order_status']->count() > 0)
                                                    <select class="form-control" 
                                                        id="select_order_status_{{ $order->id }}" 
                                                        name="update_order_status"
                                                        data-cusid="{{ $order->customer->id }}"
                                                        data-url="{{ route('update-order-status', ['orderId' => $order->id]) }}"
                                                        >
                                                        <option value="">Update Order Status</option>
                                                        @foreach($data['order_status'] as $order_status)
                                                            <option
                                                             value="{{ $order_status->id }}"
                                                             {{ $order->order_status_id == $order_status->id ? 'selected' : '' }}
                                                             >
                                                            {{ $order_status->status_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('download-invoice', ['orderId' => $order->id]) }}" class="btn btn-light btn-sm"
                                                     data-bs-toggle="tooltip" data-bs-original-title="Print Invoice"
                                                    >
                                                        <i class="ti ti-file-invoice"></i>
                                                    </a>
                                                    <a href="{{ route('order-details', ['id' => $order->id]) }}" class="btn btn-light btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-original-title="View Order Details"
                                                    >
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    
                                                    <form method="POST" action="{{ route('order-list.destroy', $order->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-name="{{ $order->order_id }}" class="btn btn-soft-danger btn-sm show_confirm"><i class="ti ti-trash"
                                                        data-bs-toggle="tooltip" data-bs-original-title="Delete Order"
                                                        ></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">No orders found for the selected status.</td>
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
<!-- End Container Fluid -->
<!-- Modal -->
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')
<script src="{{asset('backend/assets/js/pages/order-list.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.show_confirm').click(function (event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();

            Swal.fire({
                title: `Are you sure you want to delete this ${name}?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

    });
</script>
@endpush