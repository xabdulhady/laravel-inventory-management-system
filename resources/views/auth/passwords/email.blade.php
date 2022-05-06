@extends('master.authentication')

@section('title', 'Reset Password')

@section('content')


<main class="authentication-content">
    <div class="container-fluid">
        <div class="authentication-card">
            <div class="card shadow rounded-0 overflow-hidden">
                <div class="row g-0">

                    <div class="col-lg-12">
                        <div class="card-body p-5">

                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            <h5 class="card-title text-center">Forgot Password?</h5>
                            <p class="card-text text-center ">Enter your registered email ID to reset the password</p>

                            <form method="POST" action="{{ route('password.email') }}" class="form-body">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        {{-- <label for="inputEmailid" class="form-label">Email id</label> --}}
                                        <input type="email"
                                            class="form-control radius-30 @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" required
                                            placeholder="Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid gap-3">
                                            <button type="submit" class="btn btn btn-primary radius-30">Send</button>
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
