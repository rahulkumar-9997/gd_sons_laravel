$(document).ready(function () {
    let currentPage = 1;

    function showLoadMoreButtonLoader() {
        $('#load-more-category').prop('disabled', true).text('Loading...');
    }

    function hideLoadMoreButtonLoader() {
        $('#load-more-category').prop('disabled', false).text('Load More');
    }

    function fetchFilteredProductsLoadMore(url, append = false) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                if (append) {
                    $('#product-catalog-category-frontend').append(response.products);
                } else {
                    $('#product-catalog-category-frontend').html(response.products);
                }

                if (response.hasMore) {
                    $('#load-more-category').show().data('next-page', currentPage + 1);
                } else {
                    $('#load-more-category').hide();
                }
                feather.replace(); 
                hideLoadMoreButtonLoader();
            },
            error: function (xhr) {
                console.error('Error fetching filtered products:', xhr.responseText);
                hideLoadMoreButtonLoader();
            }
        });
    }

    $(document).on('click', '#load-more-category', function () {
        currentPage++;
        let baseUrl = window.location.href.split('?')[0];
        let queryParams = new URLSearchParams(window.location.search);
        queryParams.set('page', currentPage);
        let url = `${baseUrl}?${queryParams.toString()}`;
        showLoadMoreButtonLoader();
        fetchFilteredProductsLoadMore(url, true);
    });
});
