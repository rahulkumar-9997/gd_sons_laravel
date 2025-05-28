@php
$customerId = auth('customer')->id();
$wishlistProductIds = \App\Models\Wishlist::where('customer_id', $customerId)
->pluck('product_id')
->toArray();
@endphp
@foreach($products as $product)
@php
$firstImage = $product->images->get(0);
$secondImage = $product->images->get(1);
$attributes_value ='na';
if($product->ProductAttributesValues->isNotEmpty()){
$attributes_value = $product->ProductAttributesValues->first()->attributeValue->slug;
}
$purchase_rate = $product->purchase_rate;
$offer_rate = $product->offer_rate;
$mrp = $product->mrp;
$group_offer_rate = null;
$special_offer_rate = null;

/* Group price calculation*/
if ($groupCategory && $offer_rate !== null) {
$group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
if ($group_percentage > 0) {
$group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
$group_offer_rate = floor($group_offer_rate);
}
}

/* Special offer (from array) */
if (isset($specialOffers[$product->id])) {
$special_offer_rate = (float) $specialOffers[$product->id];
}

/* Final price: lowest among all available */
$final_offer_rate = collect([
$offer_rate,
$group_offer_rate,
$special_offer_rate
])->filter()->min();

/* Discount calculation */
$discountPercentage = ($mrp > 0 && $final_offer_rate > 0)
? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
: 0;
@endphp
<div>
    <div class="product-box h-100">
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

                <!--<ul class="product-option">
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                        <a href="javascript:void(0)" data-url="{{route('quick.view')}}" data-product-id="{{$product->id}}" class="quick-view">
                            <i data-feather="eye"></i>
                        </a>
                    </li>
                    @if (auth()->guard('customer')->check())
                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                            <a href="javascript:void(0)" 
                                class="addwishlist {{ in_array($product->id, $wishlistProductIds) ? 'added-to-wishlist' : '' }}" 
                                data-pid="{{ $product->id }}" 
                                data-url="{{ route('wishlist.add') }}" 
                                data-cuid="{{ $customerId }}">
                                <i class="feather-icon heart-icon {{ in_array($product->id, $wishlistProductIds) ? 'filled' : '' }}" data-feather="heart"></i>
                            </a>
                        </li>
                    @else
                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                            <a href="{{ route('logincustomer') }}?redirect={{ url()->current() }}" class="addwishlist-le" data-pid="{{ $product->id }}">
                                <i data-feather="heart"></i>
                            </a>
                        </li>
                    @endif
                </ul>-->
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