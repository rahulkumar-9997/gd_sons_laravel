@extends('backend.layouts.master')
@section('title','Create User')
@section('main-content')
{{--@dd(Auth::check());--}}

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
                     <strong>Add User</strong>
                  </li>
               </ol>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-lg-12">
         <section class="box ">
            <header class="panel_header">
               <h2 class="title pull-left">Add User</h2>
               <div class="actions panel_actions pull-right">
                  <i class="box_toggle fa fa-chevron-down"></i>
                  <i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
                  <i class="box_close fa fa-times"></i>
               </div>
            </header>
            <div class="content-body">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                           @csrf
                        <div class="form-group">
                           <label class="form-label" for="field-1">Name</label>
                           <div class="controls">
                              <input type="text" class="form-control" name="name" >
                           </div>
                           @if($errors->has('name'))
                              <div class="text-danger">{{ $errors->first('name') }}</div>
                           @endif
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="field-1">Email</label>
                           <div class="controls">
                              <input type="email" class="form-control" name="email" >
                           </div>
                           @if($errors->has('email'))
                              <div class="text-danger">{{ $errors->first('email') }}</div>
                           @endif
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="field-1">Phone Number</label>
                           <div class="controls">
                              <input type="text" class="form-control" name="phone_number" >
                           </div>
                           @if($errors->has('phone_number'))
                              <div class="text-danger">{{ $errors->first('phone_number') }}</div>
                           @endif
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="field-1">Password</label>
                           <div class="controls">
                              <input type="password" class="form-control" name="password" >
                           </div>
                           @if($errors->has('password'))
                              <div class="text-danger">{{ $errors->first('password') }}</div>
                           @endif
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="field-1">Confirm Password</label>
                           <div class="controls">
                              <input type="password" class="form-control" name="password_confirmation" >
                           </div>
                           @if($errors->has('password_confirmation'))
                              <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
                           @endif
                        </div>
                        <div class="form-group">
                           <div class="controls">
                              <button type="submit" class="btn btn-primary">Submit</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </section>
</section>
@endsection
