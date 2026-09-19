@if(isset($data['product_list']) && $data['product_list']->count() > 0)
<div id="bulk-save-errors"></div>

<table id="example-2" class="table align-middle mb-0 table-hover table-centered">
    <thead class="bg-light-subtle">
        <tr>
            <th style="width: 20%;">Product</th>
            <th>MRP</th>
            <th>Purchase Rate</th>
            <th>Offer Rate</th>
            <th>Shipping</th>
            <th>Offer + Shipping</th>
            <th>Stock Qty</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['product_list'] as $product)
        @php
        $rows = $product->inventories->isEmpty() ? collect([null]) : $product->inventories->values();
        $rowCount = $rows->count();
        $gstPercent = (float) ($product->gst_in_per ?? 0);
        @endphp
        @foreach($rows as $i => $inventory)
        @php
        $preGst = ($inventory && $inventory->purchase_rate > 0)
        ? $inventory->purchase_rate / (1 + $gstPercent / 100)
        : null;
        $gstAmount = $preGst !== null ? $inventory->purchase_rate - $preGst : null;
        $netGain = $inventory ? ($inventory->offer_rate - $inventory->purchase_rate) : null;
        $netGainPerc = ($netGain !== null && $inventory->purchase_rate > 0)
        ? ($netGain / $inventory->purchase_rate) * 100
        : null;
        $isLast = $i === $rowCount - 1;
        @endphp
        <tr class="inv-row" data-product-id="{{ $product->id }}" data-gst="{{ $gstPercent }}" data-inventory-id="{{ $inventory->id ?? '' }}">
            @if($i === 0)
            <td class="product-cell" rowspan="{{ $rowCount * 2 }}" style="vertical-align: middle;">
                <a href="https://www.google.com/search?q={{ urlencode($product->title) }}&udm=2" target="_blank" class="text-primary font-normal">
                    {{ ucwords(strtolower($product->title)) }}
                </a>
                @if($product->length && $product->breadth && $product->height && $product->weight)
                <div class="mt-1 d-flex flex-wrap gap-1">
                    <span class="badge bg-light text-dark">L: {{ number_format($product->length, 1) }}cm</span>
                    <span class="badge bg-light text-dark">B: {{ number_format($product->breadth, 1) }}cm</span>
                    <span class="badge bg-light text-dark">H: {{ number_format($product->height, 1) }}cm</span>
                    <span class="badge bg-light text-dark">W: {{ number_format($product->weight, 1) }}kg</span>
                    <span class="badge bg-purple text-white">VW: {{ number_format($product->volumetric_weight_kg, 2) }}kg</span>
                </div>
                @endif
                <div class="small text-muted mt-1">GST: {{ number_format($gstPercent, 1) }}%</div>
                <div class="mt-2 d-flex flex-wrap gap-1">
                    <button type="button" class="btn btn-sm btn-success add-inv-row-btn" data-product-id="{{ $product->id }}">
                        <i class="ti ti-plus"></i> Add Rate
                    </button>
                    @if($product->length && $product->breadth && $product->height)
                    <button type="button" class="btn btn-sm btn-outline-primary auto-calc-shipping-btn"
                        data-product-id="{{ $product->id }}"
                        data-route="{{ route('manage-inventory.shipment-rate', $product->id) }}">
                        <i class="ti ti-truck"></i> Auto-calc
                    </button>
                    @endif
                </div>
            </td>
            @endif
            <td>
                <input type="number" step="1" class="form-control form-control-sm row-mrp"
                    value="{{ $inventory ? round($inventory->mrp) : '' }}" placeholder="MRP">
            </td>
            <td>
                <input type="number" step="1" class="form-control form-control-sm row-purchase-rate"
                    value="{{ $inventory ? round($inventory->purchase_rate) : '' }}" placeholder="Purchase">
            </td>
            <td>
                <input type="number" step="1" class="form-control form-control-sm row-offer-rate"
                    value="{{ $inventory ? round($inventory->offer_rate) : '' }}" placeholder="Offer">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control form-control-sm row-shipment-rate"
                    value="{{ $inventory ? $inventory->shipment_rate : '' }}" placeholder="Shipping">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control form-control-sm row-offer-shipment-rate" value="{{ $inventory ? $inventory->offer_shipment_rate : '' }}" readonly>
                <span class="badge bg-info-subtle text-info mt-1">
                    Bachat: ₹{{ $inventory ? number_format($inventory->mrp - $inventory->offer_shipment_rate, 2) : '0.00' }}
                </span>

                <span class="badge bg-warning-subtle text-info  mt-1">
                    {{ ($inventory && $inventory->offer_shipment_rate && $inventory->mrp > 0)
                        ? number_format(
                            (($inventory->mrp - $inventory->offer_shipment_rate) / $inventory->mrp) * 100,
                            2
                        )
                        : '0.00' }}%
                </span>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm row-stock-qty"value="{{ $inventory->stock_quantity ?? '' }}" placeholder="Qty">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-inv-row" data-name="{{ $inventory->sku ?? '' }}"
                    data-bs-original-title="Delete this rate" data-bs-toggle="tooltip">
                    <i class="ti ti-trash"></i>
                </button>
            </td>
        </tr>
        <tr class="calculated-row-inventory bg-light-subtle {{ $isLast ? 'group-end' : '' }}" data-product-id="{{ $product->id }}">
            <td class="text-muted small">Calculated Values:</td>
            <td>
                <label class="small text-muted mb-0 d-block">Pre GST Amount</label>
                <input type="text" class="form-control form-control-sm row-pre-gst"
                    value="{{ $preGst !== null ? number_format($preGst, 2) : '' }}" placeholder="Pre GST Amount" readonly>
                <label class="small text-muted mb-0 d-block mt-1">GST Amount</label>
                <input type="text" class="form-control form-control-sm row-gst-amount"
                    value="{{ $gstAmount !== null ? number_format($gstAmount, 2) : '' }}" placeholder="GST Amount" readonly>
            </td>
            <td>
                <label class="small text-muted mb-0 d-block">Net Gain</label>
                <input type="text" class="form-control form-control-sm row-net-gain {{ $netGain !== null ? ($netGain < 0 ? 'text-danger' : 'text-success') : '' }}"
                    value="{{ $netGain !== null ? number_format($netGain, 2) : '' }}" placeholder="Net Gain" readonly>
                <label class="small text-muted mb-0 d-block mt-1">Net Gain %</label>
                <input type="text" class="form-control form-control-sm row-net-gain-perc"
                    value="{{ $netGainPerc !== null ? number_format($netGainPerc, 2) : '' }}" placeholder="Net Gain %" readonly>
            </td>
            <td colspan="4"></td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-end my-3 pe-2">
    <button type="button" id="save-all-inventory-btn" class="btn btn-primary">
        <i class="ti ti-device-floppy"></i> Save All
    </button>
</div>
@else
<p>No products found in this category.</p>
@endif

<div class="my-pagination" id="pagination-links">
    {{ $data['product_list']->links('vendor.pagination.bootstrap-4') }}
</div>