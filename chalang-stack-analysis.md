# Chalang — Tech Stack Analizi & İmplementasiya Bələdçisi
**Tarix:** May 2026
**Versiya:** 1.0

---

## 📦 Stack Xülasəsi

| Qat | Texnologiya | Versiya | Qiymət |
|---|---|---|---|
| Framework | Laravel | 11.0 | ✅ Cari stabil |
| Runtime | PHP | 8.2 | ⚠️ 8.3 mövcuddur |
| Bridge | Inertia.js (React adapter) | ^2.3.9 | ✅ React 19 dəstəkli |
| Auth | Laravel Sanctum | 4.0 | ✅ Cari stabil |
| UI | React | 19 | ✅ Cutting-edge |
| Build | Vite | 7 | ✅ Ən sürətli |
| State | Zustand | latest | ✅ Optimal seçim |
| Animasiya | Framer Motion | 12 | ✅ Cari stabil |
| Form | React Hook Form + Zod | latest | ✅ Sənaye standartı |
| Stil | Tailwind CSS | 3.4 | ⚠️ v4 mövcuddur |

---

## ✅ Stack Güclü Tərəfləri

### 1. Laravel 11 + Inertia v2 + React 19 kombinasiyası
Bu üçlük 2026-da **full-stack monolith** üçün ən güclü seçimdir.
- Inertia v2 React 19 Concurrent Mode ilə tam uyğundur
- Server-side routing Laravel tərəfindən, UI React tərəfindən idarə olunur
- Ayrıca REST/GraphQL API yazmaq lazım gəlmir

### 2. Vite 7 + Tailwind 3.4
- HMR (Hot Module Replacement) saniyənin onda biri sürətindədir
- Tailwind JIT modu sıfır-CSS overhead

### 3. Zustand (Redux əvəzinə)
- Bundle ölçüsü Redux-dan ~10x kiçikdir (~8KB vs ~80KB)
- React 19 Concurrent Mode ilə problem yaratmır
- Boilerplate yoxdur

### 4. Framer Motion 12
- React 19 ilə tam uyğun
- `useAnimate` hook ilə scroll-trigger animasiyaları asandır

---

## ⚠️ Potensial Problemlər & Risklər

### Risk 1 — PHP 8.2 (Orta)
```
PHP 8.3 aktiv dəstəkdədir, 8.2 security fixes alır amma yeni xüsusiyyətlər gəlmir.
Laravel 11 PHP 8.3 ilə daha yaxşı performans göstərir (JIT təkmilləşdirmələri).
```
**Tövsiyə:** Növbəti deploy pəncərəsində PHP 8.3-ə yüksəldin. Breaking change yoxdur.

### Risk 2 — Tailwind CSS 3.4 vs v4 (Aşağı)
```
Tailwind v4 (2025 sonu) tamam fərqli arxitekturaya keçib:
- postcss.config.js lazım deyil
- tailwind.config.js əvəzinə CSS @import sistemi
- Yeni `@theme` direktivi
```
**Tövsiyə:** v3.4-də qal, stabil proyekt üçün v4 miqrasiyası risk-reward baxımından erkən. Növbəki böyük refaktorda keç.

### Risk 3 — Inertia + React 19 Server Components (Aşağı)
```
React 19 Server Components (RSC) Inertia-nın arxitekturası ilə
fundamental olaraq uyuşmur — Inertia öz server-rendering yanaşmasını istifadə edir.
RSC istəsən, Next.js-ə keçmək lazım gələr.
```
**Tövsiyə:** Əgər RSC planın yoxdursa, problem yoxdur. Varsa — bu decision-ı erkən ver.

### Risk 4 — React 19 Concurrent Mode + Zustand (Çox Aşağı)
```
Zustand 4.x React 19 ilə tam uyğundur.
`useSyncExternalStore` istifadə edir — Concurrent Mode-safe.
```
**Qiymət:** ✅ Problem yoxdur.

