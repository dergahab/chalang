@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Səhifələr (Page Builder)</h4>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i> Yeni Səhifə
            </a>
        </div>
    </div>

    <div class="card glass-card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıq</th>
                        <th>Slug (URL)</th>
                        <th>Status</th>
                        <th>Blok Sayı</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td class="fw-bold">{{ $page->title }}</td>
                        <td><code>/{{ $page->slug }}</code></td>
                        <td>
                            @if($page->status == 'published')
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>{{ count($page->content ?? []) }} blok</td>
                        <td>
                            <a href="{{ route('admin.pages.builder', $page->id) }}" class="btn btn-sm btn-purple rounded-pill px-3">
                                <i class="ri-layout-masonry-line me-1"></i> Dizayn Et (Builder)
                            </a>
                            <a href="#" class="btn btn-sm btn-ghost-primary data-edit" data-id="{{ $page->id }}">
                                <i class="ri-settings-3-line"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="ri-pages-line fs-1 mb-3 d-block"></i>
                            Hələ heç bir səhifə yaradılmayıb.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
