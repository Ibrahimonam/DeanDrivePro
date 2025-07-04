<x-guest-layout>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center justify-content-center auth login-bg">
                    <div class="card shadow-lg col-lg-5 mx-auto border-0">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-center mb-4 text-primary fw-bold">Welcome Back</h3>
                            <p class="text-center mb-4 text-muted">Login to access your account</p>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <!-- Email/Username Input -->
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label text-primary">Username or Email *</label>
                                    <input type="text" id="email" name="email" class="form-control text-primary p_input @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}" required autofocus placeholder="Enter your email address">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label text-primary">Password *</label>
                                    <input type="password" id="password" name="password" class="form-control text-primary p_input @error('password') is-invalid @enderror" 
                                    required placeholder="Enter your password">
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remember Me & Forgot Password -->
                                <div class="form-group d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label for="remember" class="form-check-label text-primary">Remember me</label>
                                    </div>
                                    <a href="/forgot-password" class="text-primary text-decoration-none">Forgot password?</a>
                                </div>

                                <!-- Login Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block py-2 fw-bold">Login</button>
                                </div>
                            </form>

                            <!-- Register Link -->
                            <p class="text-center mt-4 text-muted">Don't have an account? 
                                <a href="{{ route('register') }}" class="text-primary fw-bold">Register</a>
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
