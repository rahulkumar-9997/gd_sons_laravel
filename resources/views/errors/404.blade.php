@extends('frontend.layouts.master')
@section('title', 'GD Sons - 404')
@section('description', 'G D Sons')
@section('keywords', 'G D Sons')
@section('main-content')
@push('styles')
<script>
  window.location.href = '{{ route('home') }}';
</script>
@endpush
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

              <li class="breadcrumb-item active">404</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Breadcrumb Section End -->
<section class="section-404 section-lg-space">
  <div class="container-fluid-lg">
    <div class="row">
      <div class="col-12">
        <div class="image-404">
          <img src="{{ asset('/frontend/assets/gd-img/404.png') }}" class="img-fluid blur-up lazyloaded" alt="404">
        </div>
      </div>

      <div class="col-12">
        <div class="contain-404">
          <h3 class="text-content">The page you are looking for could not be found. The link to this
            address may be outdated or we may have moved the since you last bookmarked it.</h3>
            <button 
              onclick="location.href = '{{ route('home') }}';" 
              class="btn btn-md text-white theme-bg-color mt-4 mx-auto">
              Back To Home Screen
            </button>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@push('scripts')

@endpush