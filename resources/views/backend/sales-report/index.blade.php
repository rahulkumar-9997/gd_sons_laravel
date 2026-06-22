@extends('backend.layouts.master')
@section('title','Sales Report')
@section('main-content')
@push('styles')
<style>
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table-success {
    background-color: #d4edda !important;
}
.table-danger {
    background-color: #f8d7da !important;
}
.table-warning {
    background-color: #fff3cd !important;
}
details summary {
    list-style: none;
}
details summary::-webkit-details-marker {
    display: none;
}
details summary::before {
    content: '';
}
</style>
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
                    <div class="card shadow-sm border-0 mb-2 filter-box">
                        <div class="card-body">
                            <form >
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-secondary">
                                            <i class="far fa-calendar-alt me-1"></i>Year
                                        </label>
                                        <select name="year" class="form-select" id="year-filter">
                                            <option value="">All Years</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-secondary">
                                            <i class="fas fa-calendar-day me-1"></i>Month
                                        </label>
                                        <select name="month" class="form-select" id="month-filter">
                                            <option value="">All Months</option>
                                            @foreach($months as $month)
                                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-secondary">
                                            <i class="fas fa-search me-1"></i>Search Order
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-search text-muted"></i>
                                            </span>
                                            <input type="text" name="search" class="form-control" 
                                                placeholder="Enter Order ID..." value="{{ request('search') }}" id="order-search">
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="reset-sales-filter-wrapper" style="display: none;">
                                        <button type="button" id="reset-sales-filter" class="btn btn-danger w-100">
                                            <i class="fas fa-times me-1"></i> Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
<script>
    const routes = {
        saleReportIndex: "{{ route('sale-report') }}"
    };
</script>
<script src="{{asset('backend/assets/js/pages/sales-report.js')}}" type="text/javascript"></script>
@endpush