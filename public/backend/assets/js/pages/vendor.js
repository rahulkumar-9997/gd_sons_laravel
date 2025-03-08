$(document).ready(function() {
    var baseUrl = $('meta[name="base-url"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', 'a[data-vendor-popup="true"]', function () {
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

    $(document).on('submit', '#vendorForm', function (e) {
        e.preventDefault(); 
        var form = $(this);
        var formData = form.serialize();
        var submitButton = form.find('button[type="submit"]');
        var loadingSpinner = $('#loadingSpinner');
        $('.error-text').text('');
        submitButton.prop('disabled', true).text('Saving...');
        loadingSpinner.removeClass('d-none');
        $('#loader').show();
        $.ajax({
            url: form.data('url'),
            method: 'POST',
            data: formData,
            success: function (response) {
                fetchVendorList();
                $("#commanModel").modal('hide');
                $('#loader').hide();
                Toastify({
                    text: response.message,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-success",
                    close: true,
                }).showToast();
                form.trigger('reset'); 
                submitButton.prop('disabled', false).text('Save changes');
                loadingSpinner.addClass('d-none');
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    /**Above if code is validation error */
                    let errors = xhr.responseJSON.errors;
                    for (let key in errors) {
                        $(`.${key}_error`).text(errors[key][0]);
                    }
                    /*Toastify({
                        text: "There were some errors with your submission.",
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true,
                    }).showToast();
                    */
                } else {
                    Toastify({
                        text: "An unexpected error occurred.",
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-danger",
                        close: true,
                    }).showToast();
                }
                $('#loader').hide();
                submitButton.prop('disabled', false).text('Save changes');
                loadingSpinner.addClass('d-none');
            },
            
        });
    });

    function  bindVendorListEvents(){
        
        /**Pagination */
        $(document).on('click', '#pagination-links a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            fetchVendorList(page);
        });
        /**Pagination */
        /*Edit Vendor Button click  show edit form*/
        $(document).on('click', '.edit-vendor-btn', function() {
            var vendor_id = $(this).data('vendorid');
            $('td[data-id="' + vendor_id + '"] .current-value').hide();
            $('td[data-id="' + vendor_id + '"] .edit-input').show();
            $(this).hide();
            $('button.save-vendor-btn[data-vendorid="' + vendor_id + '"]').show();
            $('button.cancel-vendor-btn[data-vendorid="' + vendor_id + '"]').show();
        });
        /*Edit Vendor Button click */
        /*Cancel Vendor Button click */
        $(document).on('click', '.cancel-vendor-btn', function() {
            var vendor_id = $(this).data('vendorid');
            $('td[data-id="' + vendor_id + '"] .edit-input').hide();
            $('td[data-id="' + vendor_id + '"] .current-value').show();
            $('button.save-vendor-btn[data-vendorid="' + vendor_id + '"]').hide();
            $('button.cancel-vendor-btn[data-vendorid="' + vendor_id + '"]').hide();
            $('button.edit-vendor-btn[data-vendorid="' + vendor_id + '"]').show();
        });
        /*Cancel Vendor Button click */
        /*Update Vendor Button click */
        $('.save-vendor-btn').on('click', function() {
            var vendor_id = $(this).data('vendorid');
            var vendor_name = $('td[data-id="' + vendor_id + '"] .edit-input[data-field="vendor_name"]').val();
            var vendor_location = $('td[data-id="' + vendor_id + '"] .edit-input[data-field="vendor_location"]').val();
            var vendor_gst_no = $('td[data-id="' + vendor_id + '"] .edit-input[data-field="vendor_gst_no"]').val();
            var vendor_contact_no = $('td[data-id="' + vendor_id + '"] .edit-input[data-field="vendor_contact_no"]').val();
            $.ajax({
                url: baseUrl + '/manage-vendor/update/' + vendor_id,
                method: 'POST',
                data: {
                    vendor_name: vendor_name,
                    vendor_location: vendor_location,
                    vendor_gst_no: vendor_gst_no,
                    vendor_contact_no: vendor_contact_no,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        fetchVendorList();
                        Toastify({
                            text: response.message,
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-success",
                            close: true
                        }).showToast();
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('.invalid-feedback').remove();
                        $('.edit-input').removeClass('is-invalid');
                        $.each(errors, function(field, messages) {
                            var inputField = $('td[data-id="' + vendor_id + '"] .edit-input[data-field="' + field + '"]');
                            var errorMessage = messages.join(', ');
                            inputField.addClass('is-invalid');
                            inputField.after('<div class="invalid-feedback">' + errorMessage + '</div>');
                        });
                    } else {
                        var errorMessage = 'An error occurred. Please try again.';
                        Toastify({
                            text: errorMessage,
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true
                        }).showToast();
                    }
                }
            });
        });
        /*Update Vendor Button click */
        /**DELETE Vendor Button Click*/
        $('.delete-vendor-btn').click(function(event) {
            var vendor_id = $(this).data("vendorid"); 
            var name = $(this).data("name");
            event.preventDefault(); 
            Swal.fire({
                title: `Are you sure you want to delete this ${name}?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: baseUrl + '/manage-vendor/delete/' + vendor_id,
                        type: 'DELETE',
                        data: {
                            id: vendor_id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            var successMessage = response.message || "Vendor deleted successfully!";
                            fetchVendorList();
                            Toastify({
                                text: successMessage,
                                duration: 10000,
                                gravity: "top",
                                position: "right",
                                className: "bg-success",
                                close: true,
                                onClick: function() {}
                            }).showToast();
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON?.error || 'An error occurred while deleting the vendor.';
                            Toastify({
                                text: errorMessage,
                                duration: 10000,
                                gravity: "top",
                                position: "right",
                                className: "bg-danger",
                                close: true,
                                onClick: function() {}
                            }).showToast();
                        }
                    });
                }
            });
        });
        /**DELETE Vendor Button Click*/
    }
    function fetchVendorList(page = 1,) {
        $('#loader').show();
        $.ajax({
            url: baseUrl + '/manage-vendor',
            type: "GET",
            data: { 
                page: page,
            },
            success: function(data) {
                $('#vendor-list-container').html(data);
                $('#loader').hide();
                bindVendorListEvents();
            },
            error: function() {
                alert("Somethins went wrongs.");
                $('#loader').hide();
            }
        });
    }
    bindVendorListEvents();
    
    
 });