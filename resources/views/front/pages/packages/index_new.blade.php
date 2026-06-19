@extends('front.layouts.main_new')
@section('content')
@php
    $packageCards = collect();
    if (isset($pricingPlans) && $pricingPlans->count() > 0) {
        $packageCards = $pricingPlans->map(function ($plan) {
            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'description' => $plan->description,
                'features' => $plan->features ?? [],
                'is_popular' => (bool) $plan->is_popular,
            ];
        });
    } else {
        $packageCards = collect($fallbackPackages ?? []);
    }
@endphp

<section class="package-hero">
    <div class="container">
        <p class="section-subtitle">Paket Konfiquratoru</p>
        <h1 class="section-title">Sizə uyğun paketi qurun</h1>
        <p class="package-hero-text">
            Paket seçin, add-onları əlavə edin və qısa brif göndərin. Qiymət açıq deyil,
            təklif sizin ehtiyaclara uyğun hazırlanacaq.
        </p>
    </div>
</section>

<section class="package-configurator">
    <div class="container">
        @if (session('success'))
            <div class="package-alert success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="package-alert error">Xəta baş verdi. Zəhmət olmasa məlumatları yoxlayın.</div>
        @endif

        <div class="package-steps" id="package-steps">
            <div class="package-step active" data-step="1">1. Paket</div>
            <div class="package-step" data-step="2">2. Add-on</div>
            <div class="package-step" data-step="3">3. Chalang AI brif</div>
            <div class="package-step" data-step="4">4. Xülasə</div>
        </div>

        <form class="package-form" id="package-form" method="POST" action="{{ route('packages.submit') }}">
            @csrf
            <input type="hidden" name="package_name" id="package_name" value="{{ old('package_name') }}">
            <input type="hidden" name="package_id" id="package_id" value="{{ old('package_id') }}">
            <input type="text" name="hp" class="package-hp" autocomplete="off" tabindex="-1" aria-hidden="true">

            <div class="wizard-step active" data-step="1">
                <h2 class="wizard-title">Paket seçimi</h2>
                <p class="wizard-subtitle">Sizə ən uyğun paketi seçin. İstəsəniz “Custom” seçə bilərsiniz.</p>
                <div class="package-grid">
                    @foreach ($packageCards as $card)
                        <button type="button" class="package-card" data-package-name="{{ $card['name'] }}" data-package-id="{{ $card['id'] ?? '' }}">
                            @if (!empty($card['is_popular']))
                                <span class="package-badge">Populyar</span>
                            @endif
                            <h3>{{ $card['name'] }}</h3>
                            <p>{{ $card['description'] }}</p>
                            @if (!empty($card['features']))
                                <ul>
                                    @foreach ($card['features'] as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <span class="package-cta">Seç</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="wizard-step" data-step="2">
                <h2 class="wizard-title">Add-on seçimləri</h2>
                <p class="wizard-subtitle">İstəyə uyğun əlavə xidmətləri seçin.</p>
                <div class="addon-grid">
                    @foreach ($addons as $addon)
                        <label class="addon-card">
                            <input type="checkbox" name="addons[]" value="{{ $addon['name'] }}" data-addon-label="{{ $addon['name'] }}">
                            <div class="addon-content">
                                <h4>{{ $addon['name'] }}</h4>
                                <p>{{ $addon['description'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="wizard-step" data-step="3">
                <div class="bilge-card">
                    <div class="bilge-title">Chalang AI köməkçisi</div>
                    <p>Bu qısa suallara cavab verin, brifiniz daha dəqiq olsun.</p>
                </div>
                <div class="brief-grid">
                    <label class="brief-field">
                        <span>Məqsədiniz nədir?</span>
                        <textarea name="brief_goal" rows="3" placeholder="Məs: satış artımı, brend tanıtımı...">{{ old('brief_goal') }}</textarea>
                    </label>
                    <label class="brief-field">
                        <span>Deadline</span>
                        <input type="text" name="brief_deadline" placeholder="Məs: 4 həftə" value="{{ old('brief_deadline') }}">
                    </label>
                    <label class="brief-field">
                        <span>Büdcə aralığı</span>
                        <input type="text" name="brief_budget_range" placeholder="Məs: 3k-7k" value="{{ old('brief_budget_range') }}">
                    </label>
                    <label class="brief-field">
                        <span>Prioritet xidmətlər</span>
                        <textarea name="brief_priority_services" rows="3" placeholder="Məs: SEO, landing, CRM...">{{ old('brief_priority_services') }}</textarea>
                    </label>
                    <label class="brief-field">
                        <span>Mövcud materiallar</span>
                        <textarea name="brief_materials" rows="3" placeholder="Məs: logo, brandbook, kontent...">{{ old('brief_materials') }}</textarea>
                    </label>
                    <label class="brief-field">
                        <span>Rəqib nümunələr</span>
                        <textarea name="brief_competitors" rows="3" placeholder="Linklər və ya adlar">{{ old('brief_competitors') }}</textarea>
                    </label>
                    <label class="brief-field">
                        <span>Əlaqə kanalı</span>
                        <input type="text" name="brief_contact_channel" placeholder="Məs: WhatsApp / Email" value="{{ old('brief_contact_channel') }}">
                    </label>
                </div>
            </div>

            <div class="wizard-step" data-step="4">
                <h2 class="wizard-title">Xülasə və əlaqə</h2>
                <div class="summary-grid">
                    <div class="summary-card">
                        <h4>Seçilən paket</h4>
                        <p id="summary-package">-</p>
                    </div>
                    <div class="summary-card">
                        <h4>Add-onlar</h4>
                        <ul id="summary-addons"></ul>
                    </div>
                    <div class="summary-card">
                        <h4>Brif xülasəsi</h4>
                        <p id="summary-brief">-</p>
                    </div>
                </div>

                <div class="contact-grid">
                    <label class="brief-field">
                        <span>Ad Soyad</span>
                        <input type="text" name="full_name" placeholder="Ad Soyad" value="{{ old('full_name') }}" required>
                    </label>
                    <label class="brief-field">
                        <span>E-poçt</span>
                        <input type="email" name="email" placeholder="email@domain.com" value="{{ old('email') }}" required>
                    </label>
                    <label class="brief-field">
                        <span>Telefon</span>
                        <input type="text" name="phone" placeholder="+994 50 000 00 00" value="{{ old('phone') }}" required>
                    </label>
                    <label class="brief-field full">
                        <span>Əlavə qeyd</span>
                        <textarea name="notes" rows="3" placeholder="Əlavə qeydlər">{{ old('notes') }}</textarea>
                    </label>
                </div>
            </div>

            <div class="wizard-controls">
                <button type="button" class="btn-secondary" id="wizard-prev">Geri</button>
                <button type="button" class="btn-primary" id="wizard-next">Növbəti</button>
                <button type="submit" class="btn-primary" id="wizard-submit">Təklif istə</button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('js_script')
<script>
    (function () {
        const form = document.getElementById('package-form');
        if (!form) {
            return;
        }

        const steps = Array.from(form.querySelectorAll('.wizard-step'));
        const stepIndicators = Array.from(document.querySelectorAll('.package-step'));
        const nextBtn = document.getElementById('wizard-next');
        const prevBtn = document.getElementById('wizard-prev');
        const submitBtn = document.getElementById('wizard-submit');
        const packageNameInput = document.getElementById('package_name');
        const packageIdInput = document.getElementById('package_id');
        const summaryPackage = document.getElementById('summary-package');
        const summaryAddons = document.getElementById('summary-addons');
        const summaryBrief = document.getElementById('summary-brief');
        const packageCards = Array.from(document.querySelectorAll('.package-card'));

        let currentStep = 1;

        function setStep(step) {
            currentStep = step;
            steps.forEach((panel) => {
                panel.classList.toggle('active', Number(panel.dataset.step) === currentStep);
            });
            stepIndicators.forEach((indicator) => {
                indicator.classList.toggle('active', Number(indicator.dataset.step) === currentStep);
            });
            prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
            nextBtn.style.display = currentStep === steps.length ? 'none' : 'inline-flex';
            submitBtn.style.display = currentStep === steps.length ? 'inline-flex' : 'none';
            nextBtn.disabled = currentStep === 1 && !packageNameInput.value;
            updateSummary();
        }

        function updateSummary() {
            summaryPackage.textContent = packageNameInput.value || '-';
            summaryAddons.innerHTML = '';
            const checkedAddons = Array.from(form.querySelectorAll('input[name=\"addons[]\"]:checked'));
            if (checkedAddons.length === 0) {
                summaryAddons.innerHTML = '<li>-</li>';
            } else {
                checkedAddons.forEach((addon) => {
                    const li = document.createElement('li');
                    li.textContent = addon.dataset.addonLabel || addon.value;
                    summaryAddons.appendChild(li);
                });
            }

            const briefFields = [
                form.querySelector('[name=\"brief_goal\"]'),
                form.querySelector('[name=\"brief_deadline\"]'),
                form.querySelector('[name=\"brief_budget_range\"]'),
                form.querySelector('[name=\"brief_priority_services\"]'),
                form.querySelector('[name=\"brief_materials\"]'),
                form.querySelector('[name=\"brief_competitors\"]'),
                form.querySelector('[name=\"brief_contact_channel\"]')
            ];

            const briefValues = briefFields
                .map((field) => field && field.value.trim())
                .filter((value) => value);

            summaryBrief.textContent = briefValues.length ? briefValues.join(' | ') : '-';
        }

        packageCards.forEach((card) => {
            card.addEventListener('click', function () {
                packageCards.forEach((btn) => btn.classList.remove('selected'));
                card.classList.add('selected');
                const selectedId = card.dataset.packageId || '';
                packageNameInput.value = card.dataset.packageName || '';
                if (selectedId) {
                    packageIdInput.disabled = false;
                    packageIdInput.value = selectedId;
                } else {
                    packageIdInput.value = '';
                    packageIdInput.disabled = true;
                }
                nextBtn.disabled = !packageNameInput.value;
                updateSummary();
            });
        });

        form.addEventListener('input', updateSummary);

        nextBtn.addEventListener('click', function () {
            if (currentStep === 1 && !packageNameInput.value) {
                return;
            }
            if (currentStep < steps.length) {
                setStep(currentStep + 1);
            }
        });

        prevBtn.addEventListener('click', function () {
            if (currentStep > 1) {
                setStep(currentStep - 1);
            }
        });

        if (!packageIdInput.value) {
            packageIdInput.disabled = true;
        }
        setStep(1);
    })();
</script>
@endpush

