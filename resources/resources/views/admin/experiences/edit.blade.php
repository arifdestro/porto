@extends('layouts.admin')
@section('title', 'Edit Experience')
@section('content')
<div class="mb-4"><a href="{{ route('admin.experiences.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Experiences</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h5>Edit: {{ $experience->title }}</h5></div>
    <div class="admin-card-body">
        <form action="{{ route('admin.experiences.update', $experience) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Job Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $experience->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Company <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company', $experience->company) }}" required>
                    @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Period <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('period') is-invalid @enderror" name="period" value="{{ old('period', $experience->period) }}" required>
                    @error('period')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $experience->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $experience->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary-custom"><i class="bi bi-check-lg me-1"></i> Update Experience</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
