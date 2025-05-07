@extends('backend.layouts.master')
@section('title','Make Conversation to Whatsapp')
@section('main-content')
@push('styles')
<link href="{{asset('backend/assets/vendor/datatables/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/vendor/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
               <h4 class="card-title flex-grow-1">Whatsapp Conversation List</h4>

               <a href="javascript:void(0)" data-conversation-popup="true" data-size="lg" data-title=" Create New Conversation to Whatsapp" data-url="{{ route('manage-whatsapp-conversation.create') }}" data-bs-toggle="tooltip" class="btn btn-sm btn-primary" data-bs-original-title="Make Conversation to Whatsapp">
                  Create New Conversation to Whatsapp
               </a>
            </div>
            <div class="card-body conversation-list-whattapp">
               @include('backend.manage-whatsapp.manage-whatsapp-conversation.partials.ajax-conversation-list', ['WhatsappConversation' => $WhatsappConversation])
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
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.quicksearch.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/js/pages/whatsapp-conversation.js')}}" type="text/javascript"></script>

@endpush