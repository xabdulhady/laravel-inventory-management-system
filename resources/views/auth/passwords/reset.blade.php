@extends('master.authentication')

@section('title', 'Update Password')

@section('content')
<main class="authentication-content">
    <div class="container-fluid">
        <div class="authentication-card">
            <div class="rounded-0 overflow-hidden">
                <div class="shadow rounded-0 overflow-hidden">
                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card shadow bg-white px-3 pt-4 pb-3">

                                <h5 class="card-title text-center">Forgot Password?</h5>
                                <p class="card-text text-center ">Enter your registered email ID to reset the password
                                </p>

                                <form method="POST" action="{{ route('password.update') }}" class="card-body">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    @csrf
                                    <div class="row g-3">

                                        <div class="col-12">
                                            <label for="Email" class="form-label">Email</label>
                                            <div class="ms-auto position-relative">
                                                <div
                                                    class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                    <i class="bi bi-envelope-fill"></i>
                                                </div>
                                                <input type="email"
                                                    class="form-control radius-30 ps-5 @error('email') is-invalid @enderror"
                                                    name="email" value="{{ $email}}" required placeholder="Email">
                                            </div>

                                            @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">New Password</label>
                                            <div class="ms-auto position-relative">
                                                <div
                                                    class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                    <i class="bi bi-lock-fill"></i>
                                                </div>
                                                <input type="password" name="password"
                                                    class="form-control radius-30 ps-5  @error('password') is-invalid @enderror"
                                                    id="password" placeholder="Enter New Password" required>
                                            </div>
                                            @error('password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="col-12">
                                            <label for="password-confirm" class="form-label">Confirm Password</label>
                                            <div class="ms-auto position-relative">
                                                <div
                                                    class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                    <i class="bi bi-lock-fill"></i>
                                                </div>
                                                <input type="password"
                                                    class="form-control radius-30 ps-5 @error('password-confirm') is-invalid @enderror"
                                                    name="password_confirmation" id="password-confirm"
                                                    placeholder="Enter Confirm Password">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid gap-3">
                                                <button type="submit" class="btn btn btn-primary radius-30">Update
                                                    Password</button>
                                                @if (route('login'))
                                                <a href="{{ route('login') }}" class="btn btn btn-light radius-30">Back
                                                    to Login</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

@endsection