---

## 🔧 UI/UX Problemlərini Stack ilə Həll Etmək

> Öncəki audit hesabatındakı kritik problemlər üçün **bu konkret stack-ə uyğun** kod nümunələri.

---

### Həll 1 — CSS Dark/Light Mode Sistemi (Tailwind)

Audit-də tapılan: Footer dark qalır, form input-ları yox olur, kartlar görünmür.

```js
// tailwind.config.js
module.exports = {
  darkMode: 'class', // 'class' seçin — data-theme ilə deyil
  theme: {
    extend: {
      colors: {
        brand: {
          50:  '#f5f4ff',
          100: '#ede9fe',
          500: '#8b5cf6',
          600: '#7c3aed',
          700: '#6c3eb8',
          900: '#1a0a3d',
        }
      }
    }
  }
}
```

```tsx
// hooks/useTheme.ts
import { create } from 'zustand'
import { persist } from 'zustand/middleware'

interface ThemeStore {
  theme: 'light' | 'dark'
  toggle: () => void
}

export const useTheme = create<ThemeStore>()(
  persist(
    (set, get) => ({
      theme: window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark' : 'light',
      toggle: () => {
        const next = get().theme === 'dark' ? 'light' : 'dark'
        document.documentElement.classList.toggle('dark', next === 'dark')
        set({ theme: next })
      },
    }),
    { name: 'chalang-theme' }
  )
)

// App.tsx — initializasiya
const { theme } = useTheme()
useEffect(() => {
  document.documentElement.classList.toggle('dark', theme === 'dark')
}, [])
```

```tsx
// Kart nümunəsi — dark/light avtomatik
<div className="
  bg-white dark:bg-gray-900
  border border-gray-200 dark:border-gray-700
  rounded-xl shadow-sm dark:shadow-none
  hover:shadow-md dark:hover:border-brand-500
  transition-all duration-200
">
  {/* kart məzmunu */}
</div>
```

---

### Həll 2 — Hero Bölməsi: Sağ Tərəfi Doldurmaq

Audit-də tapılan: Hero sağ tərəfi boşdur, particle efekti sol tərəfə qaranqlıq verir.

```tsx
// components/HeroSection.tsx
import { motion } from 'framer-motion'

export function HeroSection() {
  return (
    <section className="
      min-h-screen grid grid-cols-1 lg:grid-cols-2
      bg-white dark:bg-gray-950
    ">
      {/* Sol — məzmun */}
      <div className="flex flex-col justify-center px-8 lg:px-16 py-20">
        <motion.h1
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-5xl lg:text-6xl font-bold leading-tight
                     text-gray-900 dark:text-white"
        >
          Global{' '}
          <span className="bg-gradient-to-r from-brand-600 to-purple-400
                           bg-clip-text text-transparent">
            İnnovasiya
          </span>
          {' '}Və Süni Zəka
        </motion.h1>

        <motion.p
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.2 }}
          className="mt-6 text-lg text-gray-600 dark:text-gray-400
                     max-w-md leading-relaxed"
        >
          Biznesinizi rəqəmsal gələcəyə aparır, süni intellekt
          həlləri ilə rəqabət üstünlüyü yaradırıq.
        </motion.p>

        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.4 }}
          className="mt-10 flex gap-4"
        >
          <button className="px-8 py-3 bg-brand-700 hover:bg-brand-600
                             text-white font-medium rounded-xl
                             transition-colors duration-200">
            Başla
          </button>
          <button className="px-8 py-3 border border-gray-300
                             dark:border-gray-600 text-gray-700
                             dark:text-gray-300 font-medium rounded-xl
                             hover:bg-gray-50 dark:hover:bg-gray-800
                             transition-colors duration-200">
            Ətraflı bax
          </button>
        </motion.div>
      </div>

      {/* Sağ — vizual (boş deyil!) */}
      <div className="relative hidden lg:flex items-center justify-center
                      bg-gradient-to-br from-brand-50 to-purple-100
                      dark:from-gray-900 dark:to-brand-900/20">
        {/* Mock-up ya 3D element buraya */}
        <HeroMockup />
        {/* Particle-lar yalnız sağda */}
        <ParticleCanvas />
      </div>
    </section>
  )
}
```

