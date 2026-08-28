<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        // Apply theme immediately to prevent flash of wrong theme
        (function() {
            var theme = localStorage.getItem('porto-theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Professional Portfolio Website')">
    <title>@yield('title', 'Porto') | Portfolio</title>
    @yield('meta_tags')

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="preload" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" as="style">
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader-content">
            <i class="bi bi-hexagon-fill loader-icon"></i>
            <span class="loader-text">Loading</span>
        </div>
    </div>

    @yield('content')

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Image Protection Script -->
    <script>
        document.addEventListener('contextmenu', function(e) {
            if (e.target.tagName === 'IMG') {
                e.preventDefault();
            }
        });
    </script>
    <script>
        // Remove preloader when page is fully loaded
        function hidePreloader() {
            const preloader = document.getElementById('preloader');
            if (preloader && !preloader.classList.contains('preloader-hidden')) {
                preloader.classList.add('preloader-hidden');
                setTimeout(() => preloader.style.display = 'none', 600);
            }
        }

        window.addEventListener('load', function() {
            setTimeout(hidePreloader, 300); // Small delay to let the animation play a bit
        });

        // Fallback: forcefully hide preloader after 3 seconds just in case assets fail to load
        setTimeout(hidePreloader, 3000);
    </script>

    @stack('scripts')

    <!-- Disqus Comment Count -->
    <script id="dsq-count-scr" src="//ftrporto.disqus.com/count.js" async></script>
</body>
</html>
