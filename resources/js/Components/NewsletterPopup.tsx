/**
 * NewsletterPopup - Email capture modal with localStorage persistence
 * 
 * Shows as a popup after user spends 30 seconds on the page
 * Uses localStorage to prevent showing again if dismissed
 */

import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import type { Translations } from '@/types';

interface NewsletterPopupProps {
    translations: Translations;
    enabled?: boolean; // Admin toggle
    delay?: number; // Seconds before showing
}

export default function NewsletterPopup({ 
    translations, 
    enabled = true,
    delay = 30 
}: NewsletterPopupProps) {
    const [isOpen, setIsOpen] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);
    const [error, setError] = useState('');
    const [email, setEmail] = useState('');
    const [honeypot, setHoneypot] = useState('');

    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    // Check if popup should show
    useEffect(() => {
        if (!enabled) return;
        
        const dismissed = localStorage.getItem('newsletter_dismissed');
        const subscribed = localStorage.getItem('newsletter_subscribed');
        
        if (dismissed || subscribed) return;
        
        const timer = setTimeout(() => {
            setIsOpen(true);
        }, delay * 1000);
        
        return () => clearTimeout(timer);
    }, [enabled, delay]);

    const handleClose = () => {
        setIsOpen(false);
        localStorage.setItem('newsletter_dismissed', 'true');
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        
        if (honeypot) return; // Spam check
        
        if (!email || !email.includes('@')) {
            setError(t('newsletter.error_email', 'Email ünvanı düzgün deyil'));
            return;
        }
        
        setError('');
        setIsSubmitting(true);
        
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            const response = await fetch('/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email,
                    hp: honeypot,
                }),
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            setIsSuccess(true);
            localStorage.setItem('newsletter_subscribed', 'true');
            
            setTimeout(() => {
                setIsOpen(false);
            }, 3000);
            
        } catch (err: unknown) {
            setError(err instanceof Error ? err.message : t('newsletter.error', 'Xəta baş verdi'));
            console.error('Newsletter error:', err);
        } finally {
            setIsSubmitting(false);
        }
    };

    // Don't render if disabled
    if (!enabled) return null;

    return (
        <AnimatePresence>
            {isOpen && (
                <motion.div
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    exit={{ opacity: 0 }}
                    className="newsletter-overlay"
                    onClick={handleClose}
                >
                    <motion.div
                        initial={{ scale: 0.9, opacity: 0 }}
                        animate={{ scale: 1, opacity: 1 }}
                        exit={{ scale: 0.9, opacity: 0 }}
                        className="newsletter-modal"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <button className="newsletter-close" onClick={handleClose}>✕</button>
                        
                        {isSuccess ? (
                            <div className="newsletter-success">
                                <motion.div
                                    initial={{ scale: 0 }}
                                    animate={{ scale: 1 }}
                                    className="success-icon"
                                >✓</motion.div>
                                <h3>{t('newsletter.success', 'Təşəkkürlər!')}</h3>
                                <p>{t('newsletter.success_desc', 'Bizə qoşulduğunuz üçün təşəkkür edirik.')}</p>
                            </div>
                        ) : (
                            <>
                                <div className="newsletter-header">
                                    <h3>{t('newsletter.title', ' Yeniliklərdən xəbərdar olun')}</h3>
                                    <p>{t('newsletter.subtitle', 'Ən son xəbərlər və təkliflər birbaşa emailinzə gəlsin.')}</p>
                                </div>
                                
                                <form onSubmit={handleSubmit} className="newsletter-form">
                                    <div className="newsletter-field">
                                        <input
                                            type="email"
                                            placeholder={t('newsletter.placeholder', 'Email ünvanınız')}
                                            value={email}
                                            onChange={(e) => setEmail(e.target.value)}
                                            required
                                        />
                                        {/* Honeypot field - hidden from users */}
                                        <input
                                            type="text"
                                            name="hp"
                                            value={honeypot}
                                            onChange={(e) => setHoneypot(e.target.value)}
                                            style={{ position: 'absolute', left: -9999, opacity: 0 }}
                                            tabIndex={-1}
                                            autoComplete="off"
                                        />
                                    </div>
                                    
                                    {error && <p className="newsletter-error">{error}</p>}
                                    
                                    <button
                                        type="submit"
                                        disabled={isSubmitting}
                                        className="newsletter-btn"
                                    >
                                        {isSubmitting ? '...' : t('newsletter.btn', 'Qoşul')}
                                    </button>
                                </form>
                                
                                <p className="newsletter-privacy">
                                    {t('newsletter.privacy', 'Məxfiliyinizə təminat verilir. İstənilən vaxt çıxa bilərsiniz.')}
                                </p>
                            </>
                        )}
                    </motion.div>
                </motion.div>
            )}
        </AnimatePresence>
    );
}