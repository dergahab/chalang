/**
 * Marquee — Infinite scrolling text banner.
 * 1:1 match with Blade .infinite-text-container
 *
 * CSS keyframes are defined in app.css (@keyframes infiniteScroll).
 */
interface MarqueeProps {
    text: string;
}

export default function Marquee({ text }: MarqueeProps) {
    const displayText = text || "CHALANG / INNOVATION / BEYOND";

    return (
        <div className="infinite-text-container py-10 bg-black/5 dark:bg-white/5 border-y border-black/10 dark:border-white/10 mb-8 overflow-hidden w-full relative">
            <div className="flex w-max animate-ticker hover:[animation-play-state:paused]">
                <h2 className="text-6xl md:text-8xl font-black text-transparent whitespace-nowrap px-8" 
                    style={{ WebkitTextStroke: '2px var(--brand-primary)', opacity: 0.6 }}>
                    {displayText}
                </h2>
                <h2 className="text-6xl md:text-8xl font-black text-transparent whitespace-nowrap px-8" 
                    style={{ WebkitTextStroke: '2px var(--brand-primary)', opacity: 0.6 }}>
                    {displayText}
                </h2>
                <h2 className="text-6xl md:text-8xl font-black text-transparent whitespace-nowrap px-8" 
                    style={{ WebkitTextStroke: '2px var(--brand-primary)', opacity: 0.6 }}>
                    {displayText}
                </h2>
            </div>
        </div>
    );
}
