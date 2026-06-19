import React, { useEffect, useState } from 'react';
import { motion, useSpring } from 'framer-motion';

export default function CustomCursor() {
    // Only show custom cursor on non-touch devices
    const [isTouchDevice, setIsTouchDevice] = useState(true);
    const [isHovering, setIsHovering] = useState(false);
    const [isMouseDown, setIsMouseDown] = useState(false);
    
    // Use spring physics for smooth following
    const springConfig = { damping: 25, stiffness: 300, mass: 0.5 };
    const cursorX = useSpring(-100, springConfig);
    const cursorY = useSpring(-100, springConfig);
    
    const dotX = useSpring(-100, { damping: 50, stiffness: 500, mass: 0.1 });
    const dotY = useSpring(-100, { damping: 50, stiffness: 500, mass: 0.1 });

    useEffect(() => {
        // Detect touch device
        setIsTouchDevice('ontouchstart' in window || navigator.maxTouchPoints > 0);
        
        if ('ontouchstart' in window || navigator.maxTouchPoints > 0) return;

        const moveCursor = (e: MouseEvent) => {
            cursorX.set(e.clientX - 16); // Center follower (32px / 2)
            cursorY.set(e.clientY - 16);
            dotX.set(e.clientX - 4); // Center dot (8px / 2)
            dotY.set(e.clientY - 4);
        };

        const handleMouseDown = () => setIsMouseDown(true);
        const handleMouseUp = () => setIsMouseDown(false);

        // Detect hover on clickable elements
        const handleMouseOver = (e: MouseEvent) => {
            const target = e.target as HTMLElement;
            const isClickable = 
                target.tagName.toLowerCase() === 'a' ||
                target.tagName.toLowerCase() === 'button' ||
                target.closest('a') ||
                target.closest('button') ||
                target.classList.contains('cursor-pointer') ||
                target.classList.contains('slick-arrow') ||
                target.closest('.slick-arrow') ||
                target.classList.contains('nav-item-dropdown');
                
            setIsHovering(!!isClickable);
        };

        window.addEventListener('mousemove', moveCursor);
        window.addEventListener('mousedown', handleMouseDown);
        window.addEventListener('mouseup', handleMouseUp);
        window.addEventListener('mouseover', handleMouseOver);

        return () => {
            window.removeEventListener('mousemove', moveCursor);
            window.removeEventListener('mousedown', handleMouseDown);
            window.removeEventListener('mouseup', handleMouseUp);
            window.removeEventListener('mouseover', handleMouseOver);
        };
    }, [cursorX, cursorY, dotX, dotY]);

    if (isTouchDevice) return null;

    return (
        <>
            {/* The Outer Follower */}
            <motion.div
                id="cursor-follower"
                className="hidden md:block fixed top-0 left-0 w-8 h-8 rounded-full border border-brand-primary pointer-events-none z-[9999]"
                style={{
                    x: cursorX,
                    y: cursorY,
                }}
                animate={{
                    scale: isHovering ? 1.5 : (isMouseDown ? 0.8 : 1),
                    opacity: isHovering ? 0.5 : 1,
                    backgroundColor: isHovering ? 'rgba(75, 0, 130, 0.1)' : 'transparent'
                }}
                transition={{ duration: 0.15 }}
            />
            
            {/* The Inner Dot */}
            <motion.div
                id="cursor"
                className="hidden md:block fixed top-0 left-0 w-2 h-2 rounded-full bg-brand-primary pointer-events-none z-[10000]"
                style={{
                    x: dotX,
                    y: dotY,
                }}
                animate={{
                    scale: isHovering ? 0 : 1, // dot disappears when hovering, or you can keep it
                }}
                transition={{ duration: 0.1 }}
            />
        </>
    );
}
