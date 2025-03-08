@extends('backend.layouts.master')
@section('title','Manage Products')
@section('main-content')
@push('styles')
<!-- <link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen"/>    -->
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/js/daterangepicker/daterangepicker.css')}}" />
@endpush
<!-- Start Container Fluid -->
 
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div id="example-2_wrapper" class="filter-box">
            <div class="d-flex flex-wrap align-items-center bg-white p-2 gap-1 client-list-filter">
               <!-- Duration Filter -->
               <div class="d-flex align-items-center border-end pe-1">
                  <p class="mb-0 me-2 text-dark-grey f-14">Duration:</p>
                  <input type="text" class="form-control form-control-sm text-dark border-0 f-14" id="daterange" name="daterange" placeholder="Start Date To End Date" autocomplete="off">
               </div>

               <!-- Category Filter -->
               <div class="d-flex align-items-center border-end pe-1">
                  <p class="mb-0 me-2 text-dark-grey f-14">Category:</p>
                  <select id="category-filter" class="form-select form-select-md">
                     <option value="">All Categories</option>
                     @foreach($data['categories'] as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="d-flex align-items-center border-end pe-1">
                  <p class="mb-0 me-2 text-dark-grey f-14">Status:</p>
                  <select id="product-status"  name="status" class="form-select form-select-md">
                     <option value="">Select Product Status</option>
                     <option value="1">Published</option>
                     <option value="0">Not Published</option>
                  </select>
               </div>

               <!-- Search Filter -->
               <div class="d-flex align-items-center">
                  <label class="mb-0 me-2 text-dark-grey f-14">Search:</label>
                  <input type="search" class="form-control form-control-md" id="product-search" placeholder="Search products">
               </div>
               <button id="reset-button" class="btn btn-danger" style="display:none;">
                  <svg class="svg-inline--fa fa-times-circle fa-w-16 mr-1" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                  Reset Filters
               </button>
            </div>
         </div>
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">
                  All Produtcs List
                  <!-- Bulk delete button, hidden initially -->
                  <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger" style="display: none;">Delete Selected</button> 
               </h4>
               <!-- <input type="text" name="daterange" id="daterange" /> -->
               <!-- <div class="dropdown">
                  <select id="category-filter" class="form-select">
                     <option value="">All Categories</option>
                     @foreach($data['categories'] as $category)
                           <option value="{{ $category->id }}">{{ $category->title }}</option>
                     @endforeach
                  </select>
               </div> -->
                <a href="{{route('product-multiple-update')}}" 
                    data-title="Product Multiple Update" 
                    data-bs-toggle="tooltip" 
                    title="Product Multiple Update" 
                    class="btn btn-sm btn-info">
                    Product Multiple Update
                </a>
                <a href="{{route('product-update-gst')}}" 
                    data-title="Import Product" 
                    data-bs-toggle="tooltip" 
                    title="Update GST/HSN Code" 
                    class="btn btn-sm btn-danger">
                    Update GST/HSN Code
                </a>
                <a href="{{route('product.excel.import')}}" 
                    data-title="Import Product" 
                    data-bs-toggle="tooltip" 
                    title="Import Product" 
                    class="btn btn-sm btn-warning">
                    Import Product
                </a>
                <a href="{{route('product.create')}}" 
                    data-title="Add Product" 
                    data-bs-toggle="tooltip" 
                    title="Add Product" 
                    class="btn btn-sm btn-success">
                    Add Product
                </a>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                    Choose any Links
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('export.product') }}" class="dropdown-item">Export Product</a>
                        <!-- item-->
                        <a href="{{route('product.excel.import')}}" class="dropdown-item">Import Product</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
               @if (isset($data['product_list']) && $data['product_list']->count() > 0)
                  
                  <div class="table-responsive" id="product-list-container">
                     @include('backend.product.partials.product_table', ['data' => $data])
                  </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Container Fluid -->
<!-- Modal -->
@include('backend.layouts.common-modal-form')
<!-- modal--->
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('backend/assets/js/daterangepicker/daterangepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/assets/js/pages/upload-image-file.js')}}"></script>
<script>
    var routes = {
        productIndex: "{{ route('product.index') }}",
        productBulkDelete: "{{ route('product.bulkDelete') }}"
    };
    var csrfToken = "{{ csrf_token() }}";
</script>
<script type="text/javascript" src="{{asset('backend/assets/js/pages/product-management.js')}}"></script>

