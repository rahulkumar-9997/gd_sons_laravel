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
    .product-element-top {
        transition: transform 0.9s;
        transform-style: preserve-3d;
        padding-top: 85.212122%;
    }
    .product-element-top .thumbnail {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .ui-menu.ui-autocomplete{
        z-index: 9999;
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
                    <div id="error-container-form"></div>
                    <div class="storage-img-list">
                        @include('backend.manage-storage.partials.storage-image-list', ['data' => $data])
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
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}">
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/manage-storage.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var headerHeight = $('header.topbar').outerHeight();
        var footer = $('.fixed-submit-container');
        var card = $('.card_fixed');
        /*alert(card.outerWidth());*/
        if (footer.length) {
            var footerOffset = footer.offset().top;
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

@endpush