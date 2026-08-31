@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 150))

@section('meta_tags')
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}">
<meta property="og:image" content="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : asset($post->image)) : asset('images/default-blog.jpg') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="article">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $post->title }}">
<meta name="twitter:description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}">
<meta name="twitter:image" content="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : asset($post->image)) : asset('images/default-blog.jpg') }}">
@endsection

@push('styles')
<!-- Highlight.js CSS (Atom One Dark theme) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
<style>
    /* Styling for the pre blocks from summernote */
    .blog-content pre {
        background: #282c34;
        border-radius: 8px;
        padding: 1rem;
        margin: 1.5rem 0;
        overflow-x: auto;
    }
    .blog-content pre code {
        font-family: 'Fira Code', 'Consolas', monospace;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<!-- Reading Progress Bar -->
<div class="reading-progress-container">
    <div class="reading-progress-bar" id="readingProgressBar"></div>
</div>

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
                    <a href="{{ route('blog.index') }}" class="nav-link text-body fw-medium"><i class="bi bi-arrow-left me-1"></i> Back to Blog</a>
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

@php
    $wordCount = str_word_count(strip_tags($post->content));
    $readTime = ceil($wordCount / 200);
@endphp

<!-- Article Header & Cover -->
<header class="blog-header pb-5">
    <div class="blog-header-bg"></div>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center fade-in">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-center">
                  <ol class="breadcrumb" style="font-size: 0.9rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $post->category ?? 'Blog' }}</li>
                  </ol>
                </nav>

                <h1 class="display-4 fw-bolder mb-4" style="line-height: 1.25; color: var(--bs-heading-color);">{{ $post->title }}</h1>
                
                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 text-muted">
                    <div class="author-avatar"><i class="bi bi-person-fill"></i></div>
                    <div class="text-start">
                        <div class="fw-bold text-body" style="font-size: 0.95rem;">Ditulis oleh Admin</div>
                        <div style="font-size: 0.85rem;">
                            {{ $post->created_at->format('d M Y') }} &bull; {{ $readTime }} min read
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Cover Image -->
        @if($post->image)
        <div class="row justify-content-center mt-5 fade-in">
            <div class="col-lg-10">
                <div class="hero-cover-container">
                    <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="hero-cover-img">
                </div>
            </div>
        </div>
        @endif
    </div>
</header>

<!-- Article Content -->
<article class="py-5 bg-body">
    <div class="container">
        <div class="row justify-content-center gap-lg-4">
            
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Mobile ToC FAB (floating button) - rendered later as overlay -->

                <div class="article-content article-body fade-in">
                    {!! $post->content !!}
                </div>
                
                <!-- Author Box -->
                <div class="author-glass mt-5 p-4 rounded-4 fade-in">
                    @php
                        $heroTitle = \App\Models\SiteSetting::get('hero_title', '');
                        $authorName = preg_replace('/^(Halo|Hello|Hi),\s*I\'?a?m\s+/i', '', $heroTitle);
                        if (empty($authorName)) {
                            $admin = \App\Models\User::first();
                            $authorName = $admin ? $admin->name : 'Admin Porto';
                        }
                        
                        $authorRole = \App\Models\SiteSetting::get('hero_subtitle', 'Web Developer');
                        $authorImage = \App\Models\SiteSetting::get('hero_image');
                    @endphp
                    <div class="d-flex flex-column flex-sm-row gap-4 align-items-center align-items-sm-start">
                        <div class="author-avatar-large" style="{{ $authorImage ? 'background: transparent;' : '' }}">
                            @if($authorImage)
                                <img src="{{ str_starts_with($authorImage, 'http') ? $authorImage : asset($authorImage) }}" alt="{{ $authorName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                            @else
                                <i class="bi bi-person-fill"></i>
                            @endif
                        </div>
                        <div class="text-center text-sm-start">
                            <h5 class="fw-bold mb-1">{{ $authorName }}</h5>
                            <p class="text-secondary mb-2" style="font-size: 0.95rem;">{{ $authorRole }}</p>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">Menulis seputar pemrograman web, tutorial Laravel, dan pengalaman di dunia IT. Temukan saya di sosial media untuk diskusi lebih lanjut.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Disqus Comments Section -->
                <div class="mt-5 pt-4 border-top fade-in">
                    <h4 class="fw-bold mb-4">Komentar</h4>
                    <div id="disqus_thread"></div>
                </div>
            </div>
            
            <!-- Right Sidebar (Desktop only) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sticky-top pt-2" style="top: 100px;">
                    <div class="p-4 rounded-4" style="background: rgba(var(--bs-primary-rgb), 0.03); border: 1px solid rgba(var(--bs-primary-rgb), 0.1);">
                        
                        <!-- Desktop ToC -->
                        @if(isset($toc) && count($toc) > 0)
                        <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 1px; font-size: 0.85rem;"><i class="bi bi-list-nested me-2"></i>Daftar Isi</h6>
                        <nav class="toc-nav mb-4">
                            <ul class="list-unstyled mb-0">
                                @foreach($toc as $item)
                                    <li class="mb-2" style="padding-left: {{ ($item['level'] - 2) * 1 }}rem; border-left: 2px solid transparent;" id="toc-item-{{ $item['id'] }}">
                                        <a href="#{{ $item['id'] }}" class="text-decoration-none text-body toc-link" style="font-size: 0.9rem; transition: color 0.2s;">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                        <hr class="my-4" style="border-color: rgba(var(--bs-primary-rgb), 0.1);">
                        @endif

                        <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 1px; font-size: 0.85rem;">Kategori Topik</h6>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <a href="{{ route('blog.index', ['category' => $post->category]) }}" class="badge bg-primary text-decoration-none px-3 py-2 rounded-pill">{{ $post->category ?? 'Blog' }}</a>
                            <a href="{{ route('blog.index') }}" class="badge bg-secondary bg-opacity-10 text-body text-decoration-none px-3 py-2 rounded-pill">Web Dev</a>
                            <a href="{{ route('blog.index') }}" class="badge bg-secondary bg-opacity-10 text-body text-decoration-none px-3 py-2 rounded-pill">Tech</a>
                        </div>
                        
                        <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 1px; font-size: 0.85rem;">Bagikan</h6>
                        <div class="d-flex gap-2">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-light rounded-circle border shadow-sm" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;" title="Share on X">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-light rounded-circle border shadow-sm" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;" title="Share on Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" target="_blank" class="btn btn-light rounded-circle border shadow-sm" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;" title="Share on LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</article>

<!-- Sticky Mobile Action Bar -->
<!-- Mobile Floating Share Bar -->
<div class="share-bar d-flex d-lg-none" id="shareBar">
    <a href="javascript:void(0)" class="share-bar-btn" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" title="Kembali ke atas">
        <i class="bi bi-chevron-up"></i>
    </a>
    <div class="share-bar-divider"></div>
    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-bar-btn" title="Share ke X">
        <i class="bi bi-twitter-x"></i>
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="share-bar-btn" title="Share ke Facebook">
        <i class="bi bi-facebook"></i>
    </a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" target="_blank" class="share-bar-btn" title="Share ke LinkedIn">
        <i class="bi bi-linkedin"></i>
    </a>
    <div class="share-bar-divider"></div>
    <button class="share-bar-btn" id="copyLinkBtn" title="Salin link">
        <i class="bi bi-link-45deg" id="copyLinkIcon"></i>
    </button>
</div>

<!-- Footer -->
<footer class="py-4 text-center mt-auto" style="background: var(--bs-body-bg); border-top: 1px solid var(--bs-border-color-translucent);">
    <div class="container pt-3">
        <p class="mb-0 fw-medium" style="color: var(--bs-secondary-color);">&copy; {{ date('Y') }} Porto Developer Blog.</p>
    </div>
</footer>

@if(isset($toc) && count($toc) > 0)
<!-- Mobile Floating ToC Button + Bottom Sheet -->
<div class="d-lg-none">

    {{-- FAB Button --}}
    <button class="toc-fab" id="tocFab" aria-label="Daftar Isi" title="Daftar Isi">
        <i class="bi bi-list-nested"></i>
    </button>

    {{-- Backdrop --}}
    <div class="toc-backdrop" id="tocBackdrop"></div>

    {{-- Bottom Sheet --}}
    <div class="toc-sheet" id="tocSheet" aria-hidden="true">
        <div class="toc-sheet-handle"></div>
        <div class="d-flex justify-content-between align-items-center mb-3 px-1">
            <h6 class="fw-bold text-uppercase mb-0" style="letter-spacing: 1px; font-size: 0.8rem;">
                <i class="bi bi-list-nested me-2 text-primary"></i>Daftar Isi
            </h6>
            <button class="btn btn-sm btn-link p-0 text-body" id="tocSheetClose" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <nav class="toc-nav toc-sheet-nav">
            <ul class="list-unstyled mb-0">
                @foreach($toc as $item)
                    <li class="mb-1" style="padding-left: {{ ($item['level'] - 2) * 1.2 }}rem;">
                        <a href="#{{ $item['id'] }}" class="text-decoration-none text-body toc-link toc-sheet-link py-2 d-block" style="font-size: 0.92rem; border-radius: 8px; padding-left: 0.5rem; transition: background 0.15s, color 0.15s;">
                            {{ $item['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

</div>
@endif
@endsection

@push('styles')
<style>
    .blog-surface {
        background-color: var(--bs-light);
    }
    html[data-theme="dark"] .blog-surface {
        background-color: #1E293B;
    }
    .author-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--bs-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }
    .author-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--bs-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        flex-shrink: 0;
    }
    
    /* Reading Progress Bar */
    .reading-progress-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: transparent;
        z-index: 1050;
    }
    .reading-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--bs-primary), #0dcaf0);
        width: 0%;
        transition: width 0.1s;
        box-shadow: 0 0 10px rgba(var(--bs-primary-rgb), 0.5);
    }
    
    .sticky-share-container {
        position: sticky;
        top: 120px;
    }
    .share-btn-glass {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(var(--bs-body-bg-rgb), 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid var(--bs-border-color-translucent);
        color: var(--bs-body-color);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .share-btn-glass:hover {
        background: var(--bs-primary);
        color: white;
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 5px 15px rgba(var(--bs-primary-rgb), 0.4);
    }
    
    /* Article Content */
    .article-content {
        font-size: 1.15rem;
        line-height: 1.9;
        color: var(--bs-body-color);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .article-content p {
        margin-bottom: 1.5rem;
    }
    .article-content h1, .article-content h2, .article-content h3, .article-content h4, .article-content h5, .article-content h6 {
        color: var(--bs-heading-color);
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        scroll-margin-top: 100px;
    }
    .article-content h2 {
        font-size: 1.8rem;
        border-bottom: 2px solid var(--bs-border-color-translucent);
        padding-bottom: 0.5rem;
    }
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: 1px solid var(--bs-border-color-translucent);
    }
    .article-content a {
        color: var(--bs-primary);
        text-decoration: underline;
        text-underline-offset: 3px;
        font-weight: 500;
    }
    .article-content a:hover {
        color: var(--bs-primary-hover, #0056b3);
    }
    .article-content blockquote {
        border-left: 5px solid var(--bs-primary);
        background-color: var(--bs-light);
        padding: 1.5rem;
        margin: 2rem 0;
        border-radius: 0 12px 12px 0;
        font-style: italic;
        color: var(--bs-secondary-color);
    }
    html[data-theme="dark"] .article-content blockquote {
        background-color: #1E293B;
    }
    .article-content blockquote p:last-child {
        margin-bottom: 0;
    }
    .article-content pre {
        background-color: #1e1e1e;
        color: #d4d4d4;
        padding: 1.5rem;
        border-radius: 12px;
        overflow-x: auto;
        margin: 2rem 0;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }
    .article-content code {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.9em;
    }
    .article-content pre code {
        background-color: transparent;
        color: inherit;
        padding: 0;
        font-size: 0.95rem;
    }
    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    .article-content li {
        margin-bottom: 0.5rem;
    }

    /* Sticky Mobile Action Bar */
    /* Mobile Floating Share Bar */
    .share-bar {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1070;
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color-translucent);
        border-radius: 99px;
        padding: 8px 16px;
        gap: 4px;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        transition: opacity 0.3s, transform 0.3s;
    }
    .share-bar.hide-bar {
        opacity: 0;
        pointer-events: none;
        transform: translateX(-50%) translateY(12px);
    }
    .share-bar-btn {
        color: var(--bs-body-color);
        font-size: 1.15rem;
        text-decoration: none;
        background: none;
        border: none;
        padding: 6px 10px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s, background 0.2s;
        cursor: pointer;
        min-width: 38px;
        min-height: 38px;
    }
    .share-bar-btn:hover {
        color: var(--bs-primary);
        background: rgba(var(--bs-primary-rgb), 0.1);
    }
    .share-bar-divider {
        width: 1px;
        height: 20px;
        background: var(--bs-border-color);
        margin: 0 4px;
        opacity: 0.6;
    }

    /* Author Glass Box */
    .author-glass {
        background: rgba(var(--bs-primary-rgb), 0.03);
        border: 1px solid rgba(var(--bs-primary-rgb), 0.1);
    }

    /* ToC Nav Link Styles */
    .toc-link {
        transition: color 0.2s, font-weight 0.2s;
    }
    .toc-link:hover {
        color: var(--bs-primary) !important;
    }

    /* Disqus Container */
    #disqus_thread {
        min-height: 100px;
    }

    /* ── Mobile Floating ToC ── */
    /* FAB Button */
    .toc-fab {
        position: fixed;
        bottom: 88px;
        right: 20px;
        z-index: 1080;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: var(--bs-primary);
        color: #fff;
        border: none;
        font-size: 1.25rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .toc-fab:hover, .toc-fab:focus {
        transform: scale(1.08);
        box-shadow: 0 6px 28px rgba(0,0,0,0.3);
        outline: none;
    }
    .toc-fab.toc-open {
        transform: scale(0.9) rotate(90deg);
    }

    /* Backdrop */
    .toc-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 1079;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(2px);
    }
    .toc-backdrop.toc-open {
        opacity: 1;
        pointer-events: all;
    }

    /* Bottom Sheet */
    .toc-sheet {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1081;
        background: var(--bs-body-bg);
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        padding: 12px 20px 28px;
        box-shadow: 0 -8px 40px rgba(0,0,0,0.2);
        max-height: 70vh;
        overflow-y: auto;
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.32, 0.72, 0, 1);
        overscroll-behavior: contain;
    }
    .toc-sheet.toc-open {
        transform: translateY(0);
    }
    .toc-sheet-handle {
        width: 40px;
        height: 4px;
        background: var(--bs-border-color);
        border-radius: 99px;
        margin: 0 auto 14px;
    }
    .toc-sheet-nav .toc-sheet-link:hover,
    .toc-sheet-nav .toc-sheet-link:focus {
        background: rgba(var(--bs-primary-rgb), 0.08);
        color: var(--bs-primary) !important;
    }
    .toc-sheet-nav .toc-sheet-link.active-toc {
        background: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary) !important;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Disqus Embed
        var disqus_config = function () {
            this.page.url = '{{ url()->current() }}';
            this.page.identifier = '{{ $post->slug }}';
        };
        (function() {
            var d = document, s = d.createElement('script');
            s.src = 'https://ftrporto.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();

        // Scrollspy for ToC
        const tocLinks = document.querySelectorAll('.toc-link');
        const headings = document.querySelectorAll('.article-content h2, .article-content h3');

        if (headings.length > 0 && tocLinks.length > 0) {
            const observerOptions = {
                root: null,
                rootMargin: '-100px 0px -40% 0px',
                threshold: 0
            };

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        
                        // Remove active class from all links
                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-primary', 'fw-bold'));
                        document.querySelectorAll('.toc-nav li').forEach(li => li.style.borderLeftColor = 'transparent');
                        
                        // Add active class to current intersecting heading
                        const activeLink = document.querySelector(`.toc-link[href="#${id}"]`);
                        if (activeLink) {
                            activeLink.classList.add('text-primary', 'fw-bold');
                            const parentLi = activeLink.closest('li');
                            if (parentLi) {
                                parentLi.style.borderLeftColor = 'var(--bs-primary)';
                            }
                        }
                    }
                });
            }, observerOptions);

            headings.forEach(heading => {
                observer.observe(heading);
            });
        }

        // Smooth scroll for ToC links
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const yOffset = -90;
                    const y = targetElement.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({top: y, behavior: 'smooth'});
                }

                // Close mobile ToC bottom sheet if open
                closeTocSheet();
            });
        });

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

        // Reading Progress Bar
        const progressBar = document.getElementById('readingProgressBar');
        if(progressBar) {
            window.addEventListener('scroll', () => {
                let scrollTop = window.scrollY || document.documentElement.scrollTop;
                let docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                let scrollPercent = (scrollTop / docHeight) * 100;
                progressBar.style.width = scrollPercent + '%';
            });
        }

        // ── Mobile Floating ToC ──
        const tocFab     = document.getElementById('tocFab');
        const tocSheet   = document.getElementById('tocSheet');
        const tocBackdrop = document.getElementById('tocBackdrop');
        const tocSheetClose = document.getElementById('tocSheetClose');

        function openTocSheet() {
            if (!tocSheet) return;
            tocSheet.classList.add('toc-open');
            tocBackdrop.classList.add('toc-open');
            tocFab.classList.add('toc-open');
            tocSheet.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeTocSheet() {
            if (!tocSheet) return;
            tocSheet.classList.remove('toc-open');
            tocBackdrop.classList.remove('toc-open');
            if (tocFab) tocFab.classList.remove('toc-open');
            tocSheet.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (tocFab) {
            tocFab.addEventListener('click', function() {
                if (tocSheet.classList.contains('toc-open')) {
                    closeTocSheet();
                } else {
                    openTocSheet();
                }
            });
        }
        if (tocBackdrop)  tocBackdrop.addEventListener('click', closeTocSheet);
        if (tocSheetClose) tocSheetClose.addEventListener('click', closeTocSheet);

        // Close sheet on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeTocSheet();
        });

        // Copy Link Button
        const copyLinkBtn = document.getElementById('copyLinkBtn');
        const copyLinkIcon = document.getElementById('copyLinkIcon');
        if (copyLinkBtn) {
            copyLinkBtn.addEventListener('click', function() {
                navigator.clipboard.writeText(window.location.href).then(function() {
                    copyLinkIcon.className = 'bi bi-check2';
                    copyLinkBtn.style.color = 'var(--bs-success)';
                    setTimeout(function() {
                        copyLinkIcon.className = 'bi bi-link-45deg';
                        copyLinkBtn.style.color = '';
                    }, 2000);
                });
            });
        }

        // Auto-hide share bar when near very top
        const shareBar = document.getElementById('shareBar');
        if (shareBar) {
            window.addEventListener('scroll', function() {
                if (window.scrollY < 200) {
                    shareBar.classList.add('hide-bar');
                } else {
                    shareBar.classList.remove('hide-bar');
                }
            }, { passive: true });
            // Hide on initial load if at top
            if (window.scrollY < 200) shareBar.classList.add('hide-bar');
        }
    });
