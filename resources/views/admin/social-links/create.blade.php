@extends('layouts.admin')
@section('title', 'Add Social Link')
@section('content')
<div class="mb-4"><a href="{{ route('admin.social-links.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Social Links</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h5>New Social Link</h5></div>
    <div class="admin-card-body">
        <form action="{{ route('admin.social-links.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Platform <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('platform') is-invalid @enderror" name="platform" value="{{ old('platform') }}" placeholder="e.g. GitHub" required>
                    @error('platform')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon') }}" placeholder="e.g. github" required>
                    <small class="text-muted">Bootstrap Icon name: github, linkedin, twitter, instagram, facebook, youtube, etc.</small>
                    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">URL <span class="text-danger">*</span></label>
                    <input type="url" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" placeholder="https://..." required>
                    @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary-custom"><i class="bi bi-check-lg me-1"></i> Save Social Link</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
