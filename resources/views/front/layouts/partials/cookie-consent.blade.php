@php
$isPreview = request()->is('preview*');
$cookieKey = $isPreview ? 'preview.cookie' : 'front.cookie';
@endphp

<div id="cookie-consent-bar" class="cookie-consent-bar">
    <div class="cookie-content">
        <div class="cookie-icon">
            <svg viewBox="0 0 24 24" fill="none" class="cookie-svg">
                <path d="M21.593 7.203a2.975 2.975 0 0 0-3.692-3.692c-.14-.046-.24-.165-.254-.31a2.976 2.976 0 0 0-5.75-.436.299.299 0 0 1-.36.237 2.976 2.976 0 0 0-4.636 2.87.3.3 0 0 1-.362.296 2.976 2.976 0 0 0-2.203 4.22.3.3 0 0 1-.035.467 2.974 2.974 0 0 0 .524 5.382.3.3 0 0 1 .236.417 2.976 2.976 0 0 0 4.22 2.202.3.3 0 0 1 .468.035 2.975 2.975 0 0 0 5.38.525.3.3 0 0 1 .418.236 2.975 2.975 0 0 0 4.22-2.203.3.3 0 0 1 .467-.035 2.974 2.974 0 0 0 .525-5.38.3.3 0 0 1 .235-.418 2.974 2.974 0 0 0 .6-5.413.3.3 0 0 1-.25-.3zM12 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1-10 10zm-2-8a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm-6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1z" fill="currentColor" />
            </svg>
        </div>
        <div class="cookie-text-group">
            <p class="cookie-text" data-lang="{{ $cookieKey }}.text">
                {{ isset($ct) ? $ct($cookieKey.'.text', __($cookieKey.'.text')) : __($cookieKey.'.text') }}
            </p>
            <button type="button" class="cookie-link" id="cookie-settings-toggle">
                <span class="cookie-link-label" data-lang="{{ $cookieKey }}.settings">{{ __($cookieKey.'.settings') }}</span>
                <span class="cookie-link-caret" aria-hidden="true"></span>
            </button>
        </div>
        <button type="button" class="cookie-panel-close" id="cookie-panel-close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="cookie-preferences" id="cookie-preferences">
        <div class="cookie-option">
            <label class="cookie-option-label">
                <input type="checkbox" checked disabled>
                <span>
                    <span class="cookie-option-title" data-lang="{{ $cookieKey }}.essential">{{ __($cookieKey.'.essential') }}</span>
                    <span class="cookie-option-desc" data-lang="{{ $cookieKey }}.essential_desc">{{ __($cookieKey.'.essential_desc') }}</span>
                </span>
            </label>
        </div>
        <div class="cookie-option">
            <label class="cookie-option-label">
                <input type="checkbox" id="cookie-analytics-toggle">
                <span>
                    <span class="cookie-option-title" data-lang="{{ $cookieKey }}.analytics">{{ __($cookieKey.'.analytics') }}</span>
                    <span class="cookie-option-desc" data-lang="{{ $cookieKey }}.analytics_desc">{{ __($cookieKey.'.analytics_desc') }}</span>
                </span>
            </label>
        </div>
        <div class="cookie-option">
            <label class="cookie-option-label">
                <input type="checkbox" id="cookie-marketing-toggle">
                <span>
                    <span class="cookie-option-title" data-lang="{{ $cookieKey }}.marketing">{{ __($cookieKey.'.marketing') }}</span>
                    <span class="cookie-option-desc" data-lang="{{ $cookieKey }}.marketing_desc">{{ __($cookieKey.'.marketing_desc') }}</span>
                </span>
            </label>
        </div>
        <div class="cookie-policy">
            <div class="cookie-policy-title" data-lang="{{ $cookieKey }}.policy_title">{{ __($cookieKey.'.policy_title') }}</div>
            <ul>
                <li data-lang="{{ $cookieKey }}.policy_analytics">{{ __($cookieKey.'.policy_analytics') }}</li>
                <li data-lang="{{ $cookieKey }}.policy_marketing">{{ __($cookieKey.'.policy_marketing') }}</li>
                <li data-lang="{{ $cookieKey }}.policy_theme">{{ __($cookieKey.'.policy_theme') }}</li>
            </ul>
        </div>
    </div>
    <div class="cookie-buttons">
        <button id="cookie-close" class="cookie-btn close-btn" data-lang="{{ $cookieKey }}.decline">{{ __($cookieKey.'.decline') }}</button>
        <button id="cookie-save" class="cookie-btn save-btn" data-lang="{{ $cookieKey }}.save">{{ __($cookieKey.'.save') }}</button>
        <button id="cookie-accept" class="cookie-btn accept" data-lang="{{ $cookieKey }}.accept_all">{{ __($cookieKey.'.accept_all') }}</button>
    </div>
