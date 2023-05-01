@extends('admin.layouts.main')
@section('heading_title', 'Departament')

@section('heading_buttons')
    @can('users.create')
        <button type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </button>
    @endcan
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
{{-- 
        {{ Breadcrumbs::render('user') }} --}}
    </div>
    <div class="col-lg-12">
        <div class="card">
           
            <div class="card-body">
                
                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'company',
                    '__datatableId' => 'company',
                ])
            </div>
    </div>
    <!-- end col -->
    @include('admin.pages.company.modal')
</div>
@endsection
@push('js_stack')
    <script>
        $(document).ready(function () {
            $(".create").click(function (e) { 
                $("#company-modal").modal('toggle');
            });
           $(document).on('click',' .edit',function(){
               $.get($(this).data('route'),
                function (res) {
                  $('#edit-body').html(res.view)
                  $("#company-modal-edit").modal('toggle');
                });
            });
        });
    </script>
@endpush
