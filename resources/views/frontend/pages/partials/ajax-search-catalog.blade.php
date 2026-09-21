@foreach($products as $product)
@php
$firstImage = $product->images->get(0);
$secondImage = $product->images->get(1);
@endphp
@php
$attributes_value ='na';
if($product->ProductAttributesValues->isNotEmpty()){
$attributes_value = $product->ProductAttributesValues->first()->attributeValue->slug;
}
@endphp
@php
$offer_rate = $product->offer_rate;
$display_price = $product->display_price ?? null;
$mrp = $product->mrp;

$discountPercentage = ($mrp > 0 && $display_price > 0)
? round((($mrp - $display_price) / $mrp) * 100, 2)
: 0;
@endphp


<div>
    <div class="product-box-3 h-100">
        <div class="product-header">
            <div class="product-image">
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
                        src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                        class="img-fluid blur-up lazyload"
                        alt="{{ $product->title }}"
                        loading="lazy">
                    @endif
                </a>
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
                    <span class="theme-color">Rs. {{ number_format($display_price, 2) }}</span>
                    @if($discountPercentage > 0)
                    <span class="offer theme-color">({{ $discountPercentage }}% OFF)</span>
                    @endif
                    @endif

                    @if ($mrp)
                    <br><del>Rs. {{ number_format($mrp, 2) }}</del>
                    @endif
                </h5>
                <div class="add-to-cart-box bg-white">

                    <div class="cart_qty qty-box">
                        <div class="input-group bg-white">
                            <button type="button" class="qty-left-minus bg-gray"
                                data-type="minus" data-field="">
                                <i class="fa fa-minus"></i>
                            </button>
                            <input class="form-control input-number qty-input" type="text"
                                name="quantity" value="0">
                            <button type="button" class="qty-right-plus bg-gray"
                                data-type="plus" data-field="">
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