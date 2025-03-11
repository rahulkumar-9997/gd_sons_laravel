$(document).ready(function () {
   $('.show_confirm_customer').click(function (event) {
      var form = $(this).closest("form");
      var name = $(this).data("name");
      event.preventDefault();

      Swal.fire({
         title: `Are you sure you want to delete this ${name}?`,
         text: "If you delete this, it will be gone forever.",
         icon: "warning",
         showCancelButton: true,
         confirmButtonText: "Yes, delete it!",
         cancelButtonText: "Cancel",
         dangerMode: true,
      }).then((result) => {
         if (result.isConfirmed) {
            form.submit();
         }
      });
   });

   /**add new customer  */
   $(document).on('click', 'a[data-addCustomer-popup="true"]', function () {
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
         type: 'post',
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
   /**Customer form save  */
   $(document).off('submit', '#addNewCustomer').on('submit', '#addNewCustomer', function (event) {
      event.preventDefault();
      var form = $(this);
      var submitButton = form.find('button[type="submit"]');
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').remove();
      submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validating...');
      var formData = new FormData(this);
      $.ajax({
         url: form.attr('action'),
         type: 'POST',
         data: formData,
         processData: false,
         contentType: false,
         success: function (response) {
            submitButton.prop('disabled', false).html('Save changes');
            if (response.status === 'success') {
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
               $("#commanModel").modal('hide');
               var page = $('#pagination-links-customer .active').find('a').data('page') 
               || $('#pagination-links-customer .active').find('span').text() 
               || 1;
               page = parseInt(page);
               fetchCustomer(page);
            }
         },
         error: function (xhr) {
            submitButton.prop('disabled', false).html('Save changes');
            var errors = xhr.responseJSON.errors;
            if (errors) {
               $.each(errors, function (key, value) {
                  var inputField = $('#' + key);
                  inputField.addClass('is-invalid');
                  inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
               });
            }
         }
      });
   });
   /**Customer edit form statr**/
   $(document).on('click', 'a[data-editCustomer-popup="true"]', function () {
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
   /**Customer edit form statr**/
   /**customer edit form submit**/
   $(document).off('submit', '#updateCustomer').on('submit', '#updateCustomer', function (event) {
      event.preventDefault();
      var form = $(this);
      var submitButton = form.find('button[type="submit"]');
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').remove();
      submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

      var formData = new FormData(this);

      $.ajax({
         url: form.attr('action'),
         type: 'POST',
         data: formData,
         processData: false,
         contentType: false,
         success: function (response) {
            submitButton.prop('disabled', false).html('Update');
            if (response.status === 'success') {
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
               $("#commanModel").modal('hide');
               var page = $('#pagination-links-customer .active').find('a').data('page') 
               || $('#pagination-links-customer .active').find('span').text() 
               || 1;
               page = parseInt(page);
               fetchCustomer(page);
            }
         },
         error: function (xhr) {
            submitButton.prop('disabled', false).html('Update');
            var errors = xhr.responseJSON.errors;
            if (errors) {
               $.each(errors, function (key, value) {
                  var inputField = $('#' + key);
                  inputField.addClass('is-invalid');
                  inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
               });
            }
         }
      });
   });

   /**customer edit form submit**/
   /*Customer pagination */
   $(document).on('click', '#pagination-links-customer a', function (e) {
      e.preventDefault();
      const page = $(this).attr('href').split('page=')[1];
      fetchCustomer(page);
  });
   /*Customer pagination */
});

function updateCustomerGroup(selectElement) {
   var customerId = selectElement.id.split('-')[1];
   var groupId = selectElement.value;
   var url = selectElement.dataset.url;
   $.ajax({
      url: url,
      method: 'POST',
      data: {
         customer_id: customerId,
         group_id: groupId,
         _token: $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (response) {

         if (response.success) {
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
            var page = $('#pagination-links-customer .active').find('a').data('page') 
               || $('#pagination-links-customer .active').find('span').text() 
               || 1;
               page = parseInt(page);
               fetchCustomer(page);
         }
         else {
            Toastify({
               text: response.message,
               duration: 10000,
               gravity: "top",
               position: "right",
               className: "bg-danger",
               escapeMarkup: false,
               close: true,
               onClick: function () { }
            }).showToast();
         }
      },
      error: function () {
         Toastify({
            text: "An error occurred. Please try again.",
            duration: 10000,
            gravity: "top",
            position: "right",
            className: "bg-danger",
            escapeMarkup: false,
            close: true,
            onClick: function () { }
         }).showToast();

      },
   });
}

function fetchCustomer(page = 1,) {
   $('#loader').show();
   $.ajax({
       url: routes.customerIndex,
       type: "GET",
       data: {
           page: page,
       },
       success: function (data) {
           $('#customer-list-container').html(data);
           $('#loader').hide();
          
       },
       error: function () {
           alert("An error occurred while filtering products.");
           $('#loader').hide();
       }
   });
}
