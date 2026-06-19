@extends('admin.layouts.main')

@section('heading_title', 'İmport Preview - ' . ucfirst($model))

@section('content')
<div class="row">
    <div class="col-12">
        <!-- GOD MODE: Stepper Dashboard -->
        <div class="card glass-card border-0 mb-4 overflow-hidden" style="background: rgba(15, 23, 42, 0.4);">
            <div class="card-body py-4">
                <div class="d-flex justify-content-between position-relative px-5">
                    <div class="position-absolute top-50 start-0 translate-middle-y w-100 px-5" style="z-index: 0;">
                        <div class="progress" style="height: 2px; background: rgba(255,255,255,0.1);">
                            <div class="progress-bar bg-primary" style="width: 50%"></div>
                        </div>
                    </div>
                    <div class="step-item text-center position-relative" style="z-index: 1;">
                        <div class="step-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-lg" style="width: 40px; height: 40px; border: 4px solid #0f172a;">
                            <i class="ri-check-line"></i>
                        </div>
                        <span class="fw-bold text-success small">Fayl Seçimi</span>
                    </div>
                    <div class="step-item text-center position-relative active" style="z-index: 1;">
                        <div class="step-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-lg pulse" style="width: 40px; height: 40px; border: 4px solid #0f172a;">2</div>
                        <span class="fw-bold text-white small">Ön-baxış</span>
                    </div>
                    <div class="step-item text-center position-relative" style="z-index: 1;">
                        <div class="step-icon bg-secondary text-white-50 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; border: 4px solid #0f172a;">3</div>
                        <span class="text-white-50 small">Tamamlanma</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Dashboard -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3">
                                    <i class="ri-file-list-3-line"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Ümumi Sətir</h6>
                        </div>
                        <h2 class="mb-0 text-primary fw-bold">{{ number_format($totalRows) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3">
                                    <i class="ri-add-circle-line"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Batch Ölçüsü</h6>
                        </div>
                        <h2 class="mb-0 text-success fw-bold">{{ number_format($batchSize) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-3">
                                    <i class="ri-translate-2"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Tərcümələr</h6>
                        </div>
                        <h2 class="mb-0 text-warning fw-bold">{{ count($translatedAttributes) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card glass-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(168, 85, 247, 0.05));">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-title bg-purple-subtle text-purple rounded-circle fs-3">
                                    <i class="ri-hard-drive-2-line"></i>
                                </span>
                            </div>
                            <h6 class="card-title mb-0">Format</h6>
                        </div>
                        <h2 class="mb-0 text-purple fw-bold">{{ strtoupper($format) }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.import', ['model' => $model]) }}" method="POST" enctype="multipart/form-data" id="confirmImportForm">
            @csrf
            <input type="hidden" name="file_path" value="{{ $filePath }}">

            <div class="card glass-card overflow-hidden mb-4">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="ri-node-tree me-2 text-info"></i> 
                        Sütun Eşləşdirmə (Column Mapping)
                    </h5>
                    <span class="badge bg-soft-info text-info">Smart Guess Active</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-white-50 small mb-4">Fayldakı hər bir sütunun hansı verilənlər bazası sahəsinə yazılacağını təyin edin. Sistem avtomatik olaraq bəzi sütunları tanıyıb eşləşdirib.</p>
                    <div class="row g-3">
                        @foreach($headers as $header)
                        <div class="col-md-4 col-xl-3">
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <label class="form-label small text-white-50 mb-1 d-block text-truncate" title="{{ $header }}">FAYL SÜTUNU: <strong>{{ $header }}</strong></label>
                                <select name="mapping[{{ $header }}]" class="form-select form-select-sm shadow-none bg-dark text-white border-white-10">
                                    <option value="">-- Keç (Skip) --</option>
                                    @foreach($availableFields as $key => $field)
                                    <option value="{{ $key }}" {{ strtolower($header) == strtolower($key) ? 'selected' : '' }}>
                                        {{ $field['label'] }} {{ isset($field['required']) && $field['required'] ? '*' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card glass-card overflow-hidden">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="ri-eye-line me-2 text-primary"></i> 
                        İmport Ön-baxış (İlk {{ count($previewRows) }} sətir)
                    </h5>
                    <span class="badge bg-soft-primary text-primary px-3 py-2" style="border-radius: 8px;">Model: {{ $model }}</span>
                </div>
                
                <div class="card-body p-0">
                    @if(count($previewRows) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-4" style="width: 50px;">
                                        <div class="form-check shadow-none">
                                            <input class="form-check-input select-all-rows" type="checkbox" checked id="selectAllRows">
                                        </div>
                                    </th>
                                    @foreach($headers as $header)
                                    <th class="fw-bold">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($previewRows as $index => $row)
                                <tr>
                                    <td class="ps-4">
                                        <div class="form-check shadow-none">
                                            <input class="form-check-input row-checkbox" type="checkbox" name="selected_rows[]" value="{{ $index + 1 }}" checked>
                                        </div>
                                    </td>
                                    @foreach($headers as $header)
                                    <td class="text-nowrap">
                                        @php $val = $row[$header] ?? '-'; @endphp
                                        @if(filter_var($val, FILTER_VALIDATE_URL) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $val))
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $val }}" class="rounded shadow-sm me-2" style="width: 40px; height: 30px; object-fit: cover;">
                                                <span class="small text-truncate" style="max-width: 150px;">{{ basename($val) }}</span>
                                            </div>
                                        @else
                                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $val }}">
                                                {{ $val }}
                                            </span>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-4 border-top bg-light-subtle">
                        <div class="row align-items-end g-4">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label class="form-label fw-bold text-muted small mb-2 d-flex align-items-center">
                                        <i class="ri-settings-3-line me-1"></i> İMPORT REJİMİ
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="ri-refresh-line text-primary"></i></span>
                                        <select name="import_mode" class="form-select border-start-0 ps-0 shadow-none">
                                            <option value="merge">Merge (Mövcud olanları yenilə)</option>
                                            <option value="skip">Skip (Dublikatları keç)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-3">
                                    <div class="text-start me-4 d-none d-lg-block">
                                        <p class="text-muted small mb-0">Uğurlu importdan sonra</p>
                                        <p class="mb-0 fw-bold"><i class="ri-mail-send-line text-success me-1"></i> Email bildirişi göndəriləcək</p>
                                    </div>
                                    <a href="{{ URL::previous() }}" class="btn btn-light px-4" style="height: 48px; border-radius: 12px; display: flex; align-items: center;">
                                        <i class="ri-close-line me-2"></i> İmtina
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5 shadow-lg shadow-primary/20" style="height: 48px; border-radius: 12px; background: linear-gradient(135deg, #4b0082, #d500f9); border: none; font-weight: 600;">
                                        <i class="ri-upload-cloud-line me-2"></i> İmportu Başlat
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="avatar-lg mx-auto mb-4">
                            <span class="avatar-title bg-soft-warning text-warning rounded-circle fs-1">
                                <i class="ri-error-warning-line"></i>
                            </span>
                        </div>
                        <h4 class="text-muted">Preview üçün məlumat tapılmadı</h4>
                        <p class="text-muted mb-4">Seçdiyiniz fayl boşdur və ya strukturu səhvdir.</p>
                        <a href="{{ URL::previous() }}" class="btn btn-primary px-4">Geri Qayıt</a>
                    </div>
                    @endif
                </div>
            </div>
        </form>
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
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.glass-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.avatar-sm { height: 40px; width: 40px; }
.avatar-title {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%;
}
.bg-primary-subtle { background: rgba(59, 130, 246, 0.1); }
.bg-success-subtle { background: rgba(34, 197, 94, 0.1); }
.bg-warning-subtle { background: rgba(245, 158, 11, 0.1); }
.bg-purple-subtle { background: rgba(168, 85, 247, 0.1); }
.text-purple { color: #a855f7; }
.bg-soft-primary { background: rgba(59, 130, 246, 0.1); }
.bg-light-subtle { background: rgba(0, 0, 0, 0.02); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAllRows');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const importForm = document.getElementById('confirmImportForm');
    const submitBtn = importForm.querySelector('button[type="submit"]');

    // Select all functionality
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(c => c.checked);
            if (selectAll) selectAll.checked = allChecked;
        });
    });

    // Smart column mapping
    const mappingSelects = document.querySelectorAll('select[name^="mapping"]');
    mappingSelects.forEach(select => {
        select.addEventListener('change', function() {
            updateMappingPreview();
        });
    });

    function updateMappingPreview() {
        const mappings = {};
        mappingSelects.forEach(select => {
            const header = select.name.match(/mapping\[(.*?)\]/)[1];
            if (select.value) {
                mappings[header] = select.value;
            }
        });

        // Update preview table headers to show mappings
        const tableHeaders = document.querySelectorAll('thead th:not(:first-child)');
        tableHeaders.forEach((th, index) => {
            const headerText = th.textContent.trim();
            const mappedField = mappings[headerText];
            if (mappedField) {
                th.innerHTML = `${headerText} <small class="text-primary">→ ${mappedField}</small>`;
            }
        });
    }

    // Form validation before submit
    importForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Check if at least one column is mapped
        const mappedColumns = Array.from(mappingSelects).filter(s => s.value !== '');
        if (mappedColumns.length === 0) {
            showAlert('Xəta', 'Ən azı bir sütun eşləşdirməlisiniz!', 'danger');
            return;
        }

        // Check if any required fields are missing
        const requiredFields = @json(array_keys(array_filter($availableFields, function ($field) {
            return isset($field['required']) && $field['required'];
        })));
        const mappedValues = Array.from(mappingSelects).map(s => s.value).filter(v => v);
        const missingRequired = requiredFields.filter(field => !mappedValues.includes(field));

        if (missingRequired.length > 0) {
            showAlert('Xəbərdarlıq', `Tələb olunan sahələr eşləşdirilməyib: ${missingRequired.join(', ')}`, 'warning');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ri-loader-4-line spin me-2"></i> İmport başlayır...';

        // Submit form
        importForm.submit();
    });

    function showAlert(title, message, type = 'info') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${title}:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHtml);

        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert:last-child');
            if (alert) alert.remove();
        }, 5000);
    }

    // Initialize
    updateMappingPreview();
});
</script>
@endpush