$(document).ready(function () {
    $(document).on('submit', '#checkoutFormSubmit', function (e) {
        e.preventDefault(); 
        let form = $(this);
        let submitButton = form.find('button[type="submit"]');
        let originalButtonText = submitButton.html(); 
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                //console.log("Response received:", response);
                // if (response.data && response.data.original) {
                //     var responseData = response.data.original;
                //     form[0].reset();
                //     submitButton.prop('disabled', false).html(originalButtonText);
                //     if(responseData.redirect_url) {
                //         console.log("Redirecting to:", response.redirect_url);
                //         window.location.href = responseData.redirect_url;
                //     }
                // } else {
                //     alert("Something went wrong!");
                // }
                if (response.status=='success') {
                    submitButton.prop('disabled', false).html(originalButtonText);
                    $.ajax({
                        url: "/pay-modal-form",
                        type: "POST",
                        data: {
                            response_data: response.payment_type,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (postResponse) {
                            if (postResponse.status == 'success') {
                                $('#commoanModal .modal-render-data').html(postResponse.form);
                                $("#commoanModal").modal('show');
                                //showNotificationAll("success", "", "Data successfully processed!");
                            } else {
                                showNotificationAll("danger", "", "Something went wrong. Please try again!");
                            }
                        },
                        error: function () {
                            showNotificationAll("danger", "", "AJAX error occurred. Please try again!");
                        }
                    });
                }else if(response.status=='cash_on_delivery'){
                    if (response.data && response.data.original) {
                        var responseData = response.data.original;
                        form[0].reset();
                        submitButton.prop('disabled', false).html(originalButtonText);
                        if(responseData.redirect_url) {
                            console.log("Redirecting to:", response.redirect_url);
                            window.location.href = responseData.redirect_url;
                        }
                    } else {
                        showNotificationAll("danger", "", 'Somethins went wrong please try again!.');
                    }
                }
                else{
                    showNotificationAll("danger", "", 'Somethins went wrong please try again!.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let firstInvalidField = null;
                    $.each(errors, function(fieldName, messages) {
                        let input = form.find(`[name="${fieldName}"]`);
                        input.addClass('is-invalid');
                        //input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                        if (firstInvalidField === null) {
                            firstInvalidField = input;
                        }
                    });
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                    }
                } else {
                    showNotificationAll("danger", "", 'An unexpected error occurred. Please try again later.');
                }
                submitButton.prop('disabled', false).html(originalButtonText);
            }
        });
    });
    /**Payment form submit after payment*/
    $(document).off('submit', '#payModalFormSubmit').on('submit', '#payModalFormSubmit', function (event) {
        event.preventDefault(); 
        let form = $(this);
        let submitButton = form.find('button[type="submit"]');
        let originalButtonText = submitButton.html(); 
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.data && response.data.original) {
                    var responseData = response.data.original;
                    form[0].reset();
                    submitButton.prop('disabled', false).html(originalButtonText);
                    if(responseData.redirect_url) {
                        console.log("Redirecting to:", response.redirect_url);
                        window.location.href = responseData.redirect_url;
                    }
                } else {
                    alert("Something went wrong!");
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let firstInvalidField = null;
                    $.each(errors, function(fieldName, messages) {
                        let input = form.find(`[name="${fieldName}"]`);
                        input.addClass('is-invalid');
                        //input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                        if (firstInvalidField === null) {
                            firstInvalidField = input;
                        }
                    });
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                    }
                } else {
                    showNotificationAll("danger", "", 'An unexpected error occurred. Please try again later.');
                }
                submitButton.prop('disabled', false).html(originalButtonText);
            }
        });
    });
    /**Payment form submit after payment*/

    
});