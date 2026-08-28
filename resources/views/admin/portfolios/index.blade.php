@extends('layouts.admin')

@section('title', 'Portfolios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Drag items to reorder &bull; Changes save automatically</p>
    <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-1"></i> Add New
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($portfolios->count() > 0)
            <div class="sortable-list" id="sortablePortfolios" data-url="{{ route('admin.portfolios.reorder') }}">
                @foreach($portfolios as $portfolio)
                    <div class="sortable-item" data-id="{{ $portfolio->id }}">
                        <div class="sortable-handle">
                            <i class="bi bi-grip-vertical"></i>
                        </div>
                        <div class="sortable-thumb">
                            @if($portfolio->image)
                                <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}">
                            @else
                                <div class="sortable-thumb-placeholder"><i class="bi bi-image"></i></div>
                            @endif
                        </div>
                        <div class="sortable-content">
                            <h6 class="sortable-title">{{ $portfolio->title }}</h6>
                            <div class="sortable-meta">
                                <span class="badge bg-light text-dark">{{ $portfolio->category ?? 'Uncategorized' }}</span>
                                @if($portfolio->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="sortable-actions">
                            <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-briefcase"></i>
                <h5>No portfolios yet</h5>
                <p>Start adding your portfolio items to showcase your work.</p>
                <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary-custom">
                    <i class="bi bi-plus-lg me-1"></i> Add First Portfolio
                </a>
            </div>
        @endif
    </div>
</div>

<div class="sortable-toast" id="sortableToast">
    <i class="bi bi-check-circle-fill me-2"></i> Order saved!
</div>
@endsection
