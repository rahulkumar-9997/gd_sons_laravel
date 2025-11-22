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
            success: function (response) {
                if (response.status == 'success') {
                    submitButton.prop('disabled', false).html(originalButtonText);
                    $.ajax({
                        url: "/pay-modal-form",
                        type: "get",
                        data: {
                            response_data: response.payment_type,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (postResponse) {
                            if (postResponse.status == 'success') {
                                $('#commoanModal .modal-render-data').html(postResponse.form);
                                $("#commoanModal").modal('show');
                            } else {
                                showNotificationAll("danger", "", "Something went wrong. Please try again!");
                            }
                        },
                        error: function () {
                            showNotificationAll("danger", "", "AJAX error occurred. Please try again!");
                        }
                    });
                }
                else if (response.status == 'cash_on_delivery') {
                    if (response.data && response.data.original) {
                        var responseData = response.data.original;
                        form[0].reset();
                        submitButton.prop('disabled', false).html(originalButtonText);
                        if (responseData.redirect_url) {
                            window.location.href = responseData.redirect_url;
                        }
                    } else {
                        showNotificationAll("danger", "", 'Something went wrong please try again!.');
                    }
                }
                else if (response.status == 'razorpay') {
                    submitButton.prop('disabled', false).html(originalButtonText);
                    initializeRazorpayPayment(response);
                }
                else if (response.status == 'error') {
                    showNotificationAll("danger", "", response.message);
                    submitButton.prop('disabled', false).html(originalButtonText);
                }
                else {
                    showNotificationAll("danger", "", 'Something went wrong please try again!.');
                    submitButton.prop('disabled', false).html(originalButtonText);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let firstInvalidField = null;
                    $.each(errors, function (fieldName, messages) {
                        let input = form.find(`[name="${fieldName}"]`);
                        input.addClass('is-invalid');
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

    // Initialize Razorpay Payment
    function initializeRazorpayPayment(response) {
        var options = {
            "key": window.razorpayKey,
            "amount": response.amount,
            "currency": "INR",
            "name": "GD Sons",
            "description": "Order Payment",
            "image": "https://www.gdsons.co.in/public/frontend/assets/gd-img/fav-icon.png",
            "order_id": response.order_id,
            "handler": function (razorpayResponse) {
                handlePaymentSuccess(response, razorpayResponse);
            },
            "prefill": {
                "name": response.name,
                "email": response.email,
                "contact": response.contact
            },
            "notes": {
                "address": "Customer Address"
            },
            "theme": {
                "color": "#F37254"
            },
            "modal": {
                "ondismiss": function () {
                    $('button[type="submit"]').prop('disabled', false).html('Place Order');
                }
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();

        rzp.on('payment.failed', function (response) {
            handlePaymentFailure(response, response.order_db_id);
        });
    }

    // Handle Payment Success
    function handlePaymentSuccess(initResponse, razorpayResponse) {
        let submitButton = $('#checkoutFormSubmit button[type="submit"]');
        let originalButtonText = submitButton.html();

        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: initResponse.callback_url,
            type: 'POST',
            data: {
                razorpay_payment_id: razorpayResponse.razorpay_payment_id,
                razorpay_order_id: razorpayResponse.razorpay_order_id,
                razorpay_signature: razorpayResponse.razorpay_signature,
                order_db_id: initResponse.order_db_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    showNotificationAll("danger", "", response.message);
                    submitButton.prop('disabled', false).html(originalButtonText);
                }
            },
            error: function (xhr) {
                showNotificationAll("danger", "", "Payment verification failed. Please contact support.");
                submitButton.prop('disabled', false).html(originalButtonText);
            }
        });
    }

    // Handle Payment Failure
    function handlePaymentFailure(response, orderDbId) {
        let submitButton = $('#checkoutFormSubmit button[type="submit"]');
        let originalButtonText = submitButton.html();

        $.ajax({
            url: '/payment-failed',
            type: 'POST',
            data: {
                razorpay_payment_id: response.error.metadata.payment_id,
                razorpay_order_id: response.error.metadata.order_id,
                order_db_id: orderDbId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    showNotificationAll("danger", "", "Payment failed. Please try again.");
                } else {
                    showNotificationAll("danger", "", "Payment failed. Could not update order status.");
                }
                submitButton.prop('disabled', false).html(originalButtonText);
            },
            error: function () {
                showNotificationAll("danger", "", "Payment failed. Please try again.");
                submitButton.prop('disabled', false).html(originalButtonText);
            }
        });
    }
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
            success: function (response) {
                if (response.data && response.data.original) {
                    var responseData = response.data.original;
                    form[0].reset();
                    submitButton.prop('disabled', false).html(originalButtonText);
                    if (responseData.redirect_url) {
                        console.log("Redirecting to:", response.redirect_url);
                        window.location.href = responseData.redirect_url;
                    }
                } else {
                    alert("Something went wrong!");
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let firstInvalidField = null;
                    $.each(errors, function (fieldName, messages) {
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