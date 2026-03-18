    $(document).ready(function(){
        /**Sticky user animation */
        setTimeout(function () {
            $('.sticky-user').addClass('animate');
        }, 1000);  
       
        $('.qty-right-plus').click(function () {
            var input = $(this).siblings('.qty-input');
            var currentValue = parseInt(input.val(), 10); 
            if (!isNaN(currentValue) && currentValue < 9) { 
                input.val(currentValue + 1);
            }
        });
    
        /*Decrement quantity*/
        $('.qty-left-minus').click(function () {
            var input = $(this).siblings('.qty-input');
            var currentValue = parseInt(input.val(), 10);
            
            if (!isNaN(currentValue) && currentValue > 1) {
                input.val(currentValue - 1); 
            }
        });
        /**filter sidebar js */
        $(document).on('click', '.filter-button', function(e) {
            $(".bg-overlay, .left-box").addClass("show");
        });
        $(document).on('click', '.back-button, .bg-overlay', function(e) {
            $(".bg-overlay, .left-box").removeClass("show");
        });
        /**filter sidebar js */
        $(window).scroll(function(){
            var sticky = $('.pa-main-header'),
                scroll = $(window).scrollTop();
            
            if (scroll >= 100) sticky.addClass('animated fadeInDown fixed');
            else sticky.removeClass('animated fadeInDown fixed');
        });
        /**enquiry modal code start */
       
        $(document).on('click', '.product_detail_whattsapp', function(e) {
            var button = $(this);
            var originalButtonText = button.html();
            button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading please wait...');
            var title = $(this).data('title');
            var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
            var url = $(this).data('url');
            var productId = $(this).data('pid');
            var currentPageUrl = $(this).data('pageurl');
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                size: size,
                url: url,
                productId: productId,
                currentPageUrl: currentPageUrl
            };
            $("#commoanModal .modal-title").html(title);
            $("#commoanModal .modal-dialog").addClass('modal-' + size);
            
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    $('#commoanModal .modal-render-data').html(data.form);
                    $("#commoanModal").modal('show');
                    button.prop('disabled', false).html(originalButtonText);
                },
                error: function (data) {
                    data = data.responseJSON;
                    button.prop('disabled', false).html(originalButtonText);
                }
            });
        });

        $(document).on('click', '.requestProductBtn', function(e) {
            var button = $(this);
            var originalButtonText = button.html();
            button.prop('disabled', true).html('Loading please wait...');
            var title = $(this).data('title');
            var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
            var url = $(this).data('url');
            var currentPageUrl = $(this).data('pageurl');
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                size: size,
                url: url,
                currentPageUrl: currentPageUrl
            };
            $('#commoanModal').removeClass('page-reload-modal');
            $("#commoanModal .modal-title").html(title);
            $("#commoanModal .modal-dialog").addClass('modal-' + size);
            
            $.ajax({
                url: url,
                type: 'get',
                data: data,
                success: function (data) {
                    $('#commoanModal .modal-render-data').html(data.form);
                    $("#commoanModal").modal('show');
                    button.prop('disabled', false).html(originalButtonText);
                },
                error: function (data) {
                    data = data.responseJSON;
                    button.prop('disabled', false).html(originalButtonText);
                }
            });
        });
        
        /**product enquiry form submit */
        $(document).off('submit', '#productEnquiryForm').on('submit', '#productEnquiryForm', function (event) {
            event.preventDefault();
            var form = $(this);
            var submitButton = form.find('button[type="submit"]');
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
            
            var formData = new FormData(this);
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    submitButton.prop('disabled', false).html('Submit');                    
                    if (response.status === 'success') {
                        showNotificationAll("success", "", response.message);
                        form[0].reset();
                        localStorage.setItem('modalClosed', 'true');
                        $("#commoanModal").modal('hide');
                    }
                },
                error: function(xhr) {
                    submitButton.prop('disabled', false).html('Submit');
                    
                    var errors = xhr.responseJSON?.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            var inputField = $('#' + key);
                            inputField.addClass('is-invalid');
                            inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                        });
                    } else {
                        showNotificationAll("warning", "", "An error occurred! Please try again");
                    }
                }
            });
        });        
        /**product enquiry form submit */
        
        /* Page reload modal open code  */
        var productEnquiryRoute  = $('meta[name="product-enquiry-route"]').attr('content');
        function isModalClosedRecently() {
            var modalData = localStorage.getItem('modalClosed');
            if (!modalData) return false;
            
            try {
                modalData = JSON.parse(modalData);
                if (modalData.timestamp && modalData.value === 'true') {
                    return (Date.now() - modalData.timestamp) < 86400000;
                }
            } catch (e) {
                console.error('Error parsing modalClosed data:', e);
            }
            return false;
        }
        if (!isModalClosedRecently()) {
            setTimeout(function() {
                loadAndShowModal();
            }, 2000);
        }
        
        $(document).on('click', '.close-reload, .page-reload-modal .btn-close', function() {
            var modalData = {
                value: 'true',
                timestamp: Date.now()
            };
            localStorage.setItem('modalClosed', JSON.stringify(modalData));
            $("#commoanModal").modal('hide');
        });

        function loadAndShowModal() {
            if (!localStorage.getItem('modalClosed')) {
                var url = productEnquiryRoute ;
                var size = 'md';
                var data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    size: size,
                    url: url,
                    action : 'PageReloadModal',
                    currentPageUrl: window.location.href
                };
                
                $.ajax({
                    url: url,
                    type: 'get',
                    data: data,
                    success: function (data) {
                        $('#commoanModal .modal-render-data').html(data.form);
                        $("#commoanModal .modal-dialog").addClass('modal-' + size);
                        if (data.action === 'PageReloadModal') {
                            $('#commoanModal').addClass('page-reload-modal');
                        }
                        $("#commoanModal").modal('show');
                    },
                    error: function (data) {
                        console.error('Error loading modal:', data);
                    }
                });
            }
        }
        /* Page reload modal open code  */

        
        $(document).off('submit', '#requestAproductEnquiry').on('submit', '#requestAproductEnquiry', function (event) {
            event.preventDefault();

            var form = $(this);
            var submitButton = form.find('button[type="submit"]');
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
            var formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    submitButton.prop('disabled', false).html('Submit');
                    if (response.status === 'success') {
                        showNotificationAll("success", "", response.message);
                        form[0].reset();
                    }
                },
                error: function(xhr) {
                    submitButton.prop('disabled', false).html('Submit');

                    var errors = xhr.responseJSON?.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            var inputField = $('#' + key);
                            inputField.addClass('is-invalid');
                            inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        });
                    } else {
                        showNotificationAll("warning", "", "An error occurred! Please try again");
                    }
                }
            });
        });

        /**Request a Product Enquiry form home page */ 
        
        /*Track btn click ajax code*/ 
        $(document).on('click', 'a[data-track-click="true"], button[data-track-click="true"]', function(e) {
            var url = $(this).data('track-route');
            var btn_type = $(this).data('track-btn-type');
            var page_url = window.location.href;
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                url: url,
                btn_type: btn_type,
                page_url: page_url,
            };            
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
					console.log(data);                    
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });        
        /*Track btn click ajax code*/
               
    });

    function showNotificationAll(type, title, message) {
        $.notify(
            {
                icon: type === "success" ? "fa fa-check-circle" : "fa fa-exclamation-triangle",
                title: title,
                message: message
            },
            {
                element: "body",
                type: type,
                allow_dismiss: true,
                newest_on_top: true,
                showProgressbar: false,

                placement: {
                    from: "bottom",
                    align: "center"
                },

                offset: 20,
                spacing: 10,
                z_index: 1055,
                delay: 4000, 
                animate: {
                    enter: "animated fadeInUp",
                    exit: "animated fadeOutDown"
                },
                template: `
                    <div data-notify="container"
                    class="alert alert-{0} toast-notification shadow d-inline-flex align-items-start gap-2"
                    role="alert">
                        <span data-notify="icon" class="mt-1"></span>
                        <div class="flex-grow-1">
                            <div class="fw-bold mb-1" data-notify="title">{1}</div>
                            <div data-notify="message">{2}</div>
                        </div>
                        <button type="button"
                                class="btn-close ms-2"
                                data-notify="dismiss"
                                aria-label="Close"></button>
                    </div>
                `
            }
        );
    }
/**auto height js */
    
 $(window).on('load resize', function () {
    checkPosition();
    function checkPosition() {
        function fixButtonHeights() {
            if (window.matchMedia('(min-width: 320px)').matches) {
                var heights = new Array();
                $('.product-section .product-box .product-detail h6.name').each(
                    function () {
                        $(this).css('min-height', '0');
                        $(this).css('max-height', 'none');
                        $(this).css('height', 'auto');
                        heights.push($(this).height());
                    });
                var max = Math.max.apply(Math, heights);
                $('.product-section .product-box .product-detail h6.name').each(
                    function () {
                        $(this).css('height', max + 'px');
                    });
            }
        }

        $(document).ready(function () {
            fixButtonHeights();
            $(window).resize(function () {
                setTimeout(function () {
                    fixButtonHeights();
                }, 120);
            });
        });
    }
});

    


  