</div>
<button type="button" id="cookie-fab" class="cookie-fab" data-cookie-settings aria-label="{{ __($cookieKey.'.settings') }}" title="{{ __($cookieKey.'.settings') }}">
    <svg viewBox="0 0 24 24" fill="none" class="cookie-svg">
        <path d="M21.593 7.203a2.975 2.975 0 0 0-3.692-3.692c-.14-.046-.24-.165-.254-.31a2.976 2.976 0 0 0-5.75-.436.299.299 0 0 1-.36.237 2.976 2.976 0 0 0-4.636 2.87.3.3 0 0 1-.362.296 2.976 2.976 0 0 0-2.203 4.22.3.3 0 0 1-.035.467 2.974 2.974 0 0 0 .524 5.382.3.3 0 0 1 .236.417 2.976 2.976 0 0 0 4.22 2.202.3.3 0 0 1 .468.035 2.975 2.975 0 0 0 5.38.525.3.3 0 0 1 .418.236 2.975 2.975 0 0 0 4.22-2.203.3.3 0 0 1 .467-.035 2.974 2.974 0 0 0 .525-5.38.3.3 0 0 1 .235-.418 2.974 2.974 0 0 0 .6-5.413.3.3 0 0 1-.25-.3zM12 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1-10 10zm-2-8a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm-6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1z" fill="currentColor" />
    </svg>
</button>

