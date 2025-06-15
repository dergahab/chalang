@extends('admin.layouts.main')
@section('heading_title', 'Blog kategoriya')

@section('heading_buttons')
        <button type="button"  class="btn btn-primary float-right arrow-none waves-effect waves-light create">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </button>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                @include('admin.inc.dynamic_datatable', [
                    '__datatableName' => 'bcategory',
                    '__datatableId' => 'bcategory',
                ])
            </div>
    </div>
    <!-- end col -->
    @include('admin.pages.bcategory.modal')
</div>
@endsection
@push('js_stack')
    <script>
        $(document).ready(function () {
            $(".create").click(function (e) {
                $("#company-modal").modal('toggle');
            });

            $("#save").click(function (e) {
            e.preventDefault();
            let data = $('#saveForm').serialize();
            $.post("{{route('admin.bcategory.store')}}", data,
                function (response) {
                    dTReload()
                    $("#company-modal").modal('toggle');
                    $('#saveForm').trigger("reset");
                });
           });

           $(document).on('click',' .edit',function(){
               $.get($(this).data('route'),
                function (res) {
                if(res.code == 200){
                    $('#edit-body').html(res.view)
                    $("#modal-edit").modal('toggle');
                }
                });
            });
        });
    </script>
@endpush
