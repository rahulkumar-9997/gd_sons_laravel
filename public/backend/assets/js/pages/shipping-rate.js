$(document).ready(function () {

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
});
