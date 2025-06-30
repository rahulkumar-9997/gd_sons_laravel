@extends('frontend.layouts.master')
@if($primary_category)
    @section('title', 'Complete Range of '. $primary_category->title.' in Varanasi.')
@else
    @section('title', 'Complete Range of '. $category->title.' in Varanasi.')
@endif
@section('keywords', 'GD Sons, ' . $category->title . ', Girdar das and sons')

@section('main-content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
   <div class="container-fluid-lg">
      <div class="row">
         <div class="col-12">
            <div class="breadcrumb-contain">
               <!-- <h2>{{ $category->title }}</h2> -->
               <nav>
                  <ol class="breadcrumb mb-0">
                     <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                           Home
                        </a>
                     </li>
                     <li class="breadcrumb-item active">{{ $category->title }} </li>
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
                @if($primary_category)
                    <h1>
                        Complete Range of {{ $primary_category->title }} in Varanasi.
                    </h1>
                @else
                    <h1>
                        Complete Range of {{ $category->title }} in Varanasi.
                    </h1>
                @endif
            </div>
         </div>
      </div>
        <div class="row" id="product-catalog-frontend">
            @include('frontend.pages.ajax-product-category-catalog', [$products, $attributes_with_values_for_filter_list])
			
			
						
        </div>
        @if($primary_category)
        <div class="row justify-content-md-center primary-category-div">
            <div class="col-custom-3"></div>
            <div class="col-custom-">
                <div class="primary_category_desc">
                    {!! $primary_category->primary_category_description !!}
                </div>
            </div>
        </div>
        @endif
        @if($category->category_heading)
            <div class="row">
                <div class="content-category text-center mt-5">
                    <h3>
                        {{ $category->category_heading }}
                    </h3>
                    <div class="delivery-list-category">
                        <p class="text-content">
                        {{ $category->description }}
						
						
                        </p>
                    </div>
                </div>
            </div>
        @endif
   </div>
</section>
@section('description', 'Explore a wide range of '. $category->title.' at Girdhar Das and Sons, featuring '.$transformedstr.'. Girdhar Das and Sons offers best selection in Varanasi. Shop now for unbeatable deals and quality!')

<!-- Shop Section End -->
@endsection
@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "@if($primary_category) Complete Range of {{ $primary_category->title }} in Varanasi @else Complete Range of {{ $category->title }} in Varanasi @endif",
    "description": "GD Sons - {{ $category->title }} - Shop the best quality products in Varanasi",
    "url": "{{ url()->current() }}",
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "{{ url('/') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "{{ $category->title }}",
                "item": "{{ url()->current() }}"
            }
        ]
    },
    "mainEntity": [
        @if($primary_category)
        {
            "@type": "ProductGroup",
            "name": "{{ $primary_category->title }}",
            "description": "{{ $category->category_heading }}",
            "url": "{{ url()->current() }}",
            "hasVariant": [
                @foreach($products as $product)
                @php
                    $firstImage = $product->images->get(0);
                    $attributes_value = $product->ProductAttributesValues->isNotEmpty() ? $product->ProductAttributesValues->first()->attributeValue->slug : 'na';
                    $purchase_rate = $product->purchase_rate;
                    $offer_rate = $product->offer_rate;
                    $mrp = $product->mrp;
                    $group_offer_rate = null;
                    $special_offer_rate = null;
                    
                    if ($groupCategory && $offer_rate !== null) {
                        $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                        if ($group_percentage > 0) {
                            $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                            $group_offer_rate = floor($group_offer_rate);
                        }
                    }
                    
                    if (isset($specialOffers[$product->id])) {
                        $special_offer_rate = (float) $specialOffers[$product->id];
                    }
                    
                    $final_offer_rate = collect([
                        $offer_rate,
                        $group_offer_rate,
                        $special_offer_rate
                    ])->filter()->min();
                    
                    $discountPercentage = ($mrp > 0 && $final_offer_rate > 0)
                        ? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
                        : 0;
                @endphp
                {
                    "@type": "Product",
                    "name": "{{ $product->title }}",
                    "description": "{{ 'GD Sons - ' . $category->title }}",
                    "url": "{{ url('products/'.$product['slug'].'/'.$attributes_value) }}",
                    "brand": {
                        "@type": "Brand",
                        "name": "GD Sons"
                    },
                    "category": "{{ $product->category->title }}",
                    @if($firstImage)
                    "image": "{{ asset('images/product/thumb/' . $firstImage->image_path) }}",
                    @endif
                    "hasDiscount": true,
                    "discount": {
                        "@type": "Discount",
                        "name": "{{ $discountPercentage }}% off",
                        "discountAmount": "{{ $mrp - $final_offer_rate }}",
                        "discountPercentage": "{{ $discountPercentage }}"
                    },
                    "offers": {
                        "@type": "Offer",
                        "url": "{{ url('products/'.$product['slug'].'/'.$attributes_value) }}",
                        "priceCurrency": "INR",
                        "price": "{{ $final_offer_rate }}",
                        "priceValidUntil": "{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}",
                        "itemCondition": "https://schema.org/NewCondition",
                        "availability": "https://schema.org/{{ $product->stock_quantity > 0 ? 'InStock' : 'OutOfStock' }}"
                    }
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
        @else
        {
            "@type": "CollectionPage",
            "name": "{{ $category->title }}",
            "description": "{{ $category->title }}",
            "url": "{{ url()->current() }}",
            "hasPart": [
                @foreach($products as $product)
                @php
                    $firstImage = $product->images->get(0);
                    $attributes_value = $product->ProductAttributesValues->isNotEmpty() ? $product->ProductAttributesValues->first()->attributeValue->slug : 'na';
                    $purchase_rate = $product->purchase_rate;
                    $offer_rate = $product->offer_rate;
                    $mrp = $product->mrp;
                    $group_offer_rate = null;
                    $special_offer_rate = null;

                    if ($groupCategory && $offer_rate !== null) {
                        $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                        if ($group_percentage > 0) {
                            $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                            $group_offer_rate = floor($group_offer_rate);
                        }
                    }

                    if (isset($specialOffers[$product->id])) {
                        $special_offer_rate = (float) $specialOffers[$product->id];
                    }

                    $final_offer_rate = collect([
                        $offer_rate,
                        $group_offer_rate,
                        $special_offer_rate
                    ])->filter()->min();

                    $discountPercentage = ($mrp > 0 && $final_offer_rate > 0)
                        ? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
                        : 0;
                @endphp
                {
                    "@type": "Product",
                    "name": "{{ $product->title }}",
                    "description": "{{ 'GD Sons - ' . $category->title }}",
                    "url": "{{ url('products/'.$product['slug'].'/'.$attributes_value) }}",
                    "brand": {
                        "@type": "Brand",
                        "name": "GD Sons"
                    },
                    "category": "{{ $product->category->title }}",
                    @if($firstImage)
                    "image": "{{ asset('images/product/thumb/' . $firstImage->image_path) }}",
                    @endif
                    @if($discountPercentage > 0)
                        "hasDiscount": true,
                        "discount": {
                            "@type": "Discount",
                            "name": "{{ $discountPercentage }}% off",
                            "discountAmount": "{{ $mrp - $final_offer_rate }}",
                            "discountPercentage": "{{ $discountPercentage }}"
                        },
                    @endif
                    "offers": {
                        "@type": "Offer",
                        "url": "{{ url('products/'.$product['slug'].'/'.$attributes_value) }}",
                        "priceCurrency": "INR",
                        "price": "{{ $final_offer_rate }}",
                        "priceValidUntil": "{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}",
                        "itemCondition": "https://schema.org/NewCondition",
                        "availability": "https://schema.org/{{ $product->stock_quantity > 0 ? 'InStock' : 'OutOfStock' }}"
                    }
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
        @endif
    ]
}
</script>
@endpush
@push('scripts')
<script src="{{asset('frontend/assets/js/ion.rangeSlider.min.js')}}"></script>
<!-- <script src="{{asset('frontend/assets/js/pages/category-filter-load-more.js')}}"></script> -->
<script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/quick-view.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addto-cart.js')}}"></script>
<script>
    $(document).ready(function() {
        const filters = {};
        let currentPage = 1;
        $(document).on('change', '.filter-checkbox', function() {
            const attributeSlug = $(this).data('attslug');
            const valueSlug = $(this).data('attvslug');
            if (!filters[attributeSlug]) {
                filters[attributeSlug] = [];
            }
            if ($(this).is(':checked')) {
                if (!filters[attributeSlug].includes(valueSlug)) {
                    filters[attributeSlug].push(valueSlug);
                }
            } else {
                filters[attributeSlug] = filters[attributeSlug].filter((slug) => slug !== valueSlug);
                if (filters[attributeSlug].length === 0) {
                    delete filters[attributeSlug];
                }
            }
            updateURL();
        });

        /*Remove individual filters*/
        $(document).on('click', '.remove-filter', function() {
            const attributeSlug = $(this).data('att-slug');
            const valueSlug = $(this).data('value-slug');
            if (filters[attributeSlug]) {
                filters[attributeSlug] = filters[attributeSlug].filter((slug) => slug !== valueSlug);
                if (filters[attributeSlug].length === 0) {
                    delete filters[attributeSlug];
                }
            }
            $(`.filter-checkbox[data-attslug="${attributeSlug}"][data-attvslug="${valueSlug}"]`).prop('checked', false);
            updateURL();
        });

        /*Clear all filters*/
        $(document).on('click', '#clear-filters', function() {
            for (let key in filters) {
                delete filters[key];
            }
            let url = '{{ route("categories", [$category->slug]) }}';
            window.history.replaceState({}, '', url);
            fetchFilteredProducts(url, false);
        });

        /* Handle sorting*/
        $(document).on('click', '.dropdown-menu .dropdown-item', function() {
            const sortId = $(this).data('sortid');
            let urlParams = new URLSearchParams(window.location.search);

            if (sortId) {
                urlParams.set('sort', sortId);
            } else {
                urlParams.delete('sort');
            }
            const newUrl = window.location.pathname + '?' + urlParams.toString();
            showLoader();
            window.history.replaceState({}, '', newUrl);
            fetchFilteredProducts(newUrl, false);
        });

        // Handle Load More functionality
        // $(document).on('click', '#load-more', function() {
        //     currentPage++;
        //     let baseUrl = window.location.href.split('?')[0];
        //     let queryParams = new URLSearchParams(window.location.search);
        //     queryParams.set('page', currentPage);
        //     let url = `${baseUrl}?${queryParams.toString()}`;
        //     fetchFilteredProducts(url, true);
        // });
        // Handle Load More functionality
        $(document).on('click', '#load-more', function() {
            currentPage++;
            let baseUrl = window.location.href.split('?')[0];
            let queryParams = new URLSearchParams(window.location.search);
            queryParams.set('page', currentPage);
            queryParams.set('load_more', true);  // Add load_more parameter
            let url = `${baseUrl}?${queryParams.toString()}`;
            fetchFilteredProducts(url, true);
        });


        /*Function to update the URL based on filters*/
        function updateURL() {
            //const filterParams = [];
            const filterParams = ['filter=1'];
            $.each(filters, function(attributeSlug, valueSlugs) {
                filterParams.push(attributeSlug + '=' + valueSlugs.join(','));
            });

            let queryString = filterParams.join('&');
            let urlParams = new URLSearchParams(window.location.search);
            const sortParam = urlParams.get('sort');
            if (sortParam) {
                queryString += (queryString ? '&' : '') + 'sort=' + sortParam;
            }

            let url = '{{ route("categories", [$category->slug]) }}';
            if (queryString) url += '?' + queryString;
            window.history.replaceState({}, '', url);
            fetchFilteredProducts(url, false);
        }

        /*Function to fetch filtered or sorted products via AJAX*/
        function fetchFilteredProducts(url, append = false) {
            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    // alert(response.hasMore);
                    if (append) {
                        $('#load-more-append').append(response.products);
                    } else {
                        $('#product-catalog-frontend').html(response.products);
                        currentPage = 1;
                    }
                    if (!response.hasMore) {
                        $('#load-more').hide();
                    } else {
                        $('#load-more').show();
                    }
                    feather.replace();
                    hideLoader();
                },
                error: function(xhr) {
                    console.error('Error fetching products:', xhr.responseText);
                    hideLoader();
                }
            });
        }

        /*Show loader*/
        function showLoader() {
            $('#loader').show();
        }

        /*Hide loader*/
        function hideLoader() {
            $('#loader').hide();
        }
        feather.replace();
    });
</script>
@endpush