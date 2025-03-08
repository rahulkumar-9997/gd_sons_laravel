$(document).ready(function () {
   $('#product_categories').on('change', function () {
      var selectedCategory = $(this).val();
      var currentUrl = new URL(window.location.href);
      var params = currentUrl.searchParams;
  
      if (selectedCategory) {
          params.set('category', selectedCategory);
      } else {
          params.delete('category');
      }
      currentUrl.search = params.toString();
      window.location.href = currentUrl.toString();
   });
    /**add new attributes value */
    $(document).on('click change', 'button[data-modal-popup="true"], #product_categories', function () {
        var lastRowId = $('.add-more-attributes-append .row[id^="attribute-row"]').last().attr('id');
        var lastRowNumber = lastRowId ? lastRowId.split('-').pop() : null;
        var attributes_id = $('#pro-att-'+lastRowNumber).val(); 
        var categoryId = $('#product_categories').val();
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        //alert(attributes_id);
        //alert(attributes_id);
        var data = {
           _token: $('meta[name="csrf-token"]').attr('content'),
           size: size,
           url: url,
           category_id: categoryId,
           attributes_id: attributes_id,
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
                 $('#category_id_modal').select2({
                    dropdownParent: $("#commanModel")
                });
              },
              error: function (data) {
                 data = data.responseJSON;
              }
        });
     });
     /**add new attributes value */
     /**Attributes value form submit */
     $(document).off('submit', '#addNewAttributesValueForm').on('submit', '#addNewAttributesValueForm', function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let formData = new FormData(this);
        $('#loader').show();
        $('#error-list').empty(); 
        $.ajax({
           url: url,
           type: 'POST',
           data: formData,
           processData: false,
           contentType: false,
           beforeSend: function () {
                 $('.form-control').removeClass('is-invalid');
                 $('.invalid-feedback').remove();
           },
           success: function (response) {
                 $("#commanModel").modal('hide');
                 $('#loader').hide();
                 if (response.success) {
                    Toastify({
                       text: response.message || "Form submitted successfully!",
                       duration: 3000,
                       gravity: "top",
                       position: "right",
                       backgroundColor: "green",
                       close: true,
                    }).showToast();
                    form[0].reset();
                    $('.js-example-basic-multiple').val(null).trigger('change');
                 } else {
                    Toastify({
                       text: "An unexpected error occurred.",
                       duration: 3000,
                       gravity: "top",
                       position: "right",
                       backgroundColor: "orange",
                       close: true,
                    }).showToast();
                 }
           },
           error: function (xhr) {
              $('#loader').hide();
              if (xhr.status === 422) {
                 let errors = xhr.responseJSON.errors;
                 var errorList = '';
                 var toastMessage = ''; 
                 for (let key in errors) {
                    let errorMsg = `<li><strong>${errors[key][0]}</strong></li>`;
                    errorList += errorMsg; 
                    toastMessage += `${errors[key][0]}<br>`;
                 }

                 if (errorList) {
                    $('#error-list').html(`<ul style="color: #d9534f; font-size: 14px;">${errorList}</ul>`);
                 }
                 Toastify({
                    text: toastMessage || "Please correct the highlighted errors.",
                    duration: 10000,
                    gravity: "top",
                    position: "right",
                    className: "bg-danger",
                    escapeMarkup: false,
                    close: true,
                 }).showToast();
              } else {
                 Toastify({
                    text: "Something went wrong. Please try again.",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "red",
                    close: true,
                 }).showToast();
              }
           },
        });
     });
     /**Attributes value form submit */
});
