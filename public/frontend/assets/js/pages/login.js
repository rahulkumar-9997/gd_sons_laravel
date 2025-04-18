$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var otpTimer;
    var countdownTime = 30;
    
    function startOtpCountdown() {
        $(".count-down-otp").removeClass("hideBox");
        var timer = countdownTime;
        clearInterval(otpTimer);

        otpTimer = setInterval(function () {
            var seconds = timer % 60;
            $(".count-down-otp").text("00:" + (seconds < 10 ? "0" : "") + seconds);

            if (timer <= 0) {
                clearInterval(otpTimer);
                $(".count-down-otp").text("00:00");
            }
            timer--;
        }, 1000);
    }

    function showNotification(type, title, message) {
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

    
    $('#request-otp-button').click(function (e) {
        e.preventDefault();
        
        let submitButton = $(this);
        let originalButtonText = submitButton.html();
        
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
    
        var emailOrWhatsappNo = $('#emailOrWhatssappNo').val().trim(); 
        $(".resend-btn").attr('href', '#').addClass('disabled').css('pointer-events', 'none');
        $(".user-details").text(emailOrWhatsappNo);
        $('#emailOrWhatsappNo').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    
        $.ajax({
            url: requestOtpUrl,
            type: 'POST',
            data: {
                emailOrWhatsappNo: emailOrWhatsappNo,  
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                submitButton.prop('disabled', false).html(originalButtonText);
    
                if (response.success) {
                    if(response.dummy==1){
                        showNotification("success", "Success!", response.message);
                        window.location.href = response.redirect_url;
                    }
                    $('.login-box').hide();
                    $('.opt-box').removeClass('hideBox');
    
                    startOtpCountdown();
                    showNotification("success", "Success!", response.message);
    
                    setTimeout(function () {
                        $(".resend-btn").removeClass('disabled').css('pointer-events', 'auto');
                    }, 30000);
                } else {
                    showNotification("danger", "", response.message);
                    $('#emailOrWhatsappNo').focus();
                }
            },
            error: function (xhr) {
                submitButton.prop('disabled', false).html(originalButtonText);
                
                let errorMessage = 'An error occurred, please try again.';
                
                if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                } 
                
                if (xhr.responseJSON?.errors) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.emailOrWhatsappNo) {
                        $('#emailOrWhatsappNo').addClass('is-invalid');
                        $('#emailOrWhatsappNo').after(`<div class="invalid-feedback">${errors.emailOrWhatsappNo[0]}</div>`);
                    }
                    errorMessage = errors.emailOrWhatsappNo ? errors.emailOrWhatsappNo[0] : errorMessage;
                }
                $('#emailOrWhatsappNo').focus();
                showNotification("danger", "error !", errorMessage);
               
            }
        });
    });

    

    $('.resend-btn').click(function (e) {
        e.preventDefault();

        let submitButton = $(this);
        let originalButtonText = submitButton.html();
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Resending...');
        $(".resend-btn").attr('href', '#').addClass('disabled').css('pointer-events', 'none');
        $.post(resendOtpUrl, function (response) {
            if (response.success) {
                showNotification("success", "", response.message);
                startOtpCountdown();
                setTimeout(function () {
                    submitButton.prop('disabled', false).html(originalButtonText);
                    $(".resend-btn").removeClass('disabled').css('pointer-events', 'auto');
                }, 30000);  // Re-enable after 30 seconds
            } else {
                showNotification("danger", "Error!", response.responseJSON.error);
                submitButton.prop('disabled', false).html(originalButtonText);
                $(".resend-btn").removeClass('disabled').css('pointer-events', 'auto');
            }
        }).fail(function (response) {
            submitButton.prop('disabled', false).html(originalButtonText);
            $(".resend-btn").removeClass('disabled').css('pointer-events', 'auto');
            showNotification("danger", "Error!", response.responseJSON.error);
        });
    });

    $('#verify-otp-button').click(function (e) {
        e.preventDefault();
        var otp = $('.otp-input').val();
        if (otp === '') {
            showNotification("danger", "Error!", "Please enter the OTP.");
            return;
        }
    
        var submitButton = $(this);
        var originalButtonText = submitButton.html();
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');
        var urlParams = new URLSearchParams(window.location.search);
        var redirectUrl = urlParams.get('redirect');
        
        $.post(verifyOtpUrl, { otp: otp, redirect: redirectUrl }, function (response) {
            if (response.success) {
                $('.opt-box').hide();
                if(response.displayform==1){
                    showNotification("success", "Success!", response.message);
                    $('.updateaccount').removeClass('hideBox');
                    if (response.contact_field && response.contact_value) {
                        if (response.contact_field === 'email') {
                            $('#update_email').val(response.contact_value).prop('readonly', true);
                        } else if (response.contact_field === 'phone_number') {
                            $('#phone').val(response.contact_value).prop('readonly', true);
                        }
                    }
                }else{
                    showNotification("success", "Success!", response.message);
                    window.location.href = response.redirect_url;
                }
            } else {
                showNotification("danger", "Error!", response.error || "An unknown error occurred.");
            }
            submitButton.prop('disabled', false).html(originalButtonText);
        }).fail(function (jqXHR) {
            submitButton.prop('disabled', false).html(originalButtonText);
            var errorMessage = jqXHR.responseJSON && jqXHR.responseJSON.error
                ? jqXHR.responseJSON.error
                : "An error occurred while verifying OTP. Please try again.";
            showNotification("danger", "Error!", errorMessage);
        });
    });
    

    $(".edit-phone").click(function (e) {
        e.preventDefault();
        $('.opt-box').addClass('hideBox');
        $('.login-box').show();
    });

    /**Update account submit */
    $('#request-update-button').click(function (e) {
        e.preventDefault();
        var otp = $('.otp-input').val(); 
        var update_email = $('#update_email').val();
        //alert(update_email);
        var name = $('#name').val();
        var phone = $('#phone').val();
    
        if (name === '') {
            showNotification("danger", "Error!", "Please enter your name.");
            return;
        }
        if (phone === '') {
            showNotification("danger", "Error!", "Please enter your pnone number.");
            return;
        }
    
        var submitButton = $(this);
        var originalButtonText = submitButton.html();
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');
        var urlParams = new URLSearchParams(window.location.search);
        var redirectUrl = urlParams.get('redirect');
        
        $.post(updateDetailsUrl, { otp: otp, email: update_email, redirect: redirectUrl, phone: phone, name:name }, function (response) {
            if (response.success) {
                showNotification("success", "Success!", response.message);
                window.location.href = response.redirect_url;
            } else {
                showNotification("danger", "Error!", response.error || "An unknown error occurred.");
            }
            submitButton.prop('disabled', false).html(originalButtonText);
        }).fail(function (jqXHR) {
            submitButton.prop('disabled', false).html(originalButtonText);
            var errorMessage = jqXHR.responseJSON && jqXHR.responseJSON.error
                ? jqXHR.responseJSON.error
                : "An error occurred while updating account details.";
            showNotification("danger", "Error!", errorMessage);
        });
    });
    
    
});

