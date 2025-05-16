@extends('frontend.layouts.master')
@section('title','GD Sons : Flash Sale')
@section('description', 'Best Kitchen Retail Store in Varanasi now goes Online')
@section('main-content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
   <div class="container-fluid-lg">
      <div class="row">
         <div class="col-12">
            <div class="breadcrumb-contain">
               <nav>
                  <ol class="breadcrumb mb-0">
                     <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                           Home
                        </a>
                     </li>
                     <li class="breadcrumb-item active">Fash Sale</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Shop Section Start -->
<section class="section-b-space shop-section">
   <div class="container-fluid-lg">
      <div class="row">
         <div class="col-lg-12">
            <div class="h1-heading">
                <h1>
                    Flash Sale
                </h1>
            </div>
         </div>
      </div>
        <div class="row" id="product-catalog-flash-sale">
            <div class="col-custom-12">
                <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-3 row-cols-2 product-list-section">
                    @include('frontend.pages.partials.ajax-flash-sale', [$products, $specialOffers])
                </div>
            </div>
        </div>
   </div>
</section>

<!-- Shop Section End -->
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
       
    });
</script>
@endpush