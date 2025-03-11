
    @if (isset($data['customer_list']) && $data['customer_list']->count() > 0)
        <table class="table align-middle mb-0 table-hover table-centered">
            <thead class="bg-light-subtle">
                <tr>
                    <th>Sr. No.</th>
                    <th style="width: 15%;">Name</th>
                    <th>Email</th>
                    <th>Google Id</th>
                    <th style="width: 25%;">Assign Group</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $sr_no = 1;
                @endphp
                @foreach($data['customer_list'] as $customer_list_row)
                <tr>
                    <td>
                        {{ $sr_no }}
                    </td>
                    <td>
                        {{ $customer_list_row->name }}
                        <br><span class="text-success">
                            {{ $customer_list_row->created_at->format('d F Y') }}
                        </span>
                        
                    </td>
                    <td>
                        {{ $customer_list_row->email }}
                        <br>
                        <strong>Phone No. </strong> {{$customer_list_row->phone_number}}
                    </td>
                    <td>
                        {{ $customer_list_row->google_id }}
                    </td>
                    <td>
                        @if (isset($data['category_group']) && $data['category_group']->count() > 0)
                            <select class="form-control" 
                                id="group_category_id-{{$customer_list_row->id}}" 
                                name="group_category_id"
                                data-url="{{ route('update-customer-group') }}" 
                                onchange="updateCustomerGroup(this)">
                                <option value="">Choose a group category</option>
                                @foreach ($data['category_group'] as $category)
                                    <!-- Optgroup label with comma-separated group names -->
                                    <optgroup label="{{$category->name}} - {{ implode(', ', $category->groups->pluck('name')->toArray()) }} ">
                                        @if ($category->groups->isNotEmpty())
                                            @foreach ($category->groups as $group)
                                                <option 
                                                    value="{{ $group->id }}"
                                                    {{ $customer_list_row->group_id == $group->id ? 'selected' : '' }}>
                                                    {{ $group->name }} - {{ $category->group_category_percentage }}%
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>No groups available</option>
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                        @endif
                        <!-- @if(!empty($customer_list_row->profile_img))
                            <img src="{{ asset('images/customer/'. $customer_list_row->profile_img) }}" class="img-thumbnail" style="width: 50px;">
                        @endif -->
                    </td>
                    
                    <td>
                        <div class="d-flex gap-1">
                                <a href="{{ route('customer-wishlist', ['id' => $customer_list_row->id]) }}" title="View Wishlist">
                                <span class="mb-1 mt-1 badge border border-warning text-warning py-1 px-1">
                                    View Wishlist
                                </span>
                            </a>
                            <a href="{{ route('customer-details', ['id' => $customer_list_row->id]) }}" title="View Details">
                                <span class="mb-1 mt-1 badge border border-info text-info py-1 px-1">
                                    View Details
                                </span>
                            </a>
                            <a href="{{ route('customer-orders', ['id' => $customer_list_row->id]) }}" title="View Order">
                                <span class="mb-1 mt-1 badge border border-success text-success py-1 px-1">
                                    View Order 
                                </span>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm" data-customerid="{{$customer_list_row->id}}" data-title="Edit {{ $customer_list_row->name }}" data-editCustomer-popup="true" data-size="lg" title="Edit {{ $customer_list_row->name }}" data-bs-toggle="tooltip" data-url="{{ route('manage-customer.edit', ['id' => $customer_list_row->id]) }}">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('manage-customer.delete', $customer_list_row->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                    <a href="javascript:void(0);" title="Delete {{ $customer_list_row->name }}" data-name="{{ $customer_list_row->name }}" class="show_confirm_customer btn btn-soft-danger btn-sm" data-title="Delete {{ $customer_list_row->name }}" data-bs-toggle="tooltip" >
                                    <i class="ti ti-trash"></i>
                                </a>
                            </form>
                        </div>
                    </td>
                </tr>
                @php
                $sr_no++;
                @endphp
                @endforeach
            </tbody>
        </table>
        <div class="my-pagination" id="pagination-links-customer">
            {{ $data['customer_list']->links('vendor.pagination.bootstrap-4') }}
        </div>
    @endif