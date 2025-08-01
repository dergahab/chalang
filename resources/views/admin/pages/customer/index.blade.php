@extends('admin.layouts.main')
@section('heading_buttons')

<button type="button" class="btn btn-primary display-b float-right arrow-none waves-effect waves-light create">
    <i class="fas fa-plus mr-2"></i> Əlavə et
</button>
@endsection


@section('heading_title','Müştəri')
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
                '__datatableName' => 'customer',
                '__datatableId' => 'customer',
                ])
            </div>
        </div>
        <!-- end col -->
        @include('admin.pages.customer.modal')
    </div>
    @endsection


    @push('js_stack')
    <script>
        $(document).ready(function () {

            $('.create').click(function (e) {
                e.preventDefault();
                $("#create-modal").modal('toggle');
            });

            $("#save-customer-type").click(function (e) {
                e.preventDefault();
                pageLoader(true);
                let data = $("#create-form").serialize();
                $.post("{{ route('customer.store') }}", data,
                    function (response) {
                        if (response.code == 200) {
                            dTReload();
                            $("#create-form").trigger("reset");
                            $("#create-modal").modal('toggle');
                        }
                        pageLoader(false);
                    }).fail(function (error) {
                    $.each(error.responseJSON, function (index, value) {
                        toastr.error(value);
                        pageLoader(false);
                    });
                });
            });

            $(document).on('click','.edit',function(){
                let id = $(this).data('id');
                let url = "{{route('customer.edit','edit')}}"
                url = url.replace('edit',id);
                let data = {
                    _token: "{{csrf_token()}}",
                    id: id
                };
                pageLoader(true);
                $.get(url, function (response) {
                    if(response.code == 200){

                        $("#inputs").html(response.view);
                        $("#customer-type-modal-edit").modal('toggle');
                    }
                    pageLoader(false);
                });
            });

            $("#edit-customer-type").click(function(){
                let data = $("#edit-form").serialize();
                let id = $("#edit-id").val();
                let url = "{{route('customer.update','update')}}"
                url = url.replace('update',id);

                pageLoader(true);
                $.post(url, data,
                    function (response) {
                        if(response.code == 200){
                            dTReload();
                            // $("#create-form").trigger("reset");
                            $("#customer-type-modal-edit").modal('toggle');
                        }
                        pageLoader(false);
                    });


            })

        });
    </script>
    @endpush
