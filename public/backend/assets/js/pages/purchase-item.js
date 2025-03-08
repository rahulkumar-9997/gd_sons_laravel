$(document).ready(function () {
    var baseUrl = $('meta[name="base-url"]').attr('content');
    var selectedProductIds = [];
    /* Autocomplete for vendor name field with vendor ID */
    $(document).on('focus', '.vendor-autocomplete', function () {
        var $input = $(this);
        var $loader = $('#vendor_loader');
        var $refreshIcon = $input.siblings('.input-group-text').find('i'); 
        $input.removeClass('autocomplete-loading');
        $loader.hide(); 
        $refreshIcon.show();
        $(this).autocomplete({
            source: function (request, response) {
                // if (request.term.length < 2) {
                //     return; 
                // }
                
                $input.addClass('autocomplete-loading');
                $loader.show();
                $refreshIcon.hide();

                $.ajax({
                    url: baseUrl + '/autocomplete/vendors/',
                    data: { query: request.term },
                    success: function (data) {
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                        
                        response(data.map(function (vendor) {
                            return {
                                label: vendor.vendor_name,
                                value: vendor.vendor_name,
                                id: vendor.id
                            };
                        }));
                    },
                    error: function () {
                        console.error('Error fetching autocomplete data');
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                    }
                });
            },
            minLength: 0,
            select: function (event, ui) {
                $('#vendor_id').val(ui.item.id);
                console.log('Selected Vendor ID: ', ui.item.id);
            }
        });
    });

    /*Remove vendor ID if the input is cleared*/
    $(document).on('input', '.vendor-autocomplete', function () {
        if ($(this).val() === '') {
            $('#vendor_id').val('');
        }
    });

    
    /*Add new row to the table*/
    $('#addMore').on('click', function () {
        const newRow = `
            <tr>
                <td>
                    <div class="position-relative">
                        <div class="input-group">
                            <input type="text" class="form-control product-autocomplete" name="product_name[]" required>
                            <span class="input-group-text">
                                <i class="ti ti-refresh"></i>
                                <div class="spinner-border spinner-border-sm product-loader" role="status" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </span>
                        </div>
                        <input type="hidden" name="product_id[]" class="product_id"> 
                    </div>
                </td>
                <td>
                    <input type="text" id="hsn" name="hsn_code[]" class="form-control hsn-purchase" required>
                </td>
                <td>
                    <input type="number" id="mrp" name="mrp[]" class="form-control" required>
                </td>
                <td>
                     <input type="number" id="quantity" name="quantity[]" class="form-control" required>
                </td>
                <td>
                    <input type="number" id="total_amount" name="total_amount[]" class="form-control" required>
                </td>
                <td>
                   <input type="text" id="purchase_rate" name="purchase_rate[]" class="form-control" required>
                </td>
                <td>
                    <input type="text" id="offer_rate" name="offer_rate[]" class="form-control" required>
                </td>
                <td>
                    <input type="text" id="gst" name="gst_in_per[]" class="form-control gst-purchase">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#productTable tbody').append(newRow);
    });

    /*Remove row when 'Remove' button is clicked*/
    $(document).on('click', '.remove-row', function () {
        var row = $(this).closest('tr');
        var calculatedRow = row.next('.calculated-row'); 
        if (calculatedRow.length > 0) {
            calculatedRow.remove();
        }
        var productId = row.find('.product_id').val();
        if (productId) {
            selectedProductIds = selectedProductIds.filter(function(id) {
                return id !== productId;
            });
        }
        row.remove();
    });
    

    /*Autocomplete for product name field with product ID*/
    $(document).on('focus', '.product-autocomplete', function () {
        var $input = $(this);
        var $loader = $(this).siblings('.input-group-text').find('.product-loader'); 
        var $refreshIcon = $(this).siblings('.input-group-text').find('i'); 

        $input.removeClass('autocomplete-loading');
        $loader.hide(); 
        $refreshIcon.show(); 

        $(this).autocomplete({
            source: function (request, response) {
                // if (request.term.length < 0) {
                //     return;
                // }

                $input.addClass('autocomplete-loading');
                $loader.show(); 
                $refreshIcon.hide(); 

                $.ajax({
                    url: baseUrl + '/autocomplete/products',
                    data: {
                        query: request.term,
                        page: 1,
                        selected_ids: selectedProductIds || []
                    },
                    success: function (data) {
                        /*alert(JSON.stringify(data));*/
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                        var filteredData = data.filter(function(product) {
                            return !selectedProductIds.includes(product.id.toString());
                        });
                        response(filteredData.map(function (product) {
                            return {
                                label: product.title,
                                value: product.title,
                                id: product.id,
                                hsn_code: product.hsn_code,
                                gst_in_per: product.gst_in_per,
                            };
                        }));
                    },
                    error: function () {
                        console.error('Error fetching autocomplete data');
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                    }
                });
            },
            minLength: 0,  
            select: function (event, ui) {
                var row = $(this).closest('tr'); 
                row.find('.product_id').val(ui.item.id);
                row.find('.hsn-purchase').val(ui.item.hsn_code);
                row.find('.gst-purchase').val(ui.item.gst_in_per);
                selectedProductIds.push(ui.item.id.toString());
                console.log('Selected hsn : ', ui.item.hsn_code) 
                console.log('Selected gst: ', ui.item.gst_in_per) 
                console.log('Selected Product ID: ', ui.item.id);
            },
            
        }).autocomplete('instance')._renderItem = function (ul, item) {
            var term = $.ui.autocomplete.escapeRegex($input.val().toLowerCase());
            var matcher = new RegExp('(' + term + ')', 'i');
            var highlightedText = item.label.replace(matcher, '<span style="color: blck; font-weight: bold;">$1</span>');
            return $('<li>')
                .append('<div>' + highlightedText + '</div>')
                .appendTo(ul);
        };
    });

    /*Remove product ID if the input is cleared*/
    $(document).on('input', '.product-autocomplete', function () {
        if ($(this).val() === '') {
            var row = $(this).closest('tr'); 
            var productId = row.find('.product_id').val();
            row.find('.product_id').val('');

            selectedProductIds = selectedProductIds.filter(function(id) {
                return id !== productId;
            });
        }
    });
    /*CALCULATE ITEM */
    // $('#productTable').on('input', 'input', function () {
    //     var row = $(this).closest('tr');
    //     var mrp = parseFloat(row.find('input[name="mrp[]"]').val()) || 0;
    //     var quantity = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
    //     var totalAmount = parseFloat(row.find('input[name="total_amount[]"]').val()) || 0;
    //     var purchaseRate = quantity > 0 ? (totalAmount / quantity).toFixed(2) : 0;
    //     row.find('input[name="purchase_rate[]"]').val(purchaseRate);
    //     var offerRate = ((mrp + parseFloat(purchaseRate)) / 2).toFixed(2);
    //     row.find('input[name="offer_Rate[]"]').val(offerRate);
    // });
    $('#productTable').on('input', 'input', function () {
        var row = $(this).closest('tr');
        var mrp = parseFloat(row.find('input[name="mrp[]"]').val()) || 0;
        var quantity = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
        var totalAmount = parseFloat(row.find('input[name="total_amount[]"]').val()) || 0;
        var purchaseRateField = row.find('input[name="purchase_rate[]"]');
        var offerRateField = row.find('input[name="offer_rate[]"]');
        
        if ($(this).attr('name') !== 'purchase_rate[]') {
            var calculatedPurchaseRate = quantity > 0 ? (totalAmount / quantity).toFixed(2) : 0;
            purchaseRateField.val(calculatedPurchaseRate);
        } else {
            var editedPurchaseRate = parseFloat(purchaseRateField.val()) || 0;
            totalAmount = (editedPurchaseRate * quantity).toFixed(2);
            row.find('input[name="total_amount[]"]').val(totalAmount);
        }
        
        if (!offerRateField.is(':focus')) { 
            var purchaseRate = parseFloat(purchaseRateField.val()) || 0;
            var offerRate = Math.ceil((mrp + purchaseRate) / 2);
            offerRateField.val(offerRate);
        }
    });
    
    
    /*pre gst amount*/
    $('#productTable').on('input', 'input', function () {
        var row = $(this).closest('tr');
        var purchaseRate = parseFloat(row.find('input[name="purchase_rate[]"]').val()) || 0;
        var gstPercentage = parseFloat(row.find('input[name="gst_in_per[]"]').val()) || 0;
        var offerRate = parseFloat(row.find('input[name="offer_rate[]"]').val()) || 0;
        var preGstAmount = (purchaseRate / ((100 + gstPercentage) / 100)).toFixed(2);
        var gstAmount = (purchaseRate - preGstAmount).toFixed(2);
        var netGain = (offerRate - purchaseRate).toFixed(2); 
        var netGainPerc = purchaseRate > 0 ? ((netGain / purchaseRate) * 100).toFixed(2) : 0; 
        var calculatedRow = row.next('.calculated-row');
        console.log('preGstAmount:', preGstAmount, 'gstAmount:', gstAmount, 'netGain:', netGain, 'netGainPerc:', netGainPerc);
    
        if (calculatedRow.length === 0) {
            calculatedRow = $(`
                <tr class="calculated-row">
                    <td colspan="5" class="text-muted">Calculated Values:</td>
                    <td>
                        <label>Pre GST Amount</label>
                        <input type="text" name="pre_gst[]" class="form-control" value="${preGstAmount}" placeholder="Pre GST Amount">
                        <label>GST Amount</label>
                        <input type="text" name="gst_amount[]" class="form-control" value="${gstAmount}" placeholder="GST Amount">
                    </td>
                    <td>
                        <label>Net Gain</label>
                        <input type="text" name="net_gain[]" class="form-control" value="${netGain}" placeholder="Net Gain">
                        <label>Net Gain %</label>
                        <input type="text" name="net_gain_perc[]" class="form-control" value="${netGainPerc}" placeholder="Net Gain %">
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
        updateCalculatedValues();
    });
    function updateCalculatedValues() {
        var rowsData = [];
        var subTotal = 0;
        var gstPayable = 0;
        var grandTotal = 0;

        $('#productTable tbody tr').each(function () {
            var row = $(this);
            if (row.hasClass('calculated-row')) return;
            var quantity = parseFloat(row.find('input[name="quantity[]"]').val()) || 0;
            var totalAmount = parseFloat(row.find('input[name="total_amount[]"]').val()) || 0;
            var purchaseRate = parseFloat(row.find('input[name="purchase_rate[]"]').val()) || 0;
            var gstPercentage = parseFloat(row.find('input[name="gst_in_per[]"]').val()) || 0;

            /*Check if the next row is a calculated row*/
            var calculatedRow = row.next('.calculated-row');
            var preGstAmount = calculatedRow.length > 0
                ? parseFloat(calculatedRow.find('input[name="pre_gst[]"]').val()) || 0
                : 0;
            var gstAmount = calculatedRow.length > 0
                ? parseFloat(calculatedRow.find('input[name="gst_amount[]"]').val()) || 0
                : 0;
            var netGain = calculatedRow.length > 0
                ? parseFloat(calculatedRow.find('input[name="net_gain[]"]').val()) || 0
                : 0;
            var netGainPerc = calculatedRow.length > 0
                ? parseFloat(calculatedRow.find('input[name="net_gain_perc[]"]').val()) || 0
                : 0;
            rowsData.push({
                quantity,
                totalAmount,
                purchaseRate,
                gstPercentage,
                preGstAmount,
                gstAmount,
                netGain,
                netGainPerc,
            });
            subTotal += preGstAmount * quantity;
            gstPayable += gstAmount * quantity;
            grandTotal += totalAmount;
        });
        // $('#subTotal').text(subTotal.toFixed(2));
        // $('#gstPayable').text(gstPayable.toFixed(2));
        // $('#grandTotal').text(grandTotal.toFixed(2));
        $('#subTotal').val(subTotal.toFixed(2));
        $('#gstPayable').val(gstPayable.toFixed(2));
        $('#grandTotal').val(grandTotal.toFixed(2));

        console.log(rowsData);
    }   
    /*Sub total amount */
    /**Create new product modal js */
    $(document).on('click', 'a[data-ajax-product-popup="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url
        };
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);
        
        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function (data) {
                initializeSelect2Modal();
                $('#commanModel .render-data').html(data.form);
                initializeSelect2Modal();
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });

    /**Create new product modal js */
    /**Select product category modal form */
    $(document).on('change', '#product_categories_modal', function () {
        var categoryId = $(this).val();
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            category_id: categoryId,
        };
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function (data) {
                initializeSelect2Modal();
                $('#commanModel #append-pro-form').html(data.form);
                initializeSelect2Modal();
                //$("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
        
    });
    /**Select product category modal form */
    /**Add more attributes modal */
    $(document).on('click', '.add-more-attributes-modal', function () {
        var rowCount = $('.add-more-attributes-append-modal .row').length;
        var newRow = `
            <div class="row" id="attribute-row-${rowCount}">
                <div class="col-lg-6">
                    <div class="mb-2">
                        <select name="product_attributes[]" class="product_attributes js-example-basic-single">
                            <option selected>Select an option</option>
                            @foreach($data['product_attributes_list'] as $attributes_list_row)
                                <option value="{{ $attributes_list_row->id }}">{{ $attributes_list_row->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-2">
                        <input type="text" name="product_attributes_value[${rowCount}][]" class="form-control" placeholder="Enter attributes value comma separated">
                    </div>
                </div>
            </div>
        `;
        $('.add-more-attributes-append-modal').append(newRow);
        initializeSelect2Modal(); // Reinitialize Select2 for new elements.
    });
    /**Add more attributes modal */
    function initializeSelect2Modal() {
        $('.js-example-basic-single').each(function() {
            if (!$(this).data('select2')) {
                try {
                    $(this).select2({
                        placeholder: "Select an option",
                        allowClear: true
                    });
                } catch (error) {
                    console.error("Select2 initialization error:", error);
                }
            }
        });
    }
});

