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
    $(document).on('click', '.sr-create-order, .sr-update-order, .sr-cancel-order, .sr-update-address, .sr-generate-awb, .sr-pickup', function () {
        let btn = $(this);
        let url = btn.data('url');
        btn.prop('disabled', true).html('Processing…');
        $.post(url, {}, function (res) {
            if (res.status === 'success') {
                toastr.success(res.msg);
                setTimeout(() => location.reload(), 1000);
            } else {
                toastr.error(res.msg);
                btn.prop('disabled', false).html(btn.data('original-text'));
            }
        }).fail(function (err) {
            toastr.error("Server error!");
            btn.prop('disabled', false).html(btn.data('original-text'));
        });
    });
    /*Shiprocket order update content */

});