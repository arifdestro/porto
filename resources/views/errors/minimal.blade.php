<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        (function() {
            var theme = localStorage.getItem('porto-theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Porto</title>
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--light-bg);
            text-align: center;
            position: relative;
            overflow: hidden;
            font-family: "Inter", sans-serif;
        }
        .error-content {
            z-index: 2;
            padding: 40px;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            max-width: 500px;
            width: 90%;
            transition: background-color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease;
            animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .error-code {
            font-size: 7rem;
            font-weight: 900;
            line-height: 1;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            letter-spacing: -4px;
        }
        .error-message {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .error-desc {
            color: var(--text-light);
            margin-bottom: 32px;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        .btn-home {
            background: var(--gradient);
            color: white !important;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37,99,235,0.3);
        }
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37,99,235,0.4);
        }
        .bg-shapes .shape {
            position: absolute;
            filter: blur(80px);
            z-index: 1;
        }
        .bg-shapes .shape-1 {
            width: 350px; height: 350px;
            background: rgba(37,99,235,0.15);
            top: -100px; left: -100px;
            border-radius: 50%;
        }
        .bg-shapes .shape-2 {
            width: 450px; height: 450px;
            background: rgba(124,58,237,0.12);
            bottom: -150px; right: -150px;
            border-radius: 50%;
        }
        [data-theme="dark"] .error-page {
            background-color: #0F172A;
        }
        [data-theme="dark"] .error-content {
            background-color: #1E293B;
            border-color: rgba(255,255,255,0.07);
        }
        [data-theme="dark"] .error-message {
            color: #F1F5F9;
        }
    </style>
</head>
<body class="antialiased">
    <div class="error-page">
        <div class="bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>
        <div class="error-content">
            <div class="error-code">@yield('code')</div>
            <h2 class="error-message">@yield('message')</h2>
            <p class="error-desc">@yield('description', 'Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.')</p>
            <a href="{{ url('/') }}" class="btn-home">
                <i class="bi bi-arrow-left"></i> Back to Homepage
            </a>
        </div>
    </div>
</body>
</html>
