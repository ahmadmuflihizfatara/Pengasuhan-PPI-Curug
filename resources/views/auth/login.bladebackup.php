<x-guest-layout>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header mb-5">
            <h1 class="login-title">
                <i class="fas fa-sign-in-alt me-2"></i>Welcome Back
            </h1>
            <p class="login-subtitle">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="form-label fw-600">
                    <i class="fas fa-envelope me-2"></i>Email Address
                </label>
                <div class="input-group">
                    <span class="input-group-text glass-input-icon">
                        <i class="fas fa-at"></i>
                    </span>
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control glass-input @error('email') is-invalid @enderror"
                        name="email" 
                        placeholder="name@example.com" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                    />
                </div>
                @error('email')
                    <div class="invalid-feedback d-block mt-2">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="form-label fw-600">
                    <i class="fas fa-lock me-2"></i>Password
                </label>
                <div class="input-group">
                    <span class="input-group-text glass-input-icon">
                        <i class="fas fa-key"></i>
                    </span>
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control glass-input @error('password') is-invalid @enderror"
                        name="password" 
                        placeholder="••••••••" 
                        required 
                        autocomplete="current-password"
                    />
                </div>
                @error('password')
                    <div class="invalid-feedback d-block mt-2">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        {{ old('remember') ? 'checked' : '' }}
                    />
                    <label class="form-check-label fw-500" for="remember">
                        Remember me
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-white fw-500 text-decoration-none forgot-pwd-link">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-primary w-100 py-2 fw-600 mb-3">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>

            <!-- Divider -->
            <div class="divider small-text text-center mb-4">
                or
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="small-text mb-0">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-white fw-600 register-link">
                        Create One
                    </a>
                </p>
            </div>
        </form>
    </div>

    <style>
        .login-container {
            width: 100%;
        }

        .login-header {
            text-align: center;
            padding-bottom: 20px;
        }

        .login-title {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .login-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            margin: 0;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.95);
            font-size: 14px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .glass-input-icon {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-right: none;
            color: rgba(255, 255, 255, 0.7);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #ffffff !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.25) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            color: #ffffff !important;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2) !important;
        }

        .glass-input.is-invalid {
            border-color: #ff6b6b !important;
            background: rgba(255, 107, 107, 0.1) !important;
        }

        .glass-input.is-invalid:focus {
            box-shadow: 0 0 15px rgba(255, 107, 107, 0.3) !important;
        }

        .invalid-feedback {
            color: #ff6b6b;
            font-size: 13px;
            font-weight: 500;
        }

        .form-check {
            display: flex;
            align-items: center;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
            user-select: none;
            font-size: 14px;
            margin-left: 8px;
            margin-bottom: 0;
        }

        .forgot-pwd-link {
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .forgot-pwd-link:hover {
            color: #e0e0e0 !important;
            text-decoration: underline !important;
        }

        .register-link {
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .register-link:hover {
            color: #e0e0e0 !important;
        }

        .fw-500 {
            font-weight: 500;
        }

        .fw-600 {
            font-weight: 600;
        }

        .input-group-text {
            background: transparent;
            border: none;
        }

        @media (max-width: 576px) {
            .login-title {
                font-size: 24px;
            }

            .login-subtitle {
                font-size: 13px;
            }

            .form-label {
                font-size: 13px;
            }
        }
    </style>
</x-guest-layout>
