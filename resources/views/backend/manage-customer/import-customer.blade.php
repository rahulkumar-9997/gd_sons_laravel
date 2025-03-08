@extends('backend.layouts.master')
@section('title','Import Customer')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        Import Customer
                        <a href="{{route('manage-customer')}}"
                            data-title="Go Back to Previous Page"
                            data-bs-toggle="tooltip"
                            title="Go Back to Previous Page"
                            class="btn btn-sm btn-danger">
                            << Go Back to Previous Page
                                </a>

                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <h4>Exce Format (<span class="text-danger">Note : Email id unique</span>)</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                            </tr>
                            <tr>
                                <td>John</td>
                                <td>john@gmail.com</td>
                                <td>0000000000</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer py-2 bg-light bg-opacity-50">
                        <form method="POST" action="{{ route('customer.import') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <label for="product-categories" class="form-label">Import File *</label>
                                        <input type="file" id="import_file" class="form-control" aria-label="file example" required="required" name="import_file">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2 mt-3">
                                        <input type="submit" value="Submit" class="btn btn-primary w-50">
                                    </div>
                                </div>
                            </div>
                            
                        </form>
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


@endpush