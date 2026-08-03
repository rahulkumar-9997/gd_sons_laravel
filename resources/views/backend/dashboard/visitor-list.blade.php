@extends('backend.layouts.master')
@section('title','All visitor list')
@section('main-content')

<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">
                  All Visitor List
               </h4>
            </div>
            <div class="card-body">
               <div class="row align-items-end mb-3 g-2" id="visitor-filter-bar">
                  <div class="col-auto">
                     <select class="form-select form-select-sm" id="dateFilterSelect" style="min-width: 180px;">
                        <option value="all" selected>All Time</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last7">Last 7 Days</option>
                        <option value="last30">30 Days</option>
                        <option value="last60">60 Days</option>
                        <option value="last90">90 Days</option>
                     </select>
                  </div>
                  <div class="col-auto">
                      <button type="button" class="btn btn-sm btn-success" id="exportExcelBtn">
                           <i class="fa fa-file-excel"></i> Export Excel
                     </button>
                  </div>
                  <div class="col-auto ms-auto">
                     <button type="button" class="btn btn-sm btn-warning" id="clearOldDataBtn">
                           <i class="fa fa-broom"></i> Clear Data (less than 90 days)
                     </button>                    
                  </div>
               </div>

               @if (isset($data['visitor_list']) && $data['visitor_list']->count() > 0)
               <div class="table-responsive position-relative" id="product-list-container">
                  @include('backend.dashboard.partials.ajax-visitor-list', ['data' => $data])

                  <div id="visitorListLoader" class="position-absolute top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center" style="background: rgba(255,255,255,0.7); z-index: 10;">
                     <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                     </div>
                  </div>
               </div>
               @else
               <div class="table-responsive position-relative" id="product-list-container">
                  <div class="alert alert-warning">No visitors found.</div>                  
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Container Fluid -->
@include('backend.layouts.common-modal-form')
@endsection

