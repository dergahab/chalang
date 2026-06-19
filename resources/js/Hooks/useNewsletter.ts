import { useState, useCallback } from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { newsletterFormSchema, NewsletterFormData, defaultNewsletterForm } from '@/lib/schemas';

interface UseNewsletterOptions {
    onSuccess?: (data: NewsletterFormData) => void;
    onError?: (error: Error) => void;
    endpoint?: string;
}

export function useNewsletter(options?: UseNewsletterOptions) {
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);
    const [error, setError] = useState<Error | null>(null);
    const endpoint = options?.endpoint || '/api/newsletter';

    const {
        register,
        handleSubmit,
        formState: { errors, isValid, isDirty },
        reset,
        watch,
    } = useForm<NewsletterFormData>({
        resolver: zodResolver(newsletterFormSchema),
        defaultValues: defaultNewsletterForm,
        mode: 'onChange',
    });

    const subscribe = useCallback(async (data: NewsletterFormData) => {
        setIsSubmitting(true);
        setError(null);

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error('Abunə olmaq mümkün olmadı. Yeniden cəhd edin.');
            }

            setIsSuccess(true);
            reset();
            options?.onSuccess?.(data);
        } catch (err) {
            const error = err instanceof Error ? err : new Error('Xəta baş verdi');
            setError(error);
            options?.onError?.(error);
        } finally {
            setIsSubmitting(false);
        }
    }, [endpoint, options, reset]);

    return {
        register,
        handleSubmit: handleSubmit(subscribe),
        errors,
        isValid,
        isDirty,
        isSubmitting,
        isSuccess,
        error,
        reset,
        watch,
    };
}

export default useNewsletter;