@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs admin-tabs mb-4" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#heroTab" type="button">
                <i class="bi bi-stars me-1"></i> Hero
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#aboutTab" type="button">
                <i class="bi bi-person me-1"></i> About
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contactTab" type="button">
                <i class="bi bi-envelope me-1"></i> Contact
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#generalTab" type="button">
                <i class="bi bi-gear me-1"></i> General
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Hero Settings -->
        <div class="tab-pane fade show active" id="heroTab">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5>Hero Section Settings</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Hero Title</label>
                            <input type="text" class="form-control" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Hero Subtitle</label>
                            <input type="text" class="form-control" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Hero Description</label>
                            <textarea class="form-control" name="hero_description" rows="3">{{ $settings['hero_description'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Image</label>
                            <input type="file" class="form-control" name="hero_image" accept="image/*" onchange="previewImage(this, 'heroPreview')">
                            @if(!empty($settings['hero_image']))
                                <div class="mt-2">
                                    <img src="{{ asset($settings['hero_image']) }}" alt="Current" class="img-thumbnail" id="heroPreview" style="max-height: 150px;">
                                </div>
                            @else
                                <img id="heroPreview" class="img-thumbnail mt-2" style="max-height: 150px; display: none;">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CV / Resume (PDF)</label>
                            <input type="file" class="form-control" name="hero_cv" accept=".pdf,.doc,.docx">
                            @if(!empty($settings['hero_cv']))
                                <div class="mt-2">
                                    <a href="{{ asset($settings['hero_cv']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>View Current CV
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Settings -->
        <div class="tab-pane fade" id="aboutTab">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5>About Section Settings</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">About Title</label>
                            <input type="text" class="form-control" name="about_title" value="{{ $settings['about_title'] ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">About Description</label>
                            <textarea class="form-control" name="about_description" rows="5">{{ $settings['about_description'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">About Image</label>
                            <input type="file" class="form-control" name="about_image" accept="image/*" onchange="previewImage(this, 'aboutPreview')">
                            @if(!empty($settings['about_image']))
                                <div class="mt-2">
                                    <img src="{{ asset($settings['about_image']) }}" alt="Current" class="img-thumbnail" id="aboutPreview" style="max-height: 150px;">
                                </div>
                            @else
                                <img id="aboutPreview" class="img-thumbnail mt-2" style="max-height: 150px; display: none;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="tab-pane fade" id="contactTab">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5>Contact Information</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Settings -->
        <div class="tab-pane fade" id="generalTab">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5>General Settings</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Site Name</label>
                            <input type="text" class="form-control" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">GitHub Username</label>
                            <input type="text" class="form-control" name="github_username" value="{{ $settings['github_username'] ?? '' }}" placeholder="e.g. desfu">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Footer Text</label>
                            <input type="text" class="form-control" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary-custom btn-lg">
            <i class="bi bi-check-lg me-2"></i>Save All Settings
        </button>
    </div>
</form>

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
