@extends('admin.layouts.main')
@section('heading_title', 'Analytics')

@section('content')
<div class="row gy-4">
    <div class="col-lg-8">
        <div class="card glass-card">
            <div class="card-header border-0">
                <h4 class="card-title mb-0">Analytics & Tracking</h4>
                <p class="text-muted mb-0">Google, Meta, Yandex kodlar�n� buradan idar� edin.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.analytics.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">GA4 Measurement ID</label>
                        <input type="text" name="ga4_measurement_id" class="form-control" placeholder="G-XXXXXXXXXX"
                            value="{{ old('ga4_measurement_id', $ga4_measurement_id) }}">
                        <small class="text-muted">N�mun�: G-1234567890</small>
                        @error('ga4_measurement_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Google Search Console meta</label>
                        <input type="text" name="search_console_meta" class="form-control"
                            placeholder="google-site-verification=..."
                            value="{{ old('search_console_meta', $search_console_meta) }}">
                        <small class="text-muted">Sad�c� content d�y�rini daxil edin.</small>
                        @error('search_console_meta')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Meta Pixel ID</label>
                        <input type="text" name="meta_pixel_id" class="form-control" placeholder="1234567890"
                            value="{{ old('meta_pixel_id', $meta_pixel_id) }}">
                        @error('meta_pixel_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Yandex Metrica ID</label>
                        <input type="text" name="yandex_metrica_id" class="form-control" placeholder="12345678"
                            value="{{ old('yandex_metrica_id', $yandex_metrica_id) }}">
                        @error('yandex_metrica_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Yadda saxla</button>
                        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">L�v� et</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card glass-card h-100">
            <div class="card-header border-0">
                <h5 class="card-title mb-0">Tez n�z�r</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>GA4 �nvan�: gtag.js auto y�kl�n�r.</li>
                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Search Console meta etiketi head hiss�sind�dir.</li>
                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Meta Pixel script + noscript d�st�yi.</li>
                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Yandex Metrica kodu avtomatik �al���r.</li>
                </ul>
                <p class="text-muted small mb-0">D�y��iklikl�r public sayt�n b�t�n əsas layoutlar�na avtomatik tətbiq olunur.</p>
            </div>
        </div>
    </div>
</div>
@endsection
