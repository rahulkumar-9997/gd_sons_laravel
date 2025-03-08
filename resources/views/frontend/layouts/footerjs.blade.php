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
<script src="{{asset('frontend/assets/js/wow.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/custom-wow.js')}}"></script>
<script src="{{asset('frontend/assets/js/script.js')}}"></script>
<script src="{{asset('frontend/assets/js/gd.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/search.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/notifications.js')}}"></script>

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
