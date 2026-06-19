<!-- documented by Codex 2025-12-22 -->
## Performance Büdceləri və Alertləri (MVP)

- LCP: ≤ 2.5s (desktop), ≤ 3.0s (mobile), ölçü: Google Analytics custom event və/lə ya Lighthouse CI.
- CLS: ≤ 0.1 – əsas layoutlarda font/preload, media ölçüləri fixed.
- TTI/INP: ≤ 200ms interaktiv gecikmə, uzun task monitorinqi (PerformanceObserver).
- Asset ölçüsü: İlk yüklənən CSS/JS ≤ 300KB gzipped; şəkillərdə WebP/AVIF prioritet.
- Keş: HTML no-cache, statik fayllar 1 il immutable, critical CSS/JS split (core + page-specific).
- Alertlər: LCP/CLS/INP göstəriciləri 75-ci percentildə hədəfi keçərsə, səhər raportu (GA4/Cloudflare Web Analytics).
- CI yoxlaması: `npm run build && npm run lint` + Lighthouse/Percy vizual regressiya planı.
