@extends('backend.layouts.master')
@section('title', $data['category_show']->title)
@section('main-content')
@push('styles')
<!-- <link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/>    -->
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                <h4 class="card-title flex-grow-1">
                {{ $data['category_show']->title }}
                    <a href="{{route('category')}}" data-title="Go Back to Category" data-bs-toggle="tooltip" class="btn btn-sm btn-purple" data-bs-original-title="Go Back to Category">
                       << Go Back to Category
                    </a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive1">
                @if($data['category_show']->attributes->isNotEmpty())
                    <form action="{{route('mappedCategoryAttributesFront.submit')}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="category_id" value="{{ $data['category_show']->id }}">
                        </div>
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Attribute Title</th>
                                    <th>Attribute Values</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['category_show']->attributes as $attribute)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" id="attributes-{{$attribute->id}}" name="attributes[]" value="{{$attribute->id}}" @if(in_array($attribute->id, $data['mapped_attributes'])) checked @endif>
                                                <label class="form-check-label" for="attributes-{{$attribute->id}}">
                                                    {{ $attribute->title }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach($attribute->AttributesValues as $value)
                                                <a href="#">
                                                    <span class="mb-1 mt-1 badge bg-indigo py-1 px-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $value->name }} ">
                                                    {{ $value->name }}
                                                    </span>
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                    @else
                        <p>No attributes available for this category.</p>
                    @endif
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