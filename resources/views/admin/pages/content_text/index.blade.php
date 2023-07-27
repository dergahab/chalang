@extends('admin.layouts.main')

@section('heading_title', 'Statik tekst')

@section('heading_buttons')
    @can('category.create')
        <a href="{{ route('admin.content-text.create') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
            <i class="fas fa-plus mr-2"></i> <i class="fas fa-car"></i>
            Əlavə et
        </a>
    @endcan
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Statik tekst List</h4>
                    @include('admin.inc.dynamic_datatable', ['__datatableName' => 'text', '__datatableId' => 'datatable-content-text'])
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection
