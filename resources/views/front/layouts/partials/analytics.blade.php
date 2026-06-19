@php
    $ga4Id = $searchConsole = $metaPixel = $yandexId = null;
    $analyticsFlag = config('features.analytics_tracking');
    $requireConsent = app()->environment('production');

    if ($analyticsFlag && \Illuminate\Support\Facades\Schema::hasTable('settings')) {
        $ga4Id = \App\Models\Setting::getValue('ga4_measurement_id');
        $searchConsole = \App\Models\Setting::getValue('search_console_meta');
        $metaPixel = \App\Models\Setting::getValue('meta_pixel_id');
        $yandexId = \App\Models\Setting::getValue('yandex_metrica_id');
    }

    $analyticsConfig = [
        'enabled' => (bool) $analyticsFlag,
        'requireConsent' => (bool) $requireConsent,
        'ga4Id' => $ga4Id,
        'metaPixel' => $metaPixel,
        'yandexId' => $yandexId,
    ];
@endphp

@if ($analyticsFlag && $searchConsole)
    <meta name="google-site-verification" content="{{ $searchConsole }}">
@endif

<script>
    window.__chalangAnalytics = @json($analyticsConfig);
</script>
<script>
    (function() {
        const config = window.__chalangAnalytics || {};
        if (!config.enabled) return;

        const getCookie = (name) => {
            const prefix = name + '=';
            return document.cookie
                .split('; ')
                .find((item) => item.startsWith(prefix))
                ?.slice(prefix.length) ?? null;
        };

        const hasDnt = () => {
            const dnt = navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack;
            return dnt === '1' || dnt === 'yes';
        };

        if (hasDnt()) return;

        const analyticsConsent = getCookie('analytics_consent') === '1';
        const marketingConsent = getCookie('marketing_consent') === '1';
        const allowAnalytics = !config.requireConsent || analyticsConsent;
        const allowMarketing = !config.requireConsent || marketingConsent;

        const loadScript = (src, onload) => {
            const script = document.createElement('script');
            script.async = true;
            script.src = src;
            if (onload) script.onload = onload;
            document.head.appendChild(script);
        };

        if (config.ga4Id) {
            window.dataLayer = window.dataLayer || [];
            window.gtag = window.gtag || function() { window.dataLayer.push(arguments); };
            window.gtag('consent', 'default', {
                ad_storage: 'denied',
                analytics_storage: 'denied',
                ad_user_data: 'denied',
                ad_personalization: 'denied',
                wait_for_update: 500
            });
            if (allowAnalytics || allowMarketing) {
                window.gtag('consent', 'update', {
                    ad_storage: allowMarketing ? 'granted' : 'denied',
                    analytics_storage: allowAnalytics ? 'granted' : 'denied',
                    ad_user_data: allowMarketing ? 'granted' : 'denied',
                    ad_personalization: allowMarketing ? 'granted' : 'denied'
                });
            }
            if (allowAnalytics) {
                window.gtag('js', new Date());
                window.gtag('config', config.ga4Id, { anonymize_ip: true });
                loadScript(`https://www.googletagmanager.com/gtag/js?id=${config.ga4Id}`);
            }
        }

        if (!allowAnalytics && !allowMarketing) return;

        if (config.metaPixel && !window.fbq && allowMarketing) {
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', config.metaPixel);
            fbq('track', 'PageView');
        }

        if (config.yandexId && !window.ym && allowAnalytics) {
            (function(m,e,t,r,i,k,a){
                m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
            })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
            ym(config.yandexId, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        }
    })();
</script>
