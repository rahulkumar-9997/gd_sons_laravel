$(document).ready(function(){
    $(document).on('click', 'div[data-ajax-address-popup="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var customer_id = $(this).data('customer-id');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            customer_id: customer_id,
        };
        $("#addAddressModal .modal-title").html(title);
        $("#addAddressModal .modal-dialog").addClass('modal-' + size);
        
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                $('#addAddressModal .render-data').html(data.form);
                $("#addAddressModal").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });

    /**address form submit */
    $(document).on('submit', '#addAddressForm', function (e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="button"]');
        var loader = $('#loader'); 
        submitButton.prop('disabled', true);
        loader.show();
        var isValid = true;
        form.find('input, select').each(function() {
            if ($(this).attr('name') !== 'apartment' && $(this).val() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!isValid) {
            loader.hide();
            submitButton.prop('disabled', false);
            return;
        }
    
        var formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    form[0].reset();
                    loader.hide();
                    $("#addAddressModal").modal('hide');
                    location.reload();
                    $('.checkout-form-container').html(response.customer_address);
                } else {
                    showNotificationAll("warning", "", response.message);
                }
                submitButton.prop('disabled', false);
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    showNotificationAll("warning", "", xhr.responseJSON.message);
                } else {
                    showNotificationAll("warning", "", "An error occurred. Please try again.");
                }
                loader.hide();
                submitButton.prop('disabled', false);
            }
        });
    });
    /**edit address toggle click */
    $(document).on('click', '.toggle-popup', function () {
        var targetId = $(this).data('target');
        var popup = $('#popup-' + targetId);
        popup.toggleClass('active');
    });

    $(document).on('click', 'a[data-ajax-editaddress-popup="true"]', function () {
        var title = $(this).data('title');
        var url = $(this).data('url');
        var customer_id = $(this).data('cuid');
        var address_id = $(this).data('id');
        var loader = $('#loader'); 
        loader.show();
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            url: url,
            customer_id: customer_id,
            address_id: address_id,
        };
        $("#addAddressModal .modal-title").html(title);
        //$("#addAddressModal .modal-dialog").addClass('modal-' + size);
        
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                $('#addAddressModal .render-data').html(data.form);
                $("#addAddressModal").modal('show');
                loader.hide();
            },
            error: function (data) {
                data = data.responseJSON;
                loader.hide();
            }
        });
    });

    /**Edit address form submit */
    $(document).on('submit', '#EditAddressForm', function (e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="button"]');
        var loader = $('#loader'); 
        submitButton.prop('disabled', true);
        loader.show();
        var isValid = true;
        form.find('input, select').each(function() {
            if ($(this).attr('name') !== 'apartment' && $(this).val() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            loader.hide();
            submitButton.prop('disabled', false);
            return;
        }
        var formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    form[0].reset();
                    loader.hide();
                    $("#addAddressModal").modal('hide');
                    location.reload();
                    $('.checkout-form-container').html(response.customer_address);
                } else {
                    showNotificationAll("warning", "", response.message);
                }
                submitButton.prop('disabled', false);
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    showNotificationAll("warning", "", xhr.responseJSON.message);
                } else {
                    showNotificationAll("warning", "", "An error occurred. Please try again.");
                }
                loader.hide();
                submitButton.prop('disabled', false);
            }
        });
    });
});