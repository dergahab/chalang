<!-- documented by Codex 2025-12-22 -->
## "Book a Call" (Calendly və ya Daxili) Planı

- İnteqrasiya seçimi: 1) Embed Calendly/YouCanBook.me iframe (env-də link), 2) Daxili “call request” formu (submissions).
- Form sahələri: ad/soyad, email, telefon, seçilən zaman slotu (datetime), qeyd (optional).
- Validasiya: ad required, email required email, phone required max50, slot required datetime, honeypot `hp`.
- Anti-spam: `throttle:10,1`, honeypot, opsional captcha (feature flag).
- DB: `submissions` cədvəli `type='call'` və ya ayrı `call_requests`; status (new/confirmed/done).
- Bildiriş: adminə mail + db notification (queue); success mesajı istifadəçiyə.
- UI: Frontda call booking bloku (CTA), modal və ya ayrıca səhifə; slot seçimi üçün embed olunan calendly və ya sadə datetime picker.
- Feature flag: `FEATURE_BOOK_A_CALL` (config/features.php) ilə göstər/gizlə.
