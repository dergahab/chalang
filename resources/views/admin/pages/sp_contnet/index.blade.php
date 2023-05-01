@extends('admin.layouts.main')
@section('heading_title', 'Protfolio ')

@section('heading_buttons')
    @can('users.create')
        <a href="{{route('admin.sp-content.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
    @endcan
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">
           
            <div class="card-body">
                
                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'portfolio',
                    '__datatableId' => 'portfolio',
                ])
            </div>
    </div>
  
</div>
@endsection
@push('js_stack')

@endpush
