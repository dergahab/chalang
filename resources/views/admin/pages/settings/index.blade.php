@extends('admin.layouts.main')

@section('heading_title', 'Ümumi Tənzimləmələr')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header">
                <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab">
                            <i class="ri-home-gear-line me-1 align-bottom"></i> Ümumi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#contact" role="tab">
                            <i class="ri-phone-line me-1 align-bottom"></i> Əlaqə
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#social" role="tab">
                            <i class="ri-share-line me-1 align-bottom"></i> Sosial Media
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#seo" role="tab">
                            <i class="ri-global-line me-1 align-bottom"></i> SEO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#alerts" role="tab">
                            <i class="ri-alarm-warning-line me-1 align-bottom"></i> Ops & Alerts
                        </a>
                    </li>
                    @role('super-admin')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#branding" role="tab">
                            <i class="ri-palette-line me-1 align-bottom"></i> Theme
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#gradient-studio" role="tab" style="background:linear-gradient(135deg,#7c3aed22,#c026d322);">
                            <i class="ri-magic-line me-1 align-bottom" style="color:#c026d3"></i>
                            <span style="background:linear-gradient(135deg,#7c3aed,#c026d3);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:700;">Gradient Studio</span>
                        </a>
                    </li>
                    @endrole
                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="tab-content">
                        <!-- General Tab -->
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Saytın Adı</label>
                                    <input type="text" class="form-control" name="site_title" value="{{ $settings['site_title'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Footer Mətni</label>
                                    <input type="text" class="form-control" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" {{ isset($settings['maintenance_mode']) && $settings['maintenance_mode'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">Sayt Təmirdədir (Maintenance Mode)</label>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3 border-top pt-3">
                                    <h5 class="mb-3"><i class="ri-pulse-line me-2"></i> Canlı Layihə Statusu (Footer)</h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Canlı Status (AZ)</label>
                                            <input type="text" class="form-control" name="live_status_message_az" value="{{ $settings['live_status_message_az'] ?? '' }}" placeholder="Yeni xidmətlər əlavə olunur...">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Canlı Status (EN)</label>
                                            <input type="text" class="form-control" name="live_status_message_en" value="{{ $settings['live_status_message_en'] ?? '' }}" placeholder="Adding new services...">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Canlı Status (RU)</label>
                                            <input type="text" class="form-control" name="live_status_message_ru" value="{{ $settings['live_status_message_ru'] ?? '' }}" placeholder="Добавляем новые услуги...">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4 border-bottom pb-3">
                                    <h5 class="mb-3"><i class="ri-navigation-line me-2"></i> Naviqasiya (Feature Toggles)</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-3">
                                                <input type="hidden" name="nav_client_portal" value="0">
                                                <input class="form-check-input" type="checkbox" id="nav_client_portal" name="nav_client_portal" value="1" {{ isset($settings['nav_client_portal']) && $settings['nav_client_portal'] == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="nav_client_portal">Müştəri Portalı İkonu</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-3">
                                                <input type="hidden" name="nav_partner_hub" value="0">
                                                <input class="form-check-input" type="checkbox" id="nav_partner_hub" name="nav_partner_hub" value="1" {{ isset($settings['nav_partner_hub']) && $settings['nav_partner_hub'] == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="nav_partner_hub">Tərəfdaş Mərkəzi İkonu</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <h5 class="mb-3">Media</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">Logo (Light Mode)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="site_logo" name="site_logo" value="{{ $settings['site_logo'] ?? '' }}">
                                                <button class="btn btn-outline-secondary" type="button" id="lfm_logo" data-input="site_logo" data-preview="holder_logo">Seç</button>
                                            </div>
                                            <div id="holder_logo" class="mt-2" style="max-height:100px;">
                                                @if(isset($settings['site_logo']))
                                                    <img src="{{ $settings['site_logo'] }}" style="height: 5rem; background: #ccc; padding: 5px; border-radius: 4px;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Logo (Dark Mode)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="site_logo_dark" name="site_logo_dark" value="{{ $settings['site_logo_dark'] ?? '' }}">
                                                <button class="btn btn-outline-secondary" type="button" id="lfm_logo_dark" data-input="site_logo_dark" data-preview="holder_logo_dark">Seç</button>
                                            </div>
                                            <div id="holder_logo_dark" class="mt-2" style="max-height:100px;">
                                                @if(isset($settings['site_logo_dark']))
                                                    <img src="{{ $settings['site_logo_dark'] }}" style="height: 5rem; background: #333; padding: 5px; border-radius: 4px;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Favicon</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="site_favicon" name="site_favicon" value="{{ $settings['site_favicon'] ?? '' }}">
                                                <button class="btn btn-outline-secondary" type="button" id="lfm_favicon" data-input="site_favicon" data-preview="holder_favicon">Seç</button>
                                            </div>
                                            <div id="holder_favicon" class="mt-2" style="max-height:100px;">
                                                @if(isset($settings['site_favicon']))
                                                    <img src="{{ $settings['site_favicon'] }}" style="height: 3rem;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Contact Tab -->
                        <div class="tab-pane" id="contact" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Telefon</label>
                                    <input type="text" class="form-control" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Ünvan</label>
                                    <textarea class="form-control" name="contact_address" rows="3">{{ $settings['contact_address'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Xəritə (Google Maps Iframe)</label>
                                    <textarea class="form-control" name="contact_map" rows="3">{{ $settings['contact_map'] ?? '' }}</textarea>
                                </div>
                            </div>

                        </div>

                        <!-- Social Tab -->
                        <div class="tab-pane" id="social" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Linkedin</label>
                                    <input type="text" class="form-control" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Twitter (X)</label>
                                    <input type="text" class="form-control" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Youtube</label>
                                    <input type="text" class="form-control" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}">
                                </div>
                            </div>

                        </div>

                        <!-- SEO Tab -->
                        <div class="tab-pane" id="seo" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Meta Title (Default)</label>
                                    <input type="text" class="form-control" name="seo_meta_title" value="{{ $settings['seo_meta_title'] ?? '' }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Meta Description (Default)</label>
                                    <textarea class="form-control" name="seo_meta_description" rows="3">{{ $settings['seo_meta_description'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Meta Keywords (Default)</label>
                                    <input type="text" class="form-control" name="seo_meta_keywords" value="{{ $settings['seo_meta_keywords'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Alerts Tab -->
                        <div class="tab-pane" id="alerts" role="tabpanel">
                            <div class="alert alert-warning border-0 d-flex align-items-center mb-4">
                                <i class="ri-alarm-warning-fill fs-24 me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Biznes Kritik Hadisələr</h6>
                                    <span class="small">Sistem aşağıdakı limitlər keçildikdə avtomatik xəbərdarlıq göndərəcəkdir.</span>
                                </div>
                            </div>
                            @php
                                $canEditNotifications = auth()->user()?->hasRole('super-admin');
                                $notificationDisabled = $canEditNotifications ? '' : 'disabled';
                                $defaultNotificationRoute = [
                                    'channels' => ['database', 'mail'],
                                    'admins' => [],
                                    'roles' => ['super-admin'],
                                    'emails' => [],
                                ];
                            @endphp

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label fw-bold">Bildiriş Email-i</label>
                                    <input type="email" class="form-control" name="alert_notification_email" value="{{ $settings['alert_notification_email'] ?? '' }}" placeholder="ops@chalang.az">
                                </div>

                                <!-- Payment Drop -->
                                <div class="col-md-4 mb-4">
                                    <div class="glass-card p-3 h-100 border border-warning border-opacity-25">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="alert_payment_drop_active" name="alert_payment_drop_active" value="1" {{ isset($settings['alert_payment_drop_active']) && $settings['alert_payment_drop_active'] ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="alert_payment_drop_active">Gəlir Enişi (Payment Drop)</label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small text-muted">Aylıq Hədəfdən sapma (%)</label>
                                            <input type="number" class="form-control" name="alert_payment_drop_threshold" value="{{ $settings['alert_payment_drop_threshold'] ?? '30' }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Drop -->
                                <div class="col-md-4 mb-4">
                                    <div class="glass-card p-3 h-100 border border-info border-opacity-25">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="alert_order_drop_active" name="alert_order_drop_active" value="1" {{ isset($settings['alert_order_drop_active']) && $settings['alert_order_drop_active'] ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="alert_order_drop_active">Sifariş Azalması</label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small text-muted">Günlük Minimum Say</label>
                                            <input type="number" class="form-control" name="alert_order_drop_threshold" value="{{ $settings['alert_order_drop_threshold'] ?? '5' }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Spikes -->
                                <div class="col-md-4 mb-4">
                                    <div class="glass-card p-3 h-100 border border-danger border-opacity-25">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="alert_form_spike_active" name="alert_form_spike_active" value="1" {{ isset($settings['alert_form_spike_active']) && $settings['alert_form_spike_active'] ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="alert_form_spike_active">Form Xəta Sıçrayışı</label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small text-muted">Saatlıq Maksimum Xəta</label>
                                            <input type="number" class="form-control" name="alert_form_spike_threshold" value="{{ $settings['alert_form_spike_threshold'] ?? '10' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-routing-banner d-flex align-items-center mt-4 mb-4">
                                <i class="ri-mail-settings-line fs-24 me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Notification Routing</h6>
                                    <span class="small">Select channels, roles, admin recipients, and extra emails per event. Super-admin only.</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle notification-routing-table">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Channels</th>
                                            <th>Roles</th>
                                            <th>Admin Recipients</th>
                                            <th>Extra Emails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notificationEvents as $eventKey => $eventLabel)
                                            @php
                                                $route = $notificationRouting[$eventKey] ?? $defaultNotificationRoute;
                                                $routeChannels = $route['channels'] ?? [];
                                                $routeAdmins = $route['admins'] ?? [];
                                                $routeRoles = $route['roles'] ?? [];
                                                $routeEmails = isset($route['emails']) ? implode(', ', (array) $route['emails']) : '';
                                            @endphp
                                            <tr class="notification-routing-row">
                                                <td class="fw-semibold">{{ $eventLabel }}</td>
                                                <td>
                                                    <div class="routing-channels">
                                                        @foreach ($notificationChannels as $channelKey => $channelLabel)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="notification_routing[{{ $eventKey }}][channels][]"
                                                                    value="{{ $channelKey }}"
                                                                    {{ in_array($channelKey, $routeChannels, true) ? 'checked' : '' }}
                                                                    {{ $notificationDisabled }}>
                                                                <label class="form-check-label">{{ $channelLabel }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td style="min-width: 200px;">
                                                    <select class="form-select form-select-sm notification-routing-select" name="notification_routing[{{ $eventKey }}][roles][]" multiple size="3" {{ $notificationDisabled }}>
                                                        @forelse ($notificationRoles as $role)
                                                            <option value="{{ $role->name }}" {{ in_array($role->name, $routeRoles, true) ? 'selected' : '' }}>
                                                                {{ $role->name }}
                                                            </option>
                                                        @empty
                                                            <option value="" disabled>No roles</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td style="min-width: 260px;">
                                                    <select class="form-select form-select-sm notification-routing-select" name="notification_routing[{{ $eventKey }}][admins][]" multiple size="4" {{ $notificationDisabled }}>
                                                        @foreach ($notificationUsers as $user)
                                                            <option value="{{ $user->id }}" {{ in_array($user->id, $routeAdmins, true) ? 'selected' : '' }}>
                                                                {{ $user->full_name }} ({{ $user->email }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="min-width: 220px;">
                                                    <input type="text" class="form-control form-control-sm notification-routing-input"
                                                        name="notification_routing[{{ $eventKey }}][emails]"
                                                        value="{{ $routeEmails }}"
                                                        placeholder="ops@chalang.az, sales@chalang.az"
                                                        {{ $notificationDisabled }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                        <!-- BRANDING TAB (Super Admin) -->
                        @role('super-admin')
                        <div class="tab-pane" id="branding" role="tabpanel">
                            <div class="alert alert-info border-0 d-flex align-items-center mb-4">
                                <i class="ri-palette-line fs-24 me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ __('admin.theme_settings') }}</h6>
                                    <span class="small">{{ __('admin.theme_description') }}</span>
                                </div>
                            </div>
                            
                            <h5 class="mb-3 text-primary border-bottom pb-2"><i class="ri-brush-line me-1"></i> {{ __('admin.color_style') }}</h5>
                            <div class="row mb-4">
                                <!-- LIGHT MODE -->
                                <div class="col-md-3 mb-3">
                                    <div class="glass-card h-100 p-3 bg-light border">
                                        <h6 class="text-uppercase text-muted fs-11 fw-bold mb-3">{{ __('admin.light_mode') }}</h6>
                                        <div class="mb-3">
                                            <label class="form-label small">{{ __('admin.primary_color') }}</label>
                                            <div class="input-group input-group-sm">
                                                <input type="color" class="form-control form-control-color" id="pLightColor" name="theme_color_primary_light" value="{{ $settings['theme_color_primary_light'] ?? '#4b0082' }}" title="{{ __('admin.primary_color') }}">
                                                <input type="text" class="form-control" id="pLightText" value="{{ $settings['theme_color_primary_light'] ?? '#4b0082' }}" oninput="document.getElementById('pLightColor').value = this.value">
                                                <button type="button" class="btn btn-outline-secondary" onclick="resetColor('pLight', '#4b0082')"><i class="ri-refresh-line"></i></button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="form-label small">{{ __('admin.secondary_color') }}</label>
                                            <div class="input-group input-group-sm">
                                                <input type="color" class="form-control form-control-color" id="sLightColor" name="theme_color_secondary_light" value="{{ $settings['theme_color_secondary_light'] ?? '#d500f9' }}" title="{{ __('admin.secondary_color') }}">
                                                <input type="text" class="form-control" id="sLightText" value="{{ $settings['theme_color_secondary_light'] ?? '#d500f9' }}" oninput="document.getElementById('sLightColor').value = this.value">
                                                <button type="button" class="btn btn-outline-secondary" onclick="resetColor('sLight', '#d500f9')"><i class="ri-refresh-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DARK MODE -->
                                <div class="col-md-3 mb-3">
                                    <div class="glass-card h-100 p-3 bg-dark border border-secondary">
                                        <h6 class="text-uppercase text-muted fs-11 fw-bold mb-3 text-white-50">{{ __('admin.dark_mode') }}</h6>
                                        <div class="mb-3">
                                            <label class="form-label small text-white-50">{{ __('admin.primary_color') }}</label>
                                            <div class="input-group input-group-sm">
                                                <input type="color" class="form-control form-control-color" id="pDarkColor" name="theme_color_primary_dark" value="{{ $settings['theme_color_primary_dark'] ?? '#7c3aed' }}" title="{{ __('admin.primary_color') }}">
                                                <input type="text" class="form-control bg-dark text-white border-secondary" id="pDarkText" value="{{ $settings['theme_color_primary_dark'] ?? '#7c3aed' }}" oninput="document.getElementById('pDarkColor').value = this.value">
                                                <button type="button" class="btn btn-outline-secondary" onclick="resetColor('pDark', '#7c3aed')"><i class="ri-refresh-line"></i></button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="form-label small text-white-50">{{ __('admin.secondary_color') }}</label>
                                            <div class="input-group input-group-sm">
                                                <input type="color" class="form-control form-control-color" id="sDarkColor" name="theme_color_secondary_dark" value="{{ $settings['theme_color_secondary_dark'] ?? '#c026d3' }}" title="{{ __('admin.secondary_color') }}">
                                                <input type="text" class="form-control bg-dark text-white border-secondary" id="sDarkText" value="{{ $settings['theme_color_secondary_dark'] ?? '#c026d3' }}" oninput="document.getElementById('sDarkColor').value = this.value">
                                                <button type="button" class="btn btn-outline-secondary" onclick="resetColor('sDark', '#c026d3')"><i class="ri-refresh-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- AMBIENT / TERTIARY -->
                                <div class="col-md-3 mb-3">
                                    <div class="glass-card h-100 p-3 border border-info border-opacity-25">
                                        <h6 class="text-uppercase text-muted fs-11 fw-bold mb-3" style="color: #00d2ff !important;">🌊 Ambient Glow (3-cü Rəng)</h6>
                                        <p class="small text-muted mb-3">Footer, Hero arxa fon parıltısı. Bənövşəyi + Mavi qarışımı ən yaxşı ambiyans yaradır.</p>
                                        <div class="mb-3">
                                            <label class="form-label small">Light Mode</label>
                                            <div class="input-group input-group-sm">
                                                <input type="color" class="form-control form-control-color" id="tLightColor" name="theme_color_tertiary_light" value="{{ $settings['theme_color_tertiary_light'] ?? '#00d2ff' }}" title="Tertiary Light">
                                                <input type="text" class="form-control" id="tLightText" value="{{ $settings['theme_color_tertiary_light'] ?? '#00d2ff' }}" oninput="document.getElementById('tLightColor').value = this.value">
                                                <button type="button" class="btn btn-outline-secondary" onclick="resetColor('tLight', '#00d2ff')"><i class="ri-refresh-line"></i></button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="form-label small">Dark Mode</label>
                                            <div class="input-group input-group-sm">
                                                <input type="color" class="form-control form-control-color" id="tDarkColor" name="theme_color_tertiary_dark" value="{{ $settings['theme_color_tertiary_dark'] ?? '#0052ff' }}" title="Tertiary Dark">
                                                <input type="text" class="form-control" id="tDarkText" value="{{ $settings['theme_color_tertiary_dark'] ?? '#0052ff' }}" oninput="document.getElementById('tDarkColor').value = this.value">
                                                <button type="button" class="btn btn-outline-secondary" onclick="resetColor('tDark', '#0052ff')"><i class="ri-refresh-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TEXT & SHAPE -->
                                <div class="col-md-6 mb-3">
                                    <div class="glass-card h-100 p-3 border">
                                        <h6 class="text-uppercase text-muted fs-11 fw-bold mb-3">{{ __('admin.typography_shape') }}</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('admin.font_family') }}</label>
                                                <select class="form-select text-capitalize" name="theme_font_family">
                                                    <option value="Outfit" {{ ($settings['theme_font_family'] ?? 'Outfit') == 'Outfit' ? 'selected' : '' }}>Outfit ({{ __('admin.fonts.modern') }})</option>
                                                    <option value="Inter" {{ ($settings['theme_font_family'] ?? '') == 'Inter' ? 'selected' : '' }}>Inter ({{ __('admin.fonts.pro') }})</option>
                                                    <option value="Roboto" {{ ($settings['theme_font_family'] ?? '') == 'Roboto' ? 'selected' : '' }}>Roboto ({{ __('admin.fonts.std') }})</option>
                                                    <option value="Playfair Display" {{ ($settings['theme_font_family'] ?? '') == 'Playfair Display' ? 'selected' : '' }}>Playfair Display ({{ __('admin.fonts.classic') }})</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('admin.border_radius') }}</label>
                                                <select class="form-select" name="theme_border_radius">
                                                    <option value="rounded" {{ ($settings['theme_border_radius'] ?? 'rounded') == 'rounded' ? 'selected' : '' }}>{{ __('admin.shapes.soft') }}</option>
                                                    <option value="square" {{ ($settings['theme_border_radius'] ?? '') == 'square' ? 'selected' : '' }}>{{ __('admin.shapes.sharp') }}</option>
                                                    <option value="pill" {{ ($settings['theme_border_radius'] ?? '') == 'pill' ? 'selected' : '' }}>{{ __('admin.shapes.round') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch mt-2">
                                                    <input class="form-check-input" type="checkbox" id="theme_smart_bg" name="theme_smart_bg" value="1" {{ isset($settings['theme_smart_bg']) && $settings['theme_smart_bg'] ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="theme_smart_bg">{{ __('admin.smart_bg') }}</label>
                                                </div>
                                                <div class="form-text small">{{ __('admin.smart_bg_desc') }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">{{ __('admin.glow_intensity') }}</label>
                                                <input type="range" class="form-range" min="0" max="50" step="5" name="theme_glow_intensity" value="{{ $settings['theme_glow_intensity'] ?? '15' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3 text-primary border-bottom pb-2 mt-4"><i class="ri-layout-masonry-line me-1"></i> {{ __('admin.section_control') }}</h5>
                            <div class="row mb-4">
                                @php
                                    $sections = [
                                        'section_partners' => __('admin.sections.partners'),
                                        'section_metrics' => __('admin.sections.metrics'),
                                        'section_process' => __('admin.sections.process'),
                                        'section_services' => __('admin.sections.services'),
                                        'section_tech_stack' => __('admin.sections.tech_stack'),
                                        'section_cta' => __('admin.sections.cta'),
                                        'section_lead_magnet' => __('admin.sections.lead_magnet'),
                                        'section_estimator' => __('admin.sections.estimator')
                                    ];
                                @endphp
                                @foreach($sections as $key => $label)
                                    <div class="col-md-3 mb-3">
                                        <div class="glass-card p-2 border d-flex align-items-center">
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="{{ $key }}" name="{{ $key }}" value="1" {{ !isset($settings[$key]) || $settings[$key] ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2" for="{{ $key }}">{{ $label }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <h5 class="mb-3 text-primary border-bottom pb-2 mt-4"><i class="ri-code-s-slash-line me-1"></i> {{ __('admin.advanced') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('admin.custom_css') }}</label>
                                    <textarea class="form-control font-monospace small" name="theme_custom_css" rows="5" placeholder=".my-class { color: red !important; }">{{ $settings['theme_custom_css'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('admin.custom_js') }}</label>
                                    <textarea class="form-control font-monospace small" name="theme_custom_js" rows="5" placeholder="<script>console.log('Hello');</script>">{{ $settings['theme_custom_js'] ?? '' }}</textarea>
                                </div>
                            </div>
                            
                            <script>
                                function resetColor(prefix, defaultHex) {
                                    document.getElementById(prefix + 'Color').value = defaultHex;
                                    document.getElementById(prefix + 'Text').value = defaultHex;
                                }
                                document.querySelectorAll('input[type=color]').forEach(function(picker) {
                                    picker.addEventListener('input', function() {
                                        let textInput = document.getElementById(this.id.replace('Color', 'Text'));
                                        if(textInput) textInput.value = this.value;
                                    });
                                });
                            </script>

                        </div>
                        @endrole

                        @role('super-admin')
                        {{-- ═══════════════════════════════════════════════════ --}}
                        {{-- 🎨 INTERACTIVE MULTI-STOP GRADIENT STUDIO (ILLUSTRATOR PRO) --}}
                        {{-- ═══════════════════════════════════════════════════ --}}
                        <div class="tab-pane fade" id="gradient-studio" role="tabpanel">
                            <h5 class="mb-1 fw-bold" style="background:linear-gradient(135deg,#7c3aed,#c026d3);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">🎨 Brand Gradient Studio Pro</h5>
                            <p class="text-muted small mb-4">Adobe Illustrator təcrübəsi ilə brend qradientinizi yaradın. Bara klikləyərək yeni stop əlavə edin, stopları sürüşdürün, şəffaflığı (opacity) və rəngi tam idarə edin.</p>

                            <!-- Hidden inputs to store calculated gradient CSS and raw JSON stops -->
                            <input type="hidden" name="gradient_brand_css" id="gradient_brand_css" value="{{ $settings['gradient_brand_css'] ?? '' }}">
                            <input type="hidden" name="gradient_stops_json" id="gradient_stops_json" value="{{ $settings['gradient_stops_json'] ?? '' }}">

                            <style>
                                /* Gradient Studio Custom Styling */
                                .gs-editor-container {
                                    background: rgba(15, 23, 42, 0.3);
                                    border: 1px solid rgba(255, 255, 255, 0.05);
                                    border-radius: 16px;
                                    padding: 24px;
                                }
                                .gradient-slider-wrapper {
                                    position: relative;
                                    margin: 40px 10px 45px 10px;
                                }
                                .gradient-bar-container {
                                    position: relative;
                                    height: 38px;
                                    border-radius: 10px;
                                    cursor: copy;
                                    box-shadow: inset 0 2px 8px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.08);
                                    background-image: linear-gradient(45deg, #222 25%, transparent 25%), 
                                                      linear-gradient(-45deg, #222 25%, transparent 25%), 
                                                      linear-gradient(45deg, transparent 75%, #222 75%), 
                                                      linear-gradient(-45deg, transparent 75%, #222 75%);
                                    background-size: 16px 16px;
                                    background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
                                    background-color: #111;
                                }
                                .gradient-bar-fill {
                                    width: 100%;
                                    height: 100%;
                                    border-radius: 10px;
                                }
                                .gradient-markers-container {
                                    position: absolute;
                                    top: 100%;
                                    left: 0;
                                    right: 0;
                                    height: 25px;
                                }
                                .gradient-marker {
                                    position: absolute;
                                    top: 8px;
                                    width: 22px;
                                    height: 22px;
                                    background: #1e293b;
                                    border: 3px solid #f8fafc;
                                    border-radius: 50% 50% 50% 0;
                                    transform: translate(-50%, 0) rotate(-45deg);
                                    cursor: ew-resize;
                                    box-shadow: 0 4px 10px rgba(0,0,0,0.6), inset 0 1px 3px rgba(255,255,255,0.2);
                                    transition: border-color 0.25s, transform 0.15s, box-shadow 0.25s;
                                    z-index: 10;
                                }
                                .gradient-marker:hover {
                                    transform: translate(-50%, -2px) rotate(-45deg) scale(1.1);
                                    border-color: #d500f9;
                                }
                                .gradient-marker.active {
                                    border-color: #d500f9;
                                    background: #0f172a;
                                    transform: translate(-50%, -4px) rotate(-45deg) scale(1.2);
                                    box-shadow: 0 0 15px #d500f9, 0 6px 15px rgba(0,0,0,0.8);
                                    z-index: 12;
                                }
                                .gradient-marker-color {
                                    width: 100%;
                                    height: 100%;
                                    border-radius: 50%;
                                    transform: rotate(45deg);
                                    border: 1px solid rgba(255,255,255,0.15);
                                    box-shadow: inset 0 1px 2px rgba(255,255,255,0.3);
                                }
                                .gradient-marker-tooltip {
                                    position: absolute;
                                    bottom: 100%;
                                    left: 50%;
                                    transform: translate(-50%, -8px) rotate(45deg);
                                    background: #0f172a;
                                    color: #fff;
                                    font-size: 10px;
                                    font-weight: 700;
                                    padding: 2px 6px;
                                    border-radius: 4px;
                                    white-space: nowrap;
                                    pointer-events: none;
                                    opacity: 0;
                                    transition: opacity 0.2s;
                                    border: 1px solid rgba(255,255,255,0.1);
                                }
                                .gradient-marker:hover .gradient-marker-tooltip,
                                .gradient-marker.active .gradient-marker-tooltip {
                                    opacity: 1;
                                }
                                .selected-stop-controls {
                                    background: rgba(30, 41, 59, 0.4);
                                    backdrop-filter: blur(10px);
                                    border: 1px solid rgba(255, 255, 255, 0.08);
                                    border-radius: 12px;
                                    transition: all 0.3s ease;
                                }
                                .angle-compass {
                                    width: 70px;
                                    height: 70px;
                                    border-radius: 50%;
                                    background: rgba(255,255,255,0.03);
                                    border: 2px solid rgba(255,255,255,0.1);
                                    position: relative;
                                    cursor: pointer;
                                    transition: border-color 0.3s;
                                }
                                .angle-compass:hover {
                                    border-color: rgba(213,0,249,0.5);
                                }
                                .angle-needle {
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    width: 3px;
                                    height: 26px;
                                    border-radius: 2px;
                                    background: linear-gradient(to top, #d500f9, #7c3aed);
                                    transform-origin: bottom center;
                                    transform: translate(-50%, -100%) rotate(135deg);
                                    pointer-events: none;
                                    box-shadow: 0 0 8px rgba(213,0,249,0.6);
                                }
                            </style>

                            <div class="row g-4">
                                {{-- Sol Tərəf: Redaktor İdarəetmələri --}}
                                <div class="col-lg-7">
                                    <div class="gs-editor-container">
                                        
                                        <!-- Gradient Settings (Type & Angle) -->
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-6">
                                                <label class="form-label fw-bold mb-2 text-white">⟳ Gradient Tipi</label>
                                                <select id="gs_type" name="gradient_type" class="form-select border-secondary bg-dark text-white" onchange="gsUpdate()">
                                                    <option value="linear" {{ ($settings['gradient_type'] ?? 'linear') == 'linear' ? 'selected' : '' }}>Linear (Xətti)</option>
                                                    <option value="radial" {{ ($settings['gradient_type'] ?? '') == 'radial' ? 'selected' : '' }}>Radial (Dairəvi)</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold mb-2 text-white">⟳ Gradient Açısı</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <input type="range" id="gs_angle" name="gradient_angle" min="0" max="360" step="5"
                                                        value="{{ $settings['gradient_angle'] ?? 135 }}" class="form-range flex-grow-1" oninput="gsUpdate()">
                                                    <span id="gs_angle_val" class="fw-bold text-primary" style="min-width:48px;text-align:right">{{ $settings['gradient_angle'] ?? 135 }}°</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- INTERACTIVE SLIDER BAR -->
                                        <div class="gradient-slider-wrapper">
                                            <div class="gradient-bar-container" id="gradient_bar_container">
                                                <div class="gradient-bar-fill" id="gradient_bar_fill"></div>
                                                <div class="gradient-markers-container" id="gradient_markers_container">
                                                    <!-- Markers dynamically injected by JS -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- QUICK TOOLS -->
                                        <div class="row g-2 mb-4">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-sm btn-outline-secondary w-100 py-2" onclick="distributeStops()">
                                                    <i class="ri-space-share-line me-1"></i> Payla
                                                </button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-sm btn-outline-secondary w-100 py-2" onclick="reverseStops()">
                                                    <i class="ri-swap-box-line me-1"></i> Tərs Çevir
                                                </button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-sm btn-outline-warning w-100 py-2" onclick="resetToBrandDefault()">
                                                    <i class="ri-refresh-line me-1"></i> Sıfırla
                                                </button>
                                            </div>
                                        </div>

                                        <!-- ACTIVE STOP CONTROLS -->
                                        <div class="selected-stop-controls p-3" id="stop_controls_panel" style="display:none;">
                                            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2 border-secondary border-opacity-25">
                                                <h6 class="fw-bold mb-0 text-white"><i class="ri-paint-brush-line text-secondary me-1"></i> Seçilmiş Stop: <span class="text-secondary" id="active_stop_num">#1</span></h6>
                                                <button type="button" class="btn btn-xs btn-danger px-2 py-1" id="btn_delete_stop" onclick="deleteSelectedStop()">
                                                    <i class="ri-delete-bin-6-line me-1"></i> Sil
                                                </button>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label small text-white-50">Rəng</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="color" class="form-control form-control-color w-100 border-secondary bg-dark" id="stop_color" oninput="updateSelectedStop()">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label class="form-label small text-white-50 mb-1">Şəffaflıq</label>
                                                        <span class="badge bg-secondary" id="stop_opacity_val">100%</span>
                                                    </div>
                                                    <input type="range" class="form-range" id="stop_opacity" min="0" max="100" step="1" oninput="updateSelectedStop()">
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label class="form-label small text-white-50 mb-1">Mövqe</label>
                                                        <span class="badge bg-primary" id="stop_position_val">50%</span>
                                                    </div>
                                                    <input type="range" class="form-range" id="stop_position" min="0" max="100" step="1" oninput="updateSelectedStop()">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ambient intensity -->
                                        <div class="glass-card p-3 border mt-4">
                                            <h6 class="fw-bold mb-1 text-white">✦ Arxa Fon Parıltısı (Ambient Intensity)</h6>
                                            <p class="text-muted small mb-3">Hero, bölmələr və footer arxa fon parıltısının parıltı gücü</p>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="range" id="gs_ambient" name="gradient_ambient_intensity" min="0" max="100" step="5"
                                                    value="{{ $settings['gradient_ambient_intensity'] ?? 60 }}" class="form-range flex-grow-1" oninput="gsUpdate()">
                                                <span id="gs_ambient_val" class="fw-bold text-primary" style="min-width:48px;text-align:right">{{ $settings['gradient_ambient_intensity'] ?? 60 }}%</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- Sağ Tərəf: Canlı Preview --}}
                                <div class="col-lg-5">
                                    <div class="sticky-top" style="top:80px">
                                        <h6 class="fw-bold mb-2 text-white">👁 Canlı Preview</h6>
                                        <div id="gs_preview_box" style="background:#0b0f19;border-radius:16px;padding:28px;min-height:400px;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.08);">
                                            <!-- Ambient Glow Circles -->
                                            <div id="pv_s1" style="position:absolute;top:-50px;left:-50px;width:240px;height:240px;border-radius:50%;filter:blur(70px);opacity:.5;pointer-events:none;transition:opacity .4s;"></div>
                                            <div id="pv_s2" style="position:absolute;bottom:-40px;right:-20px;width:200px;height:200px;border-radius:50%;filter:blur(60px);opacity:.4;pointer-events:none;transition:opacity .4s;"></div>
                                            
                                            <div style="position:relative;z-index:2;">
                                                <h3 id="pv_title" style="font-size:1.7rem;font-weight:800;margin-bottom:4px;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Chalang</h3>
                                                <p style="color:rgba(255,255,255,.45);font-size:.83rem;margin-bottom:20px;">Qlobal İnnovasiya & Süni Zəka</p>
                                                
                                                <div class="d-flex gap-2 flex-wrap mb-4">
                                                    <button id="pv_btn1" style="color:#fff;border:none;padding:10px 22px;border-radius:12px;font-weight:600;font-size:.88rem;box-shadow:0 4px 20px rgba(124,58,237,.35);transition:all .3s;">Başla →</button>
                                                    <button id="pv_btn2" style="background:transparent;color:#fff;border:2px solid rgba(124,58,237,.5);padding:9px 20px;border-radius:12px;font-weight:600;font-size:.88rem;transition:all .3s;">İşlərimiz</button>
                                                </div>
                                                
                                                <div style="margin-bottom:16px;">
                                                    <div style="color:rgba(255,255,255,.35);font-size:.73rem;margin-bottom:5px;">Ambient Gücü</div>
                                                    <div style="height:5px;border-radius:4px;background:rgba(255,255,255,.08);">
                                                        <div id="pv_amb_bar" style="height:100%;border-radius:4px;width:60%;transition:width .3s;"></div>
                                                    </div>
                                                </div>
                                                
                                                <div style="display:flex;align-items:center;gap:14px;">
                                                    <div id="pv_compass" class="angle-compass" onclick="compassClick(event)">
                                                        <div id="pv_needle" class="angle-needle"></div>
                                                    </div>
                                                    <div>
                                                        <div style="color:rgba(255,255,255,.35);font-size:.72rem;">Açı</div>
                                                        <div id="pv_angle_lbl" style="color:#fff;font-weight:700;font-size:1.1rem;">135°</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-muted mt-2" style="font-size:.75rem;"><i class="ri-information-line me-1"></i>Dəyişikliklər yalnız "Yadda Saxla" basıldıqdan sonra sayta tətbiq olunur.</p>
                                    </div>
                                </div>
                            </div>

                            <script>
                            // Default Brand Stops (Purple/Violet/Bright Pink)
                            var defaultStops = [
                                {color: "#7c3aed", position: 0, opacity: 100},
                                {color: "#8b00ff", position: 50, opacity: 100},
                                {color: "#c026d3", position: 100, opacity: 100}
                            ];

                            var stops = [];
                            var activeStopIndex = null;
                            var isDragging = false;

                            // Parse raw stops from db or fallback
                            try {
                                var rawStops = document.getElementById('gradient_stops_json').value;
                                if(rawStops && rawStops.trim() !== '') {
                                    stops = JSON.parse(rawStops);
                                    // Ensure structure is correct
                                    stops = stops.map(s => {
                                        return {
                                            color: s.color || "#ffffff",
                                            position: typeof s.position === 'number' ? s.position : 0,
                                            opacity: typeof s.opacity === 'number' ? s.opacity : 100
                                        };
                                    });
                                } else {
                                    stops = JSON.parse(JSON.stringify(defaultStops));
                                }
                            } catch(e) {
                                console.error("Error parsing gradient stops", e);
                                stops = JSON.parse(JSON.stringify(defaultStops));
                            }

                            // Hex to RGBA convertor for CSS outputs
                            function hexToRgba(hex, opacityPercent) {
                                hex = hex.replace('#', '');
                                var r, g, b;
                                if(hex.length === 3) {
                                    r = parseInt(hex.substring(0,1) + hex.substring(0,1), 16);
                                    g = parseInt(hex.substring(1,2) + hex.substring(1,2), 16);
                                    b = parseInt(hex.substring(2,3) + hex.substring(2,3), 16);
                                } else {
                                    r = parseInt(hex.substring(0,2), 16);
                                    g = parseInt(hex.substring(2,4), 16);
                                    b = parseInt(hex.substring(4,6), 16);
                                }
                                var alpha = (opacityPercent / 100).toFixed(2);
                                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                            }

                            // Dynamic Style Compiler
                            function compileGradientString(stopsArr, type, angle) {
                                // Sort stops by position ascending
                                stopsArr.sort((a,b) => a.position - b.position);
                                
                                var stopsCss = stopsArr.map(s => {
                                    return `${hexToRgba(s.color, s.opacity)} ${s.position}%`;
                                }).join(', ');

                                if(type === 'radial') {
                                    return `radial-gradient(circle, ${stopsCss})`;
                                } else {
                                    return `linear-gradient(${angle}deg, ${stopsCss})`;
                                }
                            }

                            // Render markers on visual bar
                            function renderStops() {
                                var container = document.getElementById('gradient_markers_container');
                                container.innerHTML = '';

                                stops.forEach((stop, index) => {
                                    var marker = document.createElement('div');
                                    marker.className = 'gradient-marker';
                                    if(index === activeStopIndex) marker.classList.add('active');
                                    marker.style.left = stop.position + '%';

                                    var colorFill = document.createElement('div');
                                    colorFill.className = 'gradient-marker-color';
                                    colorFill.style.backgroundColor = stop.color;
                                    colorFill.style.opacity = stop.opacity / 100;
                                    marker.appendChild(colorFill);

                                    // Add small tooltip showing percentage
                                    var tooltip = document.createElement('div');
                                    tooltip.className = 'gradient-marker-tooltip';
                                    tooltip.textContent = stop.position + '%';
                                    marker.appendChild(tooltip);

                                    // Drag & Select Events
                                    marker.addEventListener('mousedown', function(e) {
                                        e.stopPropagation();
                                        selectStop(index);
                                        startDrag(index, e);
                                    });

                                    // Touch Support for mobile preview
                                    marker.addEventListener('touchstart', function(e) {
                                        e.stopPropagation();
                                        selectStop(index);
                                        startDrag(index, e.touches[0]);
                                    });

                                    container.appendChild(marker);
                                });

                                updateSelectedStopPanel();
                            }

                            function selectStop(index) {
                                activeStopIndex = index;
                                renderStops();
                            }

                            function updateSelectedStopPanel() {
                                var panel = document.getElementById('stop_controls_panel');
                                if(activeStopIndex === null || activeStopIndex >= stops.length) {
                                    panel.style.display = 'none';
                                    return;
                                }

                                panel.style.display = 'block';
                                var stop = stops[activeStopIndex];
                                
                                document.getElementById('active_stop_num').textContent = '#' + (activeStopIndex + 1);
                                document.getElementById('stop_color').value = stop.color;
                                
                                document.getElementById('stop_opacity').value = stop.opacity;
                                document.getElementById('stop_opacity_val').textContent = stop.opacity + '%';
                                
                                document.getElementById('stop_position').value = stop.position;
                                document.getElementById('stop_position_val').textContent = stop.position + '%';

                                // Distribute delete button status (must have at least 2 stops)
                                document.getElementById('btn_delete_stop').disabled = stops.length <= 2;
                            }

                            function updateSelectedStop() {
                                if(activeStopIndex === null) return;

                                var color = document.getElementById('stop_color').value;
                                var opacity = parseInt(document.getElementById('stop_opacity').value);
                                var position = parseInt(document.getElementById('stop_position').value);

                                stops[activeStopIndex].color = color;
                                stops[activeStopIndex].opacity = opacity;
                                stops[activeStopIndex].position = position;

                                document.getElementById('stop_opacity_val').textContent = opacity + '%';
                                document.getElementById('stop_position_val').textContent = position + '%';

                                // Dynamically update marker visualization without full re-render for performance
                                var markers = document.getElementById('gradient_markers_container').children;
                                if(markers[activeStopIndex]) {
                                    markers[activeStopIndex].style.left = position + '%';
                                    var inner = markers[activeStopIndex].querySelector('.gradient-marker-color');
                                    inner.style.backgroundColor = color;
                                    inner.style.opacity = opacity / 100;
                                    var tooltip = markers[activeStopIndex].querySelector('.gradient-marker-tooltip');
                                    tooltip.textContent = position + '%';
                                }

                                gsUpdate();
                            }

                            function deleteSelectedStop() {
                                if(stops.length <= 2 || activeStopIndex === null) return;
                                
                                stops.splice(activeStopIndex, 1);
                                activeStopIndex = null;
                                renderStops();
                                gsUpdate();
                            }

                            // Dragging logic
                            function startDrag(index, e) {
                                isDragging = true;
                                var container = document.getElementById('gradient_bar_container');
                                var rect = container.getBoundingClientRect();

                                function onMouseMove(moveEvent) {
                                    if (!isDragging) return;
                                    var clientX = moveEvent.clientX || (moveEvent.touches && moveEvent.touches[0].clientX);
                                    if(clientX === undefined) return;
                                    
                                    var x = clientX - rect.left;
                                    var percentage = Math.round((x / rect.width) * 100);
                                    
                                    // Limit 0 to 100
                                    percentage = Math.max(0, Math.min(100, percentage));
                                    
                                    stops[index].position = percentage;
                                    
                                    // Live update panel and marker position
                                    document.getElementById('stop_position').value = percentage;
                                    document.getElementById('stop_position_val').textContent = percentage + '%';
                                    
                                    var markers = document.getElementById('gradient_markers_container').children;
                                    if(markers[index]) {
                                        markers[index].style.left = percentage + '%';
                                        markers[index].querySelector('.gradient-marker-tooltip').textContent = percentage + '%';
                                    }
                                    
                                    gsUpdate();
                                }

                                function onMouseUp() {
                                    isDragging = false;
                                    window.removeEventListener('mousemove', onMouseMove);
                                    window.removeEventListener('mouseup', onMouseUp);
                                    window.removeEventListener('touchmove', onMouseMove);
                                    window.removeEventListener('touchend', onMouseUp);
                                    
                                    // Sort and re-render stops on release
                                    stops.sort((a,b) => a.position - b.position);
                                    // Find new index of dragged stop
                                    activeStopIndex = stops.findIndex(s => s.position === stops[index].position && s.color === stops[index].color);
                                    renderStops();
                                }

                                window.addEventListener('mousemove', onMouseMove);
                                window.addEventListener('mouseup', onMouseUp);
                                window.addEventListener('touchmove', onMouseMove, { passive: false });
                                window.addEventListener('touchend', onMouseUp);
                            }

                            // Click on bar container to add new stop
                            document.getElementById('gradient_bar_container').addEventListener('mousedown', function(e) {
                                if (e.target.classList.contains('gradient-marker') || e.target.closest('.gradient-marker')) return;
                                
                                var rect = this.getBoundingClientRect();
                                var x = e.clientX - rect.left;
                                var percentage = Math.round((x / rect.width) * 100);
                                percentage = Math.max(0, Math.min(100, percentage));

                                // Interpolate color at clicked point or copy nearest
                                var copiedColor = "#8b00ff";
                                if(stops.length > 0) {
                                    stops.sort((a,b) => a.position - b.position);
                                    var rightStop = stops.find(s => s.position >= percentage);
                                    var leftStop = [...stops].reverse().find(s => s.position <= percentage);
                                    if(rightStop && leftStop) {
                                        copiedColor = rightStop.color; // simpler approximation
                                    } else if(rightStop) {
                                        copiedColor = rightStop.color;
                                    } else if(leftStop) {
                                        copiedColor = leftStop.color;
                                    }
                                }

                                var newStop = {
                                    color: copiedColor,
                                    position: percentage,
                                    opacity: 100
                                };

                                stops.push(newStop);
                                stops.sort((a,b) => a.position - b.position);
                                activeStopIndex = stops.indexOf(newStop);
                                
                                renderStops();
                                gsUpdate();
                            });

                            // Quick Actions / Illustrator Tools
                            function distributeStops() {
                                if(stops.length < 2) return;
                                stops.sort((a,b) => a.position - b.position);
                                
                                stops[0].position = 0;
                                stops[stops.length - 1].position = 100;
                                
                                var step = 100 / (stops.length - 1);
                                for(var i = 1; i < stops.length - 1; i++) {
                                    stops[i].position = Math.round(i * step);
                                }
                                
                                selectStop(activeStopIndex !== null ? activeStopIndex : 0);
                                gsUpdate();
                            }

                            function reverseStops() {
                                stops.reverse();
                                // Recalculate mirror positions
                                stops.forEach(s => {
                                    s.position = 100 - s.position;
                                });
                                stops.sort((a,b) => a.position - b.position);
                                selectStop(activeStopIndex !== null ? activeStopIndex : 0);
                                gsUpdate();
                            }

                            function resetToBrandDefault() {
                                if(confirm("Bütün qradient stoplarını sıfırlayıb default brend rənglərinə qaytarmaq istəyirsiniz?")) {
                                    stops = JSON.parse(JSON.stringify(defaultStops));
                                    activeStopIndex = 0;
                                    renderStops();
                                    gsUpdate();
                                }
                            }

                            // Compass/Angle Wheel drag to update angle
                            function compassClick(e) {
                                var compass = document.getElementById('pv_compass');
                                var rect = compass.getBoundingClientRect();
                                var centerX = rect.left + rect.width / 2;
                                var centerY = rect.top + rect.height / 2;
                                
                                function updateAngleFromEvent(moveEvent) {
                                    var clientX = moveEvent.clientX || (moveEvent.touches && moveEvent.touches[0].clientX);
                                    var clientY = moveEvent.clientY || (moveEvent.touches && moveEvent.touches[0].clientY);
                                    
                                    var dx = clientX - centerX;
                                    var dy = clientY - centerY;
                                    
                                    // Math.atan2 returns angle in radians, convert to degrees
                                    var angleRad = Math.atan2(dy, dx);
                                    var angleDeg = Math.round(angleRad * (180 / Math.PI));
                                    
                                    // Normalize to 0-360 starting from top/right depending on layout (adding 90 to match standard css gradient top as 0 deg)
                                    angleDeg = (angleDeg + 90 + 360) % 360;
                                    
                                    document.getElementById('gs_angle').value = angleDeg;
                                    gsUpdate();
                                }

                                function endCompassDrag() {
                                    window.removeEventListener('mousemove', updateAngleFromEvent);
                                    window.removeEventListener('mouseup', endCompassDrag);
                                }

                                window.addEventListener('mousemove', updateAngleFromEvent);
                                window.addEventListener('mouseup', endCompassDrag);
                                updateAngleFromEvent(e);
                            }

                            // Core Update loop
                            function gsUpdate() {
                                var angle = parseInt(document.getElementById('gs_angle').value);
                                var ambient = parseInt(document.getElementById('gs_ambient').value);
                                var type = document.getElementById('gs_type').value;

                                // Labels
                                document.getElementById('gs_angle_val').textContent  = angle + '°';
                                document.getElementById('gs_ambient_val').textContent = ambient + '%';
                                document.getElementById('pv_angle_lbl').textContent  = angle + '°';

                                // Compile stops and save to hidden inputs
                                stops.sort((a,b) => a.position - b.position);
                                var stopsJson = JSON.stringify(stops);
                                var gradCss = compileGradientString(stops, type, angle);

                                document.getElementById('gradient_stops_json').value = stopsJson;
                                document.getElementById('gradient_brand_css').value = gradCss;

                                // Update Editor visual bar
                                // The editor bar always shows linear horizontal gradient (0 or 90 deg) for clean stop alignment
                                var editorGrad = compileGradientString(stops, 'linear', 90);
                                document.getElementById('gradient_bar_fill').style.background = editorGrad;

                                // Sağdakı Canlı Preview yeniləmələri
                                var bs = stops[0] ? stops[0].color : "#7c3aed";
                                var be = stops[stops.length - 1] ? stops[stops.length - 1].color : "#c026d3";

                                // Dynamic CSS Custom Variable update to live preview element
                                var previewBox = document.getElementById('gs_preview_box');
                                previewBox.style.setProperty('--brand-gradient', gradCss);

                                // Button gradient
                                document.getElementById('pv_btn1').style.background = gradCss;
                                document.getElementById('pv_btn1').style.boxShadow  = '0 4px 20px ' + bs + '55';
                                document.getElementById('pv_btn2').style.borderColor = bs + '88';

                                // Text gradient
                                var t = document.getElementById('pv_title');
                                t.style.backgroundImage = gradCss;
                                t.style.backgroundClip = 'text';
                                t.style.webkitBackgroundClip = 'text';

                                // Ambient bar
                                document.getElementById('pv_amb_bar').style.width = ambient + '%';
                                document.getElementById('pv_amb_bar').style.background = gradCss;

                                // Compass needle rotation (subtracting 90 because CSS vertical line is 0, needle top is 0)
                                document.getElementById('pv_needle').style.transform = 'translate(-50%,-100%) rotate('+angle+'deg)';
                                document.getElementById('pv_needle').style.background = gradCss;

                                // Ambient shapes opacity
                                var op = ambient / 100;
                                document.getElementById('pv_s1').style.opacity = (op * 0.6).toFixed(2);
                                document.getElementById('pv_s2').style.opacity = (op * 0.5).toFixed(2);
                                document.getElementById('pv_s1').style.background = `radial-gradient(circle, ${hexToRgba(bs, 100)}, transparent 70%)`;
                                document.getElementById('pv_s2').style.background = `radial-gradient(circle, ${hexToRgba(be, 100)}, transparent 70%)`;
                            }

                            // Init on page load
                            document.addEventListener('DOMContentLoaded', function() {
                                var tab = document.querySelector('[href="#gradient-studio"]');
                                if(tab) {
                                    tab.addEventListener('shown.bs.tab', function() {
                                        // Delay briefly to ensure DOM rect is loaded properly for markers positioning
                                        setTimeout(function() {
                                            renderStops();
                                            gsUpdate();
                                        }, 100);
                                    });
                                }
                                renderStops();
                                selectStop(0); // Select first stop as active by default
                                gsUpdate();
                            });
                            </script>
                        </div>
                        @endrole

                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-vision-primary">Yadda Saxla</button>
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
    $('#lfm_logo').filemanager('image');
    $('#lfm_logo_dark').filemanager('image');
    $('#lfm_favicon').filemanager('image');
</script>
@endpush
