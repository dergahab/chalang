<form id="create-form" action="{{ route('admin.company.update',$company->id) }}" method="Post"
    enctype="multipart/form-data">
@method('Put')
    @csrf
    <div class="form-group">
        <label for="name">Şirkət adı1</label>
        <input type="text" name="company" value="{{$company->name}}" id="company-edit" class="form-control" placeholder="Departamnet adı"
            aria-describedby="helpId" required>
    </div>
    <input type="hidden" id="company">
    <div class="form-group">
        <label for="category" class="form-label ">Logo <span class="text-danger">230x133</span></label>
        <input name="file" class="form-control filestyle file" type="file" data-buttonname="btn-secondary">
    </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
        <button type="submit" class="btn btn-success " id="save-departament">Əlavə et</button>
</form>