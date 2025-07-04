<x-guest-layout>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center justify-content-center auth login-bg">
                    <div class="card shadow-lg col-lg-5 mx-auto border-0">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-center mb-4 text-primary fw-bold">Create an Account</h3>
                            <p class="text-center mb-4 text-muted">Fill in the details below to get started</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Username -->
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label text-primary">Username *</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="form-control p_input text-primary @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}"
                                        required
                                        autofocus
                                        placeholder="Enter your username"
                                    >
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label text-primary">Email *</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control p_input text-primary @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        required
                                        placeholder="Enter your email"
                                    >
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label text-primary">Password *</label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control p_input text-primary @error('password') is-invalid @enderror"
                                        required
                                        placeholder="Create a password"
                                    >
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="form-label text-primary">Confirm Password *</label>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="form-control p_input text-primary @error('password_confirmation') is-invalid @enderror"
                                        required
                                        placeholder="Re-enter your password"
                                    >
                                    @error('password_confirmation')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Role Selector -->
                                <div class="form-group mb-4">
                                    <label for="role_id" class="form-label text-primary">Role *</label>
                                    <select
                                        id="role_id"
                                        name="role_id"
                                        class="form-control p_input text-primary @error('role_id') is-invalid @enderror"
                                        required
                                    >
                                        <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Select your role</option>
                                        @foreach($roles as $role)
                                            @continue($role->id === 1)
                                            <option
                                                value="{{ $role->id }}"
                                                {{ old('role_id') == $role->id ? 'selected' : '' }}
                                            >
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Zone Selector -->
                                <div class="form-group mb-4">
                                    <label for="zone_id" class="form-label text-primary">Zone *</label>
                                    <select
                                        id="zone_id"
                                        name="zone_id"
                                        class="form-control p_input text-primary @error('zone_id') is-invalid @enderror"
                                        required
                                    >
                                        <option value="" disabled {{ old('zone_id') ? '' : 'selected' }}>Select your zone</option>
                                        @foreach($zones as $zone)
                                            <option
                                                value="{{ $zone->id }}"
                                                {{ old('zone_id') == $zone->id ? 'selected' : '' }}
                                            >
                                                {{ ucfirst($zone->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('zone_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Branch Selector -->
                                <div class="form-group mb-4">
                                    <label for="branch_id" class="form-label text-primary">Branch *</label>
                                    <select
                                        id="branch_id"
                                        name="branch_id"
                                        class="form-control p_input text-primary @error('branch_id') is-invalid @enderror"
                                        required
                                    >
                                        <option value="" disabled {{ old('branch_id') ? '' : 'selected' }}>Select your branch</option>
                                        @foreach($branches as $branch)
                                            <option
                                                value="{{ $branch->id }}"
                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                            >
                                                {{ ucfirst($branch->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remember Me & Forgot -->
                                <div class="form-group d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label text-primary" for="remember">Remember me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">Forgot password?</a>
                                </div>

                                <!-- Register Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block py-2 fw-bold">Register</button>
                                </div>
                            </form>

                            <!-- Login Link -->
                            <p class="text-center mt-4 text-muted">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-primary fw-bold">Log In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
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
