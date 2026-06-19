import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import type { Translations } from '@/types';

interface LeadMagnetProps {
    translations: Translations;
}

export default function LeadMagnet({ translations }: LeadMagnetProps) {
    const [isScanning, setIsScanning] = useState(false);
    const [showSuccess, setShowSuccess] = useState(false);
    const [error, setError] = useState('');
    const [formData, setFormData] = useState({ website: '', mail: '' });

    const t = (key: string, fallback: string) => {
        const keys = key.split('.');
        let val: any = translations;
        for (const k of keys) {
            val = val?.[k];
        }
        return typeof val === 'string' ? val : fallback;
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError('');
        setIsScanning(true);
        
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
                    website: formData.website,
                    mail: formData.mail,
                    type: 'audit',
                }),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            setIsScanning(false);
            setShowSuccess(true);
            setFormData({ website: '', mail: '' });
            setTimeout(() => setShowSuccess(false), 5000);
        } catch (err: unknown) {
            setIsScanning(false);
            setError(err instanceof Error ? err.message : 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin.');
            console.error('LeadMagnet submission error:', err);
        }
    };

    return (
        <section className="lead-magnet-section" style={{ position: 'relative', overflow: 'hidden' }} aria-labelledby="lead-heading">
            {/* Radar Scanning Overlay - 1:1 with Blade */}
            <AnimatePresence>
                {isScanning && (
                    <motion.div 
                        id="audit-scan-overlay" 
                        className="scan-overlay active"
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                    >
                        <div className="scan-content">
                             <div className="scan-radar"></div>
                            <div className="scan-text" style={{ color: '#fff', fontSize: '14px', fontWeight: '500' }}>
                                {t('audit.scanning', 'Analyzing website...')}
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>

            {/* Success Toast - Matches Blade flow */}
            <AnimatePresence>
                {showSuccess && (
                    <motion.div
                        initial={{ opacity: 0, y: 50 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: 50 }}
                        className="scan-overlay active"
                        style={{ background: 'rgba(0,0,0,0.8)' }}
                    >
                        <div className="scan-content">
                            <div className="success-icon" style={{ display: 'flex', opacity: 1, transform: 'scale(1)' }}>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div className="scan-text" style={{ color: '#fff' }}>
                                Qeydə alındı! Nəticə emailinizə göndəriləcək.
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>

            <h2 id="lead-heading" className="magnet-title">
                {t('audit.title', 'Pulsuz vebsayt auditi')}
            </h2>
            <p className="magnet-desc">
                {t('audit.subtitle', 'Saytınızın performansını və SEO vəziyyətini pulsuz yoxlayın.')}
            </p>
            
            {error && (
                <motion.div 
                    initial={{ opacity: 0, y: -10 }}
                    animate={{ opacity: 1, y: 0 }}
                    className="error-message"
                    style={{ 
                        color: '#ff6b6b', 
                        textAlign: 'center', 
                        marginTop: '20px',
                        padding: '10px',
                        background: 'rgba(255, 107, 107, 0.1)',
                        borderRadius: '8px'
                    }}
                >
                    {error}
                </motion.div>
            )}

            <form onSubmit={handleSubmit} className="magnet-form" id="audit-form">
                <input 
                    type="url" 
                    name="website"
                    required 
                    value={formData.website}
                    onChange={(e) => setFormData({ ...formData, website: e.target.value })}
                    placeholder={t('audit.placeholder_url', 'Vebsayt URL')}
                    className="magnet-input"
                    disabled={isScanning}
                />
                <input 
                    type="email" 
                    name="mail"
                    required 
                    value={formData.mail}
                    onChange={(e) => setFormData({ ...formData, mail: e.target.value })}
                    placeholder={t('audit.placeholder_email', 'Email ünvanınız')}
                    className="magnet-input"
                    disabled={isScanning}
                />
                <button 
                    type="submit" 
                    disabled={isScanning}
                    className="magnet-btn"
                >
                    {isScanning ? t('audit.scanning', 'Gözləyin...') : t('audit.btn', 'Auditi başlat')}
                </button>
            </form>
        </section>
    );
}
