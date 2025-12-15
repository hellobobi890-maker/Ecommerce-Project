<x-guest-layout>
    <h4 class="text-center fw-bold mb-4">{{ __('Confirm Password') }}</h4>

    <p class="text-center text-muted mb-4">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
            <i class="bi bi-shield-check me-2"></i>{{ __('Confirm') }}
        </button>
    </form>
</x-guest-layout>