</script>

<!-- Highlight.js JS for syntax highlighting -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- Highlight.js additional languages (if needed, core includes popular ones like JS, PHP, Bash) -->
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Find all <pre> tags that Summernote generated
        document.querySelectorAll('.blog-content pre').forEach((block) => {
            // 1. Wrap in code tag if missing
            if (!block.querySelector('code')) {
                const code = document.createElement('code');
                code.innerHTML = block.innerHTML;
                block.innerHTML = '';
                block.appendChild(code);
            }

            // 2. Add wrapper for positioning the copy button
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.margin = '1.5rem 0'; // Move margin to wrapper
            
            // Remove margin from pre to avoid positioning issues
            block.style.margin = '0';
            
            block.parentNode.insertBefore(wrapper, block);
            wrapper.appendChild(block);

            // 3. Create the Copy button
            const button = document.createElement('button');
            button.className = 'btn btn-sm btn-outline-light copy-code-btn';
            button.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
            button.style.position = 'absolute';
            button.style.top = '10px';
            button.style.right = '10px';
            button.style.fontSize = '0.75rem';
            button.style.padding = '0.2rem 0.5rem';
            button.style.opacity = '0.7';
            button.style.transition = 'all 0.3s ease';
            button.style.zIndex = '10'; // Ensure it stays on top
            
            // Hover effect
            wrapper.addEventListener('mouseenter', () => button.style.opacity = '1');
            wrapper.addEventListener('mouseleave', () => button.style.opacity = '0.7');

            // Copy logic
            button.addEventListener('click', () => {
                const codeText = block.querySelector('code').innerText;
                navigator.clipboard.writeText(codeText).then(() => {
                    button.innerHTML = '<i class="bi bi-check2"></i> Copied!';
                    button.classList.replace('btn-outline-light', 'btn-success');
                    button.style.opacity = '1';
                    
                    setTimeout(() => {
                        button.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
                        button.classList.replace('btn-success', 'btn-outline-light');
                        button.style.opacity = '0.7';
                    }, 2000);
                });
            });

            wrapper.appendChild(button);
        });
        
        // Initialize highlight.js on all code blocks
        hljs.highlightAll();
    });
</script>
@endpush
