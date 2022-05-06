@extends('master.authentication')

@section('title', 'Login')

@section('content')
<main class="authentication-content">
    <div class="container-fluid">
        <div class="authentication-card">
            <div class="rounded-0 overflow-hidden">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6 ">
                        <div class="card shadow bg-white px-3 pt-1 pb-5">
                            <form class="card-body g-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="login-separater text-center mb-4"> <span>SIGN IN WITH EMAIL</span>
                                    <hr>
                                </div>
                                <div class="row g-3">

                                    <div class="col-12">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <input type="email" name="email" placeholder="Email"
                                                class="form-control radius-30 ps-5 @error('email') is-invalid @enderror"
                                                id="email" value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="inputChoosePassword" class="form-label">Enter Password</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                    class="bi bi-lock-fill"></i></div>

                                            <input type="password" placeholder="Password"
                                                class="form-control radius-30 ps-5 @error('password') is-invalid @enderror"
                                                id="password" name="password" required>

                                            @error('password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    @if (route('password.request'))
                                    <div class="col-6 text-end">
                                        <a href="{{ route('password.request') }}">
                                            Forgot Password?
                                        </a>
                                    </div>
                                    @endif

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary radius-30">Sign In</button>
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
