@extends('admin.layouts.main')

@section('heading_title', 'Analitika Tənzimləmələri')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">İzləmə Kodları (Tracking Codes)</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.analytics.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="ga4_measurement_id" class="form-label">Google Analytics 4 (GA4) ID</label>
                        <input type="text" class="form-control" id="ga4_measurement_id" name="ga4_measurement_id" value="{{ $settings['ga4_measurement_id'] ?? '' }}" placeholder="G-XXXXXXXXXX">
                        <div class="form-text">Google Analytics ölçmə ID-nizi daxil edin.</div>
                    </div>

                    <div class="mb-3">
                        <label for="meta_pixel_id" class="form-label">Facebook Pixel ID</label>
                        <input type="text" class="form-control" id="meta_pixel_id" name="meta_pixel_id" value="{{ $settings['meta_pixel_id'] ?? '' }}" placeholder="XXXXXXXXXXXXXXX">
                        <div class="form-text">Facebook Pixel ID-nizi daxil edin.</div>
                    </div>

                    <div class="mb-3">
                        <label for="yandex_metrica_id" class="form-label">Yandex Metrica ID</label>
                        <input type="text" class="form-control" id="yandex_metrica_id" name="yandex_metrica_id" value="{{ $settings['yandex_metrica_id'] ?? '' }}" placeholder="XXXXXXXX">
                        <div class="form-text">Yandex Metrica sayğac ID-nizi daxil edin.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Yadda saxla</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
