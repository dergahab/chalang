@extends('admin.layouts.main')
@section('heading_title', 'Dashboard')

@section('content')
<div class="dashboard-wrap">
    <div class="dashboard-sortable-stack" id="dashboard-sortable-top">
        <div class="dashboard-sortable-item" data-id="hero">
            <div class="dashboard-drag-handle drag-handle" title="Drag">
                <i class="ri-drag-move-2-line"></i>
            </div>
            <div class="dashboard-hero glass-card">
        <div class="hero-meta">
            <div>
                <p class="hero-eyebrow">Xoş gəldiniz</p>
                <h2 class="hero-title">Dashboard</h2>
                <p class="hero-subtitle">Son göstəriciləri izləyin və modullara tez keçin.</p>
                <div class="hero-actions">
                    @can('service.create')
                    <a href="{{ route('admin.service.index') }}" class="btn-vision-primary">Yeni xidmət əlavə et</a>
                    @endcan
                    @can('portfolio.create')
                    <a href="{{ route('admin.portfolio.index') }}" class="btn-vision-ghost">Yeni layihə əlavə et</a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="hero-cards">
            @can('service.index')
            <div class="hero-mini-card">
                <span class="mini-label">Xidmətlər</span>
                <div class="mini-value">{{ $stats['services'] }}</div>
                <span class="mini-change positive"><i class="ri-arrow-up-line"></i> +12%</span>
            </div>
            @endcan
            @can('portfolio.index')
            <div class="hero-mini-card">
                <span class="mini-label">Layihələr</span>
                <div class="mini-value">{{ $stats['portfolios'] }}</div>
                <span class="mini-change positive"><i class="ri-arrow-up-line"></i> +8%</span>
            </div>
            @endcan
            @can('message.index')
            <div class="hero-mini-card">
                <span class="mini-label">Mesajlar</span>
                <div class="mini-value">{{ $stats['messages'] }}</div>
                <span class="mini-change neutral"><i class="ri-mail-line"></i></span>
            </div>
            @endcan
            @can('blog.index')
            <div class="hero-mini-card">
                <span class="mini-label">Bloqlar</span>
                <div class="mini-value">{{ $stats['blogs'] }}</div>
                <span class="mini-change neutral"><i class="ri-article-line"></i></span>
            </div>
            @endcan
        </div>
            </div>
        </div>

    @role('super-admin')
        <div class="dashboard-sortable-item" data-id="system_management">
            <div class="dashboard-drag-handle drag-handle" title="Drag">
                <i class="ri-drag-move-2-line"></i>
            </div>
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3 text-muted">Sistem İdarəetməsi</h5>
        </div>
        <div class="col-md-3">
            <div class="hero-mini-card glass-card">
                <span class="mini-label">İstifadəçilər</span>
                <div class="mini-value">{{ $stats['users'] }}</div>
                <span class="mini-change neutral"><i class="ri-user-settings-line"></i></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="hero-mini-card glass-card">
                <span class="mini-label">Rollar</span>
                <div class="mini-value">{{ $stats['roles'] }}</div>
                <span class="mini-change neutral"><i class="ri-shield-user-line"></i></span>
            </div>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.settings.index') }}" class="hero-mini-card glass-card text-decoration-none">
                <span class="mini-label">Tənzimləmələr</span>
                <div class="mini-value"><i class="ri-settings-3-line"></i></div>
                <span class="mini-change neutral">Keçid et</span>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.activity-log.index') }}" class="hero-mini-card glass-card text-decoration-none">
                <span class="mini-label">Audit Log</span>
                <div class="mini-value"><i class="ri-file-history-line"></i></div>
                <span class="mini-change neutral">Keçid et</span>
            </a>
        </div>
    </div>
    </div>
    @endrole

    @role('super-admin')
        <div class="dashboard-sortable-item" data-id="ops">
            <div class="dashboard-drag-handle drag-handle" title="Drag">
                <i class="ri-drag-move-2-line"></i>
            </div>
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3 text-muted">Sistem Sağlamlığı (Ops)</h5>
        </div>
        <!-- Health Pulse Widget -->
        <div class="col-md-6">
            <div class="glass-card p-3 h-100 position-relative">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 fw-bold"><i class="ri-heart-pulse-line text-danger me-2"></i> Sistem Statusu</h6>
                    <span class="badge bg-soft-secondary text-secondary" id="health-last-check"><i class="ri-loader-4-line ri-spin"></i></span>
                </div>
                <div class="row g-3">
                    <div class="col-4 text-center border-end border-white-10">
                        <p class="text-muted small mb-1">Database</p>
                        <div id="health-db-indicator" class="spinner-border spinner-border-sm text-primary opacity-50" role="status"></div>
                        <div id="health-db-latency" class="small text-muted mt-1" style="font-size: 10px;">-</div>
                    </div>
                    <div class="col-4 text-center border-end border-white-10">
                        <p class="text-muted small mb-1">Cache</p>
                        <div id="health-cache-indicator" class="spinner-border spinner-border-sm text-primary opacity-50" role="status"></div>
                        <div id="health-cache-latency" class="small text-muted mt-1" style="font-size: 10px;">-</div>
                    </div>
                    <div class="col-4 text-center">
                        <p class="text-muted small mb-1">Disk</p>
                        <h6 id="health-disk" class="mb-0">-</h6>
                        <div class="progress mt-2" style="height: 4px; background: rgba(255,255,255,0.1);">
                            <div id="health-disk-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- External Links Widget -->
        <div class="col-md-6">
            <div class="glass-card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 fw-bold"><i class="ri-external-link-line text-info me-2"></i> External Monitoring</h6>
                </div>
                <div class="d-flex gap-2">
                    <a href="https://sentry.io" target="_blank" class="btn btn-sm btn-vision-ghost flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                        <i class="ri-bug-line"></i> Sentry
                    </a>
                    <a href="https://newrelic.com" target="_blank" class="btn btn-sm btn-vision-ghost flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                        <i class="ri-bar-chart-groupped-line"></i> APM
                    </a>
                    <a href="https://search.google.com/search-console" target="_blank" class="btn btn-sm btn-vision-ghost flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                        <i class="ri-google-line"></i> GSC
                    </a>
                </div>
            </div>
        </div>
    </div>
        </div>
    @endrole
    <div class="dashboard-sortable-item" data-id="quick_actions">
        <div class="dashboard-drag-handle drag-handle" title="Drag">
            <i class="ri-drag-move-2-line"></i>
        </div>
    <div class="quick-actions glass-card">
        <div class="qa-head">
            <div>
                <p class="stat-label">Tez əmrlər</p>
                <h4 class="mb-0">Əlavə et / İdarə et</h4>
            </div>
        </div>
        <div class="qa-grid">
            @can('service.create')
            <a href="{{ route('admin.service.create') }}" class="qa-card">
                <div class="qa-icon"><i class="ri-service-line"></i></div>
                <div class="qa-meta">
                    <p class="qa-title">Xidmət</p>
                    <span class="qa-sub">Yeni xidmət əlavə et</span>
                </div>
            </a>
            @endcan
            @can('portfolio.create')
            <a href="{{ route('admin.portfolio.create') }}" class="qa-card">
                <div class="qa-icon"><i class="ri-gallery-line"></i></div>
                <div class="qa-meta">
                    <p class="qa-title">Layihə</p>
                    <span class="qa-sub">Portfolioya yeni iş</span>
                </div>
            </a>
            @endcan
            @can('blog.create')
            <a href="{{ route('admin.blog.create') }}" class="qa-card">
                <div class="qa-icon"><i class="ri-article-line"></i></div>
                <div class="qa-meta">
                    <p class="qa-title">Bloq</p>
                    <span class="qa-sub">Paylaşım dərc et</span>
                </div>
            </a>
            @endcan
            @can('message.index')
            <a href="{{ route('admin.message.index') }}" class="qa-card">
                <div class="qa-icon"><i class="ri-mail-line"></i></div>
                <div class="qa-meta">
                    <p class="qa-title">Mesajlar</p>
                    <span class="qa-sub">Oxunmamışları yoxla</span>
                </div>
            </a>
            @endcan
        </div>
    </div>
    </div>

    <div class="dashboard-sortable-item" data-id="activity_chart">
        <div class="dashboard-drag-handle drag-handle" title="Drag">
            <i class="ri-drag-move-2-line"></i>
        </div>
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card glass-card h-100">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Aylıq Aktivlik Statistikası</h4>
                </div>
                <div class="card-body">
                    <div id="activity-chart" class="apex-charts" dir="ltr"></div>
