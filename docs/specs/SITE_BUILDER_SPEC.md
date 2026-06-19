# Site Builder Spec (Agentlik daxili)

## Xulase
Bu dokument agentlik ucun daxili sayt-qurucu (builder) planidir. Builder yalniz agentlik terefinden isledilir, mushteriye ise normal admin paneli olan, "adi sayt" kimi verilmis hazir Laravel lahiyesi export edilir. Meqsed: tekrarlanan isleri avtomatlasdirmaq, dizayn butovluyunu qorumaq ve developerlere “deep” isleri oturmekdir.

## Kontekst ve mehdudiyyetler
- Builder yalniz agentlik ucun, mushteri ucun deyil.
- Mushteri sayti statik deyil, admin panelli dinamik olacaq.
- SEO qorunmalidir (SSR/Blade render).
- Deploy PHP + DB hosting teleb edir.
- Dizayn butovluyu pozulmamalidir (guardrails).

## Ugur meyarlari (Success criteria)
- 60-90 deqiqe icinde tipik sayt yigmaq.
- Exportdan sonra sayt problemsiz deploy olunur (0 kritik error).
- 3 dilli kontent korekt render olunur.
- Temel SEO (meta, sitemap, OG) tam isleyir.

## Terminler lügəti
- Builder: daxili sayt-qurucu platforma.
- Block: yeniden istifade olunan UI bolme.
- Template: hazir dizayn paketleri.
- Export: musteriyey verilen Laravel lahiyesi.
- Draft/Publish: kontentin preview ve live versiyasi.


Bu fayl: agentlik ucun daxili sayt-qurucu (builder) planidir. Builderi yalniz agentlik isledecek, mushteriye ise normal admin paneli olan, "adi sayt" kimi verilmis hazir layiheni export edeceyik.

---

## 0. Meqsed ve prinsipler
- Meqsed: agentlikde tez ve sabit sayta yigmaq, tekrarlanan isleri avtomatlasdirmaq, dizayn butovluyunu qorumaq.
- Prinsipler:
  - Dizayn butovluyu pozulmasin (guardrails).
  - SEO ve performans qorunsun (SSR/Blade render).
  - Builder yalniz daxili olsun (super-admin).
  - Mushteri admin panelinde kontenti idare etsin, dizayn/layouthu yox.
  - Handoff (dev-e oturme) rahat olsun.

---

## 1. Scope / Non-scope
**Scope (edilecekler)**
- Bütün sayt sehifeleri (ana, haqqimizda, xidmetler, portfolio, blog, kontakt, FAQ, s.)
- Block-based builder (hazir bloklar + drag/drop + siralama + gizlet/ac).
- Coxyilli kontent (AZ/EN/RU).
- Draft/Publish (preview link, versiya tarixi).
- Export: tam Laravel layihesi + admin panel + DB seed.

**Non-scope (indilik)**
- Mushteriye "tam serbest" dizayn editoru.
- Marketplace, user billing, multi-tenant platforma.
- Real-time collaboration (sonra ola biler).

---

## 2. Rollar ve icazeler
- Super-admin (agentlik):
  - Builderde tam edit (layout, blok, tema, media, export).
  - Draft/Publish, template secimi.
- Mushteri admin paneli:
  - Kontent update (metn, sekil, blog, forms).
  - SEO basic, settings, media.
  - Dizayn/layoutha giris yox (yalniz content).

---

## 3. Yuksək səviyyəli arxitektura
**Daxili Builder**
- Ayrı repo / proyektdir.
- Front: React + Vite (drag/drop UI).
- Back: Laravel API (auth, content JSON, assets, export).

**Mushteri sayti**
- Laravel + Blade (SSR).
- Admin panel (hazir modul).
- DB seed ile ilkin kontent.

**Data axini**
1) Builderde sayt yigilir (JSON schema + assets).
2) Export prosesi Laravel template repo-ya data inject edir.
3) Mushteri saytina tam paket verilir.

---

## 4. Data modeli (Builder DB)
**projects**
- id, name, slug, status (draft/published), default_lang, created_at

**project_languages**
- project_id, lang_code (az/en/ru), is_default

**pages**
- id, project_id, slug, template_key, status

**page_revisions**
- id, page_id, version, is_published, created_by, created_at
- content_json (block tree)
- seo_json (title, desc, og, canonical)

**menus**
- id, project_id, location (header/footer)
- items_json (lang-aware)

**theme_tokens**
- project_id, tokens_json (colors, fonts, radius, spacing, shadows)

**assets**
- id, project_id, file_path, alt, tags, width, height, type

**forms**
- id, project_id, key, fields_json, destination (email/db)

**export_history**
- id, project_id, version, export_path, created_at

---

## 5. Block schema (JSON)
**Struktur**
- page: { id, blocks[] }
- block: { id, type, variant, props, style, layout, visibility, translations }

**Misal JSON (sadelestirilmis)**
```json
{
  "pageId": "home",
  "blocks": [
    {
      "id": "hero-1",
      "type": "hero",
      "variant": "split",
      "props": {
        "title": { "az": "Basliq", "en": "Title" },
        "subtitle": { "az": "Alt yazi", "en": "Subtitle" },
        "ctaText": { "az": "Basla", "en": "Get started" },
        "ctaLink": "/contact"
      },
      "style": { "bg": "gradient-1", "padding": "xl" },
      "layout": { "cols": 2, "align": "center" },
      "visibility": { "desktop": true, "mobile": true }
    }
  ]
}
```

---

## 6. Builder UI (flow)
1) Project yarat
2) Template sec
3) Page editor (canvas)
4) Drag/drop bloklar
5) Inspector panel (text, image, spacing, colors)
6) Multi-language switch
7) Preview (desktop/tablet/mobile)
8) Draft save
9) Publish
10) Export (Laravel package)

