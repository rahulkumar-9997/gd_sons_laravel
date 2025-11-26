$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var site_url = $('meta[name="base-url"]').attr('content');
$(document).ready(function () {

    $(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
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
    /**status on off  */
    $(document).on('click', '.statusonoff', function () {
        var brand_id = $(this).data('bid');
        var isChecked = $(this).is(':checked');
        var updateStatusUrl = '/update-status/' + brand_id;
        if (isChecked) {
            console.log("Checkbox is checked");
    
            $.ajax({
                url: updateStatusUrl,
                type: 'POST',
                data: {
                    brand_id: brand_id,
                    status: 'on',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        Toastify({
                            text: response.message, 
                            duration: 4000,
                            gravity: "top",
                            position: "right", 
                            className: "bg-success",
                            close: true, 
                            onClick: function() { }
                        }).showToast();
                        console.log('Status updated successfully: ', response.success);
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        } else {
            console.log("Checkbox is unchecked");
            $.ajax({
                url: updateStatusUrl,
                type: 'POST',
                data: {
                    brand_id: brand_id,
                    status: 'off',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Status updated successfully: ', response.success);
                    if (response.status) {
                        Toastify({
                            text: response.message, 
                            duration: 4000,
                            gravity: "top",
                            position: "right", 
                            className: "bg-success",
                            close: true, 
                            onClick: function() { }
                        }).showToast();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }
    });
    /**status on off  */
    /**Popular  on off  */
    $(document).on('click', '.popularonoff', function () {
        var brand_id = $(this).data('bid');
        var isChecked = $(this).is(':checked');
        var updateStatusUrl = '/update-status/' + brand_id;
        if (isChecked) {
            console.log("Checkbox is checked");
    
            $.ajax({
                url: updateStatusUrl,
                type: 'POST',
                data: {
                    brand_id: brand_id,
                    is_popular: 'on',
                    popular_action :'popular_action',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        Toastify({
                            text: response.message, 
                            duration: 4000,
                            gravity: "top",
                            position: "right", 
                            className: "bg-success",
                            close: true, 
                            onClick: function() { }
                        }).showToast();
                        console.log('Status updated successfully: ', response.success);
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        } else {
            console.log("Checkbox is unchecked");
            $.ajax({
                url: updateStatusUrl,
                type: 'POST',
                data: {
                    brand_id: brand_id,
                    is_popular: 'off',
                    popular_action :'popular_action',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Status updated successfully: ', response.success);
                    if (response.status) {
                        Toastify({
                            text: response.message, 
                            duration: 4000,
                            gravity: "top",
                            position: "right", 
                            className: "bg-success",
                            close: true, 
                            onClick: function() { }
                        }).showToast();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }
    });
    /**Popular  on off  */
    /*Edit brand code*/
    $(document).on('click', '.editbrand', function () {
        var brand_id = $(this).data('bid');
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            brand_id: brand_id
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                // alert(JSON.stringify(data.form2));
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);        
    });
    /*Edit brand code*/
    /*Edit brand code*/
    /**Label form */
    $(document).on('click', 'a[data-label-popup="true"]', function () {
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

    $(document).on('click', '.editLabel', function () {
        var label_id = $(this).data('lid');
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            label_id: label_id
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                // alert(JSON.stringify(data.form2));
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);        
    });
    /**Label form */
    /**Category */
    $(document).on('click', 'a[data-category-popup="true"]', function () {
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
                $('#commanModel').on('shown.bs.modal', function() {
                    initializeSelect2Modal();
                });
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
    });

    $(document).on('click', '.editCategory', function () {
        var label_id = $(this).data('catid');
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            label_id: label_id
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                // alert(JSON.stringify(data.form2));
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
                $('#commanModel').on('shown.bs.modal', function() {
                    initializeSelect2Modal();
                });
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);        
    });
    /**Category */
    /**Subcategory */
    $(document).on('click', 'a[data-subcategory-popup="true"]', function () {
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

    $(document).on('click', '.editSubcategory', function () {
        var subcategory_id = $(this).data('subcatid');
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            subcategory_id: subcategory_id
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                // alert(JSON.stringify(data.form2));
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);        
    });
    /**Subcategory */
    /**Attributes */
    $(document).on('click', 'a[data-attributes-popup="true"]', function () {
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

    
    $(document).on('click', '.editAttributes', function () {
        var attributes_id = $(this).data('attriid');
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            attributes_id: attributes_id
        };
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
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);        
    });
    /**Attributes */

    /**Attributes Value*/
        $(document).on('click', '.editAttValue', function () {
            var attributes_value_id = $(this).data('attrivid');
            
            var title = $(this).data('title');
            var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
            var url = $(this).data('url');
            
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                size: size,
                url: url,
                attributes_value_id: attributes_value_id,
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
                    $('#mapped_attributes_value_to_category').select2({
                        dropdownParent: $("#commanModel")
                    });
                },
                error: function (data) {
                    data = data.responseJSON;
                }
            });
        });
    /**Attributes Value*/
    
});

function initializeSelect2Modal() {
    $('.js-example-basic-single, .js-example-basic-multiple').each(function() {
        if ($(this).hasClass("select2-hidden-accessible")) {
            $(this).select2('destroy');  // Destroy if already initialized
        }
    });
    
    $('.js-example-basic-single').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    
    $('.js-example-basic-multiple').select2({
        placeholder: "Select Product Attributes Value",
        allowClear: true
    });
    
    console.log('Select2 initialized for existing and new elements.');
}
/**product add, edit submit button fixed after scroll */
$(document).ready(function () {
    var headerHeight = $('header.topbar').outerHeight();
    var footer = $('.card-footer');
    var card = $('.card_fixed'); 
    /*alert(card.outerWidth());*/
    if (footer.length) {
        var footerOffset = footer.offset().top;
        console.log(footerOffset);
    } else {
        // console.log("Footer not found!");
    }
    function updateFooterWidth() {
        footer.css('width', card.outerWidth() + 'px');
    }
    $(window).on('scroll resize', function () {
        if ($(window).scrollTop() > footerOffset - headerHeight) {
            footer.addClass('fixed-footer').css('top', headerHeight + 'px');
            updateFooterWidth();
        } else {
            footer.removeClass('fixed-footer').css('width', '');
        }
    });
    $(window).resize(updateFooterWidth);
});

/**submut button fixed after scroll */
