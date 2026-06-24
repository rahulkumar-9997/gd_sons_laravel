<div class="col-custom-3">
    <div class="left-box">
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
                            <span>{{ $attributes->title}} </span>
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
    @if(!empty($additionalFilters) && count($additionalFilters) > 0)
        @php
            $buttons = [];
            $currentFilters = request()->query();
            foreach ($additionalFilters as $filter) {
                $attributeData = [];
                if(isset($filter['filter_attributes'])) {
                    foreach ($filter['filter_attributes'] as $filterAttribute) {
                        $attributeSlug = $filterAttribute['attribute_slug'];
                        $valueSlugs = [];
                        foreach ($filterAttribute['filter_attributes_value'] as $attributeValue) {
                            $valueSlugs[] = $attributeValue['slug'];
                        }
                        $attributeData[] = [
                            'attribute_slug' => $attributeSlug,
                            'value_slugs'    => $valueSlugs,
                        ];
                    }
                }
                $isSelected = false;
                foreach ($attributeData as $attribute) {
                    $attributeSlug = $attribute['attribute_slug'];
                    $valueSlugs = $attribute['value_slugs'];
                    if(isset($currentFilters[$attributeSlug])) {
                        $selectedValues =
                            is_array($currentFilters[$attributeSlug])
                            ? $currentFilters[$attributeSlug]
                            : explode(',', $currentFilters[$attributeSlug]);
                        $matchedValues = array_intersect(
                            $selectedValues,
                            $valueSlugs
                        );
                        if(count($matchedValues) === count($valueSlugs)) {
                            $isSelected = true;
                        }
                    }
                }
                $buttons[] = [
                    'filter_button_name' => $filter['filter_button_name'],
                    'attribute_data'     => $attributeData,
                    'is_selected'        => $isSelected,
                ];
            }
        @endphp
        <div class="additional-filter-section mb-2">
            <div class="bg-white p-2 overflow-x-auto">
                <div class="flex items-center gap-2 whitespace-nowrap">
                    @foreach($buttons as $filter)
                        <button type="button"class="additional-filter-btn inline-flex items-center gap-1.5 px-3 py-3.5 rounded-full text-[16px] transition-all duration-150 cursor-pointer flex-shrink-0 border-[1px] font-medium
                        {{ $filter['is_selected'] 
                            ? 'active bg-[#117174] text-white border-[#117174]' 
                            : 'border-[#0F8B8D] text-primary-navy bg-gray hover:border-[#117174] hover:text-[#117174]' 
                        }}" data-filters='@json($filter['attribute_data'])'
                        >
                            <span class="leading-none">
                                {{ $filter['filter_button_name'] }}
                            </span>
                            @if($filter['is_selected'])
                                <span class="remove-icon flex items-center justify-center ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-3.5 h-3.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="show-button filter-bar">
        <div class="top-filter-menu">
            <div class="filter-button-group d-lg-none">
                <div class="filter-button d-inline-block d-lg-none1">
                    <a><i class="fa-solid fa-filter"></i> Filter</a>
                </div>
            </div>
            <div class="category-dropdown">
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
                <div class="px-2 py-1.5 text-[16px] font-medium ml-2">
                    <span class="font-semibold">
                        {{ $total_count ?? $products->total() }}
                    </span>
                    Products
                </div>
            </div>
            @php
                use App\Models\Attribute_values;
                $selectedFilters = [];
                if (request()->has('filter')) {
                    $queryParams = request()->query();
                    foreach ($queryParams as $attributeSlug => $valueSlugs) {
                        /* Skip special parameters */
                        if (in_array($attributeSlug, ['filter', 'sort', 'page', 'load_more'])) {
                            continue;
                        }
                        if (is_string($valueSlugs)) {
                            $valueSlugs = explode(',', $valueSlugs);
                        }
                        foreach ($valueSlugs as $slug) {
                            $attributeValue = Attribute_values::where('slug', $slug)->first();
                            $selectedFilters[$attributeSlug][] = [
                                'slug'  => $slug,
                                'title' => $attributeValue->name ?? ucfirst(str_replace('-', ' ', $slug)),
                            ];
                        }
                    }
                }
            @endphp
            @if (!empty($selectedFilters))
                <div class="filter-category filter-bar-desktop secondary-bar">
                    <ul>
                        @foreach ($selectedFilters as $attributeSlug => $values)
                            @foreach ($values as $value)
                            <li class="filter-item remove-filter rounded-full text-sm border bg-gray-50 border-gray-50"
                                data-att-slug="{{ $attributeSlug }}"
                                data-value-slug="{{ $value['slug'] }}">
                                <span>{{ $value['title'] }}</span>
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
    <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-2 product-list-section" id="load-more-append">
        @include('frontend.pages.partials.product-category-catalog-load-more', [$products])
    </div>
    @if ($products->hasMorePages())
    <div id="load-more-trigger"
        data-current-page="{{ $products->currentPage() }}"
        data-last-page="{{ $products->lastPage() }}">
    </div>
    @endif
    <div id="loading" style="display:none;text-align:center;margin:20px;">
        <strong>Loading...</strong>
    </div>
    @endif
</div>