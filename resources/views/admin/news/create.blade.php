<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tin tức - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.news.index') }}">
                <i class="bi bi-newspaper"></i> Thêm Tin tức Mới
            </a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-bold">Tiêu đề <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title') }}" 
                                       required
                                       placeholder="Nhập tiêu đề tin tức">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Tóm tắt</label>
                                <textarea name="summary" 
                                          class="form-control @error('summary') is-invalid @enderror" 
                                          rows="3"
                                          placeholder="Nhập tóm tắt ngắn gọn về tin tức (tùy chọn)">{{ old('summary') }}</textarea>
                                @error('summary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Hiển thị trong danh sách tin tức</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                                <textarea name="content" 
                                          class="form-control @error('content') is-invalid @enderror" 
                                          rows="15"
                                          required
                                          placeholder="Nhập nội dung chi tiết tin tức">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Hình ảnh đại diện</label>
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Chọn ảnh JPG, PNG, GIF (tối đa 2MB)</small>
                                
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" 
                                           name="published" 
                                           class="form-check-input" 
                                           id="published"
                                           {{ old('published', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="published">
                                        Công khai tin tức
                                    </label>
                                </div>
                                <small class="text-muted">Bỏ chọn để lưu dưới dạng nháp</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Tạo tin tức
                                </button>
                                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>
</body>
</html>
