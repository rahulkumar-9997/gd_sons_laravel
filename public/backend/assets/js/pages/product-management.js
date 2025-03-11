$(function () {
    /*Image modal form submit ajax */
    $(document).on('submit', '#productimageForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let $submitButton = $(this).find('button[type="submit"]');
        $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
    
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                let toastClass = response.success ? 'bg-success' : 'bg-danger';
    
                Toastify({
                    text: response.message, 
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: toastClass,
                    close: true,
                }).showToast();
    
                if (response.success) {
                    $('#commanModel').modal('hide');
                    $('#productimageForm')[0].reset();
                    $('#image-preview').empty();
                    var categoryId = $('#category-filter').val();
                    var search = $('#product-search').val();
                    var dateRange = $('#daterange').val();
                    var productStatus = $('#product-status').val();
                    var page = $('#pagination-links .active').find('a').data('page') 
                        || $('#pagination-links .active').find('span').text() 
                        || 1;
                    page = parseInt(page);
                    fetchProducts(categoryId, search, page, dateRange, productStatus);
                    //$('#example-2').load(location.href + " #example-2");
                   
                }
            },
            error: function (xhr) {
                let errorMessage = 'An unexpected error occurred.';
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Toastify({
                    text: errorMessage,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: 'bg-danger',
                    close: true,
                }).showToast();
            },
            complete: function () {
                $submitButton.prop('disabled', false).html('Save changes');
            },
        });
    });
    /*Image modal form submit ajax */
    $('#daterange').daterangepicker({
        opens: 'right',
        ranges: {
            'Today': [moment(), moment()],
            'Last 15 Days': [moment().subtract(15, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'Last 60 Days': [moment().subtract(59, 'days'), moment()],
            'Last 90 Days': [moment().subtract(89, 'days'), moment()],
            'Last 6 Months': [moment().subtract(6, 'months'), moment()],
            'Last 1 Year': [moment().subtract(1, 'year'), moment()],
        },
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear',
        }
    });

    $('#daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        $('#reset-button').show();
        updateFilters();
    });

    $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('#reset-button').hide();
        updateFilters();
    });

    $('#category-filter, #product-status').on('change', updateFilters);
    $('#product-search').on('keyup', updateFilters);

    $('#reset-button').on('click', function () {
        $('#category-filter, #product-search, #daterange, #product-status').val('');
        $('#daterange').data('daterangepicker').setStartDate(moment());
        $('#daterange').data('daterangepicker').setEndDate(moment());
        $('#reset-button').hide();
        fetchProducts();
    });

    $(document).on('click', '#pagination-links a', function (e) {
        e.preventDefault();
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        const dateRange = $('#daterange').val();
        const productStatus = $('#product-status').val();
        const page = $(this).attr('href').split('page=')[1];
        fetchProducts(categoryId, search, page, dateRange, productStatus);
    });

    function updateFilters() {
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        const dateRange = $('#daterange').val();
        const productStatus = $('#product-status').val();

        if (categoryId || search || dateRange || productStatus) {
            $('#reset-button').show();
        } else {
            $('#reset-button').hide();
        }

        fetchProducts(categoryId, search, 1, dateRange, productStatus);
    }

    function fetchProducts(categoryId = '', search = '', page = 1, dateRange = '', productStatus = '') {
        $('#loader').show();
        $.ajax({
            url: routes.productIndex,
            type: "GET",
            data: {
                category_id: categoryId,
                search: search,
                page: page,
                date_range: dateRange,
                product_status: productStatus
            },
            success: function (data) {
                $('#product-list-container').html(data);
                $('#loader').hide();
                bindCheckboxEventHandlers();
                singleDeleteProduct();
            },
            error: function () {
                alert("An error occurred while filtering products.");
                $('#loader').hide();
            }
        });
    }

    function bindCheckboxEventHandlers() {
        $('.select-all-checkbox').on('click', function () {
            const checkboxes = $('.product-checkbox');
            checkboxes.prop('checked', this.checked);
            toggleRowHighlight(checkboxes);
            toggleDeleteButton();
        });

        $('.product-checkbox').off('change').on('change', function () {
            toggleRowHighlight(this);
            toggleDeleteButton();
        });

        $('#bulk-delete-btn').off('click').on('click', function () {
            const selectedIds = $('.product-checkbox:checked').map(function () {
                return $(this).val();
            }).get();

            if (selectedIds.length > 0) {
                const deleteButton = $(this);
                deleteButton.prop('disabled', true);
                deleteButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

                Swal.fire({
                    title: 'Are you sure you want to delete these products?',
                    text: "If you delete these, they will be gone forever.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete them!",
                    cancelButtonText: "Cancel",
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(routes.productBulkDelete, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ product_ids: selectedIds })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("Deleted!", "The selected products have been deleted.", "success")
                                        .then(() => fetchProducts($('#category-filter').val(), $('#product-search').val(), 1, $('#daterange').val(), $('#product-status').val()));
                                } else {
                                    Swal.fire("Error!", "There was an error deleting the products.", "error");
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire("Error!", "Something went wrong.", "error");
                            })
                            .finally(() => {
                                deleteButton.prop('disabled', false);
                                deleteButton.html('Delete Selected');
                            });
                    } else {
                        deleteButton.prop('disabled', false);
                        deleteButton.html('Delete Selected');
                    }
                });
            } else {
                Swal.fire("No products selected", "Please select products to delete.", "info");
            }
        });
    }

    function toggleRowHighlight(checkbox) {
        const row = $(checkbox).closest('.product-row');
        row.toggleClass('highlighted', $(checkbox).prop('checked'));
    }

    function toggleDeleteButton() {
        const selectedCheckboxes = $('.product-checkbox:checked');
        $('#bulk-delete-btn').toggle(selectedCheckboxes.length > 0);
    }

    function singleDeleteProduct() {
        $('.show_confirm').click(function (event) {
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
    }

    fetchProducts();
    /**sort product img */
    $('#commanModel').on('shown.bs.modal', function () {
        $('#sortable_product_image_popup').sortable({
            placeholder: "ui-sortable-placeholder",
            update: function (event, ui) {
                var order = $(this).sortable('toArray', {attribute: 'data-id'});

                $.ajax({
                    url: routes.sortProductImg,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        order: order
                    },
                    success: function (response) {
                        if (response.success) {
                            Toastify({
                                text: response.message,
                                duration: 10000,
                                gravity: "top",
                                position: "right",
                                className: "bg-success",
                                close: true
                            }).showToast();
                            $('#commanModel').modal('hide');
                            var categoryId = $('#category-filter').val();
                            var search = $('#product-search').val();
                            var dateRange = $('#daterange').val();
                            var productStatus = $('#product-status').val();
                            var page = $('#pagination-links .active').find('a').data('page') 
                                || $('#pagination-links .active').find('span').text() 
                                || 1;
                            page = parseInt(page);
                            fetchProducts(categoryId, search, page, dateRange, productStatus);
                        } else {
                            Toastify({
                                text: 'Failed to update sort order.',
                                duration: 10000,
                                gravity: "top",
                                position: "right",
                                className: "bg-danger",
                                close: true
                            }).showToast();
                        }
                    },
                    error: function () {
                        Toastify({
                            text: 'Error updating sort order.',
                            duration: 10000,
                            gravity: "top",
                            position: "right",
                            className: "bg-danger",
                            close: true
                        }).showToast();
                    }
                });
            }
        });
    });
    /**sort product img */

});
