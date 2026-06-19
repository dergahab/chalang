@extends('admin.layouts.main')

@section('heading_title', 'Home Sections')

@section('heading_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home-sections.index') }}">Home Sections</a></li>
    <li class="breadcrumb-item active">{{ $activeSection['title'] }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                        <div>
                            <h4 class="mt-0 header-title">Home Sections: {{ $activeSection['title'] }}</h4>
                            @if(!empty($activeSection['description']))
                                <p class="text-muted small mb-0">{{ $activeSection['description'] }}</p>
                            @endif
                        </div>
                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.home-sections.index') }}">Back</a>
                    </div>

                    <form action="{{ route('admin.home-sections.update', ['section' => $activeSection['id']]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <style>
                            .map-points-editor {
                                padding: 12px;
                                border-radius: 14px;
                                border: 1px solid rgba(0,0,0,0.08);
                                background: rgba(255,255,255,0.04);
                            }
                            .map-points-canvas {
                                position: relative;
                                width: 100%;
                                max-width: 720px;
                                aspect-ratio: 2 / 1;
                                border-radius: 12px;
                                overflow: hidden;
                                background: #0f172a;
                                border: 1px solid rgba(0,0,0,0.08);
                            }
                            .map-points-img {
                                width: 100%;
                                height: 100%;
                                object-fit: contain;
                                display: block;
                            }
                            .map-points-markers {
                                position: absolute;
                                inset: 0;
                                pointer-events: none;
                            }
                            .map-point-marker {
                                position: absolute;
                                width: 12px;
                                height: 12px;
                                border-radius: 50%;
                                background: #7c3aed;
                                border: 2px solid rgba(255,255,255,0.85);
                                transform: translate(-50%, -50%);
                                box-shadow: 0 0 10px rgba(124,58,237,0.45);
                            }
                            .map-point-marker.active {
                                box-shadow: 0 0 14px rgba(124,58,237,0.85);
                            }
                            .map-points-actions {
                                display: flex;
                                align-items: center;
                                gap: 10px;
                                margin-top: 10px;
                            }
                            .map-points-list {
                                margin-top: 12px;
                                display: flex;
                                flex-direction: column;
                                gap: 8px;
                            }
                            .map-point-row {
                                display: flex;
                                flex-wrap: wrap;
                                gap: 8px;
                                align-items: center;
                            }
                            .map-point-row .form-control {
                                min-width: 0;
                            }
                            .map-point-row.active {
                                outline: 1px dashed rgba(124,58,237,0.6);
                                padding: 6px;
                                border-radius: 10px;
                            }
                        </style>

                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($sections as $section)
                                    <a class="btn btn-sm {{ $section['id'] === $activeSection['id'] ? 'btn-primary' : 'btn-outline-primary' }}"
                                       href="{{ route('admin.home-sections.edit', ['section' => $section['id']]) }}">
                                        {{ $section['title'] }}
                                    </a>
                                @endforeach
                            </div>
                            @if($enabledKey)
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" id="section_enabled" name="section_enabled" value="1" {{ $sectionEnabled ? 'checked' : '' }}>
                                    <label class="form-check-label" for="section_enabled">Show on homepage</label>
                                </div>
                            @endif
                        </div>

                        <ul class="nav nav-tabs" id="home-sections-tab" role="tablist">
                            @foreach($langs as $lang)
                                @php
                                    $tabId = $lang->country ?? $lang->lang;
                                @endphp
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if($loop->first) active @endif"
                                            id="{{ $tabId }}-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#{{ $tabId }}-pane"
                                            type="button"
                                            role="tab"
                                            aria-controls="{{ $tabId }}-pane"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $lang->lang }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mt-3" id="home-sections-tabContent">
                            @foreach($langs as $lang)
                                @php
                                    $tabId = $lang->country ?? $lang->lang;
                                    $locale = $lang->lang;
                                    $oldLocaleValues = old('content.' . $locale, []);
                                @endphp
                                <div class="tab-pane fade @if($loop->first) show active @endif"
                                     id="{{ $tabId }}-pane"
                                     role="tabpanel"
                                     aria-labelledby="{{ $tabId }}-tab">

                                    <div class="row">
                                        @foreach($activeSection['fields'] as $field)
                                            @php
                                                $fieldKey = $field['key'];
                                                $fieldType = $field['type'] ?? 'text';
                                                $fieldId = 'field_' . $locale . '_' . str_replace(['.', ' ', '[', ']'], '_', $fieldKey);
                                                $value = $oldLocaleValues[$fieldKey] ?? ($values[$locale][$fieldKey] ?? '');
                                                $isTextarea = $fieldType === 'textarea';
                                                $isMapPoints = $fieldType === 'map_points';
                                                $isImage = $fieldType === 'image';
                                                $hasPicker = !empty($field['picker']);
                                            @endphp
                                            <div class="{{ ($isTextarea || $isMapPoints) ? 'col-12' : 'col-md-6' }} mb-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label class="form-label mb-1">{{ $field['label'] }}</label>
                                                    @if($hasPicker && $isTextarea)
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm"
                                                                data-lfm-target="{{ $fieldId }}">
                                                            Add media
                                                        </button>
                                                    @endif
                                                </div>

                                                @if($isTextarea)
                                                    <textarea class="form-control"
                                                              id="{{ $fieldId }}"
                                                              name="content[{{ $locale }}][{{ $fieldKey }}]"
                                                              rows="4">{{ $value }}</textarea>
                                                @elseif($isImage)
                                                    <div class="input-group">
                                                        <input type="text"
                                                               class="form-control"
                                                               id="{{ $fieldId }}"
                                                               name="content[{{ $locale }}][{{ $fieldKey }}]"
                                                               value="{{ $value }}">
                                                        <button class="btn btn-outline-secondary lfm-image"
                                                                type="button"
                                                                data-input="{{ $fieldId }}"
                                                                data-preview="{{ $fieldId }}_preview">
                                                            Select
                                                        </button>
                                                    </div>
                                                    <div id="{{ $fieldId }}_preview" class="mt-2" style="max-height:120px;">
                                                        @if($value)
                                                            <img src="{{ $value }}" style="height: 5rem; background: #111; padding: 5px; border-radius: 4px;">
                                                        @endif
                                                    </div>
                                                @elseif($fieldType === 'map_points')
                                                    @php
                                                        $mapUrlKey = 'preview.process.map_url';
                                                        $mapUrlId = 'field_' . $locale . '_' . str_replace(['.', ' ', '[', ']'], '_', $mapUrlKey);
                                                        $mapUrlValue = $oldLocaleValues[$mapUrlKey] ?? ($values[$locale][$mapUrlKey] ?? '');
                                                        $defaultMapUrl = '/assets/images/world-map-borders.svg';
                                                    @endphp
                                                    <div class="map-points-editor"
                                                         data-target="{{ $fieldId }}"
                                                         data-map-input="{{ $mapUrlId }}"
                                                         data-default-map="{{ $defaultMapUrl }}">
                                                        <input type="hidden"
                                                               id="{{ $fieldId }}"
                                                               name="content[{{ $locale }}][{{ $fieldKey }}]"
                                                               value="{{ $value }}">
                                                        <div class="map-points-canvas">
                                                            <img src="{{ $mapUrlValue ?: $defaultMapUrl }}" class="map-points-img" alt="Map preview">
                                                            <div class="map-points-markers"></div>
                                                        </div>
                                                        <div class="map-points-actions">
                                                            <button type="button" class="btn btn-sm btn-outline-primary map-point-add">Add point</button>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary map-point-sync">Sync to other languages</button>
                                                            <span class="text-muted small">Click on map to add/pick. Top/Left are % inside the map image.</span>
                                                        </div>
                                                        <div class="map-points-list"></div>
                                                        <div class="text-muted small mt-2">Tip: Use the “Pick” button to place the point precisely on the map.</div>
                                                    </div>
                                                @elseif($fieldType === 'map_styles')
                                                    @php
                                                        $mapStylesStr = $value ?: '{"ocean":"transparent","land":"#111625","stroke":"rgba(124, 58, 237, 0.16)","strokeWidth":0.6,"opacity":75,"glow":true}';
                                                        $ms = json_decode($mapStylesStr, true);
                                                    @endphp
                                                    <div class="map-styles-editor card bg-dark text-white p-3 mb-3 border-secondary" data-target="{{ $fieldId }}">
                                                        <input type="hidden" id="{{ $fieldId }}" class="map-styles-value" name="content[{{ $locale }}][{{ $fieldKey }}]" value="{{ $value }}">
                                                        <div class="row g-3 align-items-end">
                                                            <div class="col-md-4">
                                                                <label class="form-label small text-muted mb-1">Ocean/Bg Color</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="color" class="form-control form-control-color ms-ocean-color" value="{{ $ms['ocean'] !== 'transparent' ? $ms['ocean'] : '#0b0f19' }}" style="max-width:50px;">
                                                                    <input type="text" class="form-control ms-ocean-text bg-dark text-white border-secondary" value="{{ $ms['ocean'] ?? 'transparent' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label small text-muted mb-1">Land Color</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="color" class="form-control form-control-color ms-land-color" value="{{ $ms['land'] !== 'transparent' ? $ms['land'] : '#111625' }}" style="max-width:50px;">
                                                                    <input type="text" class="form-control ms-land-text bg-dark text-white border-secondary" value="{{ $ms['land'] ?? '#111625' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label small text-muted mb-1">Stroke Color</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="color" class="form-control form-control-color ms-stroke-color" value="{{ strlen($ms['stroke'] ?? '') === 7 ? $ms['stroke'] : '#7c3aed' }}" style="max-width:50px;">
                                                                    <input type="text" class="form-control ms-stroke-text bg-dark text-white border-secondary" value="{{ $ms['stroke'] ?? 'rgba(124, 58, 237, 0.16)' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label small text-muted mb-1">Stroke Width: <span class="ms-sw-val text-info">{{ $ms['strokeWidth'] ?? 0.6 }}</span>px</label>
                                                                <input type="range" class="form-range ms-stroke-width" min="0" max="2" step="0.1" value="{{ $ms['strokeWidth'] ?? 0.6 }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label small text-muted mb-1">Opacity: <span class="ms-op-val text-info">{{ $ms['opacity'] ?? 75 }}</span>%</label>
                                                                <input type="range" class="form-range ms-opacity" min="10" max="100" step="5" value="{{ $ms['opacity'] ?? 75 }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-check form-switch mb-2">
                                                                    <input class="form-check-input ms-glow" type="checkbox" role="switch" {{ !isset($ms['glow']) || $ms['glow'] ? 'checked' : '' }}>
                                                                    <label class="form-check-label small">Neon Glow Effect</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($fieldType === 'key_value_list')
                                                    <div class="key-value-repeater" data-target="{{ $fieldId }}">
                                                        <input type="hidden" id="{{ $fieldId }}" name="content[{{ $locale }}][{{ $fieldKey }}]" value="{{ $value }}">
                                                        <div class="repeater-list mb-2 text-start">
                                                            <!-- JS will populate this -->
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-row">
                                                            + Add New Item
                                                        </button>
                                                    </div>
                                                @elseif($fieldType === 'estimator_matrix')
                                                    <div class="estimator-matrix" data-target="{{ $fieldId }}">
                                                        <input type="hidden" id="{{ $fieldId }}" name="content[{{ $locale }}][{{ $fieldKey }}]" value="{{ $value }}">
                                                        
                                                        <div class="table-responsive mb-2">
                                                            <table class="table table-sm table-bordered" style="background:rgba(255,255,255,0.05); border-color:rgba(255,255,255,0.1);">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:50px;">Def.</th>
                                                                        <th>Service Label</th>
                                                                        <th style="width:120px;">Min Price</th>
                                                                        <th style="width:120px;">Max Price</th>
                                                                        <th style="width:100px;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="matrix-list"></tbody>
                                                            </table>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-matrix-row">
                                                            + Add Service
                                                        </button>
                                                    </div>
                                                @else
                                                    <input type="text"
                                                           class="form-control"
                                                           id="{{ $fieldId }}"
                                                           name="content[{{ $locale }}][{{ $fieldKey }}]"
                                                           value="{{ $value }}">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success px-4 py-2">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_stack')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    // File Manager
    $('.lfm-image').filemanager('image');
    const lfm = function (type, options, cb) {
        let routePrefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
        window.open(routePrefix + '?type=' + type, 'FileManager', 'width=900,height=600');
        window.SetUrl = cb;
    };

    document.querySelectorAll('[data-lfm-target]').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const targetId = button.getAttribute('data-lfm-target');
            const target = document.getElementById(targetId);
            if (!target) return;
            lfm('image', { prefix: '/laravel-filemanager' }, function (items) {
                const urls = (items || []).map(function (item) { return item.url; }).filter(Boolean);
                if (!urls.length) return;
                const separator = target.value.trim() === '' ? '' : "\n";
                target.value = target.value + separator + urls.join("\n");
            });
        });
    });

    // Key Value Repeater Logic
    document.addEventListener('DOMContentLoaded', () => {
        // --- SHARED TRANSLATIONS ---
        const estLabels = {
            @foreach($langs as $lang)
            '{{ $lang->lang }}': {
                'slow': '{{ addslashes(trans('preview.estimator.urgency_slow', [], $lang->lang)) }}',
                'normal': '{{ addslashes(trans('preview.estimator.urgency_normal', [], $lang->lang)) }}',
                'urgent': '{{ addslashes(trans('preview.estimator.urgency_urgent', [], $lang->lang)) }}',
                'small': '{{ addslashes(trans('preview.estimator.size_small', [], $lang->lang)) }}',
                'medium': '{{ addslashes(trans('preview.estimator.size_medium', [], $lang->lang)) }}',
                'large': '{{ addslashes(trans('preview.estimator.size_large', [], $lang->lang)) }}',
            },
            @endforeach
        };
        const getLabels = (locale) => estLabels[locale] || estLabels['en'] || {};

        document.querySelectorAll('.key-value-repeater').forEach(container => {
            const hiddenInput = container.querySelector('input[type="hidden"]');
            const listContainer = container.querySelector('.repeater-list');
            const addButton = container.querySelector('.btn-add-row');

            const renderRows = () => {
                const raw = hiddenInput.value.trim();
                let params = [];

                // Try to parse as JSON first (Legacy support)
                try {
                    if (raw.startsWith('[') || raw.startsWith('{')) {
                        const jsonData = JSON.parse(raw);
                        if (Array.isArray(jsonData)) {
                            params = jsonData.map(item => ({
                                label: item.label,
                                value: item.value,
                                default: !!item.default
                            }));
                        }
                    }
                } catch (e) {}

                // Fallback to Pipe format (Standard)
                if (params.length === 0 && raw !== '') {
                    const lines = raw.split(/\r?\n/).filter(line => line.trim() !== '');
                    params = lines.map(line => {
                        const isDefault = line.trim().startsWith('*');
                        const cleanLine = isDefault ? line.trim().substring(1).trim() : line.trim();
                        const parts = cleanLine.split('|');
                        return {
                            label: parts[0]?.trim() || '',
                            value: parts[1]?.trim() || '',
                            default: isDefault
                        };
                    });
                }

                // --- DEFAULT DATA INJECTION (If Empty) ---
                if (params.length === 0) {
                    const nameAttr = hiddenInput.name || '';
                    const localeMatch = nameAttr.match(/content\[([a-zA-Z0-9_-]+)\]/);
                    const locale = localeMatch ? localeMatch[1] : '{{ app()->getLocale() }}';
                    const l = getLabels(locale);

                    if (nameAttr.includes('[preview.estimator.urgencies]')) {
                        params = [
                            { label: l.slow || 'Slow', value: '1', default: false },
                            { label: l.normal || 'Standard', value: '1.5', default: true },
                            { label: l.urgent || 'Urgent', value: '2.5', default: false }
                        ];
                    } else if (nameAttr.includes('[preview.estimator.sizes]')) {
                        params = [
                            { label: l.small || 'Small', value: '1', default: false },
                            { label: l.medium || 'Medium', value: '1.5', default: true },
                            { label: l.large || 'Large (Enterprise)', value: '2.5', default: false }
                        ];
                    }
                }

                listContainer.innerHTML = '';

                params.forEach((item) => {
                    const row = document.createElement('div');
                    row.className = 'd-flex gap-2 mb-2 align-items-center p-2 rounded';
                    row.style.background = 'rgba(255,255,255,0.05)';
                    row.style.border = '1px solid rgba(255,255,255,0.1)';
                    
                    row.innerHTML = `
                        <div class="form-check" title="Mark as Default">
                            <input class="form-check-input default-radio" type="radio" name="default_${hiddenInput.id}" ${item.default ? 'checked' : ''} style="cursor:pointer;">
                        </div>
                        <input type="text" class="form-control form-control-sm label-input" placeholder="Label" value="${(item.label || '').replace(/"/g, '&quot;')}" style="background:#1a202c; color:#fff; border-color:#2d3748;">
                        <span class="text-muted">|</span>
                        <input type="text" class="form-control form-control-sm value-input" placeholder="Value" value="${(item.value || '').replace(/"/g, '&quot;')}" style="background:#1a202c; color:#fff; border-color:#2d3748;">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove text-danger border-0" title="Remove" style="font-size:1.2rem; line-height:1;">&times;</button>
                    `;
                    listContainer.appendChild(row);

                    // Row Events
                    row.querySelector('.btn-remove').addEventListener('click', () => {
                        row.remove();
                        syncValue();
                    });
                    
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach(input => input.addEventListener('input', syncValue));
                    
                    row.querySelector('.default-radio').addEventListener('change', syncValue);
                });
            };

            const syncValue = () => {
                const rows = Array.from(listContainer.children);
                const lines = rows.map(row => {
                    const isDefault = row.querySelector('.default-radio').checked;
                    const label = row.querySelector('.label-input').value.trim();
                    const val = row.querySelector('.value-input').value.trim();
                    if (!label && !val) return null;
                    
                    return (isDefault ? '* ' : '') + label + ' | ' + val;
                }).filter(Boolean);

                hiddenInput.value = lines.join('\n');
            };

            addButton.addEventListener('click', () => {
                const row = document.createElement('div');
                row.className = 'd-flex gap-2 mb-2 align-items-center p-2 rounded';
                row.style.background = 'rgba(255,255,255,0.05)';
                row.style.border = '1px solid rgba(255,255,255,0.1)';
                
                row.innerHTML = `
                    <div class="form-check" title="Mark as Default">
                        <input class="form-check-input default-radio" type="radio" name="default_${hiddenInput.id}" style="cursor:pointer;">
                    </div>
                    <input type="text" class="form-control form-control-sm label-input" placeholder="Label" style="background:#1a202c; color:#fff; border-color:#2d3748;">
                    <span class="text-muted">|</span>
                    <input type="text" class="form-control form-control-sm value-input" placeholder="Value" style="background:#1a202c; color:#fff; border-color:#2d3748;">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove text-danger border-0" style="font-size:1.2rem; line-height:1;">&times;</button>
                `;
                listContainer.appendChild(row);
                
                // Add standard event listeners
                row.querySelector('.btn-remove').addEventListener('click', () => {
                     row.remove();
                     syncValue();
                });
                row.querySelectorAll('input').forEach(i => i.addEventListener('input', syncValue));
                row.querySelector('.default-radio').addEventListener('change', syncValue);
            });

            // Initial Render
            renderRows();
        });

        // MAP POINTS EDITOR
        const parseMapPoints = (raw) => {
            if (!raw) return [];
            let parsed = [];
            try {
                const data = JSON.parse(raw);
                if (Array.isArray(data)) {
                    parsed = data;
                }
            } catch (e) {}

            if (!parsed.length && raw.includes('|')) {
                parsed = raw.split(/\r?\n/).map(line => {
                    const parts = line.split('|').map(p => p.trim());
                    if (parts.length < 3) return null;
                    return { label: parts[0], top: parts[1], left: parts[2] };
                }).filter(Boolean);
            }

            return parsed.map(item => ({
                label: (item.label || '').toString(),
                top: parseFloat(item.top ?? item.y ?? 50) || 0,
                left: parseFloat(item.left ?? item.x ?? 50) || 0
            }));
        };

        const clampPercent = (val) => Math.max(0, Math.min(100, val));

        document.querySelectorAll('.map-points-editor').forEach(editor => {
            const hiddenInput = editor.querySelector('input[type="hidden"]');
            const mapInputId = editor.dataset.mapInput;
            const mapInput = mapInputId ? document.getElementById(mapInputId) : null;
            const defaultMap = editor.dataset.defaultMap || '';
            const img = editor.querySelector('.map-points-img');
            const markersLayer = editor.querySelector('.map-points-markers');
            const list = editor.querySelector('.map-points-list');
            const addBtn = editor.querySelector('.map-point-add');
            const syncBtn = editor.querySelector('.map-point-sync');
            const canvas = editor.querySelector('.map-points-canvas');

            if (!hiddenInput || !canvas || !img || !markersLayer || !list) {
                return;
            }

            let points = parseMapPoints(hiddenInput.value);
            let pickIndex = null;
            const nameAttr = hiddenInput.name || '';
            const localeMatch = nameAttr.match(/content\[([a-zA-Z0-9_-]+)\]/);
            const localeKey = localeMatch ? localeMatch[1] : null;

            const save = () => {
                const round = (val) => Math.round(val * 10) / 10;
                points = points.map(point => ({
                    label: (point.label || '').toString(),
                    top: round(clampPercent(point.top)),
                    left: round(clampPercent(point.left))
                }));
                hiddenInput.value = JSON.stringify(points);
            };

            const getImageMetrics = () => {
                const rect = canvas.getBoundingClientRect();
                const natW = img.naturalWidth || rect.width || 1;
                const natH = img.naturalHeight || rect.height || 1;
                const imgRatio = natW / natH;
                const canvasRatio = rect.width / rect.height;

                let displayWidth = rect.width;
                let displayHeight = rect.height;
                let offsetX = 0;
                let offsetY = 0;

                if (imgRatio > canvasRatio) {
                    displayWidth = rect.width;
                    displayHeight = rect.width / imgRatio;
                    offsetY = (rect.height - displayHeight) / 2;
                } else {
                    displayHeight = rect.height;
                    displayWidth = rect.height * imgRatio;
                    offsetX = (rect.width - displayWidth) / 2;
                }

                return { rect, displayWidth, displayHeight, offsetX, offsetY };
            };

            const renderMarkers = () => {
                markersLayer.innerHTML = '';
                const metrics = getImageMetrics();
                points.forEach((point, index) => {
                    const marker = document.createElement('div');
                    marker.className = 'map-point-marker' + (index === pickIndex ? ' active' : '');
                    const topPx = metrics.offsetY + (clampPercent(point.top) / 100) * metrics.displayHeight;
                    const leftPx = metrics.offsetX + (clampPercent(point.left) / 100) * metrics.displayWidth;
                    marker.style.top = topPx + 'px';
                    marker.style.left = leftPx + 'px';
                    marker.title = point.label || 'Point';
                    marker.dataset.index = index;
                    markersLayer.appendChild(marker);
                });
            };

            const renderList = () => {
                list.innerHTML = '';
                points.forEach((point, index) => {
                    const row = document.createElement('div');
                    row.className = 'map-point-row' + (index === pickIndex ? ' active' : '');
                    row.innerHTML = `
                        <input type="text" class="form-control form-control-sm map-point-label" placeholder="Label" value="${(point.label || '').replace(/"/g, '&quot;')}">
                        <input type="number" step="0.1" class="form-control form-control-sm map-point-top" placeholder="Top" value="${point.top}">
                        <input type="number" step="0.1" class="form-control form-control-sm map-point-left" placeholder="Left" value="${point.left}">
                        <button type="button" class="btn btn-sm btn-outline-secondary map-point-pick">Pick</button>
                        <button type="button" class="btn btn-sm btn-outline-danger map-point-remove">Remove</button>
                    `;

                    const labelInput = row.querySelector('.map-point-label');
                    const topInput = row.querySelector('.map-point-top');
                    const leftInput = row.querySelector('.map-point-left');
                    const pickBtn = row.querySelector('.map-point-pick');
                    const removeBtn = row.querySelector('.map-point-remove');

                    labelInput.addEventListener('input', () => {
                        points[index].label = labelInput.value;
                        save();
                        const marker = markersLayer.querySelector(`[data-index="${index}"]`);
                        if (marker) marker.title = points[index].label || 'Point';
                    });

                    topInput.addEventListener('input', () => {
                        points[index].top = clampPercent(parseFloat(topInput.value) || 0);
                        save();
                        renderMarkers();
                    });

                    leftInput.addEventListener('input', () => {
                        points[index].left = clampPercent(parseFloat(leftInput.value) || 0);
                        save();
                        renderMarkers();
                    });

                    pickBtn.addEventListener('click', () => {
                        pickIndex = index;
                        renderMarkers();
                        renderList();
                    });

                    removeBtn.addEventListener('click', () => {
                        points.splice(index, 1);
                        pickIndex = null;
                        save();
                        render();
                    });

                    list.appendChild(row);
                });
            };

            const render = () => {
                renderMarkers();
                renderList();
            };

            if (addBtn) {
                addBtn.addEventListener('click', () => {
                    points.push({ label: 'New point', top: 50, left: 50 });
                    pickIndex = points.length - 1;
                    save();
                    render();
                });
            }

            if (canvas) {
                canvas.addEventListener('click', (event) => {
                    const metrics = getImageMetrics();
                    const clickX = event.clientX - metrics.rect.left - metrics.offsetX;
                    const clickY = event.clientY - metrics.rect.top - metrics.offsetY;

                    if (clickX < 0 || clickY < 0 || clickX > metrics.displayWidth || clickY > metrics.displayHeight) {
                        return;
                    }

                    const left = clampPercent((clickX / metrics.displayWidth) * 100);
                    const top = clampPercent((clickY / metrics.displayHeight) * 100);

                    if (pickIndex !== null && points[pickIndex]) {
                        points[pickIndex].left = left;
                        points[pickIndex].top = top;
                        pickIndex = null;
                    } else {
                        points.push({ label: 'New point', top: top, left: left });
                    }
                    save();
                    render();
                });
            }

            if (syncBtn) {
                syncBtn.addEventListener('click', () => {
                    if (!localeKey) {
                        return;
                    }
                    save();
                    const payload = JSON.parse(hiddenInput.value || '[]');
                    window.__mapPointsEditors = window.__mapPointsEditors || {};
                    Object.keys(window.__mapPointsEditors).forEach(key => {
                        if (key === localeKey) return;
                        const target = window.__mapPointsEditors[key];
                        if (target && typeof target.setPoints === 'function') {
                            target.setPoints(payload);
                        }
                    });
                });
            }

            if (mapInput && img) {
                mapInput.addEventListener('input', () => {
                    const next = mapInput.value.trim();
                    img.src = next !== '' ? next : defaultMap;
                });
            }

            if (img) {
                img.addEventListener('load', () => {
                    const ratio = img.naturalWidth && img.naturalHeight
                        ? img.naturalWidth / img.naturalHeight
                        : 0;
                    if (ratio > 0) {
                        canvas.style.aspectRatio = ratio.toFixed(3) + ' / 1';
                    }
                    renderMarkers();
                });
            }
            window.addEventListener('resize', () => renderMarkers());

            if (localeKey) {
                window.__mapPointsEditors = window.__mapPointsEditors || {};
                window.__mapPointsEditors[localeKey] = {
                    getPoints: () => points,
                    setPoints: (next) => {
                        points = parseMapPoints(JSON.stringify(next || []));
                        save();
                        render();
                    }
                };
            }

            save();
            render();
        });

        // ESTIMATOR MATRIX LOGIC
        // Simple Modal for Configuration
        const modalHtml = `
            <div id="est-config-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; justify-content:center; align-items:center;">
                <div style="background:#1f2937; padding:20px; border-radius:8px; width:90%; max-width:600px; max-height:90vh; overflow-y:auto; border:1px solid #374151; color:#fff;">
                    <h5 class="mb-3">Configure Service: <span id="modal-service-name"></span></h5>
                    
                    <div class="mb-3">
                        <label class="form-label text-warning">Specific Sizes (Leave empty for Global Defaults)</label>
                        <div id="modal-sizes-list" class="nested-list"></div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addNestedRow('modal-sizes-list')">+ Add Size</button>
                    </div>
                    
                    <hr style="border-color:#374151;">

                    <div class="mb-3">
                        <label class="form-label text-warning">Specific Urgency Levels (Leave empty for Global Defaults)</label>
                        <div id="modal-urgencies-list" class="nested-list"></div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addNestedRow('modal-urgencies-list')">+ Add Urgency</button>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" id="btn-close-modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btn-save-modal">Save Configuration</button>
                    </div>
                </div>
            </div>`;
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        const modal = document.getElementById('est-config-modal');
        let activeRowData = null; // Reference to current obj
        let activeCallback = null;

        window.addNestedRow = (containerId, data = {}) => {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'd-flex gap-2 mb-2 align-items-center';
            div.innerHTML = `
                <input type="text" class="form-control form-control-sm nested-label" placeholder="Label" value="${(data.label||'').replace(/"/g, '&quot;')}" style="background:#111; color:#fff; border-color:#444;">
                <input type="number" step="0.01" class="form-control form-control-sm nested-value" placeholder="Value" value="${data.value||''}" style="width:80px; background:#111; color:#fff; border-color:#444;">
                <div class="form-check ms-1">
                    <input class="form-check-input nested-default" type="radio" name="def_${containerId}" ${data.default?'checked':''}>
                </div>
                <button type="button" class="btn btn-sm text-danger" onclick="this.parentElement.remove()">&times;</button>
            `;
            container.appendChild(div);
        };

        const openConfigModal = (serviceName, sizes, urgencies, locale, onSave) => {
            document.getElementById('modal-service-name').innerText = serviceName || 'New Service';
            document.getElementById('modal-sizes-list').innerHTML = '';
            document.getElementById('modal-urgencies-list').innerHTML = '';

            // Auto-populate defaults if empty
            if (!sizes || sizes.length === 0) {
                const l = getLabels(locale);
                sizes = [
                    { label: l.small || 'Small', value: '1', default: false },
                    { label: l.medium || 'Medium', value: '1.5', default: true },
                    { label: l.large || 'Large', value: '2.5', default: false }
                ];
            }
            if (!urgencies || urgencies.length === 0) {
                const l = getLabels(locale);
                urgencies = [
                    { label: l.slow || 'Slow', value: '1', default: false },
                    { label: l.normal || 'Standard', value: '1.5', default: true },
                    { label: l.urgent || 'Urgent', value: '2.5', default: false }
                ];
            }
            
            (sizes || []).forEach(item => addNestedRow('modal-sizes-list', item));
            (urgencies || []).forEach(item => addNestedRow('modal-urgencies-list', item));
            
            modal.style.display = 'flex';
            
            // Handle Save
            document.getElementById('btn-save-modal').onclick = () => {
                const getList = (id) => {
                    return Array.from(document.getElementById(id).children).map(row => ({
                        label: row.querySelector('.nested-label').value.trim(),
                        value: row.querySelector('.nested-value').value,
                        default: row.querySelector('.nested-default').checked
                    })).filter(i => i.label && i.value);
                };
                
                onSave({
                    sizes: getList('modal-sizes-list'),
                    urgencies: getList('modal-urgencies-list')
                });
                modal.style.display = 'none';
            };
            
             document.getElementById('btn-close-modal').onclick = () => {
                modal.style.display = 'none';
            };
        };

        // MAIN MATRIX LOGIC
        const estimatorContainers = document.querySelectorAll('.estimator-matrix');
        if (estimatorContainers.length > 0) {
            console.log('Estimator Matrix Logic Loaded', estimatorContainers.length);
        }

        estimatorContainers.forEach(container => {
            const hiddenInput = container.querySelector('input[type="hidden"]');
            const tbody = container.querySelector('.matrix-list');
            
            // Initial Data Load
            let matrixData = [];
            try {
                let rawVal = hiddenInput.value;
                if (!rawVal || rawVal === 'null') rawVal = '[]';
                matrixData = JSON.parse(rawVal);
            } catch(e) { 
                console.error('Matrix Parse Error', e);
                matrixData = []; 
            }
            if (!Array.isArray(matrixData)) matrixData = [];

            // Helper: Get all containers
            const getAllMatrixContainers = () => document.querySelectorAll('.estimator-matrix');

            // Helper: Sync Data to Input
            const sync = () => {
                const newData = [];
                tbody.querySelectorAll('tr').forEach(tr => {
                    const activeInput = tr.querySelector('.row-active');
                    const labelInput = tr.querySelector('.row-label');
                    const priceInput = tr.querySelector('.row-price');
                    const maxPriceInput = tr.querySelector('.row-price-max');
                    
                    if (activeInput && labelInput && priceInput) {
                        newData.push({
                            active: activeInput.checked,
                            label: labelInput.value,
                            value: priceInput.value,
                            max_value: maxPriceInput ? maxPriceInput.value : '',
                            sizes: JSON.parse(tr.dataset.sizes || '[]'),
                            urgencies: JSON.parse(tr.dataset.urgencies || '[]')
                        });
                    }
                });
                hiddenInput.value = JSON.stringify(newData);
            };

            // Main Function: Add Row
            const addRow = (item = {}, isSync = false) => {
                if (!item) return; 
                
                const tr = document.createElement('tr');
                tr.dataset.sizes = JSON.stringify(item.sizes || []);
                tr.dataset.urgencies = JSON.stringify(item.urgencies || []);
                
                const labelVal = (item.label || '').replace(/"/g, '&quot;');
                const priceVal = item.value || '';
                const maxPriceVal = item.max_value || '';
                const activeChecked = item.active ? 'checked' : '';

                // Generate Options for Select
                const dbServices = @json($servicesList ?? []);
                console.log('DB Services:', dbServices); // DEBUG
                let optionsHtml = '<option value="">Select Service</option>';
                
                // Determine Locale from hiddenInput name
                const nameAttr = hiddenInput.name || '';
                const localeMatch = nameAttr.match(/content\[([a-zA-Z0-9_-]+)\]/);
                const currentLocale = localeMatch ? localeMatch[1] : '{{ app()->getLocale() }}';

                dbServices.forEach(srv => {
                    const trans = srv.translations.find(t => t.locale === currentLocale) 
                                || srv.translations.find(t => t.locale === '{{ app()->getLocale() }}') 
                                || srv.translations[0];
                    const srvName = trans ? trans.name : `Service #${srv.id}`;
                    const selected = labelVal === srvName ? 'selected' : '';
                    optionsHtml += `<option value="${srvName.replace(/"/g, '&quot;')}" ${selected}>${srvName}</option>`;
                });
                
                // Fallback: If current label is not in DB list, add it as a value (legacy support)
                if (labelVal && !optionsHtml.includes(`value="${labelVal.replace(/"/g, '&quot;')}"`)) {
                    optionsHtml += `<option value="${labelVal.replace(/"/g, '&quot;')}" selected>${labelVal} (Custom)</option>`;
                }
                
                tr.innerHTML = `
                    <td class="text-center align-middle">
                        <input class="form-check-input row-active" type="radio" name="active_srv_${hiddenInput.id}" ${activeChecked}>
                    </td>
                    <td>
                        <select class="form-select form-select-sm row-label" style="background-color: #1a202c; color: #fff; border-color: #4a5568;">
                            ${optionsHtml}
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm row-price" value="${priceVal}" placeholder="Min">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm row-price-max" value="${maxPriceVal}" placeholder="Max">
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-info btn-config" title="Configure"><i class="fas fa-cog"></i> Cfg</button>
                            <button type="button" class="btn btn-outline-danger btn-del">&times;</button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // --- Event Handlers ---

                // 1. Delete
                const btnDel = tr.querySelector('.btn-del');
                btnDel.addEventListener('click', (e) => {
                    if (!e.isTrusted) {
                        // Triggered by sync -> just remove
                        tr.remove();
                        sync();
                        return;
                    }
                    
                    // User click -> Sync then remove
                    const idx = Array.from(tbody.children).indexOf(tr);
                    if (idx !== -1) {
                         getAllMatrixContainers().forEach(c => {
                            if (c === container) return;
                            const otherRows = c.querySelector('.matrix-list').children;
                            if (otherRows[idx]) {
                                const otherBtn = otherRows[idx].querySelector('.btn-del');
                                if (otherBtn) otherBtn.dispatchEvent(new Event('click'));
                            }
                         });
                    }
                    tr.remove();
                    sync();
                });

                // 2. Price Sync
                const priceInput = tr.querySelector('.row-price');
                priceInput.addEventListener('input', (e) => {
                    sync();
                    if (!e.isTrusted) return; 
                    
                    const idx = Array.from(tbody.children).indexOf(tr);
                    getAllMatrixContainers().forEach(c => {
                         if (c === container) return;
                         const otherRow = c.querySelector('.matrix-list').children[idx];
                         if (otherRow) {
                             const otherInput = otherRow.querySelector('.row-price');
                             if (otherInput) {
                                 otherInput.value = priceInput.value;
                                 otherInput.dispatchEvent(new Event('input'));
                             }
                         }
                    });
                });

                // 2.1 Max Price Sync
                const maxPriceInput = tr.querySelector('.row-price-max');
                maxPriceInput.addEventListener('input', (e) => {
                    sync();
                    if (!e.isTrusted) return;
                    
                    const idx = Array.from(tbody.children).indexOf(tr);
                    getAllMatrixContainers().forEach(c => {
                         if (c === container) return;
                         const otherRow = c.querySelector('.matrix-list').children[idx];
                         if (otherRow) {
                             const otherMax = otherRow.querySelector('.row-price-max');
                             if (otherMax) {
                                 otherMax.value = maxPriceInput.value;
                                 otherMax.dispatchEvent(new Event('input'));
                             }
                         }
                    });
                });
                
                // 3. Label Sync (Just save)
                const labelInput = tr.querySelector('.row-label');
                // labelInput.addEventListener('input', sync); 
                // DISABLED SYNC for Labels to allow separate languages to valid separate service names from dropdown.
                labelInput.addEventListener('change', sync); // Only sync to hidden input, not across tabs.

                // 4. Active Sync
                const activeInput = tr.querySelector('.row-active');
                activeInput.addEventListener('change', (e) => {
                    sync();
                    if (!e.isTrusted) return;
                    
                    const idx = Array.from(tbody.children).indexOf(tr);
                    getAllMatrixContainers().forEach(c => {
                         if (c === container) return;
                         const otherRow = c.querySelector('.matrix-list').children[idx];
                         if (otherRow) {
                             const otherRadio = otherRow.querySelector('.row-active');
                             if (otherRadio) {
                                 otherRadio.checked = true;
                                 otherRadio.dispatchEvent(new Event('change'));
                             }
                         }
                    });
                });

                // 5. Config Modal
                tr.querySelector('.btn-config').onclick = () => {
                    const currentSizes = JSON.parse(tr.dataset.sizes || '[]');
                    const currentUrgencies = JSON.parse(tr.dataset.urgencies || '[]');
                    const name = tr.querySelector('.row-label').value;
                    
                    // Extract locale from container
                    const nameAttr = hiddenInput.name || '';
                    const localeMatch = nameAttr.match(/content\[([a-zA-Z0-9_-]+)\]/);
                    const locale = localeMatch ? localeMatch[1] : 'en';

                    openConfigModal(name, currentSizes, currentUrgencies, locale, (newData) => {
                        tr.dataset.sizes = JSON.stringify(newData.sizes);
                        tr.dataset.urgencies = JSON.stringify(newData.urgencies);
                        sync();
                        
                        // Sync Config to other tabs
                        const idx = Array.from(tbody.children).indexOf(tr);
                        getAllMatrixContainers().forEach(c => {
                            if (c === container) return;
                            const otherRow = c.querySelector('.matrix-list').children[idx];
                            if (otherRow) {
                                otherRow.dataset.sizes = JSON.stringify(newData.sizes);
                                otherRow.dataset.urgencies = JSON.stringify(newData.urgencies);
                                const event = new Event('input'); 
                                otherRow.querySelector('.row-price').dispatchEvent(event);
                            }
                        });
                    });
                };
            };

            // Initialize Data Checks
            if (matrixData.length === 0) {
                 console.log('Matrix Empty -> Populating Defaults');
                 matrixData = [
                    { label: 'Vebsayt', value: 2000, max_value: 3000, active: true, sizes: [], urgencies: [] },
                    { label: 'Mobil tətbiq', value: 3500, max_value: 5000, active: false, sizes: [], urgencies: [] },
                    { label: 'Brendinq', value: 1500, max_value: 2500, active: false, sizes: [], urgencies: [] },
                    { label: 'SMM', value: 1000, max_value: 1500, active: false, sizes: [], urgencies: [] }
                ];
            }
            
            // Render Initial Rows
            try {
                matrixData.forEach(item => addRow(item, true));
                sync();
            } catch(e) { console.error('Render Error', e); }

            // Expose addRow for external calls
            container.dateFormatAddRow = (data) => addRow(data, true);
        });

        // Loop 2: Wire up "Add Service" buttons
        document.querySelectorAll('.estimator-matrix').forEach(container => {
             const btn = container.querySelector('.btn-add-matrix-row');
             if (btn) {
                 btn.onclick = () => {
                     const defData = { label: 'New Service', value: 1000, max_value: 2000, active: false };
                     document.querySelectorAll('.estimator-matrix').forEach(c => {
                         if (c.dateFormatAddRow) c.dateFormatAddRow(defData);
                     });
                 };
             }
        });
        // Map Styles Logic
        document.querySelectorAll('.map-styles-editor').forEach(container => {
            const hidden = container.querySelector('.map-styles-value');
            const oc = container.querySelector('.ms-ocean-color');
            const ot = container.querySelector('.ms-ocean-text');
            const lc = container.querySelector('.ms-land-color');
            const lt = container.querySelector('.ms-land-text');
            const sc = container.querySelector('.ms-stroke-color');
            const st = container.querySelector('.ms-stroke-text');
            const sw = container.querySelector('.ms-stroke-width');
            const swVal = container.querySelector('.ms-sw-val');
            const op = container.querySelector('.ms-opacity');
            const opVal = container.querySelector('.ms-op-val');
            const glow = container.querySelector('.ms-glow');

            function sync() {
                swVal.textContent = sw.value;
                opVal.textContent = op.value;
                const data = {
                    ocean: ot.value,
                    land: lt.value,
                    stroke: st.value,
                    strokeWidth: parseFloat(sw.value),
                    opacity: parseInt(op.value, 10),
                    glow: glow.checked
                };
                hidden.value = JSON.stringify(data);
            }

            // Sync color pickers to text inputs
            oc.addEventListener('input', () => { ot.value = oc.value; sync(); });
            lc.addEventListener('input', () => { lt.value = lc.value; sync(); });
            sc.addEventListener('input', () => { st.value = sc.value; sync(); });

            // Sync text inputs to color pickers
            ot.addEventListener('input', () => { if(ot.value.length === 7) oc.value = ot.value; sync(); });
            lt.addEventListener('input', () => { if(lt.value.length === 7) lc.value = lt.value; sync(); });
            st.addEventListener('input', () => { if(st.value.length === 7) sc.value = st.value; sync(); });

            sw.addEventListener('input', sync);
            op.addEventListener('input', sync);
            glow.addEventListener('change', sync);
        });

    });
</script>
@endpush
