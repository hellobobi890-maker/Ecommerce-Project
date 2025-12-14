<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --bg-light: #f8fafc;
        }
        * { font-family: 'Outfit', sans-serif !important; }
        body {
            background: var(--bg-light);
            min-height: 100vh;
        }
        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .btn-primary {
            background: var(--primary-color);
            border: none;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">
        <div class="mb-4">
            <a href="/" class="text-decoration-none d-flex align-items-center gap-2">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px;">
                    <i class="bi bi-bag-heart-fill fs-3"></i>
                </div>
                <span class="text-white fw-bold fs-4">{{ config('app.name') }}</span>
            </a>
        </div>

        <div class="auth-card w-100" style="max-width: 420px;">
            <div class="p-4 p-md-5">
                {{ $slot }}
            </div>
        </div>
        
        <div class="mt-4 text-white-50 small">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
