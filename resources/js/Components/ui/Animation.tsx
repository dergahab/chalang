import React from 'react';
import { motion, AnimatePresence, Variants, useInView } from 'framer-motion';

// ── Fade In ────────────────────────────────────────────────────────────────
interface FadeInProps {
    children: React.ReactNode;
    delay?: number;
    duration?: number;
    className?: string;
}

export function FadeIn({ children, delay = 0, duration = 0.4, className }: FadeInProps) {
    return (
        <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration, delay, ease: 'easeOut' }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Fade In Up ────────────────────────────────────────────────────────────────
interface FadeInUpProps {
    children: React.ReactNode;
    delay?: number;
    duration?: number;
    distance?: number;
    className?: string;
}

export function FadeInUp({
    children,
    delay = 0,
    duration = 0.4,
    distance = 20,
    className
}: FadeInUpProps) {
    return (
        <motion.div
            initial={{ opacity: 0, y: distance }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration, delay, ease: 'easeOut' }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Fade In Down ────────────────────────────────────────────────────────────────
interface FadeInDownProps {
    children: React.ReactNode;
    delay?: number;
    duration?: number;
    distance?: number;
    className?: string;
}

export function FadeInDown({
    children,
    delay = 0,
    duration = 0.4,
    distance = -20,
    className
}: FadeInDownProps) {
    return (
        <motion.div
            initial={{ opacity: 0, y: distance }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration, delay, ease: 'easeOut' }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Scale In ────────────────────────────────────────────────────────────────
interface ScaleInProps {
    children: React.ReactNode;
    delay?: number;
    duration?: number;
    className?: string;
}

export function ScaleIn({ children, delay = 0, duration = 0.3, className }: ScaleInProps) {
    return (
        <motion.div
            initial={{ opacity: 0, scale: 0.95 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration, delay, ease: 'easeOut' }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Slide In Right ────────────────────────────────────────────────────────────────
interface SlideInRightProps {
    children: React.ReactNode;
    delay?: number;
    duration?: number;
    distance?: number;
    className?: string;
}

export function SlideInRight({
    children,
    delay = 0,
    duration = 0.4,
    distance = 20,
    className
}: SlideInRightProps) {
    return (
        <motion.div
            initial={{ opacity: 0, x: distance }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration, delay, ease: 'easeOut' }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Slide In Left ────────────────────────────────────────────────────────────────
interface SlideInLeftProps {
    children: React.ReactNode;
    delay?: number;
    duration?: number;
    distance?: number;
    className?: string;
}

export function SlideInLeft({
    children,
    delay = 0,
    duration = 0.4,
    distance = -20,
    className
}: SlideInLeftProps) {
    return (
        <motion.div
            initial={{ opacity: 0, x: distance }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration, delay, ease: 'easeOut' }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Stagger Container (scroll-triggered) ────────────────────────────────────────────────
interface StaggerContainerProps {
    children: React.ReactNode;
    delayChildren?: number;
    staggerChildren?: number;
    className?: string;
    once?: boolean;
}

export function StaggerContainer({
    children,
    delayChildren = 0,
    staggerChildren = 0.08,
    className,
    once = true,
}: StaggerContainerProps) {
    const ref = React.useRef<HTMLDivElement>(null);
    const inView = useInView(ref, { once, margin: '-50px' });
    const variants: Variants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: {
                delayChildren,
                staggerChildren,
            },
        },
    };

    return (
        <motion.div
            ref={ref}
            variants={variants}
            initial="hidden"
            animate={inView ? 'visible' : 'hidden'}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Stagger Item ────────────────────────────────────────────────────────────────
interface StaggerItemProps {
    children: React.ReactNode;
    index?: number;
    className?: string;
}

export function StaggerItem({ children, index = 0, className }: StaggerItemProps) {
    return (
        <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.3, delay: index * 0.1, ease: 'easeOut' }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Magnetic Button (Hover Effect) ────────────────────────────────────────────────
interface MagneticButtonProps {
    children: React.ReactNode;
    className?: string;
    onClick?: () => void;
}

export function MagneticButton({ children, className, onClick }: MagneticButtonProps) {
    return (
        <motion.button
            whileHover={{ scale: 1.02 }}
            whileTap={{ scale: 0.98 }}
            transition={{ type: 'spring', stiffness: 400, damping: 17 }}
            className={className}
            onClick={onClick}
        >
            {children}
        </motion.button>
    );
}

// ── Hover Scale ────────────────────────────────────────────────────────────────
interface HoverScaleProps {
    children: React.ReactNode;
    scale?: number;
    className?: string;
}

export function HoverScale({ children, scale = 1.02, className }: HoverScaleProps) {
    return (
        <motion.div
            whileHover={{ scale }}
            whileTap={{ scale: 0.98 }}
            transition={{ type: 'spring', stiffness: 400, damping: 17 }}
            className={className}
        >
            {children}
        </motion.div>
    );
}

// ── Animated Visibility (with AnimatePresence) ────────────────────────────────
interface AnimatedVisibilityProps {
    show: boolean;
    children: React.ReactNode;
    className?: string;
}

export function AnimatedVisibility({ show, children, className }: AnimatedVisibilityProps) {
    return (
        <AnimatePresence>
            {show && (
                <motion.div
                    initial={{ opacity: 0, scale: 0.95 }}
                    animate={{ opacity: 1, scale: 1 }}
                    exit={{ opacity: 0, scale: 0.95 }}
                    transition={{ duration: 0.2 }}
                    className={className}
                >
                    {children}
                </motion.div>
            )}
        </AnimatePresence>
    );
}
