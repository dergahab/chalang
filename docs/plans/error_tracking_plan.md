<!-- documented by Codex 2025-12-22 -->
## Error Tracking Plan (P1)

- Alət seçimi: Sentry (və ya Bugsnag) – release tagging və environment filter (prod-only).
- Laravel inteqrasiyası: `sentry/sentry-laravel` paketini əlavə et, `.env`-də `SENTRY_LARAVEL_DSN`, `SENTRY_ENV=production`.
- Sampling: 10–20% trace, bütün exceptions, user context (`id`, `email`), request metadata (IP, UA, trace-id).
- Release adlandırma: Git commit hash və ya `APP_VERSION` env.
- Alertlər: Error rate spike (5xx), form submit xətaları, queue fail artımı – Slack/Email kanalları.
- Privacy: PII maskalama (email/phone truncation), request body redaksiya, IP anonymization.
- Verifikasiya: `php artisan sentry:test` (və ya Bugsnag `bugsnag:test`) ilə deploy sonrası yoxlama.
