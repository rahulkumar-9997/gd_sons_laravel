@if(isset($address) && $address->isNotEmpty())
@foreach($address as $addresses)
<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
    <div class="address-box">
        <div>
            <!-- <div class="label">
                                                            <label>Home</label>
                                                        </div> -->
            <div class="table-responsive address-table">
                <table class="table">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                {{$addresses->name}}
                            </td>
                        </tr>
                        <tr>
                            <td>Address :</td>
                            <td>
                                <p>
                                    {{$addresses->address}}, {{$addresses->state}} {{$addresses->city}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Pin Code :</td>
                            <td>
                                {{$addresses->zip_code}}
                            </td>
                        </tr>
                        <tr>
                            <td>Phone :</td>
                            <td>
                                {{$addresses->phone_number}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="button-group">
            <button class="btn btn-sm add-button w-100 edit-address" data-id="{{$addresses->id}}"><i data-feather="edit"></i>
                Edit</button>
            <button class="btn btn-sm add-button w-100 remove-address"
            data-url="{{ route('address.remove', ['customer_id' => $addresses->customer_id, 'address_id' => $addresses->id]) }}">
                <i data-feather="trash-2"></i>
                Remove</button>
        </div>
    </div>
</div>
@endforeach
@endif