type ClassDictionary = Record<string, boolean | null | undefined>;
type ClassArray = ClassValue[];
type ClassValue = string | number | boolean | null | undefined | ClassDictionary | ClassArray;

export function clsx(...values: ClassValue[]): string {
    const classes: string[] = [];

    const append = (value: ClassValue): void => {
        if (!value) {
            return;
        }

        if (typeof value === 'string' || typeof value === 'number') {
            classes.push(String(value));
            return;
        }

        if (Array.isArray(value)) {
            value.forEach(append);
            return;
        }

        if (typeof value === 'object') {
            Object.entries(value).forEach(([className, enabled]) => {
                if (enabled) {
                    classes.push(className);
                }
            });
        }
    };

    values.forEach(append);

    return classes.join(' ');
}

export default clsx;
