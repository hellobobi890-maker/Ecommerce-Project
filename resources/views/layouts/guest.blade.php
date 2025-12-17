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
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --accent-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-bg: #0f0f23;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
        }

        * {
            font-family: 'Outfit', sans-serif !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-bg);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Main Container */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* Left Side - Branding */
        .auth-brand-side {
            flex: 1;
            background: var(--primary-gradient);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            overflow: hidden;
        }

        .auth-brand-side::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.08) 0%, transparent 40%);
            animation: float 15s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -30px) rotate(5deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(-3deg);
            }
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 400px;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .brand-logo i {
            font-size: 3rem;
            color: white;
        }

        .brand-title {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .brand-tagline {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
            line-height: 1.6;
        }

        .brand-features {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-icon i {
            font-size: 1.2rem;
            color: white;
        }

        /* Floating Elements */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
            animation: pulse 4s ease-in-out infinite;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            left: -50px;
            animation: pulse 5s ease-in-out infinite 1s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 10%;
            animation: pulse 6s ease-in-out infinite 2s;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.2;
            }
        }

        /* Right Side - Form */
        .auth-form-side {
            flex: 1;
            background: var(--dark-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }

        .auth-form-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 0% 0%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 2;
        }

        /* Glass Card */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        /* Form Styles */
        .form-floating-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .form-floating-custom .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 1rem 1rem 1rem 3rem;
            height: 56px;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
        }

        .form-floating-custom .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-floating-custom .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .form-floating-custom .form-control.is-invalid {
            border-color: #f5576c;
        }

        .form-floating-custom .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(245, 87, 108, 0.25);
        }

        .form-floating-custom .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
            z-index: 5;
        }

        .form-floating-custom .form-label {
            display: none;
        }

        .invalid-feedback {
            color: #f5576c;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Remember & Forgot */
        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        .form-check-input:checked {
            background: var(--primary-gradient);
            border: none;
        }

        .form-check-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-left: 0.25rem;
        }

        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .forgot-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-auth {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 14px;
            background: var(--primary-gradient);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .btn-auth:active {
            transform: translateY(-1px);
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            gap: 1rem;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .auth-divider span {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* Social Buttons */
        .social-btns {
            display: flex;
            gap: 1rem;
        }

        .btn-social {
            flex: 1;
            padding: 0.875rem;
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-social:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .auth-footer a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }

        .auth-footer a:hover {
            color: #764ba2;
        }

        /* Alert */
        .alert-glass {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .auth-wrapper {
                flex-direction: column;
            }

            .auth-brand-side {
                padding: 2rem;
                min-height: auto;
            }

            .brand-content {
                max-width: 100%;
            }

            .brand-title {
                font-size: 2rem;
            }

            .brand-tagline {
                font-size: 1rem;
            }

            .brand-features {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 1.5rem;
            }

            .feature-item {
                font-size: 0.85rem;
            }

            .auth-form-side {
                padding: 2rem 1.5rem;
            }

            .glass-card {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .brand-logo {
                width: 70px;
                height: 70px;
                border-radius: 20px;
            }

            .brand-logo i {
                font-size: 2rem;
            }

            .brand-title {
                font-size: 1.75rem;
            }

            .brand-features {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <!-- Left Side - Branding -->
        <div class="auth-brand-side d-none d-lg-flex">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>

            <div class="brand-content">
                <div class="brand-logo">
                    <i class="bi bi-bag-heart-fill"></i>
                </div>
                <h1 class="brand-title">{{ config('app.name', 'Zavro') }}</h1>
                <p class="brand-tagline">Discover the latest trends in fashion. Shop premium quality products with fast
                    delivery across Pakistan.</p>

                <div class="brand-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <span>Free Delivery Nationwide</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <span>Secure Payment Methods</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <span>Easy Returns & Exchange</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-form-side">
            <div class="auth-form-container">
                <!-- Mobile Logo -->
                <div class="text-center mb-4 d-lg-none">
                    <a href="/" class="text-decoration-none">
                        <div class="brand-logo mx-auto" style="width: 70px; height: 70px;">
                            <i class="bi bi-bag-heart-fill" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h1 class="brand-title mt-3" style="font-size: 1.75rem;">{{ config('app.name', 'Zavro') }}</h1>
                    </a>
                </div>

                <div class="glass-card">
                    {{ $slot }}
                </div>

                <div class="text-center mt-4">
                    <small style="color: rgba(255,255,255,0.4);">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Zavro') }}. All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
