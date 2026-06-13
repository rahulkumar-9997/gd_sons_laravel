$(document).ready(function () {
    /* CHECKOUT FORM SUBMIT */
    $(document)
        .off("submit", "#checkoutFormSubmit")
        .on("submit", "#checkoutFormSubmit", function (e) {
            e.preventDefault();
            const form             = $(this);
            const submitButton     = form.find('button[type="submit"]');
            const originalBtnHtml  = submitButton.html();
            form.find(".is-invalid").removeClass("is-invalid");
            form.find(".invalid-feedback").remove();
            if (!validateCheckoutForm(form)) return;
            submitButton.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Submitting…');
            $.ajax({
                url    : form.attr("action"),
                method : "POST",
                data   : form.serialize(),
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                success: function (response) {
                    //alert(response);
                    console.log(response);
                    if (response && response.status === true) {
                        showNotificationAll("success", "", response.message);
                        if (response.payment_type === 'Cash on Delivery' || response.payment_type === 'Pick Up From Store') {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                submitButton.prop('disabled', false).html(originalBtnHtml);
                                showNotificationAll("danger", "", "Redirect URL missing.");
                            }
                            /*const mobileNumber = getMobileNumberFromForm();
                            $.ajax({
                                url :otpVerificationUrl,
                                method: "GET",
                                data  : {
                                    _token:$('meta[name="csrf-token"]').attr("content"),
                                    mobile_number: mobileNumber,
                                },
                                success: function (data) {
                                    $("#commoanModal .modal-render-data").html(data.form);
                                    $("#commoanModal .modal-dialog").addClass("modal-md");
                                    $("#commoanModal").modal("show");
                                    submitButton.prop("disabled", false).html(originalBtnHtml);
                                },
                                error: function () {
                                    showNotificationAll("danger", "", "Could not load OTP form.");
                                    submitButton.prop("disabled", false).html(originalBtnHtml);
                                },
                            });
                            */
                        }
                        else if (response.payment_type === "razorpay") {
                            submitButton.prop("disabled", false).html(originalBtnHtml);
                            initializeRazorpayPayment(response);
                        } 
                        else {
                            showNotificationAll("danger", "", "Unknown payment type.");
                            submitButton.prop("disabled", false).html(originalBtnHtml);
                        }
                    }
                    else if (response && response.status === false) {
                        showNotificationAll("danger", "", response.message || "Something went wrong.");
                        submitButton.prop("disabled", false).html(originalBtnHtml);
                    }
                    else {
                        showNotificationAll("danger", "", "Unexpected response. Please try again.");
                        submitButton.prop("disabled", false).html(originalBtnHtml);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON?.errors ?? {};
                        let firstField = null;
                        $.each(errors, function (fieldName, messages) {
                            const selector = `[name="${fieldName}"], [name="${fieldName}[]"]`;
                            const input    = form.find(selector).first();

                            input.addClass("is-invalid");
                            input.after(
                                `<div class="invalid-feedback d-block">${messages[0]}</div>`
                            );
                            if (!firstField) firstField = input;
                        });
                        if (firstField && firstField.length) {
                            $("html, body").animate(
                                { scrollTop: firstField.offset().top - 120 },
                                400,
                                () => firstField.focus()
                            );
                        }
                    } else {
                        const msg = xhr.responseJSON?.message ?? "An unexpected error occurred.";
                        showNotificationAll("danger", "", msg);
                    }
                    submitButton.prop("disabled", false).html(originalBtnHtml);
                },
            });
        });

    
    /* CLIENT-SIDE VALIDATION */
    function validateCheckoutForm(form) {
        let valid = true;
        form.find("input[required]:visible, select[required]:visible").each(function () {
            if (!$(this).val().trim()) {
                markInvalid($(this), "This field is required.");
                valid = false;
            }
        });
        const phone = form.find('[name="ship_phone_number"]');
        if (phone.length && phone.val() && !/^\d{10}$/.test(phone.val())) {
            markInvalid(phone, "Enter a valid 10-digit phone number.");
            valid = false;
        }
        const pin = form.find('[name="ship_pin_code"]');
        if (pin.length && pin.val() && !/^\d{6}$/.test(pin.val())) {
            markInvalid(pin, "Enter a valid 6-digit pin code.");
            valid = false;
        }
        const email = form.find('[name="ship_email"]');
        if (email.length && email.val() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.val())) {
            markInvalid(email, "Enter a valid email address.");
            valid = false;
        }
        if (!valid) {
            const firstInvalid = form.find(".is-invalid").first();
            if (firstInvalid.length) {
                $("html, body").animate({ scrollTop: firstInvalid.offset().top - 120 }, 400, () => firstInvalid.focus());
            }
        }
        return valid;
    }

    function markInvalid($el, message) {
        $el.addClass("is-invalid");
        if (!$el.next(".invalid-feedback").length) {
            $el.after(`<div class="invalid-feedback d-block">${message}</div>`);
        }
    }
    /* RAZORPAY */
    function initializeRazorpayPayment(response) {
        const options = {
            key      : window.razorpayKey,
            amount   : response.amount,
            currency : "INR",
            name     : "GD Sons",
            description: "Order Payment",
            image    : "https://www.gdsons.co.in/public/frontend/assets/gd-img/fav-icon.png",
            order_id : response.order_id,
            handler: function (razorpayResponse) {
                handlePaymentSuccess(response, razorpayResponse);
            },
            prefill: {
                name   : response.name,
                email  : response.email,
                contact: response.contact,
            },
            notes: {
                order_db_id   : response.order_db_id,
                actual_amount : response.actual_amount,
            },
            theme: { color: "#F37254" },
            modal: {
                ondismiss: function () {
                    $('button[type="submit"]').prop("disabled", false).html("Place Order");
                },
            },
        };
        const rzp = new Razorpay(options);
        rzp.on("payment.failed", function (failResponse) {
            handlePaymentFailure(failResponse, response.order_db_id);
        });
        rzp.open();
    }

    /* Payment success callback */
    function handlePaymentSuccess(initResponse, razorpayResponse) {
        const submitButton    = $('#checkoutFormSubmit button[type="submit"]');
        const originalBtnHtml = submitButton.html();
        submitButton.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Processing…');
        $.ajax({
            url   : initResponse.callback_url,
            type  : "POST",
            data  : {
                razorpay_payment_id : razorpayResponse.razorpay_payment_id,
                razorpay_order_id   : razorpayResponse.razorpay_order_id,
                razorpay_signature  : razorpayResponse.razorpay_signature,
                order_db_id         : initResponse.order_db_id,
                _token              : $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    showNotificationAll("danger", "", response.message || "Payment verification failed.");
                    submitButton.prop("disabled", false).html(originalBtnHtml);
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message ?? "Payment verification failed. Please contact support.";
                showNotificationAll("danger", "", msg);
                submitButton.prop("disabled", false).html(originalBtnHtml);
            },
        });
    }

    /* Payment failure handler */
    function handlePaymentFailure(response, orderDbId) {
        const submitButton    = $('#checkoutFormSubmit button[type="submit"]');
        const originalBtnHtml = submitButton.html();
        const paymentId = response?.error?.metadata?.payment_id ?? null;
        const orderId   = response?.error?.metadata?.order_id   ?? null;
        $.ajax({
            url  : window.razorpayPaymentFailRoute,
            type : "POST",
            data : {
                razorpay_payment_id : paymentId,
                razorpay_order_id   : orderId,
                order_db_id         : orderDbId,
                _token              : $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                showNotificationAll("danger", "", "Payment failed. Please try again.");
                submitButton.prop("disabled", false).html(originalBtnHtml);
            },
            error: function () {
                showNotificationAll("danger", "", "Payment failed. Please try again.");
                submitButton.prop("disabled", false).html(originalBtnHtml);
            },
        });
    }

    /* OTP / RESEND */
    function getMobileNumberFromForm() {
        const selected = $('input[name="customer_address_id"]:checked');
        if (selected.length) {
            const box       = selected.closest(".delivery-address-box");
            const phoneText = box.find(".delivery-address-detail li:last-child h6").text();
            const match     = phoneText.match(/\d{10}/);
            return match ? match[0] : "";
        }
        return $('input[name="ship_phone_number"]').val() ?? "";
    }

    function resendOTP(mobileNumber, $button, otpResendUrl) {
        if ($button.prop("disabled")) return;
        $button.prop("disabled", true).addClass("opacity-50 cursor-not-allowed").text("Resending…");
        $.ajax({
            url:otpResendUrl,
            method: "POST",
            data: {
                _token:$('meta[name="csrf-token"]').attr("content"),
                mobile_number: mobileNumber,
            },
            success: function (response) {
                if (response.status === "success") {
                    showNotificationAll("success", "", response.message);
                    const remaining = response.remaining_attempts ?? 0;
                    if (remaining > 0) {
                        $button.text(`Resend OTP (${remaining} left)`);
                        setTimeout(() => {
                            $button.prop("disabled", false)
                                   .removeClass("opacity-50 cursor-not-allowed")
                                   .text("Resend OTP");
                        }, 30_000);
                    } else {
                        $button.text("Limit Reached");
                    }
                } else {
                    showNotificationAll("danger", "", response.message);
                    $button.prop("disabled", false)
                           .removeClass("opacity-50 cursor-not-allowed")
                           .text("Resend OTP");
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message ?? "Failed to resend OTP.";
                showNotificationAll("danger", "", msg);
                $button.text("Limit Reached");
            },
        });
    }

    $(document)
        .off("click", ".resend-otp-btn")
        .on("click", ".resend-otp-btn", function () {
            const $btn         = $(this);
            const mobileNumber = $btn.data("mobile");
            const otpResendUrl = $btn.data("route");
            resendOTP(mobileNumber, $btn, otpResendUrl);
        });
});