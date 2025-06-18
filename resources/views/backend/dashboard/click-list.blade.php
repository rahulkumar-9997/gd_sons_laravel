@extends('backend.layouts.master')
@section('title','All Visitor Click List')
@section('main-content')
@push('styles')
@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        All Visitor Click List
                    </h4>

                </div>
                <div class="card-body">
                    @if (isset($data['click-link']) && $data['click-link']->count() > 0)
                    <div class="table-responsive" id="product-list-container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Button Type</th>
                                    <th>Page URL</th>
                                    <th>IP Address</th>
                                    <th>Click Time</th>
                                    <th>Device Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['click-link'] as $click)
                                <tr>
                                    <td>{{ $click->button_type }}</td>
                                    <td>{{ $click->page_url }}</td>
                                    <td>{{ $click->ip_address }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($click->click_time)->format('d M Y h:i:s A') }}
                                    </td>
                                    <td>{{ ucfirst($click->device_type) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
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

@endpush