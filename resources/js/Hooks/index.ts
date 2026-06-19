// Shared Hooks - Reusable hooks for the project
export { useLocalStorage, useSessionStorage } from './useLocalStorage';
export { useMediaQuery, useIsMobile, useIsTablet, useIsDesktop, useIsDarkMode, usePrefersReducedMotion } from './useMediaQuery';
export { useDebounce, useDebouncedCallback, useThrottle } from './useDebounce';
export { useContactForm } from './useContactForm';
export { useNewsletter } from './useNewsletter';

// Re-export existing hooks
export { useTheme } from './useTheme';
export { useScrollAnimation } from './useScrollAnimation';
export { useSectionEnabled } from './useSectionEnabled';
export { useMagneticHover } from './useMagneticHover';