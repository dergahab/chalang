@extends('admin.layouts.main')

@section('heading_title', 'Eksport Mərkəzi (Bulk Export)')

@section('custom_buttons')
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.export.schedules') }}" class="btn btn-sm rounded-pill px-4 fw-bold d-flex align-items-center premium-btn-outline" style="border: 1px solid rgba(0, 242, 254, 0.4); color: #00f2fe; background: rgba(0, 242, 254, 0.05);">
            <i class="ri-calendar-event-line me-2 fs-16 text-info"></i> AVTOMATİK CƏDVƏLLƏR
        </a>
        <a href="{{ route('admin.export.history') }}" class="btn btn-vision-primary btn-sm rounded-pill px-4 fw-bold shadow-lg d-flex align-items-center">
            <i class="ri-history-line me-2 fs-16"></i> EKSPORT TARİXÇƏSİ
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
    .premium-btn-outline {
        transition: all 0.3s ease !important;
        text-decoration: none !important;
    }
    .premium-btn-outline:hover {
        background: rgba(0, 242, 254, 0.15) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 242, 254, 0.2);
    }

    .export-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        border-radius: 10px;
        padding: 8px 15px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .export-btn-csv:hover { background: rgba(40, 199, 111, 0.2); border-color: #28c76f; color: #28c76f; }
    .export-btn-xlsx:hover { background: rgba(0, 242, 254, 0.2); border-color: #00f2fe; color: #00f2fe; }
    .export-btn-json:hover { background: rgba(213, 0, 249, 0.2); border-color: #d500f9; color: #d500f9; }

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
                        <div class="avatar-md bg-soft-primary rounded-3 d-flex align-items-center justify-content-center me-4" style="width: 54px; height: 54px; background: rgba(213, 0, 249, 0.1); border: 1px solid rgba(213, 0, 249, 0.2);">
                            <i class="ri-database-2-fill text-primary fs-26" style="color: var(--brand-secondary) !important;"></i>
                        </div>
                        <div>
                            <h4 class="text-white mb-1 fs-20 fw-black">Məlumatların Eksportu</h4>
                            <p class="text-muted mb-0 fs-13">Sistemdəki məlumatları CSV, Excel və ya JSON formatında endirin</p>
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
            'sp-content' => 'Səhifə kontenti',
            'content-text' => 'Mətn kontenti',
            'social-media' => 'Sosial media linkləri',
            'step' => 'Addımlar və proseslər',
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
    @endphp

    @forelse($allowedModels as $model)
        @php
            $color = $colors[$model] ?? '#4b0082';
        @endphp
        <div class="col-xl-3 col-lg-4 col-md-6 model-item">
            <div class="model-card h-100 p-4 text-center">
                <div class="model-icon-wrapper" style="background: rgba({{ hexdec(substr($color, 1, 2)) }}, {{ hexdec(substr($color, 3, 2)) }}, {{ hexdec(substr($color, 5, 2)) }}, 0.1); color: {{ $color }}; box-shadow: 0 0 15px rgba({{ hexdec(substr($color, 1, 2)) }}, {{ hexdec(substr($color, 3, 2)) }}, {{ hexdec(substr($color, 5, 2)) }}, 0.2);">
                    <i class="{{ $icons[$model] ?? 'ri-database-2-line' }}"></i>
                </div>
                
                <h5 class="text-white fw-bold mb-2 fs-16">{{ ucfirst(str_replace('-', ' ', $model)) }}</h5>
                <p class="text-muted fs-12 mb-4" style="min-height: 36px;">{{ $descs[$model] ?? 'Sistem məlumatları' }}</p>

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.export.run', ['model' => $model, 'format' => 'csv']) }}" class="export-btn export-btn-csv w-100">
                        <i class="ri-file-text-line me-2 fs-14"></i> CSV Formatında
                    </a>
                    <a href="{{ route('admin.export.run', ['model' => $model, 'format' => 'xlsx']) }}" class="export-btn export-btn-xlsx w-100">
                        <i class="ri-file-excel-line me-2 fs-14"></i> Excel (XLSX)
                    </a>
                    <a href="{{ route('admin.export.run', ['model' => $model, 'format' => 'json']) }}" class="export-btn export-btn-json w-100">
                        <i class="ri-braces-line me-2 fs-14"></i> JSON Formatında
                    </a>
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
                <p class="text-muted">Eksport üçün icazə verilən modellər mövcud deyil.</p>
            </div>
        </div>
    @endforelse
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Add loading state to export buttons
    document.querySelectorAll('.export-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const originalHtml = this.innerHTML;
            this.innerHTML = '<i class="ri-loader-4-line ri-spin me-2"></i> Hazırlanır...';
            this.style.pointerEvents = 'none';
            this.style.opacity = '0.7';

            // Reset after 5 seconds assuming download started
            setTimeout(() => {
                this.innerHTML = originalHtml;
                this.style.pointerEvents = 'auto';
                this.style.opacity = '1';
            }, 5000);
        });
    });
});
</script>
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush
@endsection