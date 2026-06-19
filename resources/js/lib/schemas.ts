import { z } from 'zod';

/**
 * Contact Form Validation Schema
 */
export const contactFormSchema = z.object({
    name: z
        .string()
        .min(2, 'Ad minimum 2 simvol olmalıdır')
        .max(100, 'Ad maximum 100 simvol ola bilər'),
    email: z
        .string()
        .email('Düzgün email ünvanı daxil edin')
        .max(255, 'Email maximum 255 simvol ola bilər'),
    phone: z
        .string()
        .optional()
        .refine(
            (val) => !val || /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/.test(val),
            'Düzgün telefon nömrəsi daxil edin'
        ),
    company: z
        .string()
        .max(255, 'Şirkət adı maximum 255 simvol ola bilər')
        .optional(),
    service: z
        .string()
        .optional(),
    budget: z
        .string()
        .optional(),
    message: z
        .string()
        .min(10, 'Mesaj minimum 10 simvol olmalıdır')
        .max(5000, 'Mesaj maximum 5000 simvol ola bilər'),
    agree: z
        .boolean()
        .refine((val) => val === true, 'Məxfilik siyasətinə razılıq verməlisiniz'),
});

export type ContactFormData = z.infer<typeof contactFormSchema>;

/**
 * Newsletter Form Validation Schema
 */
export const newsletterFormSchema = z.object({
    email: z
        .string()
        .email('Düzgün email ünvanı daxil edin')
        .max(255, 'Email maximum 255 simvol ola bilər'),
});

export type NewsletterFormData = z.infer<typeof newsletterFormSchema>;

/**
 * Quote Form Validation Schema
 */
export const quoteFormSchema = z.object({
    name: z
        .string()
        .min(2, 'Ad minimum 2 simvol olmalıdır')
        .max(100, 'Ad maximum 100 simvol ola bilər'),
    email: z
        .string()
        .email('Düzgün email ünvanı daxil edin')
        .max(255, 'Email maximum 255 simvol ola bilər'),
    phone: z
        .string()
        .min(10, 'Telefon nömrəsi daxil edin')
        .max(20, 'Telefon nömrəsi 20 simvoldan çox ola bilməz'),
    company: z
        .string()
        .max(255, 'Şirkət adı maximum 255 simvol ola bilər')
        .optional(),
    service_id: z
        .number()
        .optional(),
    platform: z
        .string()
        .optional(),
    scale: z
        .string()
        .optional(),
    timeline: z
        .string()
        .optional(),
    message: z
        .string()
        .max(5000, 'Mesaj maximum 5000 simvol ola bilər')
        .optional(),
});

export type QuoteFormData = z.infer<typeof quoteFormSchema>;

/**
 * Lead Magnet Form Validation Schema
 */
export const leadMagnetFormSchema = z.object({
    name: z
        .string()
        .min(2, 'Ad minimum 2 simvol olmalıdır')
        .max(100, 'Ad maximum 100 simvol ola bilər'),
    email: z
        .string()
        .email('Düzgün email ünvanı daxil edin')
        .max(255, 'Email maximum 255 simvol ola bilər'),
    company: z
        .string()
        .max(255, 'Şirkət adı maximum 255 simvol ola bilər')
        .optional(),
});

export type LeadMagnetFormData = z.infer<typeof leadMagnetFormSchema>;

/**
 * Login Form Validation Schema
 */
export const loginFormSchema = z.object({
    email: z
        .string()
        .email('Düzgün email ünvanı daxil edin')
        .max(255, 'Email maximum 255 simvol ola bilər'),
    password: z
        .string()
        .min(8, 'Şifrə minimum 8 simvol olmalıdır')
        .max(100, 'Şifrə maximum 100 simvol ola bilər'),
    remember: z.boolean().optional(),
});

export type LoginFormData = z.infer<typeof loginFormSchema>;

/**
 * Register Form Validation Schema
 */
export const registerFormSchema = z.object({
    name: z
        .string()
        .min(2, 'Ad minimum 2 simvol olmalıdır')
        .max(100, 'Ad maximum 100 simvol ola bilər'),
    email: z
        .string()
        .email('Düzgün email ünvanı daxil edin')
        .max(255, 'Email maximum 255 simvol ola bilər'),
    password: z
        .string()
        .min(8, 'Şifrə minimum 8 simvol olmalıdır')
        .max(100, 'Şifrə maximum 100 simvol ola bilər'),
    password_confirmation: z
        .string()
        .min(8, 'Şifrə təsdiqi minimum 8 simvol olmalıdır'),
}).refine((data) => data.password === data.password_confirmation, {
    message: 'Şifrələr uyğun deyil',
    path: ['password_confirmation'],
});

export type RegisterFormData = z.infer<typeof registerFormSchema>;

// Default values
export const defaultContactForm: ContactFormData = {
    name: '',
    email: '',
    phone: '',
    company: '',
    service: '',
    budget: '',
    message: '',
    agree: false,
};

export const defaultNewsletterForm: NewsletterFormData = {
    email: '',
};

export const defaultQuoteForm: QuoteFormData = {
    name: '',
    email: '',
    phone: '',
    company: '',
    service_id: undefined,
    platform: '',
    scale: '',
    timeline: '',
    message: '',
};

export const defaultLeadMagnetForm: LeadMagnetFormData = {
    name: '',
    email: '',
    company: '',
};