---

## 7. Coxyilli kontent
- Diller proyekt seviyesinde secilir.
- Her blokda translations: az/en/ru.
- Fallback: default lang.
- Menu ve SEO da multi-lang.

---

## 8. Draft / Publish / Versioning
- Her save -> revision.
- Publish -> is_published true.
- Preview link -> draft render.
- Rollback: eski revisioni publish etmek.

---

## 9. Export pipeline (Laravel paket)
**Base template repo**
- Hazir admin panel, auth, settings, blog, forms.
- Blade layouts + component library.

**Export addimlari**
1) Project data JSON export et.
2) Base template clone et.
3) content_json -> DB seed (pages, blocks, menus).
4) theme_tokens -> config/theme.php + css vars.
5) assets -> public/storage/media.
6) migrations/seeders generate et.
7) export zip yarat.

**Handoff fayllari**
- source.zip
- seed.sql (optional)
- README-handoff.md
- content.json + theme.json (backup)

---

## 10. Mushteri admin paneli (normal rejim)
**Modullar**
- Pages (metn, sekil, blok data)
- Blog (CRUD)
- Portfolio / Case studies
- Contact form inbox
- SEO settings
- Media library
- Basic theme settings (limitli)

**Icazeler**
- Admin: kontent
- Super-admin (agentlik): her shey

---

## 10.1 Admin panelde Drag & Drop (Notion-tipli)
**Hedef**
- Mushteri admin panelde sadelestirilmis surukle-burax islesin.
- Dizayn/layoutha tam serbestlik verilmesin (guardrails).

**Variantlar**
- Variant A (teklif olunur): block siralama (yuxari-ashagi) + basic blok field editleri.
  - Stabil, tez, dizayn butovluyu qorunur.
- Variant B (Notion-tipli): nested bloklar, columns, inline blocks.
  - Daha guclu, amma riskli ve time-consuming.
  - Bu variant yalniz daxili builderde olsun, mushteri admin panelde yox.

**Texniki qeydlər**
- Front: SortableJS (Blade), ya da React DnD (builder).
- Autosave + undo/redo minimal.
- Responsive qaydalar: bloklar mobil/desktop visibility toggle.

---

## 11. Design tokens (theme)
- Colors: primary, secondary, accent, bg, text
- Fonts: heading, body
- Radius: sm, md, lg
- Spacing scale: 4/8/12/16/24/32/48
- Shadow presets
- Button variants

Tokens builderde edit edilir, exportda CSS vars kimi oturur.

---

## 12. Media pipeline
- Upload (drag/drop)
- Auto compress (webp optional)
- Alt text required
- Responsive sizes (srcset)
- Assets tag/collection

---

## 13. SEO
- Per-page meta title/desc
- OG tags
- canonical url
- sitemap.xml
- robots.txt
- Schema JSON-LD (FAQ, Article)

---

## 14. Forms
- Contact, Audit, Subscribe
- Validation + anti-spam (honeypot)
- Email + DB storage
- Notifications admin panelde

---

## 15. Performance
- SSR (Blade)
- Cache (route/cache)
- Lazy load images
- Critical CSS optional
- Bundle minify

---

## 16. Security
- Role-based auth
- CSRF, XSS sanitize
- Media upload limits
- Audit log (publish/export)

---

## 17. Testing
- Unit: JSON schema validation
- Integration: export pipeline
- E2E: builder drag/drop + publish
- Visual regression (optional)

---

## 18. Deploy / Handoff
- Export zip + setup guide
- DB migrate + seed instructions
- Env template
- Post-deploy checklist

---

## 19. Roadmap (addim-addim)
**Phase 0 - Hazirliq**
1) Base Laravel template repo yarat
2) UI component library standardlastir
3) Block listesi ve schema finalize et

**Phase 1 - Core builder**
1) Project CRUD
2) Page editor (drag/drop)
3) Block inspector (text/image/spacing)
4) Theme tokens editor
5) Multi-language

**Phase 2 - Publishing**
1) Draft/Publish
2) Preview links
3) Version history

**Phase 3 - Export**
1) Export pipeline
2) DB seed generator
3) Zip packaging

**Phase 4 - Mushteri admin panel**
1) Modules (pages/blog/forms)
2) Media library
3) SEO manager

**Phase 5 - Polish**
1) UX improvements
2) Templates seti
3) Docs + onboarding

---

## 20. Acceptance criteria
- Builderde 1 sayt 60-90 deqiqe icinde yigilir.
- Exportdan sonra sayt problemsiz deploy olunur.
- Admin panelde kontent rahat idare olunur.
- Coxyilli sehifeler korrekt render olunur.
- SEO meta, sitemap, OG tam isleyir.

---

## 21. Riskler ve mitigasiya
- Risk: freeform layout dizayni pozur
  - Mitigasiya: block-based + guardrails
- Risk: exportda data uyghunsuzlugu
  - Mitigasiya: schema validation + tests
- Risk: coxdilli kontent qarishiqligi
  - Mitigasiya: default fallback + validation

---

## 22. Qerarlar (sonra doldurulacaq)
- Builder stack: [React+Vite + Laravel]
- Template repo: [base-laravel-site]
- Export format: [Laravel project zip]
- Languages: [az, en, ru]

## 23. Decision log (tarixce)
- [ ] Stack secimi (React+Vite vs. diger)
- [ ] Export formati (zip + seed vs. repo clone)
- [ ] Diller ve default lang
- [ ] Admin panel icazeleri (mushteri neleri gorecek)
