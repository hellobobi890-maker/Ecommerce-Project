<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Zavro') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            /* Website Color Scheme */
            --primary-color: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fb923c;
            --accent-pink: #ec4899;
            --accent-purple: #8b5cf6;
            --gradient-primary: linear-gradient(135deg, #f97316 0%, #fb923c 60%, #ffd18c 100%);
            --dark-bg: #0b1220;
            --card-bg: #111827;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-primary: #111827;
            --text-secondary: rgba(17, 24, 39, 0.6);
            --input-bg: #f3f4f6;
            --input-border: rgba(17, 24, 39, 0.12);
        }

        * {
            font-family: 'Outfit', sans-serif !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #eef2f6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-animated {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animated::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(249, 115, 22, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.1) 0%, transparent 40%);
            animation: rotate 40s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Floating Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: var(--primary-color);
            top: -200px;
            right: -150px;
            animation: float1 10s ease-in-out infinite;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: var(--accent-purple);
            bottom: -150px;
            left: -150px;
            animation: float2 12s ease-in-out infinite;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: var(--accent-pink);
            top: 40%;
            left: 20%;
            animation: float3 14s ease-in-out infinite;
        }

        @keyframes float1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-80px, 80px); }
        }

        @keyframes float2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(80px, -80px); }
        }

        @keyframes float3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-50px, 50px); }
        }

        /* Main Container */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.25rem;
            position: relative;
            z-index: 1;
        }

        .auth-shell {
            width: 100%;
            max-width: 1100px;
            background: #ffffff;
            border-radius: 34px;
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            min-height: 640px;
        }

        /* Left Side - Branding */
        .auth-brand-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            background: var(--gradient-primary);
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: left;
            max-width: 520px;
            color: #ffffff;
        }

        .brand-logo {
            width: 0;
            height: 0;
            background: transparent;
            border-radius: 0;
            display: none;
            align-items: center;
            justify-content: center;
            margin: 0;
            box-shadow: none;
            animation: none;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 20px 50px rgba(249, 115, 22, 0.35), 0 0 80px rgba(249, 115, 22, 0.2); }
            50% { box-shadow: 0 20px 70px rgba(249, 115, 22, 0.5), 0 0 100px rgba(249, 115, 22, 0.3); }
        }

        .brand-logo i {
            font-size: 3.5rem;
            color: white;
        }

        .brand-title {
            font-size: 3.1rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 1rem;
            letter-spacing: -1px;
            line-height: 1.15;
        }

        .brand-tagline {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 400;
            line-height: 1.7;
            max-width: 420px;
        }

        .brand-illustration {
            margin-top: 2.25rem;
            position: relative;
            height: 240px;
            width: 100%;
            max-width: 520px;
        }

        .brand-illustration::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.22);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.35);
        }

        .brand-illustration::after {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            right: -80px;
            bottom: -90px;
            filter: blur(0);
        }

        .brand-features {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 400;
            transition: all 0.3s ease;
            padding: 0.875rem 1.25rem;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.26);
            color: white;
            transform: translateX(10px);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .feature-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon i {
            font-size: 1.25rem;
            color: white;
        }

        /* Right Side - Form */
        .auth-form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #ffffff;
        }

        .auth-form-container {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 2;
        }

        /* Card */
        .auth-card {
            background: transparent;
            border: none;
            border-radius: 0;
            padding: 0;
            backdrop-filter: none;
            box-shadow: none;
        }

        .auth-header {
            text-align: left;
            margin-bottom: 1.75rem;
        }

        .auth-header .icon-wrap {
            width: 0;
            height: 0;
            background: transparent;
            border-radius: 0;
            display: none;
            align-items: center;
            justify-content: center;
            margin: 0;
            box-shadow: none;
        }

        .auth-header .icon-wrap i {
            font-size: 2rem;
            color: white;
        }

        .auth-header h2 {
            font-size: 2.05rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.35rem;
            letter-spacing: -0.4px;
        }

        .auth-header p {
            color: rgba(17, 24, 39, 0.55);
            font-size: 0.95rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label-custom {
            display: block;
            color: rgba(17, 24, 39, 0.6);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.75px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(17, 24, 39, 0.35);
            font-size: 1.15rem;
            z-index: 5;
            transition: color 0.3s;
        }

        .form-control {
            background: var(--input-bg);
            border: 2px solid var(--input-border);
            border-radius: 14px;
            padding: 1rem 1rem 1rem 3.5rem;
            height: 58px;
            font-size: 1rem;
            color: #111827;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control::placeholder {
            color: rgba(17, 24, 39, 0.38);
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.16);
            outline: none;
        }

        .form-control:focus ~ .input-icon,
        .input-wrapper:hover .input-icon {
            color: var(--primary-color);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Remember & Forgot */
        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            background: var(--input-bg);
            border: 2px solid var(--input-border);
            border-radius: 6px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background: var(--gradient-primary);
            border: none;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }

        .form-check-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .forgot-link:hover {
            color: var(--primary-light);
        }

        /* Submit Button */
        .btn-auth {
            width: 100%;
            padding: 1.125rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.6s;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 45px rgba(249, 115, 22, 0.32);
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            gap: 1rem;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
        }

        .auth-divider span {
            color: var(--text-secondary);
            font-size: 0.85rem;
            white-space: nowrap;
        }

        /* Social Buttons */
        .social-btns {
            display: flex;
            gap: 1rem;
        }

        .btn-social {
            flex: 1;
            padding: 1rem;
            background: #ffffff;
            border: 2px solid rgba(17, 24, 39, 0.1);
            border-radius: 14px;
            color: rgba(17, 24, 39, 0.9);
            font-size: 0.98rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            font-weight: 600;
        }

        .btn-social:hover {
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
        }

        .btn-social.google:hover { 
            border-color: #ea4335;
            color: #ea4335;
            box-shadow: 0 10px 30px rgba(234, 67, 53, 0.2);
        }
        .btn-social.facebook:hover { 
            border-color: #1877f2;
            color: #1877f2;
            box-shadow: 0 10px 30px rgba(24, 119, 242, 0.2);
        }
        .btn-social.apple:hover { 
            border-color: #111827;
            color: #111827;
            box-shadow: 0 10px 30px rgba(17, 24, 39, 0.12);
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(17, 24, 39, 0.6);
            font-size: 0.95rem;
        }

        .auth-footer a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }

        .auth-footer a:hover {
            color: var(--primary-light);
        }

        /* Alert */
        .alert-glass {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #047857;
            border-radius: 14px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .auth-shell {
                flex-direction: column;
                min-height: auto;
                border-radius: 28px;
            }

            .auth-brand-side {
                padding: 2.25rem 2rem;
            }

            .brand-title {
                font-size: 2.35rem;
            }

            .brand-illustration {
                display: none;
            }

            .auth-form-side {
                padding: 2.25rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .brand-title {
                font-size: 2rem;
            }

            .brand-features {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="bg-animated">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="auth-wrapper">
        <div class="auth-shell">
            <!-- Left Side - Branding -->
            <div class="auth-brand-side d-none d-lg-flex">
                <div class="brand-content">
                    <h1 class="brand-title">Shop smarter with {{ config('app.name', 'Zavro') }}.</h1>
                    <p class="brand-tagline">Discover new arrivals, track your orders, and enjoy fast delivery with a smooth checkout experience.</p>

                    <div class="brand-illustration" aria-hidden="true"></div>

                    <div class="brand-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <span>Fast Delivery</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <span>Secure Payments</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="auth-form-side">
                <div class="auth-form-container">
                    <!-- Mobile Logo -->
                    <div class="text-center mb-4 d-lg-none">
                        <a href="/" class="text-decoration-none" style="color: inherit;">
                            <h1 class="m-0" style="font-size: 1.5rem; font-weight: 800;">{{ config('app.name', 'Zavro') }}</h1>
                        </a>
                    </div>

                    <div class="auth-card">
                        {{ $slot }}
                    </div>

                    <div class="text-center mt-4">
                        <small style="color: rgba(17,24,39,0.35);">
                            &copy; {{ date('Y') }} {{ config('app.name', 'Zavro') }}. All rights reserved.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
