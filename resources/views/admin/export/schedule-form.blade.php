@extends('admin.layouts.main')

@section('heading_title', isset($schedule) ? 'Cədvəli Redaktə Et' : 'Yeni Eksport Cədvəli')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card glass-card border-0 shadow-lg">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="ri-calendar-todo-line me-2 text-primary"></i> 
                    Cədvəl Parametrləri
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($schedule) ? route('admin.export.schedules.update', $schedule->id) : route('admin.export.schedules.store') }}" method="POST">
                    @csrf
                    @if(isset($schedule))
                        @method('PUT')
                    @endif

                    <div class="row g-4">
                        <!-- Model Selection -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted mb-2">MODEL TÜRÜ</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <span class="input-group-text bg-white border-end-0"><i class="ri-database-2-line text-primary"></i></span>
                                <select name="model_type" class="form-select border-start-0 ps-0 shadow-none" required>
                                    <option value="">Model seçin...</option>
                                    @foreach($models as $model)
                                    <option value="{{ $model }}" {{ (isset($schedule) && $schedule->model_type == $model) ? 'selected' : '' }}>{{ $model }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('model_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Format Selection -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted mb-2">EKSPORT FORMATI</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <span class="input-group-text bg-white border-end-0"><i class="ri-file-code-line text-warning"></i></span>
                                <select name="format" class="form-select border-start-0 ps-0 shadow-none" required>
                                    <option value="csv" {{ (isset($schedule) && $schedule->format == 'csv') ? 'selected' : '' }}>CSV (Standard)</option>
                                    <option value="xlsx" {{ (isset($schedule) && $schedule->format == 'xlsx') ? 'selected' : '' }}>Excel (.xlsx)</option>
                                    <option value="json" {{ (isset($schedule) && $schedule->format == 'json') ? 'selected' : '' }}>JSON Data</option>
                                </select>
                            </div>
                        </div>

                        <!-- Frequency Selection -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted mb-2">AVTOMATİK TEZLİK</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <span class="input-group-text bg-white border-end-0"><i class="ri-time-line text-success"></i></span>
                                <select name="frequency" class="form-select border-start-0 ps-0 shadow-none" required>
                                    <option value="daily" {{ (isset($schedule) && $schedule->frequency == 'daily') ? 'selected' : '' }}>Hər Gün (Gecə saat 00:00)</option>
                                    <option value="weekly" {{ (isset($schedule) && $schedule->frequency == 'weekly') ? 'selected' : '' }}>Həftəlik (Bazar ertəsi)</option>
                                    <option value="monthly" {{ (isset($schedule) && $schedule->frequency == 'monthly') ? 'selected' : '' }}>Aylıq (Hər ayın 1-i)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Email Notification -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted mb-2">BİLDİRİŞ EMAİL-İ (Optional)</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <span class="input-group-text bg-white border-end-0"><i class="ri-mail-send-line text-info"></i></span>
                                <input type="email" name="email_to" class="form-control border-start-0 ps-0 shadow-none" value="{{ $schedule->email_to ?? '' }}" placeholder="misal@domain.com">
                            </div>
                            <div class="form-text small">Eksport bitdikdə fayl linki bu ünvana göndəriləcək.</div>
                        </div>

                        <!-- Filters (JSON) -->
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted mb-2">FİLTRLƏR (JSON FORMAT)</label>
                            <textarea name="filters" class="form-control shadow-none" rows="3" style="border-radius: 12px; font-family: monospace; font-size: 13px;" placeholder='{"status": "active", "category_id": 5}'>{{ isset($schedule) && $schedule->filters ? json_encode($schedule->filters, JSON_PRETTY_PRINT) : '' }}</textarea>
                            <div class="form-text small">Eksport zamanı tətbiq olunacaq filterlər. Boş saxlasanız bütün data çıxarılacaq.</div>
                        </div>

                        <!-- Status Toggle -->
                        <div class="col-12">
                            <div class="form-check form-switch custom-switch p-0 d-flex align-items-center">
                                <label class="form-check-label fw-bold text-muted small me-3 mb-0" for="is_active">CƏDVƏLİ AKTİV ET</label>
                                <input class="form-check-input ms-0 shadow-none" type="checkbox" name="is_active" id="is_active" style="width: 45px; height: 22px;" {{ (!isset($schedule) || $schedule->is_active) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-12 mt-5 border-top pt-4 text-end">
                            <a href="{{ route('admin.export.schedules') }}" class="btn btn-light px-4 me-2" style="border-radius: 12px;">İmtina</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-lg shadow-primary/20" style="border-radius: 12px; background: linear-gradient(135deg, #4b0082, #d500f9); border: none; font-weight: 600;">
                                <i class="ri-save-line me-1"></i> {{ isset($schedule) ? 'Dəyişiklikləri Saxla' : 'Cədvəli Yarat' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css_stack')
<style>
.glass-card {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 16px;
}
.form-check-input:checked {
    background-color: #22c55e;
    border-color: #22c55e;
}
.input-group-text {
    border-color: rgba(0,0,0,0.05);
}
.form-control, .form-select {
    border-color: rgba(0,0,0,0.05);
    height: 48px;
}
</style>
@endpush