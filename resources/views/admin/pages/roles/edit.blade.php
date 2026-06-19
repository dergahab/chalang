@extends('admin.layouts.main')

@section('heading_title', 'Rolu Düzəlt: ' . $item->title)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card glass-card">
                <div class="card-body">
                    <form action="{{ route('role.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.roles.__form')
                        <div class="mt-4 d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                <i class="ri-save-line align-middle me-1"></i> Yenilə
                            </button>
                            
                            <a href="{{ route('admin.activity-log.index', ['subject_type' => 'Spatie\Permission\Models\Role', 'subject_id' => $item->id]) }}" 
                               class="btn btn-info waves-effect waves-light" target="_blank">
                                <i class="ri-history-line align-middle me-1"></i> Tarixçə
                            </a>

                            <a href="{{ route('role.index') }}" class="btn btn-soft-secondary waves-effect">
                                <i class="ri-arrow-left-line align-middle me-1"></i> Geri
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
