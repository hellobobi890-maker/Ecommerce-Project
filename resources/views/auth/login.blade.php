<x-guest-layout>
    <h4 class="text-center fw-bold mb-4">Welcome Back!</h4>
    <p class="text-center text-muted mb-4">Login to your account</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none small">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
            <i class="bi bi-box-arrow-in-right me-2"></i>Log In
        </button>
    </form>

    <div class="text-center mt-4">
        <span class="text-muted">Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-decoration-none fw-bold ms-1">Sign Up</a>
    </div>
</x-guest-layout>
