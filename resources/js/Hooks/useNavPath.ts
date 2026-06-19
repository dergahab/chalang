import { useMemo } from 'react';
import { usePage } from '@inertiajs/react';

/**
 * useNavPath Hook
 * 
 * Converts `/preview/*` routes to `/react-test/*` when on `/react-test`
 * Converts `/preview/*` routes to `/*` when on root routes
 * 
 * Usage:
 *   const href = useNavPath('/preview/about-us')
 *   // If on /react-test: returns '/react-test/about-us'
 *   // If on root: returns '/about-us'
 */
export function useNavPath(path: string): string {
    const { url } = usePage();

    return useMemo(() => {
        // If path doesn't contain /preview, return as-is
        if (!path.includes('/preview')) {
            return path;
        }

        // If we're on /react-test pages, convert /preview/* to /react-test/*
        if (url.startsWith('/react-test') || url === '/') {
            // Replace /preview with nothing for root routes
            if (url === '/' || url.startsWith('/') && !url.startsWith('/preview')) {
                return path.replace('/preview', '');
            }
            // Replace /preview with /react-test for /react-test pages
            return path.replace('/preview', '/react-test');
        }

        // Default: keep as-is (for /preview routes, use /preview/* paths)
        return path;
    }, [url, path]);
}
