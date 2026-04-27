@php
    $product_id = $product_id ?? null;
    $pincode = $product_id ? session('user_pincode_' . $product_id) : null;
    $courierSession = $pincode 
        ? session('courier_options_' . $product_id . '_' . $pincode) 
        : null;
    $couriers = [];
    if ($courierSession) {
        if (now()->timestamp - ($courierSession['time'] ?? 0) <= 1200) {
            $couriers = $courierSession['data'];
            $locality = $courierSession['locality'] ?? null;
        } else {
            session()->forget('courier_options_' . $product_id . '_' . $pincode);
            session()->forget('user_pincode_' . $product_id);
        }
    }
@endphp

<div class="card-delivery-option p-1 formide">
    <div class="d-flex align-items-center mb-2">
        <img src="{{ asset('frontend/assets/gd-img/van.svg') }}" width="24" class="me-2">
        <span class="fw-bold text-dark">DELIVERY OPTIONS</span>
    </div>
    @if(empty($couriers))
    <form method="post" id="check-delivery-form" action="{{ route('check.serviceability') }}">
        @csrf
        <input type="hidden" name="product_data" value='@json($product_items_for_js ?? [])'>
        <input type="hidden" name="product_id" value="{{ $product_id ?? '' }}"/>
        <div class="input-group mb-2">
            <input type="text"
                class="form-control"
                name="pincode"
                value="{{ $pincode ?? '' }}"
                placeholder="Enter your zipcode"
                maxlength="6">
            <button class="btn btn-info border btn-check-delivery" type="submit">
                Check
            </button>
        </div>
        <div class="text-danger small" id="pin-message"></div>
    </form>
    @endif
    @if(!empty($couriers))
    @php $cheapest = $couriers[0]; @endphp
    <div class="delivery-result p-2 border rounded bg-light">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="mb-2">{{ $cheapest['courier'] }}</h4>
                <div class="delivery-time">
                    Delivery in {{ $cheapest['estimated_delivery_days'] ?? 'N/A' }}-7 business days                    
                </div>
                @if(!empty($cheapest['city']))
                <div class="delivery-city mt-1">                    
                    <strong>Delivery to : </strong>
                    {{ $cheapest['city'] ?? '' }}                    
                </div>
                @endif
            </div>
            <div>
                <span class="text-success fw-bold">
                    {{ $cheapest['rate'] == 0 ? 'FREE' : '₹'.$cheapest['rate'] }}
                </span>
                <div class="mt-2">                    
                    <form method="POST" action="{{ route('check.serviceability.edit') }}" id="check-delivery-form-edit">
                        @csrf
                        <input type="hidden" name="product_data" value='@json($product_items_for_js ?? [])'>
                        <input type="hidden" name="product_id" value="{{ $product_id ?? '' }}"/>
                        <button class="btn btn-sm btn-success border edit-delivery" type="submit">
                            Change Pincode
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>