<x-guest-layout>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center justify-content-center auth login-bg">
                    <div class="card shadow-lg col-lg-5 mx-auto border-0">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-center mb-4 text-primary fw-bold">Reset Your Password</h3>
                            <p class="text-center mb-4 text-muted">Enter your email address to receive a password reset link</p>

                            <!-- Session Status -->
                            @if(session('status'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf

                                <!-- Email Address -->
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label text-primary">Email *</label>
                                    <input type="email" id="email" name="email" class="form-control p_input @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}" required autofocus placeholder="Enter your registered email">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block py-2 fw-bold">Send Reset Link</button>
                                </div>
                            </form>

                            <!-- Login Link -->
                            <p class="text-center mt-4 text-muted">Remember your password? 
                                <a href="{{ route('login') }}" class="text-primary fw-bold">Log In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Roboto', sans-serif;
        }
        .login-bg {
            background: linear-gradient(to right, #4e73df, #1cc88a);
        }
        .card {
            border-radius: 10px;
        }
        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #3759c6;
            border-color: #3759c6;
        }
        .text-primary {
            color: #4e73df !important;
        }
    </style>
</x-guest-layout>
