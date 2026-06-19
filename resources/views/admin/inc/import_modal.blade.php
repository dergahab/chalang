<!-- GOD MODE: Reusable Master Import Modal -->
@php
    $importModelKey = isset($modelName) ? \Illuminate\Support\Str::kebab($modelName) : '';
@endphp
<div class="modal fade" id="masterImportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card border-0 shadow-lg" style="background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(20px); border-radius: 24px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                    <i class="ri-terminal-window-line me-2 text-primary"></i> 
                    <span id="target-model-name-display">{{ $modelName ?? 'Model' }}</span> İmport Mərkəzi
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Stepper UI - Fixed Layout -->
                <div class="d-flex justify-content-between align-items-center mb-5 position-relative">
                    <div class="position-absolute top-50 start-0 translate-middle-y w-100 px-2" style="z-index: 0;">
                        <div class="progress" style="height: 2px; background: rgba(255,255,255,0.1);">
                            <div class="progress-bar bg-primary" id="import-stepper-progress" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="step-item text-center position-relative active" style="z-index: 1; flex: 1;">
                        <div class="step-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 32px; height: 32px; border: 4px solid #0f172a; font-weight: bold;">1</div>
                        <span class="small text-white-50">Fayl</span>
                    </div>
                    <div class="step-item text-center position-relative" style="z-index: 1; flex: 1;">
                        <div class="step-icon bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 32px; height: 32px; border: 4px solid #0f172a; font-weight: bold;">2</div>
                        <span class="small text-white-50">Preview</span>
                    </div>
                    <div class="step-item text-center position-relative" style="z-index: 1; flex: 1;">
                        <div class="step-icon bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 32px; height: 32px; border: 4px solid #0f172a; font-weight: bold;">3</div>
                        <span class="small text-white-50">Finish</span>
                    </div>
                </div>

                <form id="masterImportForm" action="{{ route('admin.import.preview', ['model' => $importModelKey ?: ($modelName ?? '')]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Drag & Drop Area -->
                    <div id="drop-zone" class="drop-zone border-2 border-dashed rounded-4 p-5 text-center mb-4 transition-all" style="border-color: rgba(168, 85, 247, 0.3); background: rgba(255,255,255,0.02); cursor: pointer; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                        <div class="drop-zone-content text-center">
                            <div class="mb-3">
                                <i class="ri-cloud-upload-line display-4 text-primary opacity-50"></i>
                            </div>
                            <h6 class="text-white">Faylı bura sürükləyin və ya klikləyin</h6>
                            <p class="text-white-50 small mb-0">Dəstəklənir: .CSV, .JSON, .TXT</p>
                        </div>
                        <div class="drop-zone-file-info d-none text-center">
                            <i class="ri-file-text-line fs-1 text-success mb-2"></i>
                            <h6 class="text-success mb-1" id="selected-file-name">filename.csv</h6>
                            <p class="text-white-50 small mb-2" id="selected-file-size">0 KB</p>
                            <button type="button" class="btn btn-sm px-3 rounded-pill" id="remove-file-btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);">Dəyişdir</button>
                        </div>
                        <input type="file" name="file" id="masterImportInput" class="d-none" accept=".csv,.json,.txt">
                    </div>

                    <div class="d-grid">
                        <button type="submit" id="masterImportSubmit" class="btn btn-primary py-3 fw-bold disabled" style="border-radius: 12px; background: linear-gradient(135deg, #4b0082, #d500f9); border: none; font-size: 1rem; box-shadow: 0 10px 20px rgba(168, 85, 247, 0.2);">
                            Davam Et <i class="ri-arrow-right-line ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-4 pt-3 border-top border-white-10 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.import-history.index') }}" class="text-info small text-decoration-none d-flex align-items-center gap-1 opacity-75 hover-opacity-100">
                        <i class="ri-history-line"></i> İmport Tarixçəsi
                    </a>
                    <div class="d-flex gap-2 align-items-center">
                        <span class="text-white-50 small me-1">Şablon yüklə:</span>
                        <a href="{{ route('admin.import.template', ['model' => $importModelKey ?: ($modelName ?? 'Service'), 'format' => 'csv']) }}" class="btn btn-sm btn-outline-light border-white-10 text-white-50 shadow-none px-3" style="border-radius: 8px;">CSV</a>
                        <a href="{{ route('admin.import.template', ['model' => $importModelKey ?: ($modelName ?? 'Service'), 'format' => 'json']) }}" class="btn btn-sm btn-outline-light border-white-10 text-white-50 shadow-none px-3" style="border-radius: 8px;">JSON</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js_stack')
<style>
    .hover-opacity-100:hover { opacity: 1 !important; }
    .drop-zone:hover { border-color: #a855f7 !important; background: rgba(168, 85, 247, 0.05) !important; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('masterImportInput');
        const fileInfo = document.querySelector('.drop-zone-file-info');
        const content = document.querySelector('.drop-zone-content');
        const submitBtn = document.getElementById('masterImportSubmit');
        const fileName = document.getElementById('selected-file-name');
        const fileSize = document.getElementById('selected-file-size');
        const removeBtn = document.getElementById('remove-file-btn');

        if(dropZone) {
            dropZone.addEventListener('click', () => fileInput.click());
            dropZone.addEventListener('dragover', (e) => { 
                e.preventDefault(); 
                dropZone.style.borderColor = '#a855f7'; 
                dropZone.style.background = 'rgba(168, 85, 247, 0.05)'; 
            });
            dropZone.addEventListener('dragleave', () => { 
                dropZone.style.borderColor = 'rgba(168, 85, 247, 0.3)'; 
                dropZone.style.background = 'rgba(255,255,255,0.02)'; 
            });
            dropZone.addEventListener('drop', (e) => { 
                e.preventDefault(); 
                if(e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files; 
                    handleFiles(); 
                }
            });
            fileInput.addEventListener('change', handleFiles);
        }

        function handleFiles() {
            const file = fileInput.files[0];
            if (file) {
                fileName.innerText = file.name;
                fileSize.innerText = (file.size / 1024).toFixed(2) + ' KB';
                content.classList.add('d-none');
                fileInfo.classList.remove('d-none');
                submitBtn.classList.remove('disabled');
                dropZone.style.borderColor = '#22c55e';
            }
        }

        if(removeBtn) {
            removeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                fileInput.value = '';
                content.classList.remove('d-none');
                fileInfo.classList.add('d-none');
                submitBtn.classList.add('disabled');
                dropZone.style.borderColor = 'rgba(168, 85, 247, 0.3)';
            });
        }
    });
</script>
@endpush
