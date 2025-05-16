$(document).ready(function () {

    $(document).on('click', 'a[data-addgroupcategory-popup="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url
        };
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);
        
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });
    $(document).off('submit', '#addNewGroupCategory').on('submit', '#addNewGroupCategory', function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        var formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false);
                submitButton.html('Save changes');
                if (response.status === 'success') {
                    form[0].reset();
                    $('#commanModel').modal('hide');
                    $('.group-category-list').html(response.groupCategoryContent);
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        escapeMarkup: false,
                        close: true,
                        onClick: function () { }
                    }).showToast();
                }
            },
            error: function(xhr, status, error) {
                submitButton.prop('disabled', false);
                submitButton.html('Save changes');
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        var errorElement = $('#' + key + '_error');
                        if (errorElement.length) {
                            errorElement.text(value[0]);
                        }
                        var inputField = $('#' + key);
                        inputField.addClass('is-invalid');
                        inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                    });
                }
            }
        });
    });
    
    /**Edit group modal js */
    $(document).on('click', 'a[data-editgroupcategory-popup="true"]', function () {
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var groupCategoryId = $(this).data('groupcateid');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            group_category_id: groupCategoryId,
        };
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);
        
        $.ajax({
            url: url,
            type: 'get',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });
    /**Edit group modal js */
    $(document).off('submit', '#UpdateGroupCategory').on('submit', '#UpdateGroupCategory', function (event) {
        event.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        var formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                submitButton.prop('disabled', false);
                submitButton.html('Save changes');
                if (response.status === 'success') {
                    form[0].reset();
                    $('#commanModel').modal('hide');
                    $('.group-category-list').html(response.groupCategoryContent);
                    Toastify({
                        text: response.message,
                        duration: 10000,
                        gravity: "top",
                        position: "right",
                        className: "bg-success",
                        escapeMarkup: false,
                        close: true,
                        onClick: function () { }
                    }).showToast();
                }
            },
            error: function(xhr, status, error) {
                submitButton.prop('disabled', false);
                submitButton.html('Save changes');
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        var errorElement = $('#' + key + '_error');
                        if (errorElement.length) {
                            errorElement.text(value[0]);
                        }
                        var inputField = $('#' + key);
                        inputField.addClass('is-invalid');
                        inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                    });
                }
            }
        });
    });
    
});
