<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tin tức - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.products.index') }}">
                <i class="bi bi-shield-lock"></i> Admin Panel - Tin tức
            </a>
            <div class="d-flex gap-2">
                <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-house"></i> Trang chủ
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box"></i> Sản phẩm
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-receipt"></i> Đơn hàng
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-newspaper"></i> Quản lý Tin tức</h2>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm tin tức mới
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th style="width: 150px;">Slug</th>
                                <th style="width: 100px;">Trạng thái</th>
                                <th style="width: 100px;">Lượt xem</th>
                                <th style="width: 120px;">Ngày tạo</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($news as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/news/default.jpg') }}" 
                                             class="img-thumbnail" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $item->title }}</strong>
                                        @if($item->summary)
                                            <br><small class="text-muted">{{ Str::limit($item->summary, 80) }}</small>
                                        @endif
                                    </td>
                                    <td><code>{{ $item->slug }}</code></td>
                                    <td>
                                        @if($item->published)
                                            <span class="badge bg-success">Công khai</span>
                                        @else
                                            <span class="badge bg-secondary">Nháp</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="bi bi-eye"></i> {{ $item->views ?? 0 }}
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ url('/news/' . $item->slug) }}" 
                                               class="btn btn-outline-info" 
                                               target="_blank"
                                               title="Xem">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.news.edit', $item) }}" 
                                               class="btn btn-outline-primary"
                                               title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $item->id }})"
                                                    title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $item->id }}" 
                                              action="{{ route('admin.news.destroy', $item) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mt-2">Chưa có tin tức nào</p>
                                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Thêm tin tức đầu tiên
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($news->hasPages())
                    <div class="mt-3">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa tin tức này?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</body>
</html>
