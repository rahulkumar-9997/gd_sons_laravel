@if (isset($products) && $products->isNotEmpty())
@php
    $customerId = auth('customer')->id();
    $wishlistProductIds = \App\Models\Wishlist::where('customer_id', $customerId)
    ->pluck('product_id')
    ->toArray();
@endphp

    @foreach($products as $product)
        @php
            $firstImage=$product->images->get(0);
            $secondImage = $product->images->get(1);
        @endphp
        @php
            $attributes_value ='na';
            if($product->ProductAttributesValues->isNotEmpty()){
                $attributes_value = $product->ProductAttributesValues->first()->attributeValue->slug;
            }
        @endphp
        @php
            $purchase_rate = $product->purchase_rate;
            $offer_rate = $product->offer_rate;
            $mrp = $product->mrp;
            $group_offer_rate = null;
            $special_offer_rate = null;

        /*Group price calculation*/
        if ($groupCategory && $offer_rate !== null) {
            $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
            if ($group_percentage > 0) {
                $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                $group_offer_rate = floor($group_offer_rate);
            }
        }

        /* Special offer price from array/helper*/
        if (isset($specialOffers[$product->id])) {
            $special_offer_rate = (float) $specialOffers[$product->id];
        }

        /*Select the lowest price from all available options*/
        $final_offer_rate = collect([
        $offer_rate,
        $group_offer_rate,
        $special_offer_rate
        ])->filter()->min();

        /*Discount Percentage*/
        $discountPercentage = ($mrp > 0 && $final_offer_rate > 0)
        ? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
        : 0;

        $hasDimensions =
        !empty($product->length) &&
        !empty($product->breadth) &&
        !empty($product->height) &&
        !empty($product->weight);
        $isOutOfStock = ($product->mrp > 0 && $product->stock_quantity <= 0) || !$hasDimensions;
        @endphp
        <div>
            <div class="product-box h-100 {{ $isOutOfStock ? 'out-of-stock-product' : '' }}">
                <div class="product-header">
                    <div class="product-image">
                        @if ($discountPercentage>0)
                        <div class="label-flex">
                            <div class="discount">
                                <label>
                                    Save {{ $discountPercentage }}%
                                </label>
                            </div>
                        </div>
                        @endif
                        <div class="product-img">
                            <a href="{{ url('products/'.$product['slug'].'/'.$attributes_value) }}">
                                @if ($firstImage)
                                <picture>
                                    <source
                                        media="(max-width: 767px)"
                                        srcset="{{ asset('images/product/icon/' . $firstImage->image_path) }}">
                                    <img
                                        class="img-fluid blur-up lazyload"
                                        data-src="{{ asset('images/product/thumb/' . $firstImage->image_path) }}"
                                        src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                        srcset="{{ asset('images/product/thumb/' . $firstImage->image_path) }} 600w, 
                                    {{ asset('images/product/thumb/' . $firstImage->image_path) }} 1200w"
                                        sizes="(max-width: 600px) 600px, 1200px"
                                        alt="{{ $product->title }}"
                                        title="{{ $product->title }}"
                                        loading="lazy">
                                </picture>
                                @else
                                <img
                                    class="img-fluid blur-up lazyload"
                                    src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                    alt="{{ $product->title }}"
                                    title="{{ $product->title }}"
                                    loading="lazy">
                                @endif
                            </a>

                        </div>
                        @if($isOutOfStock)
                        <ul class="product-option">
                            <li title="Out of Stock">
                                <a href="javascript:void(0)" class="out_of_stock">
                                    Out of Stock
                                </a>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="product-footer">
                    <div class="product-detail">
                        <span class="span-name">{{ucwords(strtolower($product->category->title))}}</span>
                        <a href="{{ url('products/'.$product['slug'].'/'.$attributes_value) }}">
                            <h5 class="name">{{ ucwords(strtolower($product->title)) }}</h5>
                        </a>
                        <h5 class="price">
                            @if ($final_offer_rate === null)
                            <span class="theme-color">Price not available</span>
                            @else
                            <span class="theme-color">Rs. {{ $final_offer_rate }}</span>
                            @endif

                            @if ($mrp !== null)
                            <del>Rs. {{ $mrp }}</del>
                            @endif
                        </h5>
                        <div class="add-to-cart-box bg-white">
                            <div class="cart_qty qty-box">
                                <div class="input-group bg-white">
                                    <button type="button" class="qty-left-minus bg-gray"
                                        data-type="minus" data-field="" {{ $isOutOfStock ? 'disabled' : '' }}>
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input class="form-control input-number qty-input" type="text"
                                        name="quantity" value="0" {{ $isOutOfStock ? 'disabled' : '' }}>
                                    <button type="button" class="qty-right-plus bg-gray"
                                        data-type="plus" data-field="" {{ $isOutOfStock ? 'disabled' : '' }}>
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p>No products found in this category.</p>
@endif