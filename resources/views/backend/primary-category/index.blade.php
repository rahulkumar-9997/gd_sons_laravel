@extends('backend.layouts.master')
@section('title','Manage Primary Category')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Primary Category</h4>
               <a href="{{ route('manage-primary-category.create') }}"
                  class="btn btn-sm btn-primary">
                  Add Primary Category
               </a>
            </div>
            <div class="card-body">
               @if (isset($primaryCategory) && $primaryCategory->count() > 0)
               <div class="table-responsive1">
                  <table class="table align-middle mb-0 table-hover table-centered">
                     <thead class="bg-light-subtle">
                        <tr>
                           <th>Sr. No.</th>
                           <th>Name</th>
                           <th>Status</th>
                           <th>Url</th>
                           <th>Description</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $sr_no = 1; @endphp
                        @foreach($primaryCategory as $primaryCategoryRow)
                        @php
                           $firstProduct = $primaryCategoryRow->products->first();
                           $totalProducts = $primaryCategoryRow->products->count();
                        @endphp
                        <tr>
                           <td>{{ $sr_no }}</td>
                           <td>
                              {{ $primaryCategoryRow->title }}
                              @if($firstProduct)
                                    <br>
                                    <span class="badge bg-primary">
                                       {{ $firstProduct->title }}
                                    </span>
                                    @if($totalProducts > 1)
                                       <span class="badge bg-secondary"
                                             data-bs-toggle="tooltip"
                                             title="{{ $primaryCategoryRow->products->pluck('title')->implode(', ') }}">
                                          +{{ $totalProducts - 1 }}
                                       </span>
                                    @endif                                    
                              @endif
                           </td>
                           <td>
                              <div class="form-check form-switch">
                                 <input class="form-check-input primaryCategoryStatus"
                                    data-pid="{{ $primaryCategoryRow->id }}"
                                    data-url="{{ route('manage-primary-category.status', $primaryCategoryRow->id) }}"
                                    type="checkbox"
                                    @if($primaryCategoryRow->status) checked @endif>
                              </div>
                           </td>
                           <td>
                              <div style="max-width: 250px; overflow:auto; white-space:nowrap;">
                                    {{ $primaryCategoryRow->link }}
                              </div>
                           </td>
                           <td>
                              <div style="max-width: 250px;">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($primaryCategoryRow->primary_category_description), 60) !!}
                              </div>
                           </td>
                           <td>
                              <div class="d-flex gap-2">
                                 <a href="{{ route('manage-primary-category.edit', $primaryCategoryRow->id) }}" 
                                    class="btn btn-soft-primary btn-sm">
                                    <i class="ti ti-pencil"></i>
                                 </a>
                                 <form method="POST" action="{{ route('manage-primary-category.destroy', $primaryCategoryRow->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                       data-name="{{ $primaryCategoryRow->title }}"
                                       class="btn btn-soft-danger btn-sm show_confirm">
                                       <i class="ti ti-trash"></i>
                                    </button>
                                 </form>
                              </div>
                           </td>
                        </tr>
                        @php $sr_no++; @endphp
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="my-pagination mt-3">
                  {{ $primaryCategory->links('vendor.pagination.bootstrap-4') }}
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
<script src="{{asset('backend/assets/js/pages/primaryCategory.js')}}?v={{ env('ASSET_VERSION', '1.0') }}" type="text/javascript"></script>
<script>
   $(document).ready(function() {
      $('.show_confirm').click(function(event) {
         var form = $(this).closest("form");
         var name = $(this).data("name");
         event.preventDefault();
         Swal.fire({
            title: `Are you sure you want to delete this ${name}?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            dangerMode: true,
         }).then((result) => {
            if (result.isConfirmed) {
               form.submit();
            }
         });
      });
   });
</script>
@endpush