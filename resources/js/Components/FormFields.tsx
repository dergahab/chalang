import React from 'react';
import { UseFormRegister, FieldErrors } from 'react-hook-form';

/**
 * Form field wrapper with label, input, and error display
 * 
 * @example
 * <FormField label="Name" name="name" register={register} errors={errors} required>
 *   <input {...register('name')} className="form-input" />
 * </FormField>
 */
interface FormFieldProps {
  label: string;
  name: string;
  register: UseFormRegister<any>;
  errors: FieldErrors<any>;
  required?: boolean;
  className?: string;
  children: React.ReactNode;
}

export function FormField({
  label,
  name,
  errors,
  required,
  className = '',
  children,
}: FormFieldProps) {
  const error = errors[name]?.message as string | undefined;
  
  return (
    <div className={`form-field ${className}`}>
      <label htmlFor={name} className="form-label">
        {label}
        {required && <span className="text-red-500 ml-1">*</span>}
      </label>
      
      {children}
      
      {error && (
        <p className="form-error">{error}</p>
      )}
    </div>
  );
}

/**
 * Standalone text input with built-in registration
 * 
 * @example
 * <FormInput
 *   label="Email"
 *   name="email"
 *   register={register}
 *   errors={errors}
 *   type="email"
 *   placeholder="email@example.com"
 * />
 */
interface FormInputProps {
  label: string;
  name: string;
  register: UseFormRegister<any>;
  errors: FieldErrors<any>;
  type?: 'text' | 'email' | 'tel' | 'number' | 'password';
  placeholder?: string;
  required?: boolean;
  disabled?: boolean;
  className?: string;
  autoComplete?: string;
}

export function FormInput({
  label,
  name,
  errors,
  type = 'text',
  placeholder,
  required,
  disabled,
  className = '',
  autoComplete,
  ...inputProps
}: FormInputProps & React.InputHTMLAttributes<HTMLInputElement>) {
  const error = errors[name]?.message as string | undefined;
  
  return (
    <div className={`form-field ${className}`}>
      <label htmlFor={name} className="form-label">
        {label}
        {required && <span className="text-red-500 ml-1">*</span>}
      </label>
      
      <input
        id={name}
        type={type}
        placeholder={placeholder}
        disabled={disabled}
        autoComplete={autoComplete}
        className={`form-input ${error ? 'form-input-error' : ''}`}
        {...inputProps}
      />
      
      {error && (
        <p className="form-error">{error}</p>
      )}
    </div>
  );
}

/**
 * Textarea form field
 * 
 * @example
 * <FormTextarea
 *   label="Message"
 *   name="message"
 *   register={register}
 *   errors={errors}
 *   rows={4}
 * />
 */
interface FormTextareaProps {
  label: string;
  name: string;
  register: UseFormRegister<any>;
  errors: FieldErrors<any>;
  rows?: number;
  placeholder?: string;
  required?: boolean;
  disabled?: boolean;
  className?: string;
}

export function FormTextarea({
  label,
  name,
  errors,
  rows = 4,
  placeholder,
  required,
  disabled,
  className = '',
  ...textareaProps
}: FormTextareaProps & React.TextareaHTMLAttributes<HTMLTextAreaElement>) {
  const error = errors[name]?.message as string | undefined;
  
  return (
    <div className={`form-field ${className}`}>
      <label htmlFor={name} className="form-label">
        {label}
        {required && <span className="text-red-500 ml-1">*</span>}
      </label>
      
      <textarea
        id={name}
        rows={rows}
        placeholder={placeholder}
        disabled={disabled}
        className={`form-textarea ${error ? 'form-input-error' : ''}`}
        {...textareaProps}
      />
      
      {error && (
        <p className="form-error">{error}</p>
      )}
    </div>
  );
}

/**
 * Select dropdown form field
 * 
 * @example
 * <FormSelect
 *   label="Platform"
 *   name="platform"
 *   register={register}
 *   errors={errors}
 *   options={[
 *     { value: 'web', label: 'Web Platform' },
 *     { value: 'mobile', label: 'Mobile App' },
 *   ]}
 * />
 */
