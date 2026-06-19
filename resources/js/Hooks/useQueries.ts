import { useQuery } from '@tanstack/react-query';
import axios from 'axios';

interface ApiResponse<T> {
    data: T;
}

const defaultQueryOptions = {
    staleTime: 5 * 60 * 1000, // 5 dəqiqə
    refetchOnWindowFocus: false,
    retry: 1,
    enabled: false, // Inertia datası artıq var, lazımsız auto-fetch dayandırılır
};

export function useServices() {
    return useQuery({
        queryKey: ['services'],
        queryFn: async () => {
            const { data } = await axios.get<ApiResponse<Record<string, unknown>[]>>('/api/services');
            return data.data;
        },
        ...defaultQueryOptions,
    });
}

export function usePortfolio() {
    return useQuery({
        queryKey: ['portfolio'],
        queryFn: async () => {
            const { data } = await axios.get<ApiResponse<Record<string, unknown>[]>>('/api/portfolio');
            return data.data;
        },
        ...defaultQueryOptions,
    });
}

export function useTestimonials() {
    return useQuery({
        queryKey: ['testimonials'],
        queryFn: async () => {
            const { data } = await axios.get<ApiResponse<Record<string, unknown>[]>>('/api/testimonials');
            return data.data;
        },
        ...defaultQueryOptions,
    });
}

export function useBlogPosts() {
    return useQuery({
        queryKey: ['blog'],
        queryFn: async () => {
            const { data } = await axios.get<ApiResponse<Record<string, unknown>[]>>('/api/blog');
            return data.data;
        },
        ...defaultQueryOptions,
    });
}

export function useMetrics() {
    return useQuery({
        queryKey: ['metrics'],
        queryFn: async () => {
            const { data } = await axios.get<ApiResponse<Record<string, unknown>>>(`/api/metrics`);
            return data.data;
        },
        ...defaultQueryOptions,
    });
}
