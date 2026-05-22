@extends('backend.layouts.master')
@section('title', $categories->title)
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
                        {{ $categories->title }}
                        <a href="{{route('category')}}" data-title="Go Back to Category" data-bs-toggle="tooltip" class="btn btn-sm btn-purple" data-bs-original-title="Go Back to Category">
                            << Go Back to Category
                                </a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <strong>Note:</strong> Select the attributes and their values that you want to use as additional filters for this category.
                        These filters will be displayed on the frontend to help customers narrow down their product search.
                    </div>
                    @if($categories->attributes->isNotEmpty())
                    <form action="{{ route('additional-filter.store', $categories->id) }}"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category_id" value="{{ $categories->id }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <label for="filter_button_name" class="form-label">Filter Button Name *</label>
                                    <input type="text" name="filter_button_name" id="filter_button_name" class="form-control" placeholder="Filter Button Name" value="">
                                    @error('filter_button_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">Attribute Title</th>
                                        <th>Attribute Values</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories->attributes as $attribute)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    class="form-check-input attribute-checkbox"
                                                    id="attribute-{{ $attribute->id }}"
                                                    name="attributes[]"
                                                    value="{{ $attribute->id }}">

                                                <label class="form-check-label fw-bold"
                                                    for="attribute-{{ $attribute->id }}">
                                                    {{ $attribute->title }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($attribute->AttributesValues as $value)
                                                <div class="form-check pt-1 pb-1">
                                                    <input type="checkbox"
                                                        class="form-check-input"
                                                        id="attribute-value-{{ $value->id }}"
                                                        name="attribute_values[{{ $attribute->id }}][]" value="{{ $value->id }}"  {{ in_array($value->id, $usedAttributeValueIds) ? 'disabled' : '' }}>

                                                    <label class="form-check-label"
                                                        for="attribute-value-{{ $value->id }}">
                                                        {{ $value->name }}
                                                        @if(in_array($value->id, $usedAttributeValueIds))
                                                            <span class="badge bg-danger ms-1">
                                                                Already Used
                                                            </span>
                                                        @endif
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-warning mb-0">
                        No attributes available for this category.
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