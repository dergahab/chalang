import React, { useEffect, useRef, useState } from 'react';
import { usePage } from '@inertiajs/react';

interface SearchOverlayProps {
    isOpen: boolean;
    onClose: () => void;
}

export default function SearchOverlay({ isOpen, onClose }: SearchOverlayProps) {
    const { translations } = usePage().props as any;
    const inputRef = useRef<HTMLInputElement>(null);
    const [searchQuery, setSearchQuery] = useState('');

    // Translation helper
    const t = (key: string, defaultVal: string = '') => {
        return translations?.preview?.search?.[key] || defaultVal;
    };

    // Focus input when opened
    useEffect(() => {
        if (isOpen && inputRef.current) {
            setTimeout(() => {
                inputRef.current?.focus();
            }, 100);
        }
    }, [isOpen]);

    // Handle Escape key
    useEffect(() => {
        const handleEsc = (e: KeyboardEvent) => {
            if (e.key === 'Escape') onClose();
        };
        window.addEventListener('keydown', handleEsc);
        return () => window.removeEventListener('keydown', handleEsc);
    }, [onClose]);

    // Prevent body scroll when open
    useEffect(() => {
        if (isOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
        return () => {
            document.body.style.overflow = '';
        };
    }, [isOpen]);

    if (!isOpen) return null;

    return (
        <div
            className={`fixed top-0 left-0 w-full h-full bg-black/70 backdrop-blur-xl z-[2000] flex justify-center items-start pt-[120px] transition-opacity duration-300 ${isOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'}`}
            onClick={(e) => {
                if (e.target === e.currentTarget) onClose();
            }}
            id="search-overlay"
            role="dialog"
            aria-modal="true"
        >
            <div
                className={`w-[90%] max-w-[700px] bg-white dark:bg-[#0b0f19] border border-brand-primary shadow-[0_20px_80px_rgba(0,0,0,0.3)] rounded-3xl overflow-hidden flex flex-col transition-transform duration-400 ease-[cubic-bezier(0.175,0.885,0.32,1.275)] ${isOpen ? 'translate-y-0' : '-translate-y-[30px]'}`}
                onClick={(e) => e.stopPropagation()}
            >
                {/* Header */}
                <div className="flex items-center p-[25px_30px] border-b border-black/10 dark:border-white/10">
                    <svg className="w-[28px] h-[28px] text-brand-secondary mr-[15px] shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        <path d="M19 1l-1.25 2.75L15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z" />
                    </svg>

                    <input
                        ref={inputRef}
                        type="text"
                        className="flex-grow border-none bg-transparent text-[1.4rem] text-[#1a1a2e] dark:text-white outline-none font-semibold ml-[10px] placeholder:text-gray-400 focus:ring-0"
                        placeholder={t('placeholder', 'Search...')}
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                    />

                    <button
                        onClick={onClose}
                        className="bg-transparent border-none font-bold text-gray-500 hover:text-brand-primary cursor-pointer text-[1rem] transition-colors duration-200"
                    >
                        {t('close', 'Close')}
                    </button>
                </div>

                {/* Results Area (Empty state or results) */}
                <div className="p-0 max-h-[400px] overflow-y-auto">
                    {/* Placeholder for results - we can add actual search logic later */}
                    {searchQuery.length > 0 && (
                        <div className="p-8 text-center text-gray-500">
                            {/* Results will appear here */}
                            Searching for: "{searchQuery}"
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
