@extends('frontend.layouts.master')
@section('title','Flash Sale | Best Kitchenware Deals Online – Girdhar Das & Sons, Varanasi')
@section('description', 'Enjoy unbeatable discounts on top kitchenware brands during our Flash Sale at Girdhar Das & Sons – the Best Retail Shop in Varanasi. Great offers, fast delivery & store pickup available!')
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
                  Flash Sale on Best Kitchenware in Varanasi
               </h1>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-custom-3">
            <div class="left-box">
               <div class="shop-left-sidebar">
                  <div class="back-button">
                     <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                  </div>
                  @if (!empty($attributes_with_values_for_filter_list))
                  <div class="accordion custom-accordion" id="accordionExample">
                     @foreach ($attributes_with_values_for_filter_list as $attrId => $attribute)
                     @if (!empty($attribute['values']))
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ $attrId }}">
                           <button class="accordion-button collapsed" type="button"
                              data-bs-toggle="collapse" data-bs-target="#collapse-{{ $attrId }}">
                              <span>{{ $attribute['attribute_title'] }}</span>
                           </button>
                        </h2>
                        <div id="collapse-{{ $attrId }}" class="accordion-collapse collapse hide">
                           <div class="accordion-body">
                              <ul class="category-list custom-padding custom-height">
                                 @foreach ($attribute['values'] as $value)
                                 @if (!empty($value['name']) && $value['name'] !== 'NA')
                                 <li>
                                    <div class="form-check ps-0 m-0 category-list-box">
                                       <input class="checkbox_animated filter-checkbox" type="checkbox"
                                          data-attribute-id="{{ $attrId }}"
                                          data-value-id="{{ $value['id'] }}"
                                          data-attslug="{{ $attribute['attribute_slug'] }}"
                                          data-attvslug="{{ $value['slug'] }}"
                                          value="{{ $value['name'] }}"
                                          id="check_{{ $value['id'] }}"
                                          @if(in_array($value['slug'], explode(',', request()->query($attribute['attribute_slug'], '')))) checked @endif
                                       >
                                       <label class="form-check-label" for="check_{{ $value['id'] }}">
                                          <span class="name">{{ $value['name'] }}</span>
                                       </label>
                                    </div>
                                 </li>
                                 @endif
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                     </div>
                     @endif
                     @endforeach
                  </div>
                  @endif


               </div>
            </div>
         </div>
         <div class="col-custom-" id="product-listing-container-flash-deal">
            @include('frontend.pages.ajax-flash-deal', [
            'products' => $products,
            ])
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <div class="flash-content">
               <h3>Unmissable Flash Sale on Premium Kitchenware!</h3>
               <p>
                  Welcome to the Flash Sale section at Girdhar Das & Sons – your one-stop destination for unbeatable deals on top-quality kitchen essentials. Whether you're upgrading your cooking setup or gifting something useful to loved ones, this is the perfect time to shop. From advanced induction cooktops and stylish gas stoves to high-performance chimneys and kitchen tools, everything is available at jaw-dropping prices for a limited time only.
               </p>
               <h4>Great Offers, Limited Stock – Act Fast!</h4>
               <p>
                  At Girdhar Das & Sons, we believe in delivering not just products, but value. That’s why our flash sale includes top brands like Milton, Hindware, and Sujata – trusted by thousands of Indian households. Enjoy exclusive discounts, combo offers, and group savings that are hard to beat. With fast home delivery and store pickup options available across Varanasi, you can shop with confidence and convenience.
               </p>
               <p>
                  Don't miss this opportunity to revamp your kitchen with premium products at slashed prices. Our flash deals are updated regularly, so keep checking back for new offers before they're gone. Shop now and experience why we’re known as the Best Retail Shop in Varanasi for kitchenware!
               </p>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Shop Section End -->
