<div class="show-button filter-bar">
    <div class="top-filter-menu">
        <div class="filter-button-group d-lg-none">
            <div class="filter-button d-inline-block d-lg-none1">
                <a><i class="fa-solid fa-filter"></i> Filter</a>
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
            if (request()->has('filter')) {
                $queryParams = request()->query();
                foreach ($queryParams as $attributeSlug => $valueSlugs) {
                    /*Skip special parameters*/
                    if (in_array($attributeSlug, ['filter', 'sort', 'page', 'load_more']))
                    {
                        continue;
                    }
                    if (is_string($valueSlugs)) {
                        $selectedFilters[$attributeSlug] = explode(',', $valueSlugs);
                    } else {
                        $selectedFilters[$attributeSlug] = (array)$valueSlugs;
                    }
                }
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
    <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-2 product-list-section" id="load-more-append-flash-deal">
        @include('frontend.pages.partials.ajax-flash-sale-load-more', [$products])
    </div>
@else
    <p>No products found.</p>
@endif