@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card glass-card">
                <div class="card-header border-0 pb-0">
                    <h5 class="card-title">Yeni Səhifə Yarat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Səhifə Başlığı</label>
                            <input type="text" name="title" class="form-control" placeholder="Məs: Yeni Xidmətlər" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted">/</span>
                                <input type="text" name="slug" class="form-control" placeholder="yeni-xidmetler" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost-secondary me-2">Ləğv et</a>
                            <button type="submit" class="btn btn-primary">Yarat və Dizayn Et <i class="ri-arrow-right-line ms-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
