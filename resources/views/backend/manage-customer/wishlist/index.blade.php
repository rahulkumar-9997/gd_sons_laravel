@extends('backend.layouts.master')
@section('title', 'Customer wishlist - '.$customer->name)
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                    
                        <a href="{{route('manage-customer')}}"
                            data-title="Go Back to Previous Page"
                            data-bs-toggle="tooltip"
                            title="Go Back to Previous Page"
                            class="btn btn-sm btn-danger">
                            << Go Back to Previous Page
                        </a>
                        Customer Wishlist ({{$customer->name}})
                    </h4>
                </div>
            </div>
            <div class="card">
                <div class="col-md-12">
                    <table class="table table">
                        <tr>
                            <th>
                                Name :
                            </th>
                            <td>
                                {{$customer->name}}
                                <br><strong>Register Date :</strong>
                                <span class="text-info">
                                    {{ $customer->created_at->format('d F Y') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Email :
                            </th>
                            <td>
                                {{$customer->email}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Phone No. :
                            </th>
                            <td>
                                {{$customer->phone_number}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-old">
                <div class="row-old">
                    @if($wishlist->isNotEmpty())
                        @foreach ($wishlist as $wishlistItem)
                            @php
                                $attributes_value ='na';
                                    if($wishlistItem->product->ProductAttributesValues->isNotEmpty()){
                                    $attributes_value = $wishlistItem->product->ProductAttributesValues->first()->attributeValue->slug;
                                }
                            @endphp
                            <div class="col-md-3 col-xl-3">
                                <div class="card border-green">
                                    @if($wishlistItem->product->images->isNotEmpty())
                                        <img src="{{ asset('images/product/thumb/'.$wishlistItem->product->images->first()->image_path) }}" alt="{{ $wishlistItem->product->title }}" class="img-fluid" style="width: 100%">
                                    @else
                                        <img src="{{asset('frontend/assets/gd-img/product/no-image.png')}}" class="img-fluid blur-up lazyloaded" alt="Default Image">
                                    @endif
                                    <div class="card-body bg-light-subtle rounded-bottom">
                                        <a href="{{ url('products/'.$wishlistItem->product->slug.'/'.$attributes_value)}}" class="text-dark fw-medium fs-16">
                                                {{ ucwords(strtolower($wishlistItem->product->title)) }}
                                            </a>
                                        
                                        <h4 class="fw-semibold text-dark mt-2 d-flex align-items-center gap-2">
                                            @if($wishlistItem->product->inventories->isNotEmpty())
                                                @php
                                                    $inventory = $wishlistItem->product->inventories->first();
                                                @endphp
                                                <span class="text-muted text-decoration-line-through">
                                                    Rs. {{ $inventory->mrp  }}
                                                </span>
                                                Rs. {{ $inventory->offer_rate }}
                                                <!-- <small class="text-muted"> (30% Off)</small> -->
                                            @else
                                                <span class="theme-color">Price not available</span>
                                            @endif
                                        </h4>
                                        <div class="mt-3">
                                            <div class="d-flex gap-2">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-soft-primary border border-primary-subtle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></a>
                                                    <div class="dropdown-menu">
                                                        <!-- item-->
                                                        <a href="#!" class="dropdown-item">Edit</a>
                                                        <!-- item-->
                                                        <a href="#!" class="dropdown-item">Overview</a>
                                                        <!-- item-->
                                                        <a href="#!" class="dropdown-item">Delete</a>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <span class="position-absolute top-0 end-0 p-3">
                                        <button type="button" class="btn btn-soft-danger avatar-sm d-inline-flex align-items-center justify-content-center fs-20 rounded-circle"><iconify-icon icon="solar:heart-broken"></iconify-icon></button>
                                    </span> -->
                                </div>
                            </div>
                        @endforeach
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