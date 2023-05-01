<div class="modal fade" id="personal-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yeni İşçi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form">
                    <div class="row">
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label for="department_id">Depatatament</label>
                                <select name="department_id" id="department_id" class=" form-control" required>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label for="position_id">Vəzifə</label>
                                <select name="position_id" id="position_id" class="  form-control" required>
                                    @foreach($postions as $postion)
                                        <option value="{{ $postion->id }}">{{ $postion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label for="department_id">İcazə</label>
                                <select name="role_id" id="role_id" class=" form-control" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="name">Adı</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Adı"
                                    aria-describedby="helpId" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="sername">Soyadı</label>
                                <input type="text" id="surname" name="surname" class="form-control" placeholder="Soyadı"
                                    aria-describedby="helpId" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                                    aria-describedby="helpId" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="password">Şifrə</label>
                                <input type="text" id="password" name="password" class="form-control"
                                    placeholder="Şifrə" aria-describedby="helpId" required>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
                <button type="button" class="btn btn-success " id="save-personal">Əlavə et</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="personal-modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vəzifə düzəliş</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label for="department_id">Depatatament</label>
                                <select name="department_id" id="edit-department_id" class=" form-control" required>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label for="position_id">Vəzifə</label>
                                <select name="position_id" id="edit-position_id" class="  form-control" required>
                                    @foreach($postions as $postion)
                                        <option value="{{ $postion->id }}">{{ $postion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label for="department_id">İcazə</label>
                                <select name="role_id" id="edit-role_id" class=" form-control" required>
                                    
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="name">Adı</label>
                                <input type="text" name="name" id="edit-name" class="form-control" placeholder="Adı"
                                    aria-describedby="helpId" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="sername">Soyadı</label>
                                <input type="text" id="edit-surname" name="surname" class="form-control" placeholder="Soyadı"
                                    aria-describedby="helpId" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="edit-email" class="form-control" placeholder="Email"
                                    aria-describedby="helpId" required>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                <label for="password">Şifrə</label>
                                <input type="text" id="edit-password" name="password" class="form-control"
                                    placeholder="Şifrə" aria-describedby="helpId" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="edit-id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
                <button type="button" class="btn btn-success" id="edit-position">Düzəliş et</button>
            </div>
        </div>
    </div>
</div>