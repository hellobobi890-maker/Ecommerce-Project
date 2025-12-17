<x-guest-layout>
    <div class="auth-header">
        <h2><i class="bi bi-box-arrow-in-right me-2"></i>Welcome Back!</h2>
        <p>Sign in to continue shopping</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert-glass">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-floating-custom">
            <i class="bi bi-envelope input-icon"></i>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" required
                autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating-custom">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required
                autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="auth-options">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <div class="auth-divider">
        <span>or continue with</span>
    </div>

    <div class="social-btns">
        <button type="button" class="btn-social" title="Google">
            <i class="bi bi-google"></i>
        </button>
        <button type="button" class="btn-social" title="Facebook">
            <i class="bi bi-facebook"></i>
        </button>
        <button type="button" class="btn-social" title="Apple">
            <i class="bi bi-apple"></i>
        </button>
    </div>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Create Account</a>
    </div>
</x-guest-layout>
