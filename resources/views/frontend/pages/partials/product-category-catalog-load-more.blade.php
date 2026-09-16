@if (isset($products) && $products->isNotEmpty())
@php
    $customerId = auth('customer')->id();
    $wishlistProductIds = \App\Models\Wishlist::where('customer_id', $customerId)
    ->pluck('product_id')
    ->toArray();
@endphp

    @foreach($products as $product)
        @php
            $firstImage = $product->images->get(0);
            $firstImageExists = false;
            if ($firstImage && !empty($firstImage->image_path)) {
                $firstImageExists = file_exists(
                    public_path('images/product/thumb/' . $firstImage->image_path)
                );
            }
        @endphp
        @php
            $attributes_value ='na';
            if($product->ProductAttributesValues->isNotEmpty()){
                $attributes_value = $product->ProductAttributesValues->first()->attributeValue->slug;
            }
        @endphp
        @php
            $offer_rate = $product->offer_rate;
            $display_price = $product->display_price ?? $offer_rate;
            $mrp = $product->mrp;

            /*Discount Percentage*/
            $discountPercentage = ($mrp > 0 && $display_price > 0)
            ? round((($mrp - $display_price) / $mrp) * 100, 2)
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
                            <span class="group/badge relative inline-flex items-center gap-1 bg-green-700 text-white text-[10px] font-bold tracking-wide px-2 py-[3px] rounded-full cursor-default shadow-badge hover:shadow-badge-hover hover:scale-105 transition-all duration-200">
                                {{ $discountPercentage }}% OFF
                            </span>
                        </div>
                        @endif
                        <div class="product-img">
                            <a href="{{ url('products/'.$product['slug'].'/'.$attributes_value) }}">
                                @if ($firstImage && $firstImageExists)
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
                                        loading="lazy"
                                        onerror="this.outerHTML='<span class=\'text-[16px] font-semibold text-red-600 px-2 py-1 bg-red-50 rounded-lg\'>{{ucwords(strtolower($product->category->title))}}</span>'">
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
                            @if ($display_price === null)
                            <span class="theme-color">Price not available</span>
                            @else
                            <span class="theme-color">Rs. {{ $display_price }}</span>
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
@endif