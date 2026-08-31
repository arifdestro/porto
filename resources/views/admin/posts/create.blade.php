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
        // Custom "Insert Code" button for Summernote
        var InsertCodeButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="bi bi-code-slash"></i> Code',
                tooltip: 'Insert Code Block',
                click: function() {
                    // Build language options
                    var languages = [
                        'javascript', 'php', 'python', 'bash', 'html', 'css',
                        'java', 'csharp', 'cpp', 'go', 'ruby', 'sql', 'json',
                        'typescript', 'xml', 'yaml', 'markdown', 'dart', 'kotlin', 'swift'
                    ];
                    var optionsHTML = languages.map(function(lang) {
                        return '<option value="' + lang + '">' + lang.charAt(0).toUpperCase() + lang.slice(1) + '</option>';
                    }).join('');

                    // Create modal
                    var $modal = $(`
                        <div class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="background: #1a202c; color: #e2e8f0; border: 1px solid #4a5568;">
                                    <div class="modal-header border-bottom" style="border-color: #4a5568 !important;">
                                        <h5 class="modal-title"><i class="bi bi-code-slash me-2"></i>Insert Code Block</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Programming Language</label>
                                            <select class="form-select" id="codeLanguageSelect" style="background: #2d3748; color: #e2e8f0; border-color: #4a5568;">
                                                ${optionsHTML}
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Paste your code here</label>
                                            <textarea class="form-control" id="codeContentArea" rows="12" 
                                                style="background: #282c34; color: #abb2bf; border-color: #4a5568; font-family: 'Consolas', monospace; font-size: 0.9rem; tab-size: 4;"
                                                placeholder="Paste your code here..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top" style="border-color: #4a5568 !important;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="insertCodeBtn">
                                            <i class="bi bi-plus-lg me-1"></i>Insert Code
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                    $('body').append($modal);
                    var modal = new bootstrap.Modal($modal[0]);
                    modal.show();

                    // Handle Tab key in textarea
                    $modal.find('#codeContentArea').on('keydown', function(e) {
                        if (e.key === 'Tab') {
                            e.preventDefault();
                            var start = this.selectionStart;
                            var end = this.selectionEnd;
                            this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
                            this.selectionStart = this.selectionEnd = start + 4;
                        }
                    });

                    // Insert Code button click
                    $modal.find('#insertCodeBtn').on('click', function() {
                        var lang = $modal.find('#codeLanguageSelect').val();
                        var code = $modal.find('#codeContentArea').val();
                        if (code.trim()) {
                            // Escape HTML entities
                            var escaped = code
                                .replace(/&/g, '&amp;')
                                .replace(/</g, '&lt;')
                                .replace(/>/g, '&gt;')
                                .replace(/"/g, '&quot;');
                            var html = '<pre><code class="language-' + lang + '">' + escaped + '</code></pre><p><br></p>';
                            context.invoke('editor.pasteHTML', html);
                        }
                        modal.hide();
                    });

                    // Cleanup on close
                    $modal.on('hidden.bs.modal', function() {
                        $modal.remove();
                    });
                }
            });
            return button.render();
        };

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
                ['code', ['insertCode']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            buttons: {
                insertCode: InsertCodeButton
            },
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
