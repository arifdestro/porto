@extends('layouts.admin')

@section('title', 'Edit Profile')

@push('styles')
<style>
.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 32px;
}

.profile-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), #7C3AED);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(37,99,235,0.35);
}

.profile-meta h2 {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 4px;
    color: var(--dark);
}

[data-theme="dark"] .profile-meta h2 {
    color: #F1F5F9;
}

.profile-meta p {
    font-size: 0.9rem;
    color: var(--text-light);
    margin: 0;
}

.profile-card {
    background: var(--white);
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden;
    margin-bottom: 24px;
    border: 1px solid var(--border);
}

[data-theme="dark"] .profile-card {
    background: #1E293B;
    border-color: rgba(255,255,255,0.07);
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
}

.profile-card-header {
    padding: 20px 28px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 12px;
}

[data-theme="dark"] .profile-card-header {
    border-color: rgba(255,255,255,0.07);
}

.profile-card-header .card-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.card-icon-blue {
    background: rgba(37,99,235,0.12);
    color: var(--primary);
}

.card-icon-purple {
    background: rgba(124,58,237,0.12);
    color: #7C3AED;
}

.profile-card-header h3 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0;
    color: var(--dark);
}

[data-theme="dark"] .profile-card-header h3 {
    color: #F1F5F9;
}

.profile-card-header p {
    font-size: 0.82rem;
    color: var(--text-light);
    margin: 0;
}

.profile-card-body {
    padding: 28px;
}

.profile-form .form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 6px;
}

[data-theme="dark"] .profile-form .form-label {
    color: #CBD5E1;
}

.profile-form .form-control {
    border-radius: 10px;
    border: 1.5px solid var(--border);
    padding: 11px 14px;
    font-size: 0.9rem;
    background: var(--light-bg);
    color: var(--dark);
    transition: all 0.2s;
}

[data-theme="dark"] .profile-form .form-control {
    background: rgba(15,23,42,0.5);
    border-color: rgba(255,255,255,0.1);
    color: #F1F5F9;
}

.profile-form .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
    background: var(--white);
}

[data-theme="dark"] .profile-form .form-control:focus {
    background: #0F172A;
}

.btn-profile-save {
    background: linear-gradient(135deg, var(--primary), #2563EB);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 11px 28px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-profile-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37,99,235,0.3);
    color: white;
}

.btn-profile-password {
    background: linear-gradient(135deg, #7C3AED, #6D28D9);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 11px 28px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-profile-password:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(124,58,237,0.3);
    color: white;
}

.password-toggle-btn {
    cursor: pointer;
    background: none;
    border: none;
    color: var(--text-light);
    padding: 0 12px;
}

.password-toggle-btn:hover {
    color: var(--primary);
}

.success-inline {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    background: rgba(16,185,129,0.1);
    border: 1px solid rgba(16,185,129,0.25);
    border-radius: 10px;
    color: #059669;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 20px;
}

[data-theme="dark"] .success-inline {
    background: rgba(16,185,129,0.15);
    color: #34D399;
}
</style>
@endpush

@section('content')

{{-- Profile Header --}}
<div class="profile-header">
    <div class="profile-avatar">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>
    <div class="profile-meta">
        <h2>{{ Auth::user()->name }}</h2>
        <p>{{ Auth::user()->email }}</p>
    </div>
</div>

<div class="row g-4">
    {{-- Info Form --}}
    <div class="col-lg-6">
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="card-icon card-icon-blue">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h3>Account Information</h3>
                    <p>Update your name and email address</p>
                </div>
            </div>
            <div class="profile-card-body">
                @if(session('success_info'))
                    <div class="success-inline">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success_info') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile.update-info') }}" class="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', Auth::user()->name) }}"
                               placeholder="Your full name"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email', Auth::user()->email) }}"
                               placeholder="you@example.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-profile-save">
                        <i class="bi bi-check-lg"></i>
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Password Form --}}
    <div class="col-lg-6">
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="card-icon card-icon-purple">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <h3>Change Password</h3>
                    <p>Make sure to use a strong password</p>
                </div>
            </div>
            <div class="profile-card-body">
                @if(session('success_password'))
                    <div class="success-inline">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success_password') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile.update-password') }}" class="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password"
                                   name="current_password"
                                   placeholder="••••••••"
                                   required>
                            <button class="password-toggle-btn input-group-text" type="button" onclick="togglePassword('current_password')">
                                <i class="bi bi-eye" id="icon_current_password"></i>
                            </button>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Min. 8 characters"
                                   required>
                            <button class="password-toggle-btn input-group-text" type="button" onclick="togglePassword('password')">
                                <i class="bi bi-eye" id="icon_password"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Repeat new password"
                                   required>
                            <button class="password-toggle-btn input-group-text" type="button" onclick="togglePassword('password_confirmation')">
                                <i class="bi bi-eye" id="icon_password_confirmation"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-profile-password">
                        <i class="bi bi-shield-check"></i>
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById('icon_' + fieldId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
@endpush
