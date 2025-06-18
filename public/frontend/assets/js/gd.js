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
        /**Request a Product Enquiry form home page */
        /**For model code mobile*/
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
        /**For model code mobile*/
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
                    
                },
                error: function (data) {
                    
                }
            });
        });        
        /*Track btn click ajax code*/         
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

/**category slider js code  */
$(document).ready(function() {
    const slider = $('.category-slider');
    const prevBtn = $('.category-slider-prev');
    const nextBtn = $('.category-slider-next');
    const itemWidth = $('.category-item-home').outerWidth(true);
    const visibleItems = Math.floor($('.category-slider-wrapper').width() / itemWidth);
    const totalItems = $('.category-item-home').length;
    
    let currentPosition = 0;
    const maxPosition = totalItems - visibleItems;
    
    function updateButtons() {
        prevBtn.prop('disabled', currentPosition <= 0);
        nextBtn.prop('disabled', currentPosition >= maxPosition);
    }
    
    function slideTo(position) {
        currentPosition = Math.max(0, Math.min(position, maxPosition));
        slider.css('transform', `translateX(-${currentPosition * itemWidth}px)`);
        updateButtons();
    }
    
    prevBtn.on('click', function() {
        slideTo(currentPosition - 1);
    });
    
    nextBtn.on('click', function() {
        slideTo(currentPosition + 1);
    });
    $(window).on('resize', function() {
        const newVisibleItems = Math.floor($('.category-slider-wrapper').width() / itemWidth);
        if (newVisibleItems !== visibleItems) {
            slideTo(0);
        }
    });
    updateButtons();
    let touchStartX = 0;
    let touchEndX = 0;
    
    slider.on('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    slider.on('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            slideTo(currentPosition + 1);
        } else if (touchEndX > touchStartX + 50) {
            slideTo(currentPosition - 1);
        }
    }
});
/**category slider js code  */
/*Highlighted Products */
/*$(document).ready(function() {
    const $slider = $('.highlighted_product');
    const $wrapper = $('.highlighted_product_wrapper');
    const $prevBtn = $('.product-slider-prev');
    const $nextBtn = $('.product-slider-next');
    const $items = $('.product-box-item');
    const itemWidth = $items.first().outerWidth(true);
    let visibleItems = Math.floor($wrapper.width() / itemWidth);
    let currentPosition = parseInt($slider.data('current-position'));
    let maxPosition = $items.length - visibleItems;
    function updateSlider() {
        $slider.css('transform', `translateX(-${currentPosition * itemWidth}px)`);
        updateButtons();
    }
    function updateButtons() {
        $prevBtn.prop('disabled', currentPosition <= 0);
        $nextBtn.prop('disabled', currentPosition >= maxPosition);
    }
    function goPrev() {
        if (currentPosition > 0) {
            currentPosition--;
            updateSlider();
        }
    }
    
    function goNext() {
        if (currentPosition < maxPosition) {
            currentPosition++;
            updateSlider();
        }
    }
    
    $prevBtn.on('click', goPrev);
    $nextBtn.on('click', goNext);
    $(window).on('resize', function() {
        visibleItems = Math.floor($wrapper.width() / itemWidth);
        maxPosition = Math.max(0, $items.length - visibleItems);
        
        if (currentPosition > maxPosition) {
            currentPosition = maxPosition;
            updateSlider();
        }
        updateButtons();
    }).trigger('resize');
    let touchStartX = 0;
    let touchEndX = 0;
    
    $slider.on('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    $slider.on('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const threshold = 50;
        if (touchEndX < touchStartX - threshold) goNext();
        if (touchEndX > touchStartX + threshold) goPrev();
    }
    let isDragging = false;
    let startPosX = 0;
    let currentTranslate = 0;
    let prevTranslate = currentPosition * itemWidth;
    
    $slider.on('mousedown', function(e) {
        isDragging = true;
        startPosX = e.clientX;
        prevTranslate = currentPosition * itemWidth;
        $slider.addClass('grabbing');
        e.preventDefault();
    });
    
    $(document).on('mousemove', function(e) {
        if (!isDragging) return;
        
        const currentPosX = e.clientX;
        currentTranslate = prevTranslate - (currentPosX - startPosX);
        const maxTranslate = maxPosition * itemWidth;
        currentTranslate = Math.max(0, Math.min(currentTranslate, maxTranslate));
        
        $slider.css('transform', `translateX(-${currentTranslate}px)`);
    });
    
    $(document).on('mouseup', function() {
        if (!isDragging) return;
        isDragging = false;
        $slider.removeClass('grabbing');
        currentPosition = Math.round(currentTranslate / itemWidth);
        updateSlider();
    });
});
*/
/* Highlighted Products*/
    


  
