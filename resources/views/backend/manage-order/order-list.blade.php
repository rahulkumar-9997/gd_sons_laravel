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
                    @if (isset($orders_status) && $orders_status->count() > 0)
                        @foreach($orders_status as $status)
                            <a href="{{ route('order-list', ['order-status' => $status->id]) }}" class="btn btn-outline-primary rounded-pill 
                                {{ request()->query('order-status') == $status->id ? 'active' : '' }}">
                                {{ $status->status_name }}
                                
                            </a>
                        @endforeach
                    @endif
                    <div class="table-responsive" style="margin-top: 20px;">
                        @include('backend.manage-order.partials.order-list')
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