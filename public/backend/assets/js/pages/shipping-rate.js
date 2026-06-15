$(document).ready(function () {
    $(document).on('click', '.update-weight-category-shipping-rate', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url
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
    let currentPage = 1;
    $(document).on("click", "#pagination-links-shipping-rates a", function (e) {
        e.preventDefault();
        currentPage = $(this).attr("href").split("page=")[1];
        fetchShipmentRates(currentPage);
    });
    function fetchShipmentRates(page = 1) {
        currentPage = page;
        $("#loader").show();
        $.ajax({
            url: window.appConfig.routes.shipmentRateIndex + "?page=" + page,
            type: "GET",
            success: function (data) {
                $("#shipping-rates-container").html(data);
                $("#loader").hide();
            },
            error: function () {
                Toastify({
                    text: "Failed to load shipping rates. Please try again.",
                    duration: 5000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                }).showToast();

                $("#loader").hide();
            },
        });
    }

    $(document).on("click", ".refresh-single", function () {
        let id = $(this).data("id");
        let btn = $(this);
        btn.prop("disabled", true).text("Updating...");
        $.ajax({
            url:
                window.appConfig.routes.refreshSingle +
                "/" +
                id +
                "/refresh-single",
            type: "POST",
            data: {
                _token: window.appConfig.csrfToken,
            },
            success: function (res) {
                if (res.status) {
                    Toastify({
                        text: res.message,
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                    }).showToast();
                    fetchShipmentRates(currentPage);
                } else {
                    Toastify({
                        text: res.message || "Failed to refresh shipping rate.",
                        className: "bg-danger",
                    }).showToast();
                }
            },
            error: function () {
                Toastify({
                    text: "An error occurred while refreshing.",
                    className: "bg-danger",
                }).showToast();
            },
            complete: function () {
                btn.prop("disabled", false).text("Refresh");
            },
        });
    });
    /*Destroy shipping rate */
    $(document).on('click', '.show_confirm', function (event) {
        event.preventDefault();
        var form = $(this).closest("form");
        var url = form.attr("action"); 
        Swal.fire({
            title: "Are you sure?",
            text: "This record will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: window.appConfig.csrfToken,
                        _method: "DELETE",
                    },
                    success: function (res) {
                        if (res.status) {
                            Swal.fire("Deleted!", res.message, "success");
                            fetchShipmentRates(currentPage);
                        } else {
                            Swal.fire("Error!", res.message, "error");
                        }
                    },
                    error: function () {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    });

                }
            });
    });
    /*Destroy shipping rate */

    /*Update shipping rate */
    $(document).on('click', '.edit-row', function() {
        const row = $(this).closest('tr');
        const id = $(this).data('id');
        row.find('.view-mode').hide();
        row.find('.edit-mode').show();
        row.find('.edit-row').hide();
        row.find('.save-row').show();
        row.find('.cancel-row').show();
    });
    $(document).on('click', '.cancel-row', function() {
        const row = $(this).closest('tr');
        const id = $(this).data('id');
        row.find('.edit-mode').each(function() {
            const spanValue = $(this).closest('td').find('.view-mode').text();
            $(this).val(spanValue);
        });
        row.find('.edit-mode').hide();
        row.find('.view-mode').show();
        row.find('.save-row').hide();
        row.find('.cancel-row').hide();
        row.find('.edit-row').show();
    });
    $(document).off('click', '.save-row').on('click', '.save-row', function() {
        const row = $(this).closest('tr');
        const id = $(this).data('id');
        const saveBtn = $(this);
        row.find('.form-control').removeClass('is-invalid');
        row.find('.invalid-feedback').remove();
        saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        const formData = new FormData();
        formData.append('id', id);
        formData.append('pincode', row.find('.pincode-cell .edit-mode').val());
        formData.append('post_office', row.find('.post-office-cell .edit-mode').val());
        formData.append('weight_450gm', row.find('.weight-450gm-cell .edit-mode').val());
        formData.append('weight_750gm', row.find('.weight-750gm-cell .edit-mode').val());
        formData.append('weight_1350gm', row.find('.weight-1350gm-cell .edit-mode').val());
        formData.append('weight_3400gm', row.find('.weight-3400gm-cell .edit-mode').val());
        formData.append('weight_7500gm', row.find('.weight-7500gm-cell .edit-mode').val());
        formData.append('weight_14kg', row.find('.weight-14kg-cell .edit-mode').val());
        formData.append('weight_25kg', row.find('.weight-25kg-cell .edit-mode').val());
        formData.append('_method', 'PUT');
        formData.append('_token', window.appConfig.csrfToken);
        $.ajax({
            url: window.appConfig.routes.shipmentRateIndex + '/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                saveBtn.prop('disabled', false);
                saveBtn.html('<i class="ti ti-check"></i> Save');                
                if (response.status === 'success') {
                    row.find('.pincode-cell .view-mode').text(row.find('.pincode-cell .edit-mode').val());
                    row.find('.post-office-cell .view-mode').text(row.find('.post-office-cell .edit-mode').val());
                    row.find('.weight-450gm-cell .view-mode').text(row.find('.weight-450gm-cell .edit-mode').val());
                    row.find('.weight-750gm-cell .view-mode').text(row.find('.weight-750gm-cell .edit-mode').val());
                    row.find('.weight-1350gm-cell .view-mode').text(row.find('.weight-1350gm-cell .edit-mode').val());
                    row.find('.weight-3400gm-cell .view-mode').text(row.find('.weight-3400gm-cell .edit-mode').val());
                    row.find('.weight-7500gm-cell .view-mode').text(row.find('.weight-7500gm-cell .edit-mode').val());
                    row.find('.weight-14kg-cell .view-mode').text(row.find('.weight-14kg-cell .edit-mode').val());
                    row.find('.weight-25kg-cell .view-mode').text(row.find('.weight-25kg-cell .edit-mode').val());
                    row.find('.edit-mode').hide();
                    row.find('.view-mode').show();
                    row.find('.save-row').hide();
                    row.find('.cancel-row').hide();
                    row.find('.edit-row').show();
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: response.message,
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-success",
                            close: true,
                            onClick: function () { }
                        }).showToast();
                    } else if (typeof toastr !== 'undefined') {
                        toastr.success(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            },
            error: function(xhr, status, error) {
                saveBtn.prop('disabled', false);
                saveBtn.html('<i class="ti ti-check"></i> Save');
                
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    // Show validation errors
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: 'Please fix the validation errors',
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true,
                            onClick: function () { }
                        }).showToast();
                    }
                    
                    $.each(errors, function(key, value) {
                        // Find the input field and show error
                        var inputField = row.find('.' + key + '-cell .edit-mode');
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        }
                    });
                } else {
                    // Show general error
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: 'An error occurred while updating!',
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true,
                            onClick: function () { }
                        }).showToast();
                    } else if (typeof toastr !== 'undefined') {
                        toastr.error('An error occurred while updating!');
                    } else {
                        alert('An error occurred while updating!');
                    }
                }
            }
        });
    });
    /*Update shipping rate */
});