---

### Həll 3 — Addım Prosesi: Connector ilə

Audit-də tapılan: Addımlar arasında connector yoxdur, "01" dışındakılar light modeda görünmür.

```tsx
// components/ProcessSteps.tsx
import { motion, useInView } from 'framer-motion'
import { useRef } from 'react'

const steps = [
  { num: '01', title: 'Analiz',      desc: 'Biznesinizi öyrənirik' },
  { num: '02', title: 'Strategiya',  desc: 'Yol xəritəsi hazırlayırıq' },
  { num: '03', title: 'İcra',        desc: 'Həlli tətbiq edirik' },
  { num: '04', title: 'Nəticə',      desc: 'Ölçür, optimallaşdırırıq' },
]

export function ProcessSteps() {
  const ref = useRef(null)
  const inView = useInView(ref, { once: true })

  return (
    <section className="py-24 bg-white dark:bg-gray-950">
      <div className="max-w-6xl mx-auto px-6">
        <h2 className="text-3xl font-bold text-center text-gray-900
                       dark:text-white mb-16">
          Necə işləyirik?
        </h2>

        <div ref={ref} className="relative flex flex-col md:flex-row gap-0">
          {steps.map((step, i) => (
            <div key={step.num} className="relative flex-1 flex flex-col
                                           items-center text-center px-4">
              {/* Connector xətti (son element dışında) */}
              {i < steps.length - 1 && (
                <motion.div
                  initial={{ scaleX: 0 }}
                  animate={inView ? { scaleX: 1 } : {}}
                  transition={{ duration: 0.5, delay: i * 0.2 + 0.3 }}
                  className="hidden md:block absolute top-7 left-1/2
                             w-full h-px bg-brand-200 dark:bg-brand-800
                             origin-left"
                  style={{ left: '50%' }}
                />
              )}

              {/* Nömrə dairəsi */}
              <motion.div
                initial={{ scale: 0, opacity: 0 }}
                animate={inView ? { scale: 1, opacity: 1 } : {}}
                transition={{ duration: 0.4, delay: i * 0.15 }}
                className="relative z-10 w-14 h-14 rounded-full
                           bg-brand-100 dark:bg-brand-900
                           border-2 border-brand-600 dark:border-brand-400
                           flex items-center justify-center
                           text-brand-700 dark:text-brand-300
                           font-bold text-lg mb-4"
              >
                {step.num}
              </motion.div>

              <h3 className="font-semibold text-gray-900 dark:text-white mb-2">
                {step.title}
              </h3>
              <p className="text-sm text-gray-500 dark:text-gray-400
                            leading-relaxed">
                {step.desc}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
```

---

### Həll 4 — Forma: Görünən Input-lar + Zod Validasiya

Audit-də tapılan: Label yoxdur, input border görünmür, CTA qeyri-spesifikdir.

