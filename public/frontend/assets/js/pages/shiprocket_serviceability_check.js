(function ($) {

    // -----------------------------------------
    // Event: Existing Customer Address Radio Click
    // -----------------------------------------
    $(document).on('change', '.exiting_customer_address_radio', function () {
        let pincode = $(this).data('pincode');
        $("#checkout_pincode").val(pincode);
        if (pincode && /^\d{6}$/.test(pincode)) {
            handleServiceabilityCheck(pincode);
        }
    });

    // -----------------------------------------
    // EVENT: Pincode Manual Typing
    // -----------------------------------------
    $(document).on('keyup', '#checkout_pincode', function () {
        let pincode = $(this).val().trim();
        if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
            handleServiceabilityCheck(pincode);
        }
    });

    // -----------------------------------------
    // EVENT: Payment Type Change
    // -----------------------------------------
    $(document).on('change', "input[name='payment_type']", function () {
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

    // -----------------------------------------
    // MAIN SERVICEABILITY FUNCTION
    // -----------------------------------------
    function handleServiceabilityCheck(pincode) {
        let paymentType = $("input[name='payment_type']:checked").val();
        let placeOrderBtn = $("button[type='submit']");

        if (paymentType === "Pick Up From Store") {
            updateTotals(0);
            $(".courier-radio").hide();
            $("#courier_partner").html('<span class="text-success">Pick Up From Store — No Shipping Charges</span>');
            placeOrderBtn.prop('disabled', false);
            return;
        }

        $(".courier-radio").show();
        if (!pincode || !/^\d{6}$/.test(pincode)) return;
        let cartJsonInput = $('#cart_items_json');
        if (!cartJsonInput.length) {
            console.error("cart_items_json input not found!");
            return;
        }
        let cartItems = JSON.parse(cartJsonInput.val());
        let totalWeight = calculateTotalWeight(cartItems);
        $("#shipping_status").html("Checking serviceability...");
        $("#shipping_loader").show();
        let cod = paymentType === "Cash on Delivery" ? 1 : 0;
        $.ajax({
            url: window.shiprocketCheckUrl,
            type: "POST",
            data: {
                pincode: pincode,
                total_weight: totalWeight,
                cod: cod,
                payment_type: paymentType,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                $("#shipping_loader").hide();
                if (!res.success) {
                    $("#courier_partner").html(
                        `<span class="text-danger">${res.checkout_sidebar}</span>`
                    );
                    updateTotals(0);
                    placeOrderBtn.prop('disabled', true);
                    return;
                }

                $("#checkout-sidebar").html(res.checkout_sidebar);
                placeOrderBtn.prop('disabled', false);
                let first = $(".shipping_radio:checked");
                if (first.length) {
                    first.trigger("change");
                }
            },
            error: function () {
                $("#shipping_loader").hide();
                $("#shipping_status").html(
                    `<span class="text-danger">Error checking serviceability.</span>`
                );
            }
        });
    }

    // -----------------------------------------
    // CALCULATE TOTAL WEIGHT
    // -----------------------------------------
    function calculateTotalWeight(items) {
        let totalWeight = 0;
        items.forEach(i => {
            let qty = parseFloat(i.qty) || 1;
            let physicalWeight = parseFloat(i.weight) || 0;
            /* Volumetric Weight = L * B * H / 5000 */
            let volWeight = 0;
            if (i.length > 0 && i.breadth > 0 && i.height > 0) {
                volWeight = (i.length * i.breadth * i.height) / 5000;
            }
            let finalWeight = Math.max(physicalWeight, volWeight);

            totalWeight += finalWeight * qty;
        });

        return totalWeight;
    }

    // -----------------------------------------
    // UPDATE TOTALS
    // -----------------------------------------
    function updateTotals(shipping) {
        let subtotal = parseFloat($("#subtotal_amount").text().replace(/,/g, '')) || 0;
        let total = subtotal + shipping;

        $("#shipping_amount").text(shipping.toFixed(2));
        $("#grand_total_amount_span").text(total.toFixed(2));
        $("#grand_total_amount_input").val(total.toFixed(2));
        $("#selected_shipping_rate").val(shipping);

        if (shipping === 0) {
            $("#selected_courier_company_id").val('');
            $("#selected_cod_charges").val(0);
            $("#selected_courier_id").val('');
        }
    }

    // -----------------------------------------
    // EVENT: Shipping Radio Change
    // -----------------------------------------
    $(document).on('change', '.shipping_radio', function () {
        let shipping = parseFloat($(this).data("rate")) || 0;
        let courierName = $(this).data("courier-name") || '';
        let courierCompanyId = $(this).data("courier-company-id") || '';
        let codCharges = parseFloat($(this).data("cod-charges")) || 0;
        let courierId = $(this).data("courier-id") || '';
        let delivery_expected_date = $(this).data("courier-delivery-expected-date") || '';

        updateTotals(shipping);
        $("#selected_courier_name").val(courierName);
        $("#selected_courier_company_id").val(courierCompanyId);
        $("#selected_cod_charges").val(codCharges);
        $("#selected_courier_id").val(courierId);
        $("#selected_courier_delivery_expected_date").val(delivery_expected_date);
    });

    // -----------------------------------------
    // ON PAGE LOAD → AUTO-RUN FIRST ADDRESS
    // -----------------------------------------
    $(document).ready(function () {
        /*  Auto-trigger serviceability for default checked address*/
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
            $("#courier_partner").html('<span class="text-success">Pick Up From Store — No Shipping Charges</span>');
        }
    });
    /**Get Locality Details from shiprocket api */
    $(document).ready(function (){
        $(document).on('keyup', '#checkout_pincode, #checkout_pincode_add_new_address, #checkout_pincode_edit_address', function () {
            let pincode = $(this).val().trim();
            if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
                checkShiprocketLocalityDetails(pincode);
            }
        });
    })

    function checkShiprocketLocalityDetails(pincode){
        let placeOrderBtn = $("button[type='submit']");
        if (!pincode || !/^\d{6}$/.test(pincode)) return;
        $.ajax({
            url: window.shiprocketCheckLocalityUrl,
            type: "POST",
            data: {
                pincode: pincode,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (!res.success) {
                    placeOrderBtn.prop('disabled', true);
                    $('input[name="ship_state"]').val('');
                    $('input[name="ship_city_name"]').val('');
                    return;
                }
                placeOrderBtn.prop('disabled', false);
                $('input[name="ship_state"]').val(res.state);
                $('input[name="ship_city_name"]').val(res.city);
                /* for modal open add new address */
                $('input[name="state"]').val(res.state);
                $('input[name="city_name"]').val(res.city);
                /* for modal open add new address */
                /*if (res.locality_list && res.locality_list.length) {
                    console.log("Localities:", res.locality_list);
                }*/
            },
            error: function () {
                console.log("Shiprocket API failed");
            }
        });
    }
    /**Get Locality Details from shiprocket api */

})(jQuery);
