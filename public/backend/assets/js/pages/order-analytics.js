let chart = null;

function loadAnalytics(year) {
    $.ajax({
        url: window.orderAnalyticsUrl,
        type: "GET",
        data: { year: year },
        success: function (res) {
             if (!res || res.length === 0) {
                if (chart !== null) {
                    chart.destroy();
                    chart = null;
                }
                document.querySelector("#order_analysis").innerHTML =
                    "<div style='text-align:center;padding:20px'>No data available for selected year</div>";
                return;
            }
            let months = [];
            let total = [];
            let newOrders = [];
            let packed = [];
            let processing = [];
            let shipped = [];
            let delivered = [];
            let cancelled = [];
            res.forEach((item) => {
                months.push(item.month);
                total.push(item.total);
                newOrders.push(item.new);
                packed.push(item.packed);
                processing.push(item.processing);
                shipped.push(item.shipped);
                delivered.push(item.delivered);
                cancelled.push(item.cancelled);
            });
            renderChart(
                months,
                total,
                newOrders,
                packed,
                processing,
                shipped,
                delivered,
                cancelled,
            );
        },
        error: function () {
            console.error("Failed to load analytics");
        },
    });
}

function renderChart(
    months,
    total,
    newOrders,
    packed,
    processing,
    shipped,
    delivered,
    cancelled,
) {
    if (chart !== null) {
        chart.destroy();
    }
    var options = {
        series: [
            { name: "Total Orders", data: total },
            { name: "New", data: newOrders },
            { name: "Packed", data: packed },
            { name: "Processing", data: processing },
            { name: "Shipped", data: shipped },
            { name: "Delivered", data: delivered },
            { name: "Cancelled", data: cancelled },
        ],
        chart: {
            height: 320,
            type: "area",
            zoom: { enabled: false },
        },
        colors: [
            "#000000",
            "#008FFB",
            "#00E396",
            "#FEB019",
            "#17a2b8",
            "#28a745",
            "#FF4560",
        ],
        dataLabels: { enabled: false },
        stroke: {
            curve: "smooth",
            width: 2,
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100],
            },
        },
        xaxis: {
            categories: months,
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " Orders";
                },
            },
        },
        legend: {
            position: "top",
            horizontalAlign: "left",
        },
    };

    chart = new ApexCharts(document.querySelector("#order_analysis"), options);
    chart.render();
}
$(document).on("click", ".year-option", function () {
    let year = $(this).data("year");
    $("#selectedYear").text(year);
    loadAnalytics(year);
});
$(document).ready(function () {
    let currentYear = new Date().getFullYear();
    loadAnalytics(currentYear);
});