```tsx
// components/ContactForm.tsx
import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import { z } from 'zod'

const schema = z.object({
  name:    z.string().min(2, 'Ad ən az 2 hərf olmalıdır'),
  email:   z.string().email('Düzgün email daxil edin'),
  phone:   z.string().optional(),
  message: z.string().min(10, 'Mesaj ən az 10 hərf olmalıdır'),
  budget:  z.enum(['500-1000', '1000-3000', '3000+']),
})

type FormData = z.infer<typeof schema>

export function ContactForm() {
  const { register, handleSubmit, formState: { errors, isSubmitting } } =
    useForm<FormData>({ resolver: zodResolver(schema) })

  return (
    <section className="py-24 bg-brand-50 dark:bg-gray-900">
      <div className="max-w-2xl mx-auto px-6">
        <h2 className="text-3xl font-bold text-center text-gray-900
                       dark:text-white mb-4">
          Layihənizi bizimlə başladın
        </h2>
        <p className="text-center text-gray-500 dark:text-gray-400 mb-12">
          Formunu doldurun, 24 saat ərzində əlaqə saxlayırıq.
        </p>

        <form onSubmit={handleSubmit(onSubmit)}
              className="bg-white dark:bg-gray-800 rounded-2xl
                         border border-gray-200 dark:border-gray-700
                         p-8 space-y-6">

          {/* Ad */}
          <div>
            <label className="block text-sm font-medium text-gray-700
                               dark:text-gray-300 mb-2">
              Ad Soyad <span className="text-red-500">*</span>
            </label>
            <input
              {...register('name')}
              placeholder="Əli Həsənov"
              className="w-full px-4 py-3 rounded-xl
                         border border-gray-300 dark:border-gray-600
                         bg-white dark:bg-gray-900
                         text-gray-900 dark:text-white
                         placeholder:text-gray-400
                         focus:outline-none focus:ring-2
                         focus:ring-brand-500 focus:border-transparent
                         transition-colors duration-200"
            />
            {errors.name && (
              <p className="mt-1.5 text-sm text-red-600 dark:text-red-400">
                {errors.name.message}
              </p>
            )}
          </div>

          {/* Email */}
          <div>
            <label className="block text-sm font-medium text-gray-700
                               dark:text-gray-300 mb-2">
              Email <span className="text-red-500">*</span>
            </label>
            <input
              {...register('email')}
              type="email"
              placeholder="ali@sirket.az"
              className="w-full px-4 py-3 rounded-xl
                         border border-gray-300 dark:border-gray-600
                         bg-white dark:bg-gray-900
                         text-gray-900 dark:text-white
                         placeholder:text-gray-400
                         focus:outline-none focus:ring-2
                         focus:ring-brand-500 focus:border-transparent
                         transition-colors duration-200"
            />
            {errors.email && (
              <p className="mt-1.5 text-sm text-red-600 dark:text-red-400">
                {errors.email.message}
              </p>
            )}
          </div>

          {/* Büdcə */}
          <div>
            <label className="block text-sm font-medium text-gray-700
                               dark:text-gray-300 mb-2">
              Büdcə aralığı
            </label>
            <select
              {...register('budget')}
              className="w-full px-4 py-3 rounded-xl
                         border border-gray-300 dark:border-gray-600
                         bg-white dark:bg-gray-900
                         text-gray-900 dark:text-white
                         focus:outline-none focus:ring-2
                         focus:ring-brand-500 focus:border-transparent"
            >
              <option value="500-1000">500₼ – 1.000₼</option>
              <option value="1000-3000">1.000₼ – 3.000₼</option>
              <option value="3000+">3.000₼+</option>
            </select>
          </div>

          {/* Mesaj */}
          <div>
            <label className="block text-sm font-medium text-gray-700
                               dark:text-gray-300 mb-2">
              Layihə haqqında <span className="text-red-500">*</span>
            </label>
            <textarea
              {...register('message')}
              rows={4}
              placeholder="Layihənizi qısaca təsvir edin..."
              className="w-full px-4 py-3 rounded-xl
                         border border-gray-300 dark:border-gray-600
                         bg-white dark:bg-gray-900
                         text-gray-900 dark:text-white
                         placeholder:text-gray-400
                         focus:outline-none focus:ring-2
                         focus:ring-brand-500 focus:border-transparent
                         resize-none transition-colors duration-200"
            />
            {errors.message && (
              <p className="mt-1.5 text-sm text-red-600 dark:text-red-400">
                {errors.message.message}
              </p>
            )}
          </div>

          <button
            type="submit"
            disabled={isSubmitting}
            className="w-full py-4 bg-brand-700 hover:bg-brand-600
                       disabled:opacity-60 disabled:cursor-not-allowed
                       text-white font-semibold rounded-xl
                       transition-colors duration-200"
          >
            {isSubmitting ? 'Göndərilir...' : 'Pulsuz məsləhət al →'}
          </button>

          <p className="text-center text-xs text-gray-400 dark:text-gray-500">
            Məlumatlarınız 3-cü şəxslərlə paylaşılmır.
          </p>
        </form>
      </div>
    </section>
  )
}
```

