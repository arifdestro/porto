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
                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" loading="lazy">
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
                <div class="post-meta flex-wrap gap-2">
                    <span class="fw-medium text-body"><i class="bi bi-person-circle me-1"></i> Admin</span>
                    <span class="ms-auto"><i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('d M Y') }}</span>
                    <span class="ms-3 text-secondary"><i class="bi bi-book-half me-1"></i> {{ $readTime }} min read</span>
                </div>
                <div class="mt-2">
                    <a href="{{ route('blog.show', $post->slug) }}#disqus_thread" class="text-secondary text-decoration-none" style="font-size: 0.85rem;"><i class="bi bi-chat-dots me-1"></i>0 Comments</a>
                </div>
            </div>
        </article>
    </div>
@endforeach
