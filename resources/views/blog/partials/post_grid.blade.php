@php
    $heroTitle = \App\Models\SiteSetting::get('hero_title', '');
    $authorName = preg_replace('/^(Halo|Hello|Hi),\s*I\'?a?m\s+/i', '', $heroTitle);
    if (empty($authorName)) {
        $admin = \App\Models\User::first();
        $authorName = $admin ? $admin->name : 'Admin Porto';
    }
    $authorImage = \App\Models\SiteSetting::get('hero_image');
@endphp

@foreach($posts as $post)
    <div class="col-md-6 col-lg-4 fade-in">
        @php
            $wordCount = str_word_count(strip_tags($post->content));
            $readTime = ceil($wordCount / 200);
        @endphp
        <article class="post-card glass-card hover-glow position-relative">
            @if($post->views > 5)
                <div class="trending-ribbon">Trending 🔥</div>
            @endif
            <a href="{{ route('blog.show', $post->slug) }}" class="d-block">
                <div class="post-img-wrapper">
                    <span class="post-category bg-primary-gradient text-white">{{ $post->category ?? 'Blog' }}</span>
                    @if($post->image)
                        <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset($post->image) }}" alt="{{ $post->title }}" loading="lazy">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                            <i class="bi bi-terminal text-secondary" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                </div>
            </a>
            <div class="card-body p-4 d-flex flex-column">
                <h3 class="post-title h5">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h3>
                <p class="post-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>
                <div class="post-meta flex-wrap gap-2 align-items-center">
                    <div class="d-flex align-items-center gap-1">
                        @if($authorImage)
                            <img src="{{ str_starts_with($authorImage, 'http') ? $authorImage : asset($authorImage) }}" alt="{{ $authorName }}" style="width: 20px; height: 20px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                        <span class="fw-medium text-body ms-1">{{ $authorName }}</span>
                    </div>
                    <span class="ms-auto"><i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('d M Y') }}</span>
                    <span class="ms-2 text-secondary"><i class="bi bi-book-half me-1"></i> {{ $readTime }} min read</span>
                </div>
                <div class="mt-2">
                    <a href="{{ route('blog.show', $post->slug) }}#disqus_thread" class="text-secondary text-decoration-none" style="font-size: 0.85rem;"><i class="bi bi-chat-dots me-1"></i>0 Comments</a>
                </div>
            </div>
        </article>
    </div>
@endforeach
