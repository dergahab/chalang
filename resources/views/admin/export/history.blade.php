@extends('admin.layouts.main')

@section('heading_title', 'Eksport Tarixçəsi')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- GOD MODE: Export Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-sm bg-soft-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ri-download-2-line text-primary fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-0">Cəmi Eksport</h6>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ number_format($stats['total']) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-sm bg-soft-success rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ri-list-check-2 text-success fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-0">Çıxarılan Sətir</h6>
                        </div>
                        <h2 class="mb-0 fw-bold text-success">{{ number_format($stats['total_rows'] ?? 0) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card glass-card border-0 shadow-sm h-100 bg-transparent overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="flex-grow-1 p-4">
                            <h5 class="fw-bold mb-1">Məlumat Təhlükəsizliyi</h5>
                            <p class="text-muted small mb-0">Bütün eksport əməliyyatları IP ünvanı və istifadəçi üzrə qeydə alınır.</p>
                        </div>
                        <div class="bg-primary p-4 h-100 d-flex align-items-center" style="background: linear-gradient(135deg, #4b0082, #d500f9) !important;">
                            <i class="ri-shield-check-line text-white display-6"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card glass-card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">MODEL</label>
                        <select name="model" class="form-select border-0 bg-light-subtle shadow-none">
                            <option value="">Hamısı</option>
                            @foreach($models as $m)
                            <option value="{{ $m }}" {{ request('model') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">FORMAT</label>
                        <select name="format" class="form-select border-0 bg-light-subtle shadow-none">
                            <option value="">Bütün Formatlar</option>
                            @foreach($formats as $f)
                            <option value="{{ $f }}" {{ request('format') == $f ? 'selected' : '' }}>{{ strtoupper($f) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">
                            <i class="ri-filter-3-line me-1"></i> Filtrlə
                        </button>
                        <a href="{{ route('admin.export.history') }}" class="btn btn-light px-4 ms-2" style="border-radius: 10px;">
                            <i class="ri-refresh-line me-1"></i> Sıfırla
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card glass-card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Model Türü</th>
                                <th>Fayl Adı</th>
                                <th>Format</th>
                                <th>Sətir Sayı</th>
                                <th>İstifadəçi</th>
                                <th>Tarix</th>
                                <th class="text-end pe-4">Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories as $history)
                            <tr>
                                <td class="ps-4 text-muted fw-medium">#{{ $history->id }}</td>
                                <td><span class="badge bg-soft-primary text-primary px-3">{{ $history->model_type }}</span></td>
                                <td class="fw-bold">{{ $history->file_name }}</td>
                                <td>
                                    @php
                                        $formatClass = match($history->format) {
                                            'xlsx' => 'success',
                                            'csv' => 'info',
                                            'json' => 'warning',
                                            'html' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $formatClass }} px-3">{{ strtoupper($history->format) }}</span>
                                </td>
                                <td>{{ number_format($history->total_rows) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-2">
                                            <span class="avatar-title bg-soft-dark text-dark rounded-circle" style="font-size: 10px;">{{ substr($history->user?->name, 0, 1) }}</span>
                                        </div>
                                        <span>{{ $history->user?->name ?? 'Sistem' }}</span>
                                    </div>
                                </td>
                                <td>{{ $history->created_at?->format('d.m H:i') }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.export.history.download', $history->id) }}" class="btn btn-sm btn-soft-success shadow-none me-1" title="Endir" style="width: 32px; height: 32px; border-radius: 8px;">
                                        <i class="ri-download-cloud-line"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.export.history.destroy', $history->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger shadow-none" onclick="return confirm('Silinsin?')" style="width: 32px; height: 32px; border-radius: 8px;">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="ri-file-history-line display-4 text-muted opacity-25"></i>
                                    <p class="text-muted mt-2">Heç bir eksport tarixi tapılmadı.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($histories->hasPages())
            <div class="card-footer bg-transparent border-top">
                {{ $histories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('css_stack')
<style>
.glass-card {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 16px;
}
.bg-soft-primary { background: rgba(59, 130, 246, 0.1); }
.bg-soft-success { background: rgba(34, 197, 94, 0.1); }
.bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
.bg-soft-dark { background: rgba(15, 23, 42, 0.1); }
.bg-light-subtle { background: rgba(0, 0, 0, 0.02); }
.btn-soft-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: none;
}
.btn-soft-danger:hover {
    background: #ef4444;
    color: #fff;
}
.btn-soft-success {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
    border: none;
}
.btn-soft-success:hover {
    background: #22c55e;
    color: #fff;
}
</style>
@endpush