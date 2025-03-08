
<div class="col-custom-3">
        <div class="left-box wow fadeInUp">
            <div class="shop-left-sidebar">
                <div class="back-button">
                    <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                </div>
                @if (isset($attributes_with_values_for_filter_list) && $attributes_with_values_for_filter_list->isNotEmpty())
                <div class="accordion custom-accordion" id="accordionExample">
                    @if($attributes_with_values_for_filter_list->isNotEmpty())
                    @foreach($attributes_with_values_for_filter_list as $attributes)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseFive-{{ $attributes->id}}">
                                <span>{{ $attributes->title}}</span>
                            </button>
                        </h2>
                        <div id="collapseFive-{{ $attributes->id}}" class="accordion-collapse collapse hide">
                            <div class="accordion-body">
                                <ul class="category-list custom-padding custom-height">
                                    @if ($attributes->AttributesValues->isNotEmpty())
                                    @foreach ($attributes->AttributesValues as $value)
                                    @if($value->name!=='NA')
                                    <li>
                                        <div class="form-check ps-0 m-0 category-list-box">
                                            <input class="checkbox_animated filter-checkbox" type="checkbox"
                                                data-attribute-id="{{ $attributes->id }}"
                                                data-value-id="{{ $value->id }}"
                                                data-attslug="{{ $attributes->slug }}"
                                                data-attvslug="{{ $value->slug }}"
                                                value="{{ $value->name }}" id="check_{{ $value->id }}"
                                                @if(in_array($value->slug, explode(',', request()->query($attributes->slug, '')))) checked @endif
                                            >
                                            <label class="form-check-label" for="flexCheckDefault5">
                                                <span class="name">{{ $value->name ?? 'Unnamed Value' }}</span>
                                                <!-- <span class="number">({{$value->product_attributes_values_count}})</span> -->
                                            </label>
                                        </div>
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-custom-">
        
        <div class="show-button filter-bar">
            <div class="top-filter-menu">
                <div class="filter-button-group d-lg-none">
                    <div class="filter-button d-inline-block d-lg-none1">
                        <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                    </div>
                </div>
                <div class="category-dropdown" style="margin-left: auto !important;">
                    <h5 class="text-content">Sort By :</h5>
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                            <span>{{ request('sort', 'Most Popular') }}</span> <i class="fa-solid fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" data-sortid="new-arrivals" href="javascript:void(0)">New Arrivals</a>
                            </li>
                            <li>
                                <a class="dropdown-item" data-sortid="price-low-to-high" href="javascript:void(0)">Price Low To High</a>
                            </li>
                            <li>
                                <a class="dropdown-item" data-sortid="price-high-to-low" href="javascript:void(0)">Price High To Low</a>
                            </li>
                            <li>
                                <a class="dropdown-item" data-sortid="a-to-z-order" href="javascript:void(0)">A - Z Order</a>
                            </li>
                        </ul>
                    </div>
                </div>
                @php
                    $selectedFilters = [];
                    $queryParams = request()->query();
                    foreach ($queryParams as $attributeSlug => $valueSlugs) {
                        $selectedFilters[$attributeSlug] = explode(',', $valueSlugs);
                    }
                @endphp
                @if (!empty($selectedFilters))
                    <div class="filter-category filter-bar-desktop secondary-bar">
                        <ul>
                        @foreach ($selectedFilters as $attributeSlug => $valueSlugs)
                            @foreach ($valueSlugs as $valueSlug)
                                <li class="filter-item remove-filter" data-att-slug="{{ $attributeSlug }}" data-value-slug="{{ $valueSlug }}">
                                    <span>{{ ucfirst(strtolower((str_replace('-', ' ', $valueSlug)))) }}</span>
                                </li>
                            @endforeach
                        @endforeach
                        </ul>
                        <div class="filter-title">
                            <a href="javascript:void(0)" id="clear-filters">Clear All</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        @if (isset($products) && $products->isNotEmpty())
        
            <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-3 row-cols-2 product-list-section" id="load-more-append">
                @include('frontend.pages.partials.product-category-catalog-load-more', [$products])
            </div>
            @if ($products->hasMorePages())
                <div
                    class="show-more-products d-flex justify-content-center">
                    <button id="load-more" class="btn text-white theme-bg-color btn-md mt-sm-4 mt-3 fw-bold" data-next-page="{{ $products->currentPage() + 1 }}" data-last-page="{{ $products->lastPage() }}">
                        Load More
                    </button>
                </div>
            @endif
        @else
            <p>No products found in this category.</p>
        @endif
    </div>