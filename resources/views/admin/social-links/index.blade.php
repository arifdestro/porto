@extends('layouts.admin')
@section('title', 'Social Links')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Drag items to reorder &bull; Changes save automatically</p>
    <a href="{{ route('admin.social-links.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-1"></i> Add New</a>
</div>
<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($socialLinks->count() > 0)
            <div class="sortable-list" id="sortableSocialLinks" data-url="{{ route('admin.social-links.reorder') }}">
                @foreach($socialLinks as $link)
                    <div class="sortable-item" data-id="{{ $link->id }}">
                        <div class="sortable-handle"><i class="bi bi-grip-vertical"></i></div>
                        <div class="sortable-icon-box"><i class="bi bi-{{ $link->icon }}"></i></div>
                        <div class="sortable-content">
                            <h6 class="sortable-title">{{ $link->platform }}</h6>
                            <div class="sortable-meta">
                                <a href="{{ $link->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 250px;">{{ $link->url }}</a>
                                @if($link->is_active)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif
                            </div>
                        </div>
                        <div class="sortable-actions">
                            <a href="{{ route('admin.social-links.edit', $link) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state"><i class="bi bi-share"></i><h5>No social links yet</h5><p>Add your social media profiles.</p><a href="{{ route('admin.social-links.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-1"></i> Add First Link</a></div>
        @endif
    </div>
</div>
<div class="sortable-toast" id="sortableToast"><i class="bi bi-check-circle-fill me-2"></i> Order saved!</div>
@endsection
