## Admin Panel Sitemap (Elite Hierarchy)

- **0. Dashboard**
    - Executive Overview
    - AI "Bilgə" Daily Brief
- **1. Məzmun Hub** (Content Management)
    - Səhifələr (Haqqımızda, Addımlar)
    - Xidmətlər (Siyahı, Məzmun)
    - Bloq (Məqalələr, Kateqoriyalar)
    - Media Library (Centralized)
- **2. Portfel Hub**
    - Layihələr (Portfolio)
    - Case Studies
    - Müştəri Rəyləri (Testimonials)
- **3. Sales & CRM**
    - Leads/Müraciətlər (Submissions)
    - İsmarıclar (Messages)
    - Orders/Sifarişlər (Gated)
    - Demo/Marketplace Packages (Gated)
- **4. Growth & Marketing**
    - Bannerlər
    - Qiymət Planları
    - Tərəfdaşlar
    - Global SEO & Sitemap Tools
- **5. Ops & System Health**
    - Health Status (Cron/Queue)
    - Feature Flags Hub
    - Incident Alerts (Sentry/APM Links)
- **6. Bildiriş Mərkəzi**
    - Bildiriş Tarixçəsi
    - Channel Setup (Slack/TG/WA Bots)
- **7. Security & Access**
    - Visual Activity Log (with Diff)
    - Security Hub (2FA/SSO/IP)
    - Access Reviews
- **8. Sistem Management**
    - Ümumi Tənzimləmələr
    *   İdarəçilər & Rollar
    *   Tərcümələr & Teqlər
    *   Komanda Üzvləri
    *   Şirkət & Əlaqə Məlumatları

## Permission Matrix (Role → Visibility)

| Role | Dashboard | Content | Portfel | CRM | Marketing | Ops | Security | System |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Super-admin** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Admin** | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ✅ | ✅ |
| **Editor** | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ |
| **Analyst** | ✅ | ❌ | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ |
