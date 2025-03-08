@extends('backend.layouts.master')
@section('title','Manage Inventory')
@section('main-content')
@push('styles')
<style>
    .calculated-row-inventory input{
        padding: 0.1rem 0.1rem;
        font-size: 14px;
        border-radius: 5px;
    }
    .calculated-row-inventory label{
        font-size: 10px;
        color: red;
    }
</style>
@endpush
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div id="example-2_wrapper" class="filter-box">
                <div class="d-flex flex-wrap align-items-center bg-white p-2 gap-1 client-list-filter">
                <!-- Category Filter -->
                <div class="d-flex align-items-center border-end pe-1">
                    <p class="mb-0 me-2 text-dark-grey f-14">Category:</p>
                    <select id="category-filter" class="form-select form-select-md">
                        <option value="">All Categories</option>
                        @foreach($data['categories'] as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                  </select>
                </div>
                <div class="d-flex align-items-center border-end pe-1">
                    <p class="mb-0 me-2 text-dark-grey f-14">Status:</p>
                    <select id="product-status" name="status" class="form-select form-select-md">
                        <option value="">Select Product Status</option>
                        <option value="1">Published</option>
                        <option value="0">Not Published</option>
                    </select>
                </div>

                <!-- Search Filter -->
                <div class="d-flex align-items-center">
                    <label class="mb-0 me-2 text-dark-grey f-14">Search:</label>
                    <input type="search" class="form-control form-control-md" id="product-search" placeholder="Search products">
                </div>
                <button id="reset-button" class="btn btn-danger" style="display: none;">
                    <svg class="svg-inline--fa fa-times-circle fa-w-16 mr-1" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                    Reset Filters
                </button>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">
                        Manage Inventory
                        <!-- Bulk delete button, hidden initially -->
                        <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger" style="display: none;">Delete Selected</button> 
                    </h4>
                    
                    <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                    Choose any Links
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('export.inventory') }}" class="dropdown-item">Export Inventory</a>
                        <!-- item-->
                        <a href="{{route('import.inventory')}}" class="dropdown-item">Import Inventory</a>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    @if (isset($data['product_list']) && $data['product_list']->count() > 0)
                        <div class="table-responsive" id="product-list-container-with-inventory">
                            @include('backend.manage-inventory.partials.product_inventory_table', ['data' => $data])
                        </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Container Fluid -->
