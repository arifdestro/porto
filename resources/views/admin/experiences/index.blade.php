@extends('layouts.admin')
@section('title', 'Experiences')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Drag items to reorder &bull; Changes save automatically</p>
    <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-1"></i> Add New</a>
</div>
<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($experiences->count() > 0)
            <div class="sortable-list" id="sortableExperiences" data-url="{{ route('admin.experiences.reorder') }}">
                @foreach($experiences as $experience)
                    <div class="sortable-item" data-id="{{ $experience->id }}">
                        <div class="sortable-handle"><i class="bi bi-grip-vertical"></i></div>
                        <div class="sortable-icon-box"><i class="bi bi-building"></i></div>
                        <div class="sortable-content">
                            <h6 class="sortable-title">{{ $experience->title }}</h6>
                            <div class="sortable-meta">
                                <span class="text-muted"><i class="bi bi-building me-1"></i>{{ $experience->company }}</span>
                                <span class="badge bg-light text-dark">{{ $experience->period }}</span>
                                @if($experience->is_active)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif
                            </div>
                        </div>
                        <div class="sortable-actions">
                            <a href="{{ route('admin.experiences.edit', $experience) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state"><i class="bi bi-clock-history"></i><h5>No experiences yet</h5><p>Add your work experience to showcase your journey.</p><a href="{{ route('admin.experiences.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-1"></i> Add First Experience</a></div>
        @endif
    </div>
</div>
<div class="sortable-toast" id="sortableToast"><i class="bi bi-check-circle-fill me-2"></i> Order saved!</div>
@endsection
