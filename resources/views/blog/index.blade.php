@extends('layouts.app')

@section('title', 'Blog')
@section('meta_description', 'Read my latest thoughts, tutorials, and articles on web development, design, and IT support.')

@push('styles')
<style>
    /* Developer Blog Styles */
    body {
        background-color: var(--bs-body-bg);
    }
    .blog-header {
        position: relative;
        padding: 140px 0 60px;
        border-bottom: 1px solid var(--bs-border-color-translucent);
        overflow: hidden;
    }
    .blog-header-bg {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(var(--bs-primary-rgb), 0.08) 0%, rgba(var(--bs-primary-rgb), 0) 50%),
                    radial-gradient(circle, rgba(13, 202, 240, 0.05) 0%, rgba(13, 202, 240, 0) 50%);
        background-position: 0% 0%, 100% 100%;
        background-size: 50% 50%, 50% 50%;
        background-repeat: no-repeat;
        animation: rotateBg 20s linear infinite;
        z-index: 0;
        pointer-events: none;
    }
    @keyframes rotateBg {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .blog-header > .container {
        position: relative;
        z-index: 1;
    }
    @media (max-width: 768px) {
        .blog-header {
            padding: 100px 0 40px;
        }
        .featured-title {
            font-size: 1.6rem !important;
        }
        .post-img-wrapper {
            min-height: 200px !important;
        }
    }
    .featured-post-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--bs-border-color-translucent);
        background: var(--bs-body-bg);
    }
    .featured-post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .post-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--bs-border-color-translucent);
        background: var(--bs-body-bg);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    .post-img-wrapper {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }
    .post-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .post-card:hover .post-img-wrapper img, .featured-post-card:hover .post-img-wrapper img {
        transform: scale(1.05);
    }
    .post-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--bs-primary);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .post-title {
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 15px;
        color: var(--bs-heading-color);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .post-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .post-title a:hover {
        color: var(--bs-primary);
    }
    .featured-title {
        font-size: 2.2rem;
        -webkit-line-clamp: 3;
    }
    .post-excerpt {
        color: var(--bs-secondary-color);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 20px;
        flex-grow: 1;
    }
    .post-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.85rem;
        color: var(--bs-secondary-color);
        border-top: 1px solid var(--bs-border-color-translucent);
        padding-top: 15px;
        margin-top: auto;
    }
    .author-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--bs-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }
    
    /* New Cool Additions */
    .glass-card {
        background: rgba(var(--bs-body-bg-rgb), 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    html[data-theme="dark"] .glass-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .hover-glow {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .hover-glow:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(var(--bs-primary-rgb), 0.2);
        border-color: rgba(var(--bs-primary-rgb), 0.5);
    }
    
    .bg-primary-gradient {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #0dcaf0 100%);
    }
    
    .search-glass {
        background: rgba(var(--bs-body-bg-rgb), 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid var(--bs-border-color-translucent);
        border-radius: 50px;
        padding: 5px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .search-glass:focus-within {
        box-shadow: 0 10px 30px rgba(var(--bs-primary-rgb), 0.2);
        border-color: var(--bs-primary);
    }
    .search-glass input {
        border: none;
        background: transparent;
        color: var(--bs-body-color);
        padding: 12px 15px;
        width: 100%;
        outline: none;
    }
    
    .load-more-btn {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #0dcaf0 100%);
        border: none;
        color: white;
        padding: 12px 40px;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.3s;
        box-shadow: 0 8px 20px rgba(var(--bs-primary-rgb), 0.3);
    }
    .load-more-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(var(--bs-primary-rgb), 0.4);
    }
    .cat-pill {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .cat-pill:hover {
        transform: scale(1.05) translateY(-2px);
    }
    .trending-ribbon {
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        z-index: 10;
        box-shadow: 0 5px 15px rgba(255, 65, 108, 0.4);
        transform: rotate(5deg);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 65, 108, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 65, 108, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 65, 108, 0); }
    }
    html[data-theme="dark"] .hero-img-light {
        display: none !important;
    }
    html[data-theme="dark"] .hero-img-dark {
        display: block !important;
    }
</style>
@endpush

@section('content')
<!-- Navigation (Hamburger Version for Blog) -->
<nav class="navbar navbar-expand-lg fixed-top navbar-porto py-2 py-md-3" id="blogMainNavbar">
    <div class="container">
        <a class="navbar-brand fw-bold m-0" href="{{ route('home') }}">
            <i class="bi bi-hexagon-fill text-primary me-1"></i>Porto.
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#blogNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="blogNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item me-lg-3 my-2 my-lg-0">
                    <a href="{{ route('home') }}" class="nav-link text-body fw-medium"><i class="bi bi-arrow-left me-1"></i> Back to Portfolio</a>
                </li>
                <li class="nav-item theme-toggle-li">
                    <button class="btn theme-toggle-btn" id="themeToggle" type="button" title="Toggle Dark/Light Mode">
                        <span class="theme-toggle-label">
                            <span class="label-dark d-lg-none">Dark Mode</span>
                            <span class="label-light d-lg-none">Light Mode</span>
                        </span>
                        <span class="theme-toggle-inner ms-lg-0">
                            <i class="bi bi-moon-fill theme-icon-dark"></i>
                            <i class="bi bi-sun-fill theme-icon-light"></i>
                        </span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Blog Header -->
<header class="blog-header">
    <div class="blog-header-bg"></div>
    <div class="container">
        <div class="row align-items-center">
            <!-- Hero Image (Desktop/Tablet) -->
            <div class="col-md-5 d-none d-md-block text-center fade-in">
                <img src="{{ asset('images/light_mode_hero.jpg') }}" alt="Developer typing" class="img-fluid rounded-4 shadow-lg hero-img-light" style="max-height: 350px; object-fit: cover; width: 100%;">
                <img src="{{ asset('images/dark_mode_hero.jpg') }}" alt="Developer sleeping" class="img-fluid rounded-4 shadow-lg hero-img-dark d-none" style="max-height: 350px; object-fit: cover; width: 100%;">
            </div>
            
            <!-- Hero Text & Search -->
            <div class="col-md-7 text-center text-md-start pt-md-0 pt-4">
                <h1 class="display-4 fw-bolder mb-3">Developer <span class="text-primary">Blog</span></h1>
                <p class="lead text-secondary mx-auto mx-md-0 mb-5" style="max-width: 600px;">
                    Tutorial, tips, dan wawasan seputar dunia pemrograman, web development, dan teknologi.
                </p>
                
                <form action="{{ route('blog.index') }}" method="GET" class="search-glass mx-auto mx-md-0" style="max-width: 500px;" id="searchForm">
                    <i class="bi bi-search text-secondary ms-2"></i>
                    <input type="text" name="search" placeholder="Cari artikel, tutorial, tips..." value="{{ request('search') }}" autocomplete="off" id="searchInput">
                    <a href="{{ route('blog.index') }}" id="clearSearchBtn" class="btn btn-sm btn-link text-secondary text-decoration-none" style="{{ (request('search') || request('category')) ? '' : 'display:none;' }}"><i class="bi bi-x-circle"></i> Clear</a>
                </form>
                
                <div class="mt-4 d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    <a href="{{ route('blog.index') }}" class="btn cat-pill {{ !request('category') ? 'btn-primary shadow' : 'btn-outline-secondary' }} rounded-pill px-4 py-2">
                        <i class="bi bi-grid-fill"></i> Semua
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" class="btn cat-pill {{ request('category') == $cat ? 'btn-primary shadow' : 'btn-outline-secondary' }} rounded-pill px-4 py-2">
                        <i class="bi bi-tag"></i> {{ $cat }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <div id="blog-main-content">
            @include('blog.partials.main_content')
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="py-4 text-center mt-auto" style="background: var(--bs-body-bg); border-top: 1px solid var(--bs-border-color-translucent);">
    <div class="container pt-3">
        <p class="mb-0 fw-medium" style="color: var(--bs-secondary-color);">&copy; {{ date('Y') }} Porto Developer Blog.</p>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    // Theme toggle logic for blog
    document.addEventListener('DOMContentLoaded', function() {
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('blogMainNavbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });

        // Theme toggle logic for blog
        const toggleBtn = document.getElementById('themeToggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('porto-theme', newTheme);
            });
        }

        // AJAX Load More Logic (Delegated to document)
        document.addEventListener('click', function(e) {
            let loadMoreBtn = e.target.closest('#loadMoreBtn');
            if (loadMoreBtn) {
                let nextPage = loadMoreBtn.getAttribute('data-next-page');
                let icon = document.getElementById('loadMoreIcon');
                
                // Add loading animation
                if (icon) {
                    icon.classList.add('bi-arrow-clockwise', 'text-white');
                    icon.style.animation = 'spin 1s linear infinite';
                }
                loadMoreBtn.disabled = true;

                // Build URL with current search/category params
                let url = new URL(window.location.href);
                url.searchParams.set('page', nextPage);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (html.trim() !== '') {
                        document.getElementById('post-grid').insertAdjacentHTML('beforeend', html);
                        loadMoreBtn.setAttribute('data-next-page', parseInt(nextPage) + 1);
                        
                        // Stop loading animation
                        if (icon) icon.style.animation = 'none';
                        loadMoreBtn.disabled = false;
                    } else {
                        // No more posts
                        let container = document.getElementById('loadMoreContainer');
                        if (container) container.remove();
                    }
                })
                .catch(error => {
                    console.error('Error fetching posts:', error);
                    if (icon) icon.style.animation = 'none';
                    loadMoreBtn.disabled = false;
                });
            }
        });

        // Live Filtering Logic
        let currentCategory = new URLSearchParams(window.location.search).get('category') || '';
        let currentSearch = new URLSearchParams(window.location.search).get('search') || '';

        function fetchPosts(category, search) {
            let url = new URL(window.location.href);
            if (category) url.searchParams.set('category', category);
            else url.searchParams.delete('category');
            
            if (search) url.searchParams.set('search', search);
            else url.searchParams.delete('search');
            
            url.searchParams.delete('page'); // Reset to page 1

            // Update URL bar without reload
            window.history.pushState({}, '', url);

            // Show loading indicator
            document.getElementById('blog-main-content').innerHTML = '<div class="text-center py-5 my-5"><div class="spinner-border text-primary" role="status"></div><h5 class="mt-3 text-secondary">Loading...</h5></div>';

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('blog-main-content').innerHTML = html;
                updateCategoryButtons(category);
                
                // Show/hide clear button
                const clearBtn = document.getElementById('clearSearchBtn');
                if (clearBtn) {
                    clearBtn.style.display = (category || search) ? '' : 'none';
                }
            });
        }

        // Category click interception
        document.addEventListener('click', function(e) {
            let catLink = e.target.closest('a.cat-pill');
            if (catLink) {
                e.preventDefault();
                let url = new URL(catLink.href);
                currentCategory = url.searchParams.get('category') || '';
                fetchPosts(currentCategory, currentSearch);
            }
        });

        // Update active states on buttons
        function updateCategoryButtons(activeCat) {
            document.querySelectorAll('a.cat-pill').forEach(btn => {
                let btnUrl = new URL(btn.href);
                let btnCat = btnUrl.searchParams.get('category') || '';
                
                if (btnCat === activeCat) {
                    btn.className = 'btn cat-pill btn-primary shadow rounded-pill px-4 py-2';
                } else {
                    btn.className = 'btn cat-pill btn-outline-secondary rounded-pill px-4 py-2';
                }
            });
        }

        // Search form submit
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                currentSearch = document.getElementById('searchInput').value;
                fetchPosts(currentCategory, currentSearch);
            });
        }

        // Live search (debounce)
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentSearch = this.value;
                    fetchPosts(currentCategory, currentSearch);
                }, 500);
            });
        }

        // Clear button logic
        document.addEventListener('click', function(e) {
            let clearBtn = e.target.closest('#clearSearchBtn');
            if (clearBtn) {
                e.preventDefault();
                if (searchInput) searchInput.value = '';
                currentSearch = '';
                currentCategory = '';
                fetchPosts('', '');
            }
        });
    });
</script>
<style>
@keyframes spin { 100% { transform: rotate(360deg); } }
</style>
@endpush
