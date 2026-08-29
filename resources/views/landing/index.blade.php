@extends('layouts.app')

@section('title', $settings['site_name'] ?? 'Porto')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-porto" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand" href="#hero">
            <i class="bi bi-hexagon-fill me-2"></i>{{ $settings['site_name'] ?? 'Porto' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#skills">Skills</a></li>
                <li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>
                <li class="nav-item"><a class="nav-link" href="#experience">Experience</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link text-primary fw-medium" href="{{ route('blog.index') }}">Blog</a></li>
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

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container">
        <div class="row align-items-center align-content-center min-vh-100 pb-5">
            <div class="col-lg-6 hero-content" data-aos="fade-right">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-2 mb-3">
                    <span class="hero-badge">
                        <i class="bi bi-stars me-1"></i> Welcome to my portfolio
                    </span>
                    @if(($settings['available_for_work'] ?? '1') === '1')
                    <span class="available-badge">
                        <span class="available-dot"></span> Available for Work
                    </span>
                    @endif
                </div>
                <h1 class="hero-title">{{ $settings['hero_title'] ?? "Hello, I'm John Doe" }}</h1>
                <p class="hero-subtitle">{{ $settings['hero_subtitle'] ?? 'Full Stack Developer & UI/UX Designer' }}</p>
                <p class="hero-description">{{ $settings['hero_description'] ?? 'I create beautiful and functional web experiences' }}</p>
                <div class="hero-buttons">
                    <a href="#portfolio" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-collection me-2"></i>View My Work
                    </a>
                    <a href="#contact" class="btn btn-outline-custom btn-lg">
                        <i class="bi bi-envelope me-2"></i>Contact Me
                    </a>
                </div>
                <div class="hero-social">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="hero-social-link" title="{{ $link->platform }}">
                            <i class="bi bi-{{ $link->icon }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 hero-image-col" data-aos="fade-left">
                @if(!empty($settings['hero_image']))
                    <div class="hero-image-wrapper">
                        <div class="hero-image-frame">
                            <img src="{{ asset($settings['hero_image']) }}" alt="Hero" class="hero-image" fetchpriority="high">
                        </div>
                        <div class="hero-image-decoration"></div>
                    </div>
                @else
                    <div class="hero-image-wrapper">
                        <div class="hero-image-placeholder">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section-padding bg-light-custom" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="about-image-wrapper">
                    @if(!empty($settings['about_image']))
                        <img src="{{ asset($settings['about_image']) }}" alt="About Me" class="about-image" loading="lazy">
                    @else
                        <div class="about-image-placeholder">
                            <i class="bi bi-person-circle"></i>
                        </div>
                    @endif
                    <div class="about-image-dots"></div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <span class="section-badge">
                    <i class="bi bi-person me-1"></i> Get to know me
                </span>
                <h2 class="section-title">{{ $settings['about_title'] ?? 'About Me' }}</h2>
                <p class="about-text">{{ $settings['about_description'] ?? 'I am a passionate developer.' }}</p>
                @if(!empty($settings['hero_cv']))
                    <a href="{{ asset($settings['hero_cv']) }}" class="btn btn-primary-custom" download>
                        <i class="bi bi-download me-2"></i>Download CV
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section class="section-padding" id="skills">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">
                <i class="bi bi-lightning me-1"></i> What I do
            </span>
            <h2 class="section-title">My Skills</h2>
        </div>
        <div class="row g-4">
            @foreach($skills as $skill)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="skill-card h-100">
                        <div class="skill-card-header">
                            @if($skill->icon)
                                <div class="skill-icon">
                                    <i class="bi bi-{{ $skill->icon }}"></i>
                                </div>
                            @endif
                            <div class="skill-info">
                                <h5 class="skill-name mb-0">{{ $skill->name }}</h5>
                            </div>
                        </div>
                        @if($skill->description)
                            <div class="skill-description mt-3 text-muted" style="font-size: 0.9rem;">
                                {{ $skill->description }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="section-padding bg-light-custom" id="portfolio">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">
                <i class="bi bi-briefcase me-1"></i> My work
            </span>
            <h2 class="section-title">Portfolio</h2>
            <p class="section-subtitle">A selection of projects I've built and shipped</p>
        </div>

        <!-- Filter Buttons -->
        @php
            $categories = $portfolios->pluck('category')->unique()->filter();
        @endphp
        @if($categories->count() > 0)
            <div class="portfolio-filters text-center mb-5" data-aos="fade-up">
                <button class="filter-btn active" data-filter="all">All</button>
                @foreach($categories as $category)
                    <button class="filter-btn" data-filter="{{ \Illuminate\Support\Str::slug($category) }}">{{ $category }}</button>
                @endforeach
            </div>
        @endif

        <div class="row g-4 portfolio-grid" id="portfolioGrid">
            @foreach($portfolios as $index => $portfolio)
                <div class="col-md-6 col-lg-4 portfolio-item {{ $index >= 6 ? 'portfolio-hidden' : '' }}"
                     data-category="{{ \Illuminate\Support\Str::slug($portfolio->category) }}"
                     data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                    <div class="portfolio-card portfolio-modal-trigger"
                         data-title="{{ $portfolio->title }}"
                         data-description="{{ $portfolio->description ?? '' }}"
                         data-image="{{ $portfolio->image ? asset($portfolio->image) : '' }}"
                         data-category="{{ $portfolio->category ?? '' }}"
                         data-link="{{ $portfolio->link ?? '' }}"
                         style="cursor: pointer;">
                        <div class="portfolio-card-image">
                            @if($portfolio->image)
                                <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}" loading="lazy">
                            @else
                                <div class="portfolio-placeholder">
                                    <i class="bi bi-layers"></i>
                                </div>
                            @endif
                            <div class="portfolio-overlay">
                                <div class="portfolio-overlay-content">
                                    <span class="portfolio-view-btn">
                                        <i class="bi bi-eye"></i> Quick View
                                    </span>
                                </div>
                            </div>
                            @if($portfolio->category)
                                <span class="portfolio-badge">{{ $portfolio->category }}</span>
                            @endif
                        </div>
                        <div class="portfolio-card-body">
                            <h5 class="portfolio-title">{{ $portfolio->title }}</h5>
                            @if($portfolio->description)
                                <p class="portfolio-desc">{{ Str::limit($portfolio->description, 90) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($portfolios->count() > 6)
        <div class="text-center mt-5" id="loadMoreWrapper" data-aos="fade-up">
            <button class="btn-load-more" id="portfolioLoadMore">
                <i class="bi bi-grid me-2"></i>
                <span id="loadMoreText">Load More Projects</span>
                <span class="load-more-count">({{ $portfolios->count() - 6 }} more)</span>
            </button>
        </div>
        @endif
    </div>
</section>

<!-- Experience Section -->
<section class="section-padding" id="experience">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">
                <i class="bi bi-clock-history me-1"></i> My journey
            </span>
            <h2 class="section-title">Experience</h2>
            <p class="section-subtitle">Where I've worked and what I've learned along the way</p>
        </div>

        @if($experiences->count() > 0)
        <div class="exp-timeline">
            <div class="exp-line"></div>
            @foreach($experiences as $experience)
            <div class="exp-item {{ $loop->even ? 'exp-right' : 'exp-left' }}" data-aos="fade-{{ $loop->even ? 'left' : 'right' }}">
                <div class="exp-connector"></div>
                <div class="exp-node">
                    <span class="exp-node-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="exp-card">
                    <div class="exp-card-header">
                        <div class="exp-period">
                            <i class="bi bi-calendar-range"></i>
                            {{ $experience->period }}
                        </div>
                        <div class="exp-icon-wrap">
                            <i class="bi bi-building-fill"></i>
                        </div>
                    </div>
                    <h4 class="exp-title">{{ $experience->title }}</h4>
                    <div class="exp-company">
                        <i class="bi bi-geo-alt"></i>
                        {{ $experience->company }}
                    </div>
                    @if($experience->description)
                        <p class="exp-desc">{{ $experience->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-briefcase" style="font-size:3rem; opacity:0.3"></i>
            <p class="mt-3">No experience added yet.</p>
        </div>
        @endif
    </div>
</section>

<!-- GitHub Repos Section -->
@if(isset($settings['github_username']) && $settings['github_username'] != '')
<section class="section-padding bg-light-custom" id="github">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">
                <i class="bi bi-github me-1"></i> Open Source
            </span>
            <h2 class="section-title">GitHub Repositories</h2>
        </div>

        <div class="row g-4 align-items-start">
            {{-- Left: Profile Card --}}
            <div class="col-lg-3 col-md-4" data-aos="fade-right">
                <div class="gh-profile-card" id="gh-profile-card">
                    <div class="gh-loading">
                        <div class="gh-spinner"></div>
                        <span>Loading...</span>
                    </div>
                </div>
            </div>

            {{-- Right: Repo Grid --}}
            <div class="col-lg-9 col-md-8">
                <div class="gh-repos-grid" id="github-repos-container"
                     data-github-username="{{ $settings['github_username'] }}">
                    <div class="gh-loading" style="grid-column:1/-1" id="github-loading">
                        <div class="gh-spinner"></div>
                        <span>Loading repositories...</span>
                    </div>
                </div>

                <div class="text-center mt-4" data-aos="fade-up">
                    <a href="https://github.com/{{ $settings['github_username'] }}" target="_blank" class="btn btn-outline-custom">
                        <i class="bi bi-github me-2"></i>View All on GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Contact Section -->
<section class="section-padding bg-light-custom position-relative" id="contact">
    <!-- Background Decor -->
    <div class="position-absolute top-0 end-0 mt-5 me-5 d-none d-lg-block" style="width: 300px; height: 300px; background: radial-gradient(circle, rgba(37,99,235,0.05) 0%, transparent 70%); border-radius: 50%; z-index: 0;"></div>
    
    <div class="container position-relative" style="z-index: 1;">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">
                <i class="bi bi-envelope me-1"></i> Reach out
            </span>
            <h2 class="section-title">Get In Touch</h2>
            <p class="section-subtitle">Have a project in mind or just want to say hi? I'd love to hear from you.</p>
        </div>

        <div class="row g-5">
            <!-- Left Info Column -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-wrapper">
                    <h3 class="mb-4 fw-bold" style="font-size: 1.8rem; color: var(--dark); letter-spacing: -0.5px;">Let's talk about your next project.</h3>
                    <p class="mb-5 text-muted">Fill out the form and I will get back to you within 24 hours. Or simply reach out via email.</p>

                    <div class="d-flex flex-column gap-4">
                        <div class="contact-item d-flex align-items-center p-3 rounded-4" style="background: var(--white); border: 1px solid var(--border); box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s;">
                            <div class="contact-icon-box me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: rgba(37,99,235,0.1); color: var(--primary); font-size: 1.2rem;">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold text-dark">Email Me</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                    @if(!empty($settings['contact_email']))
                                        <a href="mailto:{{ $settings['contact_email'] }}" class="text-decoration-none text-muted contact-link">{{ $settings['contact_email'] }}</a>
                                    @else
                                        hello@example.com
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="contact-item d-flex align-items-center p-3 rounded-4" style="background: var(--white); border: 1px solid var(--border); box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s;">
                            <div class="contact-icon-box me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: rgba(124,58,237,0.1); color: #7C3AED; font-size: 1.2rem;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold text-dark">Location</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">{{ $settings['contact_address'] ?? 'Jakarta, Indonesia' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="mt-5">
                        <h6 class="fw-bold mb-3 text-dark">Connect with me</h6>
                        <div class="d-flex gap-3">
                            @foreach($socialLinks as $link)
                                <a href="{{ $link->url }}" target="_blank" class="contact-social-btn d-flex align-items-center justify-content-center rounded-circle" title="{{ $link->platform }}" style="width: 45px; height: 45px; background: var(--white); border: 1px solid var(--border); color: var(--text); font-size: 1.1rem; transition: all 0.3s;">
                                    <i class="bi bi-{{ $link->icon }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form-card p-4 p-md-5 rounded-4" style="background: var(--white); border: 1px solid var(--border); box-shadow: 0 20px 40px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
                    <!-- Decorative line -->
                    <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: var(--gradient);"></div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.9rem;">Your Name</label>
                                <input type="text" name="name" class="form-control form-control-lg bg-light-custom border-0 custom-input @error('name') is-invalid @enderror" placeholder="e.g., Andre Ibra" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.9rem;">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light-custom border-0 custom-input @error('email') is-invalid @enderror" placeholder="e.g., andre.ibra@mail.com" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label fw-semibold" style="font-size: 0.9rem;">Subject</label>
                                <input type="text" name="subject" class="form-control form-control-lg bg-light-custom border-0 custom-input @error('subject') is-invalid @enderror" placeholder="e.g., Project Inquiry" value="{{ old('subject') }}" required>
                                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label fw-semibold" style="font-size: 0.9rem;">Message</label>
                                <textarea name="message" class="form-control form-control-lg bg-light-custom border-0 custom-input @error('message') is-invalid @enderror" rows="4" placeholder="e.g., Tell me about your project..." required>{{ old('message') }}</textarea>
                                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                @error('g-recaptcha-response') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-send-fill"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            <div class="col-md-4">
                <div class="footer-brand">
                    <i class="bi bi-hexagon-fill me-2"></i>{{ $settings['site_name'] ?? 'Porto' }}
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0 text-center">
                <div class="footer-social">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" title="{{ $link->platform }}">
                            <i class="bi bi-{{ $link->icon }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0 text-md-end">
                @php
                    $footerText = $settings['footer_text'] ?? '© ' . date('Y') . ' Porto. All rights reserved.';
                    $dynamicFooter = preg_replace('/\b20\d{2}\b/', date('Y'), $footerText);
                @endphp
                <p class="footer-text">{{ $dynamicFooter }}</p>
            </div>
        </div>
    </div>
</footer>

<!-- Portfolio Preview Modal -->
<div class="modal fade" id="portfolioModal" tabindex="-1" aria-labelledby="portfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content portfolio-modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <span class="portfolio-modal-badge" id="modalCategory"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div id="modalImageWrapper" class="portfolio-modal-img-wrap mb-4">
                    <img id="modalImage" src="" alt="" class="portfolio-modal-img">
                    <div id="modalPlaceholder" class="portfolio-modal-placeholder" style="display:none;">
                        <i class="bi bi-layers"></i>
                    </div>
                </div>
                <h3 class="portfolio-modal-title" id="modalTitle"></h3>
                <p class="portfolio-modal-desc" id="modalDescription"></p>
            </div>
            <div class="modal-footer border-0 pt-0 gap-2">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i> Close
                </button>
                <a href="#" id="modalLiveLink" target="_blank" class="btn btn-primary-custom rounded-pill px-4">
                    <i class="bi bi-arrow-up-right me-1"></i> Visit Project
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Back to top" title="Back to top">
    <i class="bi bi-chevron-up"></i>
</button>

@push('scripts')
<script>
    // ===== Dark/Light Mode Toggle =====
    const themeToggle = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;

    // Load saved theme or detect system preference
    function getPreferredTheme() {
        const saved = localStorage.getItem('porto-theme');
        if (saved) return saved;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function setTheme(theme) {
        htmlElement.setAttribute('data-theme', theme);
        htmlElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('porto-theme', theme);
    }

    // Apply theme on load (no flash)
    setTheme(getPreferredTheme());

    // Toggle on click
    themeToggle.addEventListener('click', function() {
        const current = htmlElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        setTheme(next);
    });

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!localStorage.getItem('porto-theme')) {
            setTheme(e.matches ? 'dark' : 'light');
        }
    });

    // ===== Navbar scroll effect & Active Menu Spy =====
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            // Subtract offset to trigger earlier (e.g., when navbar height is considered)
            if (scrollY >= (sectionTop - 120)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                const navCollapse = document.querySelector('.navbar-collapse');
                if (navCollapse.classList.contains('show')) {
                    new bootstrap.Collapse(navCollapse).hide();
                }
            }
        });
    });

    // Scroll reveal animation
    const revealElements = document.querySelectorAll('[data-aos]');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-aos-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('aos-animate');
                }, delay);
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(el => revealObserver.observe(el));

    // Portfolio filter + Load More
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    const loadMoreBtn = document.getElementById('portfolioLoadMore');
    const loadMoreWrapper = document.getElementById('loadMoreWrapper');
    let currentFilter = 'all';
    const PAGE_SIZE = 6;

    function applyFilter(filter) {
        currentFilter = filter;
        let visible = 0;
        portfolioItems.forEach(item => {
            const matchesFilter = filter === 'all' || item.getAttribute('data-category') === filter;
            if (matchesFilter) {
                visible++;
                if (visible <= PAGE_SIZE) {
                    item.style.display = '';
                    item.classList.remove('portfolio-hidden');
                    item.classList.add('aos-animate');
                } else {
                    item.style.display = 'none';
                    item.classList.add('portfolio-hidden');
                }
            } else {
                item.style.display = 'none';
            }
        });

        // Update load more button
        const totalMatchingFilter = Array.from(portfolioItems).filter(item =>
            filter === 'all' || item.getAttribute('data-category') === filter
        ).length;

        if (loadMoreWrapper) {
            if (totalMatchingFilter > PAGE_SIZE) {
                loadMoreWrapper.style.display = '';
                const remaining = totalMatchingFilter - PAGE_SIZE;
                document.getElementById('loadMoreText').textContent = 'Load More Projects';
                document.querySelector('.load-more-count').textContent = `(${remaining} more)`;
            } else {
                loadMoreWrapper.style.display = 'none';
            }
        }
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            applyFilter(this.getAttribute('data-filter'));
        });
    });

    // Load More
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const hiddenItems = Array.from(portfolioItems).filter(item => {
                const matchesFilter = currentFilter === 'all' || item.getAttribute('data-category') === currentFilter;
                return matchesFilter && (item.style.display === 'none' || item.classList.contains('portfolio-hidden'));
            });

            hiddenItems.slice(0, PAGE_SIZE).forEach(item => {
                item.style.display = '';
                item.classList.remove('portfolio-hidden');
                item.classList.add('aos-animate');
            });

            const stillHidden = hiddenItems.slice(PAGE_SIZE).length;
            if (stillHidden === 0 && loadMoreWrapper) {
                loadMoreWrapper.style.display = 'none';
            } else if (loadMoreWrapper) {
                document.querySelector('.load-more-count').textContent = `(${stillHidden} more)`;
            }
        });
    }

    // Init filter on page load
    applyFilter('all');

    // Fetch GitHub Profile
    const ghProfileCard = document.getElementById('gh-profile-card');
    const githubContainer = document.getElementById('github-repos-container');

    const langColors = {
        JavaScript: '#F7DF1E', TypeScript: '#3178C6', PHP: '#777BB4',
        Python: '#3776AB', HTML: '#E34F26', CSS: '#1572B6',
        Vue: '#42B883', Java: '#ED8B00', 'C#': '#239120',
        Ruby: '#CC342D', Go: '#00ADD8', Rust: '#DEA584',
        Kotlin: '#7F52FF', Swift: '#F05138', Dart: '#0175C2'
    };
    function langColor(lang) { return langColors[lang] || '#94A3B8'; }

    if (githubContainer) {
        const username = githubContainer.getAttribute('data-github-username');
        if (username) {

            // Profile
            if (ghProfileCard) {
                fetch(`https://api.github.com/users/${username}`)
                    .then(r => r.json())
                    .then(user => {
                        ghProfileCard.innerHTML = `
                            <img src="${user.avatar_url}" alt="${user.login}" class="gh-avatar" loading="lazy">
                            <div class="gh-profile-info">
                                <h3 class="gh-username">${user.name || user.login}</h3>
                                <p class="gh-login">@${user.login}</p>
                                ${ user.bio ? `<p class="gh-bio">${user.bio}</p>` : '' }
                                <a href="${user.html_url}" target="_blank" class="gh-follow-btn">
                                    <i class="bi bi-github"></i> View on GitHub
                                </a>
                                <div class="gh-meta">
                                    <div class="gh-meta-item">
                                        <i class="bi bi-people-fill"></i>
                                        <span>${user.followers} <small>followers</small></span>
                                        <span class="mx-1">&middot;</span>
                                        <span>${user.following} <small>following</small></span>
                                    </div>
                                    ${ user.location ? `<div class="gh-meta-item"><i class="bi bi-geo-alt-fill"></i><span>${user.location}</span></div>` : '' }
                                    ${ user.public_repos !== undefined ? `<div class="gh-meta-item"><i class="bi bi-journal-code"></i><span>${user.public_repos} public repos</span></div>` : '' }
                                </div>
                            </div>`;
                    })
                    .catch(() => { ghProfileCard.style.display = 'none'; });
            }

            // Repos
            fetch(`https://api.github.com/users/${username}/repos?sort=updated&per_page=6&type=public`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(repos => {
                    const loadingEl = document.getElementById('github-loading');
                    if (loadingEl) loadingEl.remove();
                    if (!repos || repos.length === 0) {
                        githubContainer.innerHTML = '<div class="gh-loading">No public repositories found.</div>';
                        return;
                    }
                    let html = '';
                    repos.slice(0, 6).forEach(repo => {
                        const desc = repo.description
                            ? repo.description.substring(0, 90) + (repo.description.length > 90 ? '…' : '')
                            : '<em style="opacity:0.45">No description</em>';
                        html += `
                        <a href="${repo.html_url}" target="_blank" class="gh-repo-card">
                            <div class="gh-repo-name">${repo.name}</div>
                            <div class="gh-repo-desc">${desc}</div>
                            <div class="gh-repo-stats">
                                <span class="gh-repo-stat"><i class="bi bi-star"></i>${repo.stargazers_count}</span>
                                <span class="gh-repo-stat"><i class="bi bi-diagram-2"></i>${repo.forks_count}</span>
                                ${ repo.language ? `<span class="gh-repo-lang"><span class="lang-dot" style="background:${langColor(repo.language)}"></span>${repo.language}</span>` : '' }
                            </div>
                        </a>`;
                    });
                    githubContainer.innerHTML = html;
                })
                .catch(error => {
                    const loadingEl = document.getElementById('github-loading');
                    if (loadingEl) loadingEl.remove();
                    githubContainer.innerHTML = '<div class="gh-loading" style="color:var(--text-light)">Failed to load repositories.</div>';
                    console.error('Error fetching GitHub repos:', error);
                });
        }
    }
</script>
@endpush
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ── Portfolio Modal ──
        var portfolioModalEl = document.getElementById('portfolioModal');
        if (!portfolioModalEl) return;
        const portfolioModal = new bootstrap.Modal(portfolioModalEl);

        document.querySelectorAll('.portfolio-modal-trigger').forEach(function(card) {
            card.addEventListener('click', function() {
                var title       = this.dataset.title || '';
                var description = this.dataset.description || '';
                var image       = this.dataset.image || '';
                var category    = this.dataset.category || '';
                var link        = this.dataset.link || '';

                document.getElementById('modalTitle').textContent       = title;
                document.getElementById('modalDescription').textContent = description || 'No description provided.';

                var catEl = document.getElementById('modalCategory');
                catEl.textContent   = category;
                catEl.style.display = category ? '' : 'none';

                var modalImg = document.getElementById('modalImage');
                var modalPh  = document.getElementById('modalPlaceholder');
                if (image) {
                    modalImg.src           = image;
                    modalImg.alt           = title;
                    modalImg.style.display = '';
                    modalPh.style.display  = 'none';
                } else {
                    modalImg.style.display = 'none';
                    modalPh.style.display  = '';
                }

                var liveBtn = document.getElementById('modalLiveLink');
                if (link) {
                    liveBtn.href          = link;
                    liveBtn.style.display = '';
                } else {
                    liveBtn.style.display = 'none';
                }

                portfolioModal.show();
            });
        });

        // ── Back to Top ──
        var backToTopBtn = document.getElementById('backToTop');
        if (backToTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 400) {
                    backToTopBtn.classList.add('visible');
                } else {
                    backToTopBtn.classList.remove('visible');
                }
            }, { passive: true });
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>
@endpush
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

