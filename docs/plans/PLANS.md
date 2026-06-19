## Planlanan Funksiyalar

### AI & Kontent
- Avtomatik tərcümə (AZ→EN/RU) düyməsi
- AI copywriter (SEO yönümlü mətn generasiya)
- SEO meta təklifi (title/description/keywords)
- AI content QA (dil/stil/oxunaqlıq yoxlaması)
- Kontent təqvimi, approval/versiya, şablon kitabxanası

### Analitika & Monitorinq
- Canlı ziyarətçi xəritəsi (geo-IP real-time)
- Heatmap/klik izləmə və vizualı
- Lead konversiya/funnel qrafikləri
- Uptime/performance + tracing/observability
- Anomaliya alertləri (trafik/error artımı)

### CRM/Lead & Bildiriş
- Kanban lövhəsi (Yeni/Danışıqlar/Bağlandı)
- Müştəri profili, AI təsnifat, ABM enrich
- Bildirişlər: dropdown + tarixçə, “Hamısını oxunmuş et”, mail/Slack/Push

### UI/UX & Hədəfləmə
- Brand rəng palitrası dəyişdirici
- P2: Theme editor advanced: live preview, reset/undo, contrast check, palette generator, presets, font scale, button/shadow controls, per-page override, apply-to light/dark, autosave/publish (est: 8-12d)
- Banner/Popup builder, feature toggles
- A/B test planlayıcı, session replay
- Segment targeting (ölkə/cihaz/səhifə/UTM)

### Form/Media/SEO
- Vizual form builder + CSV/Excel export
- Media optimizasiya (compress/resize, alt-text check, bulk upload)
- XML sitemap, 404/broken link skanı, hreflang/meta checker

### Təhlükəsizlik/Audit & İnteqrasiya
- Activity log (diff, revert), RBAC audit
- Snapshot/backup (versiya qaytarma), GDPR/cookie
- İnteqrasiyalar: CRM/webhook/Elastic/ödəniş gateway

### PWA/Mobil & Ops/Deployment
- PWA manifest + offline draft, push bildirişlər, mobil optimizasiyası
- Stage/prod ayırması, feature flags, cache/CDN, backup/restore
- Test/QA, changelog, admin bələdçisi

### Digər Opsiyalar
- A/B test triggerləri, form tərk etmə xəbərdarlığı
- Form builder genişlənməsi (ödəniş/quote axını, opsiyonel)
- Uptime/error log paneli, error/performance budget

### Müştəri Portalı
- Hesab və giriş: hər müştəri yalnız öz layihələrini görür; rol icazəsi (owner/team) səlahiyyətləri
- Layihə izləmə: mərhələ statusu, tarixçə, məsul şəxs; proqress bar, tapşırıq sayı, gözləyən reviziyalar
- Fayl və təsdiq axını: preview/final, “təsdiq et”/“reviziya” düymələri, versiya tarixçəsi və rollback
- Şərh/feedback və support: mərhələ/fayl üzərindən dialoq, mail/panel bildirişləri; bilet sistemi, prioritet, task/kanban bağlantısı
- Toplantı/raportlar: görüş təqvimi, qeydlər, həftəlik progress PDF/HTML, status çıxışı
- Sənədlər və brend: müqavilə/qrafik/toplantı qeydləri “kit”, müştərinin logo/foto yükləməsi, brend guide
- Ödəniş/təklif: təklif qəbul/imtina, e-imza (ops.), invoice və ödəniş linkləri, hissə-hissə ödəniş planı, qəbz
- Məxfilik və paylaşma: expire link, su nişanı, download icazəsi; NDA qəbul düyməsi
- Bildirişlər: mərhələ/fayl/şərh/ödəniş yenilikləri (email/push), istifadəçinin öz preference-ları
- Sayt sağlamlığı: müştəriyə açıq uptime/performance xülasəsi, kritik alert bildirişi
- Çoxdilli portal: AZ/EN/RU UI, materialları dilə görə süzmək

### Admin panelde Drag & Drop (Notion-tipli)
- Hedef: mushteri admin panelde sadelestirilmis surukle-burax; dizayn/layoutha tam serbestlik yoxdur (guardrails)
- Variant A (teklif): block siralama (yuxari-ashagi) + basic blok field editleri
- Variant B (Notion-tipli): nested bloklar, columns, inline blocks (yalniz daxili builderde)
- Texniki qeydler: SortableJS (Blade) veya React DnD (builder); autosave + undo/redo minimal; responsive visibility toggle
- Permissions: super-admin full; client content-only (no layout)
