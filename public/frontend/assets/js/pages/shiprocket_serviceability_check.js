(function ($) {
    /* COUPON APPLY EVENT */
    $(document).on("click", ".apply-coupon-btn", function (e) {
        e.preventDefault();
        let couponCode = $("#apply-coupon-input").val().trim();
        let $btn = $(this);
        if (!couponCode) {
            showNotificationAll(
                "warning",
                "Warning",
                "Please enter a coupon code",
            );
            return;
        }
        let originalText = $btn.html();
        $btn.html(
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Applying...',
        ).prop("disabled", true);

        applyCoupon(couponCode, $btn, originalText);
    });
    /* COUPON APPLY FUNCTION */
    function applyCoupon(couponCode, $btn, originalText) {
        let subtotal =
            parseFloat($("#subtotal_amount").text().replace(/,/g, "")) || 0;
        let shipping =
            parseFloat($("#shipping_amount").text().replace(/,/g, "")) || 0;
        let paymentType = $("input[name='payment_type']:checked").val();
        let pincode = $("#checkout_pincode").val().trim();

        $.ajax({
            url: window.applyCouponUrl,
            type: "POST",
            data: {
                coupon_code: couponCode,
                subtotal: subtotal,
                shipping: shipping,
                payment_type: paymentType,
                pincode: pincode,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (res) {
                if (res.success) {
                    $("#apply-coupon-input").val("");
                    $("#applied_coupon_code").val(couponCode);
                    $("#coupon_discount_amount").val(res.discount_amount);
                    if ($("#applied-coupon-alert").length === 0) {
                        let alertHtml =
                            '<div class="alert alert-success alert-dismissible" id="applied-coupon-alert">' +
                            "<strong>Coupon Applied:</strong> " +
                            couponCode +
                            '<button type="button" class="btn-close float-end" id="remove-coupon-btn" aria-label="Close"></button>' +
                            "</div>";
                        $(".coupon-cart").append(alertHtml);
                    } else {
                        $("#applied-coupon-alert").html(
                            "<strong>Coupon Applied:</strong> " +
                                couponCode +
                                '<button type="button" class="btn-close float-end" id="remove-coupon-btn" aria-label="Close"></button>',
                        );
                    }
                    let discountAmount = parseFloat(res.discount_amount) || 0;
                    smoothUpdateTotalsWithCoupon(
                        shipping,
                        discountAmount,
                        subtotal,
                    );
                    showNotificationAll("success", "Success", res.message);
                    if (pincode && /^\d{6}$/.test(pincode)) {
                        setTimeout(function () {
                            handleServiceabilityCheck(pincode);
                        }, 300);
                    }
                } else {
                    showNotificationAll("warning", "Warning", res.message);
                }
            },
            error: function () {
                showNotificationAll(
                    "warning",
                    "Warning",
                    "Error applying coupon",
                );
            },
            complete: function () {
                if ($btn && originalText) {
                    $btn.html(originalText).prop("disabled", false);
                }
            },
        });
    }
    /* SMOOTH UPDATE TOTALS WITH COUPON */
    function smoothUpdateTotalsWithCoupon(shipping, discount, subtotal) {
        shipping = parseFloat(shipping) || 0;
        discount = parseFloat(discount) || 0;
        subtotal = parseFloat(subtotal) || 0;
        let total = subtotal + shipping - discount;
        animateNumber($("#shipping_amount"), shipping);
        animateNumber($("#coupon_discount_display"), discount);
        animateNumber($("#grand_total_amount_span"), total);
        $("#grand_total_amount_input").val(total.toFixed(2));
        if (discount > 0) {
            $(".coupon-discount-row").slideDown(300);
        } else {
            $(".coupon-discount-row").slideUp(300);
        }
    }
    /* ANIMATE NUMBER FUNCTION */
    function animateNumber($element, newValue) {
        let oldValue = parseFloat($element.text()) || 0;
        let step = (newValue - oldValue) / 10;
        let current = oldValue;
        let count = 0;
        let interval = setInterval(function () {
            count++;
            current += step;
            if (count >= 10) {
                $element.text(newValue.toFixed(2));
                clearInterval(interval);
            } else {
                $element.text(current.toFixed(2));
            }
        }, 20);
    }
    /* REMOVE COUPON */
    $(document).on("click", "#remove-coupon-btn", function () {
        let $btn = $(this);
        let originalHtml = $btn.html();
        $btn.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
        ).prop("disabled", true);

        $.ajax({
            url: window.removeCouponUrl,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (res) {
                if (res.success) {
                    $("#applied_coupon_code").val("");
                    $("#coupon_discount_amount").val(0);
                    $("#applied-coupon-alert").slideUp(300, function () {
                        $(this).remove();
                    });
                    let subtotal =
                        parseFloat(
                            $("#subtotal_amount").text().replace(/,/g, ""),
                        ) || 0;
                    let shipping =
                        parseFloat(
                            $("#shipping_amount").text().replace(/,/g, ""),
                        ) || 0;
                    smoothUpdateTotalsWithCoupon(shipping, 0, subtotal);
                    let pincode = $("#checkout_pincode").val().trim();
                    if (pincode && /^\d{6}$/.test(pincode)) {
                        setTimeout(function () {
                            handleServiceabilityCheck(pincode);
                        }, 300);
                    }
                    showNotificationAll(
                        "success",
                        "Success",
                        "Coupon removed successfully",
                    );
                }
            },
            complete: function () {
                $btn.html(originalHtml).prop("disabled", false);
            },
        });
    });

    /* UPDATE TOTALS WITH COUPON */
    function updateTotalsWithCoupon(shipping, discount, subtotal) {
        shipping = parseFloat(shipping) || 0;
        discount = parseFloat(discount) || 0;
        subtotal = parseFloat(subtotal) || 0;
        let total = subtotal + shipping - discount;
        $("#shipping_amount").text(shipping.toFixed(2));
        $("#coupon_discount_display").text(discount.toFixed(2));
        $("#grand_total_amount_span").text(total.toFixed(2));
        $("#grand_total_amount_input").val(total.toFixed(2));
        if (discount > 0) {
            $(".coupon-discount-row").show();
        } else {
            $(".coupon-discount-row").hide();
        }
    }

    /* MODIFIED UPDATE TOTALS FUNCTION */
    function updateTotals(shipping) {
        let subtotal =
            parseFloat($("#subtotal_amount").text().replace(/,/g, "")) || 0;
        let discount = parseFloat($("#coupon_discount_amount").val()) || 0;
        let total = subtotal + shipping - discount;
        $("#shipping_amount").text(shipping.toFixed(2));
        if (discount > 0) {
            $("#coupon_discount_display").text(discount.toFixed(2));
            $(".coupon-discount-row").show();
        }
        $("#grand_total_amount_span").text(total.toFixed(2));
        $("#grand_total_amount_input").val(total.toFixed(2));
        $("#selected_shipping_rate").val(shipping);

        if (shipping === 0) {
            $("#selected_courier_company_id").val("");
            $("#selected_cod_charges").val(0);
            $("#selected_courier_id").val("");
        }
    }

    /* MODIFIED HANDLE SERVICEABILITY FUNCTION */
    function handleServiceabilityCheck(pincode) {
        let paymentType = $("input[name='payment_type']:checked").val();
        let placeOrderBtn = $("button[type='submit']");
        let couponCode = $("#applied_coupon_code").val();
        if (paymentType === "Pick Up From Store") {
            updateTotals(0);
            $(".courier-radio").hide();
            $("#courier_partner").html(
                '<span class="text-success">Pick Up From Store — No Shipping Charges</span>',
            );
            placeOrderBtn.prop("disabled", false);
            return;
        }

        $(".courier-radio").show();
        if (!pincode || !/^\d{6}$/.test(pincode)) return;

        let cartJsonInput = $("#cart_items_json");
        if (!cartJsonInput.length) {
            console.error("cart_items_json input not found!");
            return;
        }

        let cartItems = JSON.parse(cartJsonInput.val());
        let totalWeight = calculateTotalWeight(cartItems);

        $("#shipping_status").html("Checking serviceability...");
        $("#shipping_loader").fadeIn(200);

        let cod = paymentType === "Cash on Delivery" ? 1 : 0;

        $.ajax({
            url: window.shiprocketCheckUrl,
            type: "POST",
            data: {
                pincode: pincode,
                total_weight: totalWeight,
                cod: cod,
                payment_type: paymentType,
                coupon_code: couponCode,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                placeOrderBtn.prop("disabled", true).addClass("btn-loading");
            },
            success: function (res) {
                $("#shipping_loader").fadeOut(200);

                if (!res.success) {
                    $("#courier_partner")
                        .html(
                            `<span class="text-danger">${res.checkout_sidebar}</span>`,
                        )
                        .fadeIn(300);
                    updateTotals(0);
                    placeOrderBtn.prop("disabled", true);
                    return;
                }
                $("#checkout-sidebar").fadeOut(200, function () {
                    $(this).html(res.checkout_sidebar).fadeIn(300);

                    let discount =
                        parseFloat($("#coupon_discount_amount").val()) || 0;
                    if (discount > 0) {
                        let subtotal =
                            parseFloat(
                                $("#subtotal_amount").text().replace(/,/g, ""),
                            ) || 0;
                        let shipping =
                            parseFloat(
                                $(".shipping_radio:checked").data("rate"),
                            ) || 0;
                        updateTotalsWithCoupon(shipping, discount, subtotal);
                    }

                    placeOrderBtn
                        .prop("disabled", false)
                        .removeClass("btn-loading");

                    let first = $(".shipping_radio:checked");
                    if (first.length) {
                        first.trigger("change");
                    }
                });
            },
            error: function () {
                $("#shipping_loader").fadeOut(200);
                $("#shipping_status").html(
                    `<span class="text-danger">Error checking serviceability.</span>`,
                );
                placeOrderBtn
                    .prop("disabled", false)
                    .removeClass("btn-loading");
            },
        });
    }

    /* Event: Existing Customer Address Radio Click */
    $(document).on("change", ".exiting_customer_address_radio", function () {
        let pincode = $(this).data("pincode");
        $("#checkout_pincode").val(pincode);
        if (pincode && /^\d{6}$/.test(pincode)) {
            handleServiceabilityCheck(pincode);
        }
    });

    /* EVENT: Pincode Manual Typing with Debounce */
    let pincodeTimer;
    $(document).on("keyup", "#checkout_pincode", function () {
        clearTimeout(pincodeTimer);
        let pincode = $(this).val().trim();

        if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
            pincodeTimer = setTimeout(function () {
                handleServiceabilityCheck(pincode);
            }, 500);
        }
    });

    /* EVENT: Payment Type Change */
    $(document).on("change", "input[name='payment_type']", function () {
        let selectedAddress = $(".exiting_customer_address_radio:checked");
        let pincode = "";

        if (selectedAddress.length) {
            pincode = selectedAddress.data("pincode");
            $("#checkout_pincode").val(pincode);
        } else {
            pincode = $("#checkout_pincode").val().trim();
        }

        if (pincode && /^\d{6}$/.test(pincode)) {
            handleServiceabilityCheck(pincode);
        }
    });

    /* CALCULATE TOTAL WEIGHT */
    function calculateTotalWeight(items) {
        let totalWeight = 0;
        items.forEach((i) => {
            let qty = parseFloat(i.qty) || 1;
            let physicalWeight = parseFloat(i.weight) || 0;
            let volWeight = 0;

            if (i.length > 0 && i.breadth > 0 && i.height > 0) {
                volWeight = (i.length * i.breadth * i.height) / 5000;
            }

            let finalWeight = Math.max(physicalWeight, volWeight);
            totalWeight += finalWeight * qty;
        });

        return totalWeight;
    }

    /* EVENT: Shipping Radio Change */
    $(document).on("change", ".shipping_radio", function () {
        let shipping = parseFloat($(this).data("rate")) || 0;
        let courierName = $(this).data("courier-name") || "";
        let courierCompanyId = $(this).data("courier-company-id") || "";
        let codCharges = parseFloat($(this).data("cod-charges")) || 0;
        let courierId = $(this).data("courier-id") || "";
        let delivery_expected_date =
            $(this).data("courier-delivery-expected-date") || "";

        updateTotals(shipping);

        $("#selected_courier_name").val(courierName);
        $("#selected_courier_company_id").val(courierCompanyId);
        $("#selected_cod_charges").val(codCharges);
        $("#selected_courier_id").val(courierId);
        $("#selected_courier_delivery_expected_date").val(
            delivery_expected_date,
        );
    });

    /* ON PAGE LOAD → AUTO-RUN FIRST ADDRESS */
    $(document).ready(function () {
        let firstAddr = $(".exiting_customer_address_radio:checked");

        if (firstAddr.length) {
            let pin = firstAddr.data("pincode");
            $("#checkout_pincode").val(pin);
            if (pin && /^\d{6}$/.test(pin)) {
                handleServiceabilityCheck(pin);
            }
        }

        let firstShip = $(".shipping_radio:checked");
        if (firstShip.length) firstShip.trigger("change");

        let paymentType = $("input[name='payment_type']:checked").val();
        if (paymentType === "Pick Up From Store") {
            updateTotals(0);
            $(".courier-radio").hide();
            $("#courier_partner").html(
                '<span class="text-success">Pick Up From Store — No Shipping Charges</span>',
            );
        }
    });

    /* Get Locality Details from shiprocket api with Debounce */
    let localityTimer;
    $(document).on(
        "keyup",
        "#checkout_pincode, #checkout_pincode_add_new_address, #checkout_pincode_edit_address",
        function () {
            clearTimeout(localityTimer);
            let pincode = $(this).val().trim();

            if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
                localityTimer = setTimeout(function () {
                    checkShiprocketLocalityDetails(pincode);
                }, 500);
            }
        },
    );

    function checkShiprocketLocalityDetails(pincode) {
        let placeOrderBtn = $("button[type='submit']");
        if (!pincode || !/^\d{6}$/.test(pincode)) return;
        $.ajax({
            url: window.shiprocketCheckLocalityUrl,
            type: "POST",
            data: {
                pincode: pincode,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $(document).trigger("locality-check-start");
            },
            success: function (res) {
                if (!res.success) {
                    placeOrderBtn.prop("disabled", true);
                    $('input[name="ship_state"]').val("");
                    $('input[name="ship_city_name"]').val("");
                    return;
                }

                placeOrderBtn.prop("disabled", false);
                $('input[name="ship_state"]').val(res.state);
                $('input[name="ship_city_name"]').val(res.city);
                $('input[name="state"]').val(res.state);
                $('input[name="city_name"]').val(res.city);
            },
            error: function () {
                console.log("Shiprocket API failed");
            },
            complete: function () {
                $(document).trigger("locality-check-complete");
            },
        });
    }
})(jQuery);
