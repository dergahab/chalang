@extends('admin.layouts.main')
@section('heading_title', 'Sosial Media')

@section('heading_buttons')
    @can('users.create')
        <a type="button" href="{{route('admin.social-media.create')}}"  class="btn btn-primary float-right arrow-none waves-effect waves-light ">
            <i class="fas fa-plus mr-2"></i> Əlavə et
        </a>
    @endcan
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12">
        <div class="card">
           
            <div class="card-body">
                
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Adı</th>
                        <th scope="col">icon</th>
                        <th scope="col">Status</th>
                        <th scope="col">Əməliyyat</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->name}}</td>
                            <td><i class="{{$item->icon}}"></i></td>
                            <td>#</td>
                            <td>@include('admin.pages.social-media.table_actions')</td>
                          </tr>
                        @endforeach                
                    </tbody>
                  </table>
            </div>
    </div>
    <!-- end col -->
    @include('admin.pages.pcategory.modal')
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
            $.post("{{route('admin.pcategory.store')}}", data,
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
