<!DOCTYPE html>
<html lang="en" class="h-100">
   <head>
      <!-- Title Meta -->
      <meta charset="utf-8" />
      <title>Reset Password</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="A fully responsive premium admin dashboard template" />
      <meta name="author" content="Techzaa" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="{{asset('backend/assets/fav-icon.png')}}">
      <!-- Vendor css (Require in all Page) -->
      <link href="{{asset('backend/assets/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />
      <!-- Icons css (Require in all Page) -->
      <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
      <!-- App css (Require in all Page) -->
      <link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
      <!-- Theme Config js (Require in all Page) -->
      <script src="{{asset('backend/assets/js/config.js')}}"></script>
   </head>
   <body class="h-100">
      <div class="d-flex flex-column h-100 p-3">
         <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">
               <div class="col-xxl-12">
                  <div class="row justify-content-center h-100">
                    <div class="col-lg-4">
                        <div class="py-lg-2"  style="padding: 30px;border-radius: 10px; box-shadow:0px 0px 10px 0px rgb(0 0 0 / 6%);">
                            @if($errors->any())
                                <br>
                                <div class="alert alert-danger">
                                    <p><strong>Opps Something went wrong</strong></p>
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <br>
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            @if(session()->has('success'))
                                <br>
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-2">
                                    <a href="{{route('login')}}" class="logo-dark">
                                    <img src="{{asset('backend/assets/logo.png')}}" height="100" alt="logo dark">
                                    </a>
                                    <a href="{{route('login')}}" class="logo-light">
                                    <img src="{{asset('backend/assets/logo.png')}}" height="100" alt="logo light">
                                    </a>
                                </div>
                           
                            <div class="mb-5">
                                <form action="{{ route('reset.password.post') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="col-lg-12 mb-2">
                                        <label class="form-label" for="email">Enter Registered Email'id</label>
                                        <input type="email" id="email" name="email" class="form-control bg-">
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label class="form-label" for="password">Enter Password</label>
                                        <input type="password" id="password" name="password" class="form-control bg-">
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label class="form-label" for="password_confirmation">Enter Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control bg-" >
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <a href="{{route('login')}}" class="float-end text-muted text-unline-dashed mb-3">Go to Login</a>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-3 text-center d-grid">
                                        <button class="btn btn-soft-primary" type="submit">Reset</button>
                                    </div>
                                </form>
                                <!--<p class="mt-3 fw-semibold no-span">OR sign with</p>
                                <div class="d-grid gap-2">
                                    <a href="javascript:void(0);" class="btn btn-soft-dark"><i class="bx bxl-google fs-20 me-1"></i> Sign in with Google</a>
                                    <a href="javascript:void(0);" class="btn btn-soft-primary"><i class="bx bxl-facebook fs-20 me-1"></i> Sign in with Facebook</a>
                                </div>-->
                            </div>
                            <!--<p class="text-danger text-center">Don't have an account? <a href="auth-signup.html" class="text-dark fw-bold ms-1">Sign Up</a></p>-->
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- <div class="col-xxl-5 d-none d-xxl-flex">
                  <div class="card h-100 mb-0 overflow-hidden">
                     <div class="d-flex flex-column h-100">
                        <img src="{{asset('backend/assets/images/small/img-10.jpg')}}" alt="" class="w-100 h-100">
                     </div>
                  </div>
               </div> -->
            </div>
         </div>
      </div>
      <!-- Vendor Javascript (Require in all Page) -->
      <script src="{{asset('backend/assets/js/vendor.js')}}"></script>
      <!-- App Javascript (Require in all Page) -->
      <script src="{{asset('backend/assets/js/app.js')}}"></script>
   </body>
</html>