<!-- Modal -->
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('backend/assets/js/pages/upload-image-file.js')}}"></script>
<script type="">
    /**Inventory Calculation */
    $(document).ready(function() {
        $('#commanModel').on('shown.bs.modal', function() {
            $('#dynamic-fields-table tbody').on('input', 'input[name="mrp[]"], input[name="purchase_rate[]"]', function() {
                var row = $(this).closest('tr');
                var mrp = parseFloat(row.find('input[name="mrp[]"]').val()) || 0; 
                var purchaseRate = parseFloat(row.find('input[name="purchase_rate[]"]').val()) || 0; 
                var offerRate = Math.ceil((mrp + purchaseRate) / 2);
                row.find('input[name="offer_rate[]"]').val(offerRate);
            });
            /**Calculate gst and pre gst amount  */
            $('#inventoryAddForm').on('input', 'input[name="purchase_rate[]"], input[name="offer_rate[]"], input[name="gst_in_per"]', function () {
                var row = $(this).closest('tr');
                var purchaseRate = parseFloat(row.find('input[name="purchase_rate[]"]').val()) || 0;
                var offerRate = parseFloat(row.find('input[name="offer_rate[]"]').val()) || 0;
                var gstPercentage = parseFloat($('input[name="gst_in_per"]').val()) || 0;
                var preGstAmount = (purchaseRate / ((100 + gstPercentage) / 100)).toFixed(2);
                var gstAmount = (purchaseRate - preGstAmount).toFixed(2);
                var netGain = (offerRate - purchaseRate).toFixed(2);
                var netGainPerc = purchaseRate > 0 ? ((netGain / purchaseRate) * 100).toFixed(2) : 0;
                console.log('purchaseRate:', purchaseRate, 'offerRate:', offerRate, 'gstPercentage:', gstPercentage);
                console.log('preGstAmount:', preGstAmount, 'gstAmount:', gstAmount, 'netGain:', netGain, 'netGainPerc:', netGainPerc);
                var calculatedRow = row.next('.calculated-row-inventory');

                if (calculatedRow.length === 0) {
                calculatedRow = $(`
                    <tr class="calculated-row-inventory">
                        <td colspan="1" class="text-muted">Calculated Values:</td>
                        <td>
                            <label>Pre GST Amount</label>
                            <input type="text" name="pre_gst[]" class="form-control" value="${preGstAmount}" placeholder="Pre GST Amount" readonly>
                            <label>GST Amount</label>
                            <input type="text" name="gst_amount[]" class="form-control" value="${gstAmount}" placeholder="GST Amount" readonly>
                        </td>
                        <td>
                            <label>Net Gain</label>
                            <input type="text" name="net_gain[]" class="form-control" value="${netGain}" placeholder="Net Gain" readonly>
                            <label>Net Gain %</label>
                            <input type="text" name="net_gain_perc[]" class="form-control" value="${netGainPerc}" placeholder="Net Gain %" readonly>
                        </td>
                        <td></td>
                    </tr>
                `);
                row.after(calculatedRow); 
                } else {
                    calculatedRow.find('input[name="pre_gst[]"]').val(preGstAmount);
                    calculatedRow.find('input[name="gst_amount[]"]').val(gstAmount);
                    calculatedRow.find('input[name="net_gain[]"]').val(netGain);
                    calculatedRow.find('input[name="net_gain_perc[]"]').val(netGainPerc);
                }
            });
        });
    });
    /**Inventory Calculation */

    $(document).on('click', 'a[data-ajax-popup-modal="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var product_id = $(this).data('pid');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            product_id: product_id
        };
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });
    $(document).ready(function () {
        //let baseUrl = window.location.origin + '/demo/ecom';
        $(document).on('click', '#add-more-fields', function () {
            var newRow = `
                <tr class="field-group">
                    <td>
                        <input type="number" name="mrp[]" class="form-control" required="">
                    </td>
                    <td>
                        <input type="number"  name="purchase_rate[]" class="form-control" required="">
                    </td>
                    <td>
                        <input type="number" name="offer_rate[]" class="form-control" required="">
                    </td>
                    <td>
                        <input type="number" name="stock_quantity[]" class="form-control" required="">
                    </td>
                    <td style="display: none;">
                        <input type="text" name="sku[]" class="form-control" value="${generateUniqueSKU()}" readonly required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-field">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>`;
            $('#dynamic-fields-table tbody').append(newRow);
        });
        // Remove a Field Group
        $(document).on('click', '.remove-field', function () {
            $(this).closest('tr').remove();
        });
        function generateUniqueSKU() {
            return 'SKU-' + Math.random().toString(36).substr(2, 13).toUpperCase();
        }
        /**add new inventory */
        $(document).on('submit', '#inventoryAddForm', function (e) {
            e.preventDefault();
            let form = $(this);
            let submitButton = form.find('button[type="submit"]');
            let originalButtonText = submitButton.html();
            submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function (response) {
                    $('#error-container').html('');
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                    }).showToast();

                    form[0].reset();
                    var categoryId = $('#category-filter').val();
                    var search = $('#product-search').val();
                    var productStatus = $('#product-status').val();
                    var page = $('#pagination-links .active').find('a').data('page') 
                            || $('#pagination-links .active').find('span').text() 
                            || 1;
                    page = parseInt(page);
                    fetchProductsWithInventory(categoryId, search, page, productStatus);
                    $('#dynamic-fields-table tbody').empty();
                    $('.modal').modal('hide');
                },
                error: function (error) {
                    console.error(error.responseJSON);
                    let errorMessage = error.responseJSON?.message || 'An unexpected error occurred.';
                    if (error.responseJSON?.errors) {
                        let errorDetails = '<ul>';
                        $.each(error.responseJSON.errors, function(field, messages) {
                            errorDetails += `<li><strong>${field}:</strong> ${messages.join(', ')}</li>`;
                        });
                        errorDetails += '</ul>';
                        errorMessage = errorDetails;
                    }
                    $('#error-container').html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            ${errorMessage}
                        </div>`
                    );
                    Toastify({
                        text: errorMessage,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true,
                    }).showToast();
                },
                complete: function () {
                    submitButton.prop('disabled', false).html(originalButtonText);
                }
            });
        });
        /**add new inventory */
        /**Pagination */
        $(document).on('click', '#pagination-links a', function(e) {
            e.preventDefault();
            const categoryId = $('#category-filter').val();
            const search = $('#product-search').val();
            const productStatus = $('#product-status').val();
            const page = $(this).attr('href').split('page=')[1];
            fetchProductsWithInventory(categoryId, search, page, productStatus);
        });
        /**Pagination */
        /**Filter js  */
        $('#category-filter, #product-status').on('change', updateFilters);
        $('#product-search').on('keyup', updateFilters);
        /**reset button */
        $('#reset-button').on('click', function() {
            $('#category-filter, #product-search, #product-status').val('');
            $('#reset-button').hide();
            fetchProductsWithInventory();
        });
        /**reset button */
        function updateFilters() {
            const categoryId = $('#category-filter').val();
            const search = $('#product-search').val();
            const productStatus = $('#product-status').val();
            if (categoryId || search || productStatus) {
                $('#reset-button').show();
            } else {
                $('#reset-button').hide();
            }
            fetchProductsWithInventory(categoryId, search, 1, productStatus);
        }
        /**Filter js  */
        function bindInventoryEvents() {
            $('.edit-inventory-btn').on('click', function() {
                var inventoryId = $(this).data('inventoryid');
                $('td[data-id="' + inventoryId + '"] .current-value').hide();
                $('td[data-id="' + inventoryId + '"] .edit-input').show();
                $(this).hide();
                $('button.save-inventory-btn[data-inventoryid="' + inventoryId + '"]').show();
                $('button.cancel-inventory-btn[data-inventoryid="' + inventoryId + '"]').show();
            });

            $('.cancel-inventory-btn').on('click', function() {
                var inventoryId = $(this).data('inventoryid');
                $('td[data-id="' + inventoryId + '"] .edit-input').hide();
                $('td[data-id="' + inventoryId + '"] .current-value').show();
                $('button.save-inventory-btn[data-inventoryid="' + inventoryId + '"]').hide();
                $('button.cancel-inventory-btn[data-inventoryid="' + inventoryId + '"]').hide();
                $('button.edit-inventory-btn[data-inventoryid="' + inventoryId + '"]').show();
            });

            /** Save inventory button click */
            $('.save-inventory-btn').on('click', function() {
                var inventoryId = $(this).data('inventoryid');
                var productId = $(this).data('productid');
                var mrp = $('td[data-id="' + inventoryId + '"] .edit-input[data-field="mrp"]').val();
                var purchaseRate = $('td[data-id="' + inventoryId + '"] .edit-input[data-field="purchase_rate"]').val();
                var offerRate = $('td[data-id="' + inventoryId + '"] .edit-input[data-field="offer_rate"]').val();
                var stockQuantity = $('td[data-id="' + inventoryId + '"] .edit-input[data-field="stock_quantity"]').val();
                $.ajax({
                    url: '/manage-inventory/update/' + inventoryId,
                    //url: `${baseUrl}/manage-inventory/update/${inventoryId}`,
                    method: 'POST',
                    data: {
                        id: inventoryId,
                        product_id: productId,
                        mrp: mrp,
                        purchase_rate: purchaseRate,
                        offer_rate: offerRate,
                        stock_quantity: stockQuantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            fetchProductsWithInventory();
                            Toastify({
                                text: response.message,
                                duration: 10000,
                                gravity: "top",
                                position: "right",
                                className: "bg-success",
                                close: true,
                                onClick: function() {}
                            }).showToast();
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }

                        Toastify({
                            text: errorMessage,
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true,
                            onClick: function() {}
                        }).showToast();
                    }
                });
            });

            /**DELETE INVENTORY */
            $(document).on('click', '.delete-inventory-btn', function (event) {
                var inventoryId = $(this).data("inventoryid"); 
                var name = $(this).data("name");
                event.preventDefault(); 
                Swal.fire({
                    title: `Are you sure you want to delete this ${name}?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/manage-inventory/delete/' + inventoryId,
                            type: 'DELETE',
                            data: {
                                id: inventoryId,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                var successMessage = response.message || "Inventory deleted successfully!";
                                fetchProductsWithInventory();
                                Toastify({
                                    text: successMessage,
                                    duration: 10000,
                                    gravity: "top",
                                    position: "right",
                                    className: "bg-success",
                                    close: true,
                                    onClick: function() {}
                                }).showToast();
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = xhr.responseJSON?.error || 'An error occurred while deleting the inventory.';
                                Toastify({
                                    text: errorMessage,
                                    duration: 10000,
                                    gravity: "top",
                                    position: "right",
                                    className: "bg-danger",
                                    close: true,
                                    onClick: function() {}
                                }).showToast();
                            }
                        });
                    }
                });
            });
            /**DELETE INVENTORY */
            
        }
        /**save inventory buton click */
        function fetchProductsWithInventory(categoryId = '', search = '', page = 1, productStatus = '') {
            $('#loader').show();
            $.ajax({
                url: "{{ route('manage-inventory.index') }}",
                type: "GET",
                data: { 
                    category_id: categoryId, 
                    search: search, 
                    page: page, 
                    product_status: productStatus 
                },
                success: function(data) {
                    $('#product-list-container-with-inventory').html(data);
                    $('#loader').hide();
                    bindInventoryEvents();
                },
                error: function() {
                    alert("An error occurred while filtering products.");
                    $('#loader').hide();
                }
            });
        }
        bindInventoryEvents();
        

    });
    
</script>
@endpush