/**Review form hide and show */
$(document).ready(function () {
    const $writeReviewBtn = $('.write-rev-link');
    const $cancelReviewBtn = $('.cancel-review-btn');
    const $formSection = $('.review-form-section');
    $('.write-rev-link, .cancel-review-btn').on('click', function (e) {
        e.preventDefault();
        const isVisible = $formSection.is(':visible');
        if (isVisible) {
            $formSection.slideUp(400, function () {
                $('html, body').animate({
                    scrollTop: $writeReviewBtn.offset().top - 100
                }, 400);
            });
            $writeReviewBtn.attr('aria-expanded', 'false').text('Write a review');
        } else {
            $formSection.slideDown(400, function () {
                $('html, body').animate({
                    scrollTop: $formSection.offset().top - 100
                }, 400);
            });
            $writeReviewBtn.attr('aria-expanded', 'true').text('Hide review form');
        }
    });
});
/**review image or video display */
$(document).ready(function () {
    const $input = $('#review_pic_or_video');
    const $preview = $('#preview-container');
    let filesArray = [];
    $input.on('change', function (e) {
        const newFiles = Array.from(e.target.files);
        newFiles.forEach((file) => {
            const index = filesArray.length;
            filesArray.push(file);
            const reader = new FileReader();
            reader.onload = function (event) {
                const isImage = file.type.startsWith('image/');
                const isVideo = file.type.startsWith('video/');
                const previewItem = $('<div class="preview-item"></div>');
                const removeBtn = $('<button type="button" class="remove-preview">&times;</button>');
                removeBtn.on('click', function () {
                    filesArray[index] = null;
                    previewItem.remove();
                });
                if (isImage) {
                    previewItem.append(`<img src="${event.target.result}" alt="Preview">`);
                } else if (isVideo) {
                    previewItem.append(`<video src="${event.target.result}" controls></video>`);
                }
                previewItem.append(removeBtn);
                $preview.append(previewItem);
            };
            reader.readAsDataURL(file);
        });
        /* Replace real file list before submit */
        $('#reviewForm').off('submit').on('submit', function () {
            const filteredFiles = filesArray.filter(f => f !== null);
            const dataTransfer = new DataTransfer();
            filteredFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            $input[0].files = dataTransfer.files;
        });
    });
    /**review image or video display */
    /**Review form submit code */
    $(document).off('submit', '#reviewForm').on('submit', '#reviewForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var $formSection = $('.review-form-section');
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('#rating_error').hide().text('');
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
        var formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#rating-stars').removeClass('is-invalid');
                $('#rating_error').hide().text('');
                submitButton.prop('disabled', false);
                submitButton.html('Submit Review');
                if (response.status === 'success') {
                    form[0].reset();
                    $('#preview-container').empty();
                    $('.star').removeClass('active');
                    showNotificationAll("success", "", response.message);
                    $formSection.slideUp(400, function () {
                        $('html, body').animate({
                            scrollTop: $writeReviewBtn.offset().top - 100
                        }, 400);
                    });
                }
            },
            error: function (xhr, status, error) {
                submitButton.prop('disabled', false);
                submitButton.html('Submit Review');
                try {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function (key, value) {
                            if (key === 'rating') {
                                $('#rating_error').text(value[0]).show();
                            } else {
                                var inputField = $('[name="' + key + '"]');
                                inputField.addClass('is-invalid');
                                inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                            }
                        });
                    } else {
                        showNotificationAll("warning", "", "An error occurred. Please try again");
                    }
                } catch (e) {
                    showNotificationAll("warning", "", "An unexpected error occurred.");
                }
            }
        });
    });
    /**Review form submit code */
    /*Review Load more js code */
    let currentReviewPage = 1;
    function showLoadMoreButtonLoader() {
        $('#load-more-reviews').prop('disabled', true).text('Loading...');
    }

    function hideLoadMoreButtonLoader() {
        $('#load-more-reviews').prop('disabled', false).text('Load More Reviews');
    }

    function fetchMoreReviews(url, append = true) {
        let productId = $('#load-more-reviews').data('product-id');
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                product_id: productId,
                page: currentReviewPage,
                _token: $('meta[name="csrf-token"]').attr('content')            },
            success: function (response) {
                if (response.success) {
                    if (append) {
                        $('#review-catalog-frontend').append(response.reviews);
                    } else {
                        $('#review-catalog-frontend').html(response.reviews);
                    }
                    if (response.hasMore) {
                        $('#load-more-reviews')
                            .show()
                            .data('next-page', response.nextPage);
                    } else {
                        $('#load-more-reviews').hide();
                    }
                }
                hideLoadMoreButtonLoader();
            },
            error: function (xhr) {
                console.error('Error loading reviews:', xhr.responseText);
                hideLoadMoreButtonLoader();
                alert('Failed to load reviews. Please try again.');
            }
        });
    }
    $(document).on('click', '#load-more-reviews', function () {
        currentReviewPage = $(this).data('next-page') || 2;
        let url = $(this).data('url');
        showLoadMoreButtonLoader();
        fetchMoreReviews(url, true);
    });
    /*Review Load more js code */
});
