$(document).ready(function () {
    $(document).on("click", ".edit-shipping-btn", function () {
        var card = $(this).closest(".card");
        card.find(".view-mode-content").hide();
        card.find(".edit-mode-content").show();
    });

    /* Cancel button click */
    $(document).on("click", ".cancel-shipping-btn", function () {
        var card = $(this).closest(".card");
        var id = $(this).data("id");
        card.find(".edit-post-office").val(
            card.find(".view-mode-content h4").text().split(" ,")[0],
        );
        card.find(".edit-pincode").val(
            card.find(".view-mode-content h4").text().split(",")[1]?.trim(),
        );
        card.find(".edit-weight-450gm").val(
            card.find(".weight-450gm-view").text().replace("₹", ""),
        );
        card.find(".edit-weight-750gm").val(
            card.find(".weight-750gm-view").text().replace("₹", ""),
        );
        card.find(".edit-weight-1350gm").val(
            card.find(".weight-1350gm-view").text().replace("₹", ""),
        );
        card.find(".edit-weight-3400gm").val(
            card.find(".weight-3400gm-view").text().replace("₹", ""),
        );
        card.find(".edit-weight-7500gm").val(
            card.find(".weight-7500gm-view").text().replace("₹", ""),
        );
        card.find(".edit-weight-14kg").val(
            card.find(".weight-14kg-view").text().replace("₹", ""),
        );
        card.find(".edit-weight-25kg").val(
            card.find(".weight-25kg-view").text().replace("₹", ""),
        );

        card.find(".view-mode-content").show();
        card.find(".edit-mode-content").hide();
    });

    /* Save button click */
    $(document).on("click", ".save-shipping-btn", function () {
        var button = $(this);
        var card = button.closest(".card");
        var id = button.data("id");
        var updateUrl = button.data('update-url'); 
        card.find(".form-control").removeClass("is-invalid");
        card.find(".invalid-feedback").remove();
        button
            .prop("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...',
            );
        var formData = new FormData();
        formData.append("id", id);
        formData.append("post_office", card.find(".edit-post-office").val());
        formData.append("pincode", card.find(".edit-pincode").val());
        formData.append("weight_450gm", card.find(".edit-weight-450gm").val());
        formData.append("weight_750gm", card.find(".edit-weight-750gm").val());
        formData.append(
            "weight_1350gm",
            card.find(".edit-weight-1350gm").val(),
        );
        formData.append(
            "weight_3400gm",
            card.find(".edit-weight-3400gm").val(),
        );
        formData.append(
            "weight_7500gm",
            card.find(".edit-weight-7500gm").val(),
        );
        formData.append("weight_14kg", card.find(".edit-weight-14kg").val());
        formData.append("weight_25kg", card.find(".edit-weight-25kg").val());
        formData.append("_method", "PUT");
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        $.ajax({
            url: updateUrl, 
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "success") {
                    card.find(".view-mode-content h4").text(
                        card.find(".edit-post-office").val() +
                            " , " +
                        card.find(".edit-pincode").val(),
                    );
                    card.find(".weight-450gm-view").text(
                        "₹" +
                            parseFloat(
                                card.find(".edit-weight-450gm").val(),
                            ).toFixed(2),
                    );
                    card.find(".weight-750gm-view").text(
                        "₹" +
                            parseFloat(
                                card.find(".edit-weight-750gm").val(),
                            ).toFixed(2),
                    );
                    card.find(".weight-1350gm-view").text(
                        "₹" +
                            parseFloat(
                                card.find(".edit-weight-1350gm").val(),
                            ).toFixed(2),
                    );
                    card.find(".weight-3400gm-view").text(
                        "₹" +
                            parseFloat(
                                card.find(".edit-weight-3400gm").val(),
                            ).toFixed(2),
                    );
                    card.find(".weight-7500gm-view").text(
                        "₹" +
                            parseFloat(
                                card.find(".edit-weight-7500gm").val(),
                            ).toFixed(2),
                    );
                    card.find(".weight-14kg-view").text(
                        "₹" +
                            parseFloat(
                                card.find(".edit-weight-14kg").val(),
                            ).toFixed(2),
                    );
                    card.find(".weight-25kg-view").text(
                        "₹" +
                            parseFloat(
                                card.find(".edit-weight-25kg").val(),
                            ).toFixed(2),
                    );
                    card.find(".view-mode-content").show();
                    card.find(".edit-mode-content").hide();
                    if (typeof Toastify !== "undefined") {
                        Toastify({
                            text: response.message,
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            className: "bg-success",
                            close: true,
                        }).showToast();
                    } else {
                       Toastify({
                            text: response.message,
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            className: "bg-info",
                            close: true,
                        }).showToast();
                    }
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        var inputField = card.find(".edit-" + key);
                        if (inputField.length) {
                            inputField.addClass("is-invalid");
                            inputField.after(
                                '<div class="invalid-feedback">' +
                                value[0] +
                                "</div>",
                            );
                        }
                    });

                    if (typeof Toastify !== "undefined") {
                        Toastify({
                            text: "Please fix validation errors",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true,
                        }).showToast();
                    }
                } else {
                    if (typeof Toastify !== "undefined") {
                        Toastify({
                            text:
                                xhr.responseJSON?.message ||
                                "An error occurred!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true,
                        }).showToast();
                    } else {
                        alert(
                            xhr.responseJSON?.message || "An error occurred!",
                        );
                    }
                }
            },
            complete: function () {
                button
                    .prop("disabled", false)
                    .html('<i class="ti ti-check"></i> Save');
            },
        });
    });
});
