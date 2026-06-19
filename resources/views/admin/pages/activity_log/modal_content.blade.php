<style>
    /* Midnight Purple Theme Variables (Brand Aligned) */
    :root {
        --mp-bg-main: #1e2030;       /* Deep background */
        --mp-bg-card: #2a2d3e;       /* Card background */
        --mp-bg-header: #23263a;     /* Card header background */
        --mp-bg-input: #1b1e2b;      /* Input background */
        --mp-border: #35394b;        /* Border color */
        --mp-text-primary: #ffffff;  /* Primary text */
        --mp-text-muted: #8f95b2;    /* Muted text */
        --mp-accent: #d500f9;        /* Chalang Brand Magenta/Purple */
        --mp-badge-old-bg: #3f2e3e;  /* Old badge bg */
        --mp-badge-old-text: #ff6b6b;/* Old badge text */
        --mp-badge-new-bg: #2e3f3e;  /* New badge bg */
        --mp-badge-new-text: #4ade80;/* New badge text */
        --mp-icon-bg: #3b2a4a;       /* Icon background (Tinted) */
        --mp-font-heading: 'Outfit', sans-serif;
        --mp-font-body: 'Inter', sans-serif;
        --mp-gradient-border: linear-gradient(135deg, #d500f9 0%, #6366f1 100%);
    }

    /* Modal Overrides */
    #activityModal .modal-content {
        background-color: var(--mp-bg-main);
        border: 1px solid var(--mp-border);
        color: var(--mp-text-primary);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        font-family: var(--mp-font-body);
        min-height: 80vh; /* Taller for Time Machine */
    }

    #activityModal h1, #activityModal h2, #activityModal h3, #activityModal h4, #activityModal h5, #activityModal h6, 
    .mp-card-header, .mp-accordion-btn {
        font-family: var(--mp-font-heading);
    }

    #activityModal .modal-header {
        background-color: var(--mp-bg-main);
        border-bottom: 1px solid var(--mp-border);
        padding: 1rem 1.5rem;
    }

    #activityModal .modal-body {
        background-color: var(--mp-bg-main);
        display: flex; /* Flex layout for columns */
        padding: 0;
        min-height: 600px;
    }

    /* Time Machine Layout */
    .mp-sidebar {
        width: 280px;
        border-right: 1px solid var(--mp-border);
        background: var(--mp-bg-header);
        overflow-y: auto;
        flex-shrink: 0;
        padding-top: 1rem;
    }

    .mp-content {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: var(--mp-bg-main);
    }

    /* Timeline Items */
    .mp-timeline-item {
        padding: 0.75rem 1rem 0.75rem 3.5rem;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        border-left: 3px solid transparent; /* Selection marker */
    }
    
    /* Connecting Line */
    .mp-timeline-item::before {
        content: '';
        position: absolute;
        left: 1.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--mp-border);
        z-index: 0;
    }
    /* Hide line top for first item if desired, but continuous is usually fine */
    
    /* Avatar/Node */
    .mp-timeline-item .avatar-xs {
        position: absolute;
        left: 1.15rem;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
        width: 24px;
        height: 24px;
        transition: all 0.3s;
    }
    
    .mp-timeline-item:hover {
        background: rgba(255,255,255,0.02);
    }
    
    .mp-timeline-item.active {
        background: rgba(213, 0, 249, 0.03); /* Reduced from 0.05 */
        border-left-color: var(--mp-accent);
    }
    
    .mp-timeline-item.active .avatar-title {
        background: var(--mp-accent) !important;
        color: white !important;
        box-shadow: 0 0 8px var(--mp-accent); /* Reduced from 15px */
        border-color: var(--mp-accent) !important;
    }

    /* Group Headers */
    .mp-group-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1.5rem 0 1rem;
        color: var(--mp-text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .mp-group-line {
        flex-grow: 1;
        height: 1px;
        background: var(--mp-border);
    }

    /* Cards - Cleaner Look */
    .mp-card {
        background-color: transparent;
        border: 1px solid var(--mp-border);
        border-radius: 12px;
        margin-bottom: 0.75rem;
        overflow: hidden;
        transition: all 0.2s;
    }
    .mp-card:hover {
        background-color: rgba(255,255,255,0.01);
        border-color: var(--mp-accent);
    }
    
    /* Values Section - Modernized */
    .mp-value-row {
        display: flex;
        align-items: center;
        gap: 0; /* Removed gap, using borders/padding */
    }
    
    .mp-value-box {
        flex: 1;
        padding: 1rem;
        position: relative;
    }

    .mp-value-text {
        color: var(--mp-text-muted);
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        line-height: 1.5;
        word-break: break-word;
    }
    .mp-value-text.filled {
        color: var(--mp-text-primary);
    }
    .mp-value-text.monospace {
        font-family: 'Fira Code', 'Courier New', monospace;
        font-size: 0.85rem;
    }

    .mp-arrow-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.5rem;
        color: var(--mp-border);
    }
    .mp-arrow-icon {
        font-size: 1.2rem;
        color: var(--mp-text-muted);
        opacity: 0.5;
    }

    /* Footer - Compact */
    .mp-footer {
        background-color: rgba(0,0,0,0.2);
        border-top: 1px solid var(--mp-border);
        padding: 1rem 1.5rem;
        margin-top: auto;
        border-radius: 0 0 12px 12px;
    }
    .mp-footer-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-right: 1.5rem;
        border-right: 1px solid var(--mp-border);
        height: 100%;
    }
    .mp-footer-item:last-child {
        border-right: none;
        padding-right: 0;
    }
    .mp-footer-icon {
        width: 32px;
        height: 32px;
        background-color: rgba(255,255,255,0.05);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--mp-text-muted);
        font-size: 1rem;
    }
    .mp-footer-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: var(--mp-text-muted);
        margin-bottom: 0.1rem;
        letter-spacing: 0.5px;
    }
    .mp-footer-value {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--mp-text-primary);
        line-height: 1.2;
    }

    /* Mobile Responsiveness */
    @media (max-width: 992px) {
        /* Layout Stacking */
        #activityModal .modal-body { flex-direction: column; }
        .mp-sidebar { width: 100%; height: 200px; border-right: none; border-bottom: 1px solid var(--mp-border); }
        .mp-content { padding: 1rem; }
        
        /* Value Rows (Diff View) */
        .mp-value-row { flex-direction: column; align-items: stretch; gap: 0.5rem; padding: 1rem; }
        .mp-arrow-container { transform: rotate(90deg); padding: 0.5rem 0; align-self: center; }
        .mp-value-box { width: 100%; }
        
        /* Header Adjustments */
        #activityModal .modal-header .d-flex.w-100 { flex-direction: column; align-items: flex-start; gap: 1rem; }
        #activityModal .modal-header .ms-auto { margin-left: 0 !important; width: 100%; justify-content: space-between; margin-top: 0.5rem; }
        
        /* Footer Grid Layout (2x2) */
        .mp-footer .row { --bs-gutter-y: 1rem; }
        .mp-footer-item { border-right: none; padding-right: 0; border-bottom: 1px solid var(--mp-border); padding-bottom: 0.75rem; height: auto; }
        .mp-footer .col-6:nth-last-child(-n+2) .mp-footer-item { border-bottom: none; padding-bottom: 0; }
        
        /* Hidden on Mobile */
        .mp-session-context { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    }
    /* Badge Styles */
    .bg-soft-success { background-color: rgba(74, 222, 128, 0.1) !important; color: #4ade80 !important; }
    .bg-soft-warning { background-color: rgba(250, 204, 21, 0.1) !important; color: #facc15 !important; }
    .bg-soft-danger { background-color: rgba(248, 113, 113, 0.1) !important; color: #f87171 !important; }
    .bg-soft-info { background-color: rgba(56, 189, 248, 0.1) !important; color: #38bdf8 !important; }
    .bg-soft-primary { background-color: rgba(213, 0, 249, 0.1) !important; color: #d500f9 !important; }

    /* Admin Note Accordion */
    .mp-accordion-btn {
        background-color: rgba(255, 255, 255, 0.02) !important;
        color: var(--mp-text-muted) !important;
        border: 1px solid var(--mp-border) !important;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: none !important;
    }
    .mp-accordion-btn:not(.collapsed) {
        background-color: rgba(213, 0, 249, 0.05) !important;
        color: var(--mp-accent) !important;
        border-color: var(--mp-accent) !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    .mp-accordion-btn::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%238f95b2'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    }
    .mp-accordion-btn:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23d500f9'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    }
    .mp-accordion-body {
        background-color: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--mp-border);
        border-top: none;
        padding: 1rem;
    }
    .mp-textarea {
        background-color: var(--mp-bg-main) !important;
        border: 1px solid var(--mp-border) !important;
        color: var(--mp-text-primary) !important;
        font-size: 0.85rem;
    }
    .mp-textarea:focus {
        border-color: var(--mp-accent) !important;
        box-shadow: none !important;
    }
    .mp-textarea:focus {
        border-color: var(--mp-accent) !important;
        box-shadow: none !important;
    }

    /* 1. Animation (Fade-in) */
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .mp-card { animation: slideIn 0.3s ease-out forwards; opacity: 0; }
    .mp-card:nth-child(1) { animation-delay: 0.05s; }
    .mp-card:nth-child(2) { animation-delay: 0.1s; }
    .mp-card:nth-child(3) { animation-delay: 0.15s; }
    .mp-card:nth-child(4) { animation-delay: 0.2s; }
    .mp-card:nth-child(5) { animation-delay: 0.25s; }

    /* 2. Subliminal Colors */
    .mp-value-box.old { background: rgba(248, 113, 113, 0.03); } /* Red tint */
    .mp-value-box.new { background: rgba(74, 222, 128, 0.03); } /* Green tint */

    /* 3. Empty Cells */
    .mp-empty-state {
        border: 1px dashed var(--mp-border);
        border-radius: 6px;
        padding: 0.25rem 0.5rem;
        color: var(--mp-text-muted);
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        opacity: 0.7;
    }

    /* 8. Gradient Borders */
    .mp-card.critical-impact {
        border-image: var(--mp-gradient-border);
        border-image-slice: 1;
        border-width: 1px;
        border-style: solid;
        background: linear-gradient(var(--mp-bg-card), var(--mp-bg-card)) padding-box,
                    var(--mp-gradient-border) border-box;
        border: 1px solid transparent; /* Fallback */
    }

    /* 11. Deep Copy */
    .mp-copy-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        opacity: 0;
        transition: opacity 0.2s;
        background: var(--mp-bg-card);
        border: 1px solid var(--mp-border);
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 0.7rem;
        color: var(--mp-text-muted);
        cursor: pointer;
    }
    .mp-value-box:hover .mp-copy-btn { opacity: 1; }
    .mp-copy-btn:hover { color: var(--mp-text-primary); border-color: var(--mp-accent); }

    /* 16. Session Context */
    .mp-session-context {
        background: rgba(99, 102, 241, 0.05);
        border-bottom: 1px solid var(--mp-border);
        padding: 0.75rem 1.5rem;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Print Styles for PDF Export */
    @media print {
        body * { visibility: hidden; }
        #activityModal, #activityModal * { visibility: visible; }
        #activityModal { position: absolute; left: 0; top: 0; width: 100%; height: 100%; overflow: visible; }
        .modal-dialog { margin: 0; width: 100%; max-width: 100%; }
        .modal-content { border: none; box-shadow: none; background: white !important; color: black !important; }
        .mp-sidebar, .mp-footer, .btn-close, .btn, .mp-copy-btn { display: none !important; }
        .mp-content { width: 100%; padding: 0; background: white !important; }
        .mp-value-box { background: #f8f9fa !important; border: 1px solid #dee2e6 !important; color: black !important; }
        .mp-value-text { color: black !important; }
        .badge { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; }
    }
</style>

<!-- Modal Header -->
<div class="modal-header border-bottom-0 p-4 pb-0">
    <div class="d-flex align-items-center w-100">
        <!-- Left: Title & ID -->
        <div class="d-flex align-items-center gap-3">
            @php
                $currentDesc = strtolower($activity->description);
                $headerIcon = match(true) {
                    $currentDesc == 'created' => 'ri-add-circle-line',
                    $currentDesc == 'updated' => 'ri-edit-circle-line',
                    $currentDesc == 'deleted' => 'ri-delete-bin-line',
                    str_contains($currentDesc, 'test') => 'ri-test-tube-line',
                    str_contains($currentDesc, 'login') => 'ri-login-circle-line',
                    default => 'ri-information-line'
                };
                $headerColor = match(true) {
                    $currentDesc == 'created' => '#22c55e', // success
                    $currentDesc == 'updated' => '#eab308', // warning
                    $currentDesc == 'deleted' => '#ef4444', // danger
                    str_contains($currentDesc, 'test') => '#d500f9', // primary/brand
                    str_contains($currentDesc, 'login') => '#3b82f6', // info
                    default => '#d500f9' // brand accent
                };
                $headerBg = match(true) {
                    $currentDesc == 'created' => 'rgba(34, 197, 94, 0.1)',
                    $currentDesc == 'updated' => 'rgba(234, 179, 8, 0.1)',
                    $currentDesc == 'deleted' => 'rgba(239, 68, 68, 0.1)',
                    str_contains($currentDesc, 'test') => 'rgba(213, 0, 249, 0.1)',
                    str_contains($currentDesc, 'login') => 'rgba(59, 130, 246, 0.1)',
                    default => 'rgba(213, 0, 249, 0.1)'
                };
            @endphp
            <div class="mp-icon-box rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: {{ $headerBg }}; color: {{ $headerColor }}; font-size: 20px;">
                <i class="{{ $headerIcon }}"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold lh-1" style="color: var(--mp-text-primary); font-size: 1rem;">Fəaliyyət Detalları</h5>
                <div class="d-flex align-items-center gap-2 mt-1" style="color: var(--mp-text-muted); font-size: 0.75rem;">
                    <span class="font-monospace fw-medium opacity-75">#{{ $activity->id }}</span>
                    <i class="ri-checkbox-blank-circle-fill" style="font-size: 4px; opacity: 0.3;"></i>
                    <span class="fw-medium" style="color: var(--mp-accent);">
                        {{ class_basename($activity->subject_type) }}
                    </span>
                    @if($activity->event == 'created')
                        <i class="ri-checkbox-blank-circle-fill" style="font-size: 4px; opacity: 0.3;"></i>
                        <span class="text-success fw-medium">Yaradıldı</span>
                    @elseif($activity->event == 'updated')
                        <i class="ri-checkbox-blank-circle-fill" style="font-size: 4px; opacity: 0.3;"></i>
                        <span class="text-warning fw-medium">Yeniləndi</span>
                    @elseif($activity->event == 'deleted')
                        <i class="ri-checkbox-blank-circle-fill" style="font-size: 4px; opacity: 0.3;"></i>
                        <span class="text-danger fw-medium">Silindi</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Unified Actions Toolbar -->
        <div class="d-flex align-items-center ms-auto px-2 py-1 rounded-pill" style="background: var(--mp-bg-card); border: 1px solid var(--mp-border); height: 42px;">
            
            <!-- View Mode Toggle -->
            <div class="d-flex align-items-center gap-2 px-2">
                <span class="fw-bold text-uppercase" style="color: var(--mp-text-muted); font-size: 0.65rem; letter-spacing: 0.5px;">Visual</span>
                <div class="form-check form-switch mb-0 min-h-auto d-flex align-items-center">
                    <input class="form-check-input mt-0" type="checkbox" id="viewToggle" onchange="toggleView()" style="cursor: pointer;">
                </div>
                <span class="fw-bold text-uppercase" style="color: var(--mp-text-muted); font-size: 0.65rem; letter-spacing: 0.5px;">JSON</span>
            </div>

            <div class="vr opacity-25 mx-1 align-self-center" style="height: 16px; color: var(--mp-text-muted);"></div>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-1 px-1">
                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; color: var(--mp-text-muted);" onclick="exportAudit({{ $activity->id }})" title="Eksport (PDF/JSON)">
                    <i class="ri-file-download-line fs-16"></i>
                </button>
                
                <button type="button" class="btn btn-icon btn-sm btn-ghost-warning rounded-circle d-flex align-items-center justify-content-center text-warning" style="width: 32px; height: 32px;" onclick="revertActivity({{ $activity->id }})" title="Geri qaytar">
                    <i class="ri-history-line fs-16"></i>
                </button>

                @if($activity->subject_id && $activity->subject_type && Route::has('admin.'.Str::kebab(class_basename($activity->subject_type)).'.edit'))
                <a href="{{ route('admin.'.Str::kebab(class_basename($activity->subject_type)).'.edit', $activity->subject_id) }}" 
                   class="btn btn-icon btn-sm btn-ghost-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; color: var(--mp-accent);" title="Düzəliş et">
                    <i class="ri-external-link-line fs-16"></i>
                </a>
                @endif
            </div>

            <div class="vr opacity-25 mx-1 align-self-center" style="height: 16px; color: var(--mp-text-muted);"></div>

            <!-- Close Button -->
            <button type="button" class="btn btn-icon btn-sm btn-ghost-danger rounded-circle d-flex align-items-center justify-content-center ms-1" style="width: 32px; height: 32px;" data-bs-dismiss="modal" title="Bağla">
                <i class="ri-close-line fs-18"></i>
            </button>
        </div>
    </div>
</div>
<div class="modal-body">
    <!-- Left Column: Time Machine (History) -->
    <div class="mp-sidebar d-flex flex-column">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--mp-border);">
            <h6 class="text-uppercase fs-11 fw-bold mb-0" style="color: var(--mp-text-muted);">Zaman Lenti</h6>
            @php
                if($activity->subject_type && $activity->subject_id) {
                    $baseQuery = \Spatie\Activitylog\Models\Activity::query()
                        ->where('subject_type', $activity->subject_type)
                        ->where('subject_id', $activity->subject_id);
                        
                    $totalHistory = $baseQuery->count();
                    $history = $baseQuery->latest()->take(100)->get();
                } else {
                    $history = collect([$activity]);
                    $totalHistory = 1;
                }
            @endphp
            <span class="badge bg-soft-primary rounded-pill">{{ $totalHistory }} Dəyişiklik</span>
        </div>
        
        <!-- Search Input -->
        <div class="px-3 py-2 border-bottom" style="border-color: var(--mp-border) !important;">
            <div class="position-relative">
                <input type="text" class="form-control form-control-sm bg-light border-0 ps-4" placeholder="Axtar..." onkeyup="filterTimeline(this.value)" style="font-size: 12px;">
                <i class="ri-search-line position-absolute top-50 start-0 translate-middle-y ms-2 text-muted fs-12"></i>
            </div>
        </div>

        <div class="overflow-auto custom-scrollbar flex-grow-1" style="max-height: calc(100vh - 245px);">
            @foreach($history as $hist)
                @php
                    $desc = strtolower($hist->description);
                    $badgeColor = match(true) {
                        $desc == 'created' => 'success',
                        $desc == 'updated' => 'warning',
                        $desc == 'deleted' => 'danger',
                        str_contains($desc, 'test') => 'primary',
                        str_contains($desc, 'login') => 'info',
                        default => 'secondary'
                    };
                    $badgeIcon = match(true) {
                        $desc == 'created' => 'ri-add-circle-line',
                        $desc == 'updated' => 'ri-edit-circle-line',
                        $desc == 'deleted' => 'ri-delete-bin-line',
                        str_contains($desc, 'test') => 'ri-test-tube-line',
                        str_contains($desc, 'login') => 'ri-login-circle-line',
                        default => 'ri-information-line'
                    };
                @endphp
                <div class="mp-timeline-item {{ $hist->id == $activity->id ? 'active' : '' }}" 
                     onclick="loadActivityModal({{ $hist->id }})">
                    
                    <!-- Avatar Node -->
                    <div class="avatar-xs flex-shrink-0">
                        <div class="avatar-title rounded-circle fs-10" style="background: var(--mp-bg-card); color: var(--mp-text-primary); border: 1px solid var(--mp-border);">
                            {{ substr($hist->causer->name ?? 'S', 0, 1) }}
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="fs-12 fw-bold text-truncate mp-search-target" style="color: var(--mp-text-primary); max-width: 120px;">
                            {{ $hist->causer->name ?? 'Sistem' }}
                        </div>
                        <span class="fs-10 font-monospace text-muted mp-search-date">{{ $hist->created_at->format('H:i') }}</span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2 mp-search-desc">
                        <span class="badge bg-soft-{{ $badgeColor }} text-{{ $badgeColor }} border border-{{ $badgeColor }} border-opacity-25 fs-10 rounded-pill px-2 py-0">
                            <i class="{{ $badgeIcon }} me-1"></i> {{ $hist->description }}
                        </span>
                    </div>
                </div>
            @endforeach
            <div id="no-results" class="d-none text-center py-4 text-muted fs-11">
                Nəticə tapılmadı
            </div>
        </div>
    </div>




    <!-- Right Column: Content -->
    <div class="mp-content d-flex flex-column">
        <!-- 16. Session Context -->
        <!-- 16. Session Context (Dynamic) -->
        @php
            // Calculate session context dynamically from history
            $sessionStart = $activity->created_at->subMinutes(30);
            $sessionEnd = $activity->created_at->addMinutes(30);
            
            $sessionActivities = $history->filter(function($item) use ($activity, $sessionStart, $sessionEnd) {
                return $item->causer_id == $activity->causer_id 
                    && $item->id != $activity->id
                    && $item->created_at->between($sessionStart, $sessionEnd);
            });
            
            $sessionCount = $sessionActivities->count();
        @endphp
        
        @if($sessionCount > 0)
        <div class="mp-session-context m-3 rounded-3 border" style="background: rgba(59, 130, 246, 0.05); border-color: rgba(59, 130, 246, 0.1) !important;">
            <div class="d-flex align-items-center gap-3 p-3">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-soft-info text-info" style="width: 32px; height: 32px;">
                    <i class="ri-pulse-line fs-16"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fs-11 text-uppercase fw-bold text-info opacity-75 mb-1">Sessiya Konteksti</div>
                    <div class="fs-13 text-white">Bu istifadəçi +/- 30 dəqiqə ərzində <strong class="text-info">{{ $sessionCount }} oxşar əməliyyat</strong> icra edib.</div>
                </div>
                <button class="btn btn-sm btn-soft-info rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#sessionContextList">
                    Siyahı <i class="ri-arrow-down-s-line ms-1"></i>
                </button>
            </div>
            
            <div class="collapse" id="sessionContextList">
                <div class="p-3 pt-0">
                    <div class="bg-soft-info rounded-3 p-2">
                        <ul class="list-unstyled mb-0 fs-12">
                            @foreach($sessionActivities->take(5) as $sAct)
                                <li class="d-flex justify-content-between align-items-center p-2 rounded hover-bg-white-10 mb-1">
                                    <span class="text-white-50">{{ $sAct->description }}</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="font-monospace text-muted fs-10">{{ $sAct->created_at->format('H:i') }}</span>
                                        <a href="#" onclick="loadActivityModal({{ $sAct->id }})" class="btn btn-xs btn-icon btn-ghost-info rounded-circle"><i class="ri-arrow-right-line"></i></a>
                                    </div>
                                </li>
                            @endforeach
                            @if($sessionCount > 5)
                                <li class="text-center text-muted fs-10 mt-2">+{{ $sessionCount - 5 }} daha çox...</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Visual View -->
        <div id="visualView" class="flex-grow-1">
            @if(isset($activity->properties['attributes']))
                @php
                    // Field Mapping & Grouping Logic
                    $groups = [
                        'General' => ['name', 'title', 'slug', 'status', 'is_active', 'type'],
                        'SEO' => ['meta_title', 'meta_description', 'meta_keywords'],
                        'Media' => ['image', 'icon', 'gallery', 'file'],
                        'System' => ['id', 'created_at', 'updated_at', 'deleted_at'],
                        'Security' => ['password', 'email', 'phone', 'role']
                    ];
                    
                    $changes = [];
                    $allKeys = array_keys($activity->properties['attributes']);
                    foreach($activity->properties['attributes'] as $key => $newValue) {
                        if(in_array($key, ['updated_at', 'created_at', 'deleted_at'])) continue;
                        
                        // Filter generic fields if localized version exists
                        if (in_array($key . '_az', $allKeys)) continue;

                        // FIX: For 'updated' events, only show fields that are actually in 'old' (dirty fields).
                        // If we don't check this, unchanged fields in 'attributes' (which are not in 'old') 
                        // will appear as New Value vs Null (Old), looking like they changed.
                        if ($activity->event === 'updated') {
                             if (!isset($activity->properties['old']) || !array_key_exists($key, $activity->properties['old'])) {
                                 continue;
                             }
                        }

                        $oldValue = $activity->properties['old'][$key] ?? null;
                        
                        // Strict comparison (recurisve handled by blade component later)
                        if ($oldValue != $newValue) {
                            // Determine Group
                            $groupName = 'Other';
                            foreach($groups as $gName => $fields) {
                                if(in_array($key, $fields)) {
                                    $groupName = $gName;
                                    break;
                                }
                            }
                            $changes[$groupName][] = ['key' => $key, 'old' => $oldValue, 'new' => $newValue];
                        }
                    }
                @endphp

                @if(count($changes) > 0)
                    @foreach($changes as $group => $items)
                        @php
                            $impactLevel = 'Low';
                            $impactColor = 'success';
                            if ($group == 'Security') { $impactLevel = 'Critical'; $impactColor = 'danger'; }
                            elseif ($group == 'System') { $impactLevel = 'High'; $impactColor = 'warning'; }
                            elseif ($group == 'SEO') { $impactLevel = 'Medium'; $impactColor = 'info'; }
                        @endphp
                        <div class="mp-group-header mt-4 mb-2">
                            <span>{{ $group }}</span>
                            <div class="mp-group-line"></div>
                            <span class="badge bg-soft-{{ $impactColor }} text-{{ $impactColor }}">{{ $impactLevel }} Impact</span>
                        </div>

                        @foreach($items as $item)
                            @php
                                $key = $item['key'];
                                $oldValue = $item['old'];
                                $newValue = $item['new'];
                                $isCode = in_array($key, ['properties', 'attributes', 'old']);
                                $isSensitive = in_array($key, ['password', 'token', 'secret']);
                            @endphp
                            <div class="mp-card {{ $impactLevel == 'Critical' ? 'critical-impact' : '' }}">
                                <div class="mp-card-header px-3 py-2 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--mp-border); background: rgba(255,255,255,0.01);">
                                    <span class="font-monospace fs-11 text-uppercase text-muted">{{ $key }}</span>
                                    @if($isSensitive)
                                        <i class="ri-eye-off-line text-danger" title="Sensitive Data"></i>
                                    @endif
                                </div>
                                
                                <!-- Sub-headers for Old/New Values -->
                                <div class="d-flex border-bottom" style="border-color: var(--mp-border);">
                                    <div class="w-50 px-3 py-1 fs-10 fw-bold text-uppercase text-muted border-end" style="border-color: var(--mp-border); background: rgba(255,255,255,0.005);">
                                        Köhnə Dəyər
                                    </div>
                                    <div class="w-50 px-3 py-1 fs-10 fw-bold text-uppercase text-muted" style="background: rgba(255,255,255,0.005);">
                                        Yeni Dəyər
                                    </div>
                                </div>
                                
                                <div class="mp-value-row">
                                    <!-- Old Value -->
                                    <div class="mp-value-box old position-relative" style="padding-bottom: 30px;">
                                        <button class="mp-copy-btn" onclick="copyToClipboard(`{{ is_string($oldValue) ? $oldValue : json_encode($oldValue) }}`)">Copy</button>
                                        <div class="mp-value-text {{ $oldValue ? 'filled' : '' }} {{ $isCode ? 'monospace' : '' }} {{ $isSensitive ? 'mp-blur' : '' }}">
                                            @if(is_array($oldValue))
                                                <pre class="mb-0 fs-10 text-muted w-100">{{ json_encode($oldValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            @elseif(is_bool($oldValue))
                                                {{ $oldValue ? 'True' : 'False' }}
                                            @elseif(empty($oldValue))
                                                <div class="mp-empty-state"><i class="ri-prohibited-line"></i> Boş</div>
                                            @else
                                                {{ $oldValue }}
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Arrow -->
                                    <div class="mp-arrow-container">
                                        <i class="ri-arrow-right-line mp-arrow-icon"></i>
                                    </div>

                                    <!-- New Value -->
                                    <!-- New Value -->
                                    <div class="mp-value-box border-start new position-relative" style="border-color: var(--mp-border); padding-bottom: 30px;">
                                        <button class="mp-copy-btn" onclick="copyToClipboard(`{{ is_string($newValue) ? $newValue : json_encode($newValue) }}`)">Copy</button>
                                        
                                        <div class="mp-value-text {{ $newValue ? 'filled' : '' }} {{ $isCode ? 'monospace' : '' }} {{ $isSensitive ? 'mp-blur' : '' }}" onclick="this.classList.add('revealed')">
                                            @if(is_array($newValue) && is_array($oldValue))
                                                <!-- Recursive Smart Diff -->
                                                <div class="mt-2 p-2 rounded border" style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.05) !important;">
                                                    <h6 class="fs-10 text-uppercase text-muted mb-2 ls-1">Struktur Dəyişikliyi:</h6>
                                                    @php
                                                        $diffTree = compute_recursive_diff($oldValue, $newValue);
                                                    @endphp
                                                    <x-activity-log.diff-tree :diff="$diffTree" />
                                                </div>
                                            @elseif(is_array($newValue))
                                                <pre class="mb-0 fs-10 text-muted w-100">{{ json_encode($newValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            @elseif(is_bool($newValue))
                                                {{ $newValue ? 'True' : 'False' }}
                                            @elseif(empty($newValue))
                                                <div class="mp-empty-state"><i class="ri-prohibited-line"></i> Boş</div>
                                            @else
                                                {{ $newValue }}
                                            @endif
                                        </div>
                                        
                                        @if(is_string($newValue) && strlen($newValue) > 50)
                                            <button class="btn btn-xs btn-soft-primary position-absolute bottom-0 end-0 m-2" 
                                                    onclick="showDiff(`{{ addslashes($oldValue) }}`, `{{ addslashes($newValue) }}`, 'diff-{{ $activity->id }}-{{ $key }}')">
                                                <i class="ri-file-search-line me-1"></i> Smart Diff
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Diff Container -->
                                <div id="diff-container-{{ $activity->id }}-{{ $key }}" class="d-none px-3 pb-3 border-top bg-soft-warning" style="border-color: var(--mp-border); background: rgba(255, 240, 0, 0.05);">
                                    <div class="d-flex align-items-center justify-content-between mt-2 mb-2">
                                        <span class="badge bg-warning text-dark">Dəyişiklik Analizi</span>
                                        <small class="text-muted">Smart Diff</small>
                                    </div>
                                    <div id="diff-{{ $activity->id }}-{{ $key }}" class="p-3 rounded font-monospace fs-12 border" style="background: var(--mp-bg-main); color: var(--mp-text-primary); border-color: var(--mp-border) !important;"></div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title rounded-circle" style="background: var(--mp-bg-card); color: var(--mp-text-muted);">
                                <i class="ri-file-shred-line fs-36"></i>
                            </div>
                        </div>
                        <h5 style="color: var(--mp-text-primary);">Heç bir dəyişiklik tapılmadı</h5>
                    </div>
                @endif
            @endif
            
            <!-- Admin Note -->
            <div class="accordion accordion-flush mt-4" id="adminNoteAccordion">
                <div class="accordion-item" style="background: transparent; border: none;">
                    <h2 class="accordion-header">
                        <button class="accordion-button mp-accordion-btn collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#adminNoteCollapse">
                            <span class="d-flex align-items-center gap-2">
                                <i class="ri-sticky-note-line"></i> ADMIN QEYDI
                            </span>
                        </button>
                    </h2>
                    <div id="adminNoteCollapse" class="accordion-collapse collapse" data-bs-parent="#adminNoteAccordion">
                        <div class="mp-accordion-body rounded-bottom-3">
                            <textarea class="form-control mp-textarea fs-13" 
                                      id="note-{{ $activity->id }}" 
                                      rows="3" 
                                      placeholder="Bu fəaliyyət haqqında qeyd yazın..."
                                      style="resize: none;">{{ $activity->getExtraProperty('admin_note') }}</textarea>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-sm btn-soft-success" onclick="saveNote({{ $activity->id }})">
                                    <i class="ri-save-line me-1"></i> Yadda saxla
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- JSON View -->
        <div id="jsonView" style="display: none;">
            <pre class="mp-json-view">{{ json_encode($activity->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>

        <!-- Footer -->
        <div class="mp-footer mt-auto">
            <div class="row g-0">
                <!-- User -->
                <div class="col-6 col-md-3">
                    <div class="mp-footer-item">
                        <div class="mp-footer-icon">
                            <i class="ri-user-3-line"></i>
                        </div>
                        <div class="overflow-hidden">
                            <div class="mp-footer-label">İCRAÇI</div>
                            <div class="mp-footer-value">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="text-truncate fw-bold" style="max-width: 100px;" title="{{ $activity->causer->name ?? 'Sistem' }}">{{ $activity->causer->name ?? 'Sistem' }}</span>
                                    @if($activity->causer && $activity->causer->roles->isNotEmpty())
                                        <span class="badge bg-soft-primary ms-2" style="font-size: 0.6rem;">{{ $activity->causer->roles->first()->name }}</span>
                                    @endif
                                </div>
                                @if($activity->causer)
                                    <div class="d-flex flex-column gap-0">
                                        <div class="fs-10 text-muted text-truncate" title="{{ $activity->causer->email }}">
                                            <i class="ri-mail-line me-1 opacity-50"></i>{{ $activity->causer->email }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Date -->
                <div class="col-6 col-md-3">
                    <div class="mp-footer-item">
                        <div class="mp-footer-icon">
                            <i class="ri-calendar-line"></i>
                        </div>
                        <div>
                            <div class="mp-footer-label">TARIX</div>
                            <div class="mp-footer-value font-monospace">
                                {{ $activity->created_at->format('d.m.Y') }}
                                <div class="text-muted fs-10">{{ $activity->created_at->format('H:i:s') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- IP -->
                <div class="col-6 col-md-3">
                    <div class="mp-footer-item">
                        <div class="mp-footer-icon">
                            <i class="ri-map-pin-line"></i>
                        </div>
                        <div class="overflow-hidden">
                            <div class="mp-footer-label">IP & MƏKAN</div>
                            <div class="mp-footer-value">
                                <div class="d-flex align-items-center gap-2 font-monospace mb-1">
                                    <span id="ip-{{ $activity->id }}">{{ $activity->causer_ip ?? $activity->getExtraProperty('ip') ?? '-' }}</span>
                                    <span id="location-{{ $activity->id }}" class="d-flex align-items-center gap-1"></span>
                                    <i class="ri-file-copy-line text-muted cursor-pointer opacity-50 hover-opacity-100 fs-12" onclick="copyToClipboard('{{ $activity->causer_ip ?? $activity->getExtraProperty('ip') }}')" title="IP Kopyala"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Device -->
                <div class="col-6 col-md-3">
                    <div class="mp-footer-item">
                        <div class="mp-footer-icon">
                            <i class="ri-device-line"></i>
                        </div>
                        <div class="overflow-hidden">
                            <div class="mp-footer-label">CIHAZ</div>
                            @php
                                $agent = new \Jenssegers\Agent\Agent();
                                $ua = $activity->getExtraProperty('user_agent');
                                if ($ua) {
                                    $agent->setUserAgent($ua);
                                    $platform = $agent->platform();
                                    $browser = $agent->browser();
                                    $platformMap = ['Windows' => 'Windows', 'OS X' => 'macOS', 'iOS' => 'iOS', 'Android' => 'Android', 'Linux' => 'Linux'];
                                    $platform = $platformMap[$platform] ?? $platform;
                                } else {
                                    $platform = 'Bilinmir';
                                    $browser = 'Bilinmir';
                                }
                            @endphp
                            <div class="mp-footer-value text-truncate d-flex align-items-center gap-1" style="max-width: 150px; cursor: pointer;" 
                                 tabindex="0"
                                 data-bs-toggle="popover" 
                                 data-bs-trigger="focus click" 
                                 data-bs-custom-class="custom-popover"
                                 data-bs-content="<div class='fs-11 font-monospace mb-2'>{{ $ua ?? 'User Agent məlumatı yoxdur' }}</div>@if($ua)<button class='btn btn-xs btn-soft-primary w-100' onclick='copyToClipboard(`{{ $ua }}`)'>Kopyala</button>@endif" 
                                 data-bs-html="true">
                                {{ $platform ?: 'Bilinmir' }} / {{ $browser ?: 'Bilinmir' }} <i class="ri-information-fill text-muted opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
     onload="
        (function() {
            var ip = '{{ $activity->causer_ip ?? $activity->getExtraProperty('ip') }}';
            var id = '{{ $activity->id }}';
            var el = document.getElementById('location-' + id);
            
            if(ip && ip != '127.0.0.1' && el) {
                fetch('{{ route("admin.api.ip-info", "") }}/' + ip)
                .then(r => r.json())
                .then(d => {
                    if(d.status == 'success') {
                        var flagUrl = 'https://flagcdn.com/16x12/' + d.countryCode.toLowerCase() + '.png';
                        var flagImg = '<img src=\'' + flagUrl + '\' width=\'16\' height=\'12\' alt=\'' + d.countryCode + '\' class=\'ms-1\'>';
                        el.innerHTML = flagImg + ' <span class=\'text-muted opacity-75 ms-1\'>' + d.city + '</span>';
                        el.title = d.city + ', ' + d.country;
                    }
                })
                .catch(e => { console.error(e); });
            }
        })();
     "
     style="display:none;">

<script>
    function toggleView() {
        const isJson = document.getElementById('viewToggle').checked;
        document.getElementById('visualView').style.display = isJson ? 'none' : 'block';
        document.getElementById('jsonView').style.display = isJson ? 'block' : 'none';
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Kopyalandı!',
                showConfirmButton: false,
                timer: 1500,
                background: '#1e293b',
                color: '#fff'
            });
        });
    }

    function exportAudit(id) {
        Swal.fire({
            title: 'Audit Export',
            text: 'Formatı seçin:',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'PDF',
            denyButtonText: 'JSON',
            background: '#1e293b',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                // PDF / Print Mode
                window.print();
            } else if (result.isDenied) {
                // JSON Export
                const data = document.querySelector('.mp-json-view').innerText;
                const blob = new Blob([data], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'audit-log-' + id + '.json';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        });
    }

    function saveNote(id) {
        let note = document.getElementById('note-' + id).value;
        axios.post('/admin/activity-log/' + id + '/note', { note: note })
            .then(response => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Qeyd yadda saxlanıldı',
                    showConfirmButton: false,
                    timer: 2000,
                    background: '#1e293b',
                    color: '#fff'
                });
            })
            .catch(error => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Xəta baş verdi',
                    showConfirmButton: false,
                    timer: 2000,
                    background: '#1e293b',
                    color: '#fff'
                });
            });
    }

    function showDiff(oldText, newText, elementId) {
        const container = document.getElementById('diff-container-' + elementId.replace('diff-', ''));
        const content = document.getElementById(elementId);
        
        if (!container.classList.contains('d-none')) {
            container.classList.add('d-none');
            return;
        }

        // Simple Word Diff Algorithm
        const oldWords = oldText ? oldText.split(/\s+/) : [];
        const newWords = newText ? newText.split(/\s+/) : [];
        let html = '';
        
        let i = 0, j = 0;
        while (i < oldWords.length || j < newWords.length) {
            if (i < oldWords.length && j < newWords.length && oldWords[i] === newWords[j]) {
                html += '<span class="text-muted opacity-50">' + oldWords[i] + ' </span>';
                i++; j++;
            } else {
                if (i < oldWords.length) {
                    html += '<span class="text-danger text-decoration-line-through bg-soft-danger px-1 rounded">' + oldWords[i] + '</span> ';
                    i++;
                }
                if (j < newWords.length) {
                    html += '<span class="text-success fw-bold bg-soft-success px-1 rounded">' + newWords[j] + '</span> ';
                    j++;
                }
            }
        }

        content.innerHTML = html;
        container.classList.remove('d-none');
    }

    function revertActivity(id) {
        // Check current theme
        const isDarkMode = document.documentElement.getAttribute('data-theme') === 'dark' || document.body.classList.contains('dark-mode');
        
        // Colors based on theme
        const colors = isDarkMode ? {
            bg: 'rgba(30, 41, 59, 0.95)',
            border: 'rgba(168, 85, 247, 0.3)',
            text: '#f1f5f9',
            textSub: '#94a3b8',
            primary: '#a855f7',
            primaryRgb: '168, 85, 247'
        } : {
            bg: 'rgba(255, 255, 255, 0.95)',
            border: 'rgba(75, 0, 130, 0.3)',
            text: '#1a1a2e',
            textSub: '#555',
            primary: '#4b0082',
            primaryRgb: '75, 0, 130'
        };

        Swal.fire({
            title: `<div style="display: flex; align-items: center; gap: 10px; justify-content: center;">
                <i class="ri-history-line" style="color: ${colors.primary}; font-size: 2rem;"></i>
                <span style="color: ${colors.text};">Əminsiniz?</span>
            </div>`,
            html: `<p style="font-size: 15px; color: ${colors.textSub}; margin: 20px 0;">
                Bu dəyişikliyi geri qaytarmaq istədiyinizə əminsiniz?<br>
                <span style="color: ${colors.textSub}; font-size: 13px; opacity: 0.8;">Məlumatlar əvvəlki halına bərpa olunacaq.</span>
            </p>`,
            showCancelButton: true,
            confirmButtonText: '<i class="ri-arrow-go-back-line me-1"></i> Bəli, geri qaytar',
            cancelButtonText: '<i class="ri-close-line me-1"></i> Ləğv et',
            confirmButtonColor: colors.primary,
            cancelButtonColor: isDarkMode ? '#64748b' : '#94a3b8',
            background: colors.bg,
            color: colors.text,
            customClass: {
                popup: 'swal-glass-popup',
                title: 'swal-glass-title',
                htmlContainer: 'swal-glass-content',
                confirmButton: 'swal-glass-confirm',
                cancelButton: 'swal-glass-cancel',
                actions: 'swal-glass-actions'
            },
            backdrop: 'rgba(0, 0, 0, 0.7)',
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/admin/activity-log/' + id + '/revert')
                    .then(response => {
                        Swal.fire({
                            title: `<div style="color: ${colors.text}">Uğurlu!</div>`,
                            text: 'Dəyişikliklər geri qaytarıldı.',
                            icon: 'success',
                            background: colors.bg,
                            color: colors.text,
                            confirmButtonColor: colors.primary,
                            customClass: {
                                popup: 'swal-glass-popup',
                                confirmButton: 'swal-glass-confirm'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: `<div style="color: ${colors.text}">Xəta!</div>`,
                            text: 'Xəta baş verdi: ' + (error.response?.data?.message || 'Bilinməyən xəta'),
                            icon: 'error',
                            background: colors.bg,
                            color: colors.text,
                            confirmButtonColor: colors.primary,
                            customClass: {
                                popup: 'swal-glass-popup',
                                confirmButton: 'swal-glass-confirm'
                            }
                        });
                    });
            }
        });
    }
</script>
