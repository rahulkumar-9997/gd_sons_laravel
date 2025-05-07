@extends('backend.layouts.master')
@section('title','Databases')
@section('main-content')
@push('styles')

@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                <h4 class="card-title flex-grow-1">All Table List ( Select Tables to Truncate)</h4>
                <a href="{{ route('backup.database') }}" 
                    class="btn btn-sm btn-primary" 
                    data-bs-toggle="tooltip" 
                    title="Backup Database">
                    Backup Database
                </a>
               
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('truncate.tables') }}">
                    @csrf
                    <table class="table table">
                        <thead>
                            <tr>
                                <th>Select <BR><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                <th>Table Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tableNames as $table)
                                <tr>
                                    <td>
                                        @if(in_array($table, ['users', 'migrations', 'menu_permission', 'menu_role', 'menus', 'model_has_permissions', 'model_has_roles', 'permissions', 'role_has_permissions', 'roles', 'order_status']))
                                            <input class="form-check-input" type="checkbox" disabled>
                                        @else
                                            <input type="checkbox" class="form-check-input table-checkbox" name="tables[]" value="{{ $table }}">
                                        @endif
                                    
                                    </td>
                                    <td>{{ $table }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" data-name="Truncate Selected Tables" class="btn btn-primary btn-sm show_confirm">Truncate Selected Tables</button>
                    </div>
                </form>
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

<script>
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.table-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
   $(document).ready(function() {
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
           
   });
</script>
@endpush