/**
 * useSectionEnabled — 1:1 port of Blade's $sectionEnabled() helper
 * (preview.blade.php L123-130)
 *
 * Reads admin-controlled toggle from content_text_map:
 *   preview.sections.{sectionId}.enabled
 *
 * Default: true (section is visible unless admin explicitly disables it)
 * Disabled values (case-insensitive, trimmed): "0", "false", "off", "no"
 *
 * Usage:
 *   const isEnabled = useSectionEnabled(contentTextMap);
 *   {isEnabled('metrics') && <Metrics ... />}
 */
export function useSectionEnabled(
    contentTextMap: Record<string, any> = {}
): (sectionId: string, defaultValue?: boolean) => boolean {
    return (sectionId: string, defaultValue: boolean = true): boolean => {
        const key = `preview.sections.${sectionId}.enabled`;
        const raw = contentTextMap[key];

        // If key doesn't exist in map, fall back to default
        if (raw === undefined || raw === null) {
            return defaultValue;
        }

        // Normalize to string
        const value =
            typeof raw === 'string' || typeof raw === 'number' || typeof raw === 'boolean'
                ? String(raw).trim().toLowerCase()
                : '';

        if (value === '') {
            return defaultValue;
        }

        return !['0', 'false', 'off', 'no'].includes(value);
    };
}
