let activeSalesReportRequest = null;
function updateSalesReportFilters() {
    const year = $('#year-filter').val();
    const month = $('#month-filter').val();
    const search = $('#order-search').val();
    if (year || month || search) {
        $('#reset-sales-filter-wrapper').show();
    } else {
        $('#reset-sales-filter-wrapper').hide();
    }
    fetchSalesReport(year, month, search, 1);
}

function fetchSalesReport(year = '', month = '', search = '', page = 1) {
    if (activeSalesReportRequest) {
        activeSalesReportRequest.abort();
    }
    $('#loader').show();
    activeSalesReportRequest = $.ajax({
        url: routes.saleReportIndex,
        type: 'GET',
        data: {
            year: year,
            month: month,
            search: search,
            page: page
        },
        success: function (response) {
            $('#sale-report-list').html(response);
        },
        error: function (xhr, status) {
            if (status === 'abort') {
                return;
            }
            console.log('Error loading sales report');
        },
        complete: function () {
            $('#loader').hide();
            activeSalesReportRequest = null;
        }
    });
}
$(document).on('change', '#year-filter', function () {
    updateSalesReportFilters();
});
$(document).on('change', '#month-filter', function () {
    updateSalesReportFilters();
});
$(document).on('keyup', '#order-search', function () {
    updateSalesReportFilters();
});
$(document).on('click', '#sale-report-list .pagination a', function (e) {
    e.preventDefault();
    const page = $(this).attr('href').split('page=')[1];
    fetchSalesReport(
        $('#year-filter').val(),
        $('#month-filter').val(),
        $('#order-search').val(),
        page
    );
});
$(document).on('click', '#reset-sales-filter', function () {
    $('#year-filter').val('');
    $('#month-filter').val('');
    $('#order-search').val('');
    $('#reset-sales-filter-wrapper').hide();
    fetchSalesReport('', '', '', 1);
});