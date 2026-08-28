@extends('layouts.admin')
@section('title', 'Add Skill')
@section('content')
<div class="mb-4"><a href="{{ route('admin.skills.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Skills</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h5>New Skill</h5></div>
    <div class="admin-card-body">
        <form action="{{ route('admin.skills.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icon (Bootstrap Icon name)</label>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon') }}" placeholder="e.g. code-slash">
                    <small class="text-muted">See <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></small>
                    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Additional Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" placeholder="Optional brief description of this skill">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary-custom"><i class="bi bi-check-lg me-1"></i> Save Skill</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