@endsection
@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Flash Sale | Best Kitchenware Deals Online – Girdhar Das & Sons, Varanasi",
    "description": "Enjoy unbeatable discounts on top kitchenware brands during our Flash Sale at Girdhar Das & Sons – the Best Retail Shop in Varanasi. Great offers, fast delivery & store pickup available!",
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
                "name": "Flash Sale",
                "item": "{{ url()->current() }}"
            }
        ]
    },
    "mainEntity": {
        "@type": "ItemList",
        "itemListElement": [
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
                "@type": "ListItem",
                "position": "{{ $loop->iteration }}",
                "item": {
                    "@type": "Product",
                    "name": "{{ addslashes($product->title) }}",
                    "description": "{{ addslashes($product->title) }}",
                    "url": "{{ url('products/'.$product['slug'].'/'.$attributes_value) }}",
                    "brand": {
                        "@type": "Brand",
                        "name": "{{ addslashes($product->brand->title ?? 'GD Sons') }}"
                    },
                    "category": "{{ addslashes($product->category->title) }}",
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
                        "priceValidUntil": "{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}",
                        "itemCondition": "https://schema.org/NewCondition",
                        "availability": "https://schema.org/{{ $product->stock_quantity > 0 ? 'InStock' : 'OutOfStock' }}",
                        "priceSpecification": {
                            "@type": "UnitPriceSpecification",
                            "price": "{{ $final_offer_rate }}",
                            "priceCurrency": "INR",
                            "referenceQuantity": {
                                "@type": "QuantitativeValue",
                                "value": "1"
                            }
                        }
                    },
                    @if($mrp)
                    "aggregateOffer": {
                        "@type": "AggregateOffer",
                        "highPrice": "{{ $mrp }}",
                        "lowPrice": "{{ $final_offer_rate }}",
                        "offerCount": "1",
                        "priceCurrency": "INR"
                    },
                    @endif
                    "review": {
                        "@type": "Review",
                        "reviewRating": {
                            "@type": "Rating",
                            "ratingValue": "4.5",
                            "bestRating": "5"
                        },
                        "author": {
                            "@type": "Organization",
                            "name": "GD Sons"
                        }
                    }
                }
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
}
</script>
@endpush
@push('scripts')
<script>
   $(document).ready(function() {
      const filters = {};
      initializeFiltersFromUrl();
      feather.replace();
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
      $(document).on('click', '.remove-filter', function() {
         const attributeSlug = $(this).data('att-slug');
         const valueSlug = $(this).data('value-slug');
         if (filters[attributeSlug]) {
            filters[attributeSlug] = filters[attributeSlug].filter((slug) => slug !== valueSlug);
            if (filters[attributeSlug].length === 0) {
               delete filters[attributeSlug];
            }
         }

         $(`.filter-checkbox[data-attslug="${attributeSlug}"][data-attvslug="${valueSlug}"]`)
            .prop('checked', false);
         updateURL();
      });

      $(document).on('click', '#clear-filters', function() {
         for (let key in filters) {
            delete filters[key];
         }
         $('.filter-checkbox').prop('checked', false);
         let url = window.location.pathname;
         window.history.replaceState({}, '', url);
         fetchFilteredProducts(url);
      });

      /*Handle sorting*/
      $(document).on('click', '.dropdown-menu .dropdown-item', function() {
         const sortId = $(this).data('sortid');
         let urlParams = new URLSearchParams(window.location.search);
         if (sortId) {
            urlParams.set('sort', sortId);
         } else {
            urlParams.delete('sort');
         }
         const newUrl = window.location.pathname + '?' + urlParams.toString();
         window.history.replaceState({}, '', newUrl);
         $('.dropdown-toggle span').text(
            sortId ? sortId.replace(/-/g, ' ') : 'Most Popular'
         );
         fetchFilteredProducts(newUrl);
      });

      function updateURL() {
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
         let url = window.location.pathname;
         if (queryString) url += '?' + queryString;
         window.history.replaceState({}, '', url);
         fetchFilteredProducts(url);
      }

      function fetchFilteredProducts(url) {
         showLoader();
         $.ajax({
            url: url,
            method: 'GET',
            headers: {
               'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
               $('#product-listing-container-flash-deal').html(response.html);
               feather.replace();
            },
            error: function(xhr) {
               console.error('Error fetching products:', xhr.responseText);
            },
            complete: function() {
               hideLoader();
            }
         });
      }

      function initializeFiltersFromUrl() {
         const urlParams = new URLSearchParams(window.location.search);
         urlParams.forEach((value, key) => {
            if (key === 'sort') {
               $('.dropdown-toggle span').text(value.replace(/-/g, ' '));
               return;
            }
            const valueSlugs = value.split(',');
            valueSlugs.forEach(valueSlug => {
               $(`.filter-checkbox[data-attslug="${key}"][data-attvslug="${valueSlug}"]`)
                  .prop('checked', true);
               if (!filters[key]) {
                  filters[key] = [];
               }
               if (!filters[key].includes(valueSlug)) {
                  filters[key].push(valueSlug);
               }
            });
         });
      }

      function showLoader() {
         $('#loader').show();
         $('#product-listing-container-flash-deal').addClass('loading-overlay');
      }

      function hideLoader() {
         $('#loader').hide();
         $('#product-listing-container-flash-deal').removeClass('loading-overlay');
      }
   });
</script>
@endpush