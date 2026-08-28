@extends('layouts.admin')
@section('title', 'Edit Social Link')
@section('content')
<div class="mb-4"><a href="{{ route('admin.social-links.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Social Links</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h5>Edit: {{ $socialLink->platform }}</h5></div>
    <div class="admin-card-body">
        <form action="{{ route('admin.social-links.update', $socialLink) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Platform <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('platform') is-invalid @enderror" name="platform" value="{{ old('platform', $socialLink->platform) }}" required>
                    @error('platform')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon', $socialLink->icon) }}" required>
                    <small class="text-muted">Bootstrap Icon name: github, linkedin, twitter, instagram, facebook, youtube, etc.</small>
                    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">URL <span class="text-danger">*</span></label>
                    <input type="url" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url', $socialLink->url) }}" required>
                    @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $socialLink->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary-custom"><i class="bi bi-check-lg me-1"></i> Update Social Link</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
