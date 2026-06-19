/**
 * MobileStickyCTA — Bottom sticky CTA bar for mobile.
 * 1:1 match with Blade .mobile-sticky-cta
 * Only visible on mobile (< 768px)
 */

interface MobileStickyCTAProps {
    label: string;
    href?: string;
}

const MailIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{ marginRight: 8 }}>
        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
        <polyline points="22,6 12,13 2,6" />
    </svg>
);

export default function MobileStickyCTA({ label, href = '/contact' }: MobileStickyCTAProps) {
    return (
        <div
            className="fixed bottom-0 left-0 right-0 z-[9999] p-4 md:hidden"
            style={{
                background: 'linear-gradient(to top, var(--bg-body) 80%, transparent)',
            }}
        >
            <a
                href={href}
                className="flex items-center justify-center w-full py-3.5 px-6 font-bold text-white text-sm uppercase tracking-wider transition-all duration-300 no-underline"
                style={{
                    background: 'var(--brand-gradient)',
                    borderRadius: 'var(--radius-btn, 12px)',
                    boxShadow: '0 4px 20px var(--brand-glow)',
                }}
            >
                <MailIcon />
                {label}
            </a>
        </div>
    );
}
