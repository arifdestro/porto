@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="stat-icon bg-primary-subtle">
                    <i class="bi bi-briefcase-fill text-primary"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['portfolios'] }}</h3>
                    <p>Portfolios</p>
                </div>
            </div>
            <a href="{{ route('admin.portfolios.index') }}" class="stat-card-footer">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="stat-icon bg-success-subtle">
                    <i class="bi bi-lightning-fill text-success"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['skills'] }}</h3>
                    <p>Skills</p>
                </div>
            </div>
            <a href="{{ route('admin.skills.index') }}" class="stat-card-footer">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="stat-icon bg-warning-subtle">
                    <i class="bi bi-clock-history text-warning"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['experiences'] }}</h3>
                    <p>Experiences</p>
                </div>
            </div>
            <a href="{{ route('admin.experiences.index') }}" class="stat-card-footer">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="stat-icon bg-info-subtle">
                    <i class="bi bi-share-fill text-info"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['social_links'] }}</h3>
                    <p>Social Links</p>
                </div>
            </div>
            <a href="{{ route('admin.social-links.index') }}" class="stat-card-footer">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-info-circle me-2"></i>Quick Start Guide</h5>
            </div>
            <div class="admin-card-body">
                <div class="quick-guide">
                    <div class="guide-item">
                        <span class="guide-step">1</span>
                        <div>
                            <h6>Configure Settings</h6>
                            <p>Update your hero section, about info, and contact details in <a href="{{ route('admin.settings.index') }}">Settings</a>.</p>
                        </div>
                    </div>
                    <div class="guide-item">
                        <span class="guide-step">2</span>
                        <div>
                            <h6>Add Portfolio Items</h6>
                            <p>Showcase your work by adding projects in <a href="{{ route('admin.portfolios.create') }}">Portfolios</a>.</p>
                        </div>
                    </div>
                    <div class="guide-item">
                        <span class="guide-step">3</span>
                        <div>
                            <h6>List Your Skills</h6>
                            <p>Add your technical skills with proficiency levels in <a href="{{ route('admin.skills.create') }}">Skills</a>.</p>
                        </div>
                    </div>
                    <div class="guide-item">
                        <span class="guide-step">4</span>
                        <div>
                            <h6>Add Experience</h6>
                            <p>Share your professional journey in <a href="{{ route('admin.experiences.create') }}">Experiences</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-link-45deg me-2"></i>Quick Links</h5>
            </div>
            <div class="admin-card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-2"></i>View Live Site
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-gear me-2"></i>Site Settings
                    </a>
                    <a href="{{ route('admin.portfolios.create') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-plus-circle me-2"></i>New Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
