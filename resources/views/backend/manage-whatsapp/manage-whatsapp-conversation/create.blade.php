@extends('backend.layouts.master')
@section('title','Create Group Whatapp Message')
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
                    Create Group Whatapp Message
                    <a href="{{ route('manage-group-whatsapp.index') }}" data-title=" Go Back to Previous page" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-original-title=" Go Back to Previous page">
                      << Go Back to Previous page
                    </a>
                </h4>
                
            </div>
            <div class="card-body">
                <div class="mb-2" id="error-container"></div>
                <form method="POST" action="{{ route('manage-group-whatsapp.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" id="groupWhatsAppMessageForm">
                    @csrf
                    <input type="hidden" name="redirect_url" value="{{ request('redirect_url') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <label for="name" class="form-label">Select Group *</label>
                                <select class="form-select" id="group" name="group">
                                    <option value="">Select Group</option>
                                    @if($groups->isNotEmpty()) 
                                        @foreach($groups as $group)
                                            <option 
                                            value="{{ $group->id }}"
                                            {{ request('group') == $group->id ? 'selected' : '' }}
                                            >
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No Groups Available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    @if(count($customer_list) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Pnone</th>
                                        </tr>
                                        @foreach($customer_list as $customer_list_row)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="customer_id[]" value="{{ $customer_list_row->id }}">

                                                </td>
                                                <td>
                                                    {{$customer_list_row->name}}
                                                </td>
                                                <td>
                                                    {{$customer_list_row->email}}
                                                </td>
                                                <td>
                                                    {{$customer_list_row->phone_number}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="product_url" class="form-label">Enter Product URL *</label>
                                    <input type="text" id="product_url" name="product_url" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="mb-2">
                                    <input type="submit" value="Submit" class="btn btn-primary w-100">
                                </div>
                            </div>
                        </div>
                    
                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <h5>Customer list not found !</h5>
                                </div>
                            </div>
                        </div> -->
                    @endif
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
<script src="{{asset('backend/assets/js/pages/create-group-whatsapp.js')}}"></script>
@endpush