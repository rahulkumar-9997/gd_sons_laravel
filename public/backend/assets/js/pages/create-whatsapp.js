$(document).ready(function () {
    var baseUrl = $('meta[name="base-url"]').attr('content');
    var selectedProductIds = [];
    
    /*Add new row to the table*/
    $('#addMore').on('click', function () {
        const newRow = `
            <tr>
                <td>
                    <div class="position-relative">
                        <div class="input-group">
                            <input type="text" id="product_name" name="product_name[]" class="form-control product-autocomplete" required>
                
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
                    <input type="text" id="mrp" name="mrp[]" class="form-control mrp" required>
                </td>
                <td>
                    <input type="text" id="purchase_rate" name="purchase_rate[]" class="form-control purchase_rate" required>
                     <input type="hidden" id="gst_per" name="gst_in_per[]" class="form-control gst_per">
                </td>
                <td>
                    <input type="text" id="offer_rate" name="offer_rate[]" class="form-control offer_rate" required>
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
                $input.addClass('autocomplete-loading');
                $loader.show(); 
                $refreshIcon.hide(); 

                $.ajax({
                    url: baseUrl + '/autocomplete/products-whatsapp',
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
                                mrp: product.mrp,
                                purchase_rate: product.purchase_rate,
                                offer_rate: product.offer_rate,
                                stock_quantity: product.stock_quantity,
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
                /*var row = $(this).closest('tr'); 
                row.find('.product_id').val(ui.item.id);
                row.find('.mrp').val(ui.item.mrp);
                row.find('.purchase_rate').val(ui.item.purchase_rate);
                row.find('.offer_rate').val(ui.item.offer_rate);
                row.find('.gst_per').val(ui.item.gst_in_per);
                selectedProductIds.push(ui.item.id.toString());
                console.log('Selected mrp : ', ui.item.mrp) 
                console.log('Selected purchase_rate: ', ui.item.purchase_rate) 
                console.log('Selected Product ID: ', ui.item.id);
                calculateRowValues(row);
                */
                var row = $(this).closest('tr'); 
                row.find('.product_id').val(ui.item.id);
                row.find('.mrp').val(ui.item.mrp ? ui.item.mrp : 'No Value');
                row.find('.purchase_rate').val(ui.item.purchase_rate ? ui.item.purchase_rate : 'No Value');
                row.find('.offer_rate').val(ui.item.offer_rate ? ui.item.offer_rate : 'No Value');
                row.find('.gst_per').val(ui.item.gst_in_per ? ui.item.gst_in_per : 'No Value');
                selectedProductIds.push(ui.item.id.toString());
                console.log('Selected mrp : ', ui.item.mrp) 
                console.log('Selected purchase_rate: ', ui.item.purchase_rate) 
                console.log('Selected Product ID: ', ui.item.id);
                calculateRowValues(row);
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
    
    function calculateRowValues(row) {
        var purchaseRate = parseFloat(row.find('input[name="purchase_rate[]"]').val()) || 0;
        var offerRate = parseFloat(row.find('input[name="offer_rate[]"]').val()) || 0;
        var gstPercentage = parseFloat(row.find('input[name="gst_in_per[]"]').val()) || 0;
        
        var preGstAmount = (purchaseRate / ((100 + gstPercentage) / 100)).toFixed(2);
        var gstAmount = (purchaseRate - preGstAmount).toFixed(2);
        var netGain = (offerRate - purchaseRate).toFixed(2);
        var netGainPerc = purchaseRate > 0 ? ((netGain / purchaseRate) * 100).toFixed(2) : 0;
    
        /*console.log('purchaseRate:', purchaseRate, 'offerRate:', offerRate, 'gstPercentage:', gstPercentage);
        console.log('preGstAmount:', preGstAmount, 'gstAmount:', gstAmount, 'netGain:', netGain, 'netGainPerc:', netGainPerc);
        */
    
        var calculatedRow = row.next('.calculated-row');
    
        if (calculatedRow.length === 0) {
            calculatedRow = $(`
                <tr class="calculated-row">
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
    }
    $('#whatsAppMessageForm').on('input', 'input[name="purchase_rate[]"], input[name="offer_rate[]"], input[name="gst_in_per"]', function () {
        var row = $(this).closest('tr');
        calculateRowValues(row);
    });
    /**What send message form submit* */
    $(document).off('submit', '#whatsAppMessageForm').on('submit', '#whatsAppMessageForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('input[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton.prop('disabled', true).val('Sending...');
      
        var formData = new FormData(this);  
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false);
                submitButton.val('Submit');
                if (response.status === 'success') {
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                        onClick: function () {}
                    }).showToast();
                    //form[0].reset();
                    $('#whatsAppMessageForm')[0].reset();
                    $('input[name="pre_gst[]"], input[name="gst_amount[]"], input[name="net_gain[]"], input[name="net_gain_perc[]"]').val('');
                }
            },
            error: function(error) {
                submitButton.prop('disabled', false);
                submitButton.val('Submit');
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
                // Toastify({
                //     text: errorMessage,
                //     duration: 10000,
                //     gravity: "top",
                //     position: "right",
                //     className: "bg-danger",
                //     close: true,
                // }).showToast();
            }
        });
    });
    /**What send message form submit* */
    /**autocomplete for whatsapp conversation name or mobile number */
    $(document).on('focus', '.whatsapp-conversation-autocomplete', function () {
        var $input = $(this);
        var $loader = $(this).siblings('.input-group-text').find('.whatsapp-loader');
        var $refreshIcon = $(this).siblings('.input-group-text').find('i');
        $input.removeClass('autocomplete-loading');
        $loader.hide();
        $refreshIcon.show();
        $(this).autocomplete({
            source: function (request, response) {
                $input.addClass('autocomplete-loading');
                $loader.show();
                $refreshIcon.hide();
                $.ajax({
                    url: baseUrl + '/whatsapp-conversations/autocomplete',
                    data: {
                        query: request.term 
                    },
                    success: function (data) {
                        $input.removeClass('autocomplete-loading');
                        $loader.hide();
                        $refreshIcon.show();
                        response(data.map(function (item) {
                            return {
                                label: item.name + ' (' + item.mobile_number + ')',
                                value: item.name,
                                id: item.id,
                                mobile_number: item.mobile_number
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
                var row = $(this).closest('.whatsapp-name-mobile');
                row.find('.conversation_mobile_number').val(ui.item.mobile_number);
                row.find('.conversation_name').val(ui.item.name);
                row.find('.whatsapp_conversation_id').val(ui.item.id);
            }
        }).autocomplete('instance')._renderItem = function (ul, item) {
            var term = $.ui.autocomplete.escapeRegex($input.val().toLowerCase());
            var matcher = new RegExp('(' + term + ')', 'i');
            var highlightedText = item.label.replace(matcher, '<span style="color: black; font-weight: bold;">$1</span>');
            return $('<li>')
                .append('<div>' + highlightedText + '</div>')
                .appendTo(ul);
        };
    });
    /**autocomplete for whatsapp conversation name or mobile number */
    $(document).on('input', '.whatsapp-conversation-autocomplete', function () {
        if ($(this).val() === '') {
            var row = $(this).closest('.whatsapp-name-mobile');
            row.find('.conversation_mobile_number').val('');
            row.find('.whatsapp_conversation_id').val('');
        }
    });
});

