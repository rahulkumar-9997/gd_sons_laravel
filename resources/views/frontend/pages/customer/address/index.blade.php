@extends('frontend.layouts.master')
@section('title','GD Sons :: My Address')
@section('description', 'GD Sons My Address')
@section('keywords', 'GD Sons My Address')
@push('styles')
<style>
    /* .user-dashboard-section .dashboard-left-sidebar .profile-box .profile-contain .profile-image {
    position: relative; 
    display: inline-block; 
} */
    .user-dashboard-section .dashboard-left-sidebar .profile-box .profile-contain .profile-image .spinner {
        position: absolute;
        top: 0%;
        left: 30%;
        transform: translate(-50%, -50%);
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: calc(93px + 15*(100vw - 320px) / 1600);
        height: calc(93px + 15*(100vw - 320px) / 1600);
        animation: spin 2s linear infinite;
        z-index: 10;
        display: none;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
@section('main-content')
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{URL::to('')}}">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('myaccount')}}">
                                    My Account
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Manage Addresses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- User Dashboard Section Start -->
<section class="user-dashboard-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row">
            @include('frontend.pages.customer.common.customer-menu')
            <div class="col-xxl-9 col-lg-8">
                <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                    Menu</button>
                <div class="dashboard-right-sidebar">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order" role="tabpanel">

                            <div class="dashboard-address">
                                <div class="title title-flex">
                                    <div>
                                        <h2>Manage Addresses</h2>
                                        <span class="title-leaf">
                                            <!-- <svg class="icon-width bg-gray">
                                                <use xlink:href="{{asset('images/leaf.svg#leaf')}}"></use>
                                            </svg> -->
                                        </span>
                                    </div>
                                    <button 
                                        class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3" 
                                        id="add-new-address">
                                        <i data-feather="plus" class="me-2"></i>
                                        Add New Address
                                    </button>
                                </div>
                                <div class="row g-sm-4 g-3">
                                    <div class="col-lg-12">
                                        <div class="account-address" class="account-address" id="addAddressFormContainer" style="display: none; transition: all 0.3s ease;">
                                            <div class="child-address">
                                                <form method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="addAddressFormAccount">
                                                @csrf
                                                <input type="hidden" id="address_id" name="address_id">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" class="form-control" name="full_name" placeholder="Enter full name" value="{{Auth::guard('customer')->user()->name }}">
                                                                <label for="fname">Enter full name</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, " ")"=""
                                                                value="{{Auth::guard('customer')->user()->phone_number }}">
                                                                <label for="lname">Enter phone number</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="select-option">
                                                                <div class="form-floating theme-form-floating mb-4 ">
                                                                    <select class="form-select theme-form-select" name="country">
                                                                        <option value="India">India
                                                                        </option>
                                                                    </select>
                                                                    <label>Select Country</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" name="pin_code" class="form-control" placeholder="Enter pin code" id="checkout_pincode_add_new_address">
                                                                <label for="lname">Enter pin code</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" class="form-control" name="full_address" placeholder="Enter address">
                                                                <label for="lname">Enter address</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" class="form-control" name="apartment" placeholder="Apartment, suite, etc. (optional)">
                                                                <label for="lname">Apartment, suite, etc. (optional)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" class="form-control" name="city_name" placeholder="Enter city" readonly>
                                                                <label for="lname">Enter city</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-4 theme-form-floating">
                                                                <input type="text" class="form-control" name="state" placeholder="Enter state" readonly>
                                                                <label for="lname" readonly>Enter state</label>
                                                            </div>
                                                            <!-- <div class="select-option">
                                                                <div class="form-floating theme-form-floating mb-4 ">
                                                                    <select class="form-select theme-form-select" name="state">
                                                                        <option value="Uttar Pradesh">Uttar Pradesh
                                                                        </option>
                                                                    </select>
                                                                    <label>Select State</label>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-md close-form">Close</button>
                                                        <button type="submit" class="btn theme-bg-color btn-md text-white">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-sm-4 g-3">
                                    @include('frontend.pages.customer.address.partials.address-list', ['address' => $address])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- User Dashboard Section End -->
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('frontend/assets/js/pages/customer.js')}}"></script>
<script>
    const routes = {
        storeAddress: "{{ route('address.store') }}",
        editAddress: "{{ route('address.edit', ':id') }}",
        updateAddress: "{{ route('address.update', ':id') }}"
    };
    window.shiprocketCheckLocalityUrl = "{{ route('ajax.check-shiprocket-locality-details') }}";
</script>
<script src="{{asset('frontend/assets/js/pages/customer-address.js') }}"></script>
<script src="{{asset('frontend/assets/js/pages/shiprocket_serviceability_check.js')}}?={{ time() }}"></script>
<script>
   $(document).ready(function () {
        $('#add-new-address').on('click', function () {
            const $formContainer = $('#addAddressFormContainer');
            $formContainer.toggle();
        });
        $(document).on('click', '.close-form', function () {
            $('#addAddressFormContainer').hide();
        });
    });
</script>
@endpush