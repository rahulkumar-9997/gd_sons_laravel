@extends('backend.layouts.master')
@section('title','Edit Primary Category')
@section('main-content')
@push('styles')
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Edit Primary Category</h4>
                    <a href="{{ route('manage-primary-category.index') }}"
                        class="btn btn-sm btn-info">
                        Back to Primary Category
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('manage-primary-category.update', $primary_category_row->id) }}"
                        enctype="multipart/form-data"
                        id="editPrimaryCategory">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Title *</label>
                                    <input type="text"
                                        name="title"
                                        id="title"
                                        class="form-control"
                                        value="{{ $primary_category_row->title }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Path (Url) *</label>
                                    <input type="text"
                                        name="path"
                                        id="path"
                                        class="form-control"
                                        value="{{ $primary_category_row->link }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Select Products</label>
                                    <select name="products[]"
                                        class="form-control product-autocomplete"
                                        multiple id="products">
                                        @foreach($primary_category_row->products as $product)
                                        <option value="{{ $product->id }}" selected>
                                            {{ $product->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="hidden-textarea ckeditor4" id="description">
                                    {{ $primary_category_row->primary_category_description }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="pb-0 pt-1 d-flex justify-content-end gap-2">
                                <a href="{{ route('manage-primary-category.index') }}" class="btn btn-info">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.layouts.common-modal-form')
@endsection
@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset('backend/assets/ckeditor-4/ckeditor.js') }}?v={{ env('ASSET_VERSION', '1.0') }}"></script>
<script>
    window.CKEDITOR_ROUTES = {
        upload: "{{ route('ckeditor.upload') }}",
        imagelist: "{{ route('ckeditor.images') }}",
        delete: "{{ route('ckeditor.delete') }}"
    };
    window.csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('backend/assets/ckeditor-4/ckeditor-r-create-config.js') }}?v={{ env('ASSET_VERSION', '1.0') }}"></script>
<script src="{{asset('backend/assets/js/pages/primaryCategory.js')}}?v={{ env('ASSET_VERSION', '1.0') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.product-autocomplete').select2({
            placeholder: "Search Product",
            minimumInputLength: 1,
            ajax: {
                url: "{{ route('product.autocomplete') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        selected_ids: $('.product-autocomplete').val() || []
                    };
                },
                processResults: function(data) {
                    return data;
                },
                cache: true
            }
        });
    });    
</script>
@endpush