$(document).ready(function () {
    $(document).on('change', 'select[name="update_order_status"]', function () {
        var selectElement = $(this);
        var selectedStatus = selectElement.val();
        var customerId = selectElement.data('cusid');
        var updateUrl = selectElement.data('url');
        if (selectedStatus !== "") {
            $.ajax({
                url: updateUrl,
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order_status_id: selectedStatus,
                    customer_id: customerId
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
                            text: "Failed to update order status!",
                            duration: 5000,
                            gravity: "top",
                            position: "right",
                            className: "bg-warning",
                            close: true
                        }).showToast();
                    }
                },
                error: function (xhr) {
                    Toastify({
                        text: 'Error updating order status!',
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true,
                        onClick: function () { }
                    }).showToast();
                },
                complete: function () {
                    selectElement.prop('disabled', false);
                }
            });
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