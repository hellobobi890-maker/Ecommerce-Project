<x-guest-layout>
    <div class="auth-header">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 14px; background: var(--gradient-primary);">
                <i class="bi bi-bag" style="color: #fff; font-size: 1.2rem;"></i>
            </div>
            <div style="font-weight: 800; font-size: 1.05rem;">{{ config('app.name', 'Zavro') }}</div>
        </div>
        <h2>Welcome Back</h2>
        <p>Please login to your account</p>
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
        <div class="form-group">
            <label class="form-label-custom">Email Address</label>
            <div class="input-wrapper">
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" placeholder="Email address" required
                    autofocus autocomplete="username">
                <i class="bi bi-envelope input-icon"></i>
            </div>
            @error('email')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label class="form-label-custom">Password</label>
            <div class="input-wrapper">
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                    autocomplete="current-password">
                <i class="bi bi-lock input-icon"></i>
                <button type="button" class="btn p-0 position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword"
                    aria-label="Toggle password visibility" style="border: none; background: transparent; color: rgba(17, 24, 39, 0.45);">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
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
            Login
        </button>
    </form>

    <div class="auth-divider">
        <span>Or Login with</span>
    </div>

    <div class="social-btns">
        <button type="button" class="btn-social google" title="Google">
            <i class="bi bi-google"></i>
            Google
        </button>
        <button type="button" class="btn-social facebook" title="Facebook">
            <i class="bi bi-facebook"></i>
            Facebook
        </button>
    </div>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Signup</a>
    </div>

    <script>
        (() => {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            if (!toggleBtn || !passwordInput) return;

            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                const icon = toggleBtn.querySelector('i');
                if (icon) icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        })();
    </script>
</x-guest-layout>
