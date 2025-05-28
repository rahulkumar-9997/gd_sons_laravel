<script src="{{asset('frontend/assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/bootstrap/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/bootstrap/popper.min.js')}}" defer></script>
<script src="{{asset('frontend/assets/js/feather/feather.min.js')}}" defer></script>
<script src="{{asset('frontend/assets/js/feather/feather-icon.js')}}" defer></script>
<script src="{{asset('frontend/assets/js/lazysizes.min.js')}}" defer></script>
<script src="{{asset('frontend/assets/js/slick/slick.js')}}" defer></script>
<script src="{{asset('frontend/assets/js/slick/slick-animation.min.js')}}" defer></script>
<script src="{{asset('frontend/assets/js/slick/custom_slick.js')}}" defer></script>
<!-- <script src="{{asset('frontend/assets/js/wow.min.js')}}"></script> -->
<!-- <script src="{{asset('frontend/assets/js/custom-wow.js')}}"></script> -->
<script src="{{asset('frontend/assets/js/script.js')}}"></script>
<script src="{{asset('frontend/assets/js/gd.js')}}?v={{ time() }}"></script>
<script src="{{asset('frontend/assets/js/pages/search.js')}}"></script>
<script src="{{asset('frontend/assets/js/cart-drawer.min.js')}}"></script>
<!-- <script src="{{asset('frontend/assets/js/pages/notifications.js')}}"></script> -->
<!-- <script src="https://checkout.razorpay.com/v1/magic-checkout.js"></script> -->

@if (session('error'))
    <script>
        $(document).ready(function () {
            $.notify({
                icon: "fa fa-times",
                title: "Error!",
                message: "{{ session('error') }}",
            }, {
                element: "body",
                position: null,
                type: "danger",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: true,
                placement: {
                    from: "top",
                    align: "right",
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5000,
                animate: {
                    enter: "animated fadeInDown",
                    exit: "animated fadeOutUp",
                },
                icon_type: "class",
                template: '<div data-notify="container" class="col-xxl-3 col-lg-5 col-md-6 col-sm-7 col-12 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-info progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    "</div>" +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    "</div>",
            });
        });
    </script>
@endif
@if (session('success'))
    <script>
        $(document).ready(function () {
            $.notify({
                icon: "fa fa-check",
                title: "Success!",
                message: "{{ session('success') }}",
            }, {
                element: "body",
                position: null,
                type: "success",  // For success message
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: true,
                placement: {
                    from: "top",
                    align: "right",
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5000,
                animate: {
                    enter: "animated fadeInDown",
                    exit: "animated fadeOutUp",
                },
                icon_type: "class",
                template: '<div data-notify="container" class="col-xxl-3 col-lg-5 col-md-6 col-sm-7 col-12 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-info progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    "</div>" +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    "</div>",
            });
        });
        
    </script>
@endif
@if (!isset($_SERVER['HTTP_USER_AGENT']) || !preg_match('/(android|iphone|ipod|mobile)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
    <script>
    $(document).ready(function () {
        const $desktopMenu = $('.desktop-menu-st');
        const $categoryLists = $('.onhover-category-list');
        const $categoryBoxes = $('.onhover-category-box');
        $('.dropdown-category').on('click', function (e) {
            e.stopPropagation();
            $desktopMenu.toggleClass('show');
            $categoryLists.removeClass('active');
            $categoryBoxes.removeClass('show');
        });
        $categoryLists.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const $thisBox = $(this).find('.onhover-category-box');
            $categoryLists.not(this).removeClass('active')
                .find('.onhover-category-box').removeClass('show');
            $(this).toggleClass('active');

            if ($(this).hasClass('active')) {
                $thisBox.addClass('show');
            } else {
                $thisBox.removeClass('show');
            }
        });
        $('.close-button').on('click', function () {
            $desktopMenu.removeClass('show');
            $categoryLists.removeClass('active');
            $categoryBoxes.removeClass('show');
        });
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.desktop-menu-st').length &&
                !$(e.target).closest('.dropdown-category').length) {
                $desktopMenu.removeClass('show');
                $categoryLists.removeClass('active');
                $categoryBoxes.removeClass('show');
            }
        });
        $categoryBoxes.on('click', function (e) {
            e.stopPropagation();
        });
    });
</script>
@endif
