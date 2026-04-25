@php
$pincode = session('user_pincode');
$couriers = $pincode ? session('courier_options_' . $pincode) : [];
@endphp

<div class="card-delivery-option p-2">
    <div class="d-flex align-items-center mb-2">
        <img src="{{ asset('frontend/assets/gd-img/van.svg') }}" width="24" class="me-2">
        <span class="fw-bold text-dark">DELIVERY OPTIONS</span>
    </div>
    @if(empty($couriers))
    <form method="post" id="check-delivery-form" action="{{ route('check.serviceability') }}">
        @csrf

        <input type="hidden" name="product_data" value='@json($product_items_for_js)'>

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
                    Delivery in {{ $cheapest['etd'] ?? 'N/A' }}
                </div>
            </div>
            <div>
                <span class="text-success fw-bold">
                    {{ $cheapest['rate'] == 0 ? 'FREE' : '₹'.$cheapest['rate'] }}
                </span>
                <div class="mt-2">
                    <button class="btn btn-sm btn-success edit-pincode" data-url="{{ route('check.serviceability.edit') }}">
                        Change Pincode
                    </button>
                </div>
            </div>
        </div>       
        
    </div>
    @endif
</div>