<!-- <script type="text/javascript">
   $(function() {
    $('#daterange').daterangepicker({
        opens: 'right',
        ranges: {
            'Today': [moment(), moment()],
            'Last 15 Days': [moment().subtract(15, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'Last 60 Days': [moment().subtract(59, 'days'), moment()],
            'Last 90 Days': [moment().subtract(89, 'days'), moment()],
            'Last 6 Months': [moment().subtract(6, 'months'), moment()],
            'Last 1 Year': [moment().subtract(1, 'year'), moment()],
        },
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear',
        }
    });

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        updateFilters();
    });

    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        updateFilters();
    });

    // Add event listeners for all filters
    $('#category-filter, #product-status').on('change', updateFilters);
    $('#product-search').on('keyup', updateFilters);

    $('#reset-button').on('click', function() {
        $('#category-filter, #product-search, #daterange, #product-status').val('');
        $('#reset-button').hide();
        fetchProducts();
    });

    $(document).on('click', '#pagination-links a', function(e) {
        e.preventDefault();
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        const dateRange = $('#daterange').val();
        const productStatus = $('#product-status').val();
        const page = $(this).attr('href').split('page=')[1];
        fetchProducts(categoryId, search, page, dateRange, productStatus);
    });

    function updateFilters() {
        const categoryId = $('#category-filter').val();
        const search = $('#product-search').val();
        const dateRange = $('#daterange').val();
        const productStatus = $('#product-status').val();

        if (categoryId || search || dateRange || productStatus) {
            $('#reset-button').show();
        } else {
            $('#reset-button').hide();
        }

        fetchProducts(categoryId, search, 1, dateRange, productStatus);
    }

    function fetchProducts(categoryId = '', search = '', page = 1, dateRange = '', productStatus = '') {
        $('#loader').show();
        $.ajax({
            url: "{{ route('product.index') }}",
            type: "GET",
            data: { 
               category_id: categoryId, 
               search: search, 
               page: page, 
               date_range: dateRange, 
               product_status: productStatus 
            },
            success: function(data) {
                $('#product-list-container').html(data);
                $('#loader').hide();
                bindCheckboxEventHandlers();
                singleDeleteProduct();
            },
            error: function() {
                alert("An error occurred while filtering products.");
                $('#loader').hide();
            }
        });
    }

    function bindCheckboxEventHandlers() {
        $('.select-all-checkbox').on('click', function() {
            const checkboxes = $('.product-checkbox');
            checkboxes.prop('checked', this.checked);
            toggleRowHighlight(checkboxes);
            toggleDeleteButton();
        });

        $('.product-checkbox').off('change').on('change', function() {
            toggleRowHighlight(this);
            toggleDeleteButton();
        });

        $('#bulk-delete-btn').off('click').on('click', function() {
            const selectedIds = $('.product-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length > 0) {
                const deleteButton = $(this);
                deleteButton.prop('disabled', true);
                deleteButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

                Swal.fire({
                    title: 'Are you sure you want to delete these products?',
                    text: "If you delete these, they will be gone forever.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete them!",
                    cancelButtonText: "Cancel",
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('product.bulkDelete') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ product_ids: selectedIds })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Deleted!", "The selected products have been deleted.", "success")
                                    .then(() => fetchProducts($('#category-filter').val(), $('#product-search').val(), 1, $('#daterange').val(), $('#product-status').val()));
                            } else {
                                Swal.fire("Error!", "There was an error deleting the products.", "error");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire("Error!", "Something went wrong.", "error");
                        })
                        .finally(() => {
                            deleteButton.prop('disabled', false);
                            deleteButton.html('Delete Selected');
                        });
                    } else {
                        deleteButton.prop('disabled', false);
                        deleteButton.html('Delete Selected');
                    }
                });
            } else {
                Swal.fire("No products selected", "Please select products to delete.", "info");
            }
        });
    }

    function toggleRowHighlight(checkbox) {
        const row = $(checkbox).closest('.product-row');
        row.toggleClass('highlighted', $(checkbox).prop('checked'));
    }

    function toggleDeleteButton() {
        const selectedCheckboxes = $('.product-checkbox:checked');
        $('#bulk-delete-btn').toggle(selectedCheckboxes.length > 0);
    }

    function singleDeleteProduct() {
        $('.show_confirm').click(function(event) {
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
    }
    fetchProducts();
});

</script> -->

@endpush