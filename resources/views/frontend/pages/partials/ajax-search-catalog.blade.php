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
<div>
    <div class="product-box-3 h-100">
        <div class="product-header">
            <div class="product-image">
                <a href="{{ url('products/'.$product['slug'].'/'.$attributes_value) }}">
                    @if ($firstImage)
                    <img
                        class="img-fluid blur-up lazyload"
                        data-src="{{ asset('images/product/thumb/'. $firstImage->image_path) }}"
                        src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                        srcset="{{ asset('images/product/thumb/'. $firstImage->image_path) }} 600w, {{ asset('images/product/thumb/'. $firstImage->image_path) }} 1200w"
                        sizes="(max-width: 600px) 600px, 1200px"
                        alt="{{ $product->title }}"
                        title="{{ $product->title }}"
                        loading="lazy">
                    @else
                    <img src="{{asset('frontend/assets/gd-img/product/no-image.png')}}"
                        class="img-fluid blur-up lazyload" alt="{{ $product->title }}" loading="lazy">
                    @endif

                </a>
                <!--<ul class="product-option">
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                        <a href="javascript:void(0)" data-url="{{route('quick.view')}}" data-product-id="{{$product->id}}" class="quick-view">
                        <i data-feather="eye"></i>
                        </a>
                    </li>
                    @if (auth()->guard('customer')->check())
                    @php
                    $customerId = auth('customer')->id();
                    $isInWishlist = \App\Models\Wishlist::where('customer_id', $customerId)->where('product_id', $product->id)->exists();
                    @endphp
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                        <a href="javascript:void(0)"
                            class="addwishlist {{ $isInWishlist ? 'added-to-wishlist' : '' }}"
                            data-pid="{{ $product->id }}"
                            data-url="{{ route('wishlist.add') }}"
                            data-cuid="{{ $customerId }}">
                            @if ($isInWishlist)
                            <i class="feather-icon heart-icon filled" data-feather="heart"></i>
                            @else
                            <i class="feather-icon heart-icon" data-feather="heart"></i>
                            @endif
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
                    @if($discountPercentage > 0)
                    <span class="offer theme-color">({{ $discountPercentage }}% OFF)</span>
                    @endif
                    @endif

                    @if ($mrp)
                    <br><del>Rs. {{ $mrp }}</del>
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