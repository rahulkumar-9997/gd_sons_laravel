$(document).ready(function () {
    $(document).on('click', 'a[data-ajax-coupon-add="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var couponCode = generateGDSCode();
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            coupon_code: couponCode
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
                flatpickr('#commanModel .flatpickr-date', {
                    dateFormat: "Y-m-d",
                    minDate: "today"
                });
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });
    
    $(document).off('click', '#saveCouponBtn').on('click', '#saveCouponBtn', function (event) {
        event.preventDefault();
        var form = $('#addCouponForm');
        var submitButton = $(this);
        if (!form.length) {
            console.error('Coupon form not found');
            return;
        }
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        var formData = new FormData(form[0]);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                submitButton.prop('disabled', false).html('Submit');
                if (response.status === 'success') {
                    form[0].reset();
                    $('#commanModel').modal('hide');
                    $('.coupon-list-table-render').html(response.couponContent);
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        escapeMarkup: false,
                        close: true
                    }).showToast();
                }
            },
            error: function (xhr) {
                submitButton.prop('disabled', false).html('Submit');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        var inputField = $('#' + key);
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            inputField.after(
                                '<div class="invalid-feedback">' + value[0] + '</div>'
                            );
                        }
                    });
                } else {
                    console.error(xhr.responseText);
                       Toastify({
                        text: xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "An error occurred while saving the coupon.",
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        escapeMarkup: false,
                        close: true
                    }).showToast();
                }
            }
        });
    });

    $(document).on('click', 'a[data-ajax-editcoupon-popup="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var couponCode = generateGDSCode();
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            coupon_code: couponCode
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
                flatpickr('#commanModel .flatpickr-date', {
                    dateFormat: "Y-m-d",
                    minDate: "today"
                });
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });

    $(document).off('click', '#updateCouponBtn').on('click', '#updateCouponBtn', function (event) {
        event.preventDefault();
        var form = $('#updateCouponForm');
        var submitButton = $(this);
        if (!form.length) {
            console.error('Coupon form not found');
            return;
        }
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        var formData = new FormData(form[0]);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                submitButton.prop('disabled', false).html('Submit');
                if (response.status === 'success') {
                    form[0].reset();
                    $('#commanModel').modal('hide');
                    $('.coupon-list-table-render').html(response.couponContent);
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        escapeMarkup: false,
                        close: true
                    }).showToast();
                }
            },
            error: function (xhr) {
                submitButton.prop('disabled', false).html('Submit');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        var inputField = $('#' + key);
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            inputField.after(
                                '<div class="invalid-feedback">' + value[0] + '</div>'
                            );
                        }
                    });
                } else {
                    console.error(xhr.responseText);
                       Toastify({
                        text: xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "An error occurred while saving the coupon.",
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        escapeMarkup: false,
                        close: true
                    }).showToast();
                }
            }
        });
    });
    $(document).on('click', '.show_confirm', function (event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();

        Swal.fire({
            title: `Are you sure you want to delete this ${name}?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

function generateGDSCode(length = 6) {
    const prefix = "GDS";
    const suffixLength = Math.max(length - prefix.length, 1);
    const chars = "0123456789";
    let suffix = "";
    for (let i = 0; i < suffixLength; i++) {
        suffix += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return prefix + suffix;
}
