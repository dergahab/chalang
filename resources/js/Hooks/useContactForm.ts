import { useState, useCallback } from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { contactFormSchema, ContactFormData, defaultContactForm } from '@/lib/schemas';

interface UseContactFormOptions {
    onSuccess?: (data: ContactFormData) => void;
    onError?: (error: Error) => void;
}

export function useContactForm(options?: UseContactFormOptions) {
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);
    const [error, setError] = useState<Error | null>(null);

    const {
        register,
        handleSubmit,
        formState: { errors, isValid, isDirty },
        reset,
        setValue,
        watch,
    } = useForm<ContactFormData>({
        resolver: zodResolver(contactFormSchema),
        defaultValues: defaultContactForm,
        mode: 'onChange',
    });

    const submit = useCallback(async (data: ContactFormData) => {
        setIsSubmitting(true);
        setError(null);

        try {
            const response = await fetch('/api/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error('Mesaj göndərilmədi. Yeniden cəhd edin.');
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
    }, [options, reset]);

    return {
        register,
        handleSubmit: handleSubmit(submit),
        errors,
        isValid,
        isDirty,
        isSubmitting,
        isSuccess,
        error,
        reset,
        setValue,
        watch,
    };
}

export default useContactForm;