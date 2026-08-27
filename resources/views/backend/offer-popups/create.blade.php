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
               <h4 class="card-title flex-grow-1">Create Offer Popup</h4>
               <a href="{{ route('offer-popups.index') }}" data-bs-toggle="tooltip" title="Back to Offer Popup" class="btn btn-sm btn-primary">
                 Back to Offer Popup
               </a>
            </div>
            <div class="card-body">
                <form action="{{ route('offer-popups.store') }}" method="POST" enctype="multipart/form-data" onsubmit="disableSubmitButton(this)">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title </label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Desktop Image (suggested ~600×750px) *</label>
                            <input type="file" name="desktop_image" class="form-control">
                            @error('desktop_image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>                  

                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile Image (suggested ~380×500px)</label>
                            <input type="file" name="mobile_image" class="form-control">
                            @error('mobile_image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Redirect URL </label>
                            <input type="text" name="redirect_url" class="form-control" placeholder="https://example.com">
                        </div>
                     </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Start Date (optional)</label>
                            <input type="text" name="starts_at" class="form-control flatpickr-date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">End Date (optional)</label>
                            <input type="text" name="ends_at" class="form-control flatpickr-date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" checked>
                            <label class="form-check-label" for="isActive">Active</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3 text-end">
                            <a href="{{ route('offer-popups.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button class="btn btn-primary" type="submit" id="submitBtn">
                                Submit
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
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting...';
        }
    }
</script>
@endpush