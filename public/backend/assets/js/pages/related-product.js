$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
var baseUrl = $('meta[name="base-url"]').attr("content");
// store selected product ids
var selectedProducts = [];
$(document).ready(function () {
    /* Add new row */
    $("#addMoreRelatedProduct").on("click", function () {
        const newRow = `
        <tr>
            <td>
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text" name="product_name[]" class="form-control related-product-autocomplete">
                        <span class="input-group-text">
                            <i class="ti ti-refresh"></i>
                            <div class="spinner-border spinner-border-sm product-loader" role="status" style="display:none;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </span>
                    </div>
                    <input type="hidden" name="product_id[]" class="product_id">
                </div>
            </td>
            <td>
                <input type="text" name="related_title[]" class="form-control">
            </td>
            <td>
                <textarea name="related_description[]" class="form-control"></textarea>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">
                    <i class="ti ti-trash"></i>
                </button>
            </td>
        </tr>
        `;

        $("#productTable tbody").append(newRow);
    });


    /* Autocomplete */
    $(document).on("focus", ".related-product-autocomplete", function () {
        var $input = $(this);
        var $loader = $input.closest(".input-group").find(".product-loader");
        var $refreshIcon = $input.closest(".input-group").find("i");
        if ($input.data("ui-autocomplete")) {
            $input.autocomplete("destroy");
        }
        $input.autocomplete({
            minLength: 2,
            source: function (request, response) {
                $loader.show();
                $refreshIcon.hide();
                $.ajax({
                    url: baseUrl + "/autocomplete/products-whatsapp",
                    data: {
                        query: request.term,
                        page: 1,
                    },
                    success: function (data) {
                        $loader.hide();
                        $refreshIcon.show();
                        var filtered = data.filter(function (product) {
                            return !selectedProducts.includes(product.id.toString());
                        });

                        response(
                            filtered.map(function (product) {
                                return {
                                    label: product.title,
                                    value: product.title,
                                    id: product.id,
                                };
                            })
                        );
                    },
                    error: function () {
                        $loader.hide();
                        $refreshIcon.show();
                        response([]);
                    },
                });
            },

            select: function (event, ui) {
                var $row = $(this).closest("tr");
                var oldId = $row.find(".product_id").val();
                if (oldId) {
                    selectedProducts = selectedProducts.filter(id => id != oldId);
                }
                $row.find(".product_id").val(ui.item.id);
                $(this).val(ui.item.label);
                selectedProducts.push(ui.item.id.toString());
                return false;
            },

            change: function (event, ui) {
                if (!ui.item) {
                    var $row = $(this).closest("tr");
                    var oldId = $row.find(".product_id").val();
                    if (oldId) {
                        selectedProducts = selectedProducts.filter(id => id != oldId);
                    }
                    $row.find(".product_id").val("");
                }
            }
        });

        $input.autocomplete("instance")._renderItem = function (ul, item) {
            var term = $.ui.autocomplete.escapeRegex($input.val().toLowerCase());
            var matcher = new RegExp("(" + term + ")", "i");
            var highlightedText = item.label.replace(
                matcher,
                '<span style="font-weight:bold;">$1</span>'
            );
            return $("<li>")
                .append("<div>" + highlightedText + "</div>")
                .appendTo(ul);
        };
    });

    $(document).on("input", ".related-product-autocomplete", function () {
        if ($(this).val() === "") {
            var $row = $(this).closest("tr");
            var oldId = $row.find(".product_id").val();
            if (oldId) {
                selectedProducts = selectedProducts.filter(id => id != oldId);
            }
            $row.find(".product_id").val("");
        }
    });


    /* Remove row */
    $(document).on("click", ".remove-row", function () {
        var $row = $(this).closest("tr");
        var oldId = $row.find(".product_id").val();
        if (oldId) {
            selectedProducts = selectedProducts.filter(id => id != oldId);
        }
        $row.remove();
    });


    /* Submit form */
    $(document).on("submit", "#add_related_product_form", function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('input[type="submit"],button[type="submit"]');
        submitButton.prop("disabled", true).val("Saving...");
        var formData = new FormData(this);
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                submitButton.prop("disabled", false).val("Submit");
                if (response.status === "success") {
                    form[0].reset();
                    selectedProducts = [];
                    Toastify({
                        text: response.message,
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                    }).showToast();
                    if (response.redirect_url) {
                        setTimeout(function () {
                            window.location.href = response.redirect_url;
                        }, 800);
                    }
                }
            },
            error: function (error) {
                submitButton.prop("disabled", false).val("Submit");
                let errorMessage = "An unexpected error occurred.";
                if (error.responseJSON) {
                    if (error.responseJSON.errors) {
                        let errorDetails = "<ul>";
                        $.each(error.responseJSON.errors, function (field, messages) {
                            errorDetails += `<li>${messages.join(", ")}</li>`;
                        });
                        errorDetails += "</ul>";
                        errorMessage = errorDetails;
                    } else if (error.responseJSON.message) {
                        errorMessage = error.responseJSON.message;
                    }
                }
                $("#error-container").html(
                    `<div class="alert alert-danger">${errorMessage}</div>`
                );
            }
        });

    });

});