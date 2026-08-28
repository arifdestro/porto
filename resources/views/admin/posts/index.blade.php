@extends('layouts.admin')

@section('title', 'Blog Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Manage Blog</h2>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add New Post
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary">
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @if($post->image)
                                        <img src="{{ asset($post->image) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <div class="rounded me-3 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-image text-secondary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($post->title, 40) }}</h6>
                                        <small class="text-muted">{{ Str::limit($post->slug, 40) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($post->is_published)
                                    <span class="badge bg-success bg-opacity-10 text-success">Published</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info"><i class="bi bi-eye"></i> {{ $post->views }}</span>
                            </td>
                            <td>{{ $post->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No blog posts found. <a href="{{ route('admin.posts.create') }}">Create one now</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
