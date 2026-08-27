@extends('backend.layouts.master')
@section('title','Manage Offer Popup')
@section('main-content')
@push('styles')

@endpush
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Edit Offer Popup</h4>
                    <a href="{{ route('offer-popups.index') }}" data-bs-toggle="tooltip" title="Back to Offer Popup" class="btn btn-sm btn-primary">
                        Back to Offer Popup
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('offer-popups.update', $offerPopup) }}" method="POST" enctype="multipart/form-data" onsubmit="disableSubmitButton(this)">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title </label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $offerPopup->title) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Desktop Image (suggested ~600×750px)</label>
                                <input type="file" name="desktop_image" class="form-control">
                                <small class="text-muted">Leave blank to keep the current image.</small>
                                @error('desktop_image') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                <br>
                                @if($offerPopup->desktop_image)
                                <img src="{{ asset('storage/images/offer/'.$offerPopup->desktop_image) }}" width="90" class="mb-2 d-block rounded border">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile Image (suggested ~380×500px)</label>
                                <input type="file" name="mobile_image" class="form-control">
                                <small class="text-muted">Leave blank to keep the current image.</small>
                                @error('mobile_image') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                <br>
                                @if($offerPopup->mobile_image)
                                <img src="{{ asset('storage/images/offer/'.$offerPopup->mobile_image) }}" width="70" class="mb-2 d-block rounded border">
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Redirect URL </label>
                                <input type="text" name="redirect_url" class="form-control" value="{{ old('redirect_url', $offerPopup->redirect_url) }}" placeholder="https://example.com">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date (optional)</label>
                                <input type="text" name="starts_at" class="form-control flatpickr-date" value="{{ old('starts_at', optional($offerPopup->starts_at)->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date (optional)</label>
                                <input type="text" name="ends_at" class="form-control flatpickr-date" value="{{ old('ends_at', optional($offerPopup->ends_at)->format('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $offerPopup->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3 text-end">
                                <a href="{{ route('offer-popups.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button class="btn btn-primary" type="submit" id="submitBtn">
                                    Update
                                </button>
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
<script src="{{asset('backend/assets/js/components/form-flatepicker.js')}}?v={{ env('ASSET_VERSION', '1.0.0') }}"></script>
<script>
    flatpickr('.flatpickr-date', {
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    function disableSubmitButton(form) {
        const submitBtn = form.querySelector('#submitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
        }
    }
</script>
@endpush