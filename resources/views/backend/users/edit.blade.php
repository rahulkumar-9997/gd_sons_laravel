@extends('backend.layouts.master')
@section('title','Update User')
@section('main-content')
@section('morecss')
<link href="{{asset('backend/assets/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
   <link href="{{asset('backend/assets/plugins/typeahead/css/typeahead.css')}}" rel="stylesheet" type="text/css" media="screen"/>
   <link href="{{asset('backend/assets/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" media="screen"/> 



@endsection

<section id="main-content" class=" ">
   <section class="wrapper main-wrapper" style=''>
      <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
         <div class="page-title">
            
            <div class="pull-right hidden-xs">
               <ol class="breadcrumb">
                  <li>
                     <a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Home</a>
                  </li>
                  <li>
                     <a href="{{ route('users') }}"><i class="fa fa-home"></i>User</a>
                  </li>
                  
                  <li class="active">
                     <strong>Update User</strong>
                  </li>
               </ol>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-lg-12">
         <section class="box ">
            <header class="panel_header">
               <h2 class="title pull-left">Update User</h2>
               <div class="actions panel_actions pull-right">
                  <i class="box_toggle fa fa-chevron-down"></i>
                  <i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
                  <i class="box_close fa fa-times"></i>
               </div>
            </header>
            <div class="content-body">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <form method="post" action="{{ route('users.update', $user->id) }}">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ $user->name }}" 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                placeholder="Name" required>

                            @if ($errors->has('name'))
                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input value="{{ $user->email }}"
                                type="email" 
                                class="form-control" 
                                name="email" 
                                placeholder="Email address" readonly required>
                                @if ($errors->has('email'))
                                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="field-1">Phone Number</label>
                           <div class="controls">
                              <input value="{{ $user->phone_number }}" type="text" class="form-control" name="phone_number" >
                           </div>
                           @if($errors->has('phone_number'))
                              <div class="text-danger">{{ $errors->first('phone_number') }}</div>
                           @endif
                        </div>
                        <!--<div class="form-group">
                           <label class="form-label">Select Multiple Role</label>
                           <select class="" id="s2example-2" multiple name="role">
                              <option value="">Select role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ in_array($role->name, $userRole) 
                                            ? 'selected'
                                            : '' }}>{{ $role->name }}</option>
                                @endforeach
                           </select>
                           @if ($errors->has('role'))
                                <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                            @endif
                        </div>-->
                        <div class="form-group">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" 
                                name="role" required>
                                <option value="">Select role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ in_array($role->name, $userRole) 
                                            ? 'selected'
                                            : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                           
                        </div>

                        <button type="submit" class="btn btn-primary">Update user</button>
                        <a href="{{ route('users') }}" class="btn btn-default">Cancel</a>
                    </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </section>
</section>
@endsection
@section('morescripts')
<script src="{{asset('backend/assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/typeahead/typeahead.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/typeahead/handlebars.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/plugins/multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>


@endsection

