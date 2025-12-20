<x-guest-layout>
    <div class="auth-header">
        <div class="icon-wrap">
            <i class="bi bi-person-plus"></i>
        </div>
        <h2>Create Account</h2>
        <p>Join us and start shopping!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label class="form-label-custom">Full Name</label>
            <div class="input-wrapper">
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter your full name" required
                    autofocus autocomplete="name">
                <i class="bi bi-person input-icon"></i>
            </div>
            @error('name')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label class="form-label-custom">Email Address</label>
            <div class="input-wrapper">
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" required
                    autocomplete="username">
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
                    class="form-control @error('password') is-invalid @enderror" placeholder="Create a password" required
                    autocomplete="new-password">
                <i class="bi bi-lock input-icon"></i>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label class="form-label-custom">Confirm Password</label>
            <div class="input-wrapper">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                    placeholder="Confirm your password" required autocomplete="new-password">
                <i class="bi bi-shield-lock input-icon"></i>
            </div>
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-person-plus"></i>
            Create Account
        </button>
    </form>

    <div class="auth-divider">
        <span>or sign up with</span>
    </div>

    <div class="social-btns">
        <button type="button" class="btn-social google" title="Google">
            <i class="bi bi-google"></i>
        </button>
        <button type="button" class="btn-social facebook" title="Facebook">
            <i class="bi bi-facebook"></i>
        </button>
        <button type="button" class="btn-social apple" title="Apple">
            <i class="bi bi-apple"></i>
        </button>
    </div>

    <div class="auth-footer">
        Already have an account? <a href="{{ route('login') }}">Sign In</a>
    </div>
</x-guest-layout>
