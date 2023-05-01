@extends('admin.layouts.main')
@section('heading_title', 'Blog ')
t
@section('heading_buttons')
    @can('users.create')
        <a href="{{route('admin.blog.create')}}" type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
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
                    '__datatableName' => 'blog',
                    '__datatableId' => 'blog',
                ])
            </div>
    </div>
  
</div>
@endsection
@push('js_stack')

@endpush
