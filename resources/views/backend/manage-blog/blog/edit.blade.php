@extends('backend.layouts.master')
@section('title','Edit Blog')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/> 
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/>   
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1"> Edit Blog</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('manage-blog.update', $blog->id)}}" accept-charset="UTF-8" enctype="multipart/form-data" id="editBlog">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="blog_category" class="form-label">Select Blog  Category*</label>
                                <select class="form-control" id="blog_category" data-choices data-choices-groups data-placeholder="Select Blog Categories" name="blog_category">
                                    <option value="">Select Blog Category</option>
                                    @foreach ($blog_category as $blog_category_row)
                                    <option value="{{$blog_category_row->id}}" {{ $blog->blog_category_id == $blog_category_row->id ? 'selected' : '' }}>
                                            {{$blog_category_row->title}}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('blog_category'))
                                    <div class="text-danger">{{ $errors->first('blog_category') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="blog_name" class="form-label">Blog Title Name *</label>
                                <input type="text" id="blog_name" name="blog_name" class="form-control" value="{{ old('blog_name', $blog->title) }}">
                                @if($errors->has('blog_name'))
                                    <div class="text-danger">{{ $errors->first('blog_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="blog_img" class="form-label">Blog Title Image *</label>
                                <input type="file" id="blog_img" class="form-control" aria-label="file example"  name="blog_img" accept="image/*"  value="{{ old('blog_img')}}">
                                @if($errors->has('blog_img'))
                                    <div class="text-danger">{{ $errors->first('blog_img') }}</div>
                                @endif
                                @if($blog->blog_image)
                                    <img src="{{ asset($blog->blog_image) }}" class="mt-2" height="50">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <h5 class="card-title mb-1 anchor" id="quill-snow-editor">
                                    Blog Description *
                                </h5>
                                <div class="mb-3">
                                    <div class="snow-editor" style="height: 150px; width: 100%;">
                                    {!! $blog->bog_description !!}
                                    </div>
                                    <textarea name="blog_description" class="hidden-textarea" style="display:none;"> 
                                    {!! $blog->bog_description !!}
                                    </textarea>
                                    @if($errors->has('blog_description'))
                                        <div class="text-danger">{{ $errors->first('blog_description') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-indigo pt-1 pb-1 rounded-2">
                                <h4 class="text-center text-light" style="margin-bottom: 0px;;">Blog Paragraphs</h4>
                            </div>
                            
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <tr>
                                    <th style="width: 25%">Paragraphs Title</th>
                                    <th style="width: 25%"> Product Links</th>
                                    <th class="d-flex justify-content-between">
                                        <span>Paragraphs Description</span>
                                        <button class="btn btn-primary text-end add-more-blog-paragraphs btn-sm" type="button">Add More Blog Paragraphs</button>
                                        
                                    </th>
                                </tr>
                                @foreach($blog->paragraphs as $index => $paragraph)
                                    <tr class="paragraphstr">
                                        <td>
                                            @php
                                                $product_name_first = '';
                                                $product_id_first = '';
                                                $product_name_second = '';
                                                $product_id_second = '';
                                                if ($paragraph->productLinks->isNotEmpty()) {
                                                    $firstParagraph = $paragraph->productLinks->get(0);
                                                    $product_name_first = $firstParagraph['links'];
                                                    $product_id_first = $firstParagraph['product_id'];
                                                    $secondParagraph = $paragraph->productLinks->get(1);
                                                    $product_name_second = $secondParagraph['links'];
                                                    $product_id_second = $secondParagraph['product_id'];
                                                    
                                                }
                                            @endphp
                                            <input type="text" id="paragraphs_title" name="paragraphs_title[]" class="form-control" placeholder="Enter Paragraphs Title" value="{{ $paragraph->paragraphs_title }}">
                                            @if($errors->has('paragraphs_title'))
                                                <div class="text-danger">{{ $errors->first('paragraphs_title') }}</div>
                                            @endif
                                            
                                        </td>
                                        <td>
                                            <!-- <input type="file" id="paragraphs_img" class="form-control" aria-label="file example"  name="paragraphs_img[]" accept="image/*">
                                            @if($errors->has('paragraphs_img'))
                                                <div class="text-danger">{{ $errors->first('paragraphs_img') }}</div>
                                            @endif -->
                                            <!-- @if($paragraph->bog_paragraph_image)
                                                <img src="{{ asset($paragraph->bog_paragraph_image) }}" class="mt-2" height="50">
                                            @endif -->
                                            <br>
                                            <label for="blog_img" class="form-label">Select Blog Links One</label>
                                            <div class="position-relative autocompleted">
                                                <div class="input-group">
                                                    <input type="text" id="product_name" name="product_name[]" class="form-control product-autocomplete" value="{{$product_name_first}}">

                                                    <span class="input-group-text">
                                                        <i class="ti ti-refresh"></i>
                                                        <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </span>
                                                </div>
                                                <input type="hidden" value="{{$product_id_first}}" name="product_id[]" class="product_id">
                                            </div>
                                            @if($errors->has('blog_links_one'))
                                                <div class="text-danger">{{ $errors->first('blog_links_one') }}</div>
                                            @endif
                                            <br>
                                            <label for="blog_img" class="form-label">Select Blog Links Two</label>
                                            
                                            <div class="position-relative autocompleted">
                                                <div class="input-group">
                                                    <input type="text" id="product_name" name="product_name[]" class="form-control product-autocomplete" value="{{$product_name_second}}">

                                                    <span class="input-group-text">
                                                        <i class="ti ti-refresh"></i>
                                                        <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </span>
                                                </div>
                                                <input type="hidden" value="{{$product_id_second}}" name="product_id[]" class="product_id">
                                            </div>
                                            @if($errors->has('blog_links_two'))
                                                <div class="text-danger">{{ $errors->first('blog_links_two') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="snow-editor" style="height: 150px; width: 100%;"> {!! $paragraph->bog_paragraph_description !!}</div>
                                            <textarea name="paragraphs_description[]" class="hidden-textarea" style="display:none;">
                                            {!! $paragraph->bog_paragraph_description !!}
                                            </textarea>
                                            @if($errors->has('paragraphs_description'))
                                                <div class="text-danger">{{ $errors->first('paragraphs_description') }}</div>
                                            @endif
                                            
                                            <button type="button" data-url="{{ route('remove-blog-paragraphs', $paragraph->id) }}" class="btn btn-danger remov-paragraphs btn-sm" data-name="{{ $paragraph->paragraphs_title }}">Remove</button>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!--<div class="mb-3 col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                                <label class="form-check-label" for="status">Status</label>
                            </div>
                        </div>-->
                        
                        <div class="pb-0 pt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
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
<!--autocomplete-->
<link rel="stylesheet" href="{{asset('backend/assets/js/autocomplete/jquery-ui.css')}}">
<script src="{{asset('backend/assets/js/autocomplete/jquery-ui.min.js')}}"></script>
<!--autocomplete-->
<script src="{{asset('backend/assets/js/components/form-quilljs.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/create-blog.js')}}" type="text/javascript"></script> 

@endpush