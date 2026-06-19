@extends('admin.layouts.main')

@section('heading_title', 'Eksport Cədvəlləri (Scheduling)')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- GOD MODE: Scheduling Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3">
                                    <i class="ri-calendar-event-line"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Cəmi Cədvəl</h6>
                        </div>
                        <h2 class="mb-0 text-primary fw-bold">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3">
                                    <i class="ri-checkbox-circle-line"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Aktiv</h6>
                        </div>
                        <h2 class="mb-0 text-success fw-bold">{{ $stats['active'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-3">
                                    <i class="ri-time-line"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Gözləyən</h6>
                        </div>
                        <h2 class="mb-0 text-warning fw-bold">{{ $stats['pending'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-3">
                                    <i class="ri-error-warning-line"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Uğursuz</h6>
                        </div>
                        <h2 class="mb-0 text-danger fw-bold">{{ $stats['failed'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card glass-card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="ri-list-settings-line me-2 text-primary"></i> 
                    Avtomatlaşdırılmış Eksportlar
                </h5>
                <a href="{{ route('admin.export.schedules.create') }}" class="btn btn-primary px-4 shadow-lg shadow-primary/20" style="border-radius: 12px; background: linear-gradient(135deg, #4b0082, #d500f9); border: none;">
                    <i class="ri-add-line me-1"></i> Yeni Cədvəl
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-4">Model</th>
                                <th>Format</th>
                                <th>Tezlik</th>
                                <th>Növbəti Tarix</th>
                                <th>Son Status</th>
                                <th>Aktivlik</th>
                                <th class="text-end pe-4">Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                {{ substr($schedule->model_type, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $schedule->model_type }}</h6>
                                            <small class="text-muted">{{ $schedule->email_to ?? 'Email təyin edilməyib' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-soft-info text-info px-3">{{ strtoupper($schedule->format) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-soft-purple text-purple px-3">{{ ucfirst($schedule->frequency) }}</span>
                                </td>
                                <td>
                                    @if($schedule->next_run_at)
                                        <span class="small fw-medium">{{ $schedule->next_run_at->format('d.m.Y H:i') }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($schedule->status) {
                                            'completed' => 'success',
                                            'failed' => 'danger',
                                            'running' => 'info',
                                            default => 'warning'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }} rounded-pill px-3">{{ ucfirst($schedule->status) }}</span>
                                </td>
                                <td>
                                    <div class="form-check form-switch shadow-none">
                                        <input class="form-check-input toggle-schedule" type="checkbox" data-id="{{ $schedule->id }}" {{ $schedule->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                        <a href="{{ route('admin.export.schedules.run', $schedule->id) }}" class="btn btn-sm btn-light border-0" title="İndi Çalışdır">
                                            <i class="ri-play-fill text-success"></i>
                                        </a>
                                        <a href="{{ route('admin.export.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-light border-0" title="Redaktə">
                                            <i class="ri-pencil-line text-primary"></i>
                                        </a>
                                        <form action="{{ route('admin.export.schedules.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border-0" onclick="return confirm('Silinsin?')" title="Sil">
                                                <i class="ri-delete-bin-line text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <span class="avatar-title bg-light text-muted rounded-circle fs-1">
                                            <i class="ri-calendar-schedule-line"></i>
                                        </span>
                                    </div>
                                    <h5 class="text-muted">Heç bir cədvəl tapılmadı</h5>
                                    <p class="text-muted mb-4">Məlumatlarınızı avtomatik eksport etmək üçün yeni cədvəl yaradın.</p>
                                    <a href="{{ route('admin.export.schedules.create') }}" class="btn btn-primary px-4">İlk Cədvəli Yarat</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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
.bg-primary-subtle { background: rgba(59, 130, 246, 0.1); }
.bg-success-subtle { background: rgba(34, 197, 94, 0.1); }
.bg-warning-subtle { background: rgba(245, 158, 11, 0.1); }
.bg-danger-subtle { background: rgba(239, 68, 68, 0.1); }
.bg-soft-primary { background: rgba(59, 130, 246, 0.1); }
.bg-soft-info { background: rgba(6, 182, 212, 0.1); }
.bg-soft-purple { background: rgba(168, 85, 247, 0.1); }
.text-purple { color: #a855f7; }
.form-check-input:checked {
    background-color: #22c55e;
    border-color: #22c55e;
}
</style>
@endpush

@push('js_stack')
<script>
$(document).ready(function() {
    $('.toggle-schedule').on('change', function() {
        const id = $(this).data('id');
        const isActive = $(this).is(':checked') ? 1 : 0;
        
        $.ajax({
            url: "{{ route('admin.export.schedules.toggle') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                is_active: isActive
            },
            success: function(response) {
                // Toastr notification can be added here
            },
            error: function() {
                alert('Xəta baş verdi');
                $(this).prop('checked', !isActive);
            }
        });
    });
});
</script>
@endpush