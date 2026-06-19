@extends('admin.layouts.main')

@section('heading_title', 'İmport Tarixçəsi')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card glass-card">
                    <div class="card-body text-center">
                        <div class="fs-1 text-primary">{{ $stats['total'] }}</div>
                        <div class="text-muted">Cəmi İmport</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card glass-card">
                    <div class="card-body text-center">
                        <div class="fs-1 text-warning">{{ $stats['pending'] }}</div>
                        <div class="text-muted">Gözləyən</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card glass-card">
                    <div class="card-body text-center">
                        <div class="fs-1 text-info">{{ $stats['processing'] }}</div>
                        <div class="text-muted">İşləyir</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card glass-card">
                    <div class="card-body text-center">
                        <div class="fs-1 text-success">{{ $stats['completed'] }}</div>
                        <div class="text-muted">Tamamlanan</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card glass-card">
                    <div class="card-body text-center">
                        <div class="fs-1 text-danger">{{ $stats['failed'] }}</div>
                        <div class="text-muted">Failed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card glass-card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <select name="model" class="form-control">
                            <option value="">Model seçin</option>
                            @foreach($models as $m)
                            <option value="{{ $m }}" {{ request('model') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filtrlə</button>
                        <a href="{{ route('admin.import.history') }}" class="btn btn-secondary">Sıfırla</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Table -->
        <div class="card glass-card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Model</th>
                            <th>Fayl</th>
                            <th>Satır</th>
                            <th>Yaradılan</th>
                            <th>Yenilənən</th>
                            <th>Xəta</th>
                            <th>Status</th>
                            <th>İstifadəçi</th>
                            <th>Tarix</th>
                            <th>Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                        <tr>
                            <td>#{{ $history->id }}</td>
                            <td><span class="badge bg-primary">{{ $history->model_type }}</span></td>
                            <td>{{ $history->file_name ?? '-' }}</td>
                            <td>{{ $history->total_rows }}</td>
                            <td><span class="text-success">+{{ $history->created_rows }}</span></td>
                            <td><span class="text-info">~{{ $history->updated_rows }}</span></td>
                            <td><span class="text-danger">{{ $history->failed_rows }}</span></td>
                            <td>
                                @switch($history->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Gözləyir</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-info">İşləyir</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Tamamlanıb</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Failed</span>
                                        @break
                                    @case('rolled_back')
                                        <span class="badge bg-secondary">Geri qaytarılıb</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $history->user?->name ?? '-' }}</td>
                            <td>{{ $history->created_at?->format('d.m H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.import.history.show', $history->id) }}" class="btn btn-sm btn-info">
                                    <i class="ri-eye-line"></i>
                                </a>
                                @if($history->status === 'completed')
                                <form method="POST" action="{{ route('admin.import.history.rollback', $history->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Geri qaytarılssın?')">
                                        <i class="ri-arrow-go-back-line"></i>
                                    </button>
                                </form>
                                @endif
                                @if($history->status === 'failed')
                                <a href="{{ route('admin.import.history.retry', $history->id) }}" class="btn btn-sm btn-success">
                                    <i class="ri-refresh-line"></i>
                                </a>
                                @endif
                                <form method="POST" action="{{ route('admin.import.history.destroy', $history->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Silinsin?')">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">İmport tarixçəsi yoxdur</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('css_stack')
<style>
.glass-card {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.05);
}
</style>
@endpush