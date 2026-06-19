
@extends('admin.layouts.main')

@section('heading_title', 'Fəaliyyət Jurnalı')

@section('content')
    @php
        $exportQuery = request()->only(['module', 'event', 'user', 'date_from', 'date_to', 'sort_by']);
    @endphp

    <!-- Analytics Widgets -->
    <div class="row mb-4">
        <!-- Today's Activity -->
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(168, 85, 247, 0.05)); border: 1px solid rgba(168, 85, 247, 0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Bugünkü Aktivitet</p>
                            <h4 class="mb-0" style="color: #f1f5f9;">{{ $totalActivitiesToday }}</h4>
                            <small class="text-success mt-1 d-block"><i class="ri-arrow-up-line"></i> Aktiv</small>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title rounded-circle fs-2" style="background: rgba(168, 85, 247, 0.2); color: #a855f7;">
                                <i class="ri-pulse-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top User -->
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05)); border: 1px solid rgba(59, 130, 246, 0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Ən Aktiv İstifadəçi</p>
                            <h5 class="mb-0 text-truncate" style="color: #f1f5f9; max-width: 150px;" title="{{ $activeUser->causer->name ?? 'N/A' }}">
                                {{ $activeUser->causer->name ?? 'Məlumat yoxdur' }}
                            </h5>
                            <small class="text-muted mt-1 d-block">Son 7 gün</small>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title rounded-circle fs-2" style="background: rgba(59, 130, 246, 0.2); color: #3b82f6;">
                                <i class="ri-user-star-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Module -->
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05)); border: 1px solid rgba(16, 185, 129, 0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Ən Çox Dəyişən Modul</p>
                            <h5 class="mb-0" style="color: #f1f5f9;">
                                {{ $topModule ? class_basename($topModule->subject_type) : 'Məlumat yoxdur' }}
                            </h5>
                            <small class="text-muted mt-1 d-block">Son 7 gün</small>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title rounded-circle fs-2" style="background: rgba(16, 185, 129, 0.2); color: #10b981;">
                                <i class="ri-stack-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Critical Events -->
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05)); border: 1px solid rgba(239, 68, 68, 0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-semibold text-muted mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Kritik Əməliyyatlar</p>
                            <h4 class="mb-0" style="color: #f1f5f9;">{{ $criticalEvents }}</h4>
                            <small class="text-danger mt-1 d-block"><i class="ri-delete-bin-line"></i> Silinmələr (7 gün)</small>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title rounded-circle fs-2" style="background: rgba(239, 68, 68, 0.2); color: #ef4444;">
                                <i class="ri-alert-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-12">
        <div class="card glass-card">
            <!-- Filter & Sort Header with Global Form -->
            <form method="GET" action="{{ route('admin.activity-log.index') }}" id="filterForm">
                <div class="d-flex align-items-center justify-content-between p-3 gap-3" style="background: rgba(168, 85, 247, 0.03); border-bottom: 1px solid rgba(168, 85, 247, 0.1);">
                <!-- Left Side: Selection & Bulk Actions -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Select Mode Toggle -->
                    <button type="button" class="btn btn-sm d-flex align-items-center gap-2 px-3 py-2 header-btn" onclick="toggleSelectionMode()" id="selectModeBtn" 
                            style="border-radius: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #cbd5e1; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(168, 85, 247, 0.1)'; this.style.transform='translateY(-2px)'; this.style.color='#a855f7';"
                            onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)'; this.style.color='#cbd5e1';">
                        <i class="ri-checkbox-multiple-line"></i> <span>Seç</span>
                    </button>

                    <!-- Selection Count Badge -->
                    <div id="selectionCountBadge" class="d-none align-items-center px-3 py-2 rounded-pill" style="font-size: 0.85rem; font-weight: 600; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                        <span id="selectedCount">0</span> seçildi
                    </div>

                    <!-- Bulk Actions Group -->
                    <div id="bulkActionsGroup" class="d-none align-items-center gap-2">
                        <!-- Bulk Export Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-sm d-flex align-items-center justify-content-center header-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Eksport" 
                                    style="width: 36px; height: 36px; border-radius: 10px; border-color: rgba(34, 197, 94, 0.2); color: #22c55e;"
                                    onmouseover="this.style.background='rgba(34, 197, 94, 0.1)'; this.style.transform='translateY(-2px)';"
                                    onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)';">
                                <i class="ri-file-download-line fs-16"></i>
                            </button>
                            <ul class="dropdown-menu glass-dropdown">
                                <li><a class="dropdown-item" href="#" onclick="exportSelectedLogs('csv', event)"><i class="ri-file-excel-2-line me-2 text-success"></i> CSV</a></li>
                                <li><a class="dropdown-item" href="#" onclick="exportSelectedLogs('json', event)"><i class="ri-code-s-slash-line me-2 text-warning"></i> JSON</a></li>
                                <li><a class="dropdown-item" href="#" onclick="exportSelectedLogs('html', event)"><i class="ri-printer-line me-2 text-info"></i> Çap (HTML)</a></li>
                            </ul>
                        </div>
                        
                        <!-- Bulk Revert -->
                        <button type="button" class="btn btn-sm d-flex align-items-center justify-content-center header-btn" onclick="revertSelectedLogs()" title="Geri Qaytar" 
                                style="width: 36px; height: 36px; border-radius: 10px; border-color: rgba(245, 158, 11, 0.2); color: #f59e0b;"
                                onmouseover="this.style.background='rgba(245, 158, 11, 0.1)'; this.style.transform='translateY(-2px)';"
                                onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)';">
                            <i class="ri-history-line fs-16"></i>
                        </button>

                        <!-- Bulk Delete Button (Super Admin Only) -->
                        @role('super-admin')
                        <button type="button" class="btn btn-sm align-items-center justify-content-center header-btn" id="bulkDeleteBtn" onclick="deleteSelectedLogs()" disabled title="Sil" 
                                style="width: 36px; height: 36px; opacity: 0.5; cursor: not-allowed; border-radius: 10px; display: flex; border-color: rgba(239, 68, 68, 0.2); color: #ef4444;"
                                onmouseover="if(!this.disabled){this.style.background='rgba(239, 68, 68, 0.1)'; this.style.transform='translateY(-2px)';}"
                                onmouseout="if(!this.disabled){this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)';}">
                            <i class="ri-delete-bin-line fs-16"></i>
                        </button>
                        @endrole
                    </div>
                    </div>

                <!-- Right Side: Filter & Sort -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Expandable Search Input -->
                    <div class="position-relative d-flex align-items-center justify-content-end search-container me-0" style="transition: all 0.3s ease; min-width: 38px;">
                        <input type="text" 
                               class="form-control header-btn ps-5 pe-5 search-input" 
                               name="search" 
                               id="globalSearchInput"
                               value="{{ request('search') }}" 
                               placeholder="Axtarış..." 
                               onkeyup="toggleClearBtn()"
                               style="border-radius: 12px; height: 38px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #f1f5f9; width: {{ request('search') ? '300px' : '0px' }}; opacity: {{ request('search') ? '1' : '0' }}; padding: {{ request('search') ? '10px 45px 10px 45px' : '0' }}; display: {{ request('search') ? 'block' : 'none' }}; transition: all 0.3s ease;">
                        
                        <!-- Search Icon (Toggle) -->
                        <button type="button" 
                                class="btn btn-sm d-flex align-items-center justify-content-center header-btn position-absolute start-0" 
                                onclick="toggleSearch()"
                                style="width: 38px; height: 38px; border-radius: 12px; background: {{ request('search') ? 'transparent' : 'rgba(255, 255, 255, 0.05)' }}; border: {{ request('search') ? 'none' : '1px solid rgba(168, 85, 247, 0.2)' }}; color: {{ request('search') ? '#a855f7' : '#cbd5e1' }}; z-index: 10;">
                            <i class="ri-search-line fs-16"></i>
                        </button>

                        <!-- Clear Icon -->
                        <button type="button" 
                                id="searchClearBtn"
                                class="btn btn-sm d-none align-items-center justify-content-center position-absolute end-0 me-2" 
                                onclick="clearSearch()"
                                style="width: 30px; height: 30px; border-radius: 50%; color: #cbd5e1; transition: all 0.2s; z-index: 11;"
                                onmouseover="this.style.color='#f87171'; this.style.background='rgba(255,255,255,0.1)'"
                                onmouseout="this.style.color='#cbd5e1'; this.style.background='transparent'">
                            <i class="ri-close-line fs-18"></i>
                        </button>
                    </div>

                    <script>
                        // Initialize State on Load
                        document.addEventListener('DOMContentLoaded', function() {
                            const input = document.getElementById('globalSearchInput');
                            const clearBtn = document.getElementById('searchClearBtn');
                            
                            // Remove inline display style if present to let classes handle it
                            clearBtn.style.removeProperty('display');

                            if (input.value.length > 0 && input.style.width === '300px') {
                                clearBtn.classList.remove('d-none');
                                clearBtn.classList.add('d-flex');
                            } else {
                                clearBtn.classList.add('d-none');
                                clearBtn.classList.remove('d-flex');
                            }
                        });

                        function toggleSearch() {
                            const input = document.getElementById('globalSearchInput');
                            const btn = event.currentTarget;
                            const clearBtn = document.getElementById('searchClearBtn');
                            const isExpanded = input.style.width === '300px';
                            
                            if (isExpanded && !input.value) {
                                // Collapse
                                input.style.width = '0px';
                                input.style.opacity = '0';
                                input.style.padding = '0';
                                btn.style.background = 'rgba(255, 255, 255, 0.05)';
                                btn.style.border = '1px solid rgba(168, 85, 247, 0.2)';
                                btn.style.color = '#cbd5e1';
                                
                                clearBtn.classList.add('d-none');
                                clearBtn.classList.remove('d-flex');
                                
                                // Wait for transition then hide
                                setTimeout(() => {
                                    input.style.display = 'none';
                                }, 300);
                            } else {
                                // Expand
                                input.style.display = 'block';
                                // slight delay to allow display:block to render before transitioning width
                                setTimeout(() => {
                                    input.style.width = '300px';
                                    input.style.opacity = '1';
                                    input.style.padding = '10px 45px 10px 45px';
                                }, 10);
                                
                                btn.style.background = 'transparent';
                                btn.style.border = 'none';
                                btn.style.color = '#a855f7';
                                input.focus();
                                
                                if(input.value) {
                                    clearBtn.classList.remove('d-none');
                                    clearBtn.classList.add('d-flex');
                                }
                            }
                        }

                        function toggleClearBtn() {
                            const input = document.getElementById('globalSearchInput');
                            const clearBtn = document.getElementById('searchClearBtn');
                            
                            if (input.value.length > 0 && input.style.width === '300px') {
                                clearBtn.classList.remove('d-none');
                                clearBtn.classList.add('d-flex');
                            } else {
                                clearBtn.classList.add('d-none');
                                clearBtn.classList.remove('d-flex');
                            }
                        }

                        function clearSearch() {
                            const input = document.getElementById('globalSearchInput');
                            input.value = '';
                            toggleClearBtn(); 
                            document.getElementById('filterForm').submit();
                        }
                    </script>

                    <!-- Filter Toggle Button -->
                    <button class="btn btn-sm d-flex align-items-center gap-2 px-3 py-2 header-btn" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#filterPanel" 
                            aria-expanded="false"
                            style="border-radius: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #cbd5e1; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(168, 85, 247, 0.1)'; this.style.transform='translateY(-2px)'; this.style.color='#a855f7';"
                            onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)'; this.style.color='#cbd5e1';">
                        <i class="ri-filter-3-line fs-16"></i> 
                        <span>Filtrləmə</span>
                        @if(request()->hasAny(['module', 'event', 'user', 'date_from', 'date_to']))
                            <span class="badge rounded-pill bg-primary ms-1">
                                {{ collect(['module', 'event', 'user', 'date_from', 'date_to'])->filter(fn($key) => request()->filled($key))->count() }}
                            </span>
                        @else
                            <i class="ri-arrow-down-s-line ms-1 opacity-50"></i>
                        @endif
                    </button>

                    <!-- Sort Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-sm d-flex align-items-center gap-2 px-3 py-2 header-btn" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                                style="border-radius: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #cbd5e1; transition: all 0.3s ease;"
                                onmouseover="this.style.background='rgba(168, 85, 247, 0.1)'; this.style.transform='translateY(-2px)'; this.style.color='#a855f7';"
                                onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)'; this.style.color='#cbd5e1';">
                            <span class="text-muted fw-medium" style="color: inherit !important; opacity: 0.8;">Sıralama:</span>
                            <span class="fw-semibold">
                                @switch(request('sort_by', 'newest'))
                                    @case('oldest') <i class="ri-sort-asc me-1 text-primary"></i> Ən köhnə @break
                                    @case('user') <i class="ri-user-3-line me-1 text-primary"></i> İstifadəçi @break
                                    @case('module') <i class="ri-stack-line me-1 text-primary"></i> Modul @break
                                    @default <i class="ri-sort-desc me-1 text-primary"></i> Ən yeni
                                @endswitch
                            </span>
                            <i class="ri-arrow-down-s-line ms-1 opacity-50"></i>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-end glass-dropdown" style="background: rgba(30, 41, 59, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(168, 85, 247, 0.2); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request('sort_by', 'newest') == 'newest' ? 'active' : '' }}" 
                                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'newest']) }}"
                                   style="color: #cbd5e1; padding: 8px 16px; transition: all 0.2s;">
                                    <i class="ri-sort-desc text-primary"></i>
                                    <span>Ən yeni</span>
                                    @if(request('sort_by', 'newest') == 'newest') <i class="ri-check-line ms-auto text-success"></i> @endif
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request('sort_by') == 'oldest' ? 'active' : '' }}" 
                                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'oldest']) }}"
                                   style="color: #cbd5e1; padding: 8px 16px; transition: all 0.2s;">
                                    <i class="ri-sort-asc text-primary"></i>
                                    <span>Ən köhnə</span>
                                    @if(request('sort_by') == 'oldest') <i class="ri-check-line ms-auto text-success"></i> @endif
                                </a>
                            </li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request('sort_by') == 'user' ? 'active' : '' }}" 
                                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'user']) }}"
                                   style="color: #cbd5e1; padding: 8px 16px; transition: all 0.2s;">
                                    <i class="ri-user-3-line text-primary"></i>
                                    <span>İstifadəçi</span>
                                    @if(request('sort_by') == 'user') <i class="ri-check-line ms-auto text-success"></i> @endif
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request('sort_by') == 'module' ? 'active' : '' }}" 
                                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'module']) }}"
                                   style="color: #cbd5e1; padding: 8px 16px; transition: all 0.2s;">
                                    <i class="ri-stack-line text-primary"></i>
                                    <span>Modul</span>
                                    @if(request('sort_by') == 'module') <i class="ri-check-line ms-auto text-success"></i> @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
            
            <!-- Collapsible Filter Panel -->
            <div class="collapse" id="filterPanel">
                <div class="card-body p-3" style="background: rgba(168, 85, 247, 0.02);">
                        <!-- Preserve sort -->
                        @if(request()->filled('sort_by'))
                            <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                        @endif
                        
                        <div class="row g-2">
                             <!-- Module Filter -->
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold mb-1" style="color: #a855f7; font-size: 0.75rem;">
                                    <i class="ri-stack-line"></i> MODUL
                                </label>
                                <input type="hidden" name="module" id="moduleInput" value="{{ request('module') }}">
                                <div class="dropdown w-100">
                                    <button class="btn btn-sm w-100 d-flex align-items-center justify-content-between header-btn" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false"
                                            style="border-radius: 8px; padding: 8px 12px; background: rgba(255, 255, 255, 0.05);">
                                        <span id="moduleLabel" class="d-flex align-items-center text-truncate">
                                            @if(request('module'))
                                                @php
                                                    // Flatten the grouped collection to find the selected item
                                                    $selectedModule = $modules->flatten(1)->firstWhere('value', request('module'));
                                                @endphp
                                                <i class="ri-stack-line text-primary me-2 fs-16"></i> {{ $selectedModule['label'] ?? request('module') }}
                                            @else
                                                <span class="text-muted">Hamısı</span>
                                            @endif
                                        </span>
                                        <i class="ri-arrow-down-s-line opacity-50"></i>
                                    </button>
                                    <ul class="dropdown-menu w-100 glass-dropdown" style="max-height: 300px; overflow-y: auto;">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ request()->fullUrlWithQuery(['module' => null]) }}">
                                                <span class="text-muted">Hamısı</span>
                                            </a>
                                        </li>
                                        @foreach($modules as $category => $items)
                                            <li><h6 class="dropdown-header text-uppercase fs-10 fw-bold text-muted ps-3 mt-2 mb-1" style="letter-spacing: 0.5px;">{{ $category }}</h6></li>
                                            @foreach($items as $module)
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center py-2 ps-3" href="{{ request()->fullUrlWithQuery(['module' => $module['value']]) }}">
                                                        <i class="ri-stack-line text-primary me-2 fs-16 opacity-75"></i> {{ $module['label'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li><hr class="dropdown-divider my-1 opacity-10"></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Operation Filter -->
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold mb-1" style="color: #a855f7; font-size: 0.75rem;">
                                    <i class="ri-flashlight-line"></i> ƏMƏLIYYAT
                                </label>
                                <input type="hidden" name="event" id="eventInput" value="{{ request('event') }}">
                                <div class="dropdown w-100">
                                    <button class="btn btn-sm w-100 d-flex align-items-center justify-content-between header-btn" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false"
                                            style="border-radius: 8px; padding: 8px 12px; background: rgba(255, 255, 255, 0.05);">
                                        <span id="eventLabel" class="d-flex align-items-center">
                                            @switch(request('event'))
                                                @case('created') <i class="ri-add-circle-line text-success me-2 fs-16"></i> Yaratdı @break
                                                @case('updated') <i class="ri-edit-circle-line text-warning me-2 fs-16"></i> Yenilədi @break
                                                @case('deleted') <i class="ri-delete-bin-line text-danger me-2 fs-16"></i> Sildi @break
                                                @default <span class="text-muted">Hamısı</span>
                                            @endswitch

                                        </span>
                                        <i class="ri-arrow-down-s-line opacity-50"></i>
                                    </button>
                                    <ul class="dropdown-menu w-100 glass-dropdown">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ request()->fullUrlWithQuery(['event' => null]) }}">
                                                <span class="text-muted">Hamısı</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ request()->fullUrlWithQuery(['event' => 'created']) }}">
                                                <i class="ri-add-circle-line text-success me-2 fs-16"></i> Yaratdı
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ request()->fullUrlWithQuery(['event' => 'updated']) }}">
                                                <i class="ri-edit-circle-line text-warning me-2 fs-16"></i> Yenilədi
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ request()->fullUrlWithQuery(['event' => 'deleted']) }}">
                                                <i class="ri-delete-bin-line text-danger me-2 fs-16"></i> Sildi
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-semibold mb-1" style="color: #a855f7; font-size: 0.75rem;">
                                    <i class="ri-user-line"></i> İSTİFADƏÇİ
                                </label>
                                <input type="hidden" name="user" id="userInput" value="{{ request('user') }}">
                                <div class="dropdown w-100">
                                    <button class="btn btn-sm w-100 d-flex align-items-center justify-content-between header-btn" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false"
                                            style="border-radius: 8px; padding: 8px 12px; background: rgba(255, 255, 255, 0.05);">
                                        <span id="userLabel" class="d-flex align-items-center text-truncate">
                                            @if(request('user'))
                                                @php
                                                    $selectedUser = $users->firstWhere('id', request('user'));
                                                @endphp
                                                <i class="ri-user-line text-primary me-2 fs-16"></i> {{ $selectedUser->name ?? 'ID: ' . request('user') }}
                                            @else
                                                <span class="text-muted">Hamısı</span>
                                            @endif
                                        </span>
                                        <i class="ri-arrow-down-s-line opacity-50"></i>
                                    </button>
                                    <ul class="dropdown-menu w-100 glass-dropdown" style="max-height: 300px; overflow-y: auto;">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ request()->fullUrlWithQuery(['user' => null]) }}">
                                                <span class="text-muted">Hamısı</span>
                                            </a>
                                        </li>
                                        @foreach($users as $user)
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center py-2" href="{{ request()->fullUrlWithQuery(['user' => $user->id]) }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-xs me-2">
                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-10">
                                                                {{ substr($user->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                        {{ $user->name }}
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Date Range Filter -->
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold mb-1" style="color: #a855f7; font-size: 0.75rem;">
                                    <i class="ri-calendar-line"></i> TARİX ARALIĞI
                                </label>
                                <style>
                                    input[type="date"]::-webkit-calendar-picker-indicator {
                                        filter: invert(1) opacity(0.7);
                                        cursor: pointer;
                                    }
                                </style>
                                <div class="d-flex gap-2">
                                    <div class="input-group flex-grow-1">
                                        <input type="date" class="form-control header-btn" name="date_from" value="{{ request('date_from') }}" 
                                               style="border-right: 0; border-radius: 8px 0 0 8px; padding: 8px 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #f1f5f9;">
                                        <span class="input-group-text header-btn" style="border-left: 0; border-right: 0; border-radius: 0; padding: 8px 12px; background: rgba(255, 255, 255, 0.05); border-top: 1px solid rgba(168, 85, 247, 0.2); border-bottom: 1px solid rgba(168, 85, 247, 0.2); color: #a855f7;">-</span>
                                        <input type="date" class="form-control header-btn" name="date_to" value="{{ request('date_to') }}" 
                                               style="border-left: 0; border-radius: 0 8px 8px 0; padding: 8px 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #f1f5f9;">
                                    </div>
                                    <button class="btn d-flex align-items-center justify-content-center header-btn" type="submit" 
                                            style="border-radius: 8px; padding: 8px 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #a855f7; transition: all 0.3s ease;"
                                            onmouseover="this.style.background='rgba(168, 85, 247, 0.1)'; this.style.transform='translateY(-2px)';"
                                            onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)';">
                                        <i class="ri-search-line"></i>
                                    </button>
                                    <a href="{{ route('admin.activity-log.index') }}" class="btn d-flex align-items-center justify-content-center header-btn" 
                                       style="border-radius: 8px; padding: 8px 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(168, 85, 247, 0.2); color: #a855f7; transition: all 0.3s ease;"
                                       onmouseover="this.style.background='rgba(168, 85, 247, 0.1)'; this.style.transform='translateY(-2px)';"
                                       onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.transform='translateY(0)';"
                                       title="Sıfırla">
                                        <i class="ri-refresh-line"></i>
                                    </a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="selection-column d-none">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleAll(this)">
                                    </div>
                                </th>
                                <th style="width: 50px;"><i class="ri-hashtag me-1"></i>ID</th>
                                <th><i class="ri-user-line me-1"></i> İstifadəçi</th>
                                <th><i class="ri-flashlight-line me-1"></i> Əməliyyat</th>
                                <th><i class="ri-box-3-line me-1"></i> Obyekt</th>
                                <th><i class="ri-file-list-3-line me-1"></i> Dəyişikliklər</th>
                                <th><i class="ri-calendar-line me-1"></i> Tarix</th>
                                <th><i class="ri-settings-3-line me-1"></i> Əməliyyatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td class="selection-column d-none">
                                        <div class="form-check">
                                            <input class="form-check-input select-item" type="checkbox" value="{{ $activity->id }}" onclick="updateBulkButton()">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-medium">#{{ $activity->id }}</span>
                                    </td>
                                    <td>
                                        @if($activity->causer)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        {{ substr($activity->causer->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <h6 class="mb-0">{{ $activity->causer->name }}</h6>
                                                        @if($activity->causer->roles->isNotEmpty())
                                                            <span class="badge bg-soft-info text-info" style="font-size: 0.65rem; padding: 2px 6px;">
                                                                {{ $activity->causer->roles->first()->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2 mt-1">
                                                        <small class="text-muted" style="font-size: 0.7rem;">
                                                            <i class="ri-mail-line me-1"></i>{{ $activity->causer->email }}
                                                        </small>
                                                    </div>
                                                    @if($activity->properties->has('ip'))
                                                        <div class="d-flex align-items-center gap-3 mt-1">
                                                            <small class="text-muted" style="font-size: 0.7rem;" title="IP Ünvanı">
                                                                <i class="ri-global-line me-1"></i>{{ $activity->properties['ip'] }}
                                                            </small>
                                                            @if($activity->properties->has('user_agent'))
                                                                <small class="text-muted" style="font-size: 0.7rem;" title="{{ $activity->properties['user_agent'] }}">
                                                                    <i class="ri-device-line me-1"></i>Cihaz
                                                                </small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-soft-secondary text-secondary">
                                                        S
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Sistem</h6>
                                                    <small class="text-muted">Avtomatik</small>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badges = [
                                                'created' => 'success',
                                                'updated' => 'warning',
                                                'deleted' => 'danger',
                                            ];
                                            $labels = [
                                                'created' => 'Yaratdı',
                                                'updated' => 'Yenilədi',
                                                'deleted' => 'Sildi',
                                            ];
                                            $icons = [
                                                'created' => 'ri-add-circle-line',
                                                'updated' => 'ri-edit-circle-line',
                                                'deleted' => 'ri-delete-bin-line',
                                            ];
                                        @endphp
                                        <span class="badge bg-soft-{{ $badges[$activity->description] ?? 'primary' }} text-{{ $badges[$activity->description] ?? 'primary' }}">
                                            <i class="{{ $icons[$activity->description] ?? 'ri-information-line' }} me-1 align-middle"></i>
                                            {{ $labels[$activity->description] ?? $activity->description }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            @if($activity->subject)
                                                <span class="fw-medium text-truncate" style="max-width: 200px;" title="{{ $activity->subject->title ?? $activity->subject->name ?? $activity->subject->full_name ?? $activity->subject->key ?? '' }}">
                                                    {{ $activity->subject->title ?? $activity->subject->name ?? $activity->subject->full_name ?? $activity->subject->key ?? '' }}
                                                </span>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    {{ class_basename($activity->subject_type) }} <span class="mx-1 opacity-50">•</span> #{{ $activity->subject_id }}
                                                </small>
                                            @else
                                                <span class="fw-medium">{{ class_basename($activity->subject_type) }}</span>
                                                <small class="text-muted" style="font-size: 0.75rem;">ID: #{{ $activity->subject_id }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($activity->description === 'updated' && $activity->properties->has('attributes'))
                                            @php
                                                $attributes = $activity->properties['attributes'] ?? [];
                                                $old = $activity->properties['old'] ?? [];
                                                $count = 0;
                                                $changedKeys = [];

                                                if ($activity->description === 'updated') {
                                                    foreach ($attributes as $key => $newVal) {
                                                        // Skip timestamps and auto-generated slug
                                                        if (in_array($key, ['updated_at', 'created_at', 'slug'])) continue;
                                                        
                                                        if (array_key_exists($key, $old)) {
                                                            if ($old[$key] != $newVal) {
                                                                $count++;
                                                                $changedKeys[] = $key;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    // For created/deleted, count all attributes excluding timestamps and slug
                                                    $changedKeys = array_diff(array_keys($attributes), ['updated_at', 'created_at', 'slug']);
                                                }

                                                // Filter out generic keys if localized version exists (e.g. ignore 'content' if 'content_az' is present)
                                                // This prevents double counting for single edits
                                                $changedKeys = array_filter($changedKeys, function($key) use ($changedKeys) {
                                                    // Check if there is a corresponding 'key_az' in the distinct list
                                                    if (in_array($key . '_az', $changedKeys)) {
                                                        return false;
                                                    }
                                                    return true;
                                                });
                                                
                                                $count = count($changedKeys);
                                            @endphp
                                            @if($count > 0)
                                                <span class="badge bg-soft-purple text-purple" title="{{ implode(', ', $changedKeys) }}">
                                                    {{ $count }} sahə dəyişdi
                                                </span>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ $activity->created_at->diffForHumans() }}</span>
                                            <small class="text-muted">{{ $activity->created_at->setTimezone('Asia/Baku')->format('d.m.Y H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if($activity->properties->count() > 0)
                                                <button type="button" class="btn btn-sm btn-soft-info" onclick="openActivityModal({{ $activity->id }})" title="Detallar">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                            @endif

                                            @if(in_array($activity->description, ['updated', 'deleted']))
                                                <form action="{{ route('admin.activity-log.revert', $activity->id) }}" method="POST" class="revert-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-soft-warning" title="Geri Qaytar">
                                                        <i class="ri-history-line"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Hələ heç bir fəaliyyət qeydə alınmayıb.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Dynamic Modal -->
<div class="modal fade" id="activityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background: rgba(30, 41, 59, 0.98); 
                                           backdrop-filter: saturate(180%) blur(30px);
                                           -webkit-backdrop-filter: saturate(180%) blur(30px);
                                           border: 1px solid rgba(168, 85, 247, 0.25);
                                           box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6),
                                                      0 0 0 1px rgba(168, 85, 247, 0.1) inset,
                                                      0 2px 20px rgba(168, 85, 247, 0.15);
                                           border-radius: 24px;
                                           overflow: hidden;
                                           min-height: 200px;">
        </div>
    </div>
</div>
@endsection

@push('js_stack')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openActivityModal(id) {
        const modalEl = document.getElementById('activityModal');
        const modal = new bootstrap.Modal(modalEl);
        const modalContent = modalEl.querySelector('.modal-content');
        
        // Show loader
        modalContent.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Yüklənir...</span>
                </div>
            </div>
        `;
        
        modal.show();

        fetch(`{{ route('admin.activity-log.index') }}/${id}`)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html;
                // Re-initialize plugins if needed
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl)
                })
            })
            .catch(error => {
                console.error('Error:', error);
                modalContent.innerHTML = '<div class="text-center text-danger p-4">Xəta baş verdi.</div>';
            });
    }

    function loadHistory(subjectType, subjectId, activityId) {
        const container = document.getElementById(`history-content-${activityId}`);
        const loader = document.getElementById(`history-loader-${activityId}`);
        
        if (container.innerHTML.trim() !== '') return; // Already loaded

        fetch(`{{ route('admin.activity-log.history') }}?subject_type=${encodeURIComponent(subjectType)}&subject_id=${subjectId}`)
            .then(response => response.json())
            .then(data => {
                loader.classList.add('d-none');
                container.innerHTML = data.html;
            })
            .catch(error => {
                console.error('Error:', error);
                loader.classList.add('d-none');
                container.innerHTML = '<div class="text-center text-danger p-3">Tarixçəni yükləmək mümkün olmadı.</div>';
            });
    }

    $(document).ready(function() {
        // Check current theme
        const isDarkMode = document.documentElement.getAttribute('data-theme') === 'dark';
        
        // Revert form submission (delegated for dynamic content)
        $(document).on('submit', '.revert-form', function(e) {
            e.preventDefault();
            var form = this;
            
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
                    <i class="ri-error-warning-line" style="color: ${colors.primary}; font-size: 2rem;"></i>
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
                    form.submit();
                }
            });
        });
    });
</script>
<style>
    /* Glassmorphism SweetAlert2 Styling */
    .swal-glass-popup {
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        backdrop-filter: saturate(180%) blur(25px) !important;
        -webkit-backdrop-filter: saturate(180%) blur(25px) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
        border-radius: 24px !important;
        padding: 30px !important;
    }
    
    .swal-glass-title {
        font-size: 1.5rem !important;
        font-weight: 600 !important;
        padding: 0 !important;
        margin-bottom: 10px !important;
    }
    
    .swal-glass-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .swal-glass-actions {
        gap: 12px !important;
        margin-top: 30px !important;
    }
    
    .swal-glass-confirm,
    .swal-glass-cancel {
        padding: 12px 28px !important;
        font-weight: 600 !important;
        border-radius: 16px !important;
        font-size: 0.95rem !important;
        transition: all 0.3s ease !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
    
    .swal-glass-confirm:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 20px rgba(var(--brand-primary-rgb, 75, 0, 130), 0.4) !important;
    }
    
    .swal-glass-cancel:hover {
        transform: translateY(-3px) !important;
        opacity: 0.8 !important;
    }
    
    /* Activity Log Modal Glassmorphism */
    .modal-content.bg-dark {
        background: rgba(30, 41, 59, 0.95) !important;
        backdrop-filter: saturate(180%) blur(25px) !important;
        -webkit-backdrop-filter: saturate(180%) blur(25px) !important;
        border: 1px solid rgba(168, 85, 247, 0.2) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
    }
    
    .modal-header.border-secondary {
        border-bottom: 1px solid rgba(168, 85, 247, 0.15) !important;
        background: rgba(168, 85, 247, 0.05) !important;
    }
    
    .modal-footer.border-secondary {
        border-top: 1px solid rgba(168, 85, 247, 0.15) !important;
        background: rgba(168, 85, 247, 0.05) !important;
    }
    
    .bg-soft-dark {
        background: rgba(15, 23, 42, 0.4) !important;
    }
    
    /* Icon styling with brand colors */
    .ri-alert-line,
    .ri-error-warning-line {
        filter: drop-shadow(0 0 8px currentColor);
    }
    
    /* Filter Panel Enhancements */
    .filter-header button:hover {
        background: rgba(168, 85, 247, 0.25) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(168, 85, 247, 0.2);
    }
    
    .filter-header button:active {
        transform: translateY(0);
    }
    
    /* Form Elements Purple Theme */
    .form-select:focus,
    .form-control:focus {
        border-color: rgba(168, 85, 247, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1) !important;
    }
    
    /* Force table visibility and dimensions */
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        min-height: 200px; /* Ensure minimum height */
    }

    .card-body {
        flex: 1 1 auto;
        width: 100%;
    }

    /* Fix Glass Card Overflow for Table */
    .glass-card {
        height: auto !important;
        overflow: visible !important;
        display: flex;
        flex-direction: column;
    }

    /* Modal Text Color */
    [data-theme="dark"] .modal-content {
        color: #f1f5f9 !important;
    }
    
    [data-theme="dark"] .modal-content .text-white {
        color: #f1f5f9 !important;
    }
    
    /* Search Button Hover */
    button[type="submit"]:hover {
        opacity: 0.9;
        transform: translateY(-1px) !important;
    }
    
    /* Custom Dropdown Styling */
    .glass-dropdown .dropdown-item:hover {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7 !important;
        transform: translateX(5px);
    }
    
    .glass-dropdown .dropdown-item.active {
        background: rgba(168, 85, 247, 0.25);
        color: #a855f7 !important;
        font-weight: 600;
    }
    
    /* Unified Header Buttons */
    .header-btn {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(168, 85, 247, 0.2);
        border-radius: 12px;
        color: #f1f5f9;
        transition: all 0.3s ease;
    }
    
    .header-btn:hover, .header-btn[aria-expanded="true"] {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(168, 85, 247, 0.2);
        color: #f1f5f9;
    }
    
    /* Dark Mode Select Options Fix */
    [data-theme="dark"] select.form-select option {
        background-color: #1e293b;
        color: #f1f5f9;
        padding: 8px;
    }

    /* Force Dark Glass Dropdown */
    .glass-dropdown {
        background: rgba(30, 41, 59, 0.95) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(168, 85, 247, 0.2);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .glass-dropdown .dropdown-item {
        color: #e2e8f0;
    }
    
    .glass-dropdown .text-muted {
        color: #94a3b8 !important;
    }

    /* Table Dark Mode Fixes */
    [data-theme="dark"] .table {
        color: #f1f5f9;
        --bs-table-hover-color: #f1f5f9;
        --bs-table-hover-bg: rgba(168, 85, 247, 0.05);
    }

    [data-theme="dark"] .table-hover tbody tr:hover {
        background-color: rgba(168, 85, 247, 0.1) !important;
    }

    [data-theme="dark"] .table-hover tbody tr:hover td {
        color: #f1f5f9 !important;
    }

    /* Ensure badges and other colored elements keep their color */
    .table-hover tbody tr:hover .text-success { color: #10b981 !important; }
    .table-hover tbody tr:hover .text-warning { color: #f59e0b !important; }
    .table-hover tbody tr:hover .text-danger { color: #ef4444 !important; }
    .table-hover tbody tr:hover .text-primary { color: #a855f7 !important; }
    .table-hover tbody tr:hover .text-info { color: #3b82f6 !important; }
    .table-hover tbody tr:hover .text-muted { color: #cbd5e1 !important; }

    [data-theme="dark"] .table thead th {
        background-color: rgba(30, 41, 59, 0.5) !important;
        color: #a855f7;
        border-bottom: 1px solid rgba(168, 85, 247, 0.2);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table td {
        border-bottom: 1px solid rgba(168, 85, 247, 0.1);
        vertical-align: middle;
        background-color: transparent !important; /* Ensure cells don't have their own bg */
        padding-top: 1.25rem;
        padding-bottom: 1.25rem;
    }

    /* Fix for white background on rows if any */
    .table > :not(caption) > * > * {
        background-color: transparent;
        color: inherit;
        box-shadow: none !important; /* Remove any shadow that might look like a border/bg */
    }

    /* Pagination Styling */
    .pagination {
        margin-bottom: 0;
        gap: 5px;
    }

    .page-item .page-link {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(168, 85, 247, 0.2);
        color: #cbd5e1;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .page-item.active .page-link {
        background: rgba(168, 85, 247, 0.25);
        border-color: #a855f7;
        color: #a855f7;
        font-weight: 600;
        box-shadow: 0 0 15px rgba(168, 85, 247, 0.3);
    }

    .page-item.disabled .page-link {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.2);
    }

    .page-item .page-link:hover {
        background: rgba(168, 85, 247, 0.15);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Premium Glassmorphism Classes */
    .glass-header {
        background: rgba(255, 255, 255, 0.03) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(10px);
    }

    .glass-card-inner {
        background: rgba(255, 255, 255, 0.02) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(5px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .glass-card-inner:hover {
        background: rgba(255, 255, 255, 0.04) !important;
        border-color: rgba(168, 85, 247, 0.2) !important;
        transform: translateY(-2px);
    }

    .glass-input {
        background: rgba(0, 0, 0, 0.2) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #f1f5f9 !important;
    }

    .glass-input:focus {
        background: rgba(0, 0, 0, 0.3) !important;
        border-color: rgba(168, 85, 247, 0.5) !important;
        box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.1) !important;
    }

    /* Badge Enhancements */
    .badge-glass {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(4px);
    }
</style>



<script>
    // Immediate execution to verify load
    console.log('Activity Log Script Loaded V6 - Refined');

    function toggleSelectionMode() {
        const columns = document.querySelectorAll('.selection-column');
        const bulkActions = document.getElementById('bulkActionsGroup');
        const countBadge = document.getElementById('selectionCountBadge');
        const btn = document.getElementById('selectModeBtn');
        
        columns.forEach(col => col.classList.toggle('d-none'));
        bulkActions.classList.toggle('d-none');
        bulkActions.classList.toggle('d-flex');
        countBadge.classList.toggle('d-none');
        countBadge.classList.toggle('d-flex');
        
        btn.classList.toggle('active');
        if (btn.classList.contains('active')) {
            btn.innerHTML = '<i class="ri-close-line"></i> <span>Ləğv et</span>';
            // Apply Red Glass Style
            btn.style.borderColor = 'rgba(239, 68, 68, 0.5)';
            btn.style.color = '#ef4444';
            btn.style.background = 'rgba(239, 68, 68, 0.1)';
        } else {
            btn.innerHTML = '<i class="ri-checkbox-multiple-line"></i> <span>Seç</span>';
            // Revert to Purple Glass Style
            btn.style.borderColor = 'rgba(168, 85, 247, 0.2)';
            btn.style.color = '#cbd5e1';
            btn.style.background = 'rgba(255, 255, 255, 0.05)';
            
            // Uncheck all when cancelling
            const selectAll = document.getElementById('selectAll');
            if (selectAll) {
                selectAll.checked = false;
                toggleAll(selectAll);
            }
        }
    }

    function updateBulkButton() {
        const checked = document.querySelectorAll('.select-item:checked');
        const count = document.getElementById('selectedCount');
        const buttons = document.querySelectorAll('#bulkActionsGroup button:not([data-bs-toggle="dropdown"])'); 
        const dropdownBtn = document.querySelector('#bulkActionsGroup .dropdown button');

        if (count) {
            count.textContent = checked.length;
        }

        const enable = checked.length > 0;
        const opacity = enable ? '1' : '0.5';
        const cursor = enable ? 'pointer' : 'not-allowed';

        buttons.forEach(btn => {
            btn.disabled = !enable;
            btn.style.opacity = opacity;
            btn.style.cursor = cursor;
        });

        if (dropdownBtn) {
            dropdownBtn.disabled = !enable;
            dropdownBtn.style.opacity = opacity;
            dropdownBtn.style.cursor = cursor;
        }
    }

    function toggleAll(source) {
        const checkboxes = document.querySelectorAll('.select-item');
        checkboxes.forEach(cb => cb.checked = source.checked);
        updateBulkButton();
    }

    // Fallback event listeners
    document.addEventListener('DOMContentLoaded', function() {
        updateBulkButton(); // Initial check
        
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                toggleAll(this);
            });
        }

        const checkboxes = document.querySelectorAll('.select-item');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkButton);
        });
    });

    function deleteSelectedLogs() {
        const checked = document.querySelectorAll('.select-item:checked');
        if (checked.length === 0) return;
        if (!confirm('Seçilmiş ' + checked.length + ' əməliyyatı silmək istədiyinizə əminsiniz?')) return;
        const ids = Array.from(checked).map(cb => cb.value);
        
        performBulkAction('{{ route("admin.bulk.delete") }}', ids);
    }

    function revertSelectedLogs() {
        const checked = document.querySelectorAll('.select-item:checked');
        if (checked.length === 0) return;
        if (!confirm('Seçilmiş ' + checked.length + ' əməliyyatı geri qaytarmaq istədiyinizə əminsiniz? Bu əməliyyat bəzi məlumatları bərpa edəcək və ya dəyişiklikləri ləğv edəcək.')) return;
        const ids = Array.from(checked).map(cb => cb.value);
        
        performBulkAction('{{ route("admin.bulk.revert") }}', ids);
    }

    function exportSelectedLogs(format = 'csv', event = null) {
        if (event) event.preventDefault();
        
        const checked = document.querySelectorAll('.select-item:checked');
        if (checked.length === 0) {
            alert('Zəhmət olmasa ən azı bir sətir seçin.');
            return;
        }
        
        const ids = Array.from(checked).map(cb => cb.value);
        
        // Create a hidden form to submit for download
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.bulk.export") }}';
        form.style.display = 'none';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const modelInput = document.createElement('input');
        modelInput.type = 'hidden';
        modelInput.name = 'model';
        modelInput.value = 'Spatie\\Activitylog\\Models\\Activity';
        form.appendChild(modelInput);

        const formatInput = document.createElement('input');
        formatInput.type = 'hidden';
        formatInput.name = 'format';
        formatInput.value = format;
        form.appendChild(formatInput);

        ids.forEach(id => {
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'ids[]';
            idInput.value = id;
            form.appendChild(idInput);
        });

        document.body.appendChild(form);
        form.submit();
        
        // Remove form after a slight delay to ensure submit happens
        setTimeout(() => {
            document.body.removeChild(form);
        }, 1000);
    }

    function performBulkAction(url, ids) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ids: ids,
                model: 'Spatie\\Activitylog\\Models\\Activity'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                // Reload is disabled to prevent loops, user must refresh manually if needed
                // setTimeout(() => window.location.reload(), 1000); 
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Xəta baş verdi.');
        });
    }

    function showDiff(oldText, newText, elementId) {
        if (typeof Diff === 'undefined') {
            console.error('jsdiff library not loaded');
            return;
        }
        const diff = Diff.diffWords(oldText, newText);
        const display = document.getElementById(elementId);
        const fragment = document.createDocumentFragment();

        diff.forEach((part) => {
            // green for additions, red for deletions
            // grey for common parts
            const color = part.added ? 'text-success bg-soft-success' :
                part.removed ? 'text-danger bg-soft-danger text-decoration-line-through' : 'text-muted';
            
            const span = document.createElement('span');
            span.className = color;
            span.appendChild(document.createTextNode(part.value));
            fragment.appendChild(span);
        });

        display.innerHTML = '';
        display.appendChild(fragment);
        display.parentElement.classList.remove('d-none');
    }

    function filterTimeline(query) {
        query = query.toLowerCase();
        const items = document.querySelectorAll('.mp-timeline-item');
        let hasResults = false;

        items.forEach(item => {
            // Safe navigation in case elements are missing
            const targetEl = item.querySelector('.mp-search-target');
            const descEl = item.querySelector('.mp-search-desc');
            const dateEl = item.querySelector('.mp-search-date');

            if (!targetEl || !descEl || !dateEl) return;

            const target = targetEl.innerText.toLowerCase();
            const desc = descEl.innerText.toLowerCase();
            const date = dateEl.innerText.toLowerCase();
            
            if (target.includes(query) || desc.includes(query) || date.includes(query)) {
                item.classList.remove('d-none');
                hasResults = true;
            } else {
                item.classList.add('d-none');
            }
        });

        const noResults = document.getElementById('no-results');
        if (noResults) {
            if (hasResults) {
                noResults.classList.add('d-none');
            } else {
                noResults.classList.remove('d-none');
            }
        }
    }

    function loadActivityModal(id) {
        const modalContent = document.querySelector('#activityModal .modal-content');
        
        // Skeleton Loading State
        const skeletonHTML = `
            <style>
                @keyframes shimmer {
                    0% { background-position: -1000px 0; }
                    100% { background-position: 1000px 0; }
                }
                .mp-skeleton {
                    animation: shimmer 2s infinite linear;
                    background: linear-gradient(to right, var(--mp-bg-card) 4%, var(--mp-bg-main) 25%, var(--mp-bg-card) 36%);
                    background-size: 1000px 100%;
                }
                .mp-skeleton-text { height: 12px; border-radius: 4px; margin-bottom: 8px; }
                .mp-skeleton-circle { width: 32px; height: 32px; border-radius: 50%; }
                .mp-skeleton-block { height: 60px; border-radius: 8px; }
            </style>
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <div class="d-flex align-items-center w-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="mp-skeleton mp-skeleton-circle"></div>
                        <div>
                            <div class="mp-skeleton mp-skeleton-text" style="width: 150px; height: 16px;"></div>
                            <div class="mp-skeleton mp-skeleton-text mt-2" style="width: 100px;"></div>
                        </div>
                    </div>
                    <div class="ms-auto d-flex gap-2">
                        <div class="mp-skeleton" style="width: 120px; height: 38px; border-radius: 20px;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-body d-flex p-0 mt-3">
                <div class="mp-sidebar border-end p-3" style="width: 280px; border-color: var(--mp-border) !important;">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="mp-skeleton mp-skeleton-text" style="width: 80px;"></div>
                        <div class="mp-skeleton mp-skeleton-text" style="width: 40px;"></div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        ${Array(6).fill('<div class="mp-skeleton mp-skeleton-block" style="height: 50px;"></div>').join('')}
                    </div>
                </div>
                <div class="mp-content flex-grow-1 p-4">
                    <div class="mp-skeleton mp-skeleton-block mb-4" style="height: 80px;"></div>
                    <div class="d-flex gap-4 mb-4">
                        <div class="mp-skeleton mp-skeleton-text w-25"></div>
                        <div class="mp-skeleton mp-skeleton-text w-25"></div>
                        <div class="mp-skeleton mp-skeleton-text w-50"></div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        ${Array(4).fill('<div class="mp-skeleton mp-skeleton-block"></div>').join('')}
                    </div>
                </div>
            </div>
        `;
        
        if (modalContent) {
            modalContent.innerHTML = skeletonHTML;
        }

        fetch(`{{ route('admin.activity-log.show', '') }}/${id}`)
            .then(response => response.text())
            .then(html => {
                const modalContent = document.querySelector('#activityModal .modal-content');
                if (modalContent) {
                    modalContent.innerHTML = html;
                    
                    // Re-initialize plugins
                    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl)
                    });

                    // Fetch Location if element exists
                    const locationEl = document.getElementById('location-' + id);
                    if (locationEl) {
                        const ipEl = document.getElementById('ip-' + id);
                        const ip = ipEl ? ipEl.innerText.trim() : '';

                        if (ip && ip !== '127.0.0.1' && ip !== 'IP Yoxdur' && ip !== '-') {
                            fetch(`http://ip-api.com/json/${ip}`)
                                .then(response => response.json())
                                .then(data => {
                                    if(data.status === 'success') {
                                        locationEl.className = 'd-flex align-items-center gap-2 badge bg-soft-info text-info border border-info border-opacity-25';
                                        locationEl.innerHTML = `
                                            <img src="https://flagcdn.com/16x12/${data.countryCode.toLowerCase()}.png" alt="${data.country}" class="rounded-1">
                                            <span>${data.city}, ${data.country}</span>
                                            <a href="https://www.google.com/maps/search/?api=1&query=${data.lat},${data.lon}" target="_blank" class="text-info hover-text-primary ms-1" title="Xəritədə bax">
                                                <i class="ri-map-2-line"></i>
                                            </a>
                                        `;
                                    } else {
                                        locationEl.className = 'badge bg-soft-secondary text-muted';
                                        locationEl.innerText = 'Tapılmadı';
                                    }
                                })
                                .catch(error => {
                                    console.error('IP fetch error:', error);
                                    locationEl.className = 'badge bg-soft-secondary text-muted';
                                    locationEl.innerText = 'Xəta';
                                });
                        } else {
                            locationEl.className = 'badge bg-soft-secondary text-muted';
                            locationEl.innerText = (ip === '127.0.0.1') ? 'Localhost' : 'Məlumat yoxdur';
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading activity details:', error));
    }

    // Enterprise Features
    function exportAudit(id) {
        // For now, simpler Print-to-PDF approach
        window.print();
        // In future: Redirect to download URL -> window.location.href = `/admin/activity-log/${id}/export`;
    }

    function saveNote(id) {
        const note = document.getElementById(`note-${id}`).value;
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        
        btn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i>';
        btn.disabled = true;

        fetch(`{{ url('admin/activity-log') }}/${id}/note`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ note: note })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Qeyd yadda saxlanıldı',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                throw new Error(data.message || 'Xəta baş verdi');
            }
        })
        .catch(error => {
            console.error(error);
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Qeyd saxlanılmadı',
                text: error.message
            });
        })
        .finally(() => {
            btn.innerHTML = originalContent;
            btn.disabled = false;
        });
    }

    function revertActivity(id) {
        Swal.fire({
            title: 'Dəyişikliyi geri qaytarmaq istəyirsiniz?',
            text: "Bu əməliyyat mövcud məlumatları fəaliyyətdən əvvəlki halına qaytaracaq. Bu əməliyyatın özü də yeni bir fəaliyyət kimi qeyd olunacaq.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#eab308',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Bəli, geri qaytar',
            cancelButtonText: 'Ləğv et',
            background: '#1e2030',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'İcra olunur...',
                    text: 'Zəhmət olmasa gözləyin',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); },
                    background: '#1e2030',
                    color: '#fff'
                });

                fetch(`{{ url('admin/activity-log') }}/${id}/revert`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Uğurlu!',
                            text: 'Məlumatlar əvvəlki halına qaytarıldı.',
                            background: '#1e2030',
                            color: '#fff'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Geri qaytarmaq mümkün olmadı');
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Xəta!',
                        text: error.message,
                        background: '#1e2030',
                        color: '#fff'
                    });
                });
            }
        });
    }

    // Global functions for Modal Interactions
    function toggleView() {
        const isJson = document.getElementById('viewToggle').checked;
        const visualView = document.getElementById('visualView');
        const jsonView = document.getElementById('jsonView');
        if(visualView && jsonView) {
            visualView.style.display = isJson ? 'none' : 'block';
            jsonView.style.display = isJson ? 'block' : 'none';
        }
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

    function showDiff(oldVal, newVal, containerId) {
        const container = document.getElementById(containerId);
        const parent = document.getElementById('diff-container-' + containerId.replace('diff-', ''));
        
        if (container && parent) {
            if (parent.classList.contains('d-none')) {
                const diff = Diff.diffWords(oldVal, newVal);
                const fragment = document.createDocumentFragment();
                
                diff.forEach((part) => {
                    const color = part.added ? 'text-success bg-soft-success' :
                        part.removed ? 'text-danger bg-soft-danger text-decoration-line-through' : 'text-muted';
                    const span = document.createElement('span');
                    span.className = color;
                    span.appendChild(document.createTextNode(part.value));
                    fragment.appendChild(span);
                });

                container.innerHTML = '';
                container.appendChild(fragment);
                parent.classList.remove('d-none');
            } else {
                parent.classList.add('d-none');
            }
        }
    }
    function revertActivity(id) {
        Swal.fire({
            title: 'Əminsiniz?',
            text: "Bu dəyişiklik geri qaytarılacaq!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d500f9',
            cancelButtonColor: '#35394b',
            confirmButtonText: 'Bəli, qaytar',
            cancelButtonText: 'Ləğv et',
            background: '#1e2030',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/activity-log/${id}/revert`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                document.body.appendChild(form);
                form.submit();
            }
        })
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsdiff/5.1.0/diff.min.js"></script>

@endpush


