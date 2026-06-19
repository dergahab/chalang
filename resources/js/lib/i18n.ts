export function createT(translations: Record<string, unknown>) {
    return (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: unknown = translations;
        for (const k of keys) {
            if (typeof value !== 'object' || value === null) return fallback ?? key;
            value = (value as Record<string, unknown>)[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };
}

export function createTArray(translations: Record<string, unknown>) {
    return (key: string): string[] => {
        const keys = key.split('.');
        let value: unknown = translations;
        for (const k of keys) {
            if (typeof value !== 'object' || value === null) return [];
            value = (value as Record<string, unknown>)[k];
        }
        return Array.isArray(value) ? value : [];
    };
}