interface FormSelectProps {
  label: string;
  name: string;
  register: UseFormRegister<any>;
  errors: FieldErrors<any>;
  options: { value: string; label: string }[];
  required?: boolean;
  disabled?: boolean;
  placeholder?: string;
  className?: string;
}

export function FormSelect({
  label,
  name,
  errors,
  options,
  required,
  disabled,
  placeholder,
  className = '',
  ...selectProps
}: FormSelectProps) {
  const error = errors[name]?.message as string | undefined;
  
  return (
    <div className={`form-field ${className}`}>
      <label htmlFor={name} className="form-label">
        {label}
        {required && <span className="text-red-500 ml-1">*</span>}
      </label>
      
      <select
        id={name}
        disabled={disabled}
        className={`form-select ${error ? 'form-input-error' : ''}`}
        {...selectProps}
      >
        {placeholder && (
          <option value="" disabled>
            {placeholder}
          </option>
        )}
        {options.map((option) => (
          <option key={option.value} value={option.value}>
            {option.label}
          </option>
        ))}
      </select>
      
      {error && (
        <p className="form-error">{error}</p>
      )}
    </div>
  );
}

/**
 * Checkbox form field
 * 
 * @example
 * <FormCheckbox
 *   label="I agree to the terms"
 *   name="terms"
 *   register={register}
 *   errors={errors}
 *   required
 * />
 */
interface FormCheckboxProps {
  label: string;
  name: string;
  register: UseFormRegister<any>;
  errors: FieldErrors<any>;
  required?: boolean;
  className?: string;
}

export function FormCheckbox({
  label,
  name,
  errors,
  required,
  className = '',
}: FormCheckboxProps) {
  const error = errors[name]?.message as string | undefined;
  
  return (
    <div className={`form-field-checkbox ${className}`}>
      <label htmlFor={name} className="flex items-start gap-2 cursor-pointer">
        <input
          id={name}
          type="checkbox"
          className="form-checkbox"
          {...{}}
        />
        <span>
          {label}
          {required && <span className="text-red-500 ml-1">*</span>}
        </span>
      </label>
      
      {error && (
        <p className="form-error ml-6">{error}</p>
      )}
    </div>
  );
}

/**
 * Submit button with loading state
 * 
 * @example
 * <SubmitButton isLoading={isSubmitting}>
 *   Göndər
 * </SubmitButton>
 */
interface SubmitButtonProps {
  isLoading?: boolean;
  disabled?: boolean;
  children: React.ReactNode;
  className?: string;
  variant?: 'primary' | 'secondary';
}

export function SubmitButton({
  isLoading,
  disabled,
  children,
  className = '',
  variant = 'primary',
}: SubmitButtonProps) {
  const baseClasses = 'btn';
  const variantClasses = variant === 'primary' 
    ? 'btn-primary' 
    : 'btn-secondary';
  
  return (
    <button
      type="submit"
      disabled={isLoading || disabled}
      className={`${baseClasses} ${variantClasses} ${className}`}
    >
      {isLoading ? (
        <span className="flex items-center gap-2">
          <svg className="animate-spin h-4 w-4" viewBox="0 0 24 24">
            <circle
              className="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              strokeWidth="4"
              fill="none"
            />
            <path
              className="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            />
          </svg>
          Göndərilir...
        </span>
      ) : (
        children
      )}
    </button>
  );
}

/**
 * Generic error banner for form-level errors
 */
interface FormErrorBannerProps {
  error?: string;
  className?: string;
}

export function FormErrorBanner({ error, className = '' }: FormErrorBannerProps) {
  if (!error) return null;
  
  return (
    <div className={`form-error-banner ${className}`}>
      <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
        <path
          fillRule="evenodd"
          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
          clipRule="evenodd"
        />
      </svg>
      <span>{error}</span>
    </div>
  );
}

/**
 * Generic success message banner
 */
interface FormSuccessBannerProps {
  message?: string;
  className?: string;
}

export function FormSuccessBanner({ message, className = '' }: FormSuccessBannerProps) {
  if (!message) return null;
  
  return (
    <div className={`form-success-banner ${className}`}>
      <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
        <path
          fillRule="evenodd"
          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
          clipRule="evenodd"
        />
      </svg>
      <span>{message}</span>
    </div>
  );
}