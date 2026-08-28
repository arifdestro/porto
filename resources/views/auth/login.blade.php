@extends('layouts.app')

@section('title', 'Admin Login')

@push('styles')
<style>
/* ====== Auth Page Shared Styles ====== */
.auth-page {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: var(--light-bg);
    position: relative;
    overflow: hidden;
    z-index: 1;
}

[data-theme="dark"] .auth-page {
    background-color: #0B1120;
}

/* Glowing Background Blobs */
.auth-page::before,
.auth-page::after {
    content: '';
    position: fixed;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    filter: blur(100px);
    z-index: -1;
    opacity: 0.5;
    animation: pulseGlow 8s infinite alternate;
    pointer-events: none;
}

.auth-page::before {
    background: radial-gradient(circle, rgba(37,99,235,0.4) 0%, transparent 70%);
    top: -200px;
    left: -200px;
}

.auth-page::after {
    background: radial-gradient(circle, rgba(124,58,237,0.3) 0%, transparent 70%);
    bottom: -200px;
    right: -200px;
    animation-delay: -4s;
}

@keyframes pulseGlow {
    0% { transform: scale(1); opacity: 0.4; }
    100% { transform: scale(1.1); opacity: 0.7; }
}

@keyframes authFadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Main content area - push footer down */
.auth-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 100px 20px 40px; /* top accounts for fixed navbar */
}

.auth-card {
    background: var(--white);
    width: 100%;
    max-width: 420px;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08), 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.8);
    position: relative;
    z-index: 2;
    animation: authFadeUp 0.8s ease-out forwards;
}

.auth-logo {
    width: 60px;
    height: 60px;
    background: var(--primary);
    color: white;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 24px;
    box-shadow: 0 8px 16px rgba(37,99,235,0.3);
}

.auth-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

[data-theme="dark"] .auth-title {
    color: #F8FAFC;
}

.auth-subtitle {
    color: var(--text-light);
    font-size: 0.95rem;
    margin-bottom: 32px;
}

.auth-form .form-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--dark);
    margin-bottom: 8px;
}

[data-theme="dark"] .auth-form .form-label {
    color: #CBD5E1;
}

.auth-form .form-control {
    background: var(--light-bg);
    border: 2px solid transparent;
    padding: 14px 16px;
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.3s;
}

[data-theme="dark"] .auth-form .form-control {
    background: rgba(15, 23, 42, 0.6);
    color: white;
}

.auth-form .form-control:focus {
    background: var(--white);
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
}

[data-theme="dark"] .auth-form .form-control:focus {
    background: #0F172A;
}

.auth-btn {
    background: var(--primary);
    color: white;
    font-weight: 600;
    padding: 14px;
    border-radius: 12px;
    border: none;
    width: 100%;
    margin-top: 10px;
    font-size: 1rem;
    transition: all 0.3s;
}

.auth-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(37,99,235,0.3);
}

.auth-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.auth-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

/* Footer - sticks to bottom */
.auth-footer {
    width: 100%;
    padding: 24px 0;
    background: var(--dark);
    color: rgba(255,255,255,0.7);
    z-index: 10;
    flex-shrink: 0;
}

[data-theme="dark"] .auth-footer {
    background: #020617;
}

.auth-footer .footer-brand {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--white);
}

.auth-footer .footer-text {
    color: rgba(255,255,255,0.6);
    margin-bottom: 0;
    font-size: 0.85rem;
}

.auth-footer .footer-social a {
    color: rgba(255,255,255,0.5);
    margin: 0 8px;
    font-size: 1.1rem;
    transition: all 0.3s;
}

.auth-footer .footer-social a:hover {
    color: var(--primary);
}
</style>
@endpush

@section('content')
<!-- Navbar -->
<div class="auth-page">
    <nav class="navbar navbar-expand-lg fixed-top navbar-porto" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-hexagon-fill me-2"></i>{{ $settings['site_name'] ?? 'Porto' }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#portfolio">Portfolio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
                    <li class="nav-item ms-lg-2 theme-toggle-li">
                        <button class="btn theme-toggle-btn" id="themeToggle" type="button" title="Toggle Dark/Light Mode">
                            <span class="theme-toggle-inner">
                                <i class="bi bi-moon-fill theme-icon-dark"></i>
                                <i class="bi bi-sun-fill theme-icon-light"></i>
                            </span>
                            <span class="theme-toggle-label">
                                <span class="label-dark">Dark Mode</span>
                                <span class="label-light">Light Mode</span>
                            </span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="auth-content">
        <div class="auth-card">
            <div class="auth-logo">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            
            <h1 class="auth-title">Admin Sign In</h1>
            <p class="auth-subtitle">Enter your credentials to manage your portfolio.</p>

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('_token') ? (old('remember') ? 'checked' : '') : 'checked' }}>
                        <label class="form-check-label text-muted" style="font-size: 0.9rem;" for="remember">Keep me signed in</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                </div>

                <button type="submit" class="auth-btn">
                    Sign In
                </button>
            </form>

            {{-- Register link disabled (single user) - re-enable when needed --}}
            {{-- <p class="text-center mt-4 mb-0" style="font-size: 0.9rem; color: var(--text-light);">
                Don't have an account? <a href="{{ route('register') }}" class="auth-link">Sign Up</a>
            </p> --}}
        </div>
    </div>

    <!-- Footer -->
    <footer class="auth-footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                    <div class="footer-brand">
                        <i class="bi bi-hexagon-fill me-2"></i>{{ $settings['site_name'] ?? 'Porto' }}
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <div class="footer-social">
                        @if(isset($socialLinks))
                            @foreach($socialLinks as $link)
                                <a href="{{ $link->url }}" target="_blank" title="{{ $link->platform }}">
                                    <i class="bi bi-{{ $link->icon }}"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    @php
                        $footerText = $settings['footer_text'] ?? '&copy; ' . date('Y') . ' Porto. All rights reserved.';
                        $dynamicFooter = preg_replace('/\b20\d{2}\b/', date('Y'), $footerText);
                    @endphp
                    <p class="footer-text">{!! $dynamicFooter !!}</p>
                </div>
            </div>
        </div>
    </footer>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Theme toggle
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const html = document.documentElement;
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('porto-theme', newTheme);
            });
        }

        // Navbar scroll effect
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>
@endpush
@endsection
