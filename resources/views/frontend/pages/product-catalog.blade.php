@extends('frontend.layouts.master')
@if($primary_category)
    @section('title', 'Complete Range of ' . $primary_category->title . ' in Varanasi.')
@else
    @section('title', 'Complete Range of ' . $category->title . ' ' . $attributeValue->name . ' in Varanasi.')
@endif
@section('description', 'GD Sons - ' . $category->title . ' : ' . $attributeValue->name)
@section('keywords', 'GD Sons - ' . $category->title . ' : ' . $attributeValue->name)
@section('main-content')

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <!-- <h2>{{ $category->title }} : {{ $attributeValue->name }}</h2> -->
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    Home 
                                    <!-- {{ url()->current() }} -->
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $category->title }} : {{ $attributeValue->name }}
                            </li>
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
                            Complete Range of {{ $attributeValue->name }} {{ $category->title }} in Varanasi.
                        </h1>
                    @endif
                </div>
            </div>
        </div>
        <div class="row" id="product-catalog-frontend">
            @include('frontend.pages.ajax-product-catalog', [$products, $attributes_with_values_for_filter_list])
        </div>
    </div>
</section>
<!-- Shop Section End -->
@endsection
@push('scripts')
<script src="{{asset('frontend/assets/js/ion.rangeSlider.min.js')}}"></script>
<!-- <script src="{{asset('frontend/assets/js/pages/load-more.js')}}"></script> -->
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
            $('.filter-checkbox').prop('checked', false);
            const url = '{{ route("kitchen.catalog", [$category->slug, $attribute_top->slug, $attributeValue->slug]) }}';
            window.history.replaceState({}, '', url);
            fetchFilteredProducts(url, false); // Reset products
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
            const filterParams = [];
            $.each(filters, function(attributeSlug, valueSlugs) {
                filterParams.push(attributeSlug + '=' + valueSlugs.join(','));
            });

            let queryString = filterParams.join('&');
            let urlParams = new URLSearchParams(window.location.search);
            const sortParam = urlParams.get('sort');
            if (sortParam) {
                queryString += (queryString ? '&' : '') + 'sort=' + sortParam;
            }

            let url = '{{ route("kitchen.catalog", [$category->slug, $attribute_top->slug, $attributeValue->slug]) }}';
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