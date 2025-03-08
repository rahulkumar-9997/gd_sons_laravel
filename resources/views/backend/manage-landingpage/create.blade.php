@extends('backend.layouts.master')
@section('title','Create New Landing Page')
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
                        Create New Landing Page
                        <a href="{{ route('manage-landing-page.index') }}" data-title=" Go Back to Previous page" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-original-title=" Go Back to Previous page">
                            << Go Back to Previous page
                                </a>
                    </h4>

                </div>
                <div class="card-body">
                    <div class="mb-2" id="error-container"></div>
                    <form method="POST" action="{{ route('manage-landing-page.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" id="createLandingPost">
                        @csrf
                        <input type="hidden" name="redirect_url" value="{{ request('redirect_url') }}">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="post_title" class="form-label">Post Title *</label>
                                    <input type="text" id="post_title" name="post_title" class="form-control" value="{{ old('post_title') }}">
                                    @error('post_title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="post_image" class="form-label">Post Image *</label>
                                    <input type="file" id="post_image" name="post_image" class="form-control">
                                    @error('post_image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="post_url" class="form-label">Post Url *</label>
                                    <input type="text" id="post_url" name="post_url" class="form-control" value="{{ old('post_url') }}">
                                    @error('post_url')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="pb-0 pt-1">
                                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
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
@endpush