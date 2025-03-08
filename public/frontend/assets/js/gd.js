    $(document).ready(function(){
        /**Sticky user animation */
        setTimeout(function () {
            $('.sticky-user').addClass('animate');
        }, 1000);
        /**Sticky user animation */
        // $('.silk-carousel').slick({
        //     infinite: true, 
        //     slidesToShow: 1,
        //     slidesToScroll: 1,
        //     autoplay: false, 
        //     autoplaySpeed: 4000,
        //     arrows: true, 
        //     prevArrow: '.slick-prev',
        //     nextArrow: '.slick-next',
        //     dots: true, 
        //     touchMove: true, 
        //     responsive: [
        //         {
        //             breakpoint: 600,
        //             settings: {
        //                 slidesToShow: 1,
        //                 slidesToScroll: 1
        //             }
        //         }
        //     ]
        // });
        
       
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
       
        // $(document).ready(function () {
        //     $(".sort-by-button").click(function () {
        //         $(".top-filter-menu").toggleClass("show");
        //     });
        // });
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
        /**enquiry modal code start */
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
          
    });

    function showNotificationAll(type, title, message) {
        $.notify({
            icon: type === "success" ? "fa fa-check" : "fa fa-exclamation",
            title: title,
            message: message,
        }, {
            element: "body",
            position: null,
            type: type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right",
            },
            offset: 20,
            spacing: 5,
            z_index: 1031,
            delay: 5000,
            animate: {
                enter: "animated fadeInDown",
                exit: "animated fadeOutUp",
            },
            template: `
                <div data-notify="container" class="col-xxl-2  alert bg-{0} toast-notification" role="alert">
                    <button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>
                    <span style="color: white;" data-notify="message">{2}</span>
                </div>
            `,
        });
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
    


  
