import React, { useEffect, useState, useRef } from 'react';

interface MetricItem {
    value: string;
    label: string;
    suffix?: string;
}

interface MetricsProps {
    years: MetricItem;
    projects: MetricItem;
    satisfaction: MetricItem;
    awards: MetricItem;
    enabled?: boolean; // Admin toggle to show/hide section
}

const parseNumericValue = (val: string): number => {
    const parsed = parseInt(val.replace(/[^0-9]/g, ''), 10);
    return isNaN(parsed) ? 10 : parsed;
};

const Counter: React.FC<{ target: number; suffix?: string; isVisible: boolean }> = ({ target, suffix = '', isVisible }) => {
    const [count, setCount] = useState(0);

    useEffect(() => {
        if (!isVisible) return;
        
        let startTime: number;
        const duration = 2000; // 2 seconds animation

        const animate = (currentTime: number) => {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            
            // easeOutQuart
            const easeProgress = 1 - Math.pow(1 - progress, 4);
            
            setCount(Math.floor(easeProgress * target));

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        requestAnimationFrame(animate);
    }, [target, isVisible]);

    return (
        <span>
            {count}{suffix}
        </span>
    );
};

export default function Metrics({ years, projects, satisfaction, awards, enabled = true }: MetricsProps) {
    // Don't render if disabled
    if (!enabled) return null;

    const [isVisible, setIsVisible] = useState(false);
    const sectionRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);
                    observer.disconnect();
                }
            },
            { threshold: 0.1 }
        );

        if (sectionRef.current) {
            observer.observe(sectionRef.current);
        }

        return () => observer.disconnect();
    }, []);

    const metricsData = [
        { ...years, suffix: '+', delay: 100 },
        { ...projects, suffix: '+', delay: 200 },
        { ...satisfaction, suffix: '%', delay: 300 },
        { ...awards, suffix: '+', delay: 400 },
    ];

    return (
        <section ref={sectionRef} className="py-20 md:py-28 lg:py-36 flex flex-col items-center w-full mx-auto" id="metrics">
            <div className="w-full max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex flex-wrap justify-center items-center gap-6 w-full mx-auto">
                    {metricsData.map((metric, index) => {
                        const targetVal = parseNumericValue(metric.value);
                        
                        return (
                            <div 
                                key={index} 
                                className="flex-[1_1_260px] min-w-[230px] max-w-[300px] w-full bg-[var(--card-bg)] border border-[var(--card-border)] p-[30px] rounded-2xl text-center shadow-[0_10px_30px_rgba(0,0,0,0.05)]"
                                data-aos="zoom-in"
                                data-aos-delay={`${metric.delay}`}
                                style={{
                                    animation: isVisible ? `fadeInUp 0.6s ease-out forwards ${metric.delay}ms` : 'none',
                                    opacity: isVisible ? 1 : 0,
                                }}
                            >
                                <h3 className="text-5xl font-extrabold text-brand-primary mb-1">
                                    <Counter target={targetVal} suffix={metric.suffix} isVisible={isVisible} />
                                </h3>
                                <p className="text-text-sub font-semibold">
                                    {metric.label}
                                </p>
                            </div>
                        );
                    })}
                </div>
            </div>
            <style dangerouslySetInnerHTML={{__html: `
                @keyframes fadeInUp {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `}} />
        </section>
    );
}
