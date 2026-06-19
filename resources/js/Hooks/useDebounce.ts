import { useState, useEffect, useCallback, useRef } from 'react';

/**
 * Debounce hook - delays value updates
 */
export function useDebounce<T>(value: T, delay: number): T {
    const [debouncedValue, setDebouncedValue] = useState<T>(value);

    useEffect(() => {
        const timer = setTimeout(() => {
            setDebouncedValue(value);
        }, delay);

        return () => {
            clearTimeout(timer);
        };
    }, [value, delay]);

    return debouncedValue;
}

/**
 * Debounced callback
 */
export function useDebouncedCallback<T extends (...args: Parameters<T>) => ReturnType<T>>(
    callback: T,
    delay: number
): T {
    const timeoutRef = useRef<ReturnType<typeof setTimeout> | null>(null);

    const debouncedCallback = useCallback((...args: Parameters<T>) => {
        if (timeoutRef.current) clearTimeout(timeoutRef.current);
        
        timeoutRef.current = setTimeout(() => {
            callback(...args);
        }, delay);
    }, [callback, delay]) as T;

    return debouncedCallback;
}

/**
 * Throttle hook - limits value updates
 */
export function useThrottle<T>(value: T, interval: number): T {
    const [throttledValue, setThrottledValue] = useState<T>(value);
    const lastRan = useRef(Date.now());

    useEffect(() => {
        const now = Date.now();
        if (now >= lastRan.current + interval) {
            setThrottledValue(value);
            lastRan.current = now;
        } else {
            const timer = setTimeout(() => {
                setThrottledValue(value);
                lastRan.current = Date.now();
            }, interval - (now - lastRan.current));

            return () => clearTimeout(timer);
        }
    }, [value, interval]);

    return throttledValue;
}

export default useDebounce;
