$(document).ready(function () {
    var ROUTES = window.INVENTORY_ROUTES || {};
    var INDEX_URL = ROUTES.index || "/manage-inventory";
    var DELETE_URL = ROUTES.delete || "/manage-inventory/delete/";
    var SAVE_ALL_URL = ROUTES.bulkUpdate || "/manage-inventory/bulk-update";


    /**Scroll th header fix */
    var $topbar = $('header.topbar');
    var $tableWrapper = $('#product-list-container-with-inventory');
    var $floatingWrapper = $('<table class="table align-middle mb-0 table-hover table-centered" id="example-2-floating-wrapper"></table>')
        .appendTo('body')
        .hide();
    var isFloating = false;

    function getTable() {
        return $('#example-2');
    }
    function getThead() {
        return getTable().find('thead');
    }

    function rebuildFloatingHead() {
        $floatingWrapper.empty().append(getThead().clone());
    }

    function syncColumnWidths() {
        getThead().find('th').each(function (i) {
            $floatingWrapper.find('th').eq(i).css('width', $(this).outerWidth() + 'px');
        });
    }
    function positionFloatingHead() {
        var $table = getTable();
        var offset = $table.offset();
        if (!offset) return;
        var headerHeight = $topbar.outerHeight() || 0;
        $floatingWrapper.css({
            position: 'fixed',
            top: '128px',
            left: (offset.left - $tableWrapper.scrollLeft()) + 'px',
            width: $table.outerWidth() + 'px',
            zIndex: 1000,
            margin: 0,
            tableLayout: 'fixed',
            boxShadow: 'rgba(0, 0, 0, 0.12) 0px 2px 6px',
            backgroundColor: '#f8f9fa',
            padding: '8px',
        });
    }

    function toggleFloatingHead() {
        var $thead = getThead();
        if ($thead.length === 0) {
            if (isFloating) { $floatingWrapper.hide(); isFloating = false; }
            return;
        }
        var headerHeight = $topbar.outerHeight() || 0;
        var shouldFloat = $(window).scrollTop() > ($thead.offset().top - headerHeight);

        if (shouldFloat) {
            rebuildFloatingHead();
            syncColumnWidths();
            positionFloatingHead();
            if (!isFloating) $floatingWrapper.show();
            isFloating = true;
        } else if (isFloating) {
            $floatingWrapper.hide();
            isFloating = false;
        }
    }

    $(window).on('scroll resize', toggleFloatingHead);
    $tableWrapper.on('scroll', function () {
        if (isFloating) positionFloatingHead();
    });
    /**Scroll th header fix */

    function csrf() {
        return $('meta[name="csrf-token"]').attr("content");
    }
    function toast(text, className) {
        Toastify({
            text: text,
            duration: 10000,
            gravity: "top",
            position: "right",
            className: className,
            close: true,
            onClick: function () {},
        }).showToast();
    }
    function num(selector, row) {
        return parseFloat(row.find(selector).val()) || 0;
    }

    /* ---------------------------------------------------------------
       Every rate is one flat row: product name + all its fields
       together, no popup and no separate section to open. Everything
       gets saved together via the single "Save All" button below.
    ------------------------------------------------------------------ */

    function allInvRows() {
        return $("tr.inv-row");
    }

    function rowsForProduct(pid) {
        return $("tr.inv-row[data-product-id='" + pid + "']");
    }

    function recalcRow(row) {
        var mrp = num(".row-mrp", row);
        var offer = num(".row-offer-rate", row);
        var ship = num(".row-shipment-rate", row);
        var totalField = row.find(".row-offer-shipment-rate");
        var bachatBadge = row.find(".row-bachat-badge");
        var percentBadge = row.find(".row-savings-percent-badge");

        if (offer <= 0) {
            totalField.val("");
            bachatBadge.text("Bachat: \u20B90.00");
            percentBadge.text("0.00%");
            clearRowWarning(row);
            return;
        }

        var total = offer + ship;
        totalField.val(total.toFixed(2));

        /* Shipping + Offer Rate MRP se jyada nahi ho sakta */
        if (mrp > 0 && total > mrp) {
            bachatBadge.text("Bachat: \u20B90.00");
            percentBadge.text("0.00%");
            showRowWarning(row, mrp, total);
            return;
        }

        clearRowWarning(row);

        if (mrp > 0) {
            var bachat = mrp - total;
            var percent = (bachat / mrp) * 100;
            bachatBadge.text("Bachat: \u20B9" + bachat.toFixed(2));
            percentBadge.text(percent.toFixed(2) + "%");
        } else {
            bachatBadge.text("Bachat: \u20B90.00");
            percentBadge.text("0.00%");
        }
    }

    function showRowWarning(row, mrp, total) {
        row.addClass("rate-over-mrp");
        row.find(".row-offer-shipment-rate, .row-offer-rate").addClass("is-invalid");

        var cell = row.find(".row-offer-shipment-rate").closest("td");
        var warning = cell.find(".row-rate-warning");
        if (warning.length === 0) {
            warning = $('<div class="row-rate-warning text-danger small mt-1" style="font-weight:600;"></div>');
            cell.append(warning);
        }
        warning
            .text(
                "Over MRP by \u20B9" + (total - mrp).toFixed(2) + " \u2014 lower Offer Rate or Shipping.",
            )
            .show();
    }

    function clearRowWarning(row) {
        row.removeClass("rate-over-mrp");
        row.find(".row-offer-shipment-rate, .row-offer-rate").removeClass("is-invalid");
        row.find(".row-rate-warning").remove();
    }

    function recalcGstAndGain(row) {
        var gstPercent = parseFloat(row.data("gst")) || 0;
        var purchase = num(".row-purchase-rate", row);
        var offer = num(".row-offer-rate", row);
        var calcRow = row.next(".calculated-row-inventory");

        if (calcRow.length === 0) {
            return;
        }

        var preGstEl = calcRow.find(".row-pre-gst");
        var gstEl = calcRow.find(".row-gst-amount");
        var gainEl = calcRow.find(".row-net-gain");
        var gainPercEl = calcRow.find(".row-net-gain-perc");

        if (purchase > 0) {
            var preGst = purchase / (1 + gstPercent / 100);
            var gstAmount = purchase - preGst;
            preGstEl.val(preGst.toFixed(2));
            gstEl.val(gstAmount.toFixed(2));
        } else {
            preGstEl.val("");
            gstEl.val("");
        }

        if (purchase > 0) {
            var netGain = offer - purchase;
            var netGainPerc = (netGain / purchase) * 100;
            gainEl.val(netGain.toFixed(2));
            gainPercEl.val(netGainPerc.toFixed(2));
            gainEl.toggleClass("text-success", netGain >= 0).toggleClass("text-danger", netGain < 0);
        } else {
            gainEl.val("").removeClass("text-success text-danger");
            gainPercEl.val("");
        }
    }

    function resetRowToBlank(row) {
        row.attr("data-inventory-id", "");
        row.find(".row-mrp").val("");
        row.find(".row-purchase-rate").val("");
        row.find(".row-offer-rate").val("");
        row.find(".row-shipment-rate").val("");
        row.find(".row-offer-shipment-rate").val("");
        row.find(".row-stock-qty").val("");
        row.find(".row-savings-badge").hide();
        row.find(".remove-inv-row").removeAttr("data-name");
        clearRowWarning(row);

        var calcRow = row.next(".calculated-row-inventory");
        calcRow.find(".row-pre-gst, .row-gst-amount, .row-net-gain-perc").val("");
        calcRow.find(".row-net-gain").val("").removeClass("text-success text-danger");
    }

    /* The product-name cell (with the Add Rate / Auto-calc buttons) is
       shared across all of a product's rate rows via rowspan, so it
       only appears once. Whenever rows are added or removed, this puts
       that cell back on the first row of the group with the right
       rowspan, and marks the last row so the border under it lines up. */
    function renumberProductGroup(pid) {
        var rows = rowsForProduct(pid);
        if (rows.length === 0) {
            return;
        }

        var nameCell = rows.find("td.product-cell").first();
        if (nameCell.length === 0) {
            return;
        }

        nameCell.detach();
        nameCell.attr("rowspan", rows.length * 2);

        rows.each(function () {
            $(this).next(".calculated-row-inventory").removeClass("group-end");
        });

        rows.first().prepend(nameCell);
        rows.last().next(".calculated-row-inventory").addClass("group-end");
    }

    function buildBlankRateRow(pid, gstPercent) {
        return $(
            '<tr class="inv-row" data-product-id="' + pid + '" data-gst="' + gstPercent + '" data-inventory-id="">' +
                '<td><input type="number" step="1" class="form-control form-control-sm row-mrp" placeholder="MRP"></td>' +
                '<td><input type="number" step="1" class="form-control form-control-sm row-purchase-rate" placeholder="Purchase"></td>' +
                '<td><input type="number" step="1" class="form-control form-control-sm row-offer-rate" placeholder="Offer"></td>' +
                '<td><input type="number" step="0.01" class="form-control form-control-sm row-shipment-rate" placeholder="Shipping"></td>' +
                '<td>' +
                    '<input type="number" step="0.01" class="form-control form-control-sm row-offer-shipment-rate" readonly>' +
                    '<span class="badge bg-info-subtle text-info mt-1 row-bachat-badge">Bachat: \u20B90.00</span>' +
                    '<span class="badge bg-warning-subtle text-info mt-1 row-savings-percent-badge">0.00%</span>' +
                '</td>' +
                '<td><input type="number" class="form-control form-control-sm row-stock-qty" placeholder="Qty"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger remove-inv-row"><i class="ti ti-trash"></i></button></td>' +
                "</tr>",
        );
    }

    function buildBlankCalcRow(pid) {
        return $(
            '<tr class="calculated-row-inventory bg-light-subtle" data-product-id="' + pid + '">' +
                '<td class="text-muted small">Calculated Values:</td>' +
                "<td>" +
                '<label class="small text-muted mb-0 d-block">Pre GST Amount</label>' +
                '<input type="text" class="form-control form-control-sm row-pre-gst" placeholder="Pre GST Amount" readonly>' +
                '<label class="small text-muted mb-0 d-block mt-1">GST Amount</label>' +
                '<input type="text" class="form-control form-control-sm row-gst-amount" placeholder="GST Amount" readonly>' +
                "</td>" +
                "<td>" +
                '<label class="small text-muted mb-0 d-block">Net Gain</label>' +
                '<input type="text" class="form-control form-control-sm row-net-gain" placeholder="Net Gain" readonly>' +
                '<label class="small text-muted mb-0 d-block mt-1">Net Gain %</label>' +
                '<input type="text" class="form-control form-control-sm row-net-gain-perc" placeholder="Net Gain %" readonly>' +
                "</td>" +
                '<td colspan="4"></td>' +
                "</tr>",
        );
    }

    /* Offer rate auto-fill = ceil((MRP + Purchase Rate) / 2) */
    $(document).on("input", ".row-mrp, .row-purchase-rate", function () {
        var row = $(this).closest("tr.inv-row");
        var mrp = num(".row-mrp", row);
        var purchase = num(".row-purchase-rate", row);
        if (mrp > 0 || purchase > 0) {
            row.find(".row-offer-rate").val(Math.ceil((mrp + purchase) / 2));
        }
        recalcRow(row);
        recalcGstAndGain(row);
    });

    $(document).on("input", ".row-offer-rate, .row-shipment-rate", function () {
        var row = $(this).closest("tr.inv-row");
        recalcRow(row);
        recalcGstAndGain(row);
    });

    /* + Add Rate — appends one more blank rate row (plus its own
       Calculated Values row) under the SAME product name (the name
       cell spans all of that product's rows, so it is never repeated). */
    $(document).on("click", ".add-inv-row-btn", function () {
        var pid = $(this).data("product-id");
        var gstPercent = rowsForProduct(pid).first().data("gst") || 0;
        var newRateRow = buildBlankRateRow(pid, gstPercent);
        var newCalcRow = buildBlankCalcRow(pid);
        var lastRateRow = rowsForProduct(pid).last();
        var lastCalcRow = lastRateRow.next(".calculated-row-inventory");

        (lastCalcRow.length ? lastCalcRow : lastRateRow).after(newRateRow);
        newRateRow.after(newCalcRow);
        renumberProductGroup(pid);
    });

    /* Remove a rate row. Unsaved rows just disappear; saved ones are
       deleted from the server after confirmation. If it was the only
       row left for that product, reset it to blank instead of
       removing it entirely, so there's always somewhere to add a new
       rate without reloading the page. */
    $(document).on("click", ".remove-inv-row", function () {
        var row = $(this).closest("tr.inv-row");
        var calcRow = row.next(".calculated-row-inventory");
        var pid = row.data("product-id");
        var inventoryId = row.data("inventory-id");

        if (!inventoryId) {
            if (rowsForProduct(pid).length <= 1) {
                resetRowToBlank(row);
            } else {
                row.remove();
                calcRow.remove();
                renumberProductGroup(pid);
            }
            return;
        }

        Swal.fire({
            title: "Delete this rate?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then(function (result) {
            if (!result.isConfirmed) {
                return;
            }
            $.ajax({
                url: DELETE_URL + inventoryId,
                type: "DELETE",
                data: { id: inventoryId, _token: csrf() },
                success: function (response) {
                    if (rowsForProduct(pid).length <= 1) {
                        resetRowToBlank(row);
                    } else {
                        row.remove();
                        calcRow.remove();
                        renumberProductGroup(pid);
                    }
                    toast(response.message || "Deleted successfully!", "bg-success");
                },
                error: function (xhr) {
                    toast(
                        (xhr.responseJSON && xhr.responseJSON.error) ||
                            "Could not delete this row.",
                        "bg-danger",
                    );
                },
            });
        });
    });

    /* Auto-calc Shipping — fills every rate row of one product from the
       volumetric-weight estimate, same calculation as before. */
    $(document).on("click", ".auto-calc-shipping-btn", function () {
        var button = $(this);
        var pid = button.data("product-id");
        var originalHtml = button.html();

        button
            .prop("disabled", true)
            .html('<span class="spinner-border spinner-border-sm"></span> Calculating...');

        $.ajax({
            url: button.data("route"),
            type: "POST",
            data: { _token: csrf() },
            success: function (response) {
                if (!response.success) {
                    toast(response.message, "bg-info");
                    return;
                }
                var rate = parseFloat(response.shipment_rate);
                rowsForProduct(pid).each(function () {
                    var row = $(this);
                    row.find(".row-shipment-rate").val(rate.toFixed(2));
                    recalcRow(row);
                });
                toast(response.message, "bg-success");
            },
            error: function (xhr) {
                toast(
                    (xhr.responseJSON && xhr.responseJSON.message) || "Something went wrong.",
                    "bg-danger",
                );
            },
            complete: function () {
                button.prop("disabled", false).html(originalHtml);
            },
        });
    });

    /* Save All — gathers every row on the page that has an MRP entered
       and saves them together in one request. Blank template rows that
       were never touched are skipped automatically. */
    $(document).on("click", "#save-all-inventory-btn", function () {
        var button = $(this);
        var rows = [];
        var blockingErrors = 0;

        allInvRows().each(function () {
            recalcRow($(this));
        });

        allInvRows().each(function () {
            if ($(this).hasClass("rate-over-mrp")) {
                blockingErrors++;
            }
        });

        if (blockingErrors > 0) {
            toast(
                blockingErrors +
                    " row(s) have Shipping + Offer Rate above MRP \u2014 fix those before saving.",
                "bg-danger",
            );
            return;
        }

        allInvRows().each(function () {
            var row = $(this);
            var mrp = row.find(".row-mrp").val();
            if (mrp === "" || mrp === null) {
                return; // untouched blank row, nothing to save
            }
            rows.push({
                product_id: row.data("product-id"),
                inventory_id: row.data("inventory-id") || "",
                mrp: mrp,
                purchase_rate: row.find(".row-purchase-rate").val(),
                offer_rate: row.find(".row-offer-rate").val(),
                shipment_rate: row.find(".row-shipment-rate").val(),
                stock_quantity: row.find(".row-stock-qty").val(),
            });
        });

        if (rows.length === 0) {
            toast("Nothing to save.", "bg-info");
            return;
        }

        var originalText = button.html();
        button
            .prop("disabled", true)
            .html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        $.ajax({
            url: SAVE_ALL_URL,
            type: "POST",
            data: {
                _token: csrf(),
                rows: rows,
            },
            success: function (response) {
                toast(response.message, response.failed > 0 ? "bg-warning" : "bg-success");

                if (response.failed > 0 && response.results) {
                    var messages = response.results
                        .filter(function (r) {
                            return !r.success;
                        })
                        .map(function (r) {
                            return "<li>" + r.message + "</li>";
                        })
                        .join("");
                    $("#bulk-save-errors").html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            "<strong>Some rows were not saved:</strong><ul class='mb-0'>" +
                            messages +
                            "</ul></div>",
                    );
                } else {
                    $("#bulk-save-errors").html("");
                }

                var page =
                    $("#pagination-links .active").find("a").data("page") ||
                    $("#pagination-links .active").find("span").text() ||
                    1;

                fetchProductsWithInventory(
                    $("#category-filter").val(),
                    $("#product-search").val(),
                    parseInt(page),
                    $("#product-status").val(),
                );
            },
            error: function (xhr) {
                toast(
                    (xhr.responseJSON && xhr.responseJSON.message) || "Could not save changes.",
                    "bg-danger",
                );
            },
            complete: function () {
                button.prop("disabled", false).html(originalText);
            },
        });
    });

    /* Listing: pagination, filters */

    $(document).on("click", "#pagination-links a", function (e) {
        e.preventDefault();
        fetchProductsWithInventory(
            $("#category-filter").val(),
            $("#product-search").val(),
            $(this).attr("href").split("page=")[1],
            $("#product-status").val(),
        );
    });

    $(document).on("change", "#category-filter, #product-status", updateFilters);
    $(document).on("keyup", "#product-search", updateFilters);

    $(document).on("click", "#reset-button", function () {
        $("#category-filter, #product-search, #product-status").val("");
        $("#reset-button").hide();
        fetchProductsWithInventory();
    });

    function updateFilters() {
        var categoryId = $("#category-filter").val();
        var search = $("#product-search").val();
        var productStatus = $("#product-status").val();

        if (categoryId || search || productStatus) {
            $("#reset-button").show();
        } else {
            $("#reset-button").hide();
        }

        fetchProductsWithInventory(categoryId, search, 1, productStatus);
    }

    function fetchProductsWithInventory(categoryId, search, page, productStatus) {
        $("#loader").show();

        $.ajax({
            url: INDEX_URL,
            type: "GET",
            data: {
                category_id: categoryId || "",
                search: search || "",
                page: page || 1,
                product_status: productStatus || "",
            },
            success: function (data) {
                $("#product-list-container-with-inventory").html(data);
                $("#loader").hide();
            },
            error: function () {
                toast("An error occurred while filtering products.", "bg-danger");
                $("#loader").hide();
                toggleFloatingHead();
            },
        });
    }
});