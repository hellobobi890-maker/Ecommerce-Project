@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2 class="font-weight-bold text-dark mb-0">{{ __('Profile') }}</h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-lg-8">
                <!-- Update Profile Information -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
