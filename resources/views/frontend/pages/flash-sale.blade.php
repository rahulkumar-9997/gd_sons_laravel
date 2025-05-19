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
   </div>
</section>

<!-- Shop Section End -->
@endsection
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