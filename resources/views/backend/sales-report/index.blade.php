@extends('backend.layouts.master')
@section('title','Sales Report')
@section('main-content')
@push('styles')
@endpush

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        Sales Report
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="sale-report-list">
                        @include('backend.sales-report.partials.sale-report-list', [
                            'orders' => $orders ?? ''
                        ])
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
<script src="{{asset('backend/assets/js/pages/sales-report.js')}}" type="text/javascript"></script>
@endpush