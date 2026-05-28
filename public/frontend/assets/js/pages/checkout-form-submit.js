$(document).ready(function () {
    $(document)
        .off("submit", "#checkoutFormSubmit")
        .on("submit", "#checkoutFormSubmit", function (e) {
            e.preventDefault();
            let form = $(this);
            let paymentType = $('input[name="payment_type"]:checked').val();
            let submitButton = form.find('button[type="submit"]');
            let originalButtonText = submitButton.html();
            form.find(".is-invalid").removeClass("is-invalid");
            form.find(".invalid-feedback").remove();
            submitButton
                .prop("disabled", true)
                .html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
            $.ajax({
                url: form.attr("action"),
                method: "POST",
                data: form.serialize(),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                success: function (response) {
                    if (response.status == "success") {
                        if (
                            response.payment_type == "Cash on Delivery" ||
                            response.payment_type == "Pick Up From Store"
                        ) {
                            showNotificationAll(
                                "success",
                                "",
                                response.message,
                            );
                            var mobileNumber = getMobileNumberFromForm();
                            var size = "md";
                            var data = {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content",
                                ),
                                mobile_number: mobileNumber,
                            };
                            $.ajax({
                                url: otpVerificationUrl,
                                method: "GET",
                                data: data,
                                success: function (data) {
                                    $("#commoanModal .modal-render-data").html(
                                        data.form,
                                    );
                                    $("#commoanModal .modal-dialog").addClass(
                                        "modal-" + size,
                                    );
                                    $("#commoanModal").modal("show");
                                    submitButton
                                        .prop("disabled", false)
                                        .html(originalButtonText);
                                },
                            });
                        }
                        // if (response.data && response.data.original) {
                        //     var responseData = response.data.original;
                        //     form[0].reset();
                        //     submitButton.prop('disabled', false).html(originalButtonText);
                        //     if (responseData.redirect_url) {
                        //         window.location.href = responseData.redirect_url;
                        //     }
                        // } else {
                        //     showNotificationAll("danger", "", 'Something went wrong please try again!.');
                        // }
                    } else if (response.status == "razorpay") {
                        submitButton
                            .prop("disabled", false)
                            .html(originalButtonText);
                        initializeRazorpayPayment(response);
                    } else if (response.status == "error") {
                        showNotificationAll("danger", "", response.message);
                        submitButton
                            .prop("disabled", false)
                            .html(originalButtonText);
                    } else {
                        showNotificationAll(
                            "danger",
                            "",
                            "Something went wrong please try again!.",
                        );
                        submitButton
                            .prop("disabled", false)
                            .html(originalButtonText);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let firstInvalidField = null;
                        $.each(errors, function (fieldName, messages) {
                            let input = form.find(`[name="${fieldName}"]`);
                            input.addClass("is-invalid");
                            if (firstInvalidField === null) {
                                firstInvalidField = input;
                            }
                        });
                        if (firstInvalidField) {
                            firstInvalidField.focus();
                        }
                    } else {
                        showNotificationAll(
                            "danger",
                            "",
                            "An unexpected error occurred. Please try again later.",
                        );
                    }
                    submitButton
                        .prop("disabled", false)
                        .html(originalButtonText);
                },
            });
        });

    /* Initialize Razorpay Payment */
    function initializeRazorpayPayment(response) {
        /* alert(JSON.stringify(response));*/
        var options = {
            key: window.razorpayKey,
            amount: response.amount,
            //"amount": 100,
            currency: "INR",
            name: "GD Sons",
            description: "Order Payment",
            image: "https://www.gdsons.co.in/public/frontend/assets/gd-img/fav-icon.png",
            order_id: response.order_id,
            handler: function (razorpayResponse) {
                handlePaymentSuccess(response, razorpayResponse);
            },
            prefill: {
                name: response.name,
                email: response.email,
                contact: response.contact,
            },
            notes: {
                address: "Customer Address",
                actual_amount: response.amount,
            },
            theme: {
                color: "#F37254",
            },
            modal: {
                ondismiss: function () {
                    $('button[type="submit"]')
                        .prop("disabled", false)
                        .html("Place Order");
                },
            },
        };

        var rzp = new Razorpay(options);
        rzp.open();

        rzp.on("payment.failed", function (response) {
            handlePaymentFailure(response, response.order_db_id);
        });
    }
    // Handle Payment Success
    function handlePaymentSuccess(initResponse, razorpayResponse) {
        let submitButton = $('#checkoutFormSubmit button[type="submit"]');
        let originalButtonText = submitButton.html();

        submitButton
            .prop("disabled", true)
            .html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: initResponse.callback_url,
            type: "POST",
            data: {
                razorpay_payment_id: razorpayResponse.razorpay_payment_id,
                razorpay_order_id: razorpayResponse.razorpay_order_id,
                razorpay_signature: razorpayResponse.razorpay_signature,
                order_db_id: initResponse.order_db_id,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    showNotificationAll("danger", "", response.message);
                    submitButton
                        .prop("disabled", false)
                        .html(originalButtonText);
                }
            },
            error: function (xhr) {
                showNotificationAll(
                    "danger",
                    "",
                    "Payment verification failed. Please contact support.",
                );
                submitButton.prop("disabled", false).html(originalButtonText);
            },
        });
    }

    // Handle Payment Failure
    function handlePaymentFailure(response, orderDbId) {
        let submitButton = $('#checkoutFormSubmit button[type="submit"]');
        let originalButtonText = submitButton.html();

        $.ajax({
            url: "/payment-failed",
            type: "POST",
            data: {
                razorpay_payment_id: response.error.metadata.payment_id,
                razorpay_order_id: response.error.metadata.order_id,
                order_db_id: orderDbId,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    showNotificationAll(
                        "danger",
                        "",
                        "Payment failed. Please try again.",
                    );
                } else {
                    showNotificationAll(
                        "danger",
                        "",
                        "Payment failed. Could not update order status.",
                    );
                }
                submitButton.prop("disabled", false).html(originalButtonText);
            },
            error: function () {
                showNotificationAll(
                    "danger",
                    "",
                    "Payment failed. Please try again.",
                );
                submitButton.prop("disabled", false).html(originalButtonText);
            },
        });
    }

    function getMobileNumberFromForm() {
        let selectedAddress = $('input[name="customer_address_id"]:checked');
        if (selectedAddress.length > 0) {
            let addressDiv = selectedAddress.closest(".delivery-address-box");
            let phoneText = addressDiv
                .find(".delivery-address-detail li:last-child h6")
                .text();
            let phoneMatch = phoneText.match(/\d{10}/);
            return phoneMatch ? phoneMatch[0] : "";
        } else {
            return $('input[name="ship_phone_number"]').val();
        }
    }

    function resendOTP(mobileNumber, button, otpResendUrl) {
        if (button.prop("disabled")) {
            return;
        }
        button
            .prop("disabled", true)
            .addClass("opacity-50 cursor-not-allowed")
            .text("Resending...");
        $.ajax({
            url: otpResendUrl,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                mobile_number: mobileNumber,
            },
            success: function (response) {
                if (response.status === "success") {
                    showNotificationAll("success", "", response.message);
                    let remaining = response.remaining_attempts ?? 0;
                    if (remaining > 0) {
                        button.text("Resend OTP (" + remaining + " left)");
                        setTimeout(function () {
                            button
                                .prop("disabled", false)
                                .removeClass("opacity-50 cursor-not-allowed")
                                .text("Resend OTP");
                        }, 30000);
                    } else {
                        button.text("Limit Reached");
                    }
                } else {
                    showNotificationAll("danger", "", response.message);

                    button
                        .prop("disabled", false)
                        .removeClass("opacity-50 cursor-not-allowed")
                        .text("Resend OTP");
                }
            },
            error: function (xhr) {
                let message = xhr.responseJSON?.message ?? "Failed to resend OTP.";
                showNotificationAll("danger", "", message);
                button.text("Limit Reached");
            },
        });
    }

    $(document)
        .off("click", ".resend-otp-btn")
        .on("click", ".resend-otp-btn", function () {
            let button = $(this);
            if (button.prop("disabled")) {
                return;
            }
            let mobileNumber = button.data("mobile");
            let otpResendUrl = button.data("route");
            resendOTP(mobileNumber, button, otpResendUrl);
        });
});
