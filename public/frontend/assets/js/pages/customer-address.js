$(document).ready(function () {
    /*Add New Address Button*/
    $(document).on('click', '#add-new-address', function () {
        $('#addAddressFormAccount')[0].reset();
        $('#addAddressFormAccount').attr('action', routes.storeAddress); 
        $('#addAddressFormAccount').attr('method', 'POST');
        $('#address_id').val('');
    });

    //*Edit Address Button*/
    $(document).on('click', '.edit-address', function () {
        var $button = $(this);
        var originalContent = $button.html();
        $button.html('<i class="fas fa-spinner fa-spin"></i>');
        const $formContainer = $('#addAddressFormContainer');
        $formContainer.toggle();
        let addressId = $(this).data('id');
        let editUrl = routes.editAddress.replace(':id', addressId);

        $.ajax({
            url: editUrl,
            method: 'GET',
            success: function (response) {
                if (response.success) {
                    $button.html(originalContent);
                    let address = response.address;
                    let updateUrl = routes.updateAddress.replace(':id', address.id);

                    $('#addAddressFormAccount').attr('action', updateUrl);
                    $('#addAddressFormAccount').attr('method', 'post');
                    $('#address_id').val(address.id);
                    $('input[name="full_name"]').val(address.name);
                    $('input[name="phone_number"]').val(address.phone_number);
                    $('select[name="country"]').val(address.country);
                    $('input[name="full_address"]').val(address.address);
                    $('input[name="apartment"]').val(address.apartment);
                    $('input[name="city_name"]').val(address.city);
                    $('select[name="state"]').val(address.state);
                    $('input[name="pin_code"]').val(address.zip_code);
                }
            },
            error: function () {
                $button.html(originalContent);
                showNotificationAll("warning", "", "Something went wrong. Please contact the administrator.");
            }
        });
    });

    /*Form Submission*/
    $('#addAddressFormAccount').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let submitButton = form.find('button[type="submit"]');
        let loader = $('#loader');
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        loader.show();
        var isValid = true;
        form.find('input, select').each(function() {
            if ($(this).attr('name') !== 'apartment' && $(this).val() === '' && $(this).attr('name') !== 'address_id') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            loader.hide();
            submitButton.prop('disabled', false).html('Save changes');
            showNotificationAll("warning", "", "Please fill all required fields.");
            return;
        }

        let action = form.attr('action');
        let method = form.attr('method');
        var formData = new FormData(this);
        
        $.ajax({
            url: action,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    showNotificationAll("success", "", response.message);
                    location.reload();
                } else {
                    showNotificationAll("warning", "", response.message);
                }
            },
            error: function (xhr) {
                showNotificationAll("danger", "", "An error occurred. Please try again.");
            },
            complete: function () {
                loader.hide();
                submitButton.prop('disabled', false).html('Save changes');
            }
        });
    });

    $(document).on('click', '.remove-address', function () {
        var button = $(this);
        var url = button.data('url'); 
        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Removing...');

        $.ajax({
            url: url, 
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    button.closest('.address-box').fadeOut(function() {
                        $(this).remove();
                    });
                    showNotificationAll("success", "", response.message);
                } else {
                    showNotificationAll("warning", "", response.message);
                }

                button.prop('disabled', false).html('<i data-feather="trash-2"></i> Remove'); 
            },
            error: function(xhr) {
                showNotificationAll("warning", "", 'Something went wrong. Please try again.');
                button.prop('disabled', false).html('<i data-feather="trash-2"></i> Remove');
            }
        });
    });
});
