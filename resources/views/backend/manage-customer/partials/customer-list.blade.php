
    @if (isset($data['customer_list']) && $data['customer_list']->count() > 0)
        <table class="table align-middle mb-0 table-hover table-centered">
            <thead class="bg-light-subtle">
                <tr>
                    <th>Sr. No.</th>
                    <th style="width: 15%;">Name</th>
                    <th>Email</th>
                    <th>Google Id</th>
                    <th style="width: 25%;">Assign Group</th>
                    <th>Total Orders</th>
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
                        @php
                            $orderCount = $customer_list_row->orders_count;

                            $badgeClass = match (true) {
                                $orderCount == 0 => 'bg-secondary',
                                $orderCount == 1 => 'bg-info text-dark',
                                $orderCount == 2 => 'bg-primary',
                                $orderCount == 3 => 'bg-warning text-dark',
                                $orderCount >= 4 => 'bg-success',
                            };
                        @endphp

                        <span class="badge {{ $badgeClass }}">
                            {{ $orderCount }}
                            {{ $orderCount == 1 ? 'Order' : 'Orders' }}
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="btn btn-soft-secondary btn-sm dropdown-toggle" 
                            data-bs-toggle="dropdown" aria-expanded="false"> Action
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer-wishlist', ['id' => $customer_list_row->id]) }}">
                                        <i class="ti ti-heart text-warning me-1"></i> View Wishlist
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer-details', ['id' => $customer_list_row->id]) }}">
                                        <i class="ti ti-info-circle text-info me-1"></i> View Details
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer-orders', ['id' => $customer_list_row->id]) }}">
                                        <i class="ti ti-shopping-cart text-success me-1"></i> View Order
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" 
                                    data-customerid="{{$customer_list_row->id}}" 
                                    data-title="Edit {{ $customer_list_row->name }}" 
                                    data-editCustomer-popup="true" 
                                    data-size="lg" 
                                    data-url="{{ route('manage-customer.edit', ['id' => $customer_list_row->id]) }}">
                                        <i class="ti ti-edit text-primary me-1"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger show_confirm_customer" 
                                    href="javascript:void(0);" 
                                    data-name="{{ $customer_list_row->name }}" 
                                    data-title="Delete {{ $customer_list_row->name }}"
                                    data-delete-url="{{ route('manage-customer.delete', $customer_list_row->id) }}">
                                        <i class="ti ti-trash me-1"></i> Delete
                                    </a>
                                </li>
                            </ul>
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