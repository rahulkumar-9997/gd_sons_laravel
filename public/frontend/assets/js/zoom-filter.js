/** =====================
     Product Image Zoom
========================= **/

function initZoomForSlide(slideIndex) {
    $(".zoomContainer").remove();
    $(".product-image-slider img").each(function () {
        $(this).removeData('elevateZoom');
        $(this).removeData('zoomImage');
    });
    let selector = ".image_zoom_cls-" + slideIndex;

    setTimeout(() => {
        $(selector).elevateZoom({
            zoomType: "window",
            cursor: "crosshair",
            zoomWindowWidth: 420,
            zoomWindowHeight: 420,
            zoomWindowOffetx: 20,
            borderSize: 1,
            borderColour: "#ddd",
            scrollZoom: true
        });
    }, 150);
}

$(document).ready(function () {
    if ($(window).width() > 991) {
        initZoomForSlide(0);
        $('.product-main').on('afterChange', function (event, slick, currentSlide) {
            initZoomForSlide(currentSlide);
        });
    }
});