---

### Həll 5 — Pricing: 3 Plan + Toggle

Audit-də tapılan: 2 plan kifayət deyil, toggle kiçik, valyuta ziddiyyəti.

```tsx
// components/PricingSection.tsx
import { useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'

const plans = [
  {
    name: 'Başlanğıc',
    monthly: 499,
    yearly: 399,
    description: 'Kiçik layihələr üçün ideal',
    features: [
      'Vebsayt dizaynı',
      '5 səhifə',
      'Mobil uyğunluq',
      '3 ay dəstək',
      'SEO əsasları',
    ],
    cta: 'Başla',
    popular: false,
  },
  {
    name: 'Peşəkar',
    monthly: 999,
    yearly: 799,
    description: 'Böyüyən bizneslər üçün',
    features: [
      'Xüsusi dizayn sistemi',
      'Limitsiz səhifə',
      'React / Laravel tətbiq',
      '12 ay dəstək',
      'SEO + Analitika',
      'Çoxdilli dəstək',
    ],
    cta: 'Başla',
    popular: true,
  },
  {
    name: 'Korporativ',
    monthly: null, // "Qiymət al" — custom
    yearly: null,
    description: 'Böyük həcmli layihələr',
    features: [
      'Hər şey Peşəkarda',
      'Xüsusi inteqrasiyalar',
      'Ayrıca server',
      'SLA müqaviləsi',
      'Həftəlik hesabat',
      'Prioritet dəstək',
    ],
    cta: 'Əlaqə saxla',
    popular: false,
  },
]

export function PricingSection() {
  const [yearly, setYearly] = useState(false)

  return (
    <section className="py-24 bg-white dark:bg-gray-950">
      <div className="max-w-6xl mx-auto px-6">
        <h2 className="text-3xl font-bold text-center
                       text-gray-900 dark:text-white mb-4">
          Sizə Uyğun Paketi Seçin
        </h2>

        {/* Toggle */}
        <div className="flex items-center justify-center gap-4 mb-16">
          <span className={`text-sm font-medium transition-colors
            ${!yearly ? 'text-gray-900 dark:text-white'
                      : 'text-gray-400 dark:text-gray-500'}`}>
            Aylıq
          </span>

          <button
            onClick={() => setYearly(!yearly)}
            className={`relative w-14 h-7 rounded-full transition-colors
                        duration-300 focus:outline-none focus:ring-2
                        focus:ring-brand-500
              ${yearly ? 'bg-brand-600' : 'bg-gray-200 dark:bg-gray-700'}`}
          >
            <span className={`absolute top-0.5 left-0.5 w-6 h-6
                              rounded-full bg-white shadow-sm
                              transition-transform duration-300
              ${yearly ? 'translate-x-7' : 'translate-x-0'}`}
            />
          </button>

          <span className={`text-sm font-medium transition-colors
            ${yearly ? 'text-gray-900 dark:text-white'
                     : 'text-gray-400 dark:text-gray-500'}`}>
            İllik
            <span className="ml-2 px-2 py-0.5 text-xs bg-green-100
                             dark:bg-green-900 text-green-700
                             dark:text-green-300 rounded-full">
              20% endirim
            </span>
          </span>
        </div>

        {/* Plan kartları */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {plans.map((plan) => (
            <div
              key={plan.name}
              className={`relative rounded-2xl p-8 flex flex-col
                ${plan.popular
                  ? 'bg-brand-700 text-white ring-2 ring-brand-500'
                  : 'bg-white dark:bg-gray-900 border border-gray-200\
                     dark:border-gray-700 text-gray-900 dark:text-white'
                }`}
            >
              {plan.popular && (
                <span className="absolute -top-3 left-1/2 -translate-x-1/2
                                 px-4 py-1 bg-amber-400 text-amber-900
                                 text-xs font-bold rounded-full">
                  Ən Populyar
                </span>
              )}

              <h3 className="text-lg font-semibold mb-1">{plan.name}</h3>
              <p className={`text-sm mb-6
                ${plan.popular ? 'text-brand-200' : 'text-gray-500 dark:text-gray-400'}`}>
                {plan.description}
              </p>

              <div className="mb-8">
                <AnimatePresence mode="wait">
                  {plan.monthly ? (
                    <motion.div
                      key={yearly ? 'yearly' : 'monthly'}
                      initial={{ opacity: 0, y: -10 }}
                      animate={{ opacity: 1, y: 0 }}
                      exit={{ opacity: 0, y: 10 }}
                      transition={{ duration: 0.2 }}
                    >
                      <span className="text-4xl font-bold">
                        {yearly ? plan.yearly : plan.monthly}₼
                      </span>
                      <span className={`text-sm ml-1
                        ${plan.popular ? 'text-brand-200' : 'text-gray-400'}`}>
                        /ay
                      </span>
                    </motion.div>
                  ) : (
                    <span className="text-2xl font-bold">Qiymət al</span>
                  )}
                </AnimatePresence>
              </div>

              <ul className="space-y-3 flex-1 mb-8">
                {plan.features.map((f) => (
                  <li key={f} className="flex items-center gap-2 text-sm">
                    <svg className={`w-4 h-4 flex-shrink-0
                      ${plan.popular ? 'text-brand-200' : 'text-brand-600 dark:text-brand-400'}`}
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round"
                            strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                    {f}
                  </li>
                ))}
              </ul>

              <button className={`w-full py-3 rounded-xl font-semibold
                                  transition-colors duration-200
                ${plan.popular
                  ? 'bg-white text-brand-700 hover:bg-brand-50'
                  : 'bg-brand-700 text-white hover:bg-brand-600'
                }`}>
                {plan.cta}
              </button>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
```

