@extends('frontend.layouts.master')
@section('title', 'GD Sons - Blogs')
@section('description', 'Read the latest kitchenware, cookware, appliances, home essentials, cooking tips, product guides, and lifestyle blogs from GD Sons.')

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

                            <li class="breadcrumb-item active">
                                Blog
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@if ($blogs && $blogs->isNotEmpty())
<section class="blog-pages pb-4">
    <div class="container-fluid-lg">
        <div class="blog-heading text-center mb-4">
            <div class="mb-2">
                <div class="lg:text-[20px] text-[16px]">Our Blog</div>
                <span class="title-leaf"></span>
            </div>
            <h1 class="leading-relaxed lg:text-[20px] text-[16px] mb-3">
                Kitchen tips, product guides & expert advice from GD Sons since 1970.
            </h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach ($blogs as $blog_row)
            <div class="blog-card bg-white rounded-2xl overflow-hidden shadow-[0_0_20px_rgba(0,0,0,0.07)]">
                <a href="{{ route('blog.details', ['slug' => $blog_row->slug]) }}">
                    <div class="overflow-hidden h-56 relative">
                        <img src="{{asset($blog_row->blog_image) }}" alt="{{$blog_row->title}}"
                            class="blog-img w-full h-full object-cover" />
                        <span class="absolute top-4 left-4 bg-primary-teal text-white text-[10px] font-semibold px-3 py-1 rounded-full shadow">
                            {{$blog_row->category->title}}
                        </span>
                    </div>
                    <div class="p-3 pb-2">
                        <h6 class="font-display text-slate-800 text-[20px] mb-3 line-clamp-3">
                            {{$blog_row->title}}
                        </h6>
                        @if(!empty($blog_row->bog_description))
                        <p class="text-slate-500 text-[16px] leading-relaxed line-clamp-3">
                            {!! strip_tags($blog_row->bog_description) !!}
                        </p>
                        @endif
                    </div>
                </a>
                <div class="px-2 pb-3 pt-3 border-t border-slate-100 text-center">
                    <a href="{{ route('blog.details', ['slug' => $blog_row->slug]) }}" class="inline-flex items-center gap-1.5 text-primary-teal text-[16px] font-semibold hover:gap-3 transition-all">
                        Read More
                        <svg class="w-3.5 h-3.5 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
@push('scripts')

@endpush