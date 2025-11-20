(function ($) {
    // ---------------------------
    // Event: Pincode Input Change
    // ---------------------------
    $(document).on('keyup', '#checkout_pincode', function () {
        let pincode = $(this).val().trim();
        if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
            checkDeliveryServiceability(pincode);
        }
    });
    // ---------------------------
    // Main Function: Check Serviceability
    // ---------------------------
    function checkDeliveryServiceability(pincode) {
        let cartJsonInput = $('#cart_items_json');
        if (!cartJsonInput.length) {
            console.error("cart_items_json input not found!");
            return;
        }
        let cartItems = JSON.parse(cartJsonInput.val());
        let totalWeight = calculateTotalWeight(cartItems);
        $("#shipping_status").html("Checking serviceability...");
        $("#shipping_loader").show();
        let placeOrderBtn = $("button[type='submit']");
        $.ajax({
            url: window.shiprocketCheckUrl,
            type: "POST",
            data: {
                pincode: pincode,
                total_weight: totalWeight,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                $("#shipping_loader").hide();
                if (!res.success) {
                    $("#courier_partner").html(
                        `<span class="text-danger">Delivery not available at this pincode.</span>`
                    );
                    $("#shipping_amount").text(0);
                    $("#grand_total_amount_span").text($("#subtotal_amount").text());
                    $("#grand_total_amount_input").val($("#subtotal_amount").text());
                    placeOrderBtn.prop('disabled', true);
                    return;
                }

                $("#checkout-sidebar").html(res.checkout_sidebar);
                placeOrderBtn.prop('disabled', false);
                let first = $(".shipping_radio:checked");
                if(first.length){
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
    // ---------------------------
    // Helper Function: Calculate Weight
    // ---------------------------
    function calculateTotalWeight(items) {
        let total = 0;
        items.forEach(i => {
            total += (i.weight * i.qty);
        });
        return total;
    }
    // ---------------------------
    // Shipping Radio Change
    // ---------------------------
    $(document).on('change', '.shipping_radio', function () {
        let shipping = parseFloat($(this).data("rate")) || 0;
        let courierCompanyId = $(this).data("courier-company-id") || '';
        let codCharges = parseFloat($(this).data("cod-charges")) || 0;
        let courierId = $(this).data("courier-id") || '';
        let subtotal = parseFloat($("#subtotal_amount").text().replace(/,/g, '')) || 0;
        let total = subtotal + shipping;
        $("#shipping_amount").text(shipping.toFixed(2));
        $("#grand_total_amount_span").text(total.toFixed(2));
        $("#grand_total_amount_input").val(total.toFixed(2));
        $("#selected_shipping_rate").val(shipping);
        $("#selected_courier_company_id").val(courierCompanyId);
        $("#selected_cod_charges").val(codCharges);
        $("#selected_courier_id").val(courierId);
    });

    // ---------------------------
    // On Document Ready: Trigger First Checked
    // ---------------------------
    $(document).ready(function () {
        let first = $(".shipping_radio:checked");
        if(first.length){
            first.trigger("change");
        }
    });
})(jQuery);
