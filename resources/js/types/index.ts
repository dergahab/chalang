// ════════════════════════════════════════════════════════════════════════════
// GLOBAL TYPES - Shared type definitions for the project
// ════════════════════════════════════════════════════════════════════════════

// ── Base Types ────────────────────────────────────────────────────────────
export type ID = number;

export interface Timestamped {
    created_at?: string;
    updated_at?: string;
}

export interface BaseEntity {
    id: ID;
    [key: string]: unknown;
}

// ── Translations ──────────────────────────────────────────────────
export type Translations = Record<string, string | Record<string, unknown>>;

// ── API Response Types ────────────────────────────────────────────────
export interface ApiResponse<T> {
    data: T;
    meta?: ApiMeta;
}

export interface ApiMeta {
    current_page: number;
    total_pages: number;
    total: number;
    per_page: number;
}

export interface ApiError {
    message: string;
    code?: string;
    field?: string;
}

// ── Pagination ────────────────────────────────────────────────────────────
export interface PaginationParams {
    page?: number;
    per_page?: number;
    sort?: string;
    order?: 'asc' | 'desc';
}

export interface PaginatedResponse<T> extends ApiResponse<T[]> {
    meta: ApiMeta;
}

// ── Form Types ────────────────────────────────────────────────────────────
export interface FormField {
    name: string;
    label: string;
    type: 'text' | 'email' | 'password' | 'textarea' | 'select' | 'checkbox' | 'radio';
    placeholder?: string;
    required?: boolean;
    validation?: string[];
    options?: SelectOption[];
}

export interface SelectOption {
    label: string;
    value: string | number;
}

export interface FormErrors {
    [key: string]: string[];
}

// ── Entity Types ────────────────────────────────────────────────────────────

// Service
export interface ServiceCategory {
    id: ID;
    name: string;
    description?: string;
    icon?: string;
    childs?: ServiceCategory[];
}

export interface Service extends BaseEntity, Timestamped {
    name: string;
    description?: string;
    icon?: string;
    image?: string;
    childs?: Service[];
}

// Portfolio
export interface PortfolioItem extends BaseEntity, Timestamped {
    title: string;
    slug: string;
    description?: string;
    short_description?: string;
    image?: string;
    gif?: string;
    category_id?: ID;
    pcategories?: Category[];
    link?: string;
}

export interface Category extends BaseEntity {
    name: string;
}

// Team
export interface TeamMember extends BaseEntity, Timestamped {
    name: string;
    position?: string;
    image?: string;
    specialties?: string;
    bio?: string;
    linkedin?: string;
}

// Testimonial
export interface Testimonial extends BaseEntity, Timestamped {
    author: string;
    position?: string;
    content: string;
    avatar?: string;
    company?: string;
}

// FAQ
export interface FaqItem extends BaseEntity, Timestamped {
    question: string;
    answer: string;
    order?: number;
}

// Blog
export interface BlogItem extends BaseEntity, Timestamped {
    title: string;
    slug: string;
    content?: string;
    image?: string;
    summary?: string;
    author?: string;
    category_id?: ID;
    tags?: string[];
    created_at?: string;
}

// Partner
export interface Partner extends BaseEntity, Timestamped {
    name: string;
    logo?: string;
    link?: string;
}

// Case Study
export interface CaseStudy extends BaseEntity, Timestamped {
    cover_image?: string;
    kpi_data?: Record<string, unknown>;
    gallery_images?: string[];
    in_main?: boolean;
    sort_order?: number;
    title?: string;
    slug?: string;
    problem?: string;
    solution?: string;
    result?: string;
    category?: string;
}

// Social Media
export interface SocialMedia extends BaseEntity {
    name: string;
    icon: string;
    link: string;
}

// Banner
export interface Banner extends BaseEntity {
    title: string;
    content: string;
    image?: string;
    video?: string;
    video_poster?: string;
    link?: string;
}

// Pricing Plan
export interface PricingPlan extends BaseEntity, Timestamped {
    name: string;
    price: number;
    price_monthly: number;
    price_yearly: number;
    description: string;
    features: string[];
    is_popular: boolean;
    cta_text?: string;
    cta_link?: string;
}

// Step (Process)
export interface Step extends BaseEntity, Timestamped {
    title: string;
    description?: string;
    step?: string;
    icon?: string;
    position: number;
}

// ── UI Types ────────────────────────────────────────────────────────────

// Theme Colors
export interface ThemeColors {
    primary: string;
    secondary: string;
    tertiary: string;
    primary_rgb: string;
    secondary_rgb: string;
    tertiary_rgb: string;
}

export interface ThemeConfig {
    colors: {
        light: ThemeColors;
        dark: ThemeColors;
    };
    font: string;
    font_url: string;
    border_radius: string;
    radii: {
        btn: string;
        card: string;
        input: string;
    };
    smart_bg: boolean;
    glow_intensity: number;
    custom_css: string;
    custom_js: string;
}

// Content Text Map (admin panel)
export type ContentTextMap = Record<string, string | string[] | Record<string, unknown>>;

// ── Locale ────────────────────────────────────────────────────────────
export type Locale = 'az' | 'en' | 'ru';

export const LOCALES: Locale[] = ['az', 'en', 'ru'];

export function isValidLocale(value: string): value is Locale {
    return LOCALES.includes(value as Locale);
}