---

### Həll 6 — Stats: Countup Animasiyası

Audit-də tapılan: Rəqəmlər animasiyasız, açıqlama mətni kiçikdir.

```tsx
// components/StatsSection.tsx
import { useEffect, useRef, useState } from 'react'
import { useInView } from 'framer-motion'

function useCountUp(target: number, duration = 2000, inView: boolean) {
  const [count, setCount] = useState(0)

  useEffect(() => {
    if (!inView) return
    let start = 0
    const step = target / (duration / 16)
    const timer = setInterval(() => {
      start += step
      if (start >= target) { setCount(target); clearInterval(timer) }
      else setCount(Math.floor(start))
    }, 16)
    return () => clearInterval(timer)
  }, [inView, target, duration])

  return count
}

const stats = [
  { value: 10,  suffix: '+', label: 'İl Təcrübə',        sub: '2014-dən bəri' },
  { value: 150, suffix: '+', label: 'Tamamlanan Layihə',  sub: '12 ölkədə' },
  { value: 99,  suffix: '%', label: 'Müştəri Məmnuniyyəti', sub: 'NPS skoru' },
  { value: 12,  suffix: '+', label: 'Mükafat',            sub: 'Beynəlxalq' },
]

export function StatsSection() {
  const ref = useRef(null)
  const inView = useInView(ref, { once: true })

  return (
    <section className="py-20 bg-brand-50 dark:bg-gray-900">
      <div ref={ref}
           className="max-w-5xl mx-auto px-6 grid grid-cols-2
                      md:grid-cols-4 gap-8 text-center">
        {stats.map((s) => {
          const count = useCountUp(s.value, 1800, inView)
          return (
            <div key={s.label}>
              <div className="text-4xl lg:text-5xl font-bold
                              text-brand-700 dark:text-brand-400 mb-1">
                {count}{s.suffix}
              </div>
              <div className="text-base font-semibold text-gray-800
                              dark:text-gray-200 mb-0.5">
                {s.label}
              </div>
              <div className="text-sm text-gray-500 dark:text-gray-400">
                {s.sub}
              </div>
            </div>
          )
        })}
      </div>
    </section>
  )
}
```

