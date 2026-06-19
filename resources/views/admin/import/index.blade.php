@extends('admin.layouts.main')

@section('heading_title', 'İmport Mərkəzi (Bulk Import)')

@section('custom_buttons')
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.import.history') }}" class="btn btn-vision-primary btn-sm rounded-pill px-4 fw-bold shadow-lg d-flex align-items-center">
            <i class="ri-history-line me-2 fs-16"></i> İMPORT TARİXÇƏSİ
        </a>
    </div>
@endsection

@section('content')
<style>
    /* VISION CORE v3 - RESILIENT PREMIUM STYLES */
    :root {
        --brand-primary: #4b0082;
        --brand-secondary: #d500f9;
        --brand-cyan: #00f2fe;
        --card-bg: rgba(17, 24, 39, 0.8);
        --text-muted: #94a3b8;
    }

    .glass-card-resilient {
        background: var(--card-bg) !important;
        backdrop-filter: blur(15px) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 20px !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3) !important;
    }

    .model-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .model-card:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(213, 0, 249, 0.3);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4), 0 0 20px rgba(213, 0, 249, 0.1);
    }

    .model-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        transition: transform 0.3s ease;
    }

    .model-card:hover .model-icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    /* PREMIUM BUTTONS */
    .btn-vision-primary {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary)) !important;
        border: none !important;
        color: #fff !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .btn-vision-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(213, 0, 249, 0.35) !important;
        color: #fff !important;
    }

    .search-box input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
    }
    .search-box input:focus {
        border-color: var(--brand-secondary) !important;
        box-shadow: 0 0 15px rgba(213, 0, 249, 0.2) !important;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card glass-card-resilient">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md bg-soft-primary rounded-3 d-flex align-items-center justify-content-center me-4" style="width: 54px; height: 54px; background: rgba(0, 242, 254, 0.1); border: 1px solid rgba(0, 242, 254, 0.2);">
                            <i class="ri-upload-cloud-2-fill fs-26" style="color: var(--brand-cyan) !important;"></i>
                        </div>
                        <div>
                            <h4 class="text-white mb-1 fs-20 fw-black">Məlumatların İmportu</h4>
                            <p class="text-muted mb-0 fs-13">CSV, Excel və ya JSON fayllarını sistemə daxil edin</p>
                        </div>
                    </div>
                    <div class="search-box position-relative">
                        <input type="text" id="modelSearch" class="form-control rounded-pill px-4" placeholder="Model axtar..." style="width: 250px; height: 42px; padding-left: 40px !important;">
                        <i class="ri-search-line position-absolute text-muted" style="left: 15px; top: 50%; transform: translateY(-50%);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4" id="modelsGrid">
    @php
        $icons = [
            'service' => 'ri-customer-service-2-line',
            'portfolio' => 'ri-gallery-line',
            'blog' => 'ri-article-line',
            'bcategory' => 'ri-bookmark-line',
            'pcategory' => 'ri-tags-line',
            'testimonial' => 'ri-chat-quote-line',
            'partner' => 'ri-handshake-line',
            'pricing-plan' => 'ri-price-tag-3-line',
            'team-member' => 'ri-team-line',
            'faq' => 'ri-question-answer-line',
            'tag' => 'ri-price-tag-line',
            'sp-content' => 'ri-file-text-line',
            'content-text' => 'ri-file-text-line',
            'social-media' => 'ri-share-line',
            'step' => 'ri-footprint-line',
        ];

        $descs = [
            'service' => 'Xidmətlər və tariflər',
            'portfolio' => 'Görülmüş işlər',
            'blog' => 'Xəbərlər və məqalələr',
            'bcategory' => 'Blog kateqoriyaları',
            'pcategory' => 'Portfolio kateqoriyaları',
            'testimonial' => 'Rəy və təəssüratlar',
            'partner' => 'Partnyor şirkətlər',
            'pricing-plan' => 'Qiymət planları',
            'team-member' => 'Komanda üzvləri',
            'faq' => 'Tez-tez verilən suallar',
            'tag' => 'Kateqoriyalar və teqlər',
            'sp-content' => 'Service məzmunu',
            'content-text' => 'Ümumi mətn kontenti',
            'social-media' => 'Sosial media bağlantıları',
            'step' => 'Addım ardıcıllığı',
        ];

        $colors = [
            'service' => '#00f2fe',
            'portfolio' => '#d500f9',
            'blog' => '#ff9f43',
            'bcategory' => '#28c76f',
            'pcategory' => '#ea5455',
            'testimonial' => '#f8d210',
            'partner' => '#32ccbc',
            'pricing-plan' => '#a29bfe',
            'team-member' => '#fd79a8',
            'faq' => '#55efc4',
            'tag' => '#00f2fe',
            'sp-content' => '#d500f9',
            'content-text' => '#ff9f43',
            'social-media' => '#28c76f',
            'step' => '#ea5455',
        ];

        $availableModels = [];
        foreach (\App\Http\Controllers\Admin\ImportController::allowedModelKeys() as $modelKey) {
            $availableModels[] = [
                'slug' => $modelKey,
                'name' => \Illuminate\Support\Str::title(str_replace('-', ' ', $modelKey)),
                'icon' => $icons[$modelKey] ?? 'ri-database-2-line',
                'color' => $colors[$modelKey] ?? '#00f2fe',
                'desc' => $descs[$modelKey] ?? 'Məlumatı CSV / JSON ilə idxal edin.',
            ];
        }
    @endphp

    @forelse($availableModels as $model)
        <div class="col-xl-3 col-lg-4 col-md-6 model-item">
            <div class="model-card h-100 p-4 text-center" data-model="{{ $model['slug'] }}" data-display="{{ $model['name'] }}" onclick="openImportModal(this.dataset.model, this.dataset.display)">
                <div class="model-icon-wrapper" style="background: rgba({{ hexdec(substr($model['color'], 1, 2)) }}, {{ hexdec(substr($model['color'], 3, 2)) }}, {{ hexdec(substr($model['color'], 5, 2)) }}, 0.1); color: {{ $model['color'] }}; box-shadow: 0 0 15px rgba({{ hexdec(substr($model['color'], 1, 2)) }}, {{ hexdec(substr($model['color'], 3, 2)) }}, {{ hexdec(substr($model['color'], 5, 2)) }}, 0.2);">
                    <i class="{{ $model['icon'] }}"></i>
                </div>
                
                <h5 class="text-white fw-bold mb-2 fs-16">{{ $model['name'] }}</h5>
                <p class="text-muted fs-12 mb-0" style="min-height: 36px;">{{ $model['desc'] }}</p>
                
                <div class="mt-3 pt-3 border-top border-white-10">
                    <span class="text-white-50 fs-12 fw-bold"><i class="ri-upload-line me-1"></i> İMPORT ET</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="glass-card-resilient p-5 text-center">
                <div class="avatar-xl mx-auto mb-4 bg-soft-danger rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(239, 68, 68, 0.1);">
                    <i class="ri-inbox-line fs-1 text-danger"></i>
                </div>
                <h4 class="text-white fw-bold">Heç bir model tapılmadı</h4>
                <p class="text-muted">İmport üçün icazə verilən modellər mövcud deyil.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- GOD MODE: Reusable Master Import Modal -->
<div class="modal fade" id="centralImportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-resilient border-0" style="background: rgba(15, 23, 42, 0.98) !important; backdrop-filter: blur(25px) !important; border: 1px solid rgba(0, 242, 254, 0.15) !important;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                    <i class="ri-terminal-window-line me-2 text-info"></i> 
                    <span id="target-model-name">Model</span> İmport Mərkəzi
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="centralImportForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Drag & Drop Area -->
                    <div id="central-drop-zone" class="drop-zone border-2 border-dashed rounded-4 p-5 text-center mb-3 transition-all" style="border-color: rgba(0, 242, 254, 0.3); background: rgba(0, 242, 254, 0.02); cursor: pointer;">
                        <div class="drop-zone-content">
                            <div class="mb-3">
                                <i class="ri-cloud-upload-line display-4 text-info opacity-50 pulse"></i>
                            </div>
                            <h6 class="text-white">Faylı bura sürükləyin və ya klikləyin</h6>
                            <p class="text-white-50 small mb-0">Dəstəklənir: .CSV, .JSON, .XLSX</p>
                        </div>
                        <div class="drop-zone-file-info d-none">
                            <i class="ri-file-text-line fs-1 text-success mb-2"></i>
                            <h6 class="text-success mb-1" id="central-file-name">filename.csv</h6>
                            <p class="text-white-50 small" id="central-file-size">0 KB</p>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 fw-bold" id="central-remove-btn">Dəyişdir</button>
                        </div>
                        <input type="file" name="file" id="centralImportInput" class="d-none" accept=".csv,.json,.xlsx,.xls">
                    </div>

                    <div class="d-grid">
                        <button type="submit" id="centralImportSubmit" class="btn btn-vision-primary py-3 fw-bold disabled" style="border-radius: 12px; font-size: 14px;">
                            Ön-baxışa Keç <i class="ri-arrow-right-line ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-4 pt-3 border-top border-white-10 d-flex justify-content-between align-items-center">
                    <span class="text-white-50 small">Nümunə Şablon:</span>
                    <div class="d-flex gap-2">
                        <a id="template-csv-link" href="#" class="btn btn-sm" style="background: rgba(40, 199, 111, 0.1); color: #28c76f; border: 1px solid rgba(40, 199, 111, 0.2);">CSV</a>
                        <a id="template-json-link" href="#" class="btn btn-sm" style="background: rgba(213, 0, 249, 0.1); color: #d500f9; border: 1px solid rgba(213, 0, 249, 0.2);">JSON</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openImportModal(model, displayName) {
        document.getElementById('target-model-name').innerText = displayName || model;
        document.getElementById('centralImportForm').action = `/admin/import/${model}/preview`;
        document.getElementById('template-csv-link').href = `/admin/import/template/${model}/csv`;
        document.getElementById('template-json-link').href = `/admin/import/template/${model}/json`;
        
        // jQuery is still required for bootstrap modals in this version
        $('#centralImportModal').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('modelSearch');
        if(searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const items = document.querySelectorAll('.model-item');
                
                items.forEach(item => {
                    const title = item.querySelector('h5').innerText.toLowerCase();
                    const desc = item.querySelector('p').innerText.toLowerCase();
                    
                    if(title.includes(query) || desc.includes(query)) {
                        item.style.display = '';
                        item.style.animation = 'fadeIn 0.3s ease forwards';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Drag and drop logic
        const dropZone = document.getElementById('central-drop-zone');
        const fileInput = document.getElementById('centralImportInput');
        const fileInfo = document.querySelector('.drop-zone-file-info');
        const content = document.querySelector('.drop-zone-content');
        const submitBtn = document.getElementById('centralImportSubmit');
        const fileName = document.getElementById('central-file-name');
        const fileSize = document.getElementById('central-file-size');
        const removeBtn = document.getElementById('central-remove-btn');

        if(dropZone) {
            dropZone.addEventListener('click', () => fileInput.click());
            dropZone.addEventListener('dragover', (e) => { 
                e.preventDefault(); 
                dropZone.style.borderColor = '#00f2fe'; 
                dropZone.style.background = 'rgba(0, 242, 254, 0.05)';
            });
            dropZone.addEventListener('dragleave', () => { 
                dropZone.style.borderColor = 'rgba(0, 242, 254, 0.3)'; 
                dropZone.style.background = 'rgba(0, 242, 254, 0.02)';
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
                dropZone.style.borderColor = '#28c76f';
                dropZone.style.background = 'rgba(40, 199, 111, 0.05)';
            }
        }

        if(removeBtn) {
            removeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                fileInput.value = '';
                content.classList.remove('d-none');
                fileInfo.classList.add('d-none');
                submitBtn.classList.add('disabled');
                dropZone.style.borderColor = 'rgba(0, 242, 254, 0.3)';
                dropZone.style.background = 'rgba(0, 242, 254, 0.02)';
            });
        }
        
        // Modal clear on hide
        $('#centralImportModal').on('hidden.bs.modal', function () {
            if(removeBtn) removeBtn.click();
        });
    });
</script>
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.border-white-10 { border-color: rgba(255,255,255,0.1) !important; }
</style>
@endpush
@endsection