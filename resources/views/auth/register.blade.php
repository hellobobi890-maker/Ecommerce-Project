<x-guest-layout>
    <div class="auth-header">
        <h2><i class="bi bi-person-plus me-2"></i>Create Account</h2>
        <p>Join us and start shopping!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-floating-custom">
            <i class="bi bi-person input-icon"></i>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror" placeholder="Enter your full name" required
                autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-floating-custom">
            <i class="bi bi-envelope input-icon"></i>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" required
                autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating-custom">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Create a password" required
                autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-floating-custom">
            <i class="bi bi-shield-lock input-icon"></i>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="Confirm your password" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-person-plus me-2"></i>Create Account
        </button>
    </form>

    <div class="auth-divider">
        <span>or sign up with</span>
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
        Already have an account? <a href="{{ route('login') }}">Sign In</a>
    </div>
</x-guest-layout>
