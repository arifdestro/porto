@extends('layouts.admin')

@section('title', 'Create Blog Post')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Create Blog Post</h2>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Posts
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" placeholder="e.g. Tutorial, Tips, Review">
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Content</label>
                        <textarea name="content" id="summernote" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="admin-card mb-3 bg-body-tertiary">
                        <div class="admin-card-body">
                            <h6 class="card-title fw-bold">Publishing</h6>
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">Publish immediately</label>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card mb-3 bg-body-tertiary">
                        <div class="admin-card-body">
                            <h6 class="card-title fw-bold">Cover Image</h6>
                            <div class="mb-3">
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" id="imagePreviewInput">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <img id="imagePreview" src="" class="img-fluid rounded d-none" alt="Preview">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Excerpt (Short Description)</label>
                        <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="4" placeholder="Brief summary for the blog listing...">{{ old('excerpt') }}</textarea>
                        @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save"></i> Save Post
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your awesome blog post here...',
            tabsize: 2,
            height: 400,
            styleWithSpan: false,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    // Inject dark mode CSS into Summernote's iframe
                    function applyDarkToEditor() {
                        var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                        var $editable = $('.note-editable');
                        if (isDark) {
                            $editable.css({
                                'background-color': '#1a202c',
                                'color': '#e2e8f0'
                            });
                        } else {
                            $editable.css({
                                'background-color': '',
                                'color': ''
                            });
                        }
                    }
                    applyDarkToEditor();
                    // Re-apply when theme toggled
                    document.getElementById('adminThemeToggle') && document.getElementById('adminThemeToggle').addEventListener('click', function() {
                        setTimeout(applyDarkToEditor, 50);
                    });
                },
                onImageUpload: function(files) {
                    let data = new FormData();
                    data.append("file", files[0]);
                    data.append("_token", "{{ csrf_token() }}");
                    
                    $.ajax({
                        url: "{{ route('admin.posts.upload_image') }}",
                        method: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#summernote').summernote('insertImage', response.url);
                        },
                        error: function(xhr) {
                            alert('Failed to upload image. Make sure it is a valid image file and not too large.');
                        }
                    });
                }
            }
        });
        
        // Image preview
        $('#imagePreviewInput').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview').attr('src', event.target.result).removeClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
