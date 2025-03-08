@extends('backend.layouts.master')
@section('title','User Details')
@section('main-content')
@push('styles')
 
@endpush
<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-xl-9 col-lg-8">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="bg-primary profile-bg rounded-top position-relative mx-n3 mt-n3">
                        @if(Auth::user()->profile_img)
                            <img src="{{ asset('profile-images/'.Auth::user()->profile_img) }}" alt="" class="avatar-xl border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        @else
                            <img src="{{asset('backend/assets/images/users/avatar-1.jpg')}}" alt="" class="avatar-xl border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        @endif
                    </div>
                    <div class="mt-5">
                        <div>
                            <h4 class="mb-1">{{ auth()->user()->name ?? '' }}
                                 <i class="bx bxs-badge-check text-success align-middle"></i>
                            </h4>
                            <table class="table table-sm">
                                <tr>
                                    <th>User Role</th>
                                    <td>{{ Auth::check() ? Auth::user()->role : 'N/A' }}</td>
                                </tr>
                                @php
                                    $lastLoginAt = optional(Auth::user()->logins->last())->last_login_at;
                                @endphp
                                <tr>
                                    <th>Last Login</th>
                                    <td>{{ $lastLoginAt ? \Carbon\Carbon::parse($lastLoginAt)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') : 'No login data' }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ Auth::user()->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ Auth::user()->gender ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ Auth::user()->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if(Auth::user()->status == '1')
                                            <span class="badge bg-success text-light px-2 py-1 fs-13">Active</span>
                                        @else
                                            <span class="badge bg-light text-dark px-2 py-1 fs-13">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end align-items-center gap-1">
                                <a href="{{ route('profile.edit', Auth::user()->id) }}" 
                                    data-title="Edit Profile" 
                                    data-bs-toggle="tooltip" 
                                    title="Edit Profile" 
                                    class="btn btn-sm btn-primary">
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
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

@endpush