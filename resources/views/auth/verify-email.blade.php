<x-guest-layout>
    <h4 class="text-center fw-bold mb-4">{{ __('Verify Email') }}</h4>

    <div class="alert alert-info mb-4">
        <i class="bi bi-envelope-check me-2"></i>
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-2"></i>{{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
