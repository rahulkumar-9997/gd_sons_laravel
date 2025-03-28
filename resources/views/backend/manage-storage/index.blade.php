@extends('backend.layouts.master')
@section('title','Manage Storage')
@section('main-content')
@push('styles')
<style>
    .fixed-submit-container {
        position: sticky;
        top: 0px;
        margin-bottom: 30px;
        background: white;
        padding: 10px 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }
</style>
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Manage Storage</h4>

                    <a href="javascript:void(0)" data-uploadimaghe-popup="true" data-size="lg" data-title="Upload Image" data-url="{{ route('manage-storage.create') }}" data-bs-toggle="tooltip" class="btn btn-sm btn-info" data-bs-original-title="Upload Image">
                        Upload Images
                    </a>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="fixed-submit-container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="text" id="product_name" name="product_name[]" class="form-control product-autocomplete ui-autocomplete-input" autocomplete="off" placeholder="Select a Product">

                                            <span class="input-group-text">
                                                <i class="ti ti-refresh"></i>
                                                <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </span>
                                        </div>
                                        <input type="hidden" name="product_id[]" class="product_id">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary w-100">Map Selected Images to Product</button>
                                </div>
                            </div>
                        </div>


                        <div class="images-container mt-0">
                            <div class="row">
                                @if($data['image_storage']->isNotEmpty())
                                @foreach($data['image_storage'] as $image_storage)
                                <div class="col-md-3 col-xl-3">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selected_images[]"
                                                value="{{ $image_storage->id }}" id="image_{{ $image_storage->id }}">
                                            <label class="form-check-label" for="image_{{ $image_storage->id }}">
                                                Select
                                            </label>
                                        </div>
                                        <img src="{{ asset('images/storage/' . $image_storage->image_storage_path) }}" alt="img"
                                            class="img-fluid img-thumbnail">
                                        <div class="rounded-bottom">
                                            <div class="mt-1">
                                                <div class="d-flex gap-2">
                                                    <a href="order-cart.html"
                                                        class="btn btn-outline-dark border border-secondary-subtle d-flex align-items-center justify-content-center gap-1 w-100">
                                                        Delete Image
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        
                    </form>
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
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}">
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/create-whatsapp.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/manage-storage.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var headerHeight = $('header.topbar').outerHeight();
        var footer = $('.fixed-submit-container');
        var card = $('.card_fixed');
        /*alert(card.outerWidth());*/
        if (footer.length) {
            var footerOffset = footer.offset().top;
            console.log(footerOffset);
        } else {
            // console.log("Footer not found!");
        }

        function updateFooterWidth() {
            footer.css('width', card.outerWidth() + 'px');
        }
        $(window).on('scroll resize', function() {
            if ($(window).scrollTop() > footerOffset - headerHeight) {
                footer.addClass('fixed-footer').css('top', headerHeight + 'px');
                updateFooterWidth();
            } else {
                footer.removeClass('fixed-footer').css('width', '');
            }
        });
        $(window).resize(updateFooterWidth);
    });
</script>
<script>
    $(document).ready(function() {
        $('.show_confirm').click(function(event) {
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