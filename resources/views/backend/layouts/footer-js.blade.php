<!-- Vendor Javascript (Require in all Page) -->
<script src="{{asset('backend/assets/js/vendor.js')}}"></script>
<!-- App Javascript (Require in all Page) -->
<script src="{{asset('backend/assets/js/app.js')}}"></script>
<!---RAHUL SCRIPT ADD-->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{asset('backend/assets/vendor/datatables/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/js/datatable.js')}}" type="text/javascript"></script>

<!---RAHUL SCRIPT ADD-->
@if(session()->has('success'))
<script>
    Toastify({
        text: '{{ session('success') }}',
        duration: 4000,
        gravity: "top",
        position: "right", 
        className: "bg-success",
        close: true
    }).showToast();
</script>
@endif

@if(session()->has('error'))
<script>
    Toastify({
        text: '{{ session('error') }}',
        duration: 4000,
        gravity: "top",
        position: "right", 
        className: "bg-danger",
        close: true
    }).showToast();
</script>
@endif

@if($errors->any())
<script>
    @foreach ($errors->all() as $error)
        Toastify({
            text: '{{ $error }}',
            duration: 4000,
            gravity: "top",
            position: "right", 
            className: "bg-danger",
            close: true
        }).showToast();
    @endforeach
</script>
@endif