---

## 🗂 Fayl Strukturu Tövsiyəsi

```
resources/
├── js/
│   ├── components/
│   │   ├── layout/
│   │   │   ├── Navbar.tsx
│   │   │   ├── Footer.tsx          ← light/dark aware
│   │   │   └── ThemeToggle.tsx
│   │   ├── sections/
│   │   │   ├── HeroSection.tsx
│   │   │   ├── ServicesSection.tsx
│   │   │   ├── ProcessSteps.tsx
│   │   │   ├── PricingSection.tsx
│   │   │   ├── StatsSection.tsx
│   │   │   ├── PortfolioSection.tsx
│   │   │   ├── TeamSection.tsx
│   │   │   ├── TestimonialsSection.tsx
│   │   │   ├── BlogSection.tsx
│   │   │   └── ContactForm.tsx
│   │   └── ui/
│   │       ├── Button.tsx
│   │       ├── Card.tsx
│   │       ├── Badge.tsx
│   │       └── Input.tsx
│   ├── hooks/
│   │   ├── useTheme.ts             ← Zustand persist
│   │   ├── useCountUp.ts
│   │   └── useScrollTrigger.ts
│   ├── stores/
│   │   └── themeStore.ts
│   ├── pages/
│   │   └── Home.tsx                ← Inertia page
│   └── app.tsx
```

---

## ⚡ Performans Yoxlaması

```bash
# Lighthouse hədəfləri (production)
Performance:    ≥ 90
Accessibility:  ≥ 95
Best Practices: ≥ 95
SEO:            ≥ 95

# Vite bundle analizi
npm run build -- --report
# ya da:
npx vite-bundle-visualizer
```

```ts
// vite.config.ts — optimizasiya
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({ input: ['resources/js/app.tsx'] }),
    react(),
  ],
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          'react-vendor':  ['react', 'react-dom'],
          'motion':        ['framer-motion'],
          'forms':         ['react-hook-form', 'zod', '@hookform/resolvers'],
          'inertia':       ['@inertiajs/react'],
        },
      },
    },
  },
})
```

---

## 📋 Prioritet İmplementasiya Sırası

| Sıra | Tapşırıq | Stack | Təxmini vaxt |
|---|---|---|---|
| 1 | CSS dark/light sistemi (Tailwind `darkMode: 'class'` + Zustand) | Tailwind + Zustand | 2–3 saat |
| 2 | Hero layout fix (2-col grid, particle sağda) | React + Framer Motion | 3–4 saat |
| 3 | Footer light mode uyğunluğu | Tailwind | 1 saat |
| 4 | Form: label, border, Zod validasiya | RHF + Zod | 2–3 saat |
| 5 | Pricing: 3 plan, toggle animasiyası | React + Framer Motion | 3–4 saat |
| 6 | Process steps: connector + numbered badges | React + Tailwind | 2 saat |
| 7 | Stats: countup animasiyası (scroll trigger) | Framer Motion | 1–2 saat |
| 8 | Portfolio: 4–6 real kart + hover | React + Tailwind | 2–3 saat |
| 9 | Testimoniallar: foto + güclü rəylər | React | 1–2 saat |
| 10 | Blog: cover image + metadata | React | 1–2 saat |

**Cəmi təxmini:** 18–27 saat iş

---

*Sənəd hazırlandı: May 2026 · Chalang Modern Stack v1.0*
