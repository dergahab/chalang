@extends('admin.layouts.main')
@section('heading_title', 'Əməkdaşlar')

@section('heading_buttons')
    @can('personal.create')
        <button type="button"  class="btn btn-primary  arrow-none waves-effect waves-light create">
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
                        '__datatableName' => 'personal',
                        '__datatableId' => 'personal',
                    ])
                </div>
            </div>
            <!-- end col -->
            @include('admin.pages.personal.modal')
        </div>
        {{-- @dd($roles) --}}
    @endsection



    @push('js_stack')
        <script>
            $(document).ready(function() {

                $('.create').click(function (e) { 
                    e.preventDefault();
                    $("#personal-modal").modal('toggle');
                });


                $("#save-personal").click(function(e) {
                    e.preventDefault();
                    pageLoader(true);
                    let data = {
                        _token: "{{ csrf_token() }}",
                        name: $("#name").val(),
                        surname: $("#surname").val(),
                        email: $("#email").val(),
                        password: $("#password").val(),
                        position_id: $("#position_id").val(),
                        department_id: $("#department_id").val(),
                        role_id: $("#role_id").val(),
                    }
                    $.post("{{ route('personal.store') }}", data,
                        function(response) {
                            if (response.code == 200) {
                                pageLoader(false);
                                dTReload();
                                $("#create-form").trigger("reset");
                                $("#personal-modal").modal('toggle');
                                console.log(xhr.responseText);
                            }
                        }).fail(function(error) {
                        $.each(error.responseJSON, function(index, value) {
                            toastr.error(value);
                            pageLoader(false);
                        });
                    });
                });

                $(document).on('click', '.edit', function() {
                    let id = $(this).data('id');
                    let url = "{{ route('personal.edit', 'edit') }}"
                    url = url.replace('edit', id);
                    let data = {
                        _token: "{{ csrf_token() }}",
                        id: id
                    };
                    pageLoader(true);
                    $.get(url, function(response) {
                        $('#edit-form').trigger("reset");
                        if (response.code == 200) {
                            $('#edit-form').trigger("reset");
                            $("#edit-name").val(response.data.name);
                            $("#edit-surname").val(response.data.surname);
                            $("#edit-email").val(response.data.email);
                            $("#edit-password").val(response.data.password);
                            $("#edit-id").val(response.data.id);
                            $('#edit-department_id option[value="' + response.data.department_id + '"]')
                                .attr("selected", "selected");
                            $('#edit-position_id option[value="' + response.data.position_id + '"]')
                                .attr("selected", "selected");
                            $('#edit-role_id option[value="' + response.data.roles[0].id + '"]')
                                .attr("selected", "selected");

                            $("#personal-modal-edit").modal('toggle');
                        }
                        pageLoader(false);
                    });
                });

                $("#edit-position").click(function() {
                    let data = $("#edit-form").serialize();

                    let id = $("#edit-id").val();
                    let url = "{{ route('personal.update', 'edit-id') }}"
                    url = url.replace('edit-id', id);
                    pageLoader(true);
                    $.post(url, data,
                        function(response) {
                            if (response.code == 200) {
                                dTReload();
                                $("#create-form").trigger("reset");
                                $("#personal-modal-edit").modal('toggle');
                            }
                            pageLoader(false);
                        });
                })
                //


            });
        </script>
        <script></script>
    @endpush
