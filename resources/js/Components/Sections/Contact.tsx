import { useState, FormEvent, useRef, useEffect } from 'react';
import type { Translations } from '@/types';
import { useToastStore } from '@/store/toastStore';

/**
 * Contact — Contact form section.
 * 1:1 match with Blade .contact-section
 */

interface ContactProps {
    translations?: Translations;
    enabled?: boolean; // Admin toggle to show/hide section
}

interface FormErrors {
    full_name?: string;
    email?: string;
    phone?: string;
    message?: string;
}

export default function Contact({ translations, enabled = true }: ContactProps) {
    // Don't render if disabled
    if (!enabled) return null;

    const formRef = useRef<HTMLFormElement>(null);
    const [form, setForm] = useState({
        full_name: '',
        email: '',
        phone: '',
        message: '',
        type: 'preview',
    });
    const [errors, setErrors] = useState<FormErrors>({});
    const [submitting, setSubmitting] = useState(false);
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState('');
    const addToast = useToastStore((s) => s.addToast);

    // Clear success message after timeout
    useEffect(() => {
        if (success) {
            const timer = setTimeout(() => setSuccess(false), 4000);
            return () => clearTimeout(timer);
        }
    }, [success]);

    // Clear field error on change
    useEffect(() => {
        if (errors.full_name) setErrors(prev => ({ ...prev, full_name: undefined }));
    }, [form.full_name]);
    useEffect(() => {
        if (errors.email) setErrors(prev => ({ ...prev, email: undefined }));
    }, [form.email]);
    useEffect(() => {
        if (errors.phone) setErrors(prev => ({ ...prev, phone: undefined }));
    }, [form.phone]);
    useEffect(() => {
        if (errors.message) setErrors(prev => ({ ...prev, message: undefined }));
    }, [form.message]);

    const t = (key: string, fallback: string): string => {
        const keys = key.split('.');
        let val: any = translations;
        for (const k of keys) {
            val = val?.[k];
        }
        return typeof val === 'string' ? val : fallback;
    };

    const validateForm = (): boolean => {
        const newErrors: FormErrors = {};
        
        // Name validation
        if (!form.full_name.trim()) {
            newErrors.full_name = t('validation.name_required', 'Ad daxil edin');
        } else if (form.full_name.trim().length < 2) {
            newErrors.full_name = t('validation.name_min', 'Ad ən azı 2 simvol olmalıdır');
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!form.email.trim()) {
            newErrors.email = t('validation.email_required', 'Email daxil edin');
        } else if (!emailRegex.test(form.email)) {
            newErrors.email = t('validation.email_invalid', 'Düzgün email ünvanı daxil edin');
        }

        // Phone validation (optional but if provided must be valid)
        if (form.phone.trim()) {
            const phoneRegex = /^[\d\s\+\-\(\)]{7,20}$/;
            if (!phoneRegex.test(form.phone.trim())) {
                newErrors.phone = t('validation.phone_invalid', 'Düzgün telefon nömrəsi daxil edin');
            }
        }

        // Message validation
        if (!form.message.trim()) {
            newErrors.message = t('validation.message_required', 'Mesaj daxil edin');
        } else if (form.message.trim().length < 10) {
            newErrors.message = t('validation.message_min', 'Mesaj ən azı 10 simvol olmalıdır');
        }

        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };

    const handleSubmit = async (e: FormEvent) => {
        e.preventDefault();
        
        // Validate before submit
        if (!validateForm()) {
            // Focus first error field
            const firstError = formRef.current?.querySelector('[class*="error"]') as HTMLElement;
            firstError?.focus();
            return;
        }

        setSubmitting(true);
        setError('');

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const response = await fetch('/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(form),
            });

            if (response.ok) {
                setSuccess(true);
                setForm({ full_name: '', email: '', phone: '', message: '', type: 'preview' });
                setErrors({});
                addToast(t('contact.sent', 'Mesajınız göndərildi!'), 'success');
            } else {
                const data = await response.json().catch(() => ({}));
                const msg = data?.message || t('contact.error', 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin.');
                setError(msg);
                addToast(msg, 'error');
            }
        } catch {
            setError(t('contact.network_error', 'Şəbəkə xətası. İnternet bağlantınızı yoxlayın.'));
        } finally {
            setSubmitting(false);
        }
    };

    const inputClasses = (fieldError?: string) => `
        w-full px-4 py-3.5 rounded-2xl text-sm
        bg-[var(--card-bg)] text-[var(--text-main)]
        border ${fieldError ? 'border-red-400 bg-red-400/5' : 'border-[var(--card-border)]'}
        placeholder:text-[var(--text-sub)] placeholder:opacity-70
        focus:outline-none focus:ring-2 ${fieldError ? 'focus:ring-red-400/30' : 'focus:ring-brand-primary/20'} focus:border-brand-primary
        focus:shadow-[0_0_20px_var(--brand-glow)]
        transition-all duration-300
        disabled:opacity-60 disabled:cursor-not-allowed
    `;

    return (
        <section className="py-20 md:py-28 lg:py-36 max-w-container mx-auto px-4 sm:px-6 lg:px-8" id="contact">
            <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">{t('sec_contact_title', 'Əlaqə')}</h2>

            {error && (
                <div
                    className="text-red-400 text-center mb-4 px-5 py-3 bg-red-400/10 rounded-2xl border border-red-400/30 text-sm"
                    role="alert"
                >
                    {error}
                </div>
            )}

            <form className="flex flex-col gap-5 max-w-lg mx-auto mt-8 md:mt-12" onSubmit={handleSubmit} ref={formRef} noValidate>
                <div className="flex flex-col gap-1">
                    <input
                        type="text"
                        className={inputClasses(errors.full_name)}
                        name="full_name"
                        placeholder={t('ph_name', 'Adınız')}
                        aria-label={t('ph_name', 'Adınız')}
                        value={form.full_name}
                        onChange={(e) => setForm({ ...form, full_name: e.target.value })}
                        required
                        disabled={submitting}
                        aria-invalid={!!errors.full_name}
                        aria-describedby={errors.full_name ? 'full_name_error' : undefined}
                    />
                    {errors.full_name && (
                        <span id="full_name_error" className="text-red-400 text-xs mt-1 pl-1" role="alert">{errors.full_name}</span>
                    )}
                </div>
                <div className="flex flex-col gap-1">
                    <input
                        type="email"
                        className={inputClasses(errors.email)}
                        name="email"
                        placeholder={t('ph_email', 'Email ünvanınız')}
                        aria-label={t('ph_email', 'Email ünvanınız')}
                        value={form.email}
                        onChange={(e) => setForm({ ...form, email: e.target.value })}
                        required
                        disabled={submitting}
                        aria-invalid={!!errors.email}
                        aria-describedby={errors.email ? 'email_error' : undefined}
                    />
                    {errors.email && (
                        <span id="email_error" className="text-red-400 text-xs mt-1 pl-1" role="alert">{errors.email}</span>
                    )}
                </div>
                <div className="flex flex-col gap-1">
                    <input
                        type="tel"
                        className={inputClasses(errors.phone)}
                        name="phone"
                        placeholder={t('ph_phone', 'Telefon nömrəniz')}
                        aria-label={t('ph_phone', 'Telefon nömrəniz')}
                        value={form.phone}
                        onChange={(e) => setForm({ ...form, phone: e.target.value })}
                        disabled={submitting}
                        aria-invalid={!!errors.phone}
                        aria-describedby={errors.phone ? 'phone_error' : undefined}
                    />
                    {errors.phone && (
                        <span id="phone_error" className="text-red-400 text-xs mt-1 pl-1" role="alert">{errors.phone}</span>
                    )}
                </div>
                <div className="flex flex-col gap-1">
                    <textarea
                        className={inputClasses(errors.message)}
                        name="message"
                        placeholder={t('ph_msg', 'Mesajınız')}
                        aria-label={t('ph_msg', 'Mesajınız')}
                        value={form.message}
                        onChange={(e) => setForm({ ...form, message: e.target.value })}
                        required
                        disabled={submitting}
                        aria-invalid={!!errors.message}
                        aria-describedby={errors.message ? 'message_error' : undefined}
                    />
                    {errors.message && (
                        <span id="message_error" className="text-red-400 text-xs mt-1 pl-1" role="alert">{errors.message}</span>
                    )}
                </div>
                <input type="hidden" name="type" value="preview" />
                <button 
                    type="submit" 
                    className={`inline-flex items-center justify-center gap-2 px-8 py-3 rounded-full font-bold text-white bg-brand-gradient hover:-translate-y-1 transition-all duration-300 shadow-lg magnet-btn ${submitting ? 'opacity-70 cursor-not-allowed' : ''}`}
                    disabled={submitting}
                >
                    {submitting
                        ? '⏳'
                        : success
                        ? `✓ ${t('contact.sent', 'Göndərildi!')}`
                        : t('btn_submit', 'Göndər')}
                </button>
            </form>
        </section>
    );
}
