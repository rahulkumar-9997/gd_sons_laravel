@if(isset($data['product_list']) && $data['product_list']->count() > 0)
    <table id="example-2" class="table align-middle mb-0 table-hover table-centered">
        <thead class="bg-light-subtle">
            <tr>
                <th>No.</th>
                <th style="width: 20%;">Name</th>
                <th>HSN Code</th>
                <!-- <th>Image</th> -->
                <th>Status</th>
                <th>Category</th>
                <!--<th>Created Date</th>
                <th>Attributes</th>-->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sr_no = 1;
            @endphp
            @foreach($data['product_list'] as $product)
                <tr class="product-row">
                    <td>{{ $sr_no++ }}</td>
                    <td>
                        {{ ucwords(strtolower($product->title)) }}
                    </td>
                    <td>
                        {{ $product->hsn_code??'Null' }}
                    </td>
                    <!-- <td>
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('images/product/thumb/' . $product->images[0]->image_path) }}" class="img-thumbnail" style="width: 70px; height: 70px;" alt="{{ $product->title }}">
                        @else
                            <span>No images.</span>
                        @endif
                        
                    </td> -->
                    <td>
                        <span class="badge {{ $product->product_status === 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $product->product_status === 1 ? 'Published' : 'Not Published' }}
                        </span>
                    </td>
                    <td>{{ $product->category->title ?? 'No Category' }}</td>
                    <!--<td><span class="text-success">{{ $product->created_at->toFormattedDateString() }}</span></td>-->

                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.show', $product->id) }}" data-bs-original-title="View Product" data-bs-toggle="tooltip" class="btn btn-soft-primary btn-sm"><i class="ti ti-eye"></i></a>
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-soft-primary btn-sm" data-bs-original-title="Edit Product" data-bs-toggle="tooltip"><i class="ti ti-pencil"></i></a>
                            <a href="javascript:void(0)" data-ajax-popup-modal="true" data-size="lg" data-title=" Add Inventory" data-pid="{{$product->id}}" data-url="{{route('manage-inventory.create')}}" data-bs-toggle="tooltip" class="btn btn-sm btn-primary" data-bs-original-title=" Add Inventory">
                                Add Inventory
                            </a>
                            
                            <!-- Only show the "View Inventory" button if there are inventories -->
                            @if($product->inventories->isNotEmpty())
                            @php
                                $totalPurchaseLineCount = $product->inventories->sum(function ($inventory) {
                                    return $inventory->purchase_line_count;
                                });

                                if ($totalPurchaseLineCount > 0) {
                                    $mapped = '<span class="badge bg-primary ms-1">' . $totalPurchaseLineCount . '</span>';
                                } else {
                                    $mapped = '';
                                }
                            @endphp

                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#inventory-{{$product->id}}" aria-expanded="false" aria-controls="inventory-{{$product->id}}">
                                View Inventory {!! $mapped !!}
                            </button>
                                
                            @endif
                        </div>
                    </td>
                </tr>
                <tr id="inventory-{{$product->id}}" class="collapse">
                    <td colspan="7">
                        <div class="table-responsive">
                            <table class="table table-borderless table-centered">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>MRP</th>
                                        <th>Purchase Rate</th>
                                        <th>Offer Rate</th>
                                        <th>Stock Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($product->inventories->isNotEmpty())
                                    @php 
                                        $sr_no_inventory = 1;
                                    @endphp
                                        @foreach($product->inventories as $inventory)
                                        <tr data-id="{{ $inventory->id }}">
                                            <td>{{$sr_no_inventory}}</td>
                                            <td class="editable-field" data-field="mrp" data-id="{{ $inventory->id }}">
                                                <span class="current-value"><strong>Rs. </strong> {{ $inventory->mrp }}</span>
                                                <input type="number" class="edit-input form-control" value="{{ $inventory->mrp }}" data-field="mrp" style="display:none;">
                                            </td>
                                            <td class="editable-field" data-field="purchase_rate" data-id="{{ $inventory->id }}">
                                                <span class="current-value"><strong>Rs. </strong> {{ $inventory->purchase_rate }}</span>
                                                <input type="number" class="edit-input form-control" data-field="purchase_rate" value="{{ $inventory->purchase_rate }}" style="display:none;">
                                            </td>
                                            <td class="editable-field" data-field="offer_rate" data-id="{{ $inventory->id }}">
                                                <span class="current-value"><strong>Rs. </strong> {{ $inventory->offer_rate }}</span>
                                                <input type="number" class="edit-input form-control" data-field="offer_rate" value="{{ $inventory->offer_rate }}" style="display:none;">
                                            </td>
                                            <td class="editable-field" data-field="stock_quantity" data-id="{{ $inventory->id }}">
                                                @if($inventory->purchase_line_count > 0)
                                                    <a href="javascript:void(0)"
                                                        data-pid="{{$product->id}}"
                                                        data-title="See inventory with vendor purchase lines"
                                                        data-size="lg"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="This product inventory is mapped to {{ $inventory->purchase_line_count }} purchase line's."
                                                     >
                                                        <span class="current-value">
                                                            {{  $inventory->stock_quantity }}
                                                            <span class="badge bg-warning">
                                                            {{ $inventory->purchase_line_count }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                @else
                                                    <span class="current-value">{{ $inventory->stock_quantity }}</span>
                                                @endif
                                                
                                                <input type="number" class="edit-input form-control" value="{{ $inventory->stock_quantity }}" data-field="stock_quantity" style="display:none;">
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning edit-inventory-btn" data-inventoryid="{{ $inventory->id }}"  data-bs-original-title="Edit Inventory" data-bs-toggle="tooltip">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                                
                                                <button class="btn btn-sm btn-primary save-inventory-btn" data-inventoryid="{{ $inventory->id }}" data-productid="{{ $product->id }}" style="display:none;">Update</button>
                                                <button class="btn btn-sm btn-secondary cancel-inventory-btn" data-inventoryid="{{ $inventory->id }}" style="display:none;">Cancel</button>
                                                <button class="btn btn-sm btn-danger delete-inventory-btn" data-inventoryid="{{ $inventory->id }}"  data-bs-original-title="Delete Inventory" data-bs-toggle="tooltip" data-name="{{ $inventory->sku }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                            @php 
                                                $sr_no_inventory++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No inventory found for this product.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No products found in this category.</p>
@endif

<div class="my-pagination" id="pagination-links">
    {{ $data['product_list']->links('vendor.pagination.bootstrap-4') }}
</div>