<style>
    /* Premium Glass Cookie Consent */
    .cookie-consent-bar {
        --cookie-bg: rgba(250, 250, 252, 0.95);
        --cookie-bg-strong: rgba(250, 250, 252, 0.98);
        --cookie-border: rgba(15, 23, 42, 0.08);
        --cookie-shadow: 0 18px 50px rgba(15, 23, 42, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.6);
        --cookie-text: #0f172a;
        --cookie-muted: #475569;
        --cookie-soft: rgba(15, 23, 42, 0.06);
        --cookie-card: rgba(15, 23, 42, 0.04);
        --cookie-card-border: rgba(15, 23, 42, 0.12);
        --cookie-policy-bg: rgba(15, 23, 42, 0.04);
        --cookie-policy-border: rgba(15, 23, 42, 0.12);
        --cookie-input-bg: rgba(15, 23, 42, 0.08);
        --cookie-input-border: rgba(15, 23, 42, 0.32);
        --cookie-input-check: #ffffff;
        --cookie-checked-shadow: rgba(var(--brand-primary-rgb), 0.65);
        --cookie-check-size: 14px;
        --cookie-check-radius: 6px;
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        width: 90%;
        max-width: 980px;
        /* Wider for better layout */
        background: var(--cookie-bg);
        backdrop-filter: saturate(180%) blur(20px);
        -webkit-backdrop-filter: saturate(180%) blur(20px);
        border: 1px solid var(--cookie-border);
        border-radius: 20px;
        padding: 20px 25px;
        box-shadow: var(--cookie-shadow);
        z-index: 999999;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        grid-template-areas: "content buttons";
        align-items: center;
        gap: 20px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        font-family: var(--font-main);
    }

    .cookie-consent-bar.active {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
        visibility: visible;
    }

    /* Layout for Expanded State (Settings) */
    .cookie-consent-bar.expanded {
        grid-template-columns: minmax(0, 1fr);
        grid-template-areas:
            "content"
            "prefs"
            "buttons";
        row-gap: 18px;
        align-items: stretch;
        max-width: 800px;
        background: var(--cookie-bg-strong);
    }

    /* Content Area */
    .cookie-content {
        grid-area: content;
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
        min-width: 0;
    }

    .cookie-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        background: rgba(var(--brand-primary-rgb), 0.12);
        /* Brand tint */
        border: 1px solid rgba(var(--brand-primary-rgb), 0.25);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-primary);
    }

    .cookie-svg {
        width: 24px;
        height: 24px;
        fill: currentColor;
    }

    .cookie-text-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
        min-width: 0;
    }

    .cookie-text {
        font-size: 0.95rem;
        color: var(--cookie-text);
        margin: 0;
        line-height: 1.5;
        font-weight: 400;
    }

    .cookie-link {
        background: transparent;
        border: none;
        color: var(--brand-secondary);
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        padding: 0;
        text-align: left;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: opacity 0.2s;
        text-decoration: underline;
        text-underline-offset: 4px;
        width: fit-content;
        white-space: nowrap;
        line-height: 1.2;
        outline: none;
        box-shadow: none;
    }

    .cookie-link:hover {
        opacity: 0.8;
    }

    .cookie-link:focus,
    .cookie-link:focus-visible {
        outline: none;
        box-shadow: none;
    }

    .cookie-link-caret {
        width: 10px;
        height: 10px;
        border: solid currentColor;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        margin-left: 6px;
        transition: transform 0.2s ease;
    }

    .cookie-consent-bar.expanded .cookie-link-caret {
        transform: rotate(-135deg);
    }

    .cookie-panel-close {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid var(--cookie-border);
        background: var(--cookie-soft);
        color: var(--cookie-text);
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        line-height: 1;
        transition: all 0.2s ease;
        flex-shrink: 0;
        margin-left: auto;
        align-self: flex-start;
        margin-top: 2px;
    }

    .cookie-panel-close:hover {
        border-color: rgba(var(--brand-primary-rgb), 0.35);
        background: rgba(var(--brand-primary-rgb), 0.12);
    }

    .cookie-consent-bar.expanded .cookie-panel-close {
        display: inline-flex;
    }

    /* Buttons Area */
    .cookie-buttons {
        grid-area: buttons;
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        row-gap: 10px;
    }

    .cookie-consent-bar.expanded .cookie-buttons {
        width: 100%;
        justify-content: flex-end;
        column-gap: 12px;
        row-gap: 12px;
    }


    .cookie-btn {
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        flex: 0 0 auto;
    }

    /* Primary Action: Accept All */
    .cookie-btn.accept {
        background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
        color: #fff;
        box-shadow: 0 4px 15px rgba(var(--brand-primary-rgb), 0.3);
    }

    .cookie-btn.accept:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(var(--brand-primary-rgb), 0.4);
    }

    /* Secondary Action: Save/Close */
    .cookie-btn.save-btn,
    .cookie-btn.close-btn {
        background: var(--cookie-soft);
        border-color: var(--cookie-border);
        color: var(--cookie-text);
    }

    .cookie-btn.save-btn:hover,
    .cookie-btn.close-btn:hover {
        background: rgba(var(--brand-primary-rgb), 0.12);
        border-color: rgba(var(--brand-primary-rgb), 0.35);
        color: var(--cookie-text);
    }

    /* Close Button specifically */
    .cookie-btn.close-btn {
        min-width: 100px;
    }

    /* Preferences Panel */
    .cookie-preferences {
        grid-area: prefs;
        display: none;
        width: 100%;
        border-top: 1px solid var(--cookie-border);
        padding-top: 20px;
        margin-top: 10px;
        gap: 15px;
    }

    /* When expanded, show preferences */
    .cookie-consent-bar.expanded .cookie-preferences {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .cookie-option {
        padding: 15px;
        border-radius: 14px;
        border: 1px solid var(--cookie-card-border);
        background: var(--cookie-card);
        transition: background 0.3s;
    }

    .cookie-option:hover {
        background: rgba(var(--brand-primary-rgb), 0.08);
    }

    .cookie-option-label {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: var(--cookie-text);
        font-size: 0.9rem;
        cursor: pointer;
    }

    /* Custom Checkbox */
    .cookie-consent-bar .cookie-option-label input[type="checkbox"] {
        appearance: none !important;
        -webkit-appearance: none !important;
        width: var(--cookie-check-size) !important;
        height: var(--cookie-check-size) !important;
        min-width: var(--cookie-check-size) !important;
        min-height: var(--cookie-check-size) !important;
        max-width: var(--cookie-check-size) !important;
        max-height: var(--cookie-check-size) !important;
        flex-shrink: 0;
        border-radius: var(--cookie-check-radius) !important;
        border: 1px solid var(--cookie-input-border) !important;
        background: var(--cookie-input-bg) !important;
        position: relative;
        transition: all 0.2s;
        margin-top: 2px;
        box-shadow: none !important;
        transform: none !important;
        padding: 0 !important;
        outline: none !important;
    }

    .cookie-consent-bar .cookie-option-label input:checked {
        background: var(--brand-gradient);
        border-color: rgba(var(--brand-primary-rgb), 0.9);
        box-shadow: 0 0 0 2px var(--cookie-checked-shadow);
    }

    .cookie-consent-bar .cookie-option-label input[type="checkbox"]:checked::after {
        content: '';
        position: absolute;
        left: 4px;
        top: 1px;
        width: 4px;
        height: 7px;
        border: solid var(--cookie-input-check);
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .cookie-option-title {
        font-weight: 600;
        color: var(--cookie-text);
        display: block;
        margin-bottom: 2px;
    }

    .cookie-option-desc {
        font-size: 0.8rem;
        color: var(--cookie-muted);
        line-height: 1.3;
    }

    /* Policy Text */
    .cookie-policy {
        grid-column: 1 / -1;
        margin-top: 10px;
        padding: 15px;
        border-radius: 12px;
        border: 1px dashed var(--cookie-policy-border);
        background: var(--cookie-policy-bg);
        font-size: 0.85rem;
        color: var(--cookie-muted);
    }

    .cookie-policy ul {
        margin: 5px 0 0;
        padding-left: 20px;
    }

    .cookie-policy li {
        margin-bottom: 4px;
    }

    .cookie-fab {
        position: fixed;
        left: 24px;
        bottom: 24px;
        width: 48px;
        height: 48px;
        border-radius: 16px;
        border: 1px solid rgba(var(--brand-primary-rgb), 0.25);
        background: rgba(250, 250, 252, 0.95);
        color: var(--brand-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.2);
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 999998;
    }

    .cookie-fab.visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .cookie-fab:hover {
        box-shadow: 0 12px 34px rgba(15, 23, 42, 0.3);
    }

    [data-theme="dark"] .cookie-consent-bar {
        --cookie-bg: rgba(18, 18, 24, 0.88);
        --cookie-bg-strong: rgba(18, 18, 24, 0.96);
        --cookie-border: rgba(255, 255, 255, 0.1);
        --cookie-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        --cookie-text: #e2e8f0;
        --cookie-muted: #94a3b8;
        --cookie-soft: rgba(255, 255, 255, 0.06);
        --cookie-card: rgba(255, 255, 255, 0.04);
        --cookie-card-border: rgba(255, 255, 255, 0.1);
        --cookie-policy-bg: rgba(0, 0, 0, 0.2);
        --cookie-policy-border: rgba(255, 255, 255, 0.1);
        --cookie-input-bg: rgba(255, 255, 255, 0.08);
        --cookie-input-border: rgba(255, 255, 255, 0.3);
        --cookie-input-check: #ffffff;
        --cookie-checked-shadow: rgba(var(--brand-primary-rgb), 0.45);
    }

    [data-theme="dark"] .cookie-fab {
        background: rgba(18, 18, 24, 0.9);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    .cookie-consent-bar,
    .cookie-consent-bar * {
        cursor: default;
    }

    .cookie-consent-bar button,
    .cookie-consent-bar a,
    .cookie-consent-bar label,
    .cookie-consent-bar input,
    .cookie-fab {
        cursor: pointer;
    }

    body.custom-cursor.cookie-consent-open .cookie-consent-bar,
    body.custom-cursor.cookie-consent-open .cookie-consent-bar * {
        cursor: auto !important;
    }

    body.custom-cursor.cookie-consent-open .cookie-consent-bar button,
    body.custom-cursor.cookie-consent-open .cookie-consent-bar a,
    body.custom-cursor.cookie-consent-open .cookie-consent-bar label,
    body.custom-cursor.cookie-consent-open .cookie-consent-bar input,
    body.custom-cursor.cookie-consent-open .cookie-fab {
        cursor: pointer !important;
    }

    /* Fixed: Do not hide cursor globally. */

    @media (max-width: 720px) {
        .cookie-consent-bar {
            grid-template-columns: minmax(0, 1fr);
            grid-template-areas:
                "content"
                "buttons";
        }

        .cookie-consent-bar.expanded {
            grid-template-areas:
                "content"
                "prefs"
                "buttons";
            row-gap: 14px;
        }

        .cookie-buttons {
            justify-content: flex-start;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const consentBar = document.getElementById('cookie-consent-bar');
        const fabButton = document.getElementById('cookie-fab');
        const acceptBtn = document.getElementById('cookie-accept');
        const closeBtn = document.getElementById('cookie-close');
        const saveBtn = document.getElementById('cookie-save');
        const settingsToggle = document.getElementById('cookie-settings-toggle');
        const panelCloseBtn = document.getElementById('cookie-panel-close');
        const analyticsToggle = document.getElementById('cookie-analytics-toggle');
        const marketingToggle = document.getElementById('cookie-marketing-toggle');
        const settingsLinks = document.querySelectorAll('[data-cookie-settings]');

        if (!consentBar || !acceptBtn || !closeBtn || !saveBtn || !settingsToggle || !analyticsToggle || !marketingToggle) return;

        const STORAGE_KEY = 'chalang_cookie_consent';
        const CONSENT_VERSION = 'v2';
        const ANALYTICS_COOKIE = 'analytics_consent';
        const MARKETING_COOKIE = 'marketing_consent';
        const COOKIE_DAYS = 365;

        const getCookie = (name) => {
            const prefix = name + '=';
            return document.cookie
                .split('; ')
                .find((item) => item.startsWith(prefix))
                ?.slice(prefix.length) ?? null;
        };

        const setCookie = (name, value) => {
            const maxAge = COOKIE_DAYS * 24 * 60 * 60;
            const secure = window.location.protocol === 'https:' ? '; Secure' : '';
            document.cookie = `${name}=${value}; path=/; max-age=${maxAge}; SameSite=Lax${secure}`;
        };

        const hasDnt = () => {
            const dnt = navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack;
            return dnt === '1' || dnt === 'yes';
        };

        const readStoredConsent = () => {
            const raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return null;
            if (raw === 'accepted' || raw === 'declined') {
                return {
                    version: 'legacy',
                    analytics: raw === 'accepted',
                    marketing: false
                };
            }
            try {
                const data = JSON.parse(raw);
                if (data && typeof data === 'object') return data;
            } catch (err) {
                return null;
            }
            return null;
        };

        const updateFabVisibility = () => {
            if (!fabButton) return;
            const isActive = consentBar.classList.contains('active');
            fabButton.classList.toggle('visible', !isActive);
        };

        const showBar = (expanded = false) => {
            consentBar.classList.add('active');
            if (expanded) consentBar.classList.add('expanded');
            document.body.classList.add('cookie-consent-open');
            updateFabVisibility();
        };

        const hideBar = () => {
            consentBar.classList.remove('active', 'expanded');
            document.body.classList.remove('cookie-consent-open');
            updateFabVisibility();
        };

        const persistConsent = (analyticsEnabled, marketingEnabled) => {
            const payload = {
                version: CONSENT_VERSION,
                analytics: !!analyticsEnabled,
                marketing: !!marketingEnabled,
                updatedAt: new Date().toISOString(),
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
            setCookie(ANALYTICS_COOKIE, analyticsEnabled ? '1' : '0');
            setCookie(MARKETING_COOKIE, marketingEnabled ? '1' : '0');
        };

        const storedConsent = readStoredConsent();
        const analyticsCookie = getCookie(ANALYTICS_COOKIE);
        const marketingCookie = getCookie(MARKETING_COOKIE);

        if (hasDnt() && !storedConsent && analyticsCookie === null && marketingCookie === null) {
            persistConsent(false, false);
            hideBar();
            return;
        }

        let effectiveConsent = storedConsent;
        if (!effectiveConsent && (analyticsCookie !== null || marketingCookie !== null)) {
            effectiveConsent = {
                version: CONSENT_VERSION,
                analytics: analyticsCookie === '1',
                marketing: marketingCookie === '1',
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(effectiveConsent));
        }

        const needsFreshChoice = !effectiveConsent || effectiveConsent.version !== CONSENT_VERSION;
        const initialAnalytics = needsFreshChoice ? true : !!effectiveConsent?.analytics;
        const initialMarketing = needsFreshChoice ? true : !!effectiveConsent?.marketing;
        analyticsToggle.checked = initialAnalytics;
        marketingToggle.checked = initialMarketing;

        if (needsFreshChoice) {
            setTimeout(() => {
                showBar(false);
            }, 900);
        } else {
            updateFabVisibility();
        }

        const openPanel = () => showBar(true);

        settingsLinks.forEach((link) => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                openPanel();
            });
        });

        settingsToggle.addEventListener('click', () => {
            consentBar.classList.add('active');
            consentBar.classList.toggle('expanded');
            document.body.classList.add('cookie-consent-open');
            updateFabVisibility();
        });

        if (panelCloseBtn) {
            panelCloseBtn.addEventListener('click', () => {
                consentBar.classList.remove('expanded');
                updateFabVisibility();
            });
        }

        acceptBtn.addEventListener('click', () => {
            analyticsToggle.checked = true;
            marketingToggle.checked = true;
            persistConsent(true, true);
            hideBar();
            location.reload();
        });

        closeBtn.addEventListener('click', () => {
            analyticsToggle.checked = false;
            marketingToggle.checked = false;
            persistConsent(false, false);
            hideBar();
            location.reload();
        });

        saveBtn.addEventListener('click', () => {
            persistConsent(analyticsToggle.checked, marketingToggle.checked);
            hideBar();
            location.reload();
        });
    });
</script>