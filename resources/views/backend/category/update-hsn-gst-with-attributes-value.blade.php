@extends('backend.layouts.master')
@section('title','Manage Category')
@section('main-content')
@push('styles')

@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Selected Category and attributes 
                  <span style="color:#ff6c2f;">{{ $category->title }} -> {{ $attribute->title }}</span>
               </h4>
            </div>
            <div class="card-body">
               @if($attributesValues->isNotEmpty())
                  <table class="table align-middle mb-0 table-hover table-centered" id="gst_perlist">
                        <thead>
                           <tr>
                              <th style="width: 30%;">Attributes Value Name</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($attributesValues as $attributeValue)
                              <tr>
                                 <td>{{ $attributeValue->name }}</td>
                                 <td>
                                    <form class="update-form" data-id="{{ $attributeValue->id }}" action="{{ route('update-hsn-gst-attributes-value') }}">
                                       @csrf
                                       <input type="hidden" name="category_id" value="{{ $category->id }}">
                                       <input type="hidden" name="attributes_id" value="{{ $attribute->id }}">
                                       <input type="hidden" name="attributes_value_id" value="{{ $attributeValue->id }}">
                                       <div class="row">
                                          <div class="col-md-5 form-group">
                                             <label for="hsn_code">HSN Code *</label>
                                             <input type="text" class="form-control hsn_code" name="hsn_code" value="{{ $attributeValue->hsnGst->hsn_code ?? '' }}" required>
                                             <span class="text-danger hsn_code_error"></span>
                                          </div>
                                          <div class="col-md-5 form-group">
                                             <label for="gst_percentage">GST Percentage *</label>
                                             <input type="number" class="form-control gst_percentage" name="gst_percentage" value="{{ $attributeValue->hsnGst->gst_in_per ?? '' }}" required min="0" max="100">
                                             <span class="text-danger gst_percentage_error"></span>
                                          </div>
                                          <div class="col-md-2 form-group">
                                             <button style="margin-top: 20px;" type="submit" class="btn btn-primary btn-sm">Update</button>
                                             <div class="loader" style="display:none;">Loading...</div>
                                          </div>
                                       </div>
                                    </form>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                  </table>
               @else
                  <p>No attribute values found for this category and attribute.</p>
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
<script>
   $(document).off('submit', '.update-form').on('submit', '.update-form', function (e) {
      e.preventDefault();
      var form = $(this);
      var url = form.attr('action');
      var submitButton = form.find('button[type="submit"]');
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').remove();
      submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
      $.ajax({
         url: url,
         method: 'POST',
         data: form.serialize(),
         success: function (response) {
               submitButton.prop('disabled', false).html('Save changes');
               Toastify({
                  text: response.message || 'Form submitted successfully!',
                  duration: 10000,
                  gravity: "top",
                  position: "right",
                  className: "bg-success",
                  close: true,
                  onClick: function () { }
               }).showToast();
               $('#gst_perlist').load(location.href + " #gst_perlist");
         },
         error: function (xhr) {
               submitButton.prop('disabled', false).html('Save changes');
               
               if (xhr.status === 422) { 
                  let errors = xhr.responseJSON.errors;
                  let errorMessages = Object.values(errors).flat().join('<br>');
                  Toastify({
                     text: errorMessages || 'Please correct the errors in the form.',
                     duration: 10000,
                     gravity: "top",
                     position: "right",
                     className: "bg-danger",
                     escapeMarkup: false,
                     close: true,
                     onClick: function () { }
                  }).showToast();
                  $.each(errors, function (field, messages) {
                     let input = form.find(`[name="${field}"]`);
                     input.addClass('is-invalid');
                     input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                  });
               } else {
                  let errorMessage = xhr.responseJSON.message || 'An error occurred. Please try again.';
                  Toastify({
                     text: errorMessage,
                     duration: 10000,
                     gravity: "top",
                     position: "right",
                     className: "bg-danger",
                     close: true,
                     escapeMarkup: false,
                     onClick: function () { }
                  }).showToast();
               }
         }
      });
   });


</script>
@endpush