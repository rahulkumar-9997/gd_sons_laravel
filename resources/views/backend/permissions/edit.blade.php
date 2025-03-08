@extends('backend.layouts.master')
@section('title','Update Permissions')
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
                     <a href="{{ route('permissions.index') }}"><i class="fa fa-home"></i>Permissions</a>
                  </li>
                  
                  <li class="active">
                     <strong>Update Permissions</strong>
                  </li>
               </ol>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-lg-12">
         <section class="box ">
            <header class="panel_header">
               <h2 class="title pull-left">Update Permissions</h2>
               <div class="actions panel_actions pull-right">
                  <i class="box_toggle fa fa-chevron-down"></i>
                  <i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
                  <i class="box_close fa fa-times"></i>
               </div>
            </header>
            <div class="content-body">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <form method="post" action="{{ route('permissions.update', $permission->id) }}">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ $permission->name }}" 
                                 type="text" 
                                 class="form-control" 
                                 name="name" 
                                 placeholder="Name" required>

                           @if ($errors->has('name'))
                                 <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                           @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update Permissions</button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-default">Cancel</a>
                    </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </section>
</section>
@endsection
