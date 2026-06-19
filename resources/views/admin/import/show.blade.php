@extends('admin.layouts.main')

@section('heading_title', 'İmport Detalları #' . $history->id)

@section('content')
<div class="row" id="import-details-container" data-history-id="{{ $history->id }}" data-status="{{ $history->status }}">
    <div class="col-md-6">
        <div class="card glass-card h-100">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <i class="ri-information-line me-2 text-primary fs-20"></i>
                <h5 class="mb-0">Ümumi Məlumat</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Model Türü</span>
                        <span class="badge bg-soft-primary text-primary px-3">{{ $history->model_type }}</span>
                    </div>
                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Fayl Adı</span>
                        <span class="fw-bold">{{ $history->file_name ?? '-' }}</span>
                    </div>
                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Status</span>
                        <div id="status-badge-container">
                            @php
                                $statusClass = match($history->status) {
                                    'completed' => 'success',
                                    'failed' => 'danger',
                                    'processing' => 'info',
                                    'rolled_back' => 'secondary',
                                    default => 'warning'
                                };
                                $statusText = match($history->status) {
                                    'completed' => 'Tamamlanıb',
                                    'failed' => 'Uğursuz',
                                    'processing' => 'İşlənir...',
                                    'rolled_back' => 'Geri Qaytarılıb',
                                    default => 'Gözləyir'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }} px-3 py-2 status-badge">
                                <i class="ri-loader-4-line spinner d-none me-1"></i> {{ $statusText }}
                            </span>
                        </div>
                    </div>
                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">İstifadəçi</span>
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs me-2">
                                <span class="avatar-title bg-soft-dark text-dark rounded-circle" style="font-size: 10px;">{{ substr($history->user?->name, 0, 1) }}</span>
                            </div>
                            <span>{{ $history->user?->name ?? 'Sistem' }}</span>
                        </div>
                    </div>
                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">IP Ünvanı</span>
                        <code class="text-primary">{{ $history->ip_address ?? '-' }}</code>
                    </div>
                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-0">
                        <span class="text-muted">Tarix</span>
                        <span class="text-muted small">{{ $history->created_at?->format('d.m.Y H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card glass-card h-100 shadow-lg border-0" id="stats-card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="ri-bar-chart-2-line me-2 text-success"></i> Statistika</h5>
                <span id="live-indicator" class="badge bg-soft-success text-success pulse d-none">LIVE</span>
            </div>
            <div class="card-body">
                <div class="row g-4 text-center mb-4">
                    <div class="col-4">
                        <div class="p-3 rounded-3 bg-light-subtle">
                            <h3 class="mb-1 fw-bold text-primary" id="stat-total">{{ number_format($history->total_rows) }}</h3>
                            <p class="text-muted small mb-0">CƏMİ</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-3 bg-light-subtle">
                            <h3 class="mb-1 fw-bold text-success" id="stat-created">+{{ number_format($history->created_rows) }}</h3>
                            <p class="text-muted small mb-0">YARADILAN</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-3 bg-light-subtle">
                            <h3 class="mb-1 fw-bold text-info" id="stat-updated">~{{ number_format($history->updated_rows) }}</h3>
                            <p class="text-muted small mb-0">YENİLƏNƏN</p>
                        </div>
                    </div>
                </div>

                <div class="progress-container mb-4">
                    <div class="d-flex justify-content-between mb-2 small fw-bold">
                        <span>Ümumi Tərəqqi</span>
                        <span id="progress-percent">{{ $history->total_rows > 0 ? round(($history->created_rows + $history->updated_rows + $history->failed_rows) / $history->total_rows * 100) : 0 }}%</span>
                    </div>
                    <div class="progress" style="height: 12px; border-radius: 6px; background: rgba(0,0,0,0.05);">
                        <div id="progress-bar-created" class="progress-bar bg-success" style="width: {{ $history->total_rows > 0 ? ($history->created_rows / $history->total_rows * 100) : 0 }}%"></div>
                        <div id="progress-bar-updated" class="progress-bar bg-info" style="width: {{ $history->total_rows > 0 ? ($history->updated_rows / $history->total_rows * 100) : 0 }}%"></div>
                        <div id="progress-bar-failed" class="progress-bar bg-danger" style="width: {{ $history->total_rows > 0 ? ($history->failed_rows / $history->total_rows * 100) : 0 }}%"></div>
                    </div>
                    <div class="d-flex gap-3 mt-2 small text-muted">
                        <span><i class="ri-checkbox-blank-circle-fill text-success me-1"></i> Yeni</span>
                        <span><i class="ri-checkbox-blank-circle-fill text-info me-1"></i> Update</span>
                        <span><i class="ri-checkbox-blank-circle-fill text-danger me-1"></i> Xəta</span>
                    </div>
                </div>

                <div class="success-rate-box p-3 rounded-3 text-center" style="background: rgba(75, 0, 130, 0.03); border: 1px dashed rgba(75, 0, 130, 0.1);">
                    <h5 class="mb-1">Uğur Dərəcəsi</h5>
                    <div class="display-6 fw-bold text-dark" id="stat-rate">{{ $history->success_rate }}%</div>
                </div>
            </div>
        </div>
    </div>

    <!-- GOD MODE: Live Log Console -->
    <div class="col-12 mt-4">
        <div class="card glass-card border-0 shadow-lg overflow-hidden" style="background: rgba(0,0,0,0.4);">
            <div class="card-header border-bottom border-white-10 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white d-flex align-items-center">
                    <i class="ri-terminal-box-line me-2 text-info"></i> Live System Console
                </h5>
                <div class="d-flex gap-2">
                    <span class="badge bg-soft-success text-success d-none" id="console-status">CONNECTED</span>
                    <div class="dot bg-success rounded-circle" style="width: 10px; height: 10px; box-shadow: 0 0 10px #22c55e;"></div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="log-console" class="p-3" style="height: 300px; overflow-y: auto; font-family: 'Fira Code', monospace; font-size: 13px; color: #a5b4fc; background: #0f172a;">
                    <div class="log-entry mb-1"><span class="text-white-50">[{{ date('H:i:s') }}]</span> <span class="text-info">System:</span> Konsol işə salındı...</div>
                    <div class="log-entry mb-1"><span class="text-white-50">[{{ date('H:i:s') }}]</span> <span class="text-info">System:</span> {{ $history->model_type }} modeli üçün import məlumatları oxunur...</div>
                    @if($history->status === 'completed')
                    <div class="log-entry mb-1"><span class="text-white-50">[{{ $history->completed_at?->format('H:i:s') }}]</span> <span class="text-success">Success:</span> İmport uğurla tamamlandı.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@if($history->errors)
<div class="col-12 mt-4" id="errors-container">
        <div class="card glass-card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-danger text-white py-3">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="ri-error-warning-line me-2"></i> Qeydə Alınmış Xətalar
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="alert alert-soft-danger border-0 rounded-0 mb-0">
                    <pre class="mb-0 text-danger fw-medium" style="white-space: pre-wrap; font-family: 'Courier New', Courier, monospace;">{!! json_encode($history->errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}</pre>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="mt-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('admin.import.history') }}" class="btn btn-light px-4" style="border-radius: 10px;">
            <i class="ri-arrow-left-line me-2"></i> Tarixçəyə Qayıt
        </a>
    </div>
    
    <div class="d-flex gap-2">
        @if($history->canRollback())
        <form method="POST" action="{{ route('admin.import.history.rollback', $history->id) }}" class="d-inline" id="rollback-form">
            @csrf
            <div class="input-group">
                <input type="text" name="note" placeholder="Rollback səbəbi..." class="form-control" style="width: 200px; border-radius: 10px 0 0 10px;">
                <button type="submit" class="btn btn-warning px-4 shadow-sm" style="border-radius: 0 10px 10px 0;" onclick="return confirm('BU ƏMƏLİYYAT GERİ QAYTARILA BİLMƏZ! İmport zamanı yaradılan bütün yazılar silinəcək. Davam edilsin?')">
                    <i class="ri-arrow-go-back-line me-2"></i> Geri Qaytar (Rollback)
                </button>
            </div>
        </form>
        @endif

        @if($history->status === 'failed')
        <a href="{{ route('admin.import.history.retry', $history->id) }}" class="btn btn-success px-4 shadow-sm" style="border-radius: 10px;">
            <i class="ri-refresh-line me-2"></i> Yenidən Cəhd Et (Retry)
        </a>
        @endif
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
.pulse {
    animation: pulse-animation 2s infinite;
}
@keyframes pulse-animation {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
.spinner {
    animation: rotate 1s linear infinite;
    display: inline-block;
}
@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endpush

@push('js_stack')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const historyId = document.getElementById('import-details-container').dataset.historyId;
    let currentStatus = document.getElementById('import-details-container').dataset.status;

    if (currentStatus === 'processing' || currentStatus === 'pending') {
        startPolling();
    }

    function startPolling() {
        const indicator = document.getElementById('live-indicator');
        const consoleEl = document.getElementById('log-console');
        const consoleStatus = document.getElementById('console-status');
        if(indicator) indicator.classList.remove('d-none');
        if(consoleStatus) consoleStatus.classList.remove('d-none');
        
        const badge = document.querySelector('.status-badge');
        const spinner = badge.querySelector('.spinner');
        if(spinner) spinner.classList.remove('d-none');

        let lastCreated = parseInt(document.getElementById('stat-created').innerText.replace(/\D/g, '')) || 0;
        let lastUpdated = parseInt(document.getElementById('stat-updated').innerText.replace(/\D/g, '')) || 0;

        const addLog = (msg, type = 'info') => {
            const time = new Date().toLocaleTimeString('az-AZ', { hour12: false });
            const color = type === 'success' ? 'text-success' : (type === 'error' ? 'text-danger' : 'text-info');
            const entry = document.createElement('div');
            entry.className = 'log-entry mb-1';
            entry.innerHTML = `<span class="text-white-50">[${time}]</span> <span class="${color}">${type.charAt(0).toUpperCase() + type.slice(1)}:</span> ${msg}`;
            consoleEl.appendChild(entry);
            consoleEl.scrollTop = consoleEl.scrollHeight;
        };

        addLog('Stream bağlantısı quruldu. Məlumatlar gözlənilir...', 'success');

        const pollInterval = setInterval(() => {
            fetch(`/admin/api/import-progress/${historyId}`)
                .then(response => response.json())
                .then(data => {
                    // Log changes
                    if (data.created_rows > lastCreated) {
                        addLog(`${data.created_rows - lastCreated} yeni sətir əlavə edildi.`);
                        lastCreated = data.created_rows;
                    }
                    if (data.updated_rows > lastUpdated) {
                        addLog(`${data.updated_rows - lastUpdated} sətir yeniləndi.`);
                        lastUpdated = data.updated_rows;
                    }

                    // Update stats
                    document.getElementById('stat-total').innerText = data.total_rows.toLocaleString();
                    document.getElementById('stat-created').innerText = '+' + data.created_rows.toLocaleString();
                    document.getElementById('stat-updated').innerText = '~' + data.updated_rows.toLocaleString();
                    document.getElementById('progress-percent').innerText = data.percent + '%';
                    
                    // Update bars
                    const total = data.total_rows || 1;
                    document.getElementById('progress-bar-created').style.width = (data.created_rows / total * 100) + '%';
                    document.getElementById('progress-bar-updated').style.width = (data.updated_rows / total * 100) + '%';
                    document.getElementById('progress-bar-failed').style.width = (data.failed_rows / total * 100) + '%';

                    // Update success rate
                    const success = data.created_rows + data.updated_rows;
                    const rate = total > 0 ? Math.round((success / total) * 100) : 0;
                    document.getElementById('stat-rate').innerText = rate + '%';

                    // Check if finished
                    if (data.status === 'completed' || data.status === 'failed') {
                        clearInterval(pollInterval);
                        addLog(data.status === 'completed' ? 'Əməliyyat uğurla başa çatdı!' : 'Əməliyyat xəta ilə dayandırıldı.', data.status === 'completed' ? 'success' : 'error');
                        setTimeout(() => location.reload(), 2000); 
                    }
                })
                .catch(err => {
                    console.error('Polling error:', err);
                    addLog('Bağlantı xətası. Yenidən cəhd edilir...', 'error');
                });
        }, 3000);
    }
});
</script>
@endpush