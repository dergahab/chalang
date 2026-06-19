import { create } from 'zustand';

export type ToastType = 'success' | 'error' | 'info';

export interface Toast {
    id: string;
    message: string;
    type: ToastType;
    duration: number;
}

interface ToastState {
    toasts: Toast[];
    addToast: (message: string, type?: ToastType, duration?: number) => void;
    removeToast: (id: string) => void;
}

let toastCounter = 0;

export const useToastStore = create<ToastState>()((set) => ({
    toasts: [],
    addToast: (message, type = 'info', duration = 4000) => {
        const id = `toast-${++toastCounter}`;
        set((state) => ({ toasts: [...state.toasts, { id, message, type, duration }] }));
        setTimeout(() => {
            set((state) => ({ toasts: state.toasts.filter((t) => t.id !== id) }));
        }, duration);
    },
    removeToast: (id) => set((state) => ({ toasts: state.toasts.filter((t) => t.id !== id) })),
}));
