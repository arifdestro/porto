@extends('layouts.admin')
@section('title', 'Add Experience')
@section('content')
<div class="mb-4"><a href="{{ route('admin.experiences.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Experiences</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h5>New Experience</h5></div>
    <div class="admin-card-body">
        <form action="{{ route('admin.experiences.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Job Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Company <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}" required>
                    @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Period <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('period') is-invalid @enderror" name="period" value="{{ old('period') }}" placeholder="e.g. Jan 2022 - Present" required>
                    @error('period')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary-custom"><i class="bi bi-check-lg me-1"></i> Save Experience</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
