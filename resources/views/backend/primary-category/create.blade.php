@extends('backend.layouts.master')
@section('title','Create Primary Category')
@section('main-content')
@push('styles')
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Create Primary Category</h4>
                    <a href="{{ route('manage-primary-category.index') }}"
                        class="btn btn-sm btn-info">
                        Back to Primary Category
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('manage-primary-category.store')}}" accept-charset="UTF-8" enctype="multipart/form-data" id="addPrimaryCategory">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="path" class="form-label">Path (Url) *</label>
                                    <input type="text" id="path" name="path" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="products" class="form-label">Select Products</label>
                                    <select name="products[]" id="products" class="form-control product-autocomplete" multiple>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="hidden-textarea ckeditor4" id="description"></textarea>
                                </div>
                            </div>

                            <div class="pb-0 pt-1 d-flex justify-content-end gap-2">
                                <a href="{{ route('manage-blog.index')}}" class="btn btn-info">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="{{ asset('backend/assets/ckeditor-4/ckeditor.js') }}?v={{ env('ASSET_VERSION', '1.0.0') }}"></script>
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
    $(document).ready(function(){ 
        $('.product-autocomplete').select2({
            placeholder: "Search Product",
            minimumInputLength: 1,
            ajax: {
                url: "{{ route('product.autocomplete') }}",
                dataType: 'json',
                delay: 250,
                data: function(params){
                    return {
                        search: params.term,
                        selected_ids: $('.product-autocomplete').val() || []
                    };
                },
                processResults: function(data){
                    return data;
                },
                cache: true
            }
        });
    });    
</script>
@endpush