</div>
            </div>
        </div>
    </div>
    </div>

    </div>

    <div class="row dasboard-sortable-row g-4" id="dashboard-sortable">
        @php
            // Default Default Order and Config
            $defaultItems = [
                'latest_messages' => ['view' => 'admin.dashboard.widgets.latest_messages', 'col' => 'col-xxl-6 col-xl-6 col-md-12'],
                'latest_blogs' => ['view' => 'admin.dashboard.widgets.latest_blogs', 'col' => 'col-xxl-6 col-xl-6 col-md-12'],
                'services' => ['view' => 'admin.dashboard.widgets.stat_services', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
                'portfolios' => ['view' => 'admin.dashboard.widgets.stat_portfolios', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
                'messages_stat' => ['view' => 'admin.dashboard.widgets.stat_messages', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
                'blogs_stat' => ['view' => 'admin.dashboard.widgets.stat_blogs', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
                'casestudies' => ['view' => 'admin.dashboard.widgets.stat_casestudies', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
                'testimonials' => ['view' => 'admin.dashboard.widgets.stat_testimonials', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
                'team' => ['view' => 'admin.dashboard.widgets.stat_team', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
                'partners' => ['view' => 'admin.dashboard.widgets.stat_partners', 'col' => 'col-xxl-3 col-xl-4 col-md-6'],
            ];

            // Use saved order if exists, otherwise defaults keys
            $orderKeys = !empty($layoutOrder) ? $layoutOrder : array_keys($defaultItems);
            
            // Filter to valid keys only
            $finalKeys = array_intersect($orderKeys, array_keys($defaultItems));
            
            // Add any missing new widgets to the end
            $missingKeys = array_diff(array_keys($defaultItems), $finalKeys);
            $finalKeys = array_merge($finalKeys, $missingKeys);
        @endphp

        @foreach($finalKeys as $key)
            @php $item = $defaultItems[$key]; @endphp
            
            @if($key == 'latest_messages')
                @can('message.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="activity-panel glass-card h-100">
                        <div class="activity-head d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0 text-truncate">Son mesajlar</h5>
                            <div class="d-flex align-items-center gap-2">
                                <a class="stat-link small text-nowrap" href="{{ route('admin.message.index') }}">Hamısına bax</a>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <ul class="activity-list">
                            @forelse($latestMessages as $message)
                                <li>
                                    <div>
                                        <p class="activity-title">{{ $message->name }}</p>
                                        <span class="activity-time">{{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                    <span class="activity-badge">Mesaj</span>
                                </li>
                            @empty
                                <li class="text-muted">Mesaj yoxdur</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                @endcan
            @elseif($key == 'latest_blogs')
                @can('blog.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="activity-panel glass-card h-100">
                        <div class="activity-head d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0 text-truncate">Son bloqlar</h5>
                            <div class="d-flex align-items-center gap-2">
                                <a class="stat-link small text-nowrap" href="{{ route('admin.blog.index') }}">Hamısına bax</a>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <ul class="activity-list">
                            @forelse($latestBlogs as $blog)
                                <li>
                                    <div>
                                        <p class="activity-title">{{ $blog->title }}</p>
                                        <span class="activity-time">{{ $blog->created_at }}</span>
                                    </div>
                                    <span class="activity-badge">Bloq</span>
                                </li>
                            @empty
                                <li class="text-muted">Bloq yoxdur</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                @endcan
            @elseif($key == 'services')
                @can('service.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Xidmətlər</p>
                                <h3 class="stat-number">{{ $stats['services'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-service-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Bu ay</span>
                            <a class="stat-link" href="{{ route('admin.service.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @elseif($key == 'portfolios')
                @can('portfolio.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Layihələr</p>
                                <h3 class="stat-number">{{ $stats['portfolios'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-gallery-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Bu ay</span>
                            <a class="stat-link" href="{{ route('admin.portfolio.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @elseif($key == 'messages_stat')
                @can('message.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Mesajlar</p>
                                <h3 class="stat-number">{{ $stats['messages'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-message-3-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Oxunmamışları yoxla</span>
                            <a class="stat-link" href="{{ route('admin.message.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @elseif($key == 'blogs_stat')
                @can('blog.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Bloqlar</p>
                                <h3 class="stat-number">{{ $stats['blogs'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-article-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Son paylaşımlar</span>
                            <a class="stat-link" href="{{ route('admin.blog.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @elseif($key == 'casestudies')
                @can('case-study.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Case Studies</p>
                                <h3 class="stat-number">{{ $stats['case_studies'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-slideshow-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Analitika</span>
                            <a class="stat-link" href="{{ route('admin.case-study.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @elseif($key == 'testimonials')
                @can('testimonial.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Rəylər</p>
                                <h3 class="stat-number">{{ $stats['testimonials'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-chat-quote-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Son rəylər</span>
                            <a class="stat-link" href="{{ route('admin.testimonial.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @elseif($key == 'team')
                @can('team-member.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Komanda</p>
                                <h3 class="stat-number">{{ $stats['team_members'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-team-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Aktiv üzvlər</span>
                            <a class="stat-link" href="{{ route('admin.team-member.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @elseif($key == 'partners')
                @can('partner.index')
                <div class="{{ $item['col'] }}" data-id="{{ $key }}">
                    <div class="stat-panel glass-card h-100">
                        <div class="stat-head d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="stat-label mb-1">Tərəfdaşlar</p>
                                <h3 class="stat-number">{{ $stats['partners'] }}</h3>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="stat-icon mb-0"><i class="ri-hand-heart-line"></i></span>
                                <i class="ri-drag-move-2-line text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                        </div>
                        <div class="stat-foot">
                            <span class="stat-foot-label">Brendlər</span>
                            <a class="stat-link" href="{{ route('admin.partner.index') }}">Hamısına bax</a>
                        </div>
                    </div>
                </div>
                @endcan
            @endif
        @endforeach
    </div>
</div>
@endsection

@push('js_stack')
<script src="{{ asset('admin_assets/assets/libs/sortablejs/Sortable.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Dashboard Sortable Init...');
        var topEl = document.getElementById('dashboard-sortable-top');
        var el = document.getElementById('dashboard-sortable');
        
        if (typeof Sortable === 'undefined') {
            console.error('SortableJS library not loaded!');
            return;
        }

        function saveLayout(order, area) {
            fetch("{{ route('admin.dashboard.reorder') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ order: order, area: area })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    console.log('Layout saved successfully');
                    toastr.success('Layout yadda saxlanld');
                }
            })
            .catch(error => {
                console.error('Error saving layout:', error);
                toastr.error('Layout yadda saxlanark?n x?ta baŸ verdi');
            });
        }

        if (topEl) {
            var topOrder = @json($topLayoutOrder ?? []);
            if (Array.isArray(topOrder) && topOrder.length) {
                topOrder.forEach(function (id) {
                    var node = topEl.querySelector('[data-id="' + id + '"]');
                    if (node) {
                        topEl.appendChild(node);
                    }
                });
            }

            Sortable.create(topEl, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                handle: '.drag-handle',
                onEnd: function () {
                    var order = Array.from(topEl.children).map(function (item) {
                        return item.dataset.id;
                    });
                    saveLayout(order, 'top');
                }
            });
        }

        if(el) {
            console.log('Element found, creating Sortable...');
            var sortable = Sortable.create(el, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                handle: '.drag-handle', 
                onEnd: function (evt) {
                    var order = sortable.toArray();
                    console.log('New Order:', order);
                    saveLayout(order, 'main');
                }
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartEl = document.querySelector("#activity-chart");
        if (chartEl && window.ApexCharts) {
            var options = {
                series: [{
                    name: 'Xidmətlər',
                    data: [{{ $stats['services'] }}, 4, 6, 8, 12, 15, 18, 22, 25]
                }, {
                    name: 'Layihələr',
                    data: [{{ $stats['portfolios'] }}, 3, 5, 7, 10, 14, 19, 21, 24]
                }, {
                    name: 'Bloqlar',
                    data: [{{ $stats['blogs'] }}, 5, 8, 12, 15, 20, 25, 30, 35]
                }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'İyun', 'İyul', 'Avq', 'Sen'],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: '#94a3b8',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#94a3b8',
                        fontSize: '12px'
                    }
                }
            },
            colors: ['#7c3aed', '#10b981', '#3b82f6'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [50, 100, 100, 100]
                }
            },
            grid: {
                borderColor: 'rgba(148, 163, 184, 0.1)',
                strokeDashArray: 4,
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                labels: {
                    colors: '#94a3b8'
                }
            },
            theme: {
                mode: 'dark'
            }
        };

            var chart = new ApexCharts(chartEl, options);
            chart.render();
        }

                // Health Check Logic
        const timeEl = document.getElementById('health-last-check');
        const dbEl = document.getElementById('health-db-indicator');
        const dbLatEl = document.getElementById('health-db-latency');
        const cacheEl = document.getElementById('health-cache-indicator');
        const cacheLatEl = document.getElementById('health-cache-latency');
        const diskEl = document.getElementById('health-disk');
        const diskBar = document.getElementById('health-disk-bar');
        let healthInFlight = false;

        if (timeEl) {
            fetchHealth();
            // Refresh every 30 seconds
            setInterval(fetchHealth, 30000);
        }

        function fetchHealth() {
            if (healthInFlight) {
                return;
            }

            healthInFlight = true;

            if (timeEl) {
                timeEl.className = 'badge bg-soft-secondary text-secondary';
                timeEl.innerHTML = '<i class="ri-loader-4-line ri-spin"></i>';
            }

            fetch("{{ route('admin.health.status') }}", { cache: 'no-store' })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Health check failed');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update Time
                    if (timeEl) {
                        timeEl.innerHTML = new Date().toLocaleTimeString('az-AZ', { hour: '2-digit', minute: '2-digit' });
                    }

                    // Database
                    if (dbEl) {
                        if (data.database.status === 'ok') {
                            dbEl.className = 'ri-checkbox-circle-fill text-success fs-20';
                            dbEl.innerHTML = '';
                        } else {
                            dbEl.className = 'ri-close-circle-fill text-danger fs-20';
                            dbEl.innerHTML = '';
                        }
                    }
                    if (dbLatEl) {
                        dbLatEl.innerText = data.database.latency;
                    }

                    // Cache
                    if (cacheEl) {
                        if (data.cache.status === 'ok') {
                            cacheEl.className = 'ri-checkbox-circle-fill text-success fs-20';
                            cacheEl.innerHTML = '';
                        } else {
                            cacheEl.className = 'ri-close-circle-fill text-danger fs-20';
                            cacheEl.innerHTML = '';
                        }
                    }
                    if (cacheLatEl) {
                        cacheLatEl.innerText = data.cache.latency;
                    }

                    // Disk
                    if (diskEl) {
                        diskEl.innerText = data.system.disk_usage;
                        diskEl.classList.remove('text-danger');
                    }
                    if (diskBar) {
                        diskBar.style.width = data.system.disk_usage;
                    }

                    // Disk Color Logic
                    const usageVal = parseFloat(data.system.disk_usage);
                    if (usageVal > 90) {
                        if (diskBar) {
                            diskBar.className = 'progress-bar bg-danger';
                        }
                        if (diskEl) {
                            diskEl.classList.add('text-danger');
                        }
                    } else if (usageVal > 70) {
                        if (diskBar) {
                            diskBar.className = 'progress-bar bg-warning';
                        }
                    } else {
                        if (diskBar) {
                            diskBar.className = 'progress-bar bg-success';
                        }
                    }
                })
                .catch(err => {
                    console.error('Health Check Failed', err);
                    if (timeEl) {
                        timeEl.innerText = 'Xəta';
                        timeEl.className = 'badge bg-soft-danger text-danger';
                    }
                    if (dbEl) {
                        dbEl.className = 'ri-close-circle-fill text-danger fs-20';
                        dbEl.innerHTML = '';
                    }
                    if (dbLatEl) {
                        dbLatEl.innerText = '-';
                    }
                    if (cacheEl) {
                        cacheEl.className = 'ri-close-circle-fill text-danger fs-20';
                        cacheEl.innerHTML = '';
                    }
                    if (cacheLatEl) {
                        cacheLatEl.innerText = '-';
                    }
                    if (diskEl) {
                        diskEl.innerText = '-';
                        diskEl.classList.remove('text-danger');
                    }
                    if (diskBar) {
                        diskBar.style.width = '0%';
                        diskBar.className = 'progress-bar bg-danger';
                    }
                })
                .finally(() => {
                    healthInFlight = false;
                });
        }
    });
</script>
@endpush