@push('scripts')
<script>
$(function () {
    /* ================= LOADER HELPERS (using #loader) ================= */
    function showLoader() {
        $('#loader').fadeIn(150);
    }
    function hideLoader() {
        $('#loader').fadeOut(150);
    }
    /* ================= SELECT ALL / BULK DELETE ================= */
    $(document).on('change', '#selectAllVisitors', function() {
        $('.visitor-checkbox').prop('checked', $(this).is(':checked'));
    });

    $(document).on('click', '#deleteSelectedVisitors', function() {
        let ids = [];
        $('.visitor-checkbox:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.length === 0) {
            Swal.fire({ icon: 'warning', title: 'No selection', text: 'Please select at least one visitor.' });
            return;
        }
        Swal.fire({
            title: 'Are you sure?',
            text: "Selected visitors will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) return;
            showLoader();
            $.ajax({
                url: "{{ route('visitors.bulk-delete') }}",
                type: "POST",
                data: { _token: "{{ csrf_token() }}", ids: ids },
                success: function(res) {
                    if (res.success) {
                        $('#product-list-container').html(res.html);
                        Swal.fire({ icon: 'success', title: 'Deleted!', text: 'Selected visitors deleted successfully.', timer: 2000, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Something went wrong.' });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.' });
                },
                complete: function () {
                    hideLoader();
                }
            });
        });
    });

    /* ================= LOAD LIST (filter + pagination) — raw html response ================= */
   function loadVisitorList(page) {
        let filter = $('#dateFilterSelect').val();

        showLoader();
        $.ajax({
            url: "{{ route('get-visitor-list') }}",
            type: "GET",
            data: { date_filter: filter, page: page || 1 },
            success: function (html) {
                $('#product-list-container').html(html);
            },
            error: function (xhr) {
                let msg = 'Something went wrong while filtering visitors.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            },
            complete: function () {
                hideLoader();
            }
        });
   }   

    /* ================= PAGINATION (AJAX) — carries current filter ================= */
    $(document).on('click', '#pagination-links-visitor a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (!url) return;
        let pageMatch = url.match(/[?&]page=(\d+)/);
        let page = pageMatch ? pageMatch[1] : 1;
        loadVisitorList(page);
    });

   /* ================= EXPORT EXCEL — using fetch() for reliable blob handling ================= */
   $(document).on('click', '#exportExcelBtn', function () {
      let filter = $('#dateFilterSelect').val();
      let $btn = $(this);
      let originalHtml = $btn.html();
      $btn.prop('disabled', true);
      showLoader();

      let url = "{{ route('visitors.export') }}?date_filter=" + encodeURIComponent(filter);

      fetch(url, {
         method: 'GET',
         headers: {
               'X-Requested-With': 'XMLHttpRequest',
               'Accept': 'application/json, application/octet-stream'
         }
      })
      .then(async function (response) {
         let contentType = response.headers.get('content-type') || '';

         if (contentType.indexOf('application/json') !== -1) {
               let json = await response.json();
               throw { isHandled: true, message: json.message || 'No visitor data found for the selected filter.' };
         }

         if (!response.ok) {
               // Real error text nikal ke dikhao (temporary debug ke liye)
               let text = await response.text();
               console.error('Export failed. Status:', response.status, 'Body:', text);
               throw { isHandled: true, message: 'Export failed (HTTP ' + response.status + '). Check console for details.' };
         }

         let disposition = response.headers.get('content-disposition');
         let fileName = 'visitor-list.xlsx';
         if (disposition) {
               let match = disposition.match(/filename="?([^"]+)"?/);
               if (match && match[1]) fileName = match[1];
         }

         let blob = await response.blob();
         return { blob, fileName };
      })
      .then(function ({ blob, fileName }) {
         let downloadUrl = window.URL.createObjectURL(blob);
         let a = document.createElement('a');
         a.style.display = 'none';
         a.href = downloadUrl;
         a.download = fileName;
         document.body.appendChild(a);
         a.click();
         setTimeout(function () {
               document.body.removeChild(a);
               window.URL.revokeObjectURL(downloadUrl);
         }, 200);
      })
      .catch(function (err) {
         console.error('Export error:', err);
         let msg = (err && err.isHandled) ? err.message : 'Something went wrong while exporting. Please try again.';
         Swal.fire({ icon: 'warning', title: 'Export Failed', text: msg });
      })
      .finally(function () {
         $btn.html(originalHtml).prop('disabled', false);
         hideLoader();
      });
   });

   $(document).on('click', '#clearOldDataBtn', function () {
      Swal.fire({
         title: 'Are you sure?',
         html: "This will <strong>permanently delete</strong> all visitor data <strong>older than 90 days</strong>.<br>Last 90 days data will be kept safe.",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Yes, delete old data',
         cancelButtonText: 'Cancel',
         confirmButtonColor: '#d33',
      }).then((result) => {
         if (!result.isConfirmed) return;

         showLoader();
         $.ajax({
               url: "{{ route('visitors.clear-old-data') }}",
               type: "POST",
               data: { _token: "{{ csrf_token() }}" },
               success: function (res) {
                  if (res.success) {
                     if (res.html) {
                           $('#product-list-container').html(res.html);
                     }
                     Swal.fire({
                           icon: 'success',
                           title: res.deleted_count > 0 ? 'Cleared!' : 'Nothing to Clear',
                           text: res.message,
                           timer: 2500,
                           showConfirmButton: false
                     });
                  } else {
                     Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Something went wrong.' });
                  }
               },
               error: function (xhr) {
                  let msg = 'Something went wrong while clearing old data.';
                  if (xhr.responseJSON && xhr.responseJSON.message) {
                     msg = xhr.responseJSON.message;
                  }
                  Swal.fire({ icon: 'error', title: 'Error', text: msg });
               },
               complete: function () {
                  hideLoader();
               }
         });
      });
   });

});
</script>
@endpush