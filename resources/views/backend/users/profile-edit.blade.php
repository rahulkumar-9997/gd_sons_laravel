@extends('backend.layouts.master')
@section('title','User Details Edit')
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
                            <img id="profileImagePreview" src="{{ asset('profile-images/'.Auth::user()->profile_img) }}" alt="" class="avatar-xl border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        @else
                            <img id="profileImagePreview" src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-xl border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        @endif
                    </div>

                    <div class="mt-5">
                        <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h4 class="mb-2">{{ auth()->user()->name ?? '' }} <i class="bx bxs-badge-check text-success align-middle"></i></h4>
                            <!-- Profile Image Upload -->
                            <div class="mb-2">
                                <label for="profile_img" class="form-label">Change Profile Image</label>
                                <input type="file" name="profile_img" class="form-control" id="profile_img" accept="image/*" onchange="previewProfileImage(event)">
                            </div>
                            <!-- Other Profile Details -->
                            <table class="table table-sm">
                                <!-- User Role -->
                                <tr>
                                    <th>User Role</th>
                                    <td><input type="text" name="role" class="form-control" value="{{ Auth::user()->role }}" readonly></td>
                                </tr>
                                <!-- Last Login -->
                                @php
                                    $lastLoginAt = optional(Auth::user()->logins->last())->last_login_at;
                                @endphp
                                <tr>
                                    <th>Last Login</th>
                                    <td><input type="text" class="form-control" value="{{ $lastLoginAt ? \Carbon\Carbon::parse($lastLoginAt)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') : 'No login data' }}" readonly></td>
                                </tr>
                                <!-- Name -->
                                <tr>
                                    <th>Name</th>
                                    <td><input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}"></td>
                                </tr>
                                <!-- Email -->
                                <tr>
                                    <th>Email</th>
                                    <td><input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}"></td>
                                </tr>
                                <!-- Phone Number -->
                                <tr>
                                    <th>Phone Number</th>
                                    <td>
                                        <input type="text" name="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10">
                                    </td>
                                </tr>
                                <!-- Gender -->
                                <tr>
                                    <th>Gender</th>
                                    <td>
                                        <select name="gender" class="form-select">
                                            <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ Auth::user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </td>
                                </tr>
                                <!-- Address -->
                                <tr>
                                    <th>Address</th>
                                    <td><input type="text" name="address" class="form-control" value="{{ Auth::user()->address }}"></td>
                                </tr>
                                <!-- Status -->
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <select name="status" class="form-select">
                                            <option value="1" {{ Auth::user()->status == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ Auth::user()->status == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <div class="d-flex justify-content-end align-items-center gap-1">
                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                            </div>
                        </form>
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
<script>
    function previewProfileImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profileImagePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush