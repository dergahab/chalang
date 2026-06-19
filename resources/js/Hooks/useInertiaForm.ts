import React from 'react';
import { useForm, UseFormProps } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import { Inertia } from '@inertiajs/inertia';

/**
 * Inertia-aware form hook with Zod validation, CSRF, and honeypot support.
 * 
 * @example
 * const schema = z.object({
 *   name: z.string().min(1, 'Name is required'),
 *   email: z.string().email('Invalid email'),
 * });
 * 
 * const form = useInertiaForm(schema, {
 *   route: '/contact',
 *   method: 'post',
 * });
 */
export function useInertiaForm<T extends z.ZodType>(
  schema: T,
  options: UseInertiaFormOptions<T>
) {
  const form = useForm<z.infer<T>>({
    resolver: zodResolver(schema),
    mode: 'onBlur',
    ...options.formOptions,
  });

  const { handleSubmit, setError, reset } = form;

  const onSubmit = handleSubmit(async (data) => {
    // Honeypot spam check
    const honeypot = document.querySelector<HTMLInputElement>('[name="hp"]')?.value;
    if (honeypot) {
      // Fake success for bots
      return;
    }

    const isSubmitting = options.onSubmitStart?.() ?? (() => {});
    isSubmitting();

    try {
      await new Promise<void>((resolve, reject) => {
        Inertia.post(
          options.route,
          { ...data, _token: getCsrfToken() },
          {
            method: options.method as 'post' | 'put' | 'patch' | 'delete',
            onSuccess: () => {
              options.onSuccess?.();
              resolve();
            },
            onError: (errors: Record<string, string>) => {
              // Map Inertia errors to react-hook-form
              Object.entries(errors).forEach(([field, message]) => {
                setError(field as any, { message }, { shouldFocus: true });
              });
              options.onError?.(errors);
              reject(new Error('Validation failed'));
            },
            onFinish: () => {
              options.onFinish?.();
            },
          }
        );
      });
    } catch (error) {
      options.onCatch?.(error as Error);
    }
  });

  return {
    ...form,
    onSubmit,
  };
}

/**
 * Get CSRF token from meta tag or cookie
 */
export function getCsrfToken(): string {
  const meta = document.querySelector<HTMLMetaElement>('[name="csrf-token"]');
  if (meta) {
    return meta.getAttribute('content') || '';
  }

  // Fallback to cookie
  const cookie = document.cookie
    .split('; ')
    .find((row) => row.startsWith('XSRF-TOKEN='));
  return cookie ? cookie.split('=')[1] : '';
}

/**
 * Honeypot field component - add to any form
 * 
 * @example
 * <input type="text" name="hp" className="hidden" tabIndex={-1} autoComplete="off" />
 */
export function HoneypotField() {
  return React.createElement('input', {
    type: 'text',
    name: 'hp',
    tabIndex: -1,
    autoComplete: 'off',
    className: 'absolute left-[9999px] top-auto -z-10 opacity-0 pointer-events-none',
    'aria-hidden': 'true',
    readOnly: true
  });
}

/**
 * Common validation schemas
 */
export const commonSchemas = {
  /** Required string */
  required: (message = 'This field is required') =>
    z.string().min(1, message),

  /** Email */
  email: (message = 'Invalid email address') =>
    z.string().email(message),

  /** Phone (international format) */
  phone: (message = 'Invalid phone number') =>
    z
      .string()
      .regex(/^\+?[1-9]\d{6,14}$/, message),

  /** Name (2-100 chars) */
  name: (message = 'Name must be 2-100 characters') =>
    z.string().min(2, message).max(100, message),

  /** Message (10-5000 chars) */
  message: (message = 'Message must be 10-5000 characters') =>
    z.string().min(10, message).max(5000, message),
};

/**
 * Predefined form configurations
 */
export const formConfigs = {
  contact: {
    route: '/contact',
    method: 'post',
    onSuccess: () => {
      // Toast/success notification
      window.toastr?.success('Mesajınız göndərildi!');
    },
  },
  quote: {
    route: '/contact',
    method: 'post',
    onSuccess: () => {
      window.toastr?.success('Request qəbul edildi!');
    },
  },
  subscribe: {
    route: '/subscribe',
    method: 'post',
    onSuccess: () => {
      window.toastr?.success('Abunəlik təsdiqləndi!');
    },
  },
};

export type UseInertiaFormOptions<T> = {
  route: string;
  method?: 'post' | 'put' | 'patch' | 'delete';
  formOptions?: Partial<UseFormProps<z.infer<T>>>;
  onSubmitStart?: () => void | undefined;
  onSuccess?: () => void | undefined;
  onError?: (errors: Record<string, string>) => void | undefined;
  onFinish?: () => void | undefined;
  onCatch?: (error: Error) => void | undefined;
};