$(document).ready(function () {
    /* Order Status dropdown change  */
      $(document).on('change', 'select[name="update_order_status"]', function () {
        var selectElement = $(this);
        var selectedStatus = selectElement.val();
        var selectedText = selectElement.find('option:selected').text().trim();
        var customerId = selectElement.data('cusid');
        var orderId = selectElement.data('orderid');
        var updateUrl = selectElement.data('url'); 
        var trackingFormUrl = selectElement.data('tracking-form-url');
        var deliveredCouponFormUrl = selectElement.data('delivered-coupon-form-url');
        if (selectedStatus === "") return; 
        if (selectedText.toLowerCase() === 'shipped') {
            $.ajax({
                url: trackingFormUrl + '?order_status_id=' + selectedStatus,
                type: 'GET',
                success: function (data) {
                    $("#commanModel .modal-title").html('Add Tracking Link');
                    $("#commanModel .modal-dialog").removeAttr('class').addClass('modal-dialog modal-md');
                    $('#commanModel .render-data').html(data.form);
                    $("#commanModel").modal('show');
                },
                error: function () {
                    Toastify({
                        text: 'Failed to load tracking link form',
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true
                    }).showToast();
                    selectElement.val('');
                }
            });
        } else if (selectedText.toLowerCase() === 'delivered') {
            $.ajax({
                url: deliveredCouponFormUrl + '?order_status_id=' + selectedStatus,
                type: 'GET',
                success: function (data) {
                    $("#commanModel .modal-title").html('Select Coupon for Delivery Email');
                    $("#commanModel .modal-dialog").removeAttr('class').addClass('modal-dialog modal-lg');
                    $('#commanModel .render-data').html(data.form);
                    $("#commanModel").modal('show');
                },
                error: function () {
                    Toastify({
                        text: 'Failed to load coupon form',
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true
                    }).showToast();
                    selectElement.val('');
                }
            });
        } else {
            submitOrderStatusUpdate(selectElement, updateUrl, selectedStatus, customerId, null);
        }
    });
 
    function submitOrderStatusUpdate(selectElement, updateUrl, selectedStatus, customerId, trackingLink) {
        $.ajax({
            url: updateUrl,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                order_status_id: selectedStatus,
                customer_id: customerId,
                tracking_link: trackingLink
            },
            beforeSend: function () {
                selectElement.prop('disabled', true);
            },
            success: function (response) {
                if (response.success) {
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true
                    }).showToast();
                    location.reload();
                } else {
                    Toastify({
                        text: response.message || "Failed to update order status!",
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        className: "bg-warning",
                        close: true
                    }).showToast();
                    selectElement.prop('disabled', false);
                }
            },
            error: function (xhr) {
                var message = (xhr.responseJSON && xhr.responseJSON.message) || 'Error updating order status!';
                Toastify({
                    text: message,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                    close: true
                }).showToast();
                selectElement.prop('disabled', false);
            },
            complete: function () {
                selectElement.prop('disabled', false);
            }
        });
    }
 
    // ── Tracking Link / Delivered Coupon mini form submit ─────────────
    // Both forms post to the same update-order-status route, so one handler covers both.
    $(document).off('submit', '#trackingLinkForm, #deliveredCouponForm').on('submit', '#trackingLinkForm, #deliveredCouponForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        var originalBtnText = submitButton.html();
 
        form.find('.form-control').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');
 
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
 
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                submitButton.prop('disabled', false).html(originalBtnText);
                if (response.success) {
                    $('#commanModel').modal('hide');
                    Toastify({
                        text: response.message,
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        escapeMarkup: false,
                        close: true
                    }).showToast();
                    location.reload();
                } else {
                    Toastify({
                        text: response.message || 'Failed to update status',
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        className: "bg-warning",
                        close: true
                    }).showToast();
                }
            },
            error: function (xhr) {
                submitButton.prop('disabled', false).html(originalBtnText);
                var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                if (errors) {
                    $.each(errors, function (key, value) {
                        var input = $('#' + key);
                        input.addClass('is-invalid');
                        $('#' + key + '_error').text(value[0]);
                    });
                } else {
                    var message = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong!';
                    Toastify({
                        text: message,
                        duration: 8000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true
                    }).showToast();
                }
            }
        });
    });
 
    // If the tracking-link / delivered-coupon modal is closed without submitting,
    // reset the dropdown so it doesn't visually stay stuck on that status.
    $('#commanModel').on('hidden.bs.modal', function () {
        if ($('#trackingLinkForm').length || $('#deliveredCouponForm').length) {
            $('select[name="update_order_status"]').val('');
        }
    });
 

    /*Shiprocket order update content */
    $(document).on('click', '.sr-action', function (e) {
        e.preventDefault();
        let btn = $(this);
        let url = btn.data('url');
        let order_status_id = btn.data('order-status-id');
        let actionText = btn.data('action-text');
        let originalText = btn.text();
        Swal.fire({
            title: `Are you sure you want to ${actionText}?`,
            text: "This action will sync with Shiprocket.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Yes, ${actionText}!`,
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                btn.addClass('disabled').text('Processing…');
                $('#loader').show();                      
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        order_status_id: order_status_id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        console.log("Response:", res);
                        if (res.status === 'success') {
                            let toastClass = "bg-success";
                            if (res.shiprocket_status === 'order_updated') {
                                toastClass = "bg-info";
                            }
                            else if (res.shiprocket_status === 'awb_generated') {
                                toastClass = "bg-primary";
                            }                            
                            Toastify({
                                text: res.msg,
                                duration: 10000,
                                gravity: "top",
                                position: "right",
                                className: toastClass,
                                close: true
                            }).showToast();                            
                            if (res.order_list) {
                                $('#order-list-table').html(res.order_list);
                            }
                            $('#loader').hide();
                        } else {
                            Toastify({
                                text: res.msg || "Something went wrong!",
                                duration: 10000,
                                gravity: "top",
                                position: "right",
                                className: "bg-danger",
                                close: true
                            }).showToast();
                            $('#loader').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText);
                        const message = xhr.responseJSON?.msg 
                            || xhr.responseJSON?.message 
                            || "Request failed. Please try again.";
                        Toastify({
                            text: message,
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true
                        }).showToast();
                        $('#loader').hide();
                    },
                    complete: function () {
                        btn.removeClass('disabled').text(originalText);
                        $('#loader').hide();
                    }
                });
            }
        });
    });
    /*Shiprocket order update content */
    /*  Upd. Deduction */
    $(document).on('click', '.update-deduction', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('route');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
        };
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);        
        $.ajax({
            url: url,
            type: 'get',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });

    $(document).off('submit', '#updateDeductionForm').on('submit', '#updateDeductionForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        var formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false);
                submitButton.html('Save changes');
                if (response.status === 'success') {
                    form[0].reset();
                    $('#commanModel').modal('hide');
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        escapeMarkup: false,
                        close: true,
                        onClick: function () { }
                    }).showToast();
                }
            },
            error: function(xhr, status, error) {
                submitButton.prop('disabled', false);
                submitButton.html('Save changes');
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        var errorElement = $('#' + key + '_error');
                        if (errorElement.length) {
                            errorElement.text(value[0]);
                        }
                        var inputField = $('#' + key);
                        inputField.addClass('is-invalid');
                        inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                    });
                }
            }
        });
    });
    /*  Upd. Deduction */

});