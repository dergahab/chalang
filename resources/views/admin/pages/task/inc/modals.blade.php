<div class="modal fade zoomIn task" id="new-task-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="" id="">Yeni Tapşırıq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form id="new-task-form"  enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <input type="hidden" id="tasksId" />
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div>
                                <label for="tasksTitle-field" class="form-label">Başlıq</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Başlıq" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="projectName-field" class="form-label ">Müştəri Seçin</label>
                            <select name="customer_id" id="customer_id" class="form-control select2" multiple>
                                <option value="">Müştəri Seçin</option>
                                @foreach ($customers as $customer)
                                  <option value="{{$customer->id}}">{{$customer->fullname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end col-->
                     
                        <div class="col-lg-12">
                            <label for="projectName-field" class="form-label">Açıqlama</label>
                            <textarea name="description" id="description" cols="30" class="form-control" required placeholder="Açıqlama" rows="5"></textarea>
                        </div>
                        <!--end col-->

                        <!--end col-->
                        <div class="col-lg-12">
                            <label class="form-label">Departament</label>
                            <select class="form-control select-department " >
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}"
                                        data-route="{{ route('department.users', $item->id) }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <!--end col-->

                        <!--end col-->
                        <div class="col-lg-12">
                            <label class="form-label">Təhkim et</label>
                            <select class="form-control task-users  select2 " multiple name="user_id[]">
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="duedate-field" class="form-label">Start tarixi</label>
                            <input type="datetime-local" id="start" name="start" class="form-control"
                                placeholder="Due date" required />
                        </div>
                        <div class="col-lg-6">
                            <label for="duedate-field" class="form-label">Son möhlət</label>
                            <input type="datetime-local" id="deadline" name="deadline" class="form-control"
                                placeholder="Due date" required />
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="priority-field" class="form-label">Vaciblik</label>
                            <select name="priority" class="form-control" id="priority">
                                {{-- <option value="">Vaciblik</option> --}}
                                <option value="1" selected>Yüksək</option>
                                <option value="2">Orta</option>
                                <option value="3">Aşağı</option>
                            </select>
                        </div>
                        <div class="col-ls-12">
                            <label for="priority-field" class="form-label">Fayl </label>
                            <input type="file" id="file" name="file[]" class="form-control" multiple>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">İmtina
                            et</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Əlavə et</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade zoomIn task" id="edit-task-modal"  aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="" id="">Task Düzənlə</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="#" id="edit-task-form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="tasksId" />
                    <div class="row g-3">
                        
                        <!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="tasksTitle-field" class="form-label">Başlıq</label>
                                <input type="text" id="edit-title" name="title" class="form-control"
                                    placeholder="Title" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="projectName-field" class="form-label">Müştəri Seçin</label>
                            <select name="customer_id" id="edit_customer_id" class="form-control select2" multiple>
                                <option value="">Müştəri Seçin</option>
                                @foreach ($customers as $customer)
                                  <option value="{{$customer->id}}">{{$customer->fullname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="projectName-field" class="form-label">Açıqlama</label>
                            <textarea name="description" id="edit-description" cols="30" class="form-control" required
                                placeholder="Açıqlama" rows="5"></textarea>
                        </div>
                        <!--end col-->

                        <!--end col-->
                        <div class="col-lg-12">
                            <label class="form-label">Departament</label>
                            <select class="form-control edit-department ">
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}"
                                        data-route="{{ route('department.users', $item->id) }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <!--end col-->

                        <!--end col-->
                        <div class="col-lg-12">
                            <label class="form-label">Təhkim et</label>
                            <select class="js-example-basic-multiple form-control edit-task-users select2 " 
                                name="update_user_id[]">
                                <option value="">{{ __('İstifadəçi seçin..') }}</option>
                                @foreach ($users as $itema)
                                <option value="{{ $itema->id }}">{{ $itema->full_name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label class="form-label">Start tarixi</label>
                            <input type="datetime-local" name="start" class="form-control edit-start"
                                placeholder="Başlama vaxdı" autocomplete="on" value="01/01/2002" required />
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Son möhlət</label>
                            <input type="datetime-local" id="edit-deadline" name="deadline" class="form-control"
                                autocomplete="off" placeholder="Dedline" required />
                        </div>
                        <div class="col-lg-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status_id" class="form-control" id="edit-status_id">
                                <option value="">Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="priority-field" class="form-label">Vaciblik</label>
                            <select name="priority_id" class="form-control" id="edit-priority">
                                <option value="">Vaciblik</option>
                                <option value="1">Yüksək</option>
                                <option value="2">Orta</option>
                                <option value="3">Aşağı</option>
                            </select>
                        </div>
                        <input type="hidden" id="edit-id" name="id">

                        <div class="col-ls-12">
                            <label for="priority-field" class="form-label">Fayl </label>
                            <input type="file" name="file[]" id="edit-file" class="form-control" multiple>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">İmtina
                            et</button>
                        <button type="button" class="btn btn-success" id="update-btn">Task Düzənlə</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js_stack')
<script>
    var currentModal = '';
    // $('#new-task-modal').modal({
    //     backdrop: 'static',
    //     keyboard: false,

    // });

    $('#new-task-modal').on('shown.bs.modal', function() {
        currentModal = '#new-task-modal';
    });

    $('#edit-task-modal').on('shown.bs.modal', function() {
        currentModal = '#edit-task-modal';
    });



    // $(document).ready(function() {

    //     $(document).on('change', currentModal + ' .select-department', function() {
    //         let route = $('option:selected', this).data('route')
    //         $.ajax({
    //             url: route,
    //             type: 'GET',
    //             success: function(response) {
    //                 var data = JSON.parse(response)
    //                 var html = '';
    //                 data.forEach(element => {
    //                     html += `<option value="` + element.id + `">` + element
    //                         .full_name + `</option>`;
    //                 });
    //                 $('.task-users').html(html)

    //             }
    //         })
    //     })




    // });
</script>

<script>
    $(document).ready(function() {

        $('#edit-task-modal').modal({
        backdrop: 'static',
        keyboard: false
    });

        $('.create').click(function (e) {
                e.preventDefault();
                $("#new-task-modal").modal('toggle');
            });

        $("#add-btn").click(function(e) {
            e.preventDefault();
            //    let data = $("#new-task-form").serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            formData = new FormData();

            var totalfiles = document.getElementById('file').files.length;

            for (var index = 0; index < totalfiles; index++) {
                formData.append("file[]", document.getElementById('file').files[index]);
            }
            let users = []

            // $($('.user_id')).each(function(index, element) {
            //     formData.append("user_id[]", $(element).val());
            // });

            var selectedValues = $("select[name='user_id[]']").val();
            $.each(selectedValues, function(index, value) {
                formData.append("user_id[]", value);
            });


            formData.append("_token", "{{ csrf_token() }}");
            formData.append("project", $("#project").val());
            formData.append("title", $("#title").val());
            formData.append("description", $("#description").val());
            formData.append("start", $("#start").val());
            formData.append("customer_id", $("#customer_id").val());
            formData.append("deadline", $("#deadline").val());
            formData.append("department_id", $(".select-department").val());

            formData.append("priority_id", $("#priority").val());
            pageLoader(true);
            $.ajax({
                enctype: 'multipart/form-data',
                type: "POST",
                url: "{{ route('task.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    dTReload();
                    $("#new-task-form").trigger("reset");
                    $("#new-task-modal").modal('toggle');
                    pageLoader(false);
                },
                error: function(error) {
                    $.each(error.responseJSON, function(index, value) {
                        toastr.error(value);
                    });
                    pageLoader(false);
                }
            });

        });

        $(document).on('click', '.edit', function(e) {
            let id = $(this).data('id');
            let url = "{{ route('task.edit', 'edit') }}"
            url = url.replace('edit', id);
            let data = {
                _token: "{{ csrf_token() }}",
                id: id
            };

            $.get(url, function(response) {
                if (response.code == 200) {
                    $("#edit-project").val(response.data.project);
                    $("#edit-title").val(response.data.title);
                    $("#edit-description").val(response.data.description);

                    $(".edit-start").val(response.data.start);
                    $("#edit-deadline").val(response.data.deadline);

                    $('#edit-priority').val(response.data.priority_id);
                    $('#edit-status_id').val(response.data.status_id);
                    $('#edit_customer_id').val(response.data.customer_id);
                    $('#edit-id').val(response.data.id);
                    $('.select-department').val(response.data.users[0]?.department_id).change();
                    var users = response.data.users;
                    var html = '';
                    users.forEach(element => {
                        html += `<option value="` + element.id + `">` + element
                            .full_name + `</option>`;
                    });
                    // $('.task-users').html(html);

                    $('.edit-task-users').val(response.data.user_ids).change();

                    $("#edit-task-modal").modal('toggle');
                }
            });

        })

        $("#update-btn").click(function(e) {
            e.preventDefault();
            pageLoader(true);
            let id = $("#edit-id").val();
            let url = "{{ route('task.update', 'update') }}"
            url = url.replace('update', id);
            editFormData = new FormData();

            var edittotalfiles = document.getElementById('edit-file').files.length;
            for (var index = 0; index < edittotalfiles; index++) {
                editFormData.append("file[]", document.getElementById('edit-file').files[index]);
            }

            var selectedValues = $("select[name='update_user_id[]']").val();
            $.each(selectedValues, function(index, value) {
                editFormData.append("users_id[]", value);
            });

            editFormData.append("_token", "{{ csrf_token() }}");
            editFormData.append("project", $("#edit-project").val());
            editFormData.append("title", $("#edit-title").val());
            editFormData.append("description", $("#edit-description").val());
            editFormData.append("start", $(".edit-start").val());
            editFormData.append("deadline", $("#edit-deadline").val());
            editFormData.append("customer_id", $("#edit_customer_id").val());
            editFormData.append("priority_id", $("#edit-priority").val());
            editFormData.append("id", $("#edit-id").val());
            editFormData.append("department_id", $(".edit-department").val());
            editFormData.append("_method", $("input[name=_method]").val());
         
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                enctype: 'multipart/form-data',
                type: "POST",
                url: url,
                data: editFormData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    dTReload();
                    $("#edit-task-modal").modal('toggle');
                    pageLoader(false);
                },
                error: function(error) {
                    $.each(error.responseJSON, function(index, value) {
                        toastr.error(value)
                        return false;
                    });
                    pageLoader(false);
                }
            });

        })
    });
</script>

@endpush



<!--end delete modal -->
