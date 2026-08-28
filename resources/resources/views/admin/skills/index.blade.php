@extends('layouts.admin')
@section('title', 'Skills')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Drag items to reorder &bull; Changes save automatically</p>
    <a href="{{ route('admin.skills.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-1"></i> Add New</a>
</div>
<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($skills->count() > 0)
            <div class="sortable-list" id="sortableSkills" data-url="{{ route('admin.skills.reorder') }}">
                @foreach($skills as $skill)
                    <div class="sortable-item" data-id="{{ $skill->id }}">
                        <div class="sortable-handle"><i class="bi bi-grip-vertical"></i></div>
                        <div class="sortable-icon-box">
                            @if($skill->icon)<i class="bi bi-{{ $skill->icon }}"></i>@else<i class="bi bi-lightning"></i>@endif
                        </div>
                        <div class="sortable-content">
                            <h6 class="sortable-title">{{ $skill->name }}</h6>
                            <div class="d-flex align-items-center gap-2">
                                @if($skill->is_active)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif
                            </div>
                        </div>
                        <div class="sortable-actions">
                            <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state"><i class="bi bi-lightning"></i><h5>No skills yet</h5><p>Add your skills to showcase your expertise.</p><a href="{{ route('admin.skills.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-1"></i> Add First Skill</a></div>
        @endif
    </div>
</div>
<div class="sortable-toast" id="sortableToast"><i class="bi bi-check-circle-fill me-2"></i> Order saved!</div>
@endsection
