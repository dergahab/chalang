import React, { useRef, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import type { Translations } from '@/types';

interface Banner {
    id: number;
    title: string;
    content: string;
    image?: string;
    video?: string;
    video_poster?: string;
    [key: string]: unknown;
}

interface HeroProps {
    banner: Banner | null;
    translations: Translations;
    onOpenQuote?: () => void;
}

export default function Hero({ banner, translations, onOpenQuote }: HeroProps) {
    const canvasRef = useRef<HTMLCanvasElement>(null);
    const heroRef = useRef<HTMLElement>(null);

    // Dili və tərcüməni oxuyan lokalizasiya köməkçisi (translation helper)
    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    const bannerTitle = banner?.title || '';
    const bannerDesc = banner?.content || '';
    let showreelUrl = t('hero.showreel_url', '');
    // Əgər URL yoxdursa və ya default key formunda qalıbsa
    if (!showreelUrl || showreelUrl === 'hero.showreel_url') {
        showreelUrl = '#portfolio';
    }

    // Kətan (Canvas) Animasiyası Effect-i
    useEffect(() => {
        const canvas = canvasRef.current;
        const heroSection = heroRef.current;
        
        if (!canvas || !heroSection) return;
        
        // Hərəkət təhlükəsizliyi yoxlaması - Əgər istifadəçi azaldılmış hərəkət istəyirsə animasiyanı yükləmirik
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) return;

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        // ── Theme-aware colors (reads CSS variables from ThemeProvider) ──
        // Fallback values match Blade defaults (preview.css / dynamic-styles.blade.php)
        const rootStyles = getComputedStyle(document.documentElement);
        const brandPrimary =
            rootStyles.getPropertyValue('--brand-primary').trim() || '#4b0082';
        const brandSecondary =
            rootStyles.getPropertyValue('--brand-secondary').trim() || '#d500f9';
        const brandPrimaryRgb =
            rootStyles.getPropertyValue('--brand-primary-rgb').trim() || '75, 0, 130';
        const brandSecondaryRgb =
            rootStyles.getPropertyValue('--brand-secondary-rgb').trim() || '213, 0, 249';

        // eslint-disable-next-line @typescript-eslint/naming-convention
        class Particle {
            x: number;
            y: number;
            baseX: number;
            baseY: number;
            isStar: boolean;
            size: number;
            density: number;
            color: string;
            alpha: number;
            angle: number;

            constructor(x: number, y: number, isStar: boolean) {
                // @ts-ignore
                this.x = Math.random() * canvas.width;
                // @ts-ignore
                this.y = Math.random() * canvas.height;
                this.baseX = x;
                this.baseY = y;
                this.isStar = isStar;
                this.size = isStar ? 1.5 : 2;
                this.density = (Math.random() * 30) + 1;
                this.color = isStar ? brandSecondary : brandPrimary;
                this.alpha = 0;
                this.angle = Math.random() * 360;
            }
            update(mouseX: number | null, mouseY: number | null, mouseRadius: number) {
                const dx = (mouseX ?? this.x) - this.x;
                const dy = (mouseY ?? this.y) - this.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                const forceDirectionX = distance ? dx / distance : 0;
                const forceDirectionY = distance ? dy / distance : 0;
                const force = (mouseRadius - distance) / mouseRadius;
                const directionX = forceDirectionX * force * this.density;
                const directionY = forceDirectionY * force * this.density;
                
                if (distance < mouseRadius) {
                    this.x -= directionX;
                    this.y -= directionY;
                    this.alpha = 1;
                } else {
                    if (this.x !== this.baseX) {
                        this.x -= (this.x - this.baseX) / 20;
                    }
                    if (this.y !== this.baseY) {
                        this.y -= (this.y - this.baseY) / 20;
                    }
                    this.x += Math.sin(this.angle) * 0.1;
                    this.y += Math.cos(this.angle) * 0.1;
                    this.angle += 0.05;
                    if (this.alpha < 1) this.alpha += 0.02;
                }
            }
            draw() {
                if (!ctx) return;
                ctx.globalAlpha = this.alpha;
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.closePath();
                ctx.fill();
                ctx.globalAlpha = 1;
            }
        }

        // eslint-disable-next-line @typescript-eslint/naming-convention
        class AmbientParticle {
            x: number;
            y: number;
            size: number;
            speedX: number;
            speedY: number;
            color: string;

            constructor() {
                // @ts-ignore
                this.x = Math.random() * canvas.width;
                // @ts-ignore
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 0.5;
                this.speedX = (Math.random() * 0.5) - 0.25;
                this.speedY = (Math.random() * 0.5) - 0.25;
                this.color =
                    Math.random() > 0.5
                        ? `rgba(${brandPrimaryRgb}, 0.2)`
                        : `rgba(${brandSecondaryRgb}, 0.2)`;
            }
            update() {
                // @ts-ignore
                this.x += this.speedX;
                // @ts-ignore
                this.y += this.speedY;
                // @ts-ignore
                if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                // @ts-ignore
                if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
            }
            draw() {
                if (!ctx) return;
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        let particlesArray: Particle[] = [];
        let ambientParticlesArray: AmbientParticle[] = [];
        const mouse = { x: null as number | null, y: null as number | null, radius: 150 };
        let animationFrameId: number;
        let frameCount = 0; // connect() optimallaşdırması üçün frame sayğacı
        const MAX_PARTICLES = 1200; // Particle sayı limiti — optimallaşdırılmış connect() sayəsində artırıldı

        const handleMouseMove = (event: MouseEvent) => {
            const rect = canvas.getBoundingClientRect();
            mouse.x = event.clientX - rect.left;
            mouse.y = event.clientY - rect.top;
        };

        const handleMouseLeave = () => {
            mouse.x = null;
            mouse.y = null;
        };

        heroSection.addEventListener('mousemove', handleMouseMove);
        heroSection.addEventListener('mouseleave', handleMouseLeave);

        function resizeCanvas() {
            const container = canvas?.parentElement;
            if (!container || !canvas) return;
            canvas.width = container.clientWidth;
            canvas.height = container.clientHeight;
        }

        function initLogoMap() {
            if (!canvas || !ctx) return;
            if (canvas.width <= 0 || canvas.height <= 0) return;
            particlesArray = [];
            ambientParticlesArray = [];
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            const scale = Math.min(canvas.width, canvas.height) / 22;
            const offsetX = (canvas.width - (16.44 * scale)) / 2;
            const offsetY = (canvas.height - (15.74 * scale)) / 2;
            
            // Legacy layihədən logo path-ləri
            const path1 = new Path2D('M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34,1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z');
            const path2 = new Path2D('M8.23,13.3l.19.37c.14.28.36.5.64.64l.37.19s.01.02,0,.03l-.37.19c-.28.14-.5.36-.64.64l-.19.37s-.02.01-.03,0l-.19-.37c-.14-.28-.36-.5-.64-.64l-.37-.19s-.01-.02,0-.03l.37-.19c.28-.14.5-.36.64-.64l.19-.37s.02-.01.03,0Z');
            
            ctx.save();
            ctx.translate(offsetX, offsetY);
            ctx.scale(scale, scale);
            ctx.fillStyle = 'white';
            ctx.fill(path1);
            ctx.restore();
            
            let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            // Orijinal 6px step ilə bütün loqo nöqtələrini tap
            const logoPoints: {x: number; y: number}[] = [];
            for (let y = 0; y < canvas.height; y += 6) {
                for (let x = 0; x < canvas.width; x += 6) {
                    if (imageData.data[(y * 4 * imageData.width) + (x * 4) + 3] > 128) {
                        logoPoints.push({x, y});
                    }
                }
            }
            // Performans limiti — artıq nöqtələri random sample et, loqo forması qorunsun
            const logoBudget = Math.floor(MAX_PARTICLES * 0.85);
            if (logoPoints.length > logoBudget) {
                // Fisher-Yates shuffle ilə random seç
                for (let i = logoPoints.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [logoPoints[i], logoPoints[j]] = [logoPoints[j], logoPoints[i]];
                }
                logoPoints.length = logoBudget;
            }
            for (const pt of logoPoints) {
                particlesArray.push(new Particle(pt.x, pt.y, false));
            }
            
            ctx.save();
            ctx.translate(offsetX, offsetY);
            ctx.scale(scale, scale);
            ctx.fillStyle = 'white';
            ctx.fill(path2);
            ctx.restore();
            
            imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            // Orijinal 3px step ilə star nöqtələrini tap
            const starPoints: {x: number; y: number}[] = [];
            for (let y = 0; y < canvas.height; y += 3) {
                for (let x = 0; x < canvas.width; x += 3) {
                    if (imageData.data[(y * 4 * imageData.width) + (x * 4) + 3] > 128) {
                        starPoints.push({x, y});
                    }
                }
            }
            const starBudget = MAX_PARTICLES - particlesArray.length;
            if (starPoints.length > starBudget) {
                for (let i = starPoints.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [starPoints[i], starPoints[j]] = [starPoints[j], starPoints[i]];
                }
                starPoints.length = starBudget;
            }
            for (const pt of starPoints) {
                particlesArray.push(new Particle(pt.x, pt.y, true));
            }
            
            // Ambient particle sayını da limitlə
            const ambientCount = Math.min(40, Math.max(15, Math.floor(canvas.width / 50)));
            for (let i = 0; i < ambientCount; i++) ambientParticlesArray.push(new AmbientParticle());
        }

        function connect() {
            if (!ctx) return;
            
            const cellSize = 30;
            const grid: { [key: string]: Particle[] } = {};
            const length = particlesArray.length;
            
            // 1. Group particles into grid cells (only logo/star particles that are checked)
            for (let i = 0; i < length; i++) {
                const p = particlesArray[i];
                if (!p.isStar && i % 3 !== 0) continue;
                
                const cx = Math.floor(p.x / cellSize);
                const cy = Math.floor(p.y / cellSize);
                const key = `${cx},${cy}`;
                if (!grid[key]) {
                    grid[key] = [];
                }
                grid[key].push(p);
            }
            
            // 2. Draw lines between particles in same/neighboring cells
            for (let i = 0; i < length; i++) {
                const pA = particlesArray[i];
                if (!pA.isStar && i % 3 !== 0) continue;
                
                const cx = Math.floor(pA.x / cellSize);
                const cy = Math.floor(pA.y / cellSize);
                const connectDist = pA.isStar ? 400 : 600;
                
                for (let dx = -1; dx <= 1; dx++) {
                    for (let dy = -1; dy <= 1; dy++) {
                        const cell = grid[`${cx + dx},${cy + dy}`];
                        if (!cell) continue;
                        
                        const cellLength = cell.length;
                        for (let j = 0; j < cellLength; j++) {
                            const pB = cell[j];
                            if (pA === pB) continue;
                            
                            // Prevent duplicate lines by comparing stable base coordinates
                            if (pA.baseX > pB.baseX || (pA.baseX === pB.baseX && pA.baseY >= pB.baseY)) continue;
                            
                            const distDx = pA.x - pB.x;
                            const distDy = pA.y - pB.y;
                            const distance = distDx * distDx + distDy * distDy;
                            
                            if (distance < connectDist) {
                                ctx.globalAlpha = pA.alpha * (pA.isStar ? 0.6 : 0.3);
                                ctx.strokeStyle = pA.isStar ? 'rgba(213, 0, 249, 0.5)' : 'rgba(75, 0, 130, 0.4)';
                                ctx.lineWidth = 0.8;
                                ctx.beginPath();
                                ctx.moveTo(pA.x, pA.y);
                                ctx.lineTo(pB.x, pB.y);
                                ctx.stroke();
                                ctx.globalAlpha = 1;
                            }
                        }
                    }
                }
            }
            
            // 3. Ambient connections (checked every 15th particle)
            const ambientLength = ambientParticlesArray.length;
            for (let i = 0; i < ambientLength; i++) {
                for (let j = 0; j < length; j += 15) {
                    const dx = ambientParticlesArray[i].x - particlesArray[j].x;
                    const dy = ambientParticlesArray[i].y - particlesArray[j].y;
                    const dist = dx * dx + dy * dy;
                    
                    if (dist < 3000) {
                        ctx.strokeStyle = 'rgba(213, 0, 249, 0.1)';
                        ctx.lineWidth = 0.2;
                        ctx.beginPath();
                        ctx.moveTo(ambientParticlesArray[i].x, ambientParticlesArray[i].y);
                        ctx.lineTo(particlesArray[j].x, particlesArray[j].y);
                        ctx.stroke();
                    }
                }
            }
        }

        function animate() {
            animationFrameId = requestAnimationFrame(animate);
            if (!canvas || !ctx) return;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            for (let i = 0; i < particlesArray.length; i++) {
                particlesArray[i].update(mouse.x, mouse.y, mouse.radius);
                particlesArray[i].draw();
            }
            for (let i = 0; i < ambientParticlesArray.length; i++) {
                ambientParticlesArray[i].update();
                ambientParticlesArray[i].draw();
            }
            // connect() ağır O(n²) əməliyyatdır — hər 2-ci frame-də çağır
            frameCount++;
            if (frameCount % 2 === 0) {
                connect();
            }
        }

        // Resize debounce — debounce olmadan hər resize hadisəsində tam recalculate olurdu
        let resizeTimer: ReturnType<typeof setTimeout>;
        const handleResize = () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                resizeCanvas();
                initLogoMap();
            }, 250);
        };

        window.addEventListener('resize', handleResize);
        
        // Initial setup with a slight delay to ensure container is fully sized before particle calculation
        const initTimeout = setTimeout(() => {
            resizeCanvas();
            initLogoMap();
            animate();
        }, 50);

        // CLEANUP FUNCTION: Memory leak qarşısının alınması
        return () => {
            window.removeEventListener('resize', handleResize);
            heroSection.removeEventListener('mousemove', handleMouseMove);
            heroSection.removeEventListener('mouseleave', handleMouseLeave);
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
            }
            clearTimeout(initTimeout);
            clearTimeout(resizeTimer);
        };
    }, []);

    // Tərcümədən oxu, yalnız fallback olaraq banner datasından istifadə et
    // Legacy davranış: data-lang="hero_title" attributu JS tərəfindən translations ilə override olunurdu
    const heroTitle = t('hero.title', '');
    const heroDesc = t('hero.desc', '');

    // XSS protection: yalnız icazəli tagları saxla (Blade-dəki admin data-sı üçün)
    const sanitizeHtml = (html: string): string => {
        const allowedTags = ['br', 'strong', 'em', 'span', 'b', 'i'];
        const tagPattern = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
        return html.replace(tagPattern, (match, tag) => {
            return allowedTags.includes(tag.toLowerCase()) ? match : '';
        });
    };

    const TitleHtml = sanitizeHtml(heroTitle || (banner?.title || 'Chalang'));
    const DescHtml = sanitizeHtml(heroDesc || (banner?.content || ''));

    return (
        <section ref={heroRef} className="relative min-h-screen overflow-hidden flex items-center py-20 md:py-28 lg:py-36 bg-transparent">
            <div className="relative z-10 w-full max-w-container mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                {/* Sol Sütun: Məzmun */}
                <div className="flex-1 w-full text-left relative z-20">
                <div 
                    className="text-brand-secondary font-bold uppercase tracking-wider mb-4"
                    data-aos="fade-down"
                    data-aos-delay="100"
                >
                    {t('hero.kicker', 'GLOBAL INNOVATION & AI')}
                </div>
                
                <h1 
                    className="text-[clamp(2.5rem,8vw,4.5rem)] font-extrabold leading-[1.1] text-text-main"
                    data-aos="fade-right" 
                    data-aos-delay="200"
                    dangerouslySetInnerHTML={{ __html: TitleHtml }} 
                />
                
                <p 
                    className="text-lg md:text-xl text-text-sub max-w-2xl"
                    data-aos="fade-right" 
                    data-aos-delay="300"
                    dangerouslySetInnerHTML={{ __html: DescHtml }} 
                />
                
                <div className="flex flex-wrap gap-4 mt-8" data-aos="fade-up" data-aos-delay="400">
                    {onOpenQuote ? (
                        <button
                            onClick={onOpenQuote}
                            className="magnet-btn inline-flex items-center justify-center gap-2 px-8 h-[52px] rounded-full font-bold text-white bg-gradient-to-r from-[var(--brand-primary)] to-[var(--brand-secondary)] hover:scale-105 transition-all duration-300 shadow-[0_0_20px_rgba(var(--brand-primary-rgb),0.4)] hover:shadow-[0_0_30px_rgba(var(--brand-secondary-rgb),0.6)] min-w-[160px]"
                        >
                            {t('btn_start', 'Start')}
                        </button>
                    ) : (
                        <Link href="/preview/contact" className="magnet-btn inline-flex items-center justify-center gap-2 px-8 h-[52px] rounded-full font-bold text-white bg-gradient-to-r from-[var(--brand-primary)] to-[var(--brand-secondary)] hover:scale-105 transition-all duration-300 shadow-[0_0_20px_rgba(var(--brand-primary-rgb),0.4)] hover:shadow-[0_0_30px_rgba(var(--brand-secondary-rgb),0.6)] min-w-[160px]">
                            {t('btn_start', 'Start')}
                        </Link>
                    )}
                    <a href="/preview/portfolio" className="inline-flex items-center justify-center gap-2 px-8 h-[52px] rounded-full font-bold text-text-main dark:text-white border-2 border-white/20 dark:border-white/20 hover:border-brand-primary hover:bg-brand-primary/10 backdrop-blur-md transition-all duration-300">
                        {t('btn_works', 'Our Work')}
                    </a>
                    <a 
                        href={showreelUrl} 
                        className="inline-flex items-center justify-center gap-2 px-8 h-[52px] rounded-full font-bold text-text-main dark:text-white border-2 border-white/20 dark:border-white/20 hover:border-brand-primary hover:bg-brand-primary/10 backdrop-blur-md transition-all duration-300"
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 5v14l11-7z" />
                        </svg> 
                        <span>{t('btn_showreel', 'Showreel')}</span>
                    </a>
                </div>
                </div>
                
                {/* Sağ Sütun: Canvas Particle Logo */}
                <div className="flex-1 w-full relative min-h-[400px] lg:min-h-[600px] flex justify-center items-center">
                    {/* Canvas Container */}
                    <div className="absolute inset-0 z-0 overflow-hidden rounded-[40px] opacity-100 dark:opacity-60 pointer-events-none">
                        <canvas ref={canvasRef} id="hero-canvas" className="w-full h-full object-cover"></canvas>
                    </div>
                </div>
            </div>

            {/* Video Background Fallback (if any) */}
            <div className="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                {/* Video Background - prioritizes over canvas if available */}
                {banner?.video && (
                    <video
                        className="absolute inset-0 w-full h-full object-cover z-0 opacity-60"
                        autoPlay
                        muted
                        loop
                        playsInline
                        poster={banner.video_poster ? `/storage/${banner.video_poster}` : undefined}
                    >
                        <source src={banner.video.startsWith('http') ? banner.video : `/storage/${banner.video}`} type="video/mp4" />
                    </video>
                )}
            </div>
            <style>{`
                .hero h1 span {
                    background: var(--brand-gradient);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
            `}</style>
        </section>
    );
}
