$(document).ready(function () {
    var ROUTES = window.INVENTORY_ROUTES || {};
    var INDEX_URL  = ROUTES.index  || '/manage-inventory';
    var UPDATE_URL = ROUTES.update || '/manage-inventory/update/';
    var DELETE_URL = ROUTES.delete || '/manage-inventory/delete/';
    function csrf() {
        return $('meta[name="csrf-token"]').attr('content');
    }
    function toast(text, className) {
        Toastify({
            text: text,
            duration: 10000,
            gravity: 'top',
            position: 'right',
            className: className,
            close: true,
            onClick: function () {}
        }).showToast();
    }
    function generateUniqueSKU() {
        return 'SKU-' + Math.random().toString(36).substr(2, 13).toUpperCase();
    }

    /** The product-level shipment rate, stored on the table by create() */
    function currentShipmentRate() {
        return parseFloat($('#dynamic-fields-table').data('shipment-rate')) || 0;
    }

    function num(selector, row) {
        return parseFloat(row.find(selector).val()) || 0;
    }

    /* Open inventory modal                                            */

    $(document).on('click', 'a[data-ajax-popup-modal="true"]', function () {
        var link = $(this);
        var size = (link.data('size') == '') ? 'md' : link.data('size');
        var url  = link.data('url');

        $('#commanModel .modal-title').html(link.data('title'));
        $('#commanModel .modal-dialog').addClass('modal-' + size);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: csrf(),
                size: size,
                url: url,
                product_id: link.data('pid')
            },
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $('#commanModel').modal('show');
            },
            error: function () {
                toast('Could not load the inventory form.', 'bg-danger');
            }
        });
    });

    /* Offer rate auto-fill = ceil((MRP + Purchase Rate) / 2)          */

    $(document).on('input',
        '#dynamic-fields-table input[name="mrp[]"], #dynamic-fields-table input[name="purchase_rate[]"]',
        function () {
            var row = $(this).closest('tr');
            var offerRate = Math.ceil((num('input[name="mrp[]"]', row) + num('input[name="purchase_rate[]"]', row)) / 2);

            row.find('input[name="offer_rate[]"]').val(offerRate);
            recalcShipping(row);
        }
    );
    
    function recalcShipping(row) {
        var mrp   = num('input[name="mrp[]"]', row);
        var offer = num('input[name="offer_rate[]"]', row);
        var ship  = num('input[name="shipment_rate[]"]', row);
        var badge = row.find('.savings-badge');

        if (offer <= 0) {
            row.find('input[name="offer_shipment_rate[]"]').val('');
            badge.hide();
            return;
        }

        var total = offer + ship;
        row.find('input[name="offer_shipment_rate[]"]').val(total.toFixed(2));

        if (mrp > 0) {
            badge.text('Bachat: ₹' + (mrp - total).toFixed(2)).show();
        } else {
            badge.hide();
        }
    }

    $(document).on('input',
        '#dynamic-fields-table input[name="offer_rate[]"], #dynamic-fields-table input[name="shipment_rate[]"]',
        function () {
            recalcShipping($(this).closest('tr'));
        }
    );

    /* GST / Net gain calculated row  */

    $(document).on('input',
        '#inventoryAddForm input[name="purchase_rate[]"], #inventoryAddForm input[name="offer_rate[]"], #inventoryAddForm input[name="gst_in_per"]',
        function () {
            // Changing the GST % must refresh every row, not only one
            var rows = $(this).attr('name') === 'gst_in_per'
                ? $('#dynamic-fields-table tbody tr.field-group')
                : $(this).closest('tr');

            rows.each(function () {
                var row   = $(this);
                var purc  = num('input[name="purchase_rate[]"]', row);
                var offer = num('input[name="offer_rate[]"]', row);
                var gst   = parseFloat($('input[name="gst_in_per"]').val()) || 0;

                var preGstAmount = (purc / ((100 + gst) / 100)).toFixed(2);
                var gstAmount    = (purc - preGstAmount).toFixed(2);
                var netGain      = (offer - purc).toFixed(2);
                var netGainPerc  = purc > 0 ? ((netGain / purc) * 100).toFixed(2) : '0.00';

                var calculatedRow = row.next('.calculated-row-inventory');

                if (calculatedRow.length === 0) {
                    calculatedRow = $(
                        '<tr class="calculated-row-inventory">' +
                            '<td class="text-muted">Calculated Values:</td>' +
                            '<td>' +
                                '<label>Pre GST Amount</label>' +
                                '<input type="text" name="pre_gst[]" class="form-control" placeholder="Pre GST Amount" readonly>' +
                                '<label>GST Amount</label>' +
                                '<input type="text" name="gst_amount[]" class="form-control" placeholder="GST Amount" readonly>' +
                            '</td>' +
                            '<td>' +
                                '<label>Net Gain</label>' +
                                '<input type="text" name="net_gain[]" class="form-control" placeholder="Net Gain" readonly>' +
                                '<label>Net Gain %</label>' +
                                '<input type="text" name="net_gain_perc[]" class="form-control" placeholder="Net Gain %" readonly>' +
                            '</td>' +
                            '<td colspan="5"></td>' +
                        '</tr>'
                    );
                    row.after(calculatedRow);
                }

                calculatedRow.find('input[name="pre_gst[]"]').val(preGstAmount);
                calculatedRow.find('input[name="gst_amount[]"]').val(gstAmount);
                calculatedRow.find('input[name="net_gain[]"]').val(netGain);
                calculatedRow.find('input[name="net_gain_perc[]"]').val(netGainPerc);
            });
        }
    );

    /* "Update Shipment Rate" button*/

    $(document).on('click', '.update-shipment-rate', function () {
        var button = $(this);
        button.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
        );
        $.ajax({
            url: button.data('route'),
            type: 'POST',
            data: { _token: csrf() },
            success: function (response) {
                if (!response.success) {
                    toast(response.message, 'bg-info');
                    return;
                }
                var rate = parseFloat(response.shipment_rate);
                $('#dynamic-fields-table').data('shipment-rate', rate);
                $('#vw-badge').text('VW: ' + parseFloat(response.volumetric_weight_kg).toFixed(2) + ' kg');
                $('#sr-badge').text('Shipping: ₹' + rate.toFixed(2));

                $('#dynamic-fields-table tbody tr.field-group').each(function () {
                    var row = $(this);
                    row.find('input[name="shipment_rate[]"]').val(rate.toFixed(2));
                    recalcShipping(row);
                });
                toast(response.message, 'bg-success');
            },
            error: function (xhr) {
                toast((xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.', 'bg-danger');
            },
            complete: function () {
                button.prop('disabled', false).html('Update Shipment Rate');
            }
        });
    });
    
    /*  Add More / Remove row  */

    $(document).on('click', '#add-more-fields', function () {
        var ship = currentShipmentRate();
        $('#dynamic-fields-table tbody').append(
            '<tr class="field-group">' +
                '<td>' +
                    '<input type="hidden" name="inventory_id[]" value="">' +
                    '<input type="number" step="0.01" name="mrp[]" class="form-control" required>' +
                '</td>' +
                '<td><input type="number" step="0.01" name="purchase_rate[]" class="form-control" required></td>' +
                '<td><input type="number" step="0.01" name="offer_rate[]" class="form-control" required></td>' +
                '<td><input type="number" step="0.01" name="shipment_rate[]" class="form-control" value="' + (ship > 0 ? ship.toFixed(2) : '') + '"></td>' +
                '<td>' +
                    '<input type="number" step="0.01" name="offer_shipment_rate[]" class="form-control">' +
                    '<span class="badge bg-info-subtle text-info savings-badge" style="display:none;"></span>' +
                '</td>' +
                '<td><input type="number" name="stock_quantity[]" class="form-control" required></td>' +
                '<td style="display: none;"><input type="text" name="sku[]" class="form-control" value="' + generateUniqueSKU() + '" readonly required></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm remove-field"><i class="ti ti-trash"></i></button></td>' +
            '</tr>'
        );
    });

    $(document).on('click', '.remove-field', function () {
        var row = $(this).closest('tr');
        row.next('.calculated-row-inventory').remove();
        row.remove();
    });
    
    /* Save inventory (modal form) */

    $(document).on('submit', '#inventoryAddForm', function (e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        var originalButtonText = submitButton.html();

        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function (response) {
                $('#error-container').html('');
                toast(response.message, 'bg-success');

                var page = $('#pagination-links .active').find('a').data('page')
                        || $('#pagination-links .active').find('span').text()
                        || 1;

                fetchProductsWithInventory(
                    $('#category-filter').val(),
                    $('#product-search').val(),
                    parseInt(page),
                    $('#product-status').val()
                );

                $('#dynamic-fields-table tbody').empty();
                $('.modal').modal('hide');
            },
            error: function (error) {
                var errorMessage = (error.responseJSON && error.responseJSON.message) || 'An unexpected error occurred.';

                if (error.responseJSON && error.responseJSON.errors) {
                    var details = '<ul>';
                    $.each(error.responseJSON.errors, function (field, messages) {
                        details += '<li><strong>' + field + ':</strong> ' + messages.join(', ') + '</li>';
                    });
                    errorMessage = details + '</ul>';
                }

                $('#error-container').html(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        errorMessage +
                    '</div>'
                );
                toast(errorMessage, 'bg-danger');
            },
            complete: function () {
                submitButton.prop('disabled', false).html(originalButtonText);
            }
        });
    });

    /* Listing: pagination, filters, inline edit, delete*/

    $(document).on('click', '#pagination-links a', function (e) {
        e.preventDefault();
        fetchProductsWithInventory(
            $('#category-filter').val(),
            $('#product-search').val(),
            $(this).attr('href').split('page=')[1],
            $('#product-status').val()
        );
    });

    $(document).on('change', '#category-filter, #product-status', updateFilters);
    $(document).on('keyup', '#product-search', updateFilters);

    $(document).on('click', '#reset-button', function () {
        $('#category-filter, #product-search, #product-status').val('');
        $('#reset-button').hide();
        fetchProductsWithInventory();
    });

    function updateFilters() {
        var categoryId    = $('#category-filter').val();
        var search        = $('#product-search').val();
        var productStatus = $('#product-status').val();

        if (categoryId || search || productStatus) {
            $('#reset-button').show();
        } else {
            $('#reset-button').hide();
        }

        fetchProductsWithInventory(categoryId, search, 1, productStatus);
    }
    $(document).on('click', '.edit-inventory-btn', function () {
        var id = $(this).data('inventoryid');
        $('td[data-id="' + id + '"] .current-value').hide();
        $('td[data-id="' + id + '"] .edit-input').show();
        $(this).hide();
        $('button.save-inventory-btn[data-inventoryid="' + id + '"]').show();
        $('button.cancel-inventory-btn[data-inventoryid="' + id + '"]').show();
    });

    $(document).on('click', '.cancel-inventory-btn', function () {
        var id = $(this).data('inventoryid');
        $('td[data-id="' + id + '"] .edit-input').hide();
        $('td[data-id="' + id + '"] .current-value').show();
        $('button.save-inventory-btn[data-inventoryid="' + id + '"]').hide();
        $('button.cancel-inventory-btn[data-inventoryid="' + id + '"]').hide();
        $('button.edit-inventory-btn[data-inventoryid="' + id + '"]').show();
    });

    $(document).on('click', '.save-inventory-btn', function () {
        var inventoryId = $(this).data('inventoryid');

        function field(name) {
            return $('td[data-id="' + inventoryId + '"] .edit-input[data-field="' + name + '"]').val();
        }
        $.ajax({
            url: UPDATE_URL + inventoryId,
            method: 'POST',
            data: {
                id: inventoryId,
                product_id: $(this).data('productid'),
                mrp: field('mrp'),
                purchase_rate: field('purchase_rate'),
                offer_rate: field('offer_rate'),
                stock_quantity: field('stock_quantity'),
                _token: csrf()
            },
            success: function (response) {
                if (response.success) {
                    fetchProductsWithInventory();
                    toast(response.message, 'bg-success');
                }
            },
            error: function (xhr) {
                toast((xhr.responseJSON && xhr.responseJSON.error) || 'An error occurred. Please try again.', 'bg-danger');
            }
        });
    });

    $(document).on('click', '.delete-inventory-btn', function (event) {
        event.preventDefault();

        var inventoryId = $(this).data('inventoryid');

        Swal.fire({
            title: 'Are you sure you want to delete this ' + $(this).data('name') + '?',
            text: 'If you delete this, it will be gone forever.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: DELETE_URL + inventoryId,
                type: 'DELETE',
                data: { id: inventoryId, _token: csrf() },
                success: function (response) {
                    fetchProductsWithInventory();
                    toast(response.message || 'Inventory deleted successfully!', 'bg-success');
                },
                error: function (xhr) {
                    toast((xhr.responseJSON && xhr.responseJSON.error) || 'An error occurred while deleting the inventory.', 'bg-danger');
                }
            });
        });
    });

    function fetchProductsWithInventory(categoryId, search, page, productStatus) {
        $('#loader').show();

        $.ajax({
            url: INDEX_URL,
            type: 'GET',
            data: {
                category_id: categoryId || '',
                search: search || '',
                page: page || 1,
                product_status: productStatus || ''
            },
            success: function (data) {
                $('#product-list-container-with-inventory').html(data);
                $('#loader').hide();
            },
            error: function () {
                toast('An error occurred while filtering products.', 'bg-danger');
                $('#loader').hide();
            }
        });
    }
});