$(document).ready(function () {
    /*DELETE PRODUCT REVIEW CODE */
    $(document).on('click', '.show_confirm_product_review', function (event) {
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
    /*DELETE PRODUCT REVIEW CODE */

    $('body').on('change', '.productReviewStatus', function () {
        var $checkbox = $(this);
        var primaryCategoryId = $checkbox.data('pid');
        var updateUrl = $checkbox.data('url');
        var isActive = $checkbox.is(':checked') ? 1 : 0;
        $('#loader').fadeIn();
        $checkbox.prop('disabled', true);
        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: {
                status: isActive,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.status === 'success') {

                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        close: true,
                    }).showToast();
                    var page = $('#pagination-link-product-review .active').find('a').data('page')
                        || $('#pagination-link-product-review .active').find('span').text()
                        || 1;
                    page = parseInt(page);
                    loadReviews(page);
                    $('#loader').fadeOut();
                }
            },
            error: function (xhr, status, error) {
                $checkbox.prop('checked', !isActive);
                Toastify({
                    text: 'Failed to update status. Please try again.',
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                    close: true,
                }).showToast();
            },
            complete: function () {
                $('#loader').fadeOut();
                $checkbox.prop('disabled', false);
            }
        });
    });


    $(document).on('click', '#pagination-link-product-review a', function (e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        loadReviews(page);
    });

    function loadReviews(page = 1,) {
        $('#loader').show();
        $.ajax({
            url: routes.reviewIndex,
            type: "GET",
            data: {
                page: page,
            },
            success: function (data) {
                $('#review_list').html(data);
                $('#loader').hide();

            },
            error: function () {
                Toastify({
                    text: 'An error !Please try again.',
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                    close: true,
                }).showToast();
                $('#loader').hide();
            }
        });
    }
});