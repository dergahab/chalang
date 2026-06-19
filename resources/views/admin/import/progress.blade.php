@extends('admin.layouts.main')

@section('heading_title', 'İmport Progress')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <!-- Progress Dashboard -->
        <div class="card glass-card border-0 mb-4 overflow-hidden" style="background: rgba(15, 23, 42, 0.4);">
            <div class="card-body py-5">
                <div class="text-center mb-4">
                    <div class="avatar-xl mx-auto mb-4">
                        <div class="avatar-title bg-primary rounded-circle fs-1 pulse">
                            <i class="ri-upload-cloud-line text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white mb-2">İmport Prosesi Davam Edir</h3>
                    <p class="text-white-50 mb-4">Faylınız background-da emal olunur. Bu səhifəni bağlaya bilərsiniz.</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-white-50 small">Ümumi Progress</span>
                        <span class="text-white fw-bold" id="progressText">0%</span>
                    </div>
                    <div class="progress" style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                        <div class="progress-bar bg-primary" id="progressBar" style="width: 0%; border-radius: 4px;"></div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded-3" style="background: rgba(59, 130, 246, 0.1);">
                            <div class="fs-4 fw-bold text-primary mb-1" id="processedCount">0</div>
                            <div class="text-white-50 small">Emal Olundu</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded-3" style="background: rgba(34, 197, 94, 0.1);">
                            <div class="fs-4 fw-bold text-success mb-1" id="createdCount">0</div>
                            <div class="text-white-50 small">Əlavə Olundu</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded-3" style="background: rgba(245, 158, 11, 0.1);">
                            <div class="fs-4 fw-bold text-warning mb-1" id="updatedCount">0</div>
                            <div class="text-white-50 small">Yeniləndi</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded-3" style="background: rgba(239, 68, 68, 0.1);">
                            <div class="fs-4 fw-bold text-danger mb-1" id="failedCount">0</div>
                            <div class="text-white-50 small">Xəta</div>
                        </div>
                    </div>
                </div>

                <!-- Status Messages -->
                <div id="statusMessages" class="mb-4">
                    <div class="alert alert-info border-0" style="background: rgba(59, 130, 246, 0.1);">
                        <i class="ri-information-line me-2"></i>
                        <span id="statusText">İmport prosesi başladı...</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-light px-4" onclick="window.close()">
                        <i class="ri-close-line me-2"></i> Bağla
                    </button>
                    <a href="{{ route('admin.import.index') }}" class="btn btn-primary px-4">
                        <i class="ri-add-line me-2"></i> Yeni İmport
                    </a>
                </div>
                <input type="hidden" id="historyIdHidden" value="{{ $historyId ?? '' }}">
            </div>
        </div>

        <!-- Error Details (Hidden by default) -->
        <div class="card glass-card border-0 d-none" id="errorCard">
            <div class="card-header bg-transparent border-bottom">
                <h5 class="mb-0 text-danger">
                    <i class="ri-error-warning-line me-2"></i> Xəta Detalları
                </h5>
            </div>
            <div class="card-body">
                <div id="errorList" class="list-group list-group-flush"></div>
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

.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.progress-bar {
    transition: width 0.5s ease;
}
</style>
@endpush

@push('js_stack')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const historyId = document.getElementById('historyIdHidden')?.value || null;
    let pollInterval;

    if (historyId) {
        startPolling(historyId);
    }

    function startPolling(id) {
        pollInterval = setInterval(() => {
            fetchStatus(id);
        }, 2000); // Poll every 2 seconds
    }

    function fetchStatus(id) {
        fetch(`/admin/api/import-progress/${id}`)
            .then(response => response.json())
            .then(data => {
                updateProgress(data);

                if (data.is_completed) {
                    clearInterval(pollInterval);
                    handleCompletion(data);
                }
            })
            .catch(error => {
                console.error('Status check failed:', error);
                clearInterval(pollInterval);
                showError('Status yoxlanışı uğursuz oldu');
            });
    }

    function updateProgress(data) {
        // Update progress bar
        document.getElementById('progressBar').style.width = data.progress + '%';
        document.getElementById('progressText').textContent = data.progress + '%';

        // Update stats
        document.getElementById('processedCount').textContent = data.processed;
        document.getElementById('createdCount').textContent = data.created;
        document.getElementById('updatedCount').textContent = data.updated;
        document.getElementById('failedCount').textContent = data.failed;

        // Update status text
        let statusText = '';
        if (data.status === 'processing') {
            statusText = `Emal olunur... (${data.processed}/${data.total})`;
            if (data.estimated_remaining_seconds) {
                const minutes = Math.floor(data.estimated_remaining_seconds / 60);
                const seconds = data.estimated_remaining_seconds % 60;
                statusText += ` - Təxminən ${minutes}:${seconds.toString().padStart(2, '0')} qalıb`;
            }
        } else if (data.status === 'completed') {
            statusText = 'İmport uğurla tamamlandı!';
        } else if (data.status === 'failed') {
            statusText = 'İmport xətası ilə tamamlandı';
        }

        document.getElementById('statusText').textContent = statusText;

        // Show errors if any
        if (data.errors && data.errors.length > 0) {
            showErrors(data.errors);
        }
    }

    function handleCompletion(data) {
        const statusMessages = document.getElementById('statusMessages');

        if (data.status === 'completed') {
            statusMessages.innerHTML = `
                <div class="alert alert-success border-0" style="background: rgba(34, 197, 94, 0.1);">
                    <i class="ri-check-circle-line me-2"></i>
                    <strong>Uğurlu!</strong> ${data.created} əlavə, ${data.updated} yeniləndi, ${data.failed} xəta
                </div>
            `;

            // Success notification
            showNotification('İmport uğurla tamamlandı!', 'success');
        } else {
            statusMessages.innerHTML = `
                <div class="alert alert-danger border-0" style="background: rgba(239, 68, 68, 0.1);">
                    <i class="ri-error-warning-line me-2"></i>
                    <strong>Xəta!</strong> İmport prosesi uğursuz oldu
                </div>
            `;

            showNotification('İmport uğursuz oldu', 'error');
        }
    }

    function showErrors(errors) {
        const errorCard = document.getElementById('errorCard');
        const errorList = document.getElementById('errorList');

        errorList.innerHTML = '';
        errors.forEach(error => {
            const li = document.createElement('li');
            li.className = 'list-group-item bg-transparent border-0 px-0';
            li.innerHTML = `<i class="ri-error-warning-line text-danger me-2"></i> ${error}`;
            errorList.appendChild(li);
        });

        errorCard.classList.remove('d-none');
    }

    function showError(message) {
        const statusMessages = document.getElementById('statusMessages');
        statusMessages.innerHTML = `
            <div class="alert alert-danger border-0" style="background: rgba(239, 68, 68, 0.1);">
                <i class="ri-error-warning-line me-2"></i> ${message}
            </div>
        `;
    }

    function showNotification(message, type) {
        // Simple notification - you could integrate with a proper notification system
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification('İmport Status', { body: message });
        }
    }

    // Request notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
});
</script>
@endpush