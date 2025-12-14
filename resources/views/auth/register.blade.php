<x-guest-layout>
    <h4 class="text-center fw-bold mb-4">Create Account</h4>
    <p class="text-center text-muted mb-4">Join us today!</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" 
                   class="form-control @error('name') is-invalid @enderror" 
                   required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" 
                   class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
            <i class="bi bi-person-plus me-2"></i>Register
        </button>
    </form>

    <div class="text-center mt-4">
        <span class="text-muted">Already have an account?</span>
        <a href="{{ route('login') }}" class="text-decoration-none fw-bold ms-1">Log In</a>
    </div>
</x-guest-layout>
