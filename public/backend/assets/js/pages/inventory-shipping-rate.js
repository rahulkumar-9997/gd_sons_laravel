$(document).ready(function () {
   $(document).on("click", ".update-shipment-rate", function () {
    var button = $(this);
    
    button.prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
    );
    
    var url = button.data('route');
    
    $.ajax({
        url: url,
        type: 'POST',  // or 'PUT' depending on your route
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            if (response.success) {
                Toastify({
                    text: response.message,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-success",
                    close: true,
                    onClick: function () { }
                }).showToast();
                if (response.volumetric_weight_kg) {
                    $('#volumetric_weight_kg').val(response.volumetric_weight_kg);
                }
                if (response.shipment_rate) {
                    $('#shipment_rate').val(response.shipment_rate);
                }
                console.log('Update successful:', response.data);
                
                button.prop('disabled', false).html('Update Shipment Rate');
            } else {
                Toastify({
                    text: response.message,
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-info",
                    close: true,
                    onClick: function () { }
                }).showToast();
                button.prop('disabled', false).html('Update Shipment Rate');
            }
        },
        error: function (xhr) {
            var message = 'Something went wrong.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            Toastify({
                text: message,
                duration: 10000,
                gravity: "top",
                position: "right",
                className: "bg-danger",
                close: true,
                onClick: function () { }
            }).showToast();
            button.prop('disabled', false).html('Update Shipment Rate');
        }
    });
});
    
});
