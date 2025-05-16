$(document).ready(function () {
    $(document).on('submit', '#multipleUpdateProductLabel', function (e) {
        e.preventDefault();
    
        let formData = new FormData(this);
        let productUpdates = [];
        $('input[name^="label_id"]').each(function () {
            let productId = $(this).attr('name').match(/\[(\d+)\]/)[1];
            let isChecked = $(this).is(':checked');
            productUpdates.push({
                product_id: productId,
                label_id: isChecked ? $(this).val() : null 
            });
        });
        formData.append('product_updates', JSON.stringify(productUpdates));
    
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('.btn-primary').prop('disabled', true).text('Updating...');
            },
            success: function (response) {
                let toastClass = response.success ? "bg-success" : "bg-danger";
                Toastify({
                    text: response.message,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: toastClass,
                    close: true
                }).showToast();
                updateFilters();
            },
            error: function (xhr) {
                Toastify({
                    text: "An error occurred. Please try again.",
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                    close: true
                }).showToast();
            },
            complete: function () {
                $('.btn-primary').prop('disabled', false).text('Update All');
            }
        });
    });

    $('#category-filter, #product-search').on('change keyup', function () {
        updateFilters();
    });
    $('#reset-button').on('click', function () {
        $('#category-filter, #product-search').val('');
        $('#reset-button').hide();
        updateFilters();
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        const page = $(this).attr('href').split('page=')[1];
        fetchProducts(categoryId, search, page);
    });
    function updateFilters() {
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        if (categoryId || search) {
            $('#reset-button').show();
        } else {
            $('#reset-button').hide();
        }

        fetchProducts(categoryId, search);
    }

    function fetchProducts(categoryId = '', search = '', page = 1) {
        $('#loader').show();
        $.ajax({
            url: routes.labelIndex,
            type: 'GET',
            data: {
                category_id: categoryId,
                search: search,
                page: page,
            },
            success: function (data) {
                $('#label_product_list').html(data);
                $('#loader').hide();
            },
            error: function () {
                alert("An error occurred while filtering products.");
                $('#loader').hide();
            }
        });
    }
    updateFilters();
    
});
