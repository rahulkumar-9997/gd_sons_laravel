@extends('backend.layouts.master')
@section('title','Manage Order')
@section('main-content')
@push('styles')
<style>
    .disabled-dropdown {
        pointer-events: none !important;
        opacity: 0.6;
    }
    .order-list-table th,
    .order-list-table td
    {
        font-size: 14px;
    }
</style>
@endpush
@php
    $order_status_id = request()->query('order-status');
@endphp
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
                    <div class="table-responsive" style="margin-top: 20px;" id="order-list-table">
                        @include('backend.manage-order.partials.order-list-table', ['orders' => $orders, 'orders_status' => $orders_status, 'order_status_id' => $order_status_id])
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
<script src="{{asset('backend/assets/js/pages/order-list.js')}}?v={{ env('ASSET_VERSION', '1.0.0') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.copy-phone-icon', function() {
			var phone = $(this).data('phone');
			var icon = $(this);
			navigator.clipboard.writeText(phone).then(function() {
				icon.removeClass('ti-copy').addClass('ti-check text-success');
				setTimeout(function() {
					icon.removeClass('ti-check text-success').addClass('ti-copy');
				}, 5000);
			});
		});
        
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
    /*Copy new message js code */
    document.addEventListener('DOMContentLoaded', function () {
        let currentBaseUrl = null;
        const textarea = document.getElementById('copyMessageTextarea');
        function fetchMessage(type) {
            if (!currentBaseUrl) return;
            textarea.value = 'Loading...';
            const url = currentBaseUrl + (currentBaseUrl.includes('?') ? '&' : '?') + 'type=' + encodeURIComponent(type);
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Request failed with status ' + response.status);
                }
                return response.json();
            })
            .then(function (data) {
                if (!data.success) {
                    throw new Error('Server returned an error');
                }
                textarea.value = data.message;
            })
            .catch(function (error) {
                console.error('Fetching order message failed:', error);
                textarea.value = '';
                Toastify({
                    text: 'Could not load order message. Please try again.',
                    duration: 5000,
                    gravity: 'top',
                    position: 'right',
                    className: 'toastify-error',
                    close: true
                }).showToast();
            });
        }
        // Open modal -> fetch default template
        document.querySelectorAll('.copy-order-message').forEach(function (button) {
            button.addEventListener('click', function () {
                currentBaseUrl = this.dataset.url;

                document.getElementById('typeAvailable').checked = true;
                fetchMessage('available');
            });
        });
        document.querySelectorAll('.message-type-radio').forEach(function (radio) {
            radio.addEventListener('change', function () {
                fetchMessage(this.value);
            });
        });
        document.getElementById('copyFinalMessageBtn').addEventListener('click', function () {
            const message = textarea.value;
            navigator.clipboard.writeText(message)
                .then(function () {
                    Toastify({
                        text: 'Message copied to clipboard!',
                        duration: 3000,
                        gravity: 'top',
                        position: 'right',
                        className: 'toastify-success',
                        close: true
                    }).showToast();
                })
                .catch(function (error) {
                    console.error('Copy failed:', error);
                    try {
                        textarea.select();
                        document.execCommand('copy');
                        Toastify({
                            text: 'Message copied to clipboard!',
                            duration: 3000,
                            gravity: 'top',
                            position: 'right',
                            className: 'toastify-success',
                            close: true
                        }).showToast();
                    } catch (err) {
                        console.error('Fallback copy failed:', err);
                        Toastify({
                            text: 'Could not copy the message. Please try again.',
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            className: 'toastify-error',
                            close: true
                        }).showToast();
                    }
                });
        });
    });
    /*Copy new message js code */
</script>

@endpush