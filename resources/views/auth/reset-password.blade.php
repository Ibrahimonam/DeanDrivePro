<x-guest-layout>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center justify-content-center auth login-bg">
                    <div class="card shadow-lg col-lg-5 mx-auto border-0">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-center mb-4 text-primary fw-bold">Reset Your Password</h3>
                            <p class="text-center mb-4 text-muted">Please enter your new password below to reset it.</p>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email Address -->
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label text-primary">Email Address *</label>
                                    <input type="email" id="email" name="email" class="form-control p_input @error('email') is-invalid @enderror" 
                                    value="{{ old('email', $request->email) }}" required autofocus placeholder="Enter your email address">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label text-primary">New Password *</label>
                                    <input type="password" id="password" name="password" class="form-control p_input @error('password') is-invalid @enderror" 
                                    required placeholder="Enter your new password">
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="form-label text-primary">Confirm Password *</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control p_input @error('password_confirmation') is-invalid @enderror" 
                                    required placeholder="Confirm your new password">
                                    @error('password_confirmation')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block py-2 fw-bold">Reset Password</button>
                                </div>
                            </form>

                            <!-- Login Link -->
                            <p class="text-center mt-4 text-muted">Remembered your password? 
                                <a href="{{ route('login') }}" class="text-primary fw-bold">Login</a>
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
