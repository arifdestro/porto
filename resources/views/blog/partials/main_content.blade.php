        @if($posts->count() > 0)
            @php 
                $featured = $posts->first(); 
                $remainingPosts = $posts->slice(1);
            @endphp
            
            <!-- Featured Post -->
            <div class="row mb-5 fade-in">
                <div class="col-12">
                    <div class="featured-post-card glass-card hover-glow d-flex flex-column flex-lg-row">
                        <div class="col-lg-7 p-0">
                            <a href="{{ route('blog.show', $featured->slug) }}" class="d-block h-100">
                                <div class="post-img-wrapper h-100" style="min-height: 300px;">
                                    <span class="post-category bg-primary-gradient text-white">{{ $featured->category ?? 'Terbaru' }}</span>
                                    @if($featured->image)
                                        <img src="{{ str_starts_with($featured->image, 'http') ? $featured->image : asset($featured->image) }}" alt="{{ $featured->title }}">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                            <i class="bi bi-code-slash text-secondary" style="font-size: 5rem;"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-5 p-4 p-lg-5 d-flex flex-column justify-content-center">
                            <h2 class="post-title featured-title">
                                <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                            </h2>
                            <p class="post-excerpt" style="font-size: 1.1rem;">{{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 150) }}</p>
                            <div class="post-meta mt-auto">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="author-avatar"><i class="bi bi-person-fill"></i></div>
                                    <span class="fw-medium text-body">Admin</span>
                                </div>
                                <span class="ms-auto"><i class="bi bi-calendar3 me-1"></i> {{ $featured->created_at->format('d M Y') }}</span>
                                <span><i class="bi bi-eye me-1"></i> {{ $featured->views }}</span>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('blog.show', $featured->slug) }}#disqus_thread" class="text-secondary text-decoration-none" style="font-size: 0.85rem;"><i class="bi bi-chat-dots me-1"></i>0 Comments</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Posts -->
            <div id="post-grid" class="row g-4">
                @include('blog.partials.post_grid', ['posts' => $remainingPosts])
            </div>

            @if($posts->hasMorePages())
            <div class="d-flex justify-content-center mt-5" id="loadMoreContainer">
                <button class="load-more-btn" id="loadMoreBtn" data-next-page="{{ $posts->currentPage() + 1 }}">
                    <i class="bi bi-arrow-clockwise me-2" id="loadMoreIcon"></i>Load More Articles
                </button>
            </div>
            @endif
        @else
            <div class="text-center py-5 my-5">
                <i class="bi bi-journal-code text-muted mb-3" style="font-size: 5rem;"></i>
                <h3 class="text-secondary fw-bold">Belum Ada Artikel</h3>
                <p class="text-muted">Nantikan artikel dan tutorial menarik seputar teknologi di sini.</p>
            </div>
